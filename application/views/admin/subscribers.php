<?php
if(!empty($subscribers)){
?>
<script>
	$(document).ready(function(){
		$('#reset_subscribers_search').click(function(){
			document.location.href='<?php echo $base_url;?>index.php/admin/subscribers/search/reset';
		});
		$(':input[name=group_id]').click(function(){
			$('form').attr('action','<?php echo $base_url;?>index.php/admin/subscribers/'+$('#group_action').val()+'/'+$(this).attr('id'));
			$('form').attr('target','_self');
			$(this).val($(this).attr('id'));
		});
		$('#delete_submit').click(function(){
			$('form').attr('action','<?php echo $base_url;?>index.php/admin/subscribers/delete');
			$('form').attr('target','_self');		
		});
		$('#delete_submit2').click(function(){
			if(!confirm('Are You sure?')) return false
			$('form').attr('action','<?php echo $base_url;?>index.php/admin/subscribers/deleteForever');
			$('form').attr('target','_self');		
		});		
<?php if(isset($subscribers_group)){
?>
		$('#exclude_from_group').click(function(){
			$('form').attr('action','<?php echo $base_url;?>index.php/admin/subscribers_groups/excludeSubscribers/<?php echo $subscribers_group['group_id']?>');
			$('form').attr('target','_self');			
		});
<?php }?>		
	});

</script>
<form action="<?php echo $base_url;?>index.php/admin/subscribers/search" method="post">
	<input type="text" name="search" value="<?php echo isset($search)?$search:''?>" />&nbsp;
	<input type="submit" value="Search" />
	<input type="button" value="Reset" id="reset_subscribers_search" />
</form>
<form action="<?php echo $base_url;?>index.php/admin/subscribers/export" method="post" target="_blank">
<table class='list'>
	<thead>
		<tr>
			<th><input type="checkbox" id="select_all" /></th>
			<th>ID</th>
			<th width="80px">Name</th>
<?php	if(isset($component)&&$component=='subscribers_groups'){?>
			<th width="80px">Group</th>
			<th width="150px">Email</th>
			<th width="150px">Email Content Type</th>
			<th width="50px">Status</th>
<?php }else{?>
					
			<th width="80px"><a href="<?php echo $base_url;?>index.php/admin/subscribers/index/order/title">Group</a></th>
			<th width="150px">Email</th>
			<th width="150px"><a href="<?php echo $base_url;?>index.php/admin/subscribers/index/order/content_type">Email Content Type</a></th>
			<th width="50px"><a href="<?php echo $base_url;?>index.php/admin/subscribers/index/order/status">Status</a></th>

<?php }?>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>

<?php
	foreach($subscribers as $subscriber){
?>
		<tr>
			<td valign=top><input type="checkbox" name="subscriber_id[]" value="<?php echo $subscriber['subscriber_id']?>" /></td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
					<?php echo $subscriber['subscriber_id']?>
				</a>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
					<?php echo $subscriber['name']?>
				</a>
			</td>
			<td valign=top>
				<?php
					$groups_titles=explode(',<br>',$subscriber['group_title']);
					$groups_ids=explode(',',$subscriber['group_id']);

					foreach($groups_titles as $index=>$group_title)
						echo '<div><a href="'.$base_url.'index.php/admin/subscribers_groups/showSubscribers/'.$groups_ids[$index].'">'.$group_title.'</a></div>';
				?>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
					<?php echo $subscriber['email']?>
				</a>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
					<?php echo $subscriber['content_type']?>
				</a>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
					<?php echo $subscriber['status']?>
				</a>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url;?>index.php/admin/subscribers/edit/<?php echo $subscriber['subscriber_id']?>">edit</a>
				<?php if($subscriber['status']!=='deleted'){?>
				 | <a href="<?php echo $base_url;?>index.php/admin/subscribers/delete/<?php echo $subscriber['subscriber_id']?>" onclick="return confirm('Are You sure You want to delete this subscriber?')">delete</a>
				<?php }
					  if($subscriber['status']!=='subscribed'){?> 
				 | <a href="<?php echo $base_url;?>index.php/admin/subscribers/activate/<?php echo $subscriber['subscriber_id']?>">activate</a>				
				<?php }?>
			</td>
		</tr>
<?php 		
	} 
?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan=8>
				<input type="submit" value="Delete" id="delete_submit" /></br>
				<input type="submit" value="Delete forever" id="delete_submit2" /></br>
				<input type="Submit" value="Export">
<?php
if(!empty($subscribers_groups)){
?>
				<br>
				<select id="group_action">
					<option value="setGroup">Move to group</option>
					<option value="copyToGroup">Copy to group</option>
				</select>:
<?php 
	foreach($subscribers_groups as $group){
?>	
				<input type="submit" name="group_id" value="<?php echo $group['title']?>" id="<?php echo $group['group_id']?>" />
<?php
	}
} 

if(isset($component))
	if($component=='subscribers_groups'){?>
&nbsp;&nbsp;<input type="submit" value="Exclude from group" id='exclude_from_group' />
<?php
	}
?>			
			</td>
		</tr>
		<tr>
			<td colspan=8 class="pagination">
				<?php echo isset($pagination)?$pagination:'';?>
			</td>
		</tr>
	</tfoot>
</table>
</form>
<?php
}else echo 'Empty result';
if(isset($component))
	if($component=='subscribers_groups'){?>
</br><a href="<?php echo $base_url?>index.php/admin/subscribers/add/group/<?php echo $subscribers_group['group_id']?>">Add subscriber</a>
<br/><a href="javascript:history.back()"><< Back</a>
<?php
	}
?>