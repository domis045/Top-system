<?php if(!class_exists('raintpl')){exit;}?><!doctype html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=9" >
		<meta charset="UTF-8">
		
		<title>Lineage 2 serverių topai, l2 topai <?php echo $dynamic_title;?></title>
		
		<meta name="Author" content="Justas Ašmanavičius">
		<meta name="Description" content="Lineage2 serveriu topai">
		<meta name="Keywords" content="l2 top, l2 tops, l2 topai, lineage2 top, lineage2 tops, lineage2 topai, l2servers, topai, l2, lineage2, server, tops, serveriai, toplist, top, l2best, l2top, l2server, l2servers, l2toplist, l2game, game, gametop, l2topz">
		<meta name="Generator" content="top.llb.lt">
		
		<link rel="stylesheet" href="<?php echo $theme;?>/css/reset.css">
		<link rel="stylesheet" href="<?php echo $theme;?>/css/general.css">
		<link rel="stylesheet" href="<?php echo $theme;?>/css/messages.css">
		<link rel="stylesheet" href="<?php echo $theme;?>/css/inputs.css">
		<link rel="stylesheet" href="<?php echo $theme;?>/css/toplist.css">
		<link rel="stylesheet" href="<?php echo $theme;?>/css/admin.css">
		<link rel="stylesheet" href="<?php echo $theme;?>/css/qtip.css">
		<link rel="stylesheet" href="<?php echo $theme;?>/css/pagination.css">
		<link rel="stylesheet" href="<?php echo $theme;?>/css/vote.css">
		
		<script type='text/javascript'>
			var global_config = [];
			global_config["theme_path"] = "<?php echo $theme;?>";
			global_config["home_path"] = "<?php echo $home_path;?>";
		</script>
		
		<script src="<?php echo $theme;?>/js/jquery.js"></script>
		<script src="<?php echo $theme;?>/js/qtip.js"></script>
		<script src="<?php echo $theme;?>/js/jquery.elastic.js"></script>
		<script src="<?php echo $theme;?>/js/countdown.js"></script>
		<script src="<?php echo $theme;?>/js/script.js"></script>
		
		<meta name="google-site-verification" content="3Y9g7_NwX5DtJPgZ6g5GTNSpCa3hJ2YY9op-Fiag4N4">
	</head>
	<body>
		<div id="page_out">
			<div id="page_in">
				<div id="header">
					<div id="float_left">
						<a href='#'><img src="<?php echo $theme;?>/images/logo.jpg" alt="" title="TOP.LLB.LT" class="logo"></a>
					</div>
					
					<div id="float_right" class="short_statistic">
						Šiuo metu mūsų sistemoje yra: <span style='color: #263135; font-weight: bold;'><?php echo $total_servers;?></span> <?php echo $total_servers_text;?><br>
						<?php if( $is_logged ){ ?>Jūs prisijungęs kaip: <span style='font-weight: bold;'><?php echo $username;?></span> (<a href="<?php echo $home_path;?>/validate/logout" class="link">atsijungti</a>)<?php } ?>

					</div>
					
					<div id="clear"></div>
					
					<?php if( $is_admin ){ ?>

						<div id="config_box">
							<?php if( $show_deleted_servers ){ ?>

								<a href='<?php echo $home_path;?>/validate/deleted_servers-0'>Nerodyti ištrintų serverių</a>
							<?php }else{ ?>

								<a href='<?php echo $home_path;?>/validate/deleted_servers-1'>Rodyti ištrintus serverius</a>
							<?php } ?>

						</div>
					<?php } ?>

					
					<ul id="menu">
						<?php echo $menu;?>

					</ul>
					
					<div id="clear"></div>
				</div>
				
			
				<div id="content">
					<?php echo $content;?>

				</div>
				
				<div id="footer">
					<div id="float_left" class="copyrights">Copyright &copy; 2012 LLB.LT. All Rights Reserved.</div>
					<div id="float_right" class="designer">Design: Dgrafika.Lt</div>
					<div id="clear"></div>
				</div>
			</div>
		</div>
	</body>
</html>