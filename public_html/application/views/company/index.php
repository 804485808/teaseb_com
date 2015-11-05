
<div class="mob-content">
    <div class="company-details">
        <div class="supplier-nav">
            <a onclick="javascript:history.go(-1)" ><span><i class="mob-icon-left rotating"></i><b>Return</b><div class="clear"></div></span></a>
            <a href="#"><span><i class="mob-icon-email"></i><b>Contact Now</b><div class="clear"></div></span></a>
        </div>
        <div class="company-information">
            <h1><?php echo $companyDetail['company']?></h1>
            <ul>
                <li><i>Business Type:</i><?php echo $companyDetail['mode']?></li>
                <li><i>Main Products:</i><?php echo $companyDetail['markets']?></li>
                <li><i>Telephone:</i><?php echo $companyDetail['telephone']?> </i></li>
            </ul>
        </div>
        <div class="company-nav">
            <a href="<?php echo site_url('company/companyInfo/'.$companyDetail['username'])?>">Company Info<i class="mob-icon-right"></i></a>
            <a href="#">Product Categories<i class="mob-icon-right"></i></a>
        </div>
        <div class="supplierProductLast">
            <h1>Suppliers Recommended</h1>

            <?php foreach($companySell as $k=>$v){?>
            <div class="mob-companyProduct">
                <div class="company-ProductDetails">
                    <div class="mob-companyProductImg"><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>">
                            <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" alt="" class="img-responsive"></a></div>
                    <span><a><?php echo $v['itemid']<1000000?$v['title']:$v['subtitle']?></a></span>
                    <strong><?php echo $v['minprice']>0 ? $v['currency']." ".$v['minprice'] : "Negotiable";?></strong>
                    <strong><?php echo $v['minamount'],"/",plural($v['unit']);?>/(Min. Order)</strong>
                </div>
            </div>
            <?php }?>
            <div class="clear"></div>
        </div>

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
    <div class="mob-RelatedSearches">
        <h1>Related Searches</h1>
        <ul>
            <li><a href="#">240v Synchronous Motors 240v Synchronous Motors </a></li>
            <li><a href="#">240v Synchronous Motors </a></li>
            <li><a href="#">240v Synchronous Motors </a></li>
            <li><a href="#">240v Synchronous Motors </a></li>
            <li><a href="#">240v Synchronous Motors </a></li>
            <li><a href="#">240v Synchronous Motors </a></li>
        </ul>
        <div class="clear"></div>
    </div>

</div>

