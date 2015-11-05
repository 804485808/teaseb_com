<div class="mob-content">
    <div class="mob-anNiu">
        <a href="<?php echo site_url('products/productList')?>" class="mob-button">Category Search</a>
        <a href="" class="mob-button">Find Attributes</a>
        <a href="#" class="mob-button">Find Brand</a>
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
                                    <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" class="img-responsive" alt="<?php echo $v['title']?>">
                                </a></div>
                            <dl>
                                <dt><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>"><?php echo substr($v['title'],0,50)?></a></dt>
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
    <div class="mob-ProductPrice">
        <h1>Product Price</h1>
        <div class="Product_Price_Details">
            <div class="mob-tr">
                <div class="Product-Name">Product Name</div>
                <div class="ProductAttribute">Voltage (v)</div>
                <div class="ProductAttribute"> Power (w)  </div>
                <div class="ProductAttribute">Price (US)</div>
            </div>
            <?php foreach($productPrice as $k=>$v){?>
            <div class="mob-tr">
                <div class="mob-Product-Name"><a title="<?php echo $v['title']?>" href="<?php echo company_url(site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl']),$v['username'])?>"><?php echo substr($v['title'],0,25)?></a></div>
                <div class="ProductAttribute" title="<?php echo $v['attr']['Voltage']?>"><?php echo substr($v['attr']['Voltage'],0,10)?></div>
                <div class="ProductAttribute" title="<?php echo $v['attr']['Power']?>"><?php echo substr($v['attr']['Power'],0,10)?></div>
                <div class="ProductAttribute"><?php echo $v['currency']." ".$v['minprice']?></div>
            </div>
            <?php }?>
            <div class="clear"></div>
        </div>
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
</div>