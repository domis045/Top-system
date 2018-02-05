<?php
require_once('../../core.php');

if (isset($_GET[$cron_key])) {
	ini_set('max_execution_time', 1500);
	
	$db->query("DELETE FROM users WHERE deleted = '1'");
	$db->query("DELETE FROM servers WHERE deleted = '1'");
}
?>