<?php require_once "content_header1.php"; ?>
<?php if(is_array($subscriber)&&!empty($subscriber)){
?>
<table id="id-form">
	<tr>
		<th>Name:</th>
		<td><?php echo $subscriber['name']?></td>
	</tr>
	<tr>
		<th>Email:</th>
		<td><?php echo $subscriber['email']?></td>
	</tr>
	<tr>
		<th>Content Type:</th>
		<td><?php echo $subscriber['content_type']?></td>
	</tr>
	<tr>
		<th valign=top>Groups:</th>
		<td>
<?php if(count($subscriber['groups'])>0)
		foreach($subscriber['groups'] as $group)
			echo '<div>'.$group['title'].'</div>';
	  else echo 'None';
?>
		</td>
	</tr>		
	<tr>
		<th>Added:</th>
		<td><?php if($subscriber['added_datetime']!='0000-00-00 00:00:00')
					echo date('d/m/Y H:i:s',strtotime($subscriber['added_datetime']));
				  else echo 'Unknown';?>
		</td>
	</tr>						
	<tr>
		<th>Status:</th>
		<td><?php echo $subscriber['status']?></td>
	</tr>						
	<tr>
		<td colspan=2>
			<input type="button" class="form-submit" onclick="document.location.href='<?php echo $base_url?>index.php/admin/subscribers/edit/<?php echo $subscriber['subscriber_id']?>'" value="Edit">
            <div class="clear"></div>
            <input type="button" class="form-reset" onclick="document.location.href='<?php echo $base_url;?>index.php/admin/subscribers'" value="<< Back">
		</td>
	</tr>	
</table>
<?php	
}else echo 'Subscriber not found';
?>
<?php require_once "content_footer1.php"; ?>