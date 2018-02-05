<?php if(!class_exists('raintpl')){exit;}?><div style="float: left; color: #cde0f2; font-size: 11px; margin-bottom: 4px; margin-left: 5px;">
	Top 5 serveriai
</div>

<div style="float: right; margin-bottom: 4px; margin-right: 5px;">
	<a href="http://www.top.llb.lt" style="color: #cde0f2; font-size: 11px;" target="_blank">Visi serveriai</a>
</div>
	
<div class='simple_clear'></div>

<?php $counter1=-1; if( isset($servers_list) && is_array($servers_list) && sizeof($servers_list) ) foreach( $servers_list as $key1 => $value1 ){ $counter1++; ?>

	<div class='lfpb_line <?php if( $value1["_id"] == 1 ){ ?>lfpb_line_rounded_top<?php } ?><?php if( $value1["_id"] == 5 ){ ?>lfpb_line_rounded_bottom<?php } ?> qtip_left' title='<?php echo $value1["title"];?>'>
		<div class='lfpb_top5_body server_rank' style='float: left; width: 10px; margin-left: 3px;'>
			<span class='lf_stext2'><?php echo $value1["rank"];?></span>
		</div>
			
		<div class='lfpb_top5_body server_title' style='float: left; width: 140px;'>
			<a href='<?php echo $value1["web_url"];?>' style='text-decoration: none;'  target='_blank'><?php echo $value1["short_title"];?></a>
		</div>
			
		<div class='lfpb_top5_body server_votes' style='float: right; width: 35px; margin-right: 3px'>
			<span class='lf_stext2'><?php echo $value1["votes"];?></span>
		</div>
			
		<div class='simple_clear'></div>
	</div>
<?php } ?>