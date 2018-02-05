<?php
	if(!defined('SYS_STARTED')) die('Security activated');

	if ($is_logged) {
		remove_session('logged');
		remove_session('user_id'); 
		remove_session('user_group');
	}
	
	redirect('/');

?>