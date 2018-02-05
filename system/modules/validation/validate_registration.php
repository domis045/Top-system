<?php
if(!defined('SYS_STARTED')) die('Security activated');

if (isset($_POST['register'])) {
	save_input_values($_POST);
	
	$post_data = do_request($_POST, true, '');
	
	$username_regexp = "/^[a-zA-Z0-9]{3,35}$/";
	$email_regexp = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
	
	if (!$post_data)
		set_msg('Būtina užpildyti visus laukelius', 'error', $config['home_url'] . '/go/registration#response');
		
	if (!$post_data['token'] || !read_session('token') || $post_data['token'] != read_session('token'))
		set_msg('Nenumatyta klaida, susisiekite su administratoriumi', 'error', $config['home_url'] . '/go/registration#response');
	
	if (!preg_match($username_regexp, $post_data['username']))
		set_msg('Blogai sudarytas slapyvardis (slapyvardį gali sudaryti tik lotyniškos raidės ir skaičiai, max. 35 simboliai)', 'error', $config['home_url'] . '/go/registration#response');
	
	$query = $db->prepare("SELECT user_id FROM users WHERE username = '{$post_data['username']}'");
	$query->execute();
	if ($query->rowCount() > 0) {
		remove_session('username');
		set_msg('Toks slapyvardis jau naudojamas, pasirinkite kitą', 'error', $config['home_url'] . '/go/registration#response');
	}
	
	if (strcmp($post_data['password'], $post_data['password_repeat']) != 0)
		set_msg('Slaptažodžiai nesutampa', 'error', $config['home_url'] . '/go/registration#response');
	
	if (!preg_match($email_regexp, $post_data['email'])) {
		remove_session('email');
		set_msg('Blogai sudarytas el. pašto adresas', 'error', $config['home_url'] . '/go/registration#response');
	}
	
	$query = $db->prepare("SELECT user_id FROM users WHERE email = '{$post_data['email']}' OR email_dynamic = '{$post_data['email']}'");
	$query->execute();
	if ($query->rowCount() > 0)
		set_msg('Toks el. pašto adresas jau naudojamas, pasirinkite kitą', 'error', $config['home_url'] . '/go/registration#response');
		
	require_once(SYS_SYSTEM . '/source/recaptcha.src.php');
  $privatekey = "6LfVPsYSAAAAABTjut49M8VuswlZF7YDg3TPVyxh";
  $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid)
		set_msg('Apsaugos kodas neteisingas', 'error', $config['home_url'] . '/go/registration#response');
	
	$ip = mysql_escape_mimic($_SERVER['REMOTE_ADDR']);
	$encoded_password = encode_user_password($post_data['password']);

	$query = $db->prepare("INSERT INTO users SET username = '{$post_data['username']}', password = '{$encoded_password}', email = '{$post_data['email']}', email_dynamic = '{$post_data['email']}', ip = '{$ip}', date = '" . time() . "', user_group = '1', deleted = '0'");
	$query->execute();
	
	remove_input_values($_POST);
	
	set_msg('Registracija sėkminga, dabar galite prisijungti', 'success', $config['home_url'] . '/go/registration#response');
}

?>