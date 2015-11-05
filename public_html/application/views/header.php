<!DOCTYPE html>
    <html>
    <head lang="en">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=0 "/>
        <title><?php echo $title;?></title>
        <meta name="description" content="<?php echo $description?>">
        <link rel="stylesheet"  href="<?php echo base_url('/skin/css/bootstrap.css"/>')?>
        <link rel="stylesheet"  href="<?php echo base_url('/skin/css/font-awesome.css')?>"/>
        <link rel="stylesheet"  href="<?php echo base_url('/skin/css/buttons.css')?>"/>
        <link rel="stylesheet"  href="<?php echo base_url('/skin/css/mob_motors.css')?>"  />
        <link rel="stylesheet"  href="<?php echo base_url('/skin/css/dropload.min.css')?>"  />
        <script  src="<?php echo base_url('/skin/js/jquery.min.js')?>"></script>
        <script  src="<?php echo base_url('/skin/js/TouchSlide.1.1.js')?>"></script>
        <script  src="<?php echo base_url('/skin/js/bootstrap.js')?>"></script>
        <script  src="<?php echo base_url('/skin/js/jquery.rotate.min.js')?>"></script>
        <!--[if lt IE 9]>
        <script src="<?php echo base_url('/skin/js/html5shiv.min.js')?>"></script>
        <script src="<?php echo base_url('/skin/js/respond.min.js')?>"></script>
        <![endif]-->

        <link rel="canonical" href="<?php echo $pc_url?>" >
</head>
    <body>
    <div class="mob-body" >
    <?php if(!$mob){?>
        <div class="mob-header">
            <div class="mob-btn-left" id="proNav">
                <i class="fa fa-th mob-fa " id="proIcon" ></i>
            </div>
            <div class="mob-btn-right" >
                <i class="fa fa-search mob-right"></i>
            </div>
            <div class="mob-nav mob-Location">
                <div class="mob-productLi">
                    <a  href="/">
                        <i class="backImg_01"></i>
                        <span>Home</span>
                    </a>

                </div>
                <div class="mob-productLi">
                    <a href="<?php echo site_url('products/index')?>">
                        <i class="backImg_02"></i>
                        <span>Products</span>
                    </a>
                </div>
                <div class="mob-productLi">
                    <a href="<?php echo site_url('news/index')?>">
                        <i class="backImg_03"></i>
                        <span>Information</span>
                    </a>

                </div>
                <div class="mob-productLi">
                    <a href="<?php echo site_url('company/suppliers')?>">
                        <i class="backImg_04"></i>
                        <span>Suppliers</span>
                    </a>
                </div>
                <div class="mob-productLi">
                    <a href="<?php echo site_url('news/newsList/28')?>">
                        <i class="backImg_05"></i>
                        <span>Exhibition</span>
                    </a>
                </div>
                <div class="mob-productLi">
                    <a href="#">
                        <i class="backImg_06"></i>
                        <span>My Center</span>
                    </a>
                </div>
                <div class="mob-productLi"></div>
                <div class="mob-productLi"></div>
                <div class="clear"></div>
            </div>
            <div class="mob-proName"><?php echo $header_name;?></div>
            <div class="mob-motors-sousuo mob-position">
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
                    <form action="<?php echo site_url("search/".$kw);?>" method="post" id="fast_search">
                    <div class="mob-motors-text">
                        <input type="text" name="input_text" class="mob-motors-input">
                    </div>
                        </form>
                </div>
                <div class="mob-motors-btnsearch" id="search"><i class="fa fa-search fa-lg motors-hidden"></i></div>
                <div class="clear"></div>

            </div>
            <div class="clear"></div>
        </div>

<script type="text/javascript">
    $("#search").click(function(){
        $("#fast_search").submit();
    })
</script>

            <?php }?>