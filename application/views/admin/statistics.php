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
<?php require_once "content_header1.php"; ?>
<b>Set time period:</b>
<form action="<?php echo $base_url?>index.php/admin/statistics" method="post">
    <table id="id-form">
        <tr>
            <th>From:</th><td><input type="text" name="from" id="from" /></td>
        </tr>
        <tr>
            <th>To:</th><td><input type="text" name="to" id="to" /></td>
        </tr>
        <tr>
            <td><input type="submit" value="Set" class="form-submit2" /></td>
        </tr>
    </table>
</form>
<br><br>
<table id="id-form">
    <tr>
        <td><b>Total subscribers:</b></td>
        <td><b><?php echo $subscribers_cnt?></b></td>
    </tr>
    <tr>
        <td><b>Total active subscribers:</b></td>
        <td><b><?php echo $active_subscribers_cnt?></b></td>
    </tr>
    <tr>
        <td><b>Total new subscribers:</b></td>
        <td><b><?php echo $new_subscribers_cnt?></b></td>
    </tr>
    <tr>
        <td><b>Total unsubscribed:</b></td>
        <td><b><?php echo $deleted_subscribers_cnt?></b></td>
    </tr>
</table>
<?php require_once "content_footer1.php"; ?>