<link rel="stylesheet" type="text/css" media="all" href="<?php echo $base_url?>application/libraries/js/calendar/jsDatePick_ltr.min.css" />
<script src="<?php echo $base_url?>application/libraries/js/calendar/jsDatePick.jquery.min.1.3.js" ></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
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

		new JsDatePick({
			useMode:2,
			target:"to",
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
<div class="errors">
<?php
echo validation_errors(); 
?>
</div>

Set time period:
<form action="<?php echo $base_url?>index.php/admin/statistics" method="post">
	<table>
		<tr>
			<td>From:</td><td><input type="text" name="from" id="from" /></td>
			<td>To:</td><td><input type="text" name="to" id="to" /></td>
			<td><input type="submit" value="Set" /></td>
		</tr>
	</table>
</form>

<table>
	<tr>
		<td>Total subscribers:</td>
		<td><?php echo $subscribers_cnt?></td>
	</tr>
	<tr>
		<td>Total active subscribers:</td>
		<td><?php echo $active_subscribers_cnt?></td>
	</tr>	
	<tr>
		<td>Total new subscribers:</td>
		<td><?php echo $new_subscribers_cnt?></td>
	</tr>	
	<tr>
		<td>Total unsubscribed:</td>
		<td><?php echo $deleted_subscribers_cnt?></td>
	</tr>	
</table>