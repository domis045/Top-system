<?php
require_once('core.php');

$tpl_output = '';
$top_menu_list = array(
	'home' => array('SERVERIAI' => ""),
	'registration' => array('REGISTRACIJA' => "go/registration"),
	'login' => array('PRISIJUNGIMAS' => "go/login"),
	'restore_password' => array('SLAPTAŽODŽIO PRIMINIMAS' => "go/restore_password"),
	'control' => array('SERVERIO VALDYMAS' => "go/control"),
	'vote' => array('BALSAVIMAS' => "vote-" . get_url_param('id')),
);

$menu = '';
$dynamic_title = '';

foreach ($top_menu_list as $key => $list) {
	$title = array_keys($list);
	$url = array_values($list);
	
	if (get_url_param('go') == $key) { 
		$current = "class=\"current\""; 
	} else {
		if (!get_url_param('go') && $key == 'home') $current = "class=\"current\""; else $current = "";
	}
	
	if ($key != 'vote' && $key != 'control' && $key != 'registration' && $key != 'login' && $key != 'restore_password')
		$menu .= "<a href='{$config['home_url']}/{$url[0]}'><li {$current}>{$title[0]}</li></a>";
		
	if (($key == 'registration' || $key == 'login' || $key == 'restore_password') && !$is_logged)
		$menu .= "<a href='{$config['home_url']}/{$url[0]}'><li {$current}>{$title[0]}</li></a>";
	
	if ($key == 'control' && $is_logged && !$is_admin)
		$menu .= "<a href='{$config['home_url']}/{$url[0]}'><li {$current}>{$title[0]}</li></a>";
		
	if ($key == 'vote' && get_url_param('go') == 'vote' && get_url_param('id'))
		$menu .= "<a href='{$config['home_url']}/{$url[0]}'><li {$current}>{$title[0]}</li></a>";
}

$query = $db->prepare("SELECT id FROM servers WHERE deleted = '0'");
$query->execute();
if ($query->rowCount() > 0)
	$total_servers = $query->rowCount();
else
	$total_servers = 0;
	
$tpl->assign('theme', $config['home_url'] . '/user/themes/' . $config['theme']);
$tpl->assign('home_path', $config['home_url']);
$tpl->assign('menu', $menu);
$tpl->assign('total_servers', $total_servers);
$tpl->assign('total_servers_text', format_number_text($total_servers, 'serverių', 'serveris', 'serveriai'));
$tpl->assign('is_admin', $is_admin);
$tpl->assign('is_logged', $is_logged);
$tpl->assign('username', read_session('username'));

$token = sha1(mt_rand(0, 1000000));
write_session('token', $token);
$tpl->assign('token', $token);

load_module((get_url_param('go')) ? get_url_param('go') : 'servers_list', '', 'user');

$tpl->assign('dynamic_title', $dynamic_title);
$tpl->assign('content', $tpl_output);
$tpl->draw('main');

ob_end_flush();
?>