<?php
if(!empty($templates)){
?>
<script type="text/javascript">
<!--
$(document).ready(function(){
	$('#delete_submit').click(function(){
		$('form').attr('action','<?php echo $base_url;?>index.php/admin/templates/delete');
	});
})
//-->
</script>
<form action="<?php echo $base_url;?>index.php/admin/templates/setDefault" method="post">
<table class='list'>
	<thead>
		<tr>
			<th width=20px><input type="checkbox" id="select_all" /></th>
			<th width=30px></th>
			<th>ID</th>
			<th>Subject</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>

<?php
	foreach($templates as $template){
?>
		<tr>
			<td valign=top><input type="checkbox" name="template_id[]" value="<?php echo $template['template_id']?>" /></td>
			<td valign=top>
				<input type="radio" 
					   name="template_id" 
					   value="<?php echo $template['template_id']?>"
					   <?php echo $template['default']==1?'checked=checked':''?> />
			</td>		
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/templates/showDetails/<?php echo $template['template_id']?>">
					<?php echo $template['template_id']?>
				</a>
			</td>
			<td valign=top>
				<a href="<?php echo $base_url?>index.php/admin/templates/showDetails/<?php echo $template['template_id']?>">
					<?php echo $template['subject']?>
				</a>
			</td>
			<td>
				<a href="<?php echo $base_url;?>index.php/admin/templates/edit/<?php echo $template['template_id']?>">edit</a>
				 | <a href="<?php echo $base_url;?>index.php/admin/templates/delete/<?php echo $template['template_id']?>" onclick="return confirm('Are You sure You want to delete this template?')">delete</a>
			</td>
		</tr>
<?php 		
	} 
?>	
	</tbody>
	<tfoot>
		<tr>
			<td>
				<input type="submit" id="delete_submit" value="Delete" />
			</td>
			<td>
				
				<input type="Submit" value="Default">
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