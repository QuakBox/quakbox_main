<?php
	error_reporting(-1);
	 //error_reporting( E_ALL );
	 //ini_set('display_errors', 1);
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/apps.php');	
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/posts.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/status.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	$appsWidgetObjHome=new appsWidget();
	$postWidgetObjHome=new postWidget();
	$statusWidgetObjHome=new statusWidget();
	$objLookupClass=new lookup();
	$lookupWallID=$objLookupClass->getLookupKey('Wall Type', 'World'); 
	//$encryptedWallID=$QbSecurity->QB_AlphaID($lookupWallID);
	//echo "<pre>home page";
//print_r($lookupWallID);
//die();
	$QbSecurity = new QB_SqlInjection;
	$encryptedWallID = $QbSecurity->QB_AlphaID($lookupWallID);
	$member = new Member();
	$member1 = new member1();
	
	//echo "<pre>";
//print_r($encryptedWallID);
//die();
?>

           <!-- News Block-->
            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs" style="padding-left:0px;padding-right:0px;"> 
                    <div class="LeftPanel" >     			 
                    
                
                    <?php 
                    // @important: please dont chnage this variable, it is coming from inclues/qb_subheader1.php
                    $randomCountry = $randomCountriesResult[array_rand($randomCountriesResult )];
                    $countryID = $randomCountry['country_id'];
                    $countryTitle = $randomCountry['country_title'];
                    $isWorld = true;

                    include($_SERVER['DOCUMENT_ROOT'].'/yahoo_news_menu.php');
                    ?>
               </div>    
            </div> 
            
            
            <!-- World Icon in mobile-->
            <div class="col-lg-2 visible-xs">   
                <div style="text-align:center;" class="moduletable">
                    <img src="<?php echo SITE_URL ?>/images/world.png" style="padding: 5px; width: 200px; height: 200px;">
                    <div style="background:#C0C0C0;color:#fff; padding: 5px; margin-bottom: 5px;">WORLD</div>
                </div>
            </div>  
            
            
            <!-- Memo Block-->
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 NoSidepadding" >
			

                <div class="MemoBar">			
                 <?php print $statusWidgetObjHome->getStatusWidget($encryptedWallID,$lookupWallID);?>
                </div>

                <div class="wallvwe wordlwall">
                     <?php print $postWidgetObjHome->getPosts($encryptedWallID,'','get');?>       	
                    </div>
                    <?php if($postWidgetObjHome->getCountIntialPost()>9){?>
                    <div style="text-align: center; z-index: 99999; font-size: 25px; margin: 80px 0px 30px;" id="wall_loader"> <i class="fa fa-spinner fa-spin" style="margin-right: 5px;"></i>Loading ...
                    </div>
                    <?php }?>
                  
            </div>
            
            
            <!-- Ads -->
            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs" > 
                <div class="RightPanel"> 
				<?php 		
						
			$age=$member->get_member_age($_SESSION['SESS_MEMBER_ID']);
			$gender_value = $member1->select_member_meta_value($_SESSION['SESS_MEMBER_ID'],'gender');
			if($gender_value=='2'){
				$gender='Male';
			}else {
				$gender='FeMale';
			}
 ?>
 

<!--/*
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://quakbox.com/revive-adserver/www/delivery/...'
  * to
  *   'https://quakbox.com/revive-adserver/www/delivery/...'
  *
  * This noscript section of this tag only shows image banners. There
  * is no width or height in these banners, so if you want these tags to
  * allocate space for the ad before it shows, you will need to add this
  * information to the <img> tag.
  *
  * If you do not want to deal with the intricities of the noscript
  * section, delete the tag (from <noscript>... to </noscript>). On
  * average, the noscript tag is called from less than 1% of internet
  * users.
  */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://quakbox.com/revive-adserver/www/delivery/ajs.php':'http://quakbox.com/revive-adserver/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=1");
    document.write ("&amp;age=<?php echo $age;?>");
    document.write ("&amp;gender=<?php echo $gender;?>");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://quakbox.com/revive-adserver/www/delivery/ck.php?n=ac68672b&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://quakbox.com/revive-adserver/www/delivery/avw.php?zoneid=1&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=ac68672b' border='0' alt='' /></a></noscript>
                    <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?>
                </div>
            </div>
            
            
            <!-- world logo-->
            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs" >  
                <div   class="RightPanel"> 
                    <div style=" background:#E8E8E8;text-align:center;" class="moduletable">
                    <img src="<?php echo SITE_URL ?>/images/world.png" style="padding: 5px; width: 200px;height: 200px;">
                    <div style="background:#C0C0C0;color:#fff; padding: 5px; margin-bottom: 5px;">WORLD</div>
                    </div>
                <?php /* print $appsWidgetObjHome->getApps(); */ ?> 
                </div>
            </div> 
<!-- Modified by Naresh Shaw -->
            

<input type="hidden" id="twn" class="twn" value="<?php echo $encryptedWallID;?>"/>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/share.php');
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>
