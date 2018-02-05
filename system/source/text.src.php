<?php

if(!defined('SYS_STARTED')) die('Security activated');

function _substr($str, $length, $id, $minword = 3) {
	$sub = '';
  $len = 0;
   
  foreach (explode(' ', $str) as $word) {
    $part = (($sub != '') ? ' ' : '') . $word;
    $sub .= $part;
    $len += strlen($part);
       
    if (strlen($word) > $minword && strlen($sub) >= $length) break;
  }
  
	if (!empty($id))
		return $sub . (($len < strlen($str)) ? " <a href='#' onclick=\"openFile('Pilnas serverio aprašymas', 'descr.php?id={$id}', 'dialog', '250', '450'); return false;\">žiūrėti pilną aprašymą</a>" : '');
	else
		return $sub . (($len < strlen($str)) ? '...' : '');
}

function _nl2br($string, $num) {
	$dirty = preg_replace('/\r/', '', $string);
	$clean = preg_replace('/\n{4,}/', str_repeat('<br />', $num), preg_replace('/\r/', '', $dirty));
		 
	return nl2br($clean);
}

function truncate($str, $len) {
  if (strlen($str) > $len) {
		$trunk = substr($str, 0, $len) . '..';
	} else {
		$trunk = $str;
	}
  return $trunk;
}
?>