<?php require_once "content_header1.php"; ?>
<?php if(is_array($newsletter)&&!empty($newsletter)){
?>
<table id="id-form">
	<tr>
		<th width=100px>Subject:</th>
		<td><?php echo $newsletter['subject']?></td>
	</tr>
	<tr>
		<th valign=top>Text Version:</th>
		<td><?php echo empty($newsletter['text_body'])?'None':$newsletter['text_body']?></td>
	</tr>	
	<tr>
		<th valign=top>HTML Version:</th>
		<td><?php echo empty($newsletter['html_body'])?'None':$newsletter['html_body']?></td>
	</tr>
	<tr>
		<th>Groups:</th>
		<td>
<?php if(count($newsletter['groups'])>0)
		foreach($newsletter['groups'] as $group)
			echo '<div>'.$group['title'].'</div>';
	  else echo 'None';
?>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<input type="button" class="form-submit" onclick="document.location.href='<?php echo $base_url?>index.php/admin/newsletters/edit/<?php echo $newsletter['newsletter_id']?>'" value="Edit">
            <div class="clear"></div>
            <input type="button" class="form-reset" onclick="document.location.href='<?php echo $base_url;?>index.php/admin/newsletters'" value="<< Back">
		</td>
	</tr>
</table>
<?php if(isset($schedules)){
 echo '<h3>Schedules</h3>';
	foreach($schedules as $index=>$schedule){
		require('schedule_details.php');
		if($index<count($schedules)-1) echo '<hr>';
	}
}?>	
<?php 
}else echo 'Newsletter not found';?>

<?php require_once "content_footer1.php"; ?>