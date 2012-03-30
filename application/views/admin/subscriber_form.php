<div class="errors">
<?php
echo validation_errors(); 
?>
</div>
<form action="<?php echo $base_url?>index.php/admin/subscribers/<?php echo $form_action;?>" method="post">
	<table>
		<tr>
			<td>Name:</td>
			<td>
				<input type="text" 
					   name="name" 
					   value="<?php echo $subscriber['name']?>" />
			</td>
		</tr>
		<tr>
			<td>Email:</td>
			<td>
				<input type="text" 
					   name="email" 
					   value="<?php echo $subscriber['email']?>" />
			</td>
		</tr>
		<tr>
			<td>Content Type:</td>
			<td>
				<select name="content_type">
					<option value="html" 
							<?php echo $subscriber['content_type']=='html'?'selected=selected':''?>>
						HTML
					</option>					
					<option value="text" 
							<?php echo $subscriber['content_type']=='text'?'selected=selected':''?>>
						Text
					</option>				
				</select>
			</td>
		</tr>
<?php
if(isset($groups)&&count($groups)>0){
?>					
		<tr>
			<td valign=top>Group:</td>
			<td>
<?php
	foreach($groups as $group){
?>				<div>
					<input type="checkbox"
						   name="group_id[]"
						   id="group_<?php echo $group['group_id']?>"
					   	   value="<?php echo $group['group_id']?>"
					   	   <?php echo in_array($group['group_id'],$subscriber['groups'])?'checked=checked':''?> /> 
					 	   <label for="group_<?php echo $group['group_id']?>"><?php echo $group['title']?></label>
				</div>					 	  
<?php
	} 
?>
			</td>
		</tr>		
<?php
} 
?>		
		<tr>
			<td>Status:</td>
			<td>
				<select name="status">
					<option value="new" 
							<?php echo $subscriber['status']=='new'?'selected=selected':''?>>
						New
					</option>
					<option value="subscribed" 
							<?php echo $subscriber['status']=='subscribed'?'selected=selected':''?>>
						Subscribed
					</option>
					<option value="deleted" 
							<?php echo $subscriber['status']=='deleted'?'selected=selected':''?>>
						Deleted
					</option>										
				</select>		
			</td>
		</tr>
		<tr>
			<td colspan=2>
				<input type="submit" value="Save">&nbsp;&nbsp;
				<input type="button" value="Cancel" onclick="javascript:location.href='<?php echo $base_url?>index.php/admin/subscribers'" />				
			</td>
		</tr>
	</table>
</form>