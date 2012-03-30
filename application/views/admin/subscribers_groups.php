<?php
if(!empty($subscribers_groups)){
?>
<form action="<?php echo $base_url;?>index.php/admin/subscribers_groups/setDefault" method="post">
<table class='list'>
	<thead>
		<tr>
			<th width=30px></th>
			<th>ID</th>
			<th>Title</th>
			<th>Description</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>

<?php
	foreach($subscribers_groups as $group){
?>
		<tr>
			<td valign=top>
				<input type="radio" 
					   name="group_id" 
					   value="<?php echo $group['group_id']?>"
					   <?php echo $group['default']==1?'checked=checked':''?> />
			</td>
			<td valign=top><a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/showSubscribers/<?php echo $group['group_id']?>"><?php echo $group['group_id']?></a></td>
			<td valign=top><a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/showSubscribers/<?php echo $group['group_id']?>"><?php echo $group['title']?></a></td>
			<td valign=top><a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/showSubscribers/<?php echo $group['group_id']?>"><?php echo $group['description']?></a></td>
			<td> 			
				<a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/edit/<?php echo $group['group_id']?>">edit</a>
				 | <a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/delete/<?php echo $group['group_id']?>" onclick="return confirm('Are You sure You want to delete this group?')">delete</a>
			</td>
		</tr>
<?php 		
	} 
?>	
	</tbody>
	<tfoot>
		<tr>
			<td colspan=5>
				<input type="Submit" value="Set Default">
			</td>		
		</tr>
		<tr>
			<td colspan=5 class="pagination">
				<?php echo isset($pagination)?$paginstion:'';?>
			</td>
		</tr>
	</tfoot>
</table>
</form>
<?php 
} 
?>