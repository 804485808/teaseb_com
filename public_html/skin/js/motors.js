// JavaScript Document
 $(document).ready(function() {
	 
  $("div.motors-top-nav-right ul li:even").css("padding","0");

  $("#dropdown").click(function() {
    $("#last").toggle();
	}); 
	 $("#dropdown").mouseleave(function() {
    $("#last").hide();
	});	
  $("div.motors-hotSearch ul li:even").css("padding","0");

$(".motors-Classification").slide({
	type:"menu",
	titCell:".motors-feilei",
	targetCell:".motors-Twonav",
	delayTime:0,
	triggerTime:10,
	trigger:"click",
	defaultPlay:false,
	returnDefault:true
});

TouchSlide({ 
	slideCell:"#motors-slideBox",
	titCell:".hd ul", 
	mainCell:".bd ul", 
	effect:"leftLoop",
	interTime:6000,
	delayTime:500, 
	autoPlay:true,
	autoPage:true
				});
TouchSlide({
		slideCell:"#motors-tab",
		titCell:".hd li",
		mainCell:".bd",
		effect:"left",
		easing:"swing",
		delayTime:500
});

$(".motors-tabProducts").hover(
	function(){
			$(this).find(".motors-prev,.motors-next").stop(true,true).fadeTo("show",0.9);
			},
			function(){$(this).find(".motors-prev,.motors-next").fadeOut();
			}
		);
$(".motors-tabProducts .motors-box").slide({ mainCell:"ul",vis:3,scroll:1,switchLoad:"_src",prevCell:".motors-prev",nextCell:".motors-next",effect:"leftLoop"});
$(".motors-tabProducts").slide({
	titCell:".motorsHd li",
	mainCell:".motorsBd",
	targetCell:".more a",
	effect:"left",
	easing:"swing",
	switchLoad:"_src",
	delayTime:200,
	trigger:"click"
});

$(".motors-imgscroll").slide({
	mainCell:".bd ul",
	vis:7,
	autoPage:true,
	effect:"leftLoop",
	easing:"swing",
	scroll:1,
	trigger:"click",
	switchLoad:"_src",
	interTime:2500
	});
         
 $(".motors-tabtechnical").slide({
	targetCell:".more a",
	trigger:"click"
});
TouchSlide({
		slideCell:"#tecbox",
		titCell:".hd li",
		mainCell:".bd",
		effect:"left",
		switchLoad:"_src",
		easing:"swing",
		delayTime:500
});

 TouchSlide({
	 slideCell:"#Exhibitionbox",
	 titCell:".motors-xhibition-imgebtn span",
	 mainCell:".bd ul",
	 effect:"leftLoop",
	 switchLoad:"_src",
	 interTime:6000,
	 delayTime:500,
	 autoPlay:true
});

 $(".motors-tabexhibition").hover(
	function(){
			$(this).find(".prev,.next").stop(true,true).fadeTo("show",0.9);
			},
			function(){$(this).find(".prev,.next").fadeOut();
			}
		);
		 $(".motors-newsInfo").slide({
	targetCell:".more a",
	trigger:"click"
});
	
 $(".motors-tabBusiness").slide({
	targetCell:".more a",
	trigger:"click"
});
TouchSlide({
	slideCell:"#MBbox",
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	switchLoad:"_src",
	easing:"swing",
	delayTime:500
});
 $(".motors-tabnews").hover(
	function(){
			$(this).find(".prev,.next").stop(true,true).fadeTo("show",0.9);
			},
			function(){$(this).find(".prev,.next").fadeOut();
			}
		);
TouchSlide({ 
	slideCell:"#tabnewsbox",
	titCell:".motors-news-imgebtn span",
    mainCell:".bd ul",
	effect:"leftLoop",
	switchLoad:"_src",
	interTime:6000,
	delayTime:500,
	autoPlay:true
	});
 


 $("div.motors-footer-nav ul li:even").css("padding","0");
});


$(document).ready(function() {
     $("#show").click(function() {
    $("#classbox").show();
	}); 
	$("#hide").click(function() {
    $("#classbox").hide();
	});
	
TouchSlide({
	slideCell:"#Productsbox",
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	easing:"swing",
	delayTime:500
});


});
$(window).scroll(function(){
			if ($(this).scrollTop() > 250) {
				$('#motors-to-top').fadeIn();
			} else {
				$('#motors-to-top').fadeOut();
			}
		});
		$('#motors-to-top').on('click', function(e){
			e.preventDefault();
			$('html, body').animate({scrollTop : 0},500);
			return false;
		});
		
/*Information start*/
/*banner*/
TouchSlide({ 
		slideCell:"#Info-slideBox",
		titCell:".hd ul", 
		mainCell:".bd ul", 
		effect:"left",
		interTime:6000,
		delayTime:500, 
		autoPlay:true,
		autoPage:true
		});

$(".Info-designBox").slide({
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	easing:"swing",
	delayTime:200,
	trigger:"click"
});			

$("#principleBox").slide({
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	easing:"swing",
	delayTime:200,
	trigger:"click"
});		

