// Developed by Naresh Shaw
// This example uses MediaRecorder to record from an audio and video stream, and uses the
// resulting blob as a source for a video element.
//
// The relevant functions in use are:
//
// navigator.mediaDevices.getUserMedia -> to get the video & audio stream from user
// MediaRecorder (constructor) -> create MediaRecorder instance for a stream
// MediaRecorder.ondataavailable -> event to listen to when the recording is ready
// MediaRecorder.start -> start recording
// MediaRecorder.stop -> stop recording (this will generate a blob of data)
// URL.createObjectURL -> to create a URL from a blob, which we use as video src

fileName = Math.round(Math.random() * 99999999) + 99999999;
var recordButton, stopButton, recorder, liveStream;
window.onload = function () {
//recordButton = document.getElementById('record');
  stopButton = document.getElementById('stop');
  stopButton.addEventListener('click', stopRecording);
  /*navigator.mediaDevices.getUserMedia({
    audio: true,
    video: true
  })
  .then(function (stream) {*/
    
  //});
}
/*
window.onload = function () {
  recordButton = document.getElementById('record');
  stopButton = document.getElementById('stop');

  // get video & audio stream from user
  navigator.mediaDevices.getUserMedia({
    audio: true,
    video: true
  })
  .then(function (stream) {
    liveStream = stream;

    var liveVideo = document.getElementById('live');
   // liveVideo.src = URL.createObjectURL(stream);
   // liveVideo.play();

    recordButton.disabled = false;
    recordButton.addEventListener('click', startRecording);
    stopButton.addEventListener('click', stopRecording);

  });
};*/

function startRecording() {
	//var videoOnlyStream = new MediaStream();
      //  videoOnlyStream.addTrack(stream.getVideoTracks()[0]);
       
  recorder = new MediaRecorder(liveStream);
	 
  recorder.addEventListener('dataavailable', onRecordingReady);

  //recordButton.disabled = true;
  stopButton.disabled = false;

  recorder.start();
  recordVideo = RecordRTC(recorder, {
            type: 'video',
            // recorderType: MediaStreamRecorder || WhammyRecorder
        });
		createLiveFeature();
		
}

function stopRecording() {
  //recordButton.disabled = false;
  stopButton.disabled = true;

  // Stopping the recorder will eventually trigger the 'dataavailable' event and we can complete the recording process
  recorder.stop();
 liveStream.getTracks().forEach(track => track.stop())
  //PostBlob(recordAudio.getBlob(), recordVideo.getBlob(), fileName);
  StopLiveFeature();
}

function onRecordingReady(e) {
  //var video = document.getElementById('recording');
  var file = new Blob([
   JSON.stringify({'video-blob' : e.data})
], { type: 'application/json' });
//console.log("File is  : " + file);
for (var key in file) {
    console.log(key, file[key]);
    //formData.append(key, myFormData[key]);
}
  // e.data contains a blob representing the recording
  
  //video.src = URL.createObjectURL(e.data);
  PostBlob(e.data, fileName,file);
  //video.play();
 // console.log(video.src);
}
