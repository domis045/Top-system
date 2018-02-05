<?php
	if(!defined('SYS_STARTED')) die('Security activated');
		
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
	
	$query = $db->prepare("SELECT id FROM servers");
	$query->execute();
		
	$page = (get_url_param('page')) ? get_url_param('page') : '';
	
	$pagination = new Pagination();
	$pagination->setLink($config['home_url'] . '/page/%s');
	$pagination->setPage($page);
	$pagination->setSize(50);
	$pagination->setTotalRecords($query->rowCount());
		
	if ($is_admin && read_session('show_deleted_servers'))
		$where_statement = "";
	else
		$where_statement = "WHERE deleted = '0'";
		
	$query = $db->prepare("SELECT *,rank FROM (
	SELECT @rank := IF(@prev_val=votes,@rank,@rank+1) AS rank, @prev_val := votes AS 
	votes, id, user_id, title, web_url, chronicle, xp, description, game_server_status, login_server_status, deleted
	FROM servers {$where_statement} ORDER BY votes DESC, last_vote_date DESC
	)as result " . $pagination->getLimitSql());
	$query->execute();
	
	$servers_list = array();
	foreach ($query->fetchAll() as $key => $value) {
		$rank = get_server_rank($value['user_id']);
	
		if ($value['login_server_status']) {
			$value['login_status_text'] = 'online';
			$value['login_status_image'] = "<img src='{$theme_path}/images/icons/online.png' alt='' />";
		} else {
			$value['login_status_text'] = 'offline';
			$value['login_status_image'] = "<img src='{$theme_path}/images/icons/offline.png' alt='' />";
		}
			
		if ($value['game_server_status']) {
			$value['game_status_text'] = 'online';
			$value['game_status_image'] = "<img src='{$theme_path}/images/icons/online.png' alt='' />";
		} else {
			$value['game_status_text'] = 'offline';
			$value['game_status_image'] = "<img src='{$theme_path}/images/icons/offline.png' alt='' />";
		}
		
		$value['rank'] = (isset($three_first_images[$rank])) ? $three_first_images[$rank] : $rank . '.';
		$value['bold'] = (isset($three_first_bold[$rank])) ? $three_first_bold[$rank] : '';
		
		$chronicle = explode('|', $value['chronicle']);
		$value['chronicle_full'] = $chronicle[1];
		$value['chronicle_short'] = $chronicle[0];
		
		$value['title'] = _substr($value['title'], 30, '', 1);
		
		$value['votes'] = number_format($value['votes']);
		
		if ($rank == 11) 
			$value['line'] = "<div class=\"line_box\"><div class=\"line\"></div></div>";
		else
			$value['line'] = "";
			
		if ($value['deleted'])
			$value['delete'] = "<a href='{$config['home_url']}/validate/cancel-{$value['user_id']}/" . back_path() . "' onclick=\"return _confirmAndGo('Ar tikrai norite atšaukti trynimą?');\"><img src='{$config['home_url']}/user/themes/{$config['theme']}/images/icons/cancel_delete.png' alt='' title='Atšaukti trynimą'></a>";
		else
			$value['delete'] = "<a href='{$config['home_url']}/validate/delete-{$value['user_id']}/" . back_path() . "' onclick=\"return _confirmAndGo('Ar tikrai norite pradėti trynimą?');\"><img src='{$config['home_url']}/user/themes/{$config['theme']}/images/icons/start_delete.png' alt='' title='Pradėti trynimą'></a>";
		
		$value['delete_completely'] = "<a href='{$config['home_url']}/validate/delete_completely-{$value['user_id']}/" . back_path() . "' onclick=\"return _confirmAndGo('Ar tikrai norite visiškai ištrinti šį serverį?');\"><img src='{$config['home_url']}/user/themes/{$config['theme']}/images/icons/delete_completely.png' alt='' title='Ištrinti visiškai'></a>";
		
		$servers_list[] = $value;
	}
	
	$tpl->assign('pagination', $pagination->create_links());
	$tpl->assign('servers_list', $servers_list);
	$tpl->assign('show_deleted_servers', read_session('show_deleted_servers'));
	$dynamic_title = ' - visi serveriai';
	$tpl_output = $tpl->draw('servers_list', $to_string = true);
?>