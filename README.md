# htmlConf
1. wp-content/themes/<your_theme>
2. Copy MeetrixChat.php there
3. Copy 'meetrix' directory to wp-content/themes/<your_theme>/assets directory
4. Copy followings at the end of functions.php

function custom_rewrite_rule_1() {
	add_rewrite_rule('^conference/([^/]*)/?','index.php?page_id=20&room=$matches[1]','top');
}
add_action('init', 'custom_rewrite_rule_1', 10, 0);

function custom_rewrite_rule_2() {
	add_rewrite_rule('^conference','index.php?page_id=20','top');
}
add_action('init', 'custom_rewrite_rule_2', 10, 0);

5. Update and save permelinks from wordpress admin panel 
