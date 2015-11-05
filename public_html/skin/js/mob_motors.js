/**
 * Created by ydsq-11 on 2015/9/28.
 */
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
$("#dropdown").click(function() {
    $("#last").toggle();
});
$("#dropdown").mouseleave(function() {
    $("#last").hide();
});
TouchSlide({
    slideCell:"#bannerBox",
    titCell:".hd ul",
    mainCell:".bd ul",
    effect:"leftLoop",
    interTime:6000,
    delayTime:500,
    autoPlay:true,
    autoPage:true
});
TouchSlide({
    slideCell:"#ProductBox",
    titCell:".hd li",
    mainCell:".bd",
    effect:"left",
    easing:"swing",
    delayTime:500
});
TouchSlide({
    slideCell:"#MBbox",
    titCell:".hd li",
    mainCell:".bd",
    effect:"left",
    easing:"swing",
    delayTime:500
})
TouchSlide({
    slideCell:"#IndustryBox",
    titCell:".hd li",
    mainCell:".bd",
    effect:"left",
    easing:"swing",
    delayTime:500
})
TouchSlide({
    slideCell:"#infoBox",
    mainCell:".bd ul",
    effect:"leftLoop",
    interTime:6000,
    delayTime:500,
    autoPlay:true

});
TouchSlide({
    slideCell:"#tabNewBox",
    titCell:".hd li",
    mainCell:".bd",
    effect:"left",
    easing:"swing",
    delayTime:500
});
TouchSlide({
    slideCell:"#CompanyBox",
    titCell:".hd li",
    mainCell:".bd",
    effect:"left",
    easing:"swing",
    delayTime:500
});
TouchSlide({
    slideCell:"#PrincipleBox",
    titCell:".hd li",
    mainCell:".bd",
    effect:"left",
    easing:"swing",
    delayTime:500
});
TouchSlide({
    slideCell:"#BasicsBox",
    titCell:".hd li",
    mainCell:".bd",
    effect:"left",
    easing:"swing",
    delayTime:500
});
$('body').click(function(event) {
    var navLast = $(".mob-btn-left");
    var evt = event.srcElement ? event.srcElement : event.target;
    if(evt.id == 'proNav' || evt.id == 'proIcon' ) {
        if($(this).find(".fa-th").length != 0){
            navLast.find("i").removeClass("fa-th");
            navLast.addClass("mob-color");
            navLast.find("i").addClass("mob-addStyle");
            navLast.find("i").addClass("fa-angle-up");
            $(".mob-Location").slideDown();
        }else{
            navLast.removeClass("mob-color");
            navLast.find("i").removeClass("fa-angle-up");
            navLast.find("i").addClass("fa-th");
            $(".mob-Location").slideUp();

        }
    }
    else {
        navLast.removeClass("mob-color");
        navLast.find("i").removeClass("fa-angle-up");
        navLast.find("i").addClass("fa-th");
        $(".mob-Location").slideUp();

    }
});
$("#proIcon").rotate({
    bind:
    {
        click: function(){
            $(this).rotate({ angle:0,animateTo:360,easing: $.easing.easeInOutExpo })
        }
    }

});
$(".mob-btn-right").click(function(){
    $(".mob-position").addClass("search-slide");
    $(".mob-position").show();
});
$(".mob-content").click(function(){
    $(".mob-position").hide();
    $(".mob-position").removeClass("search-slide")

});
$('body').click(function(event) {
    var categories = $(".mob-more");
    var proSheight = $("#ulLast").val();
    var protopHeight = $("#proTopHeight").val();
    var evt = event.srcElement ? event.srcElement : event.target;
    if(evt.id == 'up' || evt.id == 'down') {
        if(categories.find(".fa-angle-double-down").length != 0){
            categories.find("em").removeClass("fa-angle-double-down");
            categories.find("em").addClass("fa-angle-double-up");
            $(".ulLast").animate({height:proSheight}, "swing");
        }else{
            categories.find("em").removeClass("fa-angle-double-up");
            categories.find("em").addClass("fa-angle-double-down");
            $(".ulLast").animate({height:protopHeight}, "swing");
        }
    }
    else {
        categories.find("em").removeClass("fa-angle-double-up");
        categories.find("em").addClass("fa-angle-double-down");
        $(".ulLast").animate({height:protopHeight}, "swing");
    }
});
$('body').click(function(event) {
    var Attributes = $(".AttributesMore");
    var Sheight = $("#AttributesLast").val();
    var topHeight = $("#topHeight").val();
    var evt = event.srcElement ? event.srcElement : event.target;
    if(evt.id == 'AttributesUp' || evt.id == 'AttributesDown') {
        if(Attributes.find(".fa-angle-double-down").length != 0){
            Attributes.find("em").removeClass("fa-angle-double-down");
            Attributes.find("em").addClass("fa-angle-double-up");
            $(".AttributesLast").animate({height:Sheight}, "swing");
        }else{
            Attributes.find("em").removeClass("fa-angle-double-up");
            Attributes.find("em").addClass("fa-angle-double-down");
            $(".AttributesLast").animate({height:topHeight}, "swing");
        }
    }
    else {
        Attributes.find("em").removeClass("fa-angle-double-up");
        Attributes.find("em").addClass("fa-angle-double-down");
        $(".AttributesLast").animate({height:topHeight}, "swing");
    }
});

$('body').click(function(event) {
    var Attributes = $(".sup-More");
    var supsheight = $("#sup-AttributesLast").val();
    var suptopHeight = $("#sup-topHeight").val();
    var evt = event.srcElement ? event.srcElement : event.target;
    if(evt.id == 'supUp' || evt.id == 'supDown') {
        if(Attributes.find(".fa-angle-double-down").length != 0){
            Attributes.find("em").removeClass("fa-angle-double-down");
            Attributes.find("em").addClass("fa-angle-double-up");
            $(".sup-AttributesLast").animate({height:supsheight}, "swing");
        }else{
            Attributes.find("em").removeClass("fa-angle-double-up");
            Attributes.find("em").addClass("fa-angle-double-down");
            $(".sup-AttributesLast").animate({height:suptopHeight}, "swing");
        }
    }
    else {
        Attributes.find("em").removeClass("fa-angle-double-up");
        Attributes.find("em").addClass("fa-angle-double-down");
        $(".sup-AttributesLast").animate({height:suptopHeight}, "swing");
    }
});

$(function(){
    $(".pro-clear").find("img").addClass("img-responsive");
    $(".pro-clear").find("div").removeAttr("style");
    $(".pro-clear").find("p").removeAttr("style");
    $(".pro-clear").find("span").removeAttr("style");


});