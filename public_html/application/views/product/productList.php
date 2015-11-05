<div class="mob-content">
    <input type="hidden" value="11" class="top_cates_num">
    <div class="mob-categories">
        <?php foreach($top_cates as $k=>$v){?>
            <div  class="mob-last">
                <a href="<?php echo site_url("catalog/index/".$v['catid']."/".$v['linkurl'])?>">
                    <span><?php echo $v['catname'];?></span><i>›</i></a></div>
        <?php }?>
    </div>
</div>
<a href="#" id="motors-to-top"><i class="fa fa-angle-up"></i></a>
</div>
<script src="<?php echo base_url('/skin/js/mob_motors.js')?>"></script>
</body>
</html>
<script src="<?php echo base_url('/skin/js/dropload.min.js')?>"></script>
<script>

    // dropload
    var dropload = $('.mob-content').dropload({
        domUp : {
            domClass   : 'dropload-up',
            domRefresh : '<div class="dropload-refresh">↓Drop down</div>',
            domUpdate  : '<div class="dropload-update">↑Release update</div>',
            domLoad    : '<div class="dropload-load"><span class="loading"></span>Loading...</div>'
        },
        domDown : {
            domClass   : 'dropload-down',
            domRefresh : '<div class="dropload-refresh">↑Pull up more</div>',
            domUpdate  : '<div class="dropload-update">↓Release loading</div>',
            domLoad    : '<div class="dropload-load"><span class="loading"></span>Loading...</div>'
        },
        loadUpFn : function(me){
            var top_cates_num = $(".top_cates_num").val();
            $.ajax({
                url: '<?php echo site_url("products/ajax_product_list_top")?>',
                type: 'post',
                data: {top_cates_num: top_cates_num},
                dataType: 'json',
                success: function(data){
                    var result = '';
                    for(var i = 0; i < data.length; i++){
                        result +=   '<div  class="mob-last"><a href="/catalog/index/'+data[i]['catid']+"/"+data[i]['linkurl']+'.html"><span>'+data[i]['catname']+'</span><i>›</i></a></div>';
                    }
                    setTimeout(function(){
                        $('.mob-categories').html('');
                        $('.mob-categories').prepend(result);
                        me.resetload();
                    },1000);
                },
                error: function(xhr, type){
                    alert('Ajax error!');
                    me.resetload();
                }
            });
        },
        loadDownFn : function(me){
            var top_cates_num = $(".top_cates_num").val();
            $.ajax({
                url: '<?php echo site_url("products/ajax_product_list")?>',
                type: 'post',
                data: {top_cates_num: top_cates_num},
                dataType: 'json',
                success: function(data){
                    var result = '';
                    for(var i = 0; i < data.length; i++){
                        result +=   '<div  class="mob-last"><a href="/catalog/index/'+data[i]['catid']+"/"+data[i]['linkurl']+'.html"><span>'+data[i]['catname']+'</span><i>›</i></a></div>';
                    }
                    $(".top_cates_num").val(parseInt(top_cates_num)+parseInt(data.length));
                    setTimeout(function(){
                        $('.mob-categories').append(result);
                        me.resetload();
                    },1000);
                },
                error: function(xhr, type){
                    alert('Ajax error!');
                    me.resetload();
                }
            });
        }
    });
</script>
