<?php
if(!defined('SYS_STARTED')) die('Security activated');

if (isset($_POST['lost_password'])) {
	$post_data = do_request($_POST, true, '');
	
	if (!$post_data)
		set_msg('Būtina užpildyti visus laukelius', 'error', $config['home_url'] . '/go/restore_password#response');
	
	if (!$post_data['token'] || !read_session('token') || $post_data['token'] != read_session('token'))
		set_msg('Nenumatyta klaida, susisiekite su administratoriumi', 'error', $config['home_url'] . '/go/restore_password#response');
	
	require_once(SYS_SYSTEM . '/source/recaptcha.src.php');
  $privatekey = "6LfVPsYSAAAAABTjut49M8VuswlZF7YDg3TPVyxh";
  $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) 
		set_msg('Neteisingas apsaugos kodas', 'error', $config['home_url'] . '/go/restore_password#response');
	
	$email_regexp = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
	
	// ivestas slapyvardis
	if (!strpos($post_data['lost_password_data'], '@')) {
		$query = $db->prepare("SELECT user_id FROM users WHERE username = '{$post_data['lost_password_data']}' AND deleted = '0'");
		$query->execute();
		
		// jei toks vartotojas egzistuoja
		if ($query->rowCount() > 0) {
			$query = $db->prepare("SELECT MAX(id) as maxId FROM lost_password_log");
			$query->execute();
			
			$data = $query->fetch();
			$new_max_id = $data['maxId'] + 1;
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$date = time();
			$future_date = time() + (24 * 60 * 60);
			
			$lost_password_data_encoded = pass_reminder_encode($post_data['lost_password_data'].$new_max_id.'top.llb.lt'.time());
			$lost_password_link = "{$config['home_url']}/go/restore_password/{$lost_password_data_encoded}";
			
			$lost_password_message = "Šis laiškas jums atsiūstas todėl, kad kažkas iniciavo slaptažodžio keitimą top.llb.lt puslapyje ir nurodė šį el. pašto adresą, jei tai buvote jūs ir jums reikia naujo slaptažodžio prašome paspausti (arba nukopijuoti į adreso laukelį) nuorodą esančią žemiau, kitu atveju tiesiog ignoruokite šį laišką.
Slaptažodžio keitimo nuoroda bus aktyvi 24 valandas arba kol ją paspausite.

{$lost_password_link}

---------------------------------------------------------
Šis laiškas sugeneruotas automatiškai, į jį atsakyti nereikia.
---------------------------------------------------------";

			$query = $db->prepare("SELECT user_id, email_dynamic FROM users WHERE username = '{$post_data['lost_password_data']}'");
			$query->execute();
			if ($query->rowCount() > 0) {
				$data = $query->fetch();
				
				send_email($data['email_dynamic'], "top.llb.lt slaptažodžio keitimas", $lost_password_message);
				$db->query("INSERT INTO lost_password_log SET ip = '{$ip}', date = '{$date}', code = '{$lost_password_data_encoded}', valid_date = '{$future_date}', lost_password_data = '{$data['user_id']}'");
				
				set_msg('Slaptažodžio keitimo nuoroda išsiūsta el. pašto adresu kuris priklauso Jūsų įvestam slapyvardžiui', 'success', $config['home_url'] . '/go/restore_password#response');
			} else {
				set_msg('Toks vartotojas neegzistuoja', 'error', $config['home_url'] . '/go/restore_password#response');
			}
		} else {
			set_msg('Toks vartotojas neegzistuoja', 'error', $config['home_url'] . '/go/restore_password#response');
		}
	} else {
		if (!preg_match($email_regexp, $post_data['lost_password_data']))
			set_msg('Blogai sudarytas el. pašto adresas', 'error', $config['home_url'] . '/go/restore_password#response');
		
		$query = $db->prepare("SELECT user_id FROM users WHERE email_dynamic = '{$post_data['lost_password_data']}' AND deleted = '0'");
		$query->execute();
		
		// jei toks vartotojas egzistuoja
		if ($query->rowCount() > 0) {
			$query = $db->prepare("SELECT MAX(id) as maxId FROM lost_password_log");
			$query->execute();
			
			$data = $query->fetch();
			$new_max_id = $data['maxId'] + 1;
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$date = time();
			$future_date = time() + (24 * 60 * 60);
			
			$lost_password_data_encoded = pass_reminder_encode($post_data['lost_password_data'].$new_max_id.'top.llb.lt'.time());
			$lost_password_link = "{$config['home_url']}/go/restore_password/{$lost_password_data_encoded}";
			
			$lost_password_message = "Šis laiškas jums atsiūstas todėl, kad kažkas iniciavo slaptažodžio keitimą top.llb.lt puslapyje ir nurodė šį el. pašto adresą, jei tai buvote jūs ir jums reikia naujo slaptažodžio prašome paspausti (arba nukopijuoti į adreso laukelį) nuorodą esančią žemiau, kitu atveju tiesiog ignoruokite šį laišką.
Slaptažodžio keitimo nuoroda bus aktyvi 24 valandas arba kol ją paspausite.

{$lost_password_link}

---------------------------------------------------------
Šis laiškas sugeneruotas automatiškai, į jį atsakyti nereikia.
---------------------------------------------------------";

			$query = $db->prepare("SELECT user_id FROM users WHERE email_dynamic = '{$post_data['lost_password_data']}'");
			$query->execute();
			if ($query->rowCount() > 0) {
				$data = $query->fetch();
				
				send_email($post_data['lost_password_data'], "top.llb.lt slaptažodžio keitimas", $lost_password_message);
				$db->query("INSERT INTO lost_password_log SET ip = '{$ip}', date = '{$date}', code = '{$lost_password_data_encoded}', valid_date = '{$future_date}', lost_password_data = '{$data['user_id']}'");
				
				set_msg('Slaptažodžio keitimo nuoroda išsiūsta nurodytu el. pašto adresu', 'success', $config['home_url'] . '/go/restore_password#response');
			} else {
				set_msg('Toks el. pašto adresas nerastas', 'error', $config['home_url'] . '/go/restore_password#response');
			}
		} else {
			set_msg('Toks el. pašto adresas nerastas', 'error', $config['home_url'] . '/go/restore_password#response');
		}
	}
}
?>