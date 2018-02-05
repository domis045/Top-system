<?php
if(!defined('SYS_STARTED')) die('Security activated');

if (isset($_POST['login'])) {
	$post_data = do_request($_POST, true, '');
	
	if (!$post_data)
		set_msg('Būtina užpildyti visus laukelius', 'error', $config['home_url'] . '/go/login#response');
	
	if (!$post_data['token'] || !read_session('token') || $post_data['token'] != read_session('token'))
		set_msg('Nenumatyta klaida, susisiekite su administratoriumi', 'error', $config['home_url'] . '/go/login#response');
	
	$encoded_password = encode_user_password($post_data['password']);

	$query = $db->prepare("SELECT user_id, user_group FROM users WHERE username = '{$post_data['username']}' AND password = '{$encoded_password}' AND deleted = '0'");
	$query->execute();
	if ($query->rowCount() == 0)
		set_msg('Blogas slapyvardis ir/arba slaptažodis (<a href="' . $config['home_url'] . '/go/restore_password" class="link">pamiršai slaptažodį?</a>)', 'error', $config['home_url'] . '/go/login#response');
	
	$data = $query->fetch();
	
	session_regenerate_id();
	write_session('userIP', md5($_SERVER['REMOTE_ADDR']));
	write_session('userHA', md5(md5($_SERVER['HTTP_USER_AGENT']).md5($config['home_url']).md5($config['random_code'])));
	write_session('user_group', $data['user_group']);
	write_session('user_id', $data['user_id']);
	write_session('username', $post_data['username']);
	
	if ($data['user_group'] == 2) {
		write_session('show_deleted_servers', true);
		redirect($config['home_url']);
	}
		
	redirect($config['home_url'] . '/go/control');
}
?>