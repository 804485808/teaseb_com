<header>
            <div class="mobUp">
                <div class="mob-logo">
                    <a href="/" ><img src="<?php echo base_url('/skin/images/motors-logo.png');?>" alt="" class="img-responsive"></a>

                </div>
                <ul>

                    <?php if(!$username) {?>
                        <li><a href="<?php echo main_url(site_url("/reg_login/login_in/"))?>">Sign In</a></li>
                        <li>|</li>
                        <li><a href="<?php echo main_url(site_url("/reg_login/register/"))?>">Join Free</a></li>
                    <?php }else {?>
                        <li><a href="<?php echo main_url(site_url("/user/user_main/"))?>">My Center</a></li>
                        <li>|</li>
                        <li><a href="<?php echo main_url(site_url("/reg_login/login_out/"))?>" rel="nofollow">Sign Out</a></li>
                    <?php }?>

                </ul>
                <div class="clear"></div>
            </div>
    <div class="mob-motors-sousuo">
        <div class="mob-motors-search">
            <div class="mob-motors-dropdown" id="dropdown">
                <div class="mob-btn-color" id="btn-meun">All <span class="carets">▼</span> </div>
                <ul class="mob-motors-last" id="last">
                    <li><a href="#">All</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Suppliers</a></li>
                    <li><a href="#">Buyers</a></li>
                </ul>
            </div>

            <form action="<?php echo site_url("search/".$kw);?>" method="post" id="fast_search" name="fast_search">
                <div class="mob-motors-text">
                    <input type="text" id="input_text"  name="search" class="mob-motors-input">
                </div>
            </form>
        </div>
        <div class="mob-motors-btnsearch"><i onclick="search_sub()" class="fa fa-search fa-lg motors-hidden"></i></div>
        <div class="clear"></div>

    </div>
</header>
<script type="text/javascript">
    $("#search").click(function(){
        $("#fast_search").submit();
    })
</script>
<div class="mob-banner">
    <div class="mob-bannerBox" id="bannerBox">
        <div class="hd">
            <ul></ul>
        </div>
        <div class="bd">
            <ul>
                <li>
                    <div class="pic"><a href="#"><img src="<?php echo base_url('/skin/images/banner1.jpg')?>" class="img-responsive" alt=""/></a></div>
                </li>
                <li>
                    <div class="pic"><a href="#"><img src="<?php echo base_url('/skin/images/banner2.jpg')?>" class="img-responsive" alt=""/></a></div>
                </li>
                <li>
                    <div class="pic"><a href="#"><img src="<?php echo base_url('/skin/images/banner3.jpg')?>" class="img-responsive" alt=""/></a></div>
                </li>
                <li>
                    <div class="pic"><a href="#"><img src="<?php echo base_url('/skin/images/banner4.jpg')?>" class="img-responsive" alt=""/></a></div>
                </li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="mob-nav">
    <div class="mob-ulLi">
        <a href="<?php echo site_url('products/index')?>" class="mob-backImg"><img src="<?php echo base_url('/skin/images/mob-allproducts.png')?>" class="img-responsive" alt=""></a>
        <span><a href="<?php echo site_url('products/index')?>">Products</a></span>
    </div>
    <div class="mob-ulLi">
        <a href="<?php echo site_url('news/index')?>" class="mob-backImg"><img src="<?php echo base_url('/skin/images/mob-information.png')?>" class="img-responsive" alt=""></a>
        <span><a href="<?php echo site_url('news/index')?>">Information</a></span>
    </div>
    <div class="mob-ulLi">
        <a href="<?php echo site_url('company/suppliers')?>" class="mob-backImg"><img src="<?php echo base_url('/skin/images/mob-suppliers.png')?>" class="img-responsive" alt=""></a>
        <span><a href="<?php echo site_url('company/suppliers')?>">Suppliers</a></span>
    </div>
    <div class="mob-ulLi">
        <a href="<?php echo site_url('news/newsList/28')?>" class="mob-backImg"><img src="<?php echo base_url('/skin/images/mob-exhibition.png')?>" class="img-responsive" alt=""></a>
        <span><a href="<?php echo site_url('news/newsList/28')?>">Exhibition</a></span>
    </div>
    <div class="clear"></div>
