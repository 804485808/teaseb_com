
    <div class="mob-content">
        <div class="mob-productAttributes">
            <div class="AttributesLast">
                <span>Attributes</span>
                <?php foreach($attr as $k=>$v){?>
                <span><?php echo $k?>:</span>
                <ul class="productLast">
                    <?php foreach($v as $kk=>$vv){?>
                    <li><a href="<?php
                        echo site_url("sell_list/index/catid_".$catid."/".$thisUrl."_oid_".$vv['id']);
                        ?>"><?php echo $vv['value']."(".$vv['cnum'].")"?></a></li>
                    <?php }?>
                </ul>
                <?php }?>
            </div>
            <div class="AttributesMore"><b id="AttributesUp"><em class="fa fa-angle-double-down" id="AttributesDown"></em></b></div>
            <div class="clear"></div>
        </div>
        <div class="allProductLast">
            <?php foreach($sellList as $k=>$v){?>
            <div class="mob-product">
                <div class="mob-productImg"><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>">
                        <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" class="img-responsive" alt="<?php echo $v['subtitle']?>" title="<?php echo $v['subtitle']?>"></a></div>
                <div class="mob-productData">
                    <?php if($v['itemid']<1000000):?>
                        <h1 title="<?php echo $v['subtitle']?>"><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>">
                                <?php echo substr($v['title'],0,100)?></a>
                        </h1>
                    <?php else:?>
                        <h1 title="<?php echo $v['subtitle']?>"><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>">
                                <?php echo substr($v['subtitle'],0,100)?></a>
                            </h1>
                    <?php endif?>

                    <ul>
                        <li><b><?php echo $v['minprice']>0 ? $v['currency']." ".$v['minprice'] : "Negotiable";?></b></li>
                        <li><b><?php echo $v['minamount'],"/",plural($v['unit']);?>/(Min. Order)</b></li>
                        <?php
                        foreach(array_slice($v['attr'],0,10) as $kk=> $vv){
                            echo "<li title=".$vv."><i>".$kk.":</i>".$vv."</li>";
                        }
                        ?>

                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="mob-supplierData">
                    <h1><a href="<?php echo site_url("company/index/".$v['username'])?>"><?php echo $v['company']?></a> </h1>
                    <ul>
                        <li><i>Business Type:</i><?php echo $v['mode']?>  </li>
                        <li><i>Main Products:</i><?php echo substr($v['companySell'],0,50)?></li>
                        <li><i>Hot Markets:</i><?php echo substr($v['markets'],0,80)?></li>
                    </ul>
                </div>


                <div class="clear"></div>
            </div>
            <?php }?>
            <div class="mob-page">
                <a href="<?php echo $NowPage>2?site_url($mobPageUrl."/".($NowPage-1)*$page_size):site_url($mobPageUrl);?>" class="button button-primary button-pill button-small fl">Up Page</a>
                <span><?php echo $NowPage."/".$total_page?></span>
                <a href="<?php
                if($NowPage<$total_page) {
                    echo site_url($mobPageUrl . "/" . $NowPage * $page_size);
                }
                ;?>" class="button button-primary button-pill button-small fr">Next Page</a>
            </div>
        </div>
    </div>
    <a href="#" id="motors-to-top"><i class="fa fa-angle-up"></i></a>

</div>
<input type="hidden" id="AttributesLast">
<input type="hidden" id="topHeight">
<script src="js/mob_motors.js"></script>
<script>
    $(function()
    {
        var height = 0;
        var sheight = 0;
        var topHeight = 0;
        var spanHeight = 0;
        var i=0;
        $(".productLast").each(function (a, b) {
            if(a==0){
                topHeight = parseInt($(b).height())+10;
            }
            if(a==1){
                topHeight = topHeight + parseInt($(b).height())+10;
            }
            height = height+ parseInt($(b).height())+10;
        })

        $(".AttributesLast span").each(function (a, b) {
            sheight = sheight+ parseInt($(b).height())+2;
            if(a==0) {
                spanHeight = parseInt($(b).height())+2;
            }
        })


        $("#AttributesLast").val(sheight+height)
        $("#topHeight").val(topHeight+spanHeight*3)
        $(".AttributesLast").css('height',topHeight+spanHeight*3)
    }
    )
</script>