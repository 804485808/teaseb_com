<script src="<?php echo base_url('skin/js/iscroll.js')?>"></script>
<div class="mob-content">

    <!--Profile-Contact-->
    <div class="nav">
        <span class="Profilebox"><a href="<?php echo site_url("company/index/".$product['username'])?>" class="Profile"><img src="<?php echo base_url('skin/images/arrows_right.png')?>">Company Profile</a></span>
        <span class="contactbox"><a href="<?php echo site_url('mob_sendInquiry/index/'.$product['itemid'])?>" class="contact"><img src="<?php echo base_url('skin/images/mail.png')?>">Contact Now</a></span>
    </div>

    <!--pro_information-->
    <div class="pro-clear">
    <div class="pro_infbox">
        <img src="<?php echo site_url('mob_img/img'.$product['thumb'])?>">
        <h2><?php echo $product['subtitle'];?><br>
        </h2>
        <h3><?php echo $product['minprice']>0 ? $product['currency']." ".$product['minprice'] : "Negotiable";?><br>
            <?php echo $product['minamount'],"/",plural($product['unit']);?>(Min. Order)
        </h3>
        <ul class="pro_inf">

            <?php foreach(array_slice($product['attr'],0,6) as $k=>$v){?>
                <li><span><?php echo $k?>:</span><?php echo $v?></li>

            <?php }?>



        </ul>
    </div>

    <!--Product Description-->
    <div class="pro_desc">
        <div class="duiqi"><span>Product Description</span>
        </div>
        <h2>Basic Info.</h2>
        <ul class="pro_inf">
            <?php foreach($product['attr'] as $k=>$v){?>
                <li><span><?php echo $k?>:</span><?php echo $v?></li>
            <?php }?>

        </ul>
    </div>
    <ul class="description-box">
        <h2 class="description">Product Description.</h2>
        <li><?php echo $product['content'];?></li>
         </ul>
    <ul class="com_inf">
        <h2></h2>
        <li><?php echo $product['company']?><br>
            Business Type:<?php echo $com_data['mode'];?>,<br>
            Main Products: <?php echo $product['markets']?><br>
            Website: <a href="<?php echo site_url("company/index/".$product['username']);?>"><?php echo site_url("company/index/".$product['username']);?></a><br>
            Telephone: <?php echo $product['telephone']?><br>
        </li>
    </ul>
    </div>
    <div class="shop_box">
        <ul class="who_shop"><li>People who shopped for this item also looked at</li></ul>
        <div id="wrapper">
        <table bordercolor="#ddd" border="1" cellspacing="0" class="shop_list">
            <tr>
                <td><span>Product</span></td>
                <?php foreach(array_slice($option,0,8) as $k => $v):?>
                <td><span><?php echo $k?></span></td>
                <?php endforeach;?>
            </tr>
<!--            <tr>-->
<!--                <td><img src="images/product_pc.png"><span>z4 series gear motors for cranes</span></td>-->
<!--                <td>3</td>-->
<!--                <td>50/60HZ</td>-->
<!--                <td>T/t, L/c, Western Union</td>-->
<!--                <td>1.4kw ~ 600k</td>-->
<!--                <td>Rolling Mill</td>-->
<!--                <td>160v 400v</td>-->
<!--                <td>2300 RPM</td>-->
<!--                <td>Twain</td>-->
<!--            </tr>-->
            <?php foreach(array_slice($likeSell,0,8) as $s){?>
                <tr>
                <td><img src="<?php echo site_url('mob_img/img'.$s['thumb']).'/h/85/w/85'?>">
                    <a href="<?php echo site_url('sell_detail/index/'.$s['itemid'].'/'.$s['linkurl'])?>">
                <?php if($s['itemid']<1000000):?>
                        <span><?php echo substr($s['title'],0,30)?></span></a>
                <?php else:?>
                    <span><?php echo substr($s['subtitle'],0,30)?></span></a>
                <?php endif?>
                </td>


                    <?php foreach(array_slice($s['attr'],0,8) as $kk=>$vv){?>

                            <td><?php echo substr($vv,0,22)?></td>

                    <?php }?>
                </tr>
            <?php }?>
        </table>
            </div>
    </div>
 <script>
     $(function(){
         $(".pro-clear table").wrap("<div id='wrap'></div>");
            new iScroll("wrapper",{snap:true,
             momentum:false,
             hScrollbar:false,
             vScrollbar: false,
             hScroll:true,
             vScroll:false });
            new iScroll("wrap",{snap:true,
             momentum:false,
             hScrollbar:false,
             vScrollbar: false,
             hScroll:true,
             vScroll:false });
     });
    </script>

    <!--footer-->


