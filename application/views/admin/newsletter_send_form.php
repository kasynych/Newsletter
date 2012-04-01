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

	$(document).ready(function(){
		$(':input[name=send_now]').click(function(){
			$('#send_date').val('Now');
			return false;
		});
	})
</script>
<?php echo 'Server time: '.date('D/m/Y H:i:s')?>
<table>
	<tr>
		<th valign=top>Choose Subscriber(s):</th>
		<td id="subscribers">
			<select name="subscriber_id[]" multiple>
<?php if(!empty($subscribers)){
		foreach($subscribers as $subscriber){
?>
			<option value="<?php echo $subscriber['subscriber_id']?>"
					<?php echo in_array($subscriber['subscriber_id'],$schedule['subscribers'])?'selected=selected':''?>><?php echo $subscriber['name']?>
			</option>
<?php			
		}
?>
<?php }?>			
			</select>
		</td>
	</tr>
	<tr>
		<th>OR</th>
	</tr>	
	<tr>
		<th valign=top>Choose Subscribers Groups:</th>
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
		<th>Set timing rule:</th>
		<td id='time_rules'><input type="text"  class="inp-form"
								   name="time_rules"
								   value="<?php echo $schedule['time_rules']?>" /></td>
	</tr>
	<tr>
		<th>OR</th>
	</tr>
	<tr>
		<th>Set sending date and time:</th>
		<td id="date">
			<input type="text" 
				   name="send_date"
                   class="inp-form"
				   id="send_date" 
				   value="<?php echo $schedule['send_date']?>" />&nbsp;
			&nbsp;Hour:&nbsp;<input type="text" class="inp-form" name="send_hour" size=2 value="<?php echo $schedule['send_hour']?>">
			&nbsp;Minute:&nbsp;<input type="text" class="inp-form" name="send_minute" size=2 value="<?php echo $schedule['send_minute']?>">
			&nbsp;&nbsp;<input type="button" value="Now" name="send_now">
		</td> 
	</tr>
</table>