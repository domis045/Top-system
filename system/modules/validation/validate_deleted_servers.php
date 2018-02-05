<?php
if (!defined('SYS_STARTED')) die('Security activated');
if (!$is_logged || !$is_admin) die('Security activated');

if (isset($_GET['id'])) {
	$get_data = do_request($_GET, true, '');
	
	remove_session('show_deleted_servers');
		
	if ($get_data['id'])
		write_session('show_deleted_servers', 1);
	else
		write_session('show_deleted_servers', 0);
	
	redirect($config['home_url']);
}
?>