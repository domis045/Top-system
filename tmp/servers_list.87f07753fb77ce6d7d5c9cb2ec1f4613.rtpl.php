<?php if(!class_exists('raintpl')){exit;}?><div id="servers_list_box">
	<div class="server_list top rank">Vieta</div>
	<div class="server_list top title">Pavadinimas</div>
	<div class="server_list top chronicle">Kronika</div>
	<div class="server_list top rates">Daugikliai (XP)</div>
	<div class="server_list top statistic">Serverio būklė</div>
	<div class="server_list top votes">Balsų kiekis</div>
	<div class="server_list top vote">Balsavimas</div>
	
	<div id="clear"></div>

	<div class="servers_list_out">
		<?php $counter1=-1; if( isset($servers_list) && is_array($servers_list) && sizeof($servers_list) ) foreach( $servers_list as $key1 => $value1 ){ $counter1++; ?>

			<div class="server_list_hover <?php if( $is_admin && $value1["deleted"] && $show_deleted_servers ){ ?>deleted_opacity<?php } ?>">
				<?php if( $is_admin ){ ?>

					<!-- delete -->
					<div style="position: absolute; margin-left: -75px;">
						<?php echo $value1["delete_completely"];?>

						<span style='margin-left: 10px;'><?php echo $value1["delete"];?></span>
					</div>
				<?php } ?>

			
				<!-- rank -->
				<div class="server_list rank"><?php echo $value1["rank"];?></div>
				
				<!-- title -->
				<div class="server_list title">
					<span class="description_title" title="<?php echo $value1["description"];?>">
						<a href="<?php echo $value1["web_url"];?>" class="list_link" <?php echo $value1["bold"];?> target="_blank"><?php echo $value1["title"];?></a>
					</span>
				</div>
				
				<!-- chronicle -->
				<div class="server_list chronicle">
					<span class="chronicle_title" title="<?php echo $value1["chronicle_full"];?>"><?php echo $value1["chronicle_short"];?></span>
				</div>
				
				<!-- rates -->
				<div class="server_list rates">x<?php echo $value1["xp"];?></div>
				
				<!-- status -->
				<div class="server_list statistic">
					<!-- login -->
					<span class="login_server_status_title" title="Login server: <?php echo $value1["login_status_text"];?>">
						LS: <?php echo $value1["login_status_image"];?>

					</span> 
					
					<!-- game -->
					<span class="game_server_status_title" title="Game server: <?php echo $value1["game_status_text"];?>">
						GS: <?php echo $value1["game_status_image"];?>

					</span>
				</div>
				
				<!-- votes -->
				<div class="server_list votes"><?php echo $value1["votes"];?></div>
				
				<!-- vote -->
				<div class="server_list vote">
					<a href="<?php echo $home_path;?>/vote-<?php echo $value1["id"];?>" class="list_link" title="Balsuoti">
						<img src="<?php echo $theme;?>/images/icons/vote_off.png" class="list_vote_img" alt=""> Balsuoti
					</a>
				</div>
				
				<?php echo $value1["line"];?>

				
				<div id="clear"></div>
			</div>
		<?php } ?>

	</div>
	
	<div id="pagination">
		<?php echo $pagination;?>

	</div>
	
	<div id="clear"></div>
</div>