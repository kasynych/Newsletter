<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel='stylesheet' type='text/css' media='all' href='<?php echo $base_url;?>styles_admin.css' />	
	<title>Admin</title>
</head>	
<body>
<div class="layout">
	<div class="login_form">
		<form action="<?php echo $base_url?>index.php/admin/home/login" method="post">
		<table>
			<tr>
				<td colspan=2>
					<div class="errors"><?php require_once('errors.php');?>
			<?php
			echo validation_errors(); 
			?>	
					</div>
					<div class="message"><?php echo $message?></div>
				</td>
			</tr>
			<tr>
				<td><b>Login:</b></td>
				<td><input type="text" name="name" value="" /></td>
			</tr>
			<tr>
				<td><b>Password:</b></td>
				<td><input type="password" name="password" value="" /></td>
			</tr>		
			<tr>
				<td colspan="2">
					<input type="submit" value="Login" />
				</td>
			</tr>
		</table>	
		</form>
	</div>
</div>
</body>
</html>