<div class="mob-content">
    <article>
        <h1><?php echo $newsDetail['title'];?></h1>
        <address>By <?php echo $newsDetail['author'];?> | Published on <?php echo $newsDetail['data']['M']." ".$newsDetail['data']['D'].",".$newsDetail['data']['Y'];?></address>
        <div class="mob-Info-share">
            <span class='st_facebook_large' displayText='Facebook'></span>
            <span class='st_twitter_large' displayText='Tweet'></span>
            <span class='st_pinterest_large' displayText='Pinterest'></span>
            <span class='st_googleplus_large' displayText='Google +'></span>
            <div class="mob-Info-like"><i></i><span><?php echo $newsDetail['hits'];?></span></div>
            <div class="clear"></div>
        </div>
        <section class="Info-DetailsContent">
            <address><?php echo $newsDetail['copyfrom'];?></address>
            <?php echo $newsDetail['content'];?>
        </section>
        <div class="mob-Related-Articles">
            <h2> Related Articles:</h2>
            <ul>
                <?php foreach($newsRelated as $k=>$v){?>
                <li><a href="<?php echo site_url("news/newsDetail/".$v['itemid'])?>" class="infoClick"><i>●</i><?php echo $v['title'];?></a></li>
                <?php }?>
            </ul>
        </div>
    </article>
    <div class="mob-Comments">
        <span>Comments<label>Comments(<?php echo $newsDetail['count']; ?>)</label></span>
        <textarea class="mob-textarea"></textarea>
        <button class="button button-primary button-rounded button-small">Publish</button>
        <div class="clear"></div>
    </div>
    <div class="mob-information-Comments">
        <?php foreach($newsDetail['newsReview'] as $k => $v){ ?>
            <div class="mob-CommentsDetails">
                <time><?php echo $v['time'];?></time>
                <span><b>mei dou:</b><?php echo $v['content'];?></span>
            </div>
        <?php }?>
    </div>

    <div class="mob-hotProduct">
        <h1>Recommended Products</h1>
        <div class="bd">
            <ul>
                <?php foreach($hot_pros as $k => $v){ ?>
                    <li>
                        <div class="mob-ProFeaturedImg"><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>"><img src="<?php echo site_url('mob_img/img'.$v['thumb'])?>" class="img-responsive"
                                                                         alt=""></a></div>

                        <span><a href="<?php echo site_url('sell_detail/index/'.$v['itemid'].'/'.$v['linkurl'])?>"><?php echo mb_substr($v['title'],0,35,'utf-8')?></a></span>

                    </li>
                <?php }?>
            </ul>

            <div class="clear"></div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $(".Info-DetailsContent p").each(function(){
            if($(this).find("span").html() == "&nbsp;")
            {
                $(this).find("span").remove();
                if($(this).html() == "")
                {
                    $(this).remove();
                }
            }
            $(this).find("img").addClass("img-responsive");
            $(this).addClass("Info-DetailsContent-p");
            $(this).find("span").not("strong span").addClass("Info-DetailsContent-p-span");
            $(this).find("strong").addClass("Info-DetailsContent-strong");
            $(this).find("strong span").addClass("Info-DetailsContent-p-strong");
        });

        for(var i=1;i<7;i++)
        {
            var cl = ".Info-DetailsContent h"+i;
            $(cl).each(function(){
                $(this).addClass("Info-DetailsContent-h3");
                $(this).find("span").addClass("Info-DetailsContent-h3");
            });
        }
        $("button").click(function(){
            var content = $(".mob-textarea").val();
            if(content) {
                $.ajax({
                    url: '<?php echo site_url("news/newsReview/".$newsDetail['itemid'])?>',
                    type: 'post',
                    data: {content: content},
                    success: function (data) {
                        window.location.reload();
                    }
                });
                $(".mob-textarea").val("");
            }
            else
            {
                alert("Content is empty!");
            }
        });
    });
</script>