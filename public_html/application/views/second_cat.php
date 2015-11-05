<div class="mob-content">
    <div class="pro-feiLei">
        <span>Categories</span>
        <ul class="ulLast">
            <?php foreach($second_cat as $j=>$u){ ?>
                <?php foreach($u as $h=>$j){?>
                    <li class="li"><a href="<?php echo site_url("sell_list/index/catid_".$j['catid']."/".$j['linkurl']);?>">
                            <?php echo $j['catname']."(".$j['item'].")";?></a></li>
                <?php }}?>
        </ul>
        <div class="mob-more"><b id="up"><em class="fa fa-angle-double-down" id="down"></em></b></div>
        <div class="clear"></div>
    </div>
    <div class="mob-allProduct mob-margin">
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
                    <?php foreach($hot_pros as $c){ ?>
                        <li>
                            <div class="mob-ProFeaturedImg"><a href="<?php echo site_url('sell_detail/index/'.
                                    $c['itemid'].'/'.$c['linkurl']);?>" target="_blank">
                                    <img src="<?php echo site_url('mob_img/img'.$c['thumb'])?>"
                                         class="img-responsive" alt="<?php echo $c['title'] ?>"></a></div>
                            <dl>
                                <dt><a title="<?php echo $c['title'];?>" href="<?php echo site_url('sell_detail/index/'.$c['itemid'].'/'.$c['linkurl']) ?>">
                                        <?php echo mb_substr($c['title'],0,50,'utf-8')?></a></dt>
                                <dd>Price：<b class="motors-public-color"><?php  echo $c['minprice']>0 ? $c['currency']." ".$c['minprice'] : "Negotiable"?></b> </dd>
                                <dd>MOQ：<b class="motors-public-color"><?php echo $c['minamount']."/".$c['unit']?></b></dd>
                                <dd>Region：<b class="motors-public-color"><?php echo $c['areaname']?></b></dd>
                            </dl>
                        </li>
                    <?php } ?>
                </ul>
                <ul>
                    <?php foreach($new_sell as $o){ ?>
                        <li>
                            <div class="mob-ProFeaturedImg">
                                <a href="<?php echo site_url('sell_detail/index/'.$o['itemid'].'/'.$o['linkurl']);?>" target="_blank">
                                    <img src="<?php echo site_url('mob_img/img'.$o['thumb'])?>>"
                                         class="img-responsive" alt=""></a></div>
                            <dl>
                                <dt><a title="<?php echo $o['subtitle'];?>" href="<?php echo site_url('sell_detail/index/'.$o['itemid'].'/'.$o['linkurl']);?>">
                                        <?php echo mb_substr($o['title'],0,50,'utf-8')?></a></dt>
                                <dd>Price：<b class="motors-public-color"><?php  echo $o['minprice']>0 ? $o['currency']." ".$o['minprice'] : "Negotiable"?></b> </dd>
                                <dd>MOQ：<b class="motors-public-color"><?php echo $o['minamount']."/".$o['unit']?></b></dd>
                                <dd>Region：<b class="motors-public-color"><?php echo $o['areaname']?></b></dd>
                            </dl>
                        </li>
                    <?php } ?>
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
                    <li class="on">Recommended</li>
                    <li>Exhibition </li>
                    <li>Purchase</li>
                </ul>
            </div>
            <div class="bd">
                <article>
                    <?php foreach($newsRecommend as $k=>$v) {?>
                        <section>
                            <div class="motors-Timg"><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>"
                                    <?php echo $v['title']?>><img src="<?php echo site_url('mob_img/img/'.$v['thumb'])?>"
                                                                  title="<?php echo $v['title']?>" alt="" class="img-responsive"></a></div>
                            <div class="mob-text">
                                <h1><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                        <?php echo mb_substr($v['title'],0,200,'utf-8')?></a></h1>
                                <h3><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                        <?php echo mb_substr($v['content'],0,200,'utf-8')?></a></h3>
                            </div>
                        </section>
                    <?php } ?>
                </article>
                <article>
                    <?php foreach($exhibition as $k=>$v) {?>
                        <section>
                            <div class="motors-Timg"><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>"
                                    <?php echo $v['title']?>><img src="<?php echo site_url('mob_img/img/'.$v['thumb'])?>"
                                                                  title="<?php echo $v['title']?>" alt="" class="img-responsive"></a></div>
                            <div class="mob-text">
                                <h1><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                        <?php echo mb_substr($v['title'],0,200,'utf-8')?></a></h1>
                                <h3><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                        <?php echo mb_substr($v['content'],0,200,'utf-8')?></a></h3>
                            </div>
                        </section>
                    <?php } ?>
                </article>
                <ul>
                    <?php foreach($newInquiry as $k=>$v){ ?>
                        <li><a href="" title="<?php echo $v['title']?>"><i>●</i><?php echo $v['title']?></a> </li>
                    <?php }?>
                </ul>

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
<input type="hidden" id="ulLast">
<input type="hidden" id="proTopHeight">
<script>
    $(function(){
        var proHeight = 0;
        var proSheight = 0;
        var ptoTopHeight = 0;
        var i=0;
        $(".li").each(function (a, b) {
            if(a==0){
                ptoTopHeight = parseInt($(b).height());
            }
            if(a==1){
                ptoTopHeight = ptoTopHeight + parseInt($(b).height());
            }
            proHeight = proHeight+ parseInt($(b).height()/2);
        });
        $("#ulLast").val(proSheight+proHeight)
        $("#proTopHeight").val(ptoTopHeight)
        $(".ulLast").css('height',ptoTopHeight)
    });
</script>

