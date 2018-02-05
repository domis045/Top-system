<?php
require_once('../../core.php');

if (isset($_GET[$cron_key])) {
	ini_set('max_execution_time', 1500);
	
	$query = $db->prepare("SELECT id, login_server_ip, game_server_ip, login_server_port, game_server_port FROM servers WHERE deleted = '0'");
	$query->execute();
	
	if ($query->rowCount() > 0) {
		foreach($query->fetchAll() as $key => $value) {
			if(check_server_status($value['login_server_ip'], $value['login_server_port'])) 
				$db->query("UPDATE servers SET login_server_status = '1' WHERE id = '{$value['id']}'");
			else 
				$db->query("UPDATE servers SET login_server_status = '0' WHERE id = '{$value['id']}'");

			if(check_server_status($value['game_server_ip'], $value['game_server_port'])) 
				$db->query("UPDATE servers SET game_server_status = '1' WHERE id = '{$value['id']}'");
			else 
				$db->query("UPDATE servers SET game_server_status = '0' WHERE id = '{$value['id']}'");
		}
	}
}
?>