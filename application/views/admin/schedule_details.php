<?php if(is_array($schedule)&&!empty($schedule)){
?>
<table>
<?php if($show_newsletter===true){?>
	<tr>
		<td>Newsletter:</td>
		<td>
			<a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
				<?php echo $newsletter['subject']?>
			</a>
		</td>
	</tr>
<?php }?>
	<tr>
		<td>Schedule Title:</td>
		<td><?php echo $schedule['title']?></td>
	</tr>
	<tr>
		<td valign=top>Subscribers:</td>
		<td>
<?php
		if(count($schedule['subscribers'])>0){
			foreach($schedule['subscribers'] as $subscriber){
?>
			<div><a href="<?php $base_url?>index.php/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
				<?php echo $subscriber['email']?>
			</a></div>
<?php				
			}
		}else echo 'None';		 
?>
		</td>
	</tr>	
	<tr>
		<td>Time:</td>
		<td>
			<?php echo (!empty($schedule['time_rules'])?$schedult['time_rules']:$schedule['send_datetime'])?>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<input type="button" onclick="document.location.href='<?php echo $base_url?>index.php/admin/schedules/edit/<?php echo $schedule['schedule_id']?>'" value="Edit">
<?php if($show_newsletter===true){?>			
			</br><a href="<?php echo $base_url;?>index.php/admin/schedules">&lt;&lt;back</a>
<?php }?>
		</td>
	</tr>	
</table>
<?php 
}else echo 'Schedule not found';?>