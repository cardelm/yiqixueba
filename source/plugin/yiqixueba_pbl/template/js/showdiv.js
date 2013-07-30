function showDiv(divID) 
{
    if (divID != null && divID != "") {
        var v = document.getElementById(divID);
        if (v.style.display == "none")
		{
            v.style.display = "inline";
        }
    }
}

function hiddenDiv(divID) 
{
    if (divID != null && divID != "") 
	{
        var vv = document.getElementById(divID);
        if (vv.style.display == "inline") 
		{
            vv.style.display = "none";
        }
    }
}

function recadd(tid) {
	$('recommend_add_'+tid).innerHTML=parseInt($('recommend_add_'+tid).innerHTML)+1;
}
function recsubtract(tid) {
	$('recommend_subtract_'+tid).innerHTML=parseInt($('recommend_subtract_'+tid).innerHTML)+1;
}