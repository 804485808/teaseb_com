
    <div class="mob-content">

        <!--Profile-Contact-->
        <div class="supplier-nav">
            <a onclick="javascript:history.go(-1)" ><span><i class="mob-icon-left rotating"></i><b>Return</b><div class="clear"></div></span></a>
            <a href="#"><span><i class="mob-icon-email"></i><b>Contact Now</b><div class="clear"></div></span></a>
        </div>

        <!--about-->
        <div class="about_box">
            <h3>About</h3>
            <ul>
                <li><?php echo $companyDetail['company']?></li>
                <li>Business Type: <span><?php echo $companyDetail['mode']?></span></li>
                <li>Main Products: <span><?php echo $companyDetail['markets']?></span></li>
                <li>Hot market: <span>North America; Mid East; Southeast Asia; Eastern Europe;
South America; Western Europe;</span></li>
            </ul>
            <h3>Company Contact Information</h3>
            <ul>
                <li>Telephone: <span><?php echo $companyDetail['telephone']?></span></li>
                <li>Address: <span><?php echo $companyDetail['address']?></span></li>
                <li>Website: <span><?php echo site_url("company/index/".$companyDetail['username'])?></span></li>
            </ul>
        </div>




