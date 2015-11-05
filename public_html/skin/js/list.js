// JavaScript Document


$(document).ready(function(){
	$("#list").click(function(){ 
		$("#list").removeClass("lNone");
		$("#list").addClass("l");
		$("#gallery").removeClass("g");
		$("#gallery").addClass("gNone");
		$("#ListGallery").addClass("listL");
		$("#ListGallery").removeClass("listG");
		
	  });
	$("#gallery").click(function(){ 
		$("#list").removeClass("l");
		$("#list").addClass("lNone");
		$("#gallery").removeClass("gNone");
		$("#gallery").addClass("g");
		$("#ListGallery").addClass("listG");
		$("#ListGallery").removeClass("listL");
		
	  });
	$("#m1").click(function(){ 
		$("#m1").addClass("cMain");
		$("#n2").removeClass("cMain");
		$("#p3").removeClass("cMain");
		
	  });
	$("#n2").click(function(){ 
		$("#m1").removeClass("cMain");
		$("#n2").addClass("cMain");
		$("#p3").removeClass("cMain");
		
	  });
	$("#p3").click(function(){ 
		$("#m1").removeClass("cMain");
		$("#n2").removeClass("cMain");
		$("#p3").addClass("cMain");
		
	  });


});


$(document).ready(function(){
	$(".otherPBox").find(".botPmore").each(function(i){ 

	if($(".otherPBox").find("ul:eq("+i+")").find(".outbox").height()<270){$(this).hide()};
	if($(".otherPBox").find("ul:eq("+i+")").find(".outbox").height()<450){$(".otherPBox").find("ul:eq("+i+")").find(".moreLink").hide()};

																													   
	if($(".otherPBox").find("ul:eq("+i+")").find(".outbox").height()<130){$(".otherPBox").find("ul:eq("+i+")").animate({height:125+"px"},{queue:false, duration:0})};
	
	$(this).click(function(){
		var getOutBoxHeht=$(".otherPBox").find("ul:eq("+i+")").find(".outbox").height()+"px"; 
			$(".otherPBox").find("ul:eq("+i+")").animate({height:getOutBoxHeht},{queue:false, duration:300});
			$(this).hide();
		});
	  });

});

$(document).ready(function(){
	$(".HotCatList").find('ul').hide();
	$(".HotCatList").find("ul:eq(0)").show();
	$(".HotCatLeft").find('li').each(function(i){
		$(this).click(function(){
			$(".HotCatLeft").find('li').removeClass("black");	   
			$(this).addClass("black");
			$(".HotCatList").find('ul').hide({queue:false, duration:0});
			$(".HotCatList").find("ul:eq("+i+")").show({queue:false, duration:200});
		  });
	 });
	$(".comListRightList").find('li').each(function(i){
		$(this).find(".comListShowMore").click(function(){
			$(".comListRightList").find('li').removeClass("tabcomList");											
			$(".comListRightList").find('li').addClass("comListPicL");											
		});									  
	 });
	$(".comListRightList").find("li:eq(0)").css("border","0px");
	$(".comListRightList").find('li:odd').addClass("comListPicR");


});








