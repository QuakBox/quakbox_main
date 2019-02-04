
<!doctype html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Video ads demo</title>
  <link rel="stylesheet" href="css/videoPlayerMain.css" type="text/css">
  <link rel="stylesheet" href="css/videoPlayer.theme1.css" type="text/css">
  <link rel="stylesheet" href="css/preview.css" type="text/css" media="screen"/>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="js/IScroll4Custom.js" type="text/javascript"></script>
  <script src='js/THREEx.FullScreen.js'></script>
  <script src="js/videoPlayer.js" type="text/javascript"></script>
  <script src="js/Playlist.js" type="text/javascript"></script>  
  
  
							   
</body>
  
  
</head>
<body>


  
  

   
    

    <a href="https://quakbox.com/watch.php?video_id=202" style="color:#993300;">
      <div class="video_title">Video upload</div>
    </a>
    <div id="videoplayerid202">
      <div data-state="loading" style="width: 400px; height: 250px;" class="videoPlayer">
        <video poster="https://quakbox.com/uploadedvideo/videothumb/p400x2251429844150VideoJBeatzFtPrincessEudMySuperstar102.png"
        autobuffer="false" class="videoPlayer">
          <source src="https://quakbox.com/uploadedvideo/new1430082255NickiMinajOnlyftDrakeLilWayneChrisBrown.mp4" />
        </video>
        <div style="display: none; opacity: 0;" class="preloader"></div>
        <div style="left: 1px; opacity: 1;" class="controls disabled">
          <div class="volumeTrack">
            <div class="volumeTrackProgress"></div>
          </div>
          <div style="display: none; opacity: 0; bottom: 20px;" class="toolTipVolume">
            <div class="toolTipVolumeText"></div>
            <div class="toolTipTriangle"></div>
          </div>
          <div class="timeElapsed">00:00</div>
          <div class="timeTotal">04:45</div>
          <div style="width: 308px; left: 46px;" class="videoTrack">
            <div style="width: 1.32434px;" class="videoTrackDownload"></div>
            <div style="width: 0px;" class="videoTrackProgress"></div>
          </div>
          <div style="opacity: 0; bottom: 51px; left: 36.4px; display: none;" class="toolTip">
            <div class="toolTipText">00:13</div>
            <div style="left: 19px; top: 18px;" class="toolTipTriangle"></div>
          </div>
        </div>
        <div style="opacity: 1;" class="playButtonScreen"></div>
        <div style="opacity: 0; display: none; bottom: 93px; left: 16px;" class="infoWindow">
          <div style="bottom: 0px;" class="infoBtnClose"></div>
          <p class="infoTitle">Oceans</p>
          <p class="infoText"></p>
        </div>
        <p style="opacity: 1;" class="nowPlayingText">Oceans</p>
        <div style="display: none; opacity: 0; width: 105px; top: 5px; left: 285px;" class="shareWindow">
          <div class="facebook"></div>
          <div class="twitter"></div>
          <div class="pinterest"></div>
          <div class="linkedin"></div>
          <div class="googlePlus"></div>
        </div>
        <div style="opacity: 0; display: none; bottom: 73.5px; left: 46px;" class="embedWindow">
          <div style="bottom: 0px;" class="embedBtnClose"></div>
          <p class="embedTitle">EMBED CODE:</p>
          <p style="opacity: 0.5;" class="embedText">&lt;iframe src=&quot;https://quakbox.com&quot; width=&quot;746&quot;
          height=&quot;420&quot; frameborder=&quot;0&quot; webkitAllowFullScreen mozallowfullscreen
          allowFullScreen&gt;&lt;/iframe&gt;</p>
        </div>
        <div style="cursor: pointer; top: 30px; right: 30px; opacity: 1;" class="logo"></div>
        <div style="display: none; left: 105px; bottom: 93px;" class="videoAdBox">
          <p class="adsTitle">Your video will begin in</p>
          <div class="timeLeft">00:00</div>
        </div>
        <div style="display: none; opacity: 0; bottom: 88px; left: 200px;" class="ads">
          <div style="bottom: 0px;" class="adClose"></div>
        </div>
      </div>
    </div>
    <script type="text/javascript" charset="utf-8">
                                                            $(document).ready(function($)
                                                            {
                                                                var videoidqw = &quot;videoplayerid202&quot;;
                                                                var title1 = &quot;Video upload&quot;;
                                                                var desc1 = &quot;&quot;;
                                                                var mp4videopath =
&quot;https://quakbox.com/uploadedvideo/new1430082255NickiMinajOnlyftDrakeLilWayneChrisBrown.mp4&quot;;                         
                                   
                                                                var thumb =
&quot;https://quakbox.com/uploadedvideo/videothumb/p400x2251429844150VideoJBeatzFtPrincessEudMySuperstar102.png&quot;;
                                                                var adsmp4videopath = &quot;https://quakbox.com/&quot;;      
                                                      
                                                                var ads = &quot;0&quot;;
                                                                if(ads == 1){
                                                                        var adsFlag = true;
                                                                }else {
                                                                        var adsFlag = false;
                                                                }
                                                                var click_url = &quot;&quot;;
                                                                
                                                                
                                                                var oggvideopath =
&quot;https://quakbox.com/uploadedvideo/new1429844150VideoJBeatzFtPrincessEudMySuperstar1.ogg&quot;;
                                                                var webmvideopath =
&quot;https://quakbox.com/uploadedvideo/new1429844150VideoJBeatzFtPrincessEudMySuperstar1.webm&quot;;
                                                                var adsoggvideopath = &quot;https://quakbox.com/&quot;;
                                                                var adswebmvideopath = &quot;https://quakbox.com/&quot;;     
                                              
                                                                
                                                                        
                                                                videoPlayer = $(&quot;#&quot;+videoidqw).Video({
                                                                    autoplay:false,
                                                                    autohideControls:4, 
                                                                    videoPlayerWidth:400,
                                                                    videoPlayerHeight:250,                                         
               
                                                                    posterImg:thumb,
                                                                    fullscreen_native:false,
                                                                    fullscreen_browser:true,
                                                                    restartOnFinish:false,
                                                                    spaceKeyActive:true,
                                                                    rightClickMenu:true,                                           
                
                                                                    
                                                                     embed:[{
                                                                        show:true,
                                                                        embedCode:&#39;&lt;iframe
src=&quot;https://quakbox.com&quot; width=&quot;746&quot; height=&quot;420&quot; frameborder=&quot;0&quot;
webkitAllowFullScreen mozallowfullscreen allowFullScreen&gt;&lt;\/iframe&gt;&#39;
                                                                    }],
                                                                    
                                                                    videos:[{
                                                                        id:0,
                                                                        title:&quot;Oceans&quot;,
                                                                        mp4:mp4videopath,
                                                                        webm:webmvideopath,
                                                                        ogv:oggvideopath,
                                                                        info:desc1,
                                                        
                                                                        popupAdvertisementShow:false,
                                                                        popupAdvertisementClickable:false,
                                                                       
popupAdvertisementPath:&quot;images/advertisement_images/ad2.jpg&quot;,
                                                                       
popupAdvertisementGotoLink:&quot;https://quakbox.com&quot;,
                                                                        popupAdvertisementStartTime:&quot;00:02&quot;,
                                                                        popupAdvertisementEndTime:&quot;00:10&quot;,
                                                        
                                                                        videoAdvertisementShow:adsFlag,
                                                                        videoAdvertisementClickable:true,
                                                                        videoAdvertisementGotoLink:click_url,
                                                                        videoAdvertisement_mp4:adsmp4videopath,
                                                                        videoAdvertisement_webm:adswebmvideopath,
                                                                        videoAdvertisement_ogv:adsoggvideopath
                                                                        
                                                                    }]
                                                                });
                                                        
                                                            });
                                                        
                                                          
</script>



 


						  
							  
							  
							  
 
 
 
  
 
  
  
</body>

</html>