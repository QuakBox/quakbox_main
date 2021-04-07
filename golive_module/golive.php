<?php 
	
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');		
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/video-time.php');
	
	$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	
	$objMember = new member1();
	
	$video_id = $_REQUEST['video_id'];
	 
	if(!(empty($video_id)||($qbValidation->qbIntegerCheck($video_id))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
           	$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$video_id = $QbSecurity->qbClean($_REQUEST['video_id'], $con);
	$video_id=htmlspecialchars(trim($video_id));
			$msql = mysqli_query($con, "select * from member where member_id = '$session_member_id'");
	$mres_new = mysqli_fetch_array($msql);	
	//echo "<pre>";
	//print_r($mres_new['username']);
	//die();
	$mresUsername = $mres_new['username'];
	$mresPic=$objMember->select_member_meta_value($mres_new['member_id'],'current_profile_image');
	
	if($mresPic){			
		$mresPic=SITE_URL.'/'.$mresPic;	
	}
	else{
		$mresPic=SITE_URL.'/images/default.png';
	}
	

	

	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
?>




        <script>
            if(!location.hash.replace('#', '').length) {
                location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
                location.reload();
            }
        </script>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		
       <!--  Developed by Naresh Shaw -->
  
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <!--<link rel="stylesheet" href="https://cdn.webrtc-experiment.com/style.css">-->
		<script src="js/record-video-and-audio.js"></script>
		 <script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
		 


		  <style>
    body,
   
    
    
    </style>
	<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: rgba(0,0,0,0.4);
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: rgba(0,0,0,0.4);
  color: white;
}
</style> 
</style>

        <style>
            audio, video {
                -moz-transition: all 1s ease;
                -ms-transition: all 1s ease;

                -o-transition: all 1s ease;
                -webkit-transition: all 1s ease;
                transition: all 1s ease;
                vertical-align: top;
                width: 100%;
            }

            input {
                border: 1px solid #d9d9d9;
                border-radius: 1px;
                font-size: 2em;
                margin: .2em;
                width: 50%;
            }

            select {
                border: 1px solid #d9d9d9;
                border-radius: 1px;
                height: 50px;
                margin-left: 1em;
                margin-right: -12px;
                padding: 1.1em;
                vertical-align: 6px;
                width: 50%;
            }

            .setup {
                border-bottom-left-radius: 0;
                border-top-left-radius: 0;
                font-size: 102%;
                height: 47px;
                margin-left: 0px;
                margin-top: 8px;
                position: absolute;
            }

          
        </style>
        

        <!-- This Library is used to detect WebRTC features -->
        <script src="https://cdn.webrtc-experiment.com/DetectRTC.js"></script>

        <script src="js/socket.io.js"> </script>
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script src="https://cdn.webrtc-experiment.com/IceServersHandler.js"></script>
        <script src="https://cdn.webrtc-experiment.com/CodecsHandler.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RTCPeerConnection-v1.5.js"> </script>
        <script src="https://cdn.webrtc-experiment.com/webrtc-broadcasting/broadcast.js"> </script>
    </head>


<!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Webcam stream info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <div class="dropdown">
         <p>Title : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="videoTitle" name="videoTitle" value="" /></p>
          <div class="dropdown-menu-privacy" aria-labelledby="dropdownMenu1">
           <p>Privacy : <select name="privacy" id="privacy">
		   <option value="0">Public</option>
		   <option value="1">Private</option> 
		   </select></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="enableGolive();">Save changes</button>
      </div>
    </div>
  </div>
</div>        

<div class="insideWrapper container">
    <div class="col-lg-8 col-md-8 col-sm-8">


        <article>
            

            <!-- copy this <section> and next <script> -->
            <section class="experiment">
			
                <section>
                    <select id="broadcasting-option" style="display:none;">
                        <option>Audio + Video</option>
                        <option>Only Audio</option>
                        <option>Screen</option>
                    </select>
                    <input type="text" id="broadcast-name" value="<?php echo $mresUsername;?>" style="display:none;">
                    <span style="float:left;"><button id="setup-new-broadcast" class="setup btn btn-primary" data-toggle="modal" data-target="#exampleModal" disabled >Go Live</button></span>
				<span id="end-stream" style="float:right;display:none;"><button class="setup" id="stop" disabled>End Stream</button></span>
                </section><br /><br /><br />
			

                <!-- list of all available broadcasting rooms -->
                <table style="width: 100%;" id="rooms-list"></table>

                <!-- local/remote videos container -->
                <div id="videos-container"></div>
				
            </section>
			
			<main>
    
    <div class="row">
      <!--<figure>
        <video id="live" width="320"></video><br />
        <caption>live preview</caption>
      </figure>-->
      <!--<figure>
        <video id="recording" controls width="320"></video><br />
        <caption>recorded clip</caption>
      </figure>-->
	  <!--  Developed by Naresh Shaw -->
    </div>
  </main>

            <script>
                
				 var mimeType = 'video/webm';
            var fileExtension = 'webm';
            var type = 'video';
            var recorderType;
            var defaultWidth;
            var defaultHeight;
			var LiveVideourl ;
			//fileName = Math.round(Math.random() * 99999999) + 99999999 ;
			function PostBlob(videoBlob, fileName , file) {
			//var form = document.getElementById('myForm');
			var title = document.getElementById('videoTitle').value;
			var privacy = document.getElementById('privacy').value;
			var myFormData = { filename : fileName, 'video-blob' : videoBlob, 'LiveVideourl' : LiveVideourl, 'videoTitle' : title ,'live_video_privacy' : privacy};
			//alert(LiveVideourl); 
    var formData = new FormData();
    formData.append('filename', fileName);
   // formData.append('audio-blob', audioBlob);
    formData.append('video-blob', videoBlob, file);
    formData.append('LiveVideourl', LiveVideourl);
    formData.append('videoTitle', title);
    formData.append('live_video_privacy', privacy);  
	for (var key in formData) {
    console.log(key, formData[key]);
    //formData.append(key, myFormData[key]);
}

/*for (var key in formData) {
    console.log(key, formData[key]);
    formData.append(key, formData[key]);
}*/
	document.getElementById('loader').style.display ='block';
    xhr('golivesave.php', formData, function(ffmpeg_output) {
       // document.querySelector('h1').innerHTML = ffmpeg_output.replace(/\\n/g, '<br />');
       // preview.src = 'uploads/' + fileName + '-merged.webm';
        //preview.play();
        //preview.muted = false;
		//var last_video_id = request.responseText;
		//console.log(request.responseText); 
		document.getElementById('loader').style.display ='none';
		window.location.href = "https://quakbox.com/watch.php?video_id="+ffmpeg_output;
    });
  
}
function enableGolive()
{
	document.getElementById('setup-new-broadcast').disabled = false;
	 $('#exampleModal').modal('hide');
}
function createLiveFeature()
{
	//var windowLocation = window.location;
	//console.log(windowLocation);
	//document.getElementById('windowLocation').value = windowLocation;
	var title = document.getElementById('videoTitle').value;
	var privacy = document.getElementById('privacy').value;
	
	var myFormData = { start : 1, 'loc' : document.URL, 'title' : title, 'privacy' : privacy};
    var formData = new FormData();
	for (var key in myFormData) {
    //console.log(key, myFormData[key]);
    formData.append(key, myFormData[key]);
}
	xhr('goliveupdate.php', formData,  function(ffmpeg_output) {
       // document.querySelector('h1').innerHTML = ffmpeg_output.replace(/\\n/g, '<br />');
       // preview.src = 'uploads/' + fileName + '-merged.webm';
        //preview.play();
        //preview.muted = false;
		//console.log(request.responseText));
		if(ffmpeg_output !='')
		{
			console.log("response live video id is :"+ ffmpeg_output);
			LiveVideourl = ffmpeg_output;
		}	
	
		
    });
	
}
function StopLiveFeature()
{
	var myFormData = { start : 0, 'loc' : document.URL};
    var formData = new FormData();
	for (var key in myFormData) {
    //console.log(key, myFormData[key]);
    formData.append(key, myFormData[key]);
}
	xhr('goliveupdate.php', formData,  function(ffmpeg_output) {
       // document.querySelector('h1').innerHTML = ffmpeg_output.replace(/\\n/g, '<br />');
       // preview.src = 'uploads/' + fileName + '-merged.webm';
        //preview.play();
        //preview.muted = false;
		//console.log(request.responseText));
		
    });
}
function xhr(url, data, callback) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            callback(request.responseText);
        }
    };
    request.open('POST', url);
    request.send(data);
}
function xhrGet(url,  callback) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            callback(request.responseText);
        }
    };
    request.open('GET', url);
    request.send();
}
function getFileName(fileExtension) {
                var d = new Date();
                var year = d.getUTCFullYear();
                var month = d.getUTCMonth();
                var date = d.getUTCDate();
                return 'RecordRTC-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
            }
                var config = {
                    openSocket: function(config) {
                        var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';
                        var SIGNALING_SERVER = 'https://webrtcweb.com:9559/';

                        config.channel = config.channel || location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
                        var sender = Math.round(Math.random() * 999999999) + 999999999;

                        io.connect(SIGNALING_SERVER).emit('new-channel', {
                            channel: config.channel,
                            sender: sender
                        });

                        var socket = io.connect(SIGNALING_SERVER + config.channel);
                        socket.channel = config.channel;
                        socket.on('connect', function () {
                            if (config.callback) config.callback(socket);
                        });

                        socket.send = function (message) {
                            socket.emit('message', {
                                sender: sender,
                                data: message
                            });
                        };

                        socket.on('message', config.onmessage);
                    },
                    onRemoteStream: function(htmlElement) {
                        videosContainer.appendChild(htmlElement);
                        //rotateInCircle(htmlElement);
                    },
                    onRoomFound: function(room) {
                        var alreadyExist = document.querySelector('button[data-broadcaster="' + room.broadcaster + '"]');
                        if (alreadyExist) return;

                        if (typeof roomsList === 'undefined') roomsList = document.body;

                        var tr = document.createElement('tr');
                        tr.innerHTML = '<td><strong>' + room.roomName + '</strong> is broadcasting his media!</td>' +
                            '<td><button class="join">Watch Stream</button></td>';
                        roomsList.appendChild(tr);
						$('#exampleModal').modal('hide');  
                        var joinRoomButton = tr.querySelector('.join');
                        joinRoomButton.setAttribute('data-broadcaster', room.broadcaster);
                        joinRoomButton.setAttribute('data-roomToken', room.broadcaster);
                        joinRoomButton.onclick = function() {
                            this.disabled = true;

                            var broadcaster = this.getAttribute('data-broadcaster');
                            var roomToken = this.getAttribute('data-roomToken');
                            broadcastUI.joinRoom({
                                roomToken: roomToken,
                                joinUser: broadcaster
                            });
                            hideUnnecessaryStuff();
                        };
                    },
                    onNewParticipant: function(numberOfViewers) {
                        document.title = 'Viewers: ' + numberOfViewers;
                    },
                    onReady: function() {
                        console.log('now you can open or join rooms');
                    }
                };

                function setupNewBroadcastButtonClickHandler() {
				//startRecording();
				//liveStream = stream;
                    document.getElementById('broadcast-name').disabled = true;
                    document.getElementById('setup-new-broadcast').disabled = true;
                    document.getElementById('end-stream').style.display = 'block';
					
                    DetectRTC.load(function() {
                        captureUserMedia(function() {
                            var shared = 'video';
                            if (window.option == 'Only Audio') {
                                shared = 'audio';
                            }
                            if (window.option == 'Screen') {
                                shared = 'screen';
                            }

                            broadcastUI.createRoom({
                                roomName: (document.getElementById('broadcast-name') || { }).value || 'Anonymous',
                                isAudio: shared === 'audio'
                            });
                        });
                        hideUnnecessaryStuff();
                    });
                }

                function captureUserMedia(callback) {
                    var constraints = null;
                    window.option = broadcastingOption ? broadcastingOption.value : '';
					//console.log("option is: "+ option);
                    if (option === 'Only Audio') {
                        constraints = {
                            audio: true,
                            video: false
                        };

                        if(DetectRTC.hasMicrophone !== true) {
                            alert('DetectRTC library is unable to find microphone; maybe you denied microphone access once and it is still denied or maybe microphone device is not attached to your system or another app is using same microphone.');
                        }
                    }
                    if (option === 'Screen') {
                        var video_constraints = {
                            mandatory: {
                                chromeMediaSource: 'screen'
                            },
                            optional: []
                        };
                        constraints = {
                            audio: false,
                            video: video_constraints
                        };

                        if(DetectRTC.isScreenCapturingSupported !== true) {
                           alert('DetectRTC library is unable to find screen capturing support. You MUST run chrome with command line flag "chrome --enable-usermedia-screen-capturing"');
                        }
                    }

                    if (option != 'Only Audio' && option != 'Screen' && DetectRTC.hasWebcam !== true) {
                        alert('DetectRTC library is unable to find webcam; maybe you denied webcam access once and it is still denied or maybe webcam device is not attached to your system or another app is using same webcam.');
                    }

                    var htmlElement = document.createElement(option === 'Only Audio' ? 'audio' : 'video');

                    htmlElement.muted = true;
                    htmlElement.volume = 0;

                    try {
                        htmlElement.setAttributeNode(document.createAttribute('autoplay'));
                        htmlElement.setAttributeNode(document.createAttribute('playsinline'));
                        htmlElement.setAttributeNode(document.createAttribute('controls'));
                    } catch (e) {
                        htmlElement.setAttribute('autoplay', true);
                        htmlElement.setAttribute('playsinline', true);
                        htmlElement.setAttribute('controls', true);
                    }

                    var mediaConfig = {
                        video: htmlElement,
                        onsuccess: function(stream) {
							liveStream = stream;
							var liveVideo = document.getElementById('live');
						   // liveVideo.src = URL.createObjectURL(stream);
						   // liveVideo.play();

							//recordButton.disabled = false;
							//recordButton.addEventListener('click', startRecording);
							startRecording();
							stopButton.addEventListener('click', stopRecording);
							//setupNewBroadcastButtonClickHandler();	
                            config.attachStream = stream;
                            
                            videosContainer.appendChild(htmlElement);
                          //  rotateInCircle(htmlElement);
                            
                            callback && callback();
                        },
                        onerror: function() {
                            if (option === 'Only Audio') alert('unable to get access to your microphone');
                            else if (option === 'Screen') {
                                if (location.protocol === 'http:') alert('Please test this WebRTC experiment on HTTPS.');
                                else alert('Screen capturing is either denied or not supported. Are you enabled flag: "Enable screen capture support in getUserMedia"?');
                            } else alert('unable to get access to your webcam');
                        }
                    };
                    if (constraints) mediaConfig.constraints = constraints;
                    getUserMedia(mediaConfig);
                }

                var broadcastUI = broadcast(config);

                /* UI specific */
                var videosContainer = document.getElementById('videos-container') || document.body;
                var setupNewBroadcast = document.getElementById('setup-new-broadcast');
                var roomsList = document.getElementById('rooms-list');

                var broadcastingOption = document.getElementById('broadcasting-option');

                if (setupNewBroadcast) setupNewBroadcast.onclick = setupNewBroadcastButtonClickHandler;

                function hideUnnecessaryStuff() {
                    var visibleElements = document.getElementsByClassName('visible'),
                        length = visibleElements.length;
                    for (var i = 0; i < length; i++) {
                        visibleElements[i].style.display = 'none';
                    }
                }

                function rotateInCircle(video) {
                    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                    setTimeout(function() {
                        video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                    }, 1000);
                }

            </script>

            <section class="experiment">
              
            </section>

            <section class="experiment"><small id="send-message"></small></section>
        </article>
</div>
    <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs"> 
		<span id="loader" name="loader" style="display:none;top: 130px;
position: relative;">Please wait for processing .<img src="../images/loader.gif" /></span>
		</div>
</div>





<!-- Modified by Naresh Shaw -->


<?php //include_once 'share.php';?>
<?php //include_once 'smiley.php';?>
<?php
	//include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
}
?>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(window).on('load',function(){
		//alert('i m here');
        $('#exampleModal').modal('show');
    });
</script>
<footer>
    <div class="qbfooter">    	
<!-- Developed by Naresh Shaw -->
    <?php if(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] > 0){ ?>
	<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
	
    <?php } ?>
    </div>           
</footer>

</body>
</html>

	

       

       