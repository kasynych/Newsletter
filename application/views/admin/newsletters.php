<?php
if(!empty($newsletters)){
?>
<form action="<?php echo $base_url;?>index.php/admin/newsletters/delete" method="post">
<table class='list'>
	<thead>
		<tr>
			<th><input type="checkbox" id="select_all" /></th>
			<th>ID</th>
			<th>Subject</th>
			<th>Groups</th>
			<th>Last updated</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>

<?php
	foreach($newsletters as $newsletter){
?>
		<tr>
			<td valign=top><input type="checkbox" name="newsletter_id[]" value="<?php echo $newsletter['newsletter_id']?>" /></td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
					<?php echo $newsletter['newsletter_id']?>
				</a>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
					<?php echo $newsletter['subject']?>
				</a>
			</td>
			<td valign=top>
				<?php
					$groups_titles=explode(',<br>',$newsletter['group_title']);
					$groups_ids=explode(',',$newsletter['group_id']);

					foreach($groups_titles as $index=>$group_title)
						echo '<div><a href="'.$base_url.'index.php/admin/newsletters_groups/showNewsletters/'.$groups_ids[$index].'">'.$group_title.'</a></div>';
				?>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
					<?php echo $newsletter['updated']?>
				</a>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
					<?php echo $newsletter['status']?>
				</a>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url;?>index.php/admin/newsletters/edit/<?php echo $newsletter['newsletter_id']?>">edit</a>
				 | <a href="<?php echo $base_url;?>index.php/admin/newsletters/delete/<?php echo $newsletter['newsletter_id']?>" onclick="return confirm('Are You sure You want to delete newsletter with whole it\'s content and attachments?')">delete</a>
			</td>
		</tr>
<?php 		
	} 
?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">
				<input type="submit" value="Delete" id="delete_submit" />
			</td>
		</tr>
		<tr>
			<td colspan=5 class="pagination">
				<?php echo isset($pagination)?$pagination:'';?>
			</td>
		</tr>
	</tfoot>
</table>
</form>
<?php
}else echo 'Empty result';
if(isset($component))
	if($component=='newsletters_groups'){?><br>
	<a href="<?php echo $base_url;?>index.php/admin/newsletters/add/group/<?php echo $newsletters_group['group_id']?>">Create new issue</a><br>
<br/><a href="javascript:history.back()"><< Back</a>
<?php
	}
?>