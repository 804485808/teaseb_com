// JavaScript Document
function initMenuEvent(objId){
	var hot_last = document.getElementById(objId).getElementsByTagName('b');
	var more = hot_last[0].className=='hot_last_more'?hot_last[0]:hot_last[1];
	var less = hot_last[0].className=='hot_last_less'?hot_last[0]:hot_last[1];
	for(var i=0; i<hot_last.length; i++){
		hot_last[i].onclick = function(){
			var hot_last_div = document.getElementById(objId).getElementsByTagName('span')[0];
			if(hot_last_div.style.display == 'none'){
				hot_last_div.style.display="block";
				more.style.display="none";
			}
			else{
				hot_last_div.style.display="none";
				more.style.display="block";
			}
		}
	}
}

