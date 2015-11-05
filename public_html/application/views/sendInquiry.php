<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=0 "/>
    <title>Motors-biz.com, Comprehensive Portal on Motor Products, Information, Exhibitions, Price, Suppliers, Buyers, Manufacturers</title>
    <meta name="description" content="<?php echo $description?>">
    <link rel="stylesheet"  href="<?php echo base_url('/skin/css/bootstrap.css"/>')?>
        <link rel="stylesheet"  href="<?php echo base_url('/skin/css/font-awesome.css')?>"/>
    <link rel="stylesheet"  href="<?php echo base_url('/skin/css/buttons.css')?>"/>
    <link rel="stylesheet"  href="<?php echo base_url('/skin/css/mob_motors.css')?>"  />
    <link rel="stylesheet"  href="<?php echo base_url('/skin/css/dropload.min.css')?>"  />
    <script  src="<?php echo base_url('/skin/js/jquery.min.js')?>"></script>
    <script  src="<?php echo base_url('/skin/js/TouchSlide.1.1.js')?>"></script>
    <script  src="<?php echo base_url('/skin/js/bootstrap.js')?>"></script>
    <script  src="<?php echo base_url('/skin/js/jquery.rotate.min.js')?>"></script>
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('/skin/js/html5shiv.min.js')?>"></script>
    <script src="<?php echo base_url('/skin/js/respond.min.js')?>"></script>
    <![endif]-->
</head>
<body>
<div class="mob-body" >
    <!--head-->
    <div class="head_snav">
        <a onclick="javascript:history.go(-1)" ><img src="<?php echo base_url('skin/images/arrows_left.png')?>"></a>
        <span>Send Inquiry</span>
    </div>
    <form id="Inquiry">
    <div class="sen_box">
        <div class="text_box0">
            <h5>*<span>From</span></h5>
            <input type="text"  id="email" name="post[email]" placeholder="Enter your email address">
        </div>
        <div class="text_box0">
            <h5>*<span>Subject</span></h5>
            <input type="text" readonly name="post[title]" id="subject" value="Inquiry about <?php echo $product['title']?>" >

            <input type="hidden" name="post[sid]" value="<?php echo $product['itemid']?>">
            <input type="hidden" name="post[touser]" value="<?php echo $product['username']?>">
        </div>
        <div class="text_box0 clear_mar">
            <h5 class="con_tex">*<span>Content</span></h5>
            <textarea class="tebie0" name="content"></textarea>
        </div>
        <h6 class="huise">Your inquiry content must be between 20 to 4000 characters.</h6>
        <input type="button" id="send" value="Send Inquiry" class="sent_0">
        <div class="duiqi_0">
            <h5 class="duiqi_f">*<span>Please contact the merchant for service information.</span></h5>
            <h5>*<span>Please make sure your contact information is correct.</span></h5>
            <h4>Your message will be sent directly to the recipient(s) and will not be publicly
                displayed.<br>
                We will never distribute or sell your personal information to third parties without
                your express permission.</h4>
        </div>
    </div>
        </form>


    <!--footer-->
    <!--<foot>
        <div class="mob_footer">Copyright © 2014 motors-biz.com. All rights reserved. Designed by HK Netor LTD</div>
        <div class="mob_followUs">
            <div class="mob_share">
                <label>Follow Us :</label>
                <div class="motors_share" >
                   <a href="#"><img src="images/facebook_logo.png"></a>
                   <a href="#"><img src="images/twrtter_logo.png"></a>
                   <a href="#"><img src="images/linked_in.png"></a>
                   <a href="#"><img src="images/gool_logo.png"></a>
                </div>
            </div>
        </div>
    </foot>-->
</div>
</body>
</html>
<script type="text/javascript">
    $("#send").click(function(){
        var email = $("#email").val();
        if(!email){
            alert("email can't be empty")
            return false;
        }
        if(!email.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)){
            alert("please fill in correct format Email")
            return false;
        }



        $.ajax({
            url:'<?php echo site_url('supplier_connect/save')?>',
            type:'post',
            data:$("#Inquiry").serialize(),
            dataType:'html',
            success:function(data){
                if(data==1){
                    alert('Submit success!')
                }else if(data==3){
                    alert('Submission failure!')
                }else if(data==2){
                    alert('Cannot repeat!')
                }
            }
        })

    })


</script>