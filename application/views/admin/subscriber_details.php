<?php if(is_array($subscriber)&&!empty($subscriber)){
?>
<table>
	<tr>
		<td>Name:</td>
		<td><?php echo $subscriber['name']?></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><?php echo $subscriber['email']?></td>
	</tr>
	<tr>
		<td>Content Type:</td>
		<td><?php echo $subscriber['content_type']?></td>
	</tr>
	<tr>
		<td valign=top>Groups:</td>
		<td>
<?php if(count($subscriber['groups'])>0)
		foreach($subscriber['groups'] as $group)
			echo '<div>'.$group['title'].'</div>';
	  else echo 'None';
?>
		</td>
	</tr>		
	<tr>
		<td>Added:</td>
		<td><?php if($subscriber['added_datetime']!='0000-00-00 00:00:00')
					echo date('d/m/Y H:i:s',strtotime($subscriber['added_datetime']));
				  else echo 'Unknown';?>
		</td>
	</tr>						
	<tr>
		<td>Status:</td>
		<td><?php echo $subscriber['status']?></td>
	</tr>						
	<tr>
		<td colspan=2>
			<input type="button" onclick="document.location.href='<?php echo $base_url?>index.php/admin/subscribers/edit/<?php echo $subscriber['subscriber_id']?>'" value="Edit">
			</br><a href="<?php echo $base_url;?>index.php/admin/subscribers">&lt;&lt;back</a>
		</td>
	</tr>	
</table>
<?php	
}else echo 'Subscriber not found';
?>