$("#InstallBox").slide({
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	easing:"swing",
	delayTime:200,
	trigger:"click"
});	
$("#RepairBox").slide({
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	easing:"swing",
	delayTime:200,
	trigger:"click"
});

$("#TireBox").slide({
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	easing:"swing",
	delayTime:200,
	trigger:"click"
});
$("#HawkBox").slide({
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	easing:"swing",
	delayTime:200,
	trigger:"click"
});
TouchSlide({
	slideCell:"#Figurebox",
	titCell:".hd li",
	mainCell:".bd",
	effect:"left",
	easing:"swing",
	delayTime:500
});
function next(){
var m1=document.getElementById('movie1');
var m2=document.getElementById('movie2');
var m3=document.getElementById('movie3');
if(m1.style.display=='block'){
m1.style.display='none';
m2.style.display='block';
}else if(m2.style.display=='block'){
m2.style.display='none';
m3.style.display='block';
}else{
m3.style.display='none';
m1.style.display='block';
}
}

function Change(){
var m1=document.getElementById('more1');
var m2=document.getElementById('more2');
var m3=document.getElementById('more3');
if(m1.style.display=='block'){
m1.style.display='none';
m2.style.display='block';
}else if(m2.style.display=='block'){
m2.style.display='none';
m3.style.display='block';
}else{
m3.style.display='none';
m1.style.display='block';
}
}
$(document).ready(function(){
		$(".down_icon").each(function(index, element) {
            $(this).click(function(){
				 if($(this).find(".fa-angle-double-up").length == 0)
				 {
					$(this).parent().animate({height:"72px"}, "swing");
                 	$(this).find("i").removeClass("fa-angle-double-down"); 
			     	$(this).find("i").addClass("fa-angle-double-up");
                    $(".product_BrandCountry").animate({height:$(".product_BrandCountry").height()+36}, "swing");
				 }
				  else
				 {
				     $(this).parent().animate({height:"36px"}, "swing");
                     $(this).find("i").removeClass("fa-angle-double-up"); 
			         $(this).find("i").addClass("fa-angle-double-down");
                     $(".product_BrandCountry").animate({height:$(".product_BrandCountry").height()-36}, "swing");
				 }
			});			
        });

		$("#btndown").click(function(){
			if($(this).find(".fa-angle-double-up").length == 0){
			$(".product_BrandCountry").animate({height:$(".product_BrandCountry").height()*2}, "swing");
			$("div.product_Attributes_Fold").removeClass("btn_down");
			$("div.product_Attributes_Fold").addClass("btn_up");
			$("div.product_Attributes_Foldicon").removeClass("product_Attributes_Folddown");
			$("div.product_Attributes_Foldicon").addClass("product_Attributes_Foldup");
			$(this).find("i").removeClass("fa-angle-double-down");
			$(this).find("i").addClass("fa-angle-double-up");
			}
			else
			{
			$(".product_BrandCountry").animate({height:$(".product_BrandCountry").height()*0.5}, "swing");
			$("div.product_Attributes_Fold").removeClass("btn_up");
			$("div.product_Attributes_Fold").addClass("btn_down");
			$("div.product_Attributes_Foldicon").removeClass("product_Attributes_Foldup");
			$("div.product_Attributes_Foldicon").addClass("product_Attributes_Folddown");
			$(this).find("i").removeClass("fa-angle-double-up");
			$(this).find("i").addClass("fa-angle-double-down");
				}
			});
	});
$(".MProducts_box").hover(
	function(){
			$(this).find(".Products_prev,.Products_next").stop(true,true).fadeTo("show",0.9);
			},
			function(){$(this).find(".Products_prev,.Products_next").fadeOut();
			}
		);
$(".Hot_newProducts .MProducts_box").slide({ mainCell:"ul",vis:5,scroll:1,switchLoad:"_src",prevCell:".Products_prev",nextCell:".Products_next",effect:"leftLoop"});
$(".Hot_newProducts").slide({
	titCell:".ProductsHd li",
	mainCell:".ProductsBd",
	targetCell:".more a",
	effect:"leftLoop",
	easing:"swing",
	switchLoad:"_src",
	delayTime:800,
	trigger:"click"
});

$(".product_RecommendedBox").slide({
	targetCell:".more a",
	trigger:"click"
});
TouchSlide({
		slideCell:"#RecommendedBox",
		titCell:".hd li",
		mainCell:".bd",
		effect:"left",
		switchLoad:"_src",
		easing:"swing",
		delayTime:500
});
$(".product_FeaturedBox").hover(
	function(){
			$(this).find(".Feature_prev,.Feature_next").stop(true,true).fadeTo("show",0.9);
			},
			function(){$(this).find(".Feature_prev,.Feature_next").fadeOut();
			}
		);
