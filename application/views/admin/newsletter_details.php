<?php if(is_array($newsletter)&&!empty($newsletter)){
?>
<table>
	<tr>
		<td>Subject:</td>
		<td><?php echo $newsletter['subject']?></td>
	</tr>
	<tr>
		<td valign=top>Text Version:</td>
		<td><?php echo empty($newsletter['text_body'])?'None':$newsletter['text_body']?></td>
	</tr>	
	<tr>
		<td valign=top>HTML Version:</td>
		<td><?php echo empty($newsletter['html_body'])?'None':$newsletter['html_body']?></td>
	</tr>
	<tr>
		<td>Groups:</td>
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
			<input type="button" onclick="document.location.href='<?php echo $base_url?>index.php/admin/newsletters/edit/<?php echo $newsletter['newsletter_id']?>'" value="Edit">
			</br><a href="<?php echo $base_url;?>index.php/admin/newsletters">&lt;&lt;back</a>
		</td>
	</tr>
</table>
<?php if(isset($schedules)){
 echo '<h3>Schedules</h3>';
	foreach($schedules as $index=>$schedule){
		require('schedule_details.php');
		if($index<count($schedules)) echo '<hr>';
	}
}?>	
<?php 
}else echo 'Newsletter not found';?>