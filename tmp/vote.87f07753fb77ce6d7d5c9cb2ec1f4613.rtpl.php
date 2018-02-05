<?php if(!class_exists('raintpl')){exit;}?><script type="text/javascript">
	var RecaptchaOptions = {
		theme : 'custom',
		custom_theme_widget: 'recaptcha_widget'
	};
</script>

<?php if( $server_exist ){ ?>

	<div id="servers_list_box">
		<div class="server_list top rank">Vieta</div>
		<div class="server_list top title">Pavadinimas</div>
		<div class="server_list top chronicle">Kronika</div>
		<div class="server_list top rates">Daugikliai (XP)</div>
		<div class="server_list top statistic">Serverio būklė</div>
		<div class="server_list top vote_votes">Balsų kiekis</div>
		
		<div id="clear"></div>

		<div class="servers_list_out">
			<div class="server_list_hover">
				<!-- rank -->
				<div class="server_list rank"><?php echo $data["rank"];?></div>
					
				<!-- title -->
				<div class="server_list title">
					<span class="vote_description_title" title="<?php echo $data["description"];?>">
						<a href="<?php echo $data["web_url"];?>" class="list_link" <?php echo $data["bold"];?>><?php echo $data["title"];?></a>
					</span>
				</div>
					
				<!-- chronicle -->
				<div class="server_list chronicle">
					<span class="vote_chronicle_title" title="<?php echo $data["chronicle_full"];?>"><?php echo $data["chronicle_short"];?></span>
				</div>
					
				<!-- rates -->
				<div class="server_list rates">x<?php echo $data["xp"];?></div>
					
				<!-- status -->
				<div class="server_list statistic">
					<!-- login -->
					<span class="vote_login_server_status_title" title="Login server: <?php echo $data["login_status_text"];?>">
						LS: <?php echo $data["login_status_image"];?>

					</span> 
						
					<!-- game -->
					<span class="vote_game_server_status_title" title="Game server: <?php echo $data["game_status_text"];?>">
						GS: <?php echo $data["game_status_image"];?>

					</span>
				</div>
					
				<!-- votes -->
				<div class="server_list vote_votes"><?php echo $data["votes"];?></div>
					
				<div id="clear"></div>
			</div>
		</div>
		
		<div class="line" style="width: 940px;"></div>
		
		<div id="clear"></div>
	</div>
	
	<div id="float_left">
		<div class="vote_box">
			<label>Balsavimas SMS žinutėmis</label>
			
			<table style="font-family: Tahoma; width: 300px;">
				<tr>
					<td><label>Žinutės tekstas</label></td>
					<td style="text-align: center;"><label>Numeris</label></td>
					<td style="text-align: center;"><label>Kaina</label></td>
					<td style="text-align: center;"><label>Balsai</label></td>
				</tr>
				
				<?php $counter1=-1; if( isset($sms_data) && is_array($sms_data) && sizeof($sms_data) ) foreach( $sms_data as $key1 => $value1 ){ $counter1++; ?>

					<tr>
						<td><?php echo $value1["keyword"];?> <?php echo $data["id"];?></td>
						<td style="text-align: center;"><?php echo $value1["number"];?></td>
						<td style="text-align: center;"><?php echo $value1["price"];?></td>
						<td style="text-align: center;"><?php echo $value1["points"];?></td>
					</tr>
				<?php } ?>

			</table>
			<br>
			<a href="http://www.llb.lt/kontaktai.html" target="_blank" class="link">Išsiuntei SMS, bet negavai balsų?</a>
		</div>
	</div>
	
	<div id="float_left" style="margin-left: 10px;">
		<div class="vote_box" style="min-width: 300px;">
			<label>Nemokamas balsavimas (kas 12 valandų)</label>
			
			<?php if( !$voted ){ ?> 
				<form action="<?php echo $home_path;?>/validate/vote" method="post">
					<input type="hidden" name="id" value="<?php echo $data["id"];?>">
					<input type="hidden" name="token" value="<?php echo $token;?>">
				
					<div id="recaptcha_widget" style="display:none">
						<div id="recaptcha_image"></div>
						<div class="recaptcha_only_if_incorrect_sol" style="color:red">Kodas neteisingas, bandykite dar kartą</div>

						<div class="recaptcha_only_if_image">Įveskite žodžius matomus paveikslėlyje</div>

						<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" style="width: 300px;">
						<div><a href="javascript:Recaptcha.reload()" class="link">Perkrauti apsaugos paveikslėlį</a></div>
					</div>
	 
					<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LfVPsYSAAAAAC3TohBFpFxH3kpFirdQWCi8CFH3"></script>
					 
					<noscript>
						<iframe src="http://www.google.com/recaptcha/api/noscript?k=6LfVPsYSAAAAAC3TohBFpFxH3kpFirdQWCi8CFH3" height="300" width="500" frameborder="0"></iframe><br>
						<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
						<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
					</noscript>
				
					<input type='submit' name='vote' class="g-button g-button-submit" style="margin-top: 10px; margin-left: 207px;" value="Atiduoti balsą">
				</form>
				
				<?php echo $form_response;?>

			<?php }else{ ?>

				<div class='vote_left_time_box'>Iki kito nemokamo balsavimo liko: <span id='vote_left_time_counter'></div>
				<script type="text/javascript">window.onload = CreateTimer("vote_left_time_counter", <?php echo $left_time;?>);</script>
				
				<?php echo $form_response;?>

			<?php } ?>

		</div>
	</div>
	
	<div id="float_left" style="margin-left: 10px;">
		<div class="vote_box fix">
			<label>Akcijos</label>
			
			<?php echo $offer;?>

		</div>
	</div>
	<div id="clear"></div>
	
<?php }else{ ?>

	<div class='message warning'><p>Toks serveris mūsų sistemoje nerastas</p></div>
<?php } ?>