</div>
<div class="mob-allProduct">
    <div class="mob-hotProduct" id="ProductBox">
        <div class="hd">
            <ul>
                <li class="on">Hot Products</li>
                <li>New Products</li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="bd">
            <ul>
                <?php foreach(array_slice($hot_pros,0,4) as $k=>$v){?>
                <li>
                    <div class="mob-ProFeaturedImg">
                        <a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>">
                            <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" class="img-responsive" alt="<?php echo $v['title']?>">
                        </a>
                    </div>
                    <dl>
                        <dt><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>">
                                <?php echo $v['title']?>
                        </a></dt>
                        <?php foreach($v['attr'] as $ak=>$av){?>
                            <dd><?php echo $av['name']?>：<b  class="motors-public-color" title="<?php echo $av['value']?>"><?php echo strlen($av['value'])>20?substr($av['value'],0,15)."...":$av['value']?></b></dd>
                        <?php }?>

                    </dl>
                </li>
                <?php }?>
            </ul>
            <ul>

                <?php foreach(array_slice($selllist,0,4) as $k=>$v){?>
                <li>
                    <div class="mob-ProFeaturedImg"><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>">
                            <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" class="img-responsive" alt="<?php echo $v['subtitle']?>">
                        </a></div>
                    <dl>
                        <dt><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>"><?php echo substr($v['subtitle'],0,50)?></a></dt>
                        <dd>Price：<b class="motors-public-color"><?php  echo $v['minprice']>0 ? $v['currency']." ".$v['minprice'] : "Negotiable"?></b> </dd>
                        <dd>MOQ：<b class="motors-public-color"><?php echo $v['minamount']."/".$v['unit']?></b></dd>
                        <dd>Region：<b class="motors-public-color"><?php echo $v['areaname']?></b></dd>
                    </dl>
                </li>
                <?php }?>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="mob-HotBrands">
    <h1>Hot Brands</h1>
    <ul>
        <li><a><img src="<?php echo base_url('/skin/images/Aosmith.png')?>" class="img-responsive" alt=""></a></li>
        <li><a><img src="<?php echo base_url('/skin/images/Baldor.png')?>" class="img-responsive" alt=""></a></li>
        <li><a><img src="<?php echo base_url('/skin/images/Maxon.png')?>" class="img-responsive" alt=""></a></li>
        <li><a><img src="<?php echo base_url('/skin/images/Minn_korn.png')?>" class="img-responsive" alt=""></a></li>
        <li><a><img src="<?php echo base_url('/skin/images/rockwell.png')?>" class="img-responsive" alt=""></a></li>
        <li><a><img src="<?php echo base_url('/skin/images/Siemens.png')?>" class="img-responsive" alt=""></a></li>
        <li><a><img src="<?php echo base_url('/skin/images/Suzuki.png')?>" class="img-responsive" alt=""></a></li>
        <li><a><img src="<?php echo base_url('/skin/images/Yamaha.png')?>" class="img-responsive" alt=""></a></li>
    </ul>
    <div class="clear"></div>
</div>

<div class="motors-Business">
    <div class="motors-tabBusiness" id="MBbox">
        <div class="hd">
            <ul>
                <li class="on">Information</li>
                <li>Exhibition </li>
                <li>Technology </li>
            </ul>
        </div>
        <div class="bd">
            <article>
                <?php foreach(array_slice($newsTop,0,4) as $k=>$v){?>
                <section>
                    <div class="motors-Timg"><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>">
                            <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" title="" alt="" class="img-responsive">
                        </a></div>
                    <div class="mob-text">
                        <h1><a title="<?php echo $v['title']?>" href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><?php echo $v['title']?></a></h1>
                        <h3><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><?php echo substr(strip_tags($v['content']),0,250)?>...</a></h3>
                    </div>
                </section>
                <?php }?>
            </article>
            <article>
                <?php foreach(array_slice($exhibition,0,4) as $k=>$v){?>
                <section>
                    <div class="motors-Timg"><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>">
                            <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" title="" alt="" class="img-responsive">
                        </a></div>
                    <div class="mob-text">
                        <h1><a title="<?php echo $v['title']?>" href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><?php echo $v['title']?></a></h1>
                        <h3><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><?php echo substr(strip_tags($v['content']),0,250)?>...</a></h3>
                    </div>
                </section>
               <?php }?>
            </article>
            <article>

                <?php foreach(array_slice($mobile_technology,0,4) as $k=>$v){?>
                    <section>
                        <div class="motors-Timg"><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>">
                                <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" title="" alt="" class="img-responsive">
                            </a></div>
                        <div class="mob-text">
                            <h1><a title="<?php echo $v['title']?>" href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><?php echo $v['title']?></a></h1>
                            <h3><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><?php echo substr(strip_tags($v['content']),0,250)?>...</a></h3>
                        </div>
                    </section>
                <?php }?>

            </article>
        </div>
    </div>
    <div class="clear"></div>
