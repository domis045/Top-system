<?php

if(!defined('SYS_STARTED')) die('Security activated');
	
	function clean_url($url)  {
		$bad_entities = array("&", "\"", "'", '\"', "\'", "<", ">", "(", ")", "*");
		$safe_entities = array("&amp;", "", "", "", "", "", "", "", "", "");
		$url = str_replace($bad_entities, $safe_entities, $url);
		return $url;
	}
	
	function encode_user_password($password) {
		$salt = '8weee2sd069kl97s4d6a5s1d5';
		$password = md5($password . $salt);
		return $password;
	}
	
	function pass_reminder_encode($secret) {
		$salt = '5s5g4sPSjwifnlszxpwKw9s31w8w1';
		$encoded = md5(md5($secret.sha1($salt.$secret).$salt.$secret));
		return $encoded;
	}
	
	function is_logged() {	
		global $config;
	
		$ip = md5($_SERVER['REMOTE_ADDR']);
		$user_agent_encoded = md5(md5($_SERVER['HTTP_USER_AGENT']).md5($config['home_url']).md5($config['random_code']));
		
		if (read_session('userHA') == $user_agent_encoded && read_session('userIP') == $ip)
			return true;
		else
			return false;
	}
	
	function is_voted() {
		global $db;
		
		$ip = clean_url($_SERVER['REMOTE_ADDR']);
		
		$query = $db->prepare("SELECT ip FROM vote_log WHERE ip = '{$ip}' AND date > '" . time() . "'");
		$query->execute();
		
		if($query->rowCount() != 0) return true; else return false;
	}
	
function safe_get($check_url) {
	$return = false;
	if (is_array($check_url)) 
	{
		foreach ($check_url as $value) 
		{
			$return = safe_get($value);
			if ($return == true) return true;
		}
	} 
	else 
	{
		$check_url = str_replace("\"", "", $check_url);
		$check_url = str_replace("\'", "", $check_url);
		if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*style*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) || (preg_match("/\([^>]*\"?[^)]*\)/i", $check_url))) 
		{
			$return = true;
		}
	}
	
	return $return;
}

function mysql_escape_mimic($inp) { 
	if(is_array($inp)) return array_map(__METHOD__, $inp); 

	if(!empty($inp) && is_string($inp)) { 
		return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
	} 

	return $inp; 
}
?>