$(".product_FeaturedBox").slide({ mainCell:"ul",vis:4,scroll:1,switchLoad:"_src",prevCell:".Feature_prev",nextCell:".Feature_next",effect:"leftLoop"});
$(document).ready(function() {
	$(".Mobile_CommodityAttributes").click(function(){
		if($(this).find(".fa-caret-up").length == 0){
			$(".Mobile_productBrandCountry") .slideDown("slow");
			$(this).find("i").removeClass("fa-caret-down");
			$(this).find("i").addClass("fa-caret-up"); 
		}
		else
		{
			$(".Mobile_productBrandCountry") .slideUp("slow");	
			$(this).find("i").removeClass("fa-caret-up");
			$(this).find("i").addClass("fa-caret-down"); }
		});
		
		  
});
/*Information end*/
/*productdetails*/
	 
  $("div.product-motors-top-nav-right ul li:even").css("padding","0");

  $("#Pdropdown").click(function() {
    $("#Plast").toggle();
	}); 
	 $("#Pdropdown").mouseleave(function() {
    $("#Plast").hide();
	});	
  $("div.product-motors-hotSearch ul li:even").css("padding","0");
TouchSlide({ 
	slideCell:"#PreviewBox",
	mainCell:".bd ul", 
	effect:"leftLoop", 
	switchLoad:"_src"
});
    $(".product_Complex").click( function(){
		$(".product_Complex").each(function() {
			$(this).removeClass("product_Complex_color");
		});	
		 var lengths =  $(this).attr("class");
		 var classs = lengths.split(" ").length;
		 if(classs == 2){
			     $(this).removeClass("product_Complex_color");
			}
			else
			{
				$(this).addClass("product_Complex_color");
			}
	});
$(".product_AgentsRangeLast").find(".product_AgentsRange").each(function(index, element) {
    $(this).mouseenter(function(){
		$(this).next().show();
		});
	$(this).mouseleave(function(){
		$(this).next().hide();
		});
});
	$(".product_Suppliersbox").slide({
	titCell:".pr_lab",
	targetCell:".pr_box",
	defaultIndex:0,
	effect:"slideDown",
	easing:"swing",
	delayTime:300,
	returnDefault:false
	});
	
/*productdetails end*/
/*supplierslast start*/
$(".Suooliers_more").each(function(index, element) {
    $(this).click( function(){
		if($(this).find(".fa-caret-up").length == 0){
			$(this).prev().animate({height:$(this).parent().find(".Suooliers_boby").height()*3}, "swing");
			$(this).find("i").removeClass("fa-caret-down"); 
			$(this).find("i").addClass("fa-caret-up");
			$(this).find("span").html("Less");
			}else
			{
			$(this).prev().animate({height:$(this).parent().find(".Suooliers_boby").height()/3}, "swing");
			$(this).find("i").removeClass("fa-caret-up"); 
			$(this).find("i").addClass("fa-caret-down");
			$(this).find("span").html("More");
			}					
		});
});
$(".suppliers_Hotproductbox").slide({
		mainCell:".bd ul",
		effect:"leftLoop",
		interTime:3500,
		delayTime:800,
		autoPlay:false,
		prevCell:".suppro_prev",
		nextCell:".suppro_next",
		autoPage:true, 
		trigger:"click", 
		easing:"swing"
	});
$(".sup_Hotsearch_more").each(function(index, element) {
    $(this).click( function(){
		if($(this).find(".fa-caret-up").length == 0){
			$(this).prev().animate({height:$(".sup_Hotsearch_content").height()*2}, "swing");
			$(this).find("i").removeClass("fa-caret-down"); 
			$(this).find("i").addClass("fa-caret-up");
			$(this).find("span").html("Less");
			}else
			{
			$(this).prev().animate({height:$(".sup_Hotsearch_content").height()*0.5}, "swing");
			$(this).find("i").removeClass("fa-caret-up"); 
			$(this).find("i").addClass("fa-caret-down");
			$(this).find("span").html("More");
			}
	});
});

/*supplierslast end*/
$(".suppliers_nav").slide({
	type:"menu",
	titCell:".sli",
	targetCell:".sub",
	effect:"slideDown",
	delayTime:300,
	triggerTime:0,
	defaultPlay:true,
	easing:"swing",
	returnDefault:true
	});
TouchSlide({ 
	slideCell:"#introductionBox",
	mainCell:".bd ul", 
	effect:"leftLoop", 
	switchLoad:"_src"
});
$(".product_Hierarchy").find("#M_menu").mouseenter(function(){
	$(".Level_menu").slideDown();
	});
$(".product_Hierarchy").mouseleave(function(){
	$(".Level_menu").slideUp();
	});
	 $(".commodityBox").slide({	
				mainCell:".bd ul",
				easing:"swing",
				effect:"leftLoop",
				switchLoad:"_src"			
				});
$(".product_border").slide({
	type:"menu",
	titCell:".bb",
	effect:"slideDown",
	delayTime:100,
	triggerTime:0,
	defaultPlay:true,
	easing:"swing",
	returnDefault:false
	});

 $(".tcdPageCode").createPage({
        pageCount:10,
        current:1,
        backFn:function(p){
            console.log(p);
        }
    });
$(".product_presentation").find("div").removeAttr("style");
$(".product_presentation").find("table").removeAttr("style");
$(".product_presentation").find("p").removeAttr("style");
$(".product_presentation").find("span").removeAttr("style");
