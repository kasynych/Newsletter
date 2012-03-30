<?php
if(!empty($newsletters_groups)){
?>
<table class='list'>
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Description</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>

<?php
	foreach($newsletters_groups as $group){
?>
		<tr>
			<td valign=top><a href="<?php echo $base_url;?>index.php/admin/newsletters_groups/showNewsletters/<?php echo $group['group_id']?>"><?php echo $group['group_id']?></a></td>
			<td valign=top><a href="<?php echo $base_url;?>index.php/admin/newsletters_groups/showNewsletters/<?php echo $group['group_id']?>"><?php echo $group['title']?></a></td>
			<td valign=top><a href="<?php echo $base_url;?>index.php/admin/newsletters_groups/showNewsletters/<?php echo $group['group_id']?>"><?php echo $group['description']?></a></td>
			<td> 			
				<a href="<?php echo $base_url;?>index.php/admin/newsletters/add/group/<?php echo $group['group_id']?>">create new issue</a>
				 | 
				<a href="<?php echo $base_url;?>index.php/admin/newsletters_groups/edit/<?php echo $group['group_id']?>">edit</a>
				 | <a href="<?php echo $base_url;?>index.php/admin/newsletters_groups/delete/<?php echo $group['group_id']?>" onclick="return confirm('Are You sure You want to delete this group?')">delete</a>
			</td>
		</tr>
<?php 		
	} 
?>	
	</tbody>
	<tfoot>
		<tr>
			<td colspan=5 class="pagination">
				<?php echo isset($pagination)?$paginstion:'';?>
			</td>
		</tr>
	</tfoot>
</table>
<?php 
} 
?>