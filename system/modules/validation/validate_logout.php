<?php
if(!defined('SYS_STARTED')) die('Security activated');

if ($is_logged) {
	remove_session('userHA');
	remove_session('userIP');
	remove_session('user_id'); 
	remove_session('user_group');
	remove_session('username');
	if ($is_admin)
		remove_session('show_deleted_servers');
}
	
redirect($config['home_url']);
?>