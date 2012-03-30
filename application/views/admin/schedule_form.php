<div class="errors">
<?php
echo validation_errors(); 
?>
</div>
Server time: <?php echo date('d/m/Y H:i:s');?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $base_url?>application/libraries/js/calendar/jsDatePick_ltr.min.css" />
<script src="<?php echo $base_url?>application/libraries/js/calendar/jsDatePick.jquery.min.1.3.js" ></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"send_date",
			dateFormat:"%d/%m/%Y"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
	};
</script>
<form action="<?php echo $base_url?>index.php/admin/schedules/<?php echo $form_action;?>" method="post">
<table>
	<tr>
		<td>Title:</td>
		<td><input type="text" name="title" value="<?php echo $schedule['title']?>" /></td>
	</tr>
	<tr>
		<td>Choose Newsletter:</td>
		<td>
			<select name="newsletter_id">
<?php if(!empty($newsletters)){
		foreach($newsletters as $newsletter){
?>
			<option value="<?php echo $newsletter['newsletter_id']?>"
					<?php echo $newsletter['newsletter_id']==$schedule['newsletter_id']?'selected=selected':''?>>
				<?php echo $newsletter['subject']?>
			</option>
<?php			
		}
?>
<?php }?>			
			</select>
		</td>
	</tr>
	<tr>
		<td valign=top>Choose Subscriber(s):</td>
		<td id="subscribers">
			<select name="subscriber_id[]" multiple>
<?php if(!empty($subscribers)){
		foreach($subscribers as $subscriber){
?>
			<option value="<?php echo $subscriber['subscriber_id']?>"
					<?php echo in_array($subscriber['subscriber_id'],$schedule['subscribers'])?'selected=selected':''?>>
				<?php echo $subscriber['name']?>
			</option>
<?php			
		}
?>
<?php }?>			
			</select>
		</td>
	</tr>
	<tr>
		<td>OR</td>
	</tr>	
	<tr>
		<td valign=top>Choose Subscribers Groups:</td>
		<td id="subscribers_groups">
			<select name="subscriber_group_id[]" multiple>
<?php if(!empty($subscribers_groups)){
		foreach($subscribers_groups as $subscribers_group){
?>
			<option value="<?php echo $subscribers_group['group_id']?>"
					<?php echo in_array($subscribers_group['group_id'],$schedule['groups'])?'selected=selected':''?>>
				<?php echo $subscribers_group['title']?>
			</option>
<?php			
		}
?>
<?php }?>			
			</select>
		</td>
	</tr>
	<tr><td colspan=2><hr /></td></tr>
	<tr>
		<td>Set timing rule:</td>
		<td id='time_rules'><input type="text" 
								   name="time_rules"
								   value="<?php echo $schedule['time_rules']?>" /></td>
	</tr>
	<tr>
		<td>OR</td>
	</tr>
	<tr>
		<td>Set sending date and time:</td>
		<td id="date">
			<input type="text" 
				   name="send_date" 
				   id="send_date" 
				   value="<?php echo $schedule['send_date']?>" />&nbsp;
			&nbsp;Hour:&nbsp;<input type="text" name="send_hour" size=2 value="<?php echo $schedule['send_hour']?>">
			&nbsp;Minute:&nbsp;<input type="text" name="send_minute" size=2 value="<?php echo $schedule['send_minute']?>">
		</td> 
	</tr>
	<tr>
		<td colspan=2>
			<input type="submit" value="Save" name="submit">&nbsp;&nbsp;
			<input type="button" value="Cancel" onclick="javascript:location.href='<?php echo $base_url?>index.php/admin/schedules'" />				
		</td>
	</tr>
</table>
</form>