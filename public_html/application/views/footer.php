<?php if(!$mob){?>
<div class="Mobile-footer">
<?php } ?>
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
<footer>
    <div class="mob-footer">Copyright © 2015 motors-biz.com. All rights reserved. Designed by HK Netor LTD</div>
    <div class="mob-FollowUs">
        <div class="mob-share">
            <label>Follow Us :</label>
            <div class="motors-share" >
                <span class='st_facebook_large' displayText='Facebook'></span>
                <span class='st_twitter_large' displayText='Tweet'></span>
                <span class='st_pinterest_large' displayText='Pinterest'></span>
                <span class='st_googleplus_large' displayText='Google +'></span>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url('/skin/js/buttons.js');?>"></script>
        <script type="text/javascript">stLight.options({publisher: "28e5302c-35ba-4e7e-b338-be70a2c05454", doNotHash: true, doNotCopy: true, hashAddressBar: false});</script>
        <div class="clear"></div>
    </div>

</footer>
    <?php if(!$mob){?>
</div>
    <?php }?>
<a href="#" id="motors-to-top"><i class="fa fa-angle-up"></i></a>
</div>
<script src="<?php echo base_url('/skin/js/mob_motors.js')?>"></script>
</body>
</html>

<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//108.186.196.82/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', 68]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<noscript><p><img src="//108.186.196.82/piwik.php?idsite=68" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-68131536-1', 'auto');
    ga('send', 'pageview');

</script>