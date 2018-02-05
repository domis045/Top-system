<?php

if(!defined('SYS_STARTED')) die('Security activated');

function get_url_param($_key) {
	if (isset($_GET[$_key])) return clean_url($_GET[$_key]); else return false;
}

function load_module($module_1, $module_2 = '', $zone = 'admin') {
	global $tpl, $is_logged, $db, $theme_path, $misc_path, $lng, $tpl_output, $config, $sms_config, $dynamic_title, $is_admin;
	
	if (!empty($module_2)) {
		if ($module_1 == $module_2) $module_2 = str_replace($module_2, 'main_' . $module_2, $module_2);

		if (file_exists(SYS_SYSTEM . "/modules/" . $zone . "/" . $module_1))
			$path = SYS_SYSTEM . "/modules/" . $zone . "/" . $module_1 . "/" . $module_2 . ".php";
		else
			$path = SYS_SYSTEM . "/modules/" . $zone . "/" . $module_2 . ".php";
	} else {
		$path = SYS_SYSTEM . "/modules/" . $zone . "/" . $module_1 . ".php";
	}

	if (file_exists($path)) {
		require_once($path);
	}
}

function currentUrl() {
	$_SERVER['REQUEST_URI'] = isset($_SERVER['REQUEST_URI']) ? clean_url($_SERVER['REQUEST_URI']) : "";
	
	$pageURL = $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
	$pageURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"] : $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $pageURL;
}

function back_path() {
	return base64_encode($_SERVER['REQUEST_URI']);
}

function create_safe_url($url) {
	global $config;
	
	$_SERVER['REQUEST_URI'] = isset($_SERVER['REQUEST_URI']) ? clean_url($_SERVER['REQUEST_URI']) : "";
	
	if ($url != 'self') {
		$created_url = $config['home_url'] . clean_url($url);
	} else {
		$created_url = $_SERVER['REQUEST_URI'];
	} 	
	
	return $created_url;
}

function set_msg($msg, $type = 'warning', $redirect = false, $session_name = 'msg') {
	write_session($session_name, "<div class='message {$type}'><p>{$msg}</p></div>");
	
	if ($redirect) redirect($redirect); else exit;
}

function get_msg($msg_id, $style = '') {
	$msg = '';
	$div_start = '';
	$div_end = '';
	
	if ($style) {
		$div_start = "<div style='{$style}'>";
		$div_end = "</div>";
	}
	
	if (read_session($msg_id)) {
		$msg = $div_start . read_session($msg_id) . remove_session($msg_id) . $div_end;
	}
	
	return $msg;
}

function send_email($to, $subject, $message, $from = 'info@top.llb.lt') {
  $headers = 'From: '.$from."\r\n" .
  'Reply-To: '.$from."\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
  mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $headers);
} 

function redirect($location) {
	header("Location: " . str_replace("&amp;", "&", $location));
	exit;
}

function generate_random_code($length = 7, $level = 3) {
	list($usec, $sec) = explode(' ', microtime());
	srand((float) $sec + ((float) $usec * 100000));

	$chars[1] = "123456789";
	$chars[2] = "abcdefghijklmnopqrstuvwxyz";
	$chars[3] = "0123456789abcdefghijklmnopqrstuvwxyz";
	$chars[4] = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$chars[5] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

	$code  = "";
	$counter   = 0;

	while ($counter < $length) {
		$actChar = substr($chars[$level], rand(0, strlen($chars[$level])-1), 1);

		if (!strstr($code, $actChar)) {
			$code .= $actChar;
			$counter++;
		}
	}
	
	return $code;
}

function get_server_rank($user_id) {
	global $db, $is_admin;
	
	if ($is_admin && read_session('show_deleted_servers'))
		$where_statement = "";
	else
		$where_statement = "WHERE deleted = '0'";
	
  $sql1 = "SET @rownum := 0";

  $sql2 = "SELECT rank FROM (
		SELECT @rownum := @rownum + 1 AS rank, votes, user_id, title, web_url, chronicle, xp, description, game_server_status, login_server_status
    FROM servers {$where_statement} ORDER BY votes DESC, last_vote_date DESC
  ) as result WHERE user_id = '{$user_id}'";

	$db->query($sql1);
  $query = $db->prepare($sql2);
	$query->execute();
  $rows = '';
  $data = array();
  if ($query->rowCount() > 0)
		$rows = $query->rowCount();
  else
    $rows = '';

  if (!empty($rows)) {
		foreach ($query->fetchAll() as $key => $rows) $data[] = $rows;
  }

  if (empty($data[0]['rank'])) return true; else return $data[0]['rank'];
}

function check_server_status($ipaddress, $port) {
	if (@fsockopen($ipaddress, $port, $errno, $errstr, 2)) return true; else return false;
}

function do_request($request_data, $check_empty, $check_elements) {
	$post_data = array();

	if ($check_empty && empty($check_elements)) {
		foreach ($request_data as $key => $data)
			if (!empty($data)) $post_data[$key] = mysql_escape_mimic($data); else return false;
			
		return $post_data;
	}
	
	if ($check_empty && !empty($check_elements)) {
		foreach ($request_data as $key => $data) {
			if (in_array($key, $check_elements)) {
				if (!empty($data)) $post_data[$key] = mysql_escape_mimic($data); else return false;
			} else {
				$post_data[$key] = mysql_escape_mimic($data);
			}
		}
			
		return $post_data;
	}
	
	if (!$check_empty) {
		foreach ($request_data as $key => $data)
			$post_data[$key] = mysql_escape_mimic($data);
			
		return $post_data;
	}
	
	return false;
}

// $number - daiktu - daiktas - daiktai
function format_number_text($number, $text1, $text2, $text3) {
	$number = substr($number, -2);

	if ((($number > 10) && ($number < 20)) || ($number % 10 == 0)) return $text1;
	
	if (($number == 1) || ($number % 10 == 1)) return $text2;
	
	return $text3 ;
}

function save_input_values($data) {
	if (!empty($data)) {
		foreach ($data as $key => $value)
			write_session($key, $value);
	}
}

function remove_input_values($data) {
	if (!empty($data)) {
		foreach ($data as $key => $value)
			remove_session($key);
	}
}

?>