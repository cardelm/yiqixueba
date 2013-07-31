document.ready(function(){
    var d = document;
    var $input = d.getElementById('AddOrderNumber');
    var $inputTip = d.getElementById('NumberTip');
    var $inputLeft = d.getElementById('NumberLeftBtn');
    var $inputRight = d.getElementById('NumberRightBtn');
    var $total = d.getElementById('AddOrderTotal');
    var $btnBack = d.getElementById('BtnBack');
    var $btnOrder = d.getElementById('BtnOrder');
    var number = $input.getAttribute('value') != '' ? parseInt($input.getAttribute('value')) : 0;
    var price = parseInt($total.getAttribute('price'));
    var total = price * number / 100;
    $total.innerText = '￥'+total;

	
    function changeInput()
    {
        var num = parseInt($input.value);
        var max = parseInt($input.getAttribute('nummax'));
        var min = parseInt($input.getAttribute('nummin'));
        var price = parseInt($total.getAttribute('price'));
        if (isNaN(num) || num < min) {
            num = min;
            $inputTip.innerHTML = '最少'+min+'份';
        }
        else if (num > max) {
            num = max;
            $inputTip.innerHTML = '最多'+max+'份';
        }
        else {
            $inputTip.innerHTML = '';
        }
        changeLinkClass(num,min,max);
        var total = price * num / 100;
        $input.value = num;
        $total.innerText = '￥'+total;
    }
    $input.addEventListener('focus', changeInput);
    $input.addEventListener('blur', changeInput);

    function changeLinkClass(num,min,max)
    {
        if (num == min) {
            $inputLeft.setAttribute('class', 'No_t');
            //$inputTip.innerHTML = '最少'+min+'份';
        }
        else {
            $inputLeft.removeAttribute('class');
        }
        if (num == max) {
            $inputRight.setAttribute('class', 'No_t');
            //$inputTip.innerHTML = '最多'+max+'份';
        }
        else {
            $inputRight.removeAttribute('class');
        }
        if (num > min && num < max) {
            $inputTip.innerHTML = '';
        }
    }
    function changeClass()
    {
        var type = this.innerText;
        var num = parseInt($input.value);
        var max = parseInt($input.getAttribute('nummax'));
        var min = parseInt($input.getAttribute('nummin'));
        var price = parseInt($total.getAttribute('price'));
        if (type == '+') {
            if (num < max) num = num + 1;
        }
        else {
            if (num > min) num = num - 1;
        }
        changeLinkClass(num,min,max);
        var total = price * num / 100;
        $input.value = num;
        $total.innerText = '￥'+total;
    }
    $inputLeft.addEventListener('click', changeClass);
    $inputRight.addEventListener('click', changeClass);

    window.btnClick = false;
    $btnBack.addEventListener('click', function(){
        history.back();
    });
    $btnOrder.addEventListener('click', function(){
        var url = this.getAttribute('url');
        //判断数据是否完整
        var buyCount = parseInt($input.value);
        var max = parseInt($input.getAttribute('nummax'));
        var min = parseInt($input.getAttribute('nummin'));
        if (buyCount > max) {
            alert('最多购买' + max + '份');
            $input.value = max;
            return false;
        }
        else if (buyCount < min) {
            alert('最少购买'+min+'份');
            $input.value = min;
            return false;
        }
        var reg = /^1\d{10}$/;

        if (window.btnClick) {
            return false;
        }
        window.btnClick = true;
        d.getElementById('loadingBox').style.display = 'block';
        var url = url + '&buyCount=' + buyCount + '&mobile=&r=' + Math.random();
        location.href=url;
    });

});
