<?php /* Template Name: MeetrixChat 
Add following to functions.php

function custom_rewrite_tag() {
  add_rewrite_tag('%room%', '([^&]+)');
}
add_action('init', 'custom_rewrite_tag', 10, 0);

function custom_rewrite_rule_1() {
	add_rewrite_rule('^conference/([^/]*)/?','index.php?page_id=20&room=$matches[1]','top');
}
add_action('init', 'custom_rewrite_rule_1', 10, 0);

function custom_rewrite_rule_2() {
	add_rewrite_rule('^conference','index.php?page_id=20','top');
}
add_action('init', 'custom_rewrite_rule_2', 10, 0);

*/ 
global $wp_query;

// get the user activity list
$logged_in_users = get_transient('online_status');

$room=false;

if(isset($wp_query->query_vars['room'])){
	$room = $wp_query->query_vars['room'];
	//echo "Room ID: ".$wp_query->query_vars['room'];
}

	
if(is_user_logged_in()){
	// get current user ID
	$user = wp_get_current_user();
	
	//$userIdHash = hash('md5', $user->ID);
	//random generation of usedrId
	$userIdHash = hash('md5', rand());
	
	// check if the current user needs to update his online status;
	// he does if he doesn't exist in the list
	$no_need_to_update = isset($logged_in_users[$userIdHash])

	    // and if his "last activity" was less than let's say ...15 minutes ago          
	    && $logged_in_users[$userIdHash] >  (time() - (60));

	// update the list if needed
	if(!$no_need_to_update){
	  	$logged_in_users[$userIdHash] = time();
	  	set_transient('online_status', $logged_in_users, $expire_in = (60)); // 30 mins 
	}

	if(!$room){
		//echo "user logged in. No room";
		$room = $userIdHash;
	}
}

//give room id
if(!(is_user_logged_in())){
	$room = $_SERVER['QUERY_STRING'];
	}

$autherOnline = false;

if($room){
	$autherOnline = isset($logged_in_users[$room]) && $logged_in_users[$room] >  (time() - (60));
}
//else echo "room false";
//echo $room;
 //if ($autherOnline){
 	//echo "author online";
 //}
 //else{
 	//echo "author offline";
 //}
?>

<!DOCTYPE html>
	<head>
    <!--<script src="/vendor/simpleWebRTC/simplewebrtc.bundle.js"></script>-->
    <!--<script src="/socket+.io/socket.io.js"></script>-->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/meetrix/js/simplewebrtc.bundle.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/meetrix/js/meetrix.js"></script>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/meetrix/css/meetrix.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/meetrix/font-awesome-4.7.0/css/font-awesome.min.css">
	</head>
	<body>
	<div id="remotes" class="container-fluid">
	    <div class="gallery">
		    <?php
		    //$strLink = "/".md5(uniqid(rand(), true));
		    //echo $strLink;
			if(!$autherOnline){
				echo "<h3 style=\"width:100%;background-color:red\">Conference has not been started yet. Please try again later</h3>";
			}
		?>
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
	        <?php
	        	if(is_user_logged_in() && $user && $userIdHash==$room){
	        	echo 
			        "<span class=\"fa-stack fa-sm\">
		          		<a id=\"linkIcon\" class=\"fa fa-link fa-stack-1x\" aria-hidden=\"true\" href=\"#openModal\"></a>
		        	</span>";
	        	}
	        ?>
	      </div>
	    </div>
	</div>
	</body>
	<?php
	if(is_user_logged_in() && $user && $userIdHash==$room){	
	    echo '<div id="'.'openModal" class="modalDialog">'.'<div>'; 
		echo '<a href="'.'#close" title="Close" class="close">X</a>';
		echo '<h2>Share this link</h2><input style="width:100%" value="';
		//echo "http://localhost/conference/?page_Id=1&room=".$userIdHash;
		echo "http://localhost/conference/?".$userIdHash;
		echo '"></div>'.'</div>';
    }
	?>
	<script type="text/javascript">
		arrange();
	</script>
	
	<?php
	if($autherOnline){
		echo "<script type=\"text/javascript\">
			  webrtc.on('readyToCall', function () {
			   // you can name it anything
			   console.log(\"Printing room\");
			   console.log(\"$room\");
			   webrtc.joinRoom('".$room."');
			  });
		</script>";
	}
	// else{
	
	// }
	?>


