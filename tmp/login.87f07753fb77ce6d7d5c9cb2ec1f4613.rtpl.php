<?php if(!class_exists('raintpl')){exit;}?><div id="alignc_out">
	<div id="alignc_in">
		<form action="<?php echo $home_path;?>/validate/login" method="post">
			<input type="hidden" name="token" value="<?php echo $token;?>">
			
			<table>
				<tr>
					<td style="padding-top: 5px;">
						<label style="text-align: left;">Slapyvardis</label>
						<input type="text" name="username" class="medium_input">
					</td>
				</tr>
					
				<tr>
					<td style="padding-top: 5px;">
						<label style="text-align: left;">Slaptažodis (<a href="<?php echo $home_path;?>/go/restore_password" class="link" style="font-weight: normal;">pamiršai slaptažodį?</a>)</label>
						<input type="password" name="password" class="medium_input">
					</td>
				</tr>
					
				<tr>
					<td align="right">
						<input type="submit" name="login" class="g-button g-button-submit" style="margin-top: 10px;" value="Prisijungti">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<a name="response"></a>
<?php echo $form_response;?>