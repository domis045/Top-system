<?php if(!class_exists('raintpl')){exit;}?><script type="text/javascript">
	var RecaptchaOptions = {
		theme : "custom",
		custom_theme_widget: "recaptcha_widget"
	};
</script>

<form action="<?php echo $home_path;?>/validate/restore_password" method="post">
	<input type="hidden" name="token" value="<?php echo $token;?>">

	<table>
		<tr>
			<td>
				<label>Slapyvardis arba el. pašto adresas</label>
				<input type="text" name="lost_password_data" class="medium_input">
			<td>
		</tr>
			
		<tr>
			<td style="padding-top: 5px;">
				<div id="recaptcha_widget" style="display:none">
					<div id="recaptcha_image"></div>
					<div class="recaptcha_only_if_incorrect_sol" style="color:red">Kodas neteisingas, bandykite dar kartą</div>

					<div class="recaptcha_only_if_image">Įveskite žodžius matomus paveikslėlyje</div>

					<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="medium_input">
					<div><a href="javascript:Recaptcha.reload()" class="link">Perkrauti apsaugos paveikslėlį</a></div>
				</div>
 
				<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LfVPsYSAAAAAC3TohBFpFxH3kpFirdQWCi8CFH3"></script>
				 
				<noscript>
					<iframe src="http://www.google.com/recaptcha/api/noscript?k=6LfVPsYSAAAAAC3TohBFpFxH3kpFirdQWCi8CFH3" height="300" width="500" frameborder="0"></iframe><br>
					<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
					<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
				</noscript>
			</td>
		</tr>
			
		<tr>
			<td>
				<input type="submit" name="lost_password" class="g-button g-button-submit" style="margin-left: 99px; margin-top: 15px;" value="Pakeisti slaptažodį">
			</td>
		</tr>
	</table>
</form>

<a name="response"></a>
<?php echo $form_response;?>