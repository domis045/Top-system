<?php

/* MySQL nustatymai */

$mysql_config = array(
	'host' => 'localhost',
	'user' => '',
	'password' => '',
	'db_name' => ''
);

/*
*	slaptas raktas skirtas apsaugoti cronjob failus nuo atsitiktinio panaudojimo
* $cron_key = 'raktas';
* pvz. $cron_key = 'abc';
* kad paleistueme cron faila (is cron aplanko) jums reikes prirasyti si slapta rakta.
* pvz. http://www.manoweb.lt/system/cron/update_status.php?slaptas_raktas
*/
$cron_key = '7w5qkw84XsdasdwkDKals55974samd';

/*
* theme - naudojamas dizainas is "themes" aplanko
* system_url - pilnas kelias iki sistemos be pasvyrojo bruksnio gale
* email - sistemos administratoriaus el. pasto adresas
* skype - sistemos administratoriaus skype
* ptitle - puslapio pavadinimas, pvz L2 topai
* servers_limit - serveriu limitas (sarase)
* vip_vote_points - kiek prides tasku jei balsuojama uz vip serveri
*/
$config = array(
	'theme' => 'default',
	'home_url' => 'http://www.top.lt',
	'random_code' => '8WslhpW6f9Sxbps1684',
	
	'multiply_sms_votes' => 1,
	'multiply_free_votes_status' => false,
	'multiply_free_votes' => 1,
	'special_offer' => ''
);

$admin_ip = ''; // jei cia irasytas IP tada i administratoriaus zona bus galima prisijungti tik is sio IP

$sms_config = array(
	array(
		'keyword' => "VPSNET1 vote",
		'number' => "1398",
		'points' => number_format(50 * $config['multiply_sms_votes']),
		'price' => 1
	),
			
	array(
		'keyword' => "VPSNET2 vote",
		'number' => "1398",
		'points' =>  number_format(110 * $config['multiply_sms_votes']),
		'price' => 2
	),
			
	array(
		'keyword' => "VPSNET3 vote",
		'number' => "1398",
		'points' =>  number_format(170 * $config['multiply_sms_votes']),
		'price' => 3
	),
			
	array(
		'keyword' => "VPSNET5 vote",
		'number' => "1398",
		'points' =>  number_format(300 * $config['multiply_sms_votes']),
		'price' => 5
	),
			
	array(
		'keyword' => "VPSNET10 vote",
		'number' => "1398",
		'points' =>  number_format(650 * $config['multiply_sms_votes']),
		'price' => 10
	),
			
	array(
		'keyword' => "VPSNET15 vote",
		'number' => "1398",
		'points' =>  number_format(1200 * $config['multiply_sms_votes']),
		'price' => 15
	),
);
?>