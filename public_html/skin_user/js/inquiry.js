document.domain = "motors-biz.com";
$(document).ready(function(){MultiSelect.Init();});$(document).keyup(function(){if(getEvent().keyCode==27){GetInquiry.CloseBox();$("#show").stop();}});$(window).scroll(function(){var showBox=$("#show");if(showBox.css("display")=="block"){showBox.css("top",(($(window).height()-parseInt(showBox.css("height")))/2+$(window).scrollTop())+"px");}});function getEvent(){return window.event||arguments.callee.caller.arguments[0];}
var MultiSelect={SpidCount:0,TigDiv:"#batInquiry",TigP:"#tig",Init:function(){if($.cookie(MultiSelect.CookieName())!=null){var ids=($.cookie(MultiSelect.CookieName())||"");$("input[name='SPId']").each(function(){if(ids.indexOf(this.value+",")>=0){this.checked=true;}});}
MultiSelect.CkClick();$(".itemBox ul,.promotion ul,.mainleft .itemBox,.mainleft .itemBox1,#divlistpro table,#frm .productA").bind("dblclick",function(){var caller=getEvent().target||getEvent().srcElement;if($(caller).attr("name")!="SPId"){var ck=$(this).find("input");if(ck.attr("checked")==true){ck.removeAttr("checked");MultiSelect.DelSelected(ck);}
else{ck.attr("checked","true");MultiSelect.AddSelected(ck);}}});},CkClick:function(){$("input[name='SPId']").bind("click",function(){if(this.checked){MultiSelect.AddSelected(this);}
else{MultiSelect.DelSelected(this);}});},DocClick:function(caller){if($(caller).attr("id")=="iqBgbox"){GetInquiry.CloseBox();}},AddSelected:function(inputObj){if(MultiSelect.SpidCount>=20){MultiSelect.ShowTig(inputObj,"Select <strong>"+MultiSelect.SpidCount+"</strong> product(s) at most ,<a href='javascript:void(0);' onclick='MultiSelect.ClearCookie();'>Reselect?</a>");$(inputObj).attr("checked","false");return;}
var ids=$.cookie(MultiSelect.CookieName())==null?"":$.cookie(MultiSelect.CookieName());var id=$(inputObj).val();if(ids!=null){if(ids.indexOf(id+",")<0){ids+=id+",";$.cookie(MultiSelect.CookieName(),ids,{expires:7});}
MultiSelect.SpidCount=ids.substring(0,ids.length-1).split(",").length;}
if(MultiSelect.SpidCount>0){MultiSelect.ShowTig(inputObj,"You have selected<strong>"+MultiSelect.SpidCount+"</strong>product(s), <a href='javascript:void(0);' onclick='MultiSelect.ClearCookie();'>Reselect?</a>");}},DelSelected:function(inputObj){var ids=$.cookie(MultiSelect.CookieName())||"";var id=$(inputObj).val();if(ids!=null){if(ids.indexOf(id+",")>=0){ids=ids.replace(id+",","");$.cookie(MultiSelect.CookieName(),ids,{expires:7});}
MultiSelect.SpidCount=ids.substring(0,ids.length-1).split(",").length;ids=ids.substring(0,ids.length-1);var lastid=ids.substring(ids.lastIndexOf(",")+1);if(lastid!=null&&lastid!=""&&MultiSelect.SpidCount>1){var lastCk=$("input[value='"+lastid+"']");if(lastCk.size()>0){MultiSelect.ShowTig(lastCk,"You have selected<strong>"+MultiSelect.SpidCount+"</strong>product(s), <a href='javascript:void(0);' onclick='MultiSelect.ClearCookie();'>Reselect?</a>");}
else{MultiSelect.CloseTig();}}
else{MultiSelect.CloseTig();}}},AddByID:function(id){var ck=$("input[value='"+id+"']");if(ck.size()==0)ck=$("input[value='"+id+"-p']");if(ck.size()==0)ck=$("input[value='"+id+"-c']");if(ck.size()>0){ck.attr("checked",true);MultiSelect.AddSelected(ck);return true;}
else{return false;}},ShowTig:function(inputObj,tigmsg){$(MultiSelect.TigP).html(tigmsg);var top=$(inputObj).offset().top;var left=$(inputObj).offset().left;$(MultiSelect.TigDiv).css({"display":"block","left":left-7,"top":top-67,"z-index":9999});},CloseTig:function(){$(MultiSelect.TigDiv).css("display","none");},ClearCookie:function(){$.cookie(MultiSelect.CookieName(),"");$("input[name='SPId']").each(function(){if(this.checked==true){this.checked=false;}});MultiSelect.SpidCount=0;MultiSelect.CloseTig();return false;},AllSelect:function(value){$("input[name='SPId']").each(function(){this.checked=value;if(value){MultiSelect.AddSelected(this);}
else{MultiSelect.DelSelected(this);}});},CookieName:function(){var parten="/(ic|chemicals)/";var reg=new RegExp(parten);if(reg.test(window.location.href)){var p=window.location.href.substring(window.location.href.lastIndexOf("/")+1);p=p.substring(0,p.lastIndexOf(".")).replace(/-/g,"_");return"ids_"+p;}
else{return"ids";}}};var GetInquiry={Domain:"http://www.motors-biz.com/",Url:"index.php/supplier_connect/index/",IframeId:"iframeIqBox",GetInquiryBox:function(id,type,content,industryType,origin){var data="",isMulti=false;var t=typeof(type)=='undefined'?'spid':type;if(typeof(id)!='undefined'&&type!='cid'){if(MultiSelect.AddByID(id))isMulti=true;}
var ids=$.cookie(MultiSelect.CookieName())||"";if(ids==""&&typeof(id)=='undefined'){alert("please select more than a product!");return;}
if(!isMulti&&typeof(id)!='undefined'){data=id+"/";}
else if(ids!=""){data=ids+"/";}
else{data=id+"/";}
if(typeof(content)!='undefined'){
if(content=="Add your inquiry details for example:\n 1.Yourself Introduction\n 2.Required Size Range & Specification\n 3.Enquiry for Price / MOQ"){
	$("#content_input_span").html("<span class='worry_msg'> * required</span>");
	$("#content_input").focus();
	return false;
}
content = content.replace(/\r\n|\n/ig,"<br/>");
document.cookie = "sendmessage="+content+"; path=/";
if(content.length>2200){
	$("#content_input_span").html("<span class='worry_msg'>Enter between 20 to 2,000 characters.</span>");
	return false;
}
}
if(typeof(industryType)!='undefined'){data+=industryType+"/";}
if(typeof(origin)!='undefined'){data+=origin+"/";}

$("#show").html("");var iqIframe=$("<iframe>");iqIframe.attr("src",GetInquiry.Domain+GetInquiry.Url+data+new Date().getTime());iqIframe.attr({"id":GetInquiry.IframeId,"scrolling":"no","frameborder":"0","width":"100%","height":"100%"});$("#show").html("<img rel='loading' src='"+GetInquiry.Domain+"skin_user/images/loader.gif'/>");GetInquiry.ShowBox({"targetWidth":"28px","targetHeight":"28px","type":"loading"},function(){$("#show").append(iqIframe);});},NewGetInquiryBox:function(op){GetInquiry.GetInquiryBox(op.id,op.type,op.content,op.industryType,op.origin);},ShowBox:function(options,callback){var showBox=$("#show");var iWidth=$.browser.msie?$(document).width()-21:$(document).width();var iHeight=$(window).height();var docHeight=$(document).height();var sTop=$(window).scrollTop();$("#iqBgbox").css({"width":"100%","height":docHeight+"px","display":"block"});var bgIframe=$("#iqIframe");bgIframe.css({"width":"100%","height":docHeight+"px"});bgIframe.attr("class","style1 dis");var startWidth=options.startWidth||"0px";var startHeight=options.startHeight||"0px";var startLeft=showBox.css("display")=="block"?showBox.css("left"):-parseInt(startWidth)+"px";var startTop=showBox.css("display")=="block"?showBox.css("top"):sTop+iHeight+parseInt(startHeight)+"px";var targetWidth=options.targetWidth||showBox.css("width");var targetHeight=options.targetHeight||showBox.css("height");var targetLeft=(iWidth-parseInt(targetWidth))/2+"px";var targetTop=((iHeight-parseInt(targetHeight))/2+sTop)+"px";showBox.css({"display":"block","left":startLeft,"top":startTop,"width":startWidth,"height":startHeight,"z-index":9999});showBox.animate({"left":targetLeft,"top":targetTop,"width":targetWidth,"height":targetHeight},200,callback);},CloseBox:function(){$("#iqIframe").attr("class","undis");$("#show").hide();$("#iqBgbox").hide();$("#iqMsgbox").hide();}};jQuery.cookie=function(key,value,options){if(arguments.length>1&&String(value)!=="[object Object]"){options=jQuery.extend({},options);if(value===null||value===undefined){options.expires=-1;}
if(typeof options.expires==='number'){var days=options.expires,t=options.expires=new Date();t.setDate(t.getDate()+days);}
value=String(value);return(document.cookie=[encodeURIComponent(key),'=',options.raw?value:encodeURIComponent(value),options.expires?'; expires='+options.expires.toUTCString():'',options.path?'; path='+options.path:'',options.domain?'; domain='+options.domain:'',options.secure?'; secure':''].join(''));}
options=value||{};var result,decode=options.raw?function(s){return s;}:decodeURIComponent;return(result=new RegExp('(?:^|; )'+encodeURIComponent(key)+'=([^;]*)').exec(document.cookie))?decode(result[1]):null;};