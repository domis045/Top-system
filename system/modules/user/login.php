<?php
if(!defined('SYS_STARTED')) die('Security activated');

$tpl->assign('form_response', get_msg('msg', 'margin-top: 15px;'));
$tpl_output = $tpl->draw('login', $to_string = true);
?>