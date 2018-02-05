<?php
if(!defined('SYS_STARTED')) die('Security activated');

if (isset($_POST['vote'])) {
	$post_data = do_request($_POST, true, '');
	
	if (!$post_data)
		set_msg('Neįvedėte apsaugos kodo', 'error', $config['home_url'] . '/vote-' . $_POST['id']);
		
	if ($post_data['token'] != read_session('token'))
		set_msg('Nenumatyta klaida, susisiekite su administratoriumi', 'error', $config['home_url'] . '/vote-' . $post_data['id']);
	
	if (is_voted())
		set_msg('Jūs jau balsavote kartą per 12 valandų', 'error', $config['home_url'] . '/vote-' . $post_data['id']);
	
	$query = $db->prepare("SELECT votes FROM servers WHERE id = '{$post_data['id']}'");
	$query->execute();
	
	if ($query->rowCount() == 0)
		set_msg('Serveris už kurį balsuojate neegzistuoja', 'error', $config['home_url'] . '/vote-' . $post_data['id']);
	
	require_once(SYS_SYSTEM . '/source/recaptcha.src.php');
  $privatekey = "6LfVPsYSAAAAABTjut49M8VuswlZF7YDg3TPVyxh";
  $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid)
		set_msg('Apsaugos kodas neteisingas', 'error', $config['home_url'] . '/vote-' . $post_data['id']);

	$ip = mysql_escape_mimic($_SERVER['REMOTE_ADDR']);
	$next_vote = date("Y-m-d H:i:s", strtotime("+12 hours"));
	$next_vote_converted = strtotime($next_vote);
	$last_vote = time();

	$data = $query->fetch();
	if ($config['multiply_free_votes_status'])
		$new_votes = $data['votes'] + (1 * $config['multiply_free_votes']);
	else
		$new_votes = $data['votes'] + 1;
	
	$query = $db->prepare("SELECT ip FROM vote_log WHERE ip = '{$ip}'");
	$query->execute();

	if ($query->rowCount() > 0)
		$db->query("UPDATE vote_log SET date = '{$next_vote_converted}' WHERE ip = '{$ip}'");
	else
		$db->query("INSERT INTO vote_log SET ip = '{$ip}', date = '{$next_vote_converted}'");
			
	$db->query("UPDATE servers SET votes = '{$new_votes}', last_vote_date = '{$last_vote}' WHERE id = '{$post_data['id']}'");

	set_msg('Jūsų balsas įskaitytas', 'success', $config['home_url'] . '/vote-' . $post_data['id']);
}

?>