</div>


<div class="mob-ProductPrice">
    <h1>Product Price</h1>

    <div class="Product_Price_Details">
        <div class="mob-tr">
            <div class="Product-Name">Product Name</div>
            <div class="ProductAttribute">Voltage (v)</div>
            <div class="ProductAttribute"> Power (w)</div>
            <div class="ProductAttribute">Price (US)</div>
        </div>
        <?php foreach($productPrice as $k=>$v){?>
        <div class="mob-tr">
            <a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>"><div class="mob-Product-Name"><?php echo substr($v['title'],0,25)?></div></a>
            <div class="ProductAttribute"><?php echo substr($v['attr']['Voltage'],0,10)?></div>
            <div class="ProductAttribute"> <?php echo substr($v['attr']['Power'],0,10)?></div>
            <div class="ProductAttribute"><?php echo $v['currency']." ".$v['minprice']?></div>
        </div>
        <?php }?>
        <div class="clear"></div>
    </div>
</div>

<div class="motors-Business">
    <div class="motors-tabBusiness" id="IndustryBox">
        <div class="hd">
            <ul>


                <?php foreach($market as $k=>$v){?>
                    <li class="<?php echo $k?'':'on'?>"><?php echo $k?></li>
                <?php }?>
            </ul>
        </div>
        <div class="bd">
            <?php for($i=0;$i<count($market);$i++) {?>
            <?php $arr = $i==0?reset($market):next($market)?>
            <article>
                <?php foreach(array_slice($arr,0,6) as $k=>$v){?>
                <section>
                    <div class="motors-Timg"><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" title="" alt=""
                                                             class="img-responsive"></a></div>
                    <div class="mob-text">
                        <h1><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><?php echo $v['title']?></a></h1>

                        <h3><a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>"><?php echo substr(strip_tags($v['content']),0,300)?></a></h3>
                    </div>
                </section>
                <?php }?>


            </article>
            <?php }?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="mob-region">
    <h1>Source by Region</h1>
    <ul>
        <li><a href=""> <i class="motors-SourceImg-01"></i><span>USA</span></a></li>
        <li><a href="">
                <i class="motors-SourceImg-02"></i>
                <span>China</span></a>
        </li>
        <li><a href="">
                <i class="motors-SourceImg-03"></i>
                <span>India</span></a>
        </li>
        <li><a href="">
                <i class="motors-SourceImg-04"></i>
                <span>Japan</span></a>
        </li>
        <li><a href="">
                <i class="motors-SourceImg-05"></i>
                <span>Malaysia</span></a>
        </li>
        <li><a href="">
                <i class="motors-SourceImg-06"></i>
                <span>Thailand</span></a>
        </li>
        <li><a href="">
                <i class="motors-SourceImg-07"></i>
                <span>Turkey</span></a>
        </li>
        <li><a href="">
                <i class="motors-SourceImg-08"></i>
                <span>Vietnam</span></a>
        </li>
    </ul>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    function search_sub(){
        if(document.getElementById('input_text').value!="Tire Brands, Specifications, or Vehicles..." && document.getElementById('input_text').value!=""){
            document.getElementById('fast_search').submit();
        }else{
            return false;
        }
    }
</script>