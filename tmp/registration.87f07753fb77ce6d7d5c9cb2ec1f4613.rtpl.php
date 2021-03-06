<?php if(!class_exists('raintpl')){exit;}?><script type="text/javascript">
	var RecaptchaOptions = {
		theme : "custom",
		custom_theme_widget: "recaptcha_widget"
	};
</script>
 
<form action="<?php echo $home_path;?>/index.php?validate=registration" method="post">
	<input type="hidden" name="token" value="<?php echo $token;?>">

	<table>
		<tr>
			<td>
				<label>Slapyvardis</label>
				<input type="text" name="username" class="medium_input" value="<?php echo $username;?>">
			</td>
		</tr>
				
		<tr>
			<td style="padding-top: 5px;">
				<label>Slaptažodis</label>
				<input type="password" name="password" class="medium_input">
			</td>
		</tr>
				
		<tr>
			<td style="padding-top: 5px;">
				<label>Pakartokite slaptažodį</label>
				<input type="password" name="password_repeat" class="medium_input">
			</td>
		</tr>
				
		<tr>
			<td style="padding-top: 5px;">
				<label>El. pašto adresas</label>
				<input type="text" name="email" class="medium_input" value="<?php echo $email;?>">
			</td>
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
				<input type="submit" name="register" class="g-button g-button-submit" style="margin-left: 134px; margin-top: 15px;" value="Registruotis">
			</td>
		</tr>
	</table>
</form>

<a name="response"></a>
<?php echo $form_response;?>