<?php
if (!defined('SYS_STARTED')) die('Security activated');

if (isset($_POST['email_change'])) {
	$post_data = do_request($_POST, true, '');

	$email_regexp = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
		
	if (!$post_data)
		set_msg('Būtina užpildyti visus laukelius', 'error', $config['home_url'] . '/go/control#ec_response', 'ec_msg');
		
	if (!preg_match($email_regexp, $post_data['new_email']))
		set_msg('Blogai sudarytas el. pašto adresas', 'error', $config['home_url'] . '/go/control#ec_response', 'ec_msg');
		
	$query = $db->prepare("SELECT email FROM users WHERE user_id = '" . read_session('user_id') . "'");
	$query->execute();
	$email_data = $query->fetch();
	
	if ($email_data['email'] == $post_data['new_email'])
		set_msg('Senas ir naujas el. pašto adresas negali sutapti', 'error', $config['home_url'] . '/go/control#ec_response', 'ec_msg');
		
	$query = $db->prepare("SELECT user_id FROM users WHERE user_id != '" . read_session('user_id') . "' AND email_dynamic = '{$post_data['new_email']}'");
	$query->execute();
	if ($query->rowCount() != 0)
		set_msg('Toks el. pašto adresas jau naudojamas', 'error', $config['home_url'] . '/go/control#ec_response', 'ec_msg');
		
	$query = $db->prepare("UPDATE users SET email_dynamic = '{$post_data['new_email']}' WHERE user_id = '" . read_session('user_id') . "'");
	$query->execute();
	
	set_msg('El. pašto adresas pakeistas sėkmingai', 'success', $config['home_url'] . '/go/control#ec_response', 'ec_msg');
}

?>