<?php
if(!defined('SYS_STARTED')) die('Security activated');
	
if (get_url_param('code')) {
	$code = get_url_param('code');
	
	$query = $db->prepare("SELECT id, valid_date, lost_password_data FROM lost_password_log WHERE code = '{$code}'");
	$query->execute();
	$data = $query->fetch();
	
	if ($query->rowCount() > 0 && date('Y-m-d H:i', $data['valid_date']) > date('Y-m-d H:i')) {
		$generated_new_pass = generate_random_code(8, 4);
		$new_pass_encoded = encode_user_password($generated_new_pass);
			
		$query = $db->prepare("SELECT user_id, username, email_dynamic FROM users WHERE user_id = '{$data['lost_password_data']}'");
		$query->execute();
		$user_data = $query->fetch();

		$lost_password_message = "Jūsų slaptažodis top.llb.lt sistemoje sėkmingai pakeistas

Jūsų prisijungimo slapyvardis yra: {$user_data['username']}
Jūsų naujas slaptažodis yra: {$generated_new_pass}

---------------------------------------------------------
Šis laiškas sugeneruotas automatiškai, į jį atsakyti nereikia.
---------------------------------------------------------";
	
		send_email($user_data['email_dynamic'], "top.llb.lt slaptažodžio keitimas", $lost_password_message, 'info@top.llb.lt');
			
		$query = $db->prepare("UPDATE users SET password = '{$new_pass_encoded}' WHERE user_id = '{$user_data['user_id']}'");
		$query->execute();
		
		$query = $db->prepare("DELETE FROM lost_password_log WHERE id = '{$data['id']}'");
		$query->execute();
			
		$msg = "<div class='message success'><p>Jūsų slaptažodis sėkmingai pakeistas, duomenys išsiūsti Jūsų el. pašto adresu</p></div>";
	} else {
		$msg = "<div class='message error'><p>Slaptažodžio keitimas negalimas</p></div>";
	}
		
	$tpl->assign('response', $msg);
	$tpl_output = $tpl->draw('restore_password_end', $to_string = true);	
} else {
	$tpl->assign('form_response', get_msg('msg', 'margin-top: 15px;'));
	$tpl_output = $tpl->draw('restore_password', $to_string = true);
}
?>