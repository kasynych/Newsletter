<?php if($show_newsletter===true){?>
<?php require_once "content_header1.php"; ?>
<?php }?>
<?php if(is_array($schedule)&&!empty($schedule)){
?>
<table id="id-form">
<?php if($show_newsletter===true){?>
	<tr>
		<th>Newsletter:</th>
		<td>
			<a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
				<?php echo $newsletter['subject']?>
			</a>
		</td>
	</tr>
<?php }?>
	<tr>
		<th>Schedule Title:</th>
		<td><?php echo $schedule['title']?></td>
	</tr>
	<tr>
		<th valign=top>Subscribers:</th>
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
		<th>Time:</th>
		<td>
			<?php echo (!empty($schedule['time_rules'])?$schedult['time_rules']:$schedule['send_datetime'])?>
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<input type="button" class="form-submit" onclick="document.location.href='<?php echo $base_url?>index.php/admin/schedules/edit/<?php echo $schedule['schedule_id']?>'" value="Edit">
<?php if($show_newsletter===true){?>
            <div class="clear"></div>
            <input type="button" class="form-reset" onclick="document.location.href='<?php echo $base_url;?>index.php/admin/schedules'" value="<< Back" />
<?php }?>
		</td>
	</tr>	
</table>
<?php 
}else echo 'Schedule not found';?>
<?php if($show_newsletter===true){
 require_once "content_footer1.php";
}?>