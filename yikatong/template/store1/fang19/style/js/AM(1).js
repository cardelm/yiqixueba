/*
 *@Description: AM.js
 *@Version:     v1.0
 *@Author:      GaoLi
 
 * Includes Do.js
 * http://kejun.github.com/Do/
 * Copyright 2011, douban
 * Released under the MIT, BSD, and GPL Licenses.
 */

(function() {

var _doc = document,

_win = window,

_baseVersion = AM_Config.baseVersion || "",

_loaded = {},

_loadingQueue = {},

_isArray = function(e) { return e.constructor === Array; },

_config = {
	autoLoad: true,
	
	coreLib: [AM_Config.baseUrl+'/jquery.js',AM_Config.baseUrl+'/App.component.js'],
	
	mods: {}
},

_jsFiles = _doc.getElementsByTagName('script'),

_jsSelf = _jsFiles[_jsFiles.length - 1],

_jsConfig,

_AM,

_readyList = [],

_isReady = false,

_globalList = [],

_load = function(url, type, charset, cb, context) {
	var refFile = _jsFiles[0];

	if (!url) {
		return;
	}
	
	if (_loaded[url]) {
		_loadingQueue[url] = false;
		if (cb) {
			cb(url, context);
		}
		return;
	}
	
	if (_loadingQueue[url]) {
		setTimeout(function() {
			_load(url, type, charset, cb, context);
		}, 1);
		return;
	}

	_loadingQueue[url] = true;

	var n, t = type || url.toLowerCase().substring(url.lastIndexOf('.js') + 1);

	t = t.replace(AM_Config.baseVersion,"");

	if (t === "js") {
		n = _doc.createElement('script');
		n.setAttribute('type', 'text/javascript');
		n.setAttribute('src', url);
		n.setAttribute('async', true);
	} else if (t === 'css') {
		n = _doc.createElement('link');
		n.setAttribute('type', 'text/css');
		n.setAttribute('rel', 'stylesheet');
		n.setAttribute('href', url);
		_loaded[url] = true;
	}

	if (charset) {
		n.charset = charset;
	}
	
	if (t === 'css') {
		refFile.parentNode.insertBefore(n, refFile);
		if (cb) {
			cb(url, context);
		}
		return;
	}

	n.onload = n.onreadystatechange = function() {
		if (!this.readyState || this.readyState === 'loaded' || this.readyState === 'complete') {
			
			_loaded[this.getAttribute('src')] = true;

			if (cb) {
				cb(this.getAttribute('src'), context);
			}

			n.onload = n.onreadystatechange = null;
		}
	};

	refFile.parentNode.insertBefore(n, refFile);
},

_calculate = function(e) {
	if (!e || !_isArray(e)) {
		return;
	}

	var i = 0,
	item,
	result = [],
	mods = _config.mods,
	depeList = [],
	hasAdded = {},
	getDepeList = function(e) {
		var i = 0, m, reqs;
		
		if (hasAdded[e]) {
			return depeList;
		}
		hasAdded[e] = true;

		if (mods[e].requires) {
			reqs = mods[e].requires;
			for (; typeof (m = reqs[i++]) !== 'undefined';) {
				if (mods[m]) {
					getDepeList(m);
					depeList.push(m);
				} else {
					depeList.push(m);
				}
			}
			return depeList;
		}
		return depeList;
	};

	for (; typeof (item = e[i++]) !== 'undefined'; ) {
		if (mods[item] && mods[item].requires && mods[item].requires[0]) {
			depeList = [];
			hasAdded = {};
			result = result.concat(getDepeList(item));
		}
		result.push(item);
	}

	return result;
},

_ready = function() {
  _isReady = true;
  if (_readyList.length > 0) {
    _AM.apply(this, _readyList);
    _readyList = [];
  }
},

_onDOMContentLoaded = function() {
	if (_doc.addEventListener) {
		_doc.removeEventListener('DOMContentLoaded', _onDOMContentLoaded, false);
	} else if (_doc.attachEvent) {
		_doc.detachEvent('onreadystatechange', _onDOMContentLoaded);
	}
	_ready();
},

_doScrollCheck = function() {
	if (_isReady) {
		return;
	}

	try {
		_doc.documentElement.doScroll('left');
	} catch (err) {
		return _win.setTimeout(_doScrollCheck, 1);
	}

	_ready();
},

_bindReady = function() {
	if (_doc.readyState === 'complete') {
		return _win.setTimeout(_ready, 1);
	}

	var toplevel = false;

	if (_doc.addEventListener) {
		_doc.addEventListener('DOMContentLoaded', _onDOMContentLoaded, false);
		_win.addEventListener('load', _ready, false);
	} else if (_doc.attachEvent) {
		_doc.attachEvent('onreadystatechange', _onDOMContentLoaded);
		_win.attachEvent('onload', _ready);

		try {
			toplevel = (_win.frameElement === null);
		} catch (err) {}

		if (document.documentElement.doScroll && toplevel) {
			_doScrollCheck();
		}
	}
},

_Queue = function(e) {
	if (!e || !_isArray(e)) {
		return;
	}

	this.queue = e;
	
	this.current = null;
};

_Queue.prototype = {

	_interval: 10,

	start: function() {
		var o = this;
		this.current = this.next();

		if (!this.current) {
			this.end = true;
			return;
		}

		this.run();
	},

	run: function() {
		var o = this, mod, currentMod = this.current;

		if (typeof currentMod === 'function') {
			currentMod();
			this.start();
			return;
		} else if (typeof currentMod === 'string') {
			if (_config.mods[currentMod]) {
				mod = _config.mods[currentMod];
				_load(mod.path, mod.type, mod.charset, function(e) {
					o.start();
				}, o);
			} else if (/\.js/i.test(currentMod)) {
				_load(currentMod + _baseVersion, 'js', '', function(e, o) {
					o.start();
				}, o);
			} else if (/\.css/i.test(currentMod)) {
				_load(currentMod + _baseVersion, 'css', '', function(e, o) {
					o.start();
				}, o);
			} else {
				this.start();
		   }
		}
	},

	next: function() { return this.queue.shift(); }
};

_jsConfig = _jsSelf.getAttribute('data-cfg-autoload');
if (typeof _jsConfig === 'string') {
	_config.autoLoad = (_jsConfig.toLowerCase() === 'true') ? true : false;
}

_jsConfig = _jsSelf.getAttribute('data-cfg-corelib');
if (typeof _jsConfig === 'string') {
	_config.coreLib = _jsConfig.split(',');
}

_AM = function() {
	var args = [].slice.call(arguments), thread;
	if (_globalList.length > 0) {
		args = _globalList.concat(args);
	}

	if (_config.autoLoad) {
		args = _config.coreLib.concat(args);
	}

	thread = new _Queue(_calculate(args));
	thread.start();
};

_AM.add = function(sName, oConfig) {
	if (!sName || !oConfig || !oConfig.path) {
		return;
	}
	_config.mods[sName] = oConfig;
};

_AM.delay = function() {
	var args = [].slice.call(arguments), delay = args.shift();
	_win.setTimeout(function() {
		_AM.apply(this, args);
	}, delay);
};

_AM.global = function() {
	var args = [].slice.call(arguments);
	_globalList = _globalList.concat(args);
};

_AM.ready = function() {
	var args = [].slice.call(arguments);
	if (_isReady) {
		return _AM.apply(this, args);
	}
	_readyList = _readyList.concat(args);
};

_AM.css = function(str) {
	var css = _doc.getElementById('do-inline-css');
	if (!css) {
		css = _doc.createElement('style');
		css.type = 'text/css';
		css.id = 'do-inline-css';
		_doc.getElementsByTagName('head')[0].appendChild(css);
	}

	if (css.styleSheet) {
		css.styleSheet.cssText = css.styleSheet.cssText + str;
	} else {
		css.appendChild(_doc.createTextNode(str));
	}
};

if (_config.autoLoad) {
	_AM(_config.coreLib);
}

this.AM = _AM;

_bindReady();

})();