/**
 * Created by buddhikajay on 8/5/16.
 */
var webrtc = new SimpleWebRTC({
   // the id/element dom element that will hold "our" video
   localVideoEl: 'localVideo',
   // the id/element dom element that will hold remote videos
   remoteVideosEl: 'remoteVideos',
   // immediately ask for camera access
   autoRequestMedia: true,
   // url: 'https://'+location.hostname+':8888'
   url: 'https://sandbox.simplewebrtc.com:443/'
   // url: 'https://media.obmcse.xyz/'
});

var muted = false;
var paused = false;

// Moved to html .we have to wait until it's ready
webrtc.on('readyToCall', function () {
   // you can name it anything
   webrtc.joinRoom('buddhikajay');
});


// a peer video has been added
webrtc.on('videoAdded', function (video, peer) {
    console.log('video added', peer);
    var remotes = document.getElementById('remotes');
    if (remotes) {
        var gallery = document.createElement('div');
        gallery.className = 'gallery';
        gallery.id = 'container_' + webrtc.getDomId(peer);
        gallery.appendChild(video);

        var description = document.createElement('div');
        description.className = 'desc';
        gallery.appendChild(description);

        var span = document.createElement('span');
        span.id = 'span_' + webrtc.getDomId(peer);
        span.className = "fa-stack fa-sm";
        description.appendChild(span);

        var speakerIcon = document.createElement('i');
        //this id is used to get the peer by string spitting
        speakerIcon.id = 'speaker___' + webrtc.getDomId(peer);
        speakerIcon.className = "fa fa-volume-up fa-stack-1x";
        speakerIcon.onclick = function(){muteRemote(this);};
        span.appendChild(speakerIcon);

        var banIcon = document.createElement('i');
        banIcon.id = 'ban___' + webrtc.getDomId(peer);
        banIcon.className = "fa fa-ban fa-stack-2x ban-icon";
        banIcon.onclick = function(){muteRemote(this);};
        span.appendChild(banIcon);



        // suppress contextmenu
        video.oncontextmenu = function () { return false; };
        remotes.appendChild(gallery);
        arrange();

    }
});


// a peer video was removed
webrtc.on('videoRemoved', function (video, peer) {
    console.log('video removed ', peer);
    var remotes = document.getElementById('remotes');
    var el = document.getElementById(peer ? 'container_' + webrtc.getDomId(peer) : 'locallocal_video_containerScreenContainer');
    if (remotes && el) {
        remotes.removeChild(el);
        arrange();
    }
});

function arrange(){

    console.log('arranging....');
    var remotes = document.getElementById('remotes');
    var videoCount = remotes.childElementCount;
    if (remotes) {
        switch (videoCount){
          case 1:
            console.log("Only One");
            changeWidth(600);
            break;
          case 2:
            console.log("Two");
            changeWidth(400);
            break;
          case 3:
            console.log("Three");
            changeWidth(280);
            break;
          case 4:
            console.log("Four");
            changeWidth(400);
            break;

        }
    }
}

function changeWidth(width){
    var all = document.getElementsByClassName('gallery');
    for (var i = 0; i < all.length; i++) {
      all[i].style.width = width+'px';
    }
}

function toggleMute(){
    if(muted){
        console.log('unmute');
        webrtc.unmute();
        // document.getElementById('muteIcon').className = "fa fa-microphone";
        // document.getElementById('muteIcon').style.color="green";
        document.getElementById('muteIconBan').style.display="none";
    }
    else{
        console.log('mute');
        webrtc.mute();
        // document.getElementById('muteIcon').className = "fa fa-microphone-slash";
        // document.getElementById('muteIcon').style.color="red";
        document.getElementById('muteIconBan').style.display="block";

    }
    muted =! muted;
}

function togglePauseVideo(){
    if(paused){
        console.log('Resume Video');
        webrtc.resumeVideo();
        // document.getElementById('pauseVideoIcon').style.color="green"; 
        document.getElementById('pauseVideoBan').style.display="none";             
    }
    else{
        console.log('Pause Video');
        webrtc.pauseVideo();
        // document.getElementById('pauseVideoIcon').style.color="red";
        document.getElementById('pauseVideoBan').style.display="block";
    }
    paused = !paused;
}

function muteRemote(element){

    var peer = element.id.split('___');
    console.log('video volume:'+peer[1]);
    video = document.getElementById(peer[1]);
    if(video.volume == 1){
        console.log('muting');
        video.volume = 0;
        document.getElementById('ban___'+peer[1]).style.display="block";
    }
    else{
        console.log('unmuting');
        video.volume = 1;
        document.getElementById('ban___'+peer[1]).style.display="none";
    }
}