<?phpif (!defined('SYS_STARTED')) die('Security activated');if (!$is_logged || !$is_admin) die('Security activated');if (isset($_GET['id'])) {	$get_data = do_request($_GET, true, '');	$back_path = str_replace('&amp;', '&', base64_decode($_GET['back_path']));		$query = $db->prepare("SELECT users.*, servers.* FROM users, servers WHERE users.user_id = '{$get_data['id']}' AND servers.user_id = '{$get_data['id']}'");	$query->execute();	if ($query->rowCount() > 0) {		$query = $db->prepare("UPDATE users SET deleted = '0' WHERE user_id = '{$get_data['id']}'");		$query->execute();				$query = $db->prepare("UPDATE servers SET deleted = '0' WHERE user_id = '{$get_data['id']}'");		$query->execute();	}		redirect($back_path);}?>