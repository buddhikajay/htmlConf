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

// we have to wait until it's ready
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
        description.innerHTML = "description";
        gallery.appendChild(description);

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
