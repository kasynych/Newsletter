<?php if(is_array($template)&&!empty($template)){
?>
<table>
	<tr>
		<td>Subject:</td>
		<td><?php echo $template['subject']?></td>
	</tr>
	<tr>
		<td valign=top>Text Version:</td>
		<td><?php echo empty($template['text_body'])?'None':$template['text_body']?></td>
	</tr>	
	<tr>
		<td valign=top>HTML Version:</td>
		<td><?php echo empty($template['html_body'])?'None':$template['html_body']?></td>
	</tr>
	<tr>
		<td colspan=2>
			<input type="button" onclick="document.location.href='<?php echo $base_url?>index.php/admin/templates/edit/<?php echo $template['template_id']?>'" value="Edit">
			</br><a href="<?php echo $base_url;?>index.php/admin/templates">&lt;&lt;back</a>
		</td>
	</tr>
</table>
<?php 
}else echo 'Template not found';?>