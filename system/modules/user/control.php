<?php
	if(!defined('SYS_STARTED')) die('Security activated');

	if (!$is_logged) redirect('/');

	$allow_vote_banners = false;
	$server_data = array();
	$chronicles_list = array(
		'C0|Prelude', 'C1|Harbingers of War', 'C2|Age Of Splendor', 'C3|Rise of Darkness',
		'C4|Scions of Destiny', 'C5|Oath of Blood', 'CT0|Interlude', 'CT1|The Kamael', 'CT1.5|Hellbound', 'CT2.1|Gracia Part 1', 'CT2.2|Gracia Part 2',
		'CT2.3|Gracia Final', 'CT2.4|Gracia Epilogue', 'CT3|Freya', 'CT3.1|High Five', 'GOD|Awakening'
	);
	
	$query = $db->prepare("SELECT id, title, web_url, chronicle, xp, description, login_server_ip, game_server_ip, login_server_port, game_server_port FROM servers WHERE user_id = '" . read_session('user_id') . "'");
	$query->execute();
	
	
	if ($query->rowCount() > 0) {
		$server_data = $query->fetch();
		$allow_vote_banners = true;
	} else {
		$server_data['id'] = '';
		$server_data['title'] = read_session('title');
		$server_data['web_url'] = read_session('web_url');
		$server_data['chronicle'] = read_session('chronicle');
		$server_data['xp'] = read_session('xp');
		$server_data['description'] = read_session('description');
		$server_data['login_server_ip'] = read_session('login_server_ip');
		$server_data['game_server_ip'] = read_session('game_server_ip');
		$server_data['login_server_port'] = read_session('login_server_port');
		$server_data['game_server_port'] = read_session('game_server_port');
	}
	
	$chronicles_select = '';
	
	foreach ($chronicles_list as $chronicle) {
		$chronicle_title = str_replace('|', ' - ', $chronicle);
		if (read_session('chronicle') == $chronicle || $server_data['chronicle'] == $chronicle) $selected = "selected='selected'"; else $selected = '';
		$chronicles_select .= "<option value='{$chronicle}' {$selected}>{$chronicle_title}</option>";
	}
	
	if ($allow_vote_banners)
		$tpl->assign('default_vote_code', "<a href='{$config['home_url']}/vote-{$server_data['id']}' target='_blank'><img src='{$config['home_url']}/user/images/1.jpg' alt='vote image' title='Paspausk, jei nori atiduoti balsą'></a>");
	else
		$tpl->assign('default_vote_code', "");
	
	$tpl->assign('allow_vote_banners', $allow_vote_banners);
	$tpl->assign('server_data', $server_data);
	$tpl->assign('chronicles_list', $chronicles_select);
	$tpl->assign('form_response', get_msg('msg', 'margin-top: 15px;'));
	$tpl->assign('password_change_form_response', get_msg('pc_msg', 'margin-top: 15px;'));
	$tpl->assign('email_change_form_response', get_msg('ec_msg', 'margin-top: 15px;'));
	$tpl_output = $tpl->draw('control', $to_string = true);
?>