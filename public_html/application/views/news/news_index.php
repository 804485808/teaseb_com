<div class="mob-content">
    <div class="infoNav" id="infoNav">
        <div class="bd">
            <ul>
                <?php foreach($technologyDetail as $k=>$v) {?>
                <li><a href="<?php echo site_url("news/newsList/{$v['catid']}")?>"><?php echo $v['catname'];?></a></li>
                <?php }?>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <script>
        var Scroll = new iScroll('wrapper',{hScrollbar:false, vScrollbar:false,vScroll:false});
    </script>
    <div class="info-banner">
        <div class="info-bannerBox" id="infoBox">
            <div class="bd">
                <ul>
                    <?php foreach($newsHot as $k=>$v){?>
                    <li>
                        <a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                            <div class="info-pic" href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                <img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" /></div>
                            <span class="tit" href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>"><?php echo mb_substr($v['title'],0,60,'utf-8')?></span>
                        </a>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
    <div class="motors-Business info-border-top">
        <div class="motors-tabBusiness" id="MBbox">
            <div class="hd">
                <ul>
                    <li class="on">Most Read </li>
                    <li>Recommend</li>
                </ul>
            </div>
            <div class="bd">
                <article>
                    <?php foreach($newsHot as $k=>$v){?>
                    <section>
                        <div class="motors-Timg"><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                <img src="<?php echo $site['image_domain'].$v['thumb'];?>" title="<?php echo $v['title']; ?>" alt="" class="img-responsive"></a></div>
                        <div class="mob-text">
                            <h1><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>"><?php echo mb_substr($v['title'],0,60,'utf-8')?></a></h1>
                            <h3><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>"><?php echo mb_substr($v['content'],0,200,'utf-8')?></a></h3>
                        </div>
                    </section>
                    <?php }?>
                </article>
                <article>
                    <?php foreach($latestNews as $k=>$v){?>
                        <section>
                            <div class="motors-Timg"><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                    <img src="<?php echo $site['image_domain'].$v['thumb'];?>" title="<?php echo $v['title']; ?>" alt="" class="img-responsive">
                                </a></div>
                            <div class="mob-text">
                                <h1><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>"><?php echo mb_substr($v['title'],0,60,'utf-8')?></a></h1>
                                <h3><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>"><?php echo mb_substr($v['content'],0,200,'utf-8')?></a></h3>
                            </div>
                        </section>
                    <?php }?>
                </article>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <?php foreach($technologyDetail as $k => $v){ if($k%2==1){ ?>
        <div class="mobNews info-border-top">
            <div class="info-tabNews">
                <div class="hd">
                    <ul>
                        <li class="on technology_new"><?php echo $technologyDetail[$k]['catname'];?></li>
                        <li class="technology_new"><?php echo $technologyDetail[$k+1]['catname'];?></li>
                    </ul>
                </div>
                <div class="bd">
                    <ul class="technology" style="display: block;">
                        <?php foreach($technologyDetail[$k][$k] as $key=>$v){ if($key == 0){?>
                        <li>
                            <a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                <h1><?php echo mb_substr($v['title'],0,60,'utf-8')?></h1>
                                <div class="mob-infoImg"><img src="<?php echo $site['image_domain'].$v['thumb'];?>"
                                                              title="<?php echo $v['title']; ?>" alt="" class="img-responsive"></div>
                                <aside><?php echo mb_substr($v['content'],0,150,'utf-8')?></aside>
                            </a>
                        </li>
                        <?php }else{ ?>
                        <li><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>" class="infoClick">
                                <i>●</i><?php echo mb_substr($v['title'],0,60,'utf-8')?></a></li>
                        <?php }}?>
                        <li><a href="<?php echo site_url("news/newsList/{$technologyDetail[$k]['catid']}")?>">Click to Enter the Exhibition<i><em class="fa fa-angle-double-right"></em></i></a></li>
                    </ul>
                    <ul class="technology" style="display: none;">
                        <?php foreach($technologyDetail[$k+1][$k+1] as $key=>$v){ if($key == 0){?>
                            <li>
                                <a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                    <h1><?php echo mb_substr($v['title'],0,60,'utf-8')?></h1>
                                    <div class="mob-infoImg"><img src="<?php echo $site['image_domain'].$v['thumb'];?>"
                                                                  title="<?php echo $v['title']; ?>" alt="" class="img-responsive"></div>
                                    <aside><?php echo mb_substr($v['content'],0,150,'utf-8')?></aside>
                                </a>
                            </li>
                        <?php }else{ ?>
                            <li><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>" class="infoClick">
                                    <i>●</i><?php echo mb_substr($v['title'],0,60,'utf-8')?></a></li>
                        <?php }}?>
                        <li><a href="<?php echo site_url("news/newsList/{$technologyDetail[$k+1]['catid']}")?>">Click to Enter the Industry News<i><em class="fa fa-angle-double-right"></em></i></a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    <?php }}?>
    <?php foreach($newsDetail as $k => $v){ if($k%3==0){ ?>
    <div class="mobNews info-border-top">
        <div class="info-tabNews">
            <div class="hd">
                <ul>
                    <li class="on detail_new"><?php echo $newsDetail[$k]['catname'];?></li>
                    <li class="detail_new"><?php echo $newsDetail[$k+1]['catname'];?></li>
                    <li class="detail_new"><?php echo $newsDetail[$k+2]['catname'];?></li>
                </ul>
            </div>
            <div class="bd">

                <ul class="detail" style="display: block;">
                    <?php foreach($newsDetail[$k][$k] as $key=>$v){ if($key == 0){?>
                        <li>
                            <a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                <h1><?php echo mb_substr($v['title'],0,60,'utf-8')?></h1>
                                <div class="mob-infoImg"><img src="<?php echo $site['image_domain'].$v['thumb'];?>"
                                                              title="<?php echo $v['title']; ?>" alt="" class="img-responsive"></div>
                                <aside><?php echo mb_substr($v['content'],0,150,'utf-8')?></aside>
                            </a>
                        </li>
                    <?php }else{ ?>
                        <li><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>" class="infoClick">
                                <i>●</i><?php echo mb_substr($v['title'],0,60,'utf-8')?></a></li>
                    <?php }}?>
                    <li><a href="<?php echo site_url("news/newsList/{$newsDetail[$k]['catid']}")?>">Click to Enter the Principle<i><em class="fa fa-angle-double-right"></em></i></a></li>
                </ul>
                <ul class="detail" style="display: none;">
                    <?php foreach($newsDetail[$k+1][$k+1] as $key=>$v){ if($key == 0){?>
                        <li>
                            <a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                <h1><?php echo mb_substr($v['title'],0,60,'utf-8')?></h1>
                                <div class="mob-infoImg"><img src="<?php echo $site['image_domain'].$v['thumb'];?>"
                                                              title="<?php echo $v['title']; ?>" alt="" class="img-responsive"></div>
                                <aside><?php echo mb_substr($v['content'],0,150,'utf-8')?></aside>
                            </a>
                        </li>
                    <?php }else{ ?>
                        <li><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>" class="infoClick">
                                <i>●</i><?php echo mb_substr($v['title'],0,60,'utf-8')?></a></li>
                    <?php }}?>
                    <li><a href="<?php echo site_url("news/newsList/{$newsDetail[$k+1]['catid']}")?>">Click to Enter the Steps<i><em class="fa fa-angle-double-right"></em></i></a></li>
                </ul>
                <ul class="detail" style="display: none;">
                    <?php foreach($newsDetail[$k+2][$k+2] as $key=>$v){ if($key == 0){?>
                        <li>
                            <a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>">
                                <h1><?php echo mb_substr($v['title'],0,60,'utf-8')?></h1>
                                <div class="mob-infoImg"><img src="<?php echo $site['image_domain'].$v['thumb'];?>"
                                                              title="<?php echo $v['title']; ?>" alt="" class="img-responsive"></div>
                                <aside><?php echo mb_substr($v['content'],0,150,'utf-8')?></aside>
                            </a>
                        </li>
                    <?php }else{ ?>
                        <li><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>" class="infoClick">
                                <i>●</i><?php echo mb_substr($v['title'],0,60,'utf-8')?></a></li>
                    <?php }}?>
                    <li><a href="<?php echo site_url("news/newsList/{$newsDetail[$k+2]['catid']}")?>">Click to Enter the Equation<i><em class="fa fa-angle-double-right"></em></i></a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <?php }} ?>
</div>
<script type="text/javascript">
        $(function(){
            $(".technology_new").click(function(){
                var num = $(".technology_new").index($(this));
                if(num%2==1)
                {
                    $(this).prev().removeClass("on");
                    $(".technology").eq(num-1).attr("style","display: none;");
                }
                else
                {
                    $(this).next().removeClass("on");
                    $(".technology").eq(num+1).attr("style","display: none;");
                }
                $(".technology").eq(num).attr("style","display: block;");
                $(this).addClass("on");

            });
            $(".detail_new").click(function(){
                var detail_new = $(".detail_new");
                var detail = $(".detail");
                var num = detail_new.index($(this));
                if(num%3==2)
                {
                    $(this).prev().removeClass("on");
                    $(this).prev().prev().removeClass("on");
                    detail.eq(num-1).attr("style","display: none;");
                    detail.eq(num-2).attr("style","display: none;");
                }
                if(num%3==1)
                {
                    $(this).prev().removeClass("on");
                    $(this).next().removeClass("on");
                    detail.eq(num-1).attr("style","display: none;");
                    detail.eq(num+1).attr("style","display: none;");
                }
                if(num%3==0)
                {
                    $(this).next().removeClass("on");
                    $(this).next().next().removeClass("on");
                    detail.eq(num+1).attr("style","display: none;");
                    detail.eq(num+2).attr("style","display: none;");
                }
                detail.eq(num).attr("style","display: block;");
                $(this).addClass("on");

            });
        });
</script>
