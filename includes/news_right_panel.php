<!--
News Right Panel 
Created By Yasser Hossam and Mushira Ahmad
-->

<div style='position:fixed;'>
        <!-- Country Flag -->
        <div class="panel panel-primary nopadding" style="border: 0;">
            <div class="panel-heading"  style="height: 20px;padding: 1px;"><center><?php echo strtoupper($res['country_title']);?></center></div>
          <div class="panel-body nopadding">
              <center><img alt='<?php echo strtoupper($res['country_title']);?>' src='<?php  echo "images/Flags/flags_new/flags/".strtolower($res['code']).".png";?>' style='zoom: 2;display: block;margin: auto;height: auto; max-height: 100%; width: auto;max-width: 100%;'/></center>
          </div>
        </div> 
        <!-- Ads Panel-->
        <div class="panel panel-primary nopadding" style="border: 0;">
            <div class="panel-heading"  style="height: 20px;padding: 1px;">Partners <div style="float: right !important;"><a href="/add_ads.php" style="color:white">Create Ads</a></div></div>
              <div class="panel-body nopadding">
                <?php include 'ads_column_posts.php';?>
              </div>
        </div> 
</div>