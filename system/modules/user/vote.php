<?php
if(!defined('SYS_STARTED')) die('Security activated');

$id = get_url_param('id');
$server_exist = false;
$voted = false;

$three_first_images = array(
	1 => "<img src='{$theme_path}/images/icons/gold_medal_small.png' alt='' />", 
	"<img src='{$theme_path}/images/icons/silver_medal_small.png' alt='' />", 
	"<img src='{$theme_path}/images/icons/bronze_medal_small.png' alt='' />"
);
		
$three_first_bold = array(
	1 => "style='font-weight: bold;'",
	"style='font-weight: bold;'",
	"style='font-weight: bold;'",
);

if ($id && is_numeric($id)) {
	$query = $db->prepare("SELECT id, user_id, title, web_url, chronicle, xp, description, game_server_status, login_server_status, votes FROM servers WHERE id = '{$id}' AND deleted = '0'");
	$query->execute();
	
	if ($query->rowCount() > 0) {
		$server_data = $query->fetch();
		$rank = get_server_rank($server_data['user_id']);
		$server_exist = true;
	}
	
	if ($server_exist) {
		if (is_voted()) {
			$ip = mysql_escape_mimic($_SERVER['REMOTE_ADDR']);
			$query = $db->prepare("SELECT date FROM vote_log WHERE ip = '{$ip}'");
			$query->execute();
			$data = $query->fetch();
			$converted_next_vote_date = date('Y-m-d H:i:s', $data['date']);
		} else {
			$converted_next_vote_date = '';
		}
		
		if ($server_data['login_server_status']) {
			$server_data['login_status_text'] = 'online';
			$server_data['login_status_image'] = "<img src='{$theme_path}/images/icons/online.png' alt='' />";
		} else {
			$server_data['login_status_text'] = 'offline';
			$server_data['login_status_image'] = "<img src='{$theme_path}/images/icons/offline.png' alt='' />";
		}
			
		if ($server_data['game_server_status']) {
			$server_data['game_status_text'] = 'online';
			$server_data['game_status_image'] = "<img src='{$theme_path}/images/icons/online.png' alt='' />";
		} else {
			$server_data['game_status_text'] = 'offline';
			$server_data['game_status_image'] = "<img src='{$theme_path}/images/icons/offline.png' alt='' />";
		}

		$server_data['rank'] = (isset($three_first_images[$rank])) ? $three_first_images[$rank] : $rank . '.';
		$server_data['bold'] = (isset($three_first_bold[$rank])) ? $three_first_bold[$rank] : '';
		
		$chronicle = explode('|', $server_data['chronicle']);
		$server_data['chronicle_full'] = $chronicle[1];
		$server_data['chronicle_short'] = $chronicle[0];
		
		$server_data['votes'] = number_format($server_data['votes']);
		
		// nemokamas balsavimas
		if (is_voted()) {
			$ip = mysql_escape_mimic($_SERVER['REMOTE_ADDR']);
			$query = $db->prepare("SELECT date FROM vote_log WHERE ip = '{$ip}'");
			$query->execute();
			$data = $query->fetch();
			$converted_next_vote_date = date('Y-m-d H:i:s', $data['date']);
		
			$date1 = time();
			$date2 = strtotime($converted_next_vote_date);
			$left_time = $date2 - $date1;
			$tpl->assign('left_time', $left_time);
			$voted = true;
		}
		
		$tpl->assign('data', $server_data);
		$tpl->assign('sms_data', $sms_config);
		$dynamic_title = ' - ' . $server_data['title'];
	}
}

if ($config['special_offer'])
	$tpl->assign('offer', $config['special_offer']);
else
	$tpl->assign('offer', 'Šiuo metu akcijų nėra');

$tpl->assign('voted', $voted);
$tpl->assign('server_exist', $server_exist);
$tpl->assign('form_response', get_msg('msg', 'margin-top: 15px;'));
$tpl_output = $tpl->draw('vote', $to_string = true);
?>