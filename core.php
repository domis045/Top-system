<?php
error_reporting(E_ALL);
session_start();
ob_start();

define('SYS_STARTED', true);
define('SYS_ROOT', realpath(dirname(__FILE__)) .'/');

require_once(SYS_ROOT . 'config.php');

define('SYS_ADMIN', SYS_ROOT . 'admin');
define('SYS_USER', SYS_ROOT . 'user');
define('SYS_SYSTEM', SYS_ROOT . 'system');

load_source('security', 'sessions', 'system', 'text', 'template', 'pagination');

raintpl::configure("base_url", null);
raintpl::configure("tpl_dir", SYS_USER . '/themes/' . $config['theme'] . '/');
raintpl::configure("cache_dir", "tmp/");
raintpl::configure("path_replace", false);

$tpl = new RainTPL;
$db = new PDO('mysql:host=' . $mysql_config['host'] . ';dbname=' . $mysql_config['db_name'], $mysql_config['user'], $mysql_config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 

$theme_path = $config['home_url'] . '/user/themes/' . $config['theme'];
$misc_path = $config['home_url'] . '/user/misc';

require_once(SYS_USER ."/language/lt/web.php");

if (safe_get($_GET)) die('Security activated');

if (get_url_param('go') == 'top5') {
	require_once(SYS_SYSTEM . '/modules/user/top_5.php');
	exit;
}

if (get_url_param('go') != 'top5') {
	$is_admin = false;
	$is_logged = false;
	if (is_logged()) {
		if (read_session('user_group') == 2) $is_admin = true;
		
		$is_logged = true;
		
		$query = $db->prepare("SELECT deleted FROM users WHERE user_id = '" . read_session('user_id') . "'");
		$query->execute();
		$user_data = array();
		
		if ($query->rowCount() > 0)
			$user_data = $query->fetch();
			
		if ($user_data['deleted'])
			$is_logged = false;
	}
}
	
if (get_url_param('validate') && file_exists(SYS_SYSTEM . '/modules/validation/validate_' . get_url_param('validate') . '.php')) {
	require_once(SYS_SYSTEM . '/modules/validation/validate_' . get_url_param('validate') . '.php');
}

function load_source() {
  foreach (func_get_args() as $src_name)  {
    $src_file = SYS_SYSTEM . '/source/' . $src_name . '.src.php';
    
		if (file_exists($src_file)) 
      require_once($src_file);
		else 
			die('<b>'. $src_name. '.src.php</b> not found');
  }
}
?>