<?php
if(!defined('SYS_STARTED')) die('Security activated');

require_once(SYS_SYSTEM . '/source/recaptcha.src.php');

$tpl->assign('username', read_session('username'));
$tpl->assign('email', read_session('email'));

$tpl->assign('form_response', get_msg('msg', 'margin-top: 15px;'));
$tpl_output = $tpl->draw('registration', $to_string = true);
 
?>