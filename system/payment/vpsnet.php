<?php
	require_once('../../core.php');

	if (checkTransaction($_GET['vps_transaction'], $_GET['vps_orderid'], $_GET['vps_status'], $_GET['vps_sum'])) {
		$date = time();
		
		$get_data = do_request($_GET, false, '');
		
		$sms = explode(' ', $get_data['vps_sms']);
		
		$query = $db->prepare("SELECT votes FROM servers WHERE id = '{$sms[1]}'");
		$query->execute();
		if ($query->rowCount() > 0) {
			$data = $query->fetch();
			
			switch($get_data['vps_sum']) {
				case 100:
					$votes_plus = 50 * $config['multiply_sms_votes'];
					break;
				
				case 200:
					$votes_plus = 110 * $config['multiply_sms_votes'];
					break;
				
				case 300:
					$votes_plus = 170 * $config['multiply_sms_votes'];
					break;
				
				case 500:
					$votes_plus = 300 * $config['multiply_sms_votes'];
					break;
				
				case 1000:
					$votes_plus = 650 * $config['multiply_sms_votes'];
					break;
				
				case 1500:
					$votes_plus = 1200 * $config['multiply_sms_votes'];
					break;
			}
				
			$new_votes = $data['votes'] + $votes_plus;
				
			$db->query("UPDATE servers SET votes = '{$new_votes}' WHERE id = '{$sms[1]}'");
			$db->query("INSERT INTO payment_log SET server_id = '{$sms[1]}', operator = '{$get_data['vps_operator']}', number = '{$get_data['vps_smsfrom']}', sum = '{$get_data['vps_sum']}', date = '{$date}', action = 'sms'");
				
			echo "OK";
		} else {
			die("Toks serveris neegzistuoja");
		}
	} else {
		die("Klaida!");
	}
	 
	function checkTransaction($transaction, $orderid, $status, $sum) {
		$passwords = array('84xx10z'); //jusu naudojami VPSnet.lt raktazodziu slaptazodziai (jei naudojate viena - irasome tik viena)
		foreach($passwords as $key=>$password) {
			$t = md5("{$password}|{".$_SERVER['REMOTE_ADDR']."}|{$orderid}|{$status}|{$sum}");
			if($transaction==$t)
				return true;
		}
		return false;
	}
?>