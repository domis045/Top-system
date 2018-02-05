<?php
if(!defined('SYS_STARTED')) die('Security activated');
	
$three_first_images = array(
	1 => "<img src='{$theme_path}/images/icons/gold_medal_small.png' style='margin-left: -5px;' alt=''>", 
	"<img src='{$theme_path}/images/icons/silver_medal_small.png' style='margin-left: -5px;' alt=''>", 
	"<img src='{$theme_path}/images/icons/bronze_medal_small.png' style='margin-left: -5px;' alt=''>"
);
$servers_list = array();
	
$query = $db->prepare("SELECT *,rank FROM (
SELECT @rank := IF(@prev_val=votes,@rank,@rank+1) AS rank, @prev_val := votes AS 
votes, id, user_id, title, web_url, chronicle, xp, description, game_server_status, login_server_status
FROM servers WHERE deleted = '0' ORDER BY votes DESC, last_vote_date DESC
)as result LIMIT 5");
$query->execute();

if ($query->rowCount() > 0) {
	$i = 1;
	foreach ($query->fetchAll() as $key => $value) {
		$rank = get_server_rank($value['user_id']);

		$value['rank'] = (isset($three_first_images[$rank])) ? "<div class='server_rank_add'><strong>{$rank}</strong></div>" : "<div class='server_rank_add'>{$rank}</div>";
		$value['short_title'] = truncate(strtolower($value['title']), 25);
		$value['_id'] = $i;
		
		$servers_list[] = $value;
		++$i;
	}
}
	
$tpl->assign('servers_list', $servers_list);	
$tpl->draw('top5');
?>