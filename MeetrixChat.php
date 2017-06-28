<?php /* Template Name: MeetrixChat 
Add following to functions.php

function custom_rewrite_tag() {
  add_rewrite_tag('%room%', '([^&]+)');
}
add_action('init', 'custom_rewrite_tag', 10, 0);

function custom_rewrite_rule() {
	add_rewrite_rule('^conference/([^/]*)/?','index.php?page_id=20&room=$matches[1]','top');
}
add_action('init', 'custom_rewrite_rule', 10, 0);

*/ 
global $wp_query;
// ... more ...
?>
<!DOCTYPE html>
	<head>
    <!--<script src="/vendor/simpleWebRTC/simplewebrtc.bundle.js"></script>-->
    <!--<script src="/socket.io/socket.io.js"></script>-->
    <script src="/wordpress/wp-content/themes/twentyseventeen/assets/meetrix/js/simplewebrtc.bundle.js"></script> 
    <script src="/wordpress/wp-content/themes/twentyseventeen/assets/meetrix/js/meetrix.js"></script> 
    <link rel="stylesheet" href="/wordpress/wp-content/themes/twentyseventeen/assets/meetrix/css/meetrix.css">
    <link rel="stylesheet" href="/wordpress/wp-content/themes/twentyseventeen/assets/meetrix/font-awesome-4.7.0/css/font-awesome.min.css">
	</head>
	<body>
	<div id="remotes" class="container-fluid">
	    <div class="gallery">
	      <video autoplay id="localVideo" class="center-block"></video>
	      <div class="desc">
	        <span class="fa-stack fa-sm">
	          <i id="pauseVideoIcon" class="fa fa-video-camera fa-stack-1x" aria-hidden="true" onclick="togglePauseVideo()"></i>
	          <i id="pauseVideoBan" class="fa fa-ban fa-stack-2x ban-icon" onclick="togglePauseVideo()"></i>
	        </span>
	        <span class="fa-stack fa-sm">
	          <i id="muteIcon" class="fa fa-microphone fa-stack-1x" aria-hidden="true" onclick="toggleMute()"></i>
	          <i id="muteIconBan" class="fa fa-ban fa-stack-2x ban-icon" onclick="toggleMute()"></i>
	        </span>
	      </div>
	    </div>
	</div>
	</body>
	<script type="text/javascript">
	  webrtc.on('readyToCall', function () {
	   // you can name it anything
	   webrtc.joinRoom(<?php echo "'".$wp_query->query_vars['room']."'"; ?>);
	   arrange();
	  });
	</script>


