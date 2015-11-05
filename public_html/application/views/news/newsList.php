<div class="mob-content">
       <div class="informationLast">
        <ul>
            <?php foreach($newsList as $k=>$v){?>
               <li>
                    <a href="<?php echo site_url('news/newsDetail/'.$v['itemid'])?>">
                        <h1><?php echo $v['title']?></h1>
                        <div class="mob-infoImg"><img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" alt="" class="img-responsive"></div>
                        <aside><?php echo substr(strip_tags($v['content']),0,300)."..."?></aside>
                    </a>
                </li>
            <?php }?>
       </ul>
           <div class="clear"></div>
           <div class="mob-page">
               <a href="<?php echo $page_num>2?site_url($base_url."/".($page_num-1)*$page_size):site_url($base_url);?>" class="button button-primary button-pill button-small fl">Up Page</a>
               <span><?php echo $page_num."/".$total_page?></span>
               <a href="<?php echo $page_num<$total_page?site_url($base_url."/".$page_num*$page_size):site_url($base_url."/".($total_page-1)*$page_size);?>" class="button button-primary button-pill button-small fr">Next Page</a>
           </div>
       </div>
    </div>