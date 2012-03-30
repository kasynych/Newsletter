<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">

	<link rel='stylesheet' type='text/css' media='all' href='http://localhost/newsletter/styles.css' />

	<title>Subscription form</title>

	<script src="http://localhost/newsletter/application/libraries/js/jquery.js"></script>

	<script type="text/javascript" src="http://localhost/newsletter/application/libraries/js/functions.js"></script>

</head>

<body>
<div class="layout">
<div class="errors">
<?php
require_once('errors.php');
echo validation_errors(); 
?>

</div>
<form action="<?php echo $base_url?>index.php/home" method=post>
<table>
	<tr>
		<td>Your Name:</td>
		<td><input type="text" name="name" value="<?php echo $subscriber['name']?>" /></td>
	</tr>
	<tr>
		<td>Your Email:</td>
		<td><input type="text" name="email" value="<?php echo $subscriber['email']?>" /></td>
	</tr>	
	<tr>
		<td>Email Format:</td>
		<td>
			<select name="content_type">
				<option value="html" <?php echo $subscriber['content_type']=='html'?'selected=selected':''?>>HTML</option>
				<option value="text" <?php echo $subscriber['content_type']=='text'?'selected=selected':''?>>Text</option>
			</select>
		</td>
	</tr>	
	<tr>
		<td colspan=2>
			<input type="submit" value="Subscribe" />
		</td>
	</tr>
</table>
</form>
</div>
</body>