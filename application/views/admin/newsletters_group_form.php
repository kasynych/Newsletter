<div class="errors">
<?php
echo validation_errors(); 
?>
</div>
<form action="<?php echo $base_url?>index.php/admin/newsletters_groups/<?php echo $form_action;?>" method="post">
	<table>
		<tr>
			<td>Title:</td>
			<td><input type="text" name="title" value="<?php echo $newsletters_group['title']?>" /></td>
		</tr>
		<tr>
			<td valign="top">Description:</td>
			<td><textarea name="description" cols=30 rows=5><?php echo $newsletters_group['description']?></textarea></td>
		</tr>
		<tr>
			<td colspan=2><input type="submit" value="Save" />&nbsp;&nbsp;
						  <input type="button" value="Cancel" onclick="location.href='<?php echo $base_url?>index.php/admin/newsletters'" />
			</td>
		</tr>
	</table>
</form>