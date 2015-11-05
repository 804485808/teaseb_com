<div class="mob-content">
    <div class="mob-sup-productAttributes">
        <div class="sup-AttributesLast">
            <span>Attributes</span>
            <span>Categories:</span>
            <ul class="sup-productLast">
                <?php foreach($category_type as $v){ ?>
                    <li><a href="<?php echo site_url("company/suppliers/Category_{$v['catid']}_{$tid}");?>"
                           title="<?php echo $v['catname'];?>"><?php echo $v['catname'];?> <i>(<?php echo $v['num']; ?>)</i></a></li>
                <?php } ?>
            </ul>
            <span>Hot Markets:</span>
            <ul class="sup-productLast">
                <?php foreach($markets_type as $k => $v){ ?>
                    <li><a href="<?php echo site_url("company/suppliers/Markets_{$k}_{$tid}");?>" title="<?php echo $k;?>" rel="nofollow"> <?php echo $k;?> <i>(<?php echo $v;?>)</i></a></li>
                <?php } ?>
            </ul>
            <span>Business Types:</span>
            <ul class="sup-productLast">
                <?php foreach($business_type as $v){ ?>
                    <li><a title="<?php echo $v['mode'];?>" href="<?php echo site_url("company/suppliers/Business_{$v['mode']}_{$tid}");?>" rel="nofollow"><?php echo mb_substr($v['mode'],0,20,'utf-8')?> <i>(<?php echo $v['@count'];?>)</i></a></li>
                <?php } ?>
            </ul>
            <span>Annual Revenue:</span>
            <ul class="sup-productLast">
                <?php foreach($volume_type as $v){ ?>
                    <li><a title="<?php echo $v['volume'];?>" href="<?php echo site_url("company/suppliers/Volume_{$v['volume']}_{$tid}");?>" rel="nofollow"><?php echo mb_substr($v['volume'],0,20,'utf-8')?> <i>(<?php echo $v['@count'];?>)</i></a></li>
                <?php } ?>

            </ul>
            <span>Countries:</span>
            <ul class="sup-productLast">
                <?php foreach(array_slice($country_type,0,20) as $v){ ?>
                    <li><a title="<?php echo $v['name'];?>" href="<?php echo site_url("company/suppliers/Country_{$v['areaid']}_{$tid}");?>" rel="nofollow"><?php echo mb_substr($v['name'],0,20,'utf-8')?> <i>(<?php echo $v['@count'];?>)</i></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="sup-More"><b id="supUp"><em class="fa fa-angle-double-down" id="supDown"></em></b></div>
        <div class="clear"></div>
    </div>

    <div class="allSupplierLast">
            <?php foreach($list as $k => $v){?>
            <div class="mob-SupplierLast">
                <div class="mob-SupplierDetails">
                    <h1><a href="<?php echo company_url(site_url(''),$v['username']);?>"><?php echo $v['company'] ?></a></h1>
                    <span><i></i>Audited Supplier</span>
                    <ul>
                        <li><i>Business Type:</i><b><?php echo $v['mode'] ?></b></li>
                        <li><i>Main Products:</i><b><?php echo $v['business'] ?></b></li>
                        <li><i>Location:</i><b><?php echo $v['markets'] ?></b></li>
                        <li><i>Total Annual Sales Volume:</i><b><?php echo $v['volume'] ?></b></li>
                        <li><i>Top3 market:</i><b><?php echo $v['export'] ?></b></li>
                    </ul>
                </div>
                <div class="mob-hotProduct">
                    <div class="bd">
                        <ul>
                            <?php foreach($v['sell'] as $k=>$value){?>
                                <li>
                                    <div class="mob-ProFeaturedImg"><a href="<?php echo site_url('sell_detail/index/'.$value['itemid'].'/'.$value['linkurl'])?>">
                                            <img src="<?php echo site_url('mob_img/img'.$value['thumb'])?>" class="img-responsive" alt=""></a></div>

                                    <span><a href="<?php echo site_url('sell_detail/index/'.$value['itemid'].'/'.$value['linkurl'])?>" title="<?php echo $value['title']?>">
                                            <?php echo mb_substr($value['title'],0,40,'utf-8')?></a></span>

                                </li>
                            <?php }?>
                        </ul>

                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <?php }?>
        <div class="mob-page">
            <a href="<?php echo $page_num>2?site_url($base_url."/".($page_num-1)*$page_size):site_url($base_url);?>" class="button button-primary button-pill button-small fl">Up Page</a>
            <span><?php echo $page_num."/".$total_page?></span>
            <a href="<?php echo site_url($base_url."/".$page_num*$page_size);?>" class="button button-primary button-pill button-small fr">Next Page</a>
        </div>
        </div>
        <div class="mob-RelatedSearches">
            <h1>Related Searches</h1>
            <ul>
                <?php
                $totalkw=count($keywords)-1;
                foreach($keywords as $w=>$q){ ?>
                    <li><a href="<?php echo main_url(site_url("slist/index/{$q['id']}/{$q['linkurl']}"))?>" title="<?php echo $q['tag']?>"><?php echo mb_substr($q['tag'],0,22,"utf-8")?></a> </li>
                <?php }?>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
<input type="hidden" id="sup-AttributesLast">
<input type="hidden" id="sup-topHeight">
<script>
    $(function()
        {
            var supHeight = 0;
            var supsheight = 0;
            var suptopHeight = 0;
            var supspanHeight = 0;
            var i=0;
            $(".sup-productLast").each(function (a, b) {
                if(a==0){
                    suptopHeight = parseInt($(b).height())+12;
                }
                if(a==1){
                    suptopHeight = suptopHeight + parseInt($(b).height())+12;
                }
                supHeight = supHeight+ parseInt($(b).height())+12;
            })

            $(".sup-AttributesLast span").each(function (a, b) {
                supsheight = supsheight+ parseInt($(b).height())+2;
                if(a==0) {
                    supspanHeight = parseInt($(b).height())+2;
                }
            })


            $("#sup-AttributesLast").val(supsheight+supHeight)
            $("#sup-topHeight").val(suptopHeight+supspanHeight*3)
            $(".sup-AttributesLast").css('height',suptopHeight+supspanHeight*3)
        }
    )
</script>
