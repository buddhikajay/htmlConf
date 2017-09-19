# htmlConf
Setting up and implementing htmlConf 

Steps:
1. Create a directory in ‘wp-content/themes/<your_theme>’ or you can use an existing theme in themes (for an example ‘tewntyseventeen’).
2. Copy ‘MeetrixChat.php’ that folder.
3. Copy 'meetrix' directory (which contains font-awesome-4.7.0, css, js and index.html files) to ‘wp-content/themes/<your_theme>/assets’ directory.
4. To add reference to files (using script and link tags) in ‘MeetrixChat.php’, use ‘<?php echo get_template_directory_uri(); ?>’ as follows:

		<script src="<?php echo get_template_directory_uri(); ?>/assets/meetrix/js/
		meetrix.js”></script>

5. Copy followings at the end of ‘functions.php’.

		function custom_rewrite_rule_1() {
		add_rewrite_rule('^conference/([^/]*)/?','index.php?page_id=20&room=
		$matches[1]','top');
		}
		
		add_action('init', 'custom_rewrite_rule_1', 10, 0);

		function custom_rewrite_rule_2() {
			add_rewrite_rule('^conference','index.php?page_id=20','top');
		}
		
		add_action('init', 'custom_rewrite_rule_2', 10, 0);

6. Update and save permalinks from wordpress admin panel.
Now the MeetrixChat template has been created and can be used to create pages.
7. Then create a new page from wordpress admin panel, and select ‘MeetrixChat’ as its template and publish it.
8. Then update and save permalinks from wordpress admin panel.
9. To provide the conference room ID ($room) for the third user (who has not logged in), the following can be added to ‘MeetrixChat.php’:

		if( !(is_user_logged_in()) ){
		$room = $_SERVER['QUERY_STRING'];
		}

10. “Share this link” option should be allowed only for the logged in user, therefore it should be within the if() block as follows:

		if(is_user_logged_in() && $user && $userIdHash==$room){	
		    echo '<div id="'.'openModal" class="modalDialog">'.'<div>'; 
		    echo '<a href="'.'#close" title="Close" class="close">X</a>';
		    echo '<h2>Share this link</h2><input style="width:100%" value="';
		    echo "http://localhost/conference/?".$userIdHash;
		    echo '"></div>'.'</div>';
		   }



