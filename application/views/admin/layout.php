<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel='stylesheet' type='text/css' media='all' href='<?php echo $base_url;?>styles_admin.css' />
	<title>Admin<?php echo isset($data['site_title'])?' :: '.$data['site_title']:''?></title>
	<script src="<?php echo $base_url?>application/libraries/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo $base_url?>application/libraries/js/functions.js"></script>
</head>
<body>
	<div class="layout">
		<div class="header">
			<h1><a href="<?php echo $base_url?>index.php/admin/home">Admin<?php echo isset($site_title)?' :: '.$site_title:''?></a></h1>
		</div>		
		<div class="errors"><?php require_once('errors.php');?></div>
		<div class="message"><?php echo $message?></div>		
		<ul class='menu'>
			<li><a href="<?php echo $base_url?>index.php/admin/subscribers/index/reset">Subscribers</a>
				<ul>
					<li><a href="<?php echo $base_url?>index.php/admin/subscribers/add">Add Subscriber</a></li>
					<li><a href="<?php echo $base_url?>index.php/admin/subscribers/import">Import Subscribers</a></li>
					<li><a href="<?php echo $base_url?>index.php/admin/subscribers_groups">Groups</a></li>
					<li><a href="<?php echo $base_url?>index.php/admin/subscribers_groups/add">Add Group</a></li>
				</ul>
			</li>
			<li><a href="<?php echo $base_url?>index.php/admin/newsletters">Newsletters</a>
				<ul>
					<li><a href="<?php echo $base_url?>index.php/admin/newsletters/add">Add Issue</a></li>
					<li><a href="<?php echo $base_url?>index.php/admin/newsletters_groups">Groups</a></li>
					<li><a href="<?php echo $base_url?>index.php/admin/newsletters_groups/add">Add Group</a></li>
				</ul>
			</li>
			<li><a href="<?php echo $base_url?>index.php/admin/templates">Templates</a>
				<ul>
					<li><a href="<?php echo $base_url?>index.php/admin/templates/add">Add Template</a></li>
				</ul>
			</li>			
			<li><a href="<?php echo $base_url?>index.php/admin/schedules">Delivery</a>
				<ul>
					<li><a href="<?php echo $base_url?>index.php/admin/schedules/add">New Schedule</a></li>
				</ul>
			</li>
			<li><a href="<?php echo $base_url?>index.php/admin/statistics">Statistics</a></li>
			<li><a href="<?php echo $base_url?>index.php/admin/settings">Settings</a></li>					
			<li>
				<a href="<?php echo $base_url;?>index.php/admin/home/logout">Log Out</a>
			</li>
		</ul>
		<div class="content">
			<h2><?php echo isset($title)?$title:'';?></h2>		
			<?php if(isset($content)) require_once $content.'.php';?>
		</div>
	</div>
</body>
</html>