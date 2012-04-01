<?php require_once "content_header1.php"; ?>
<?php if(is_array($template)&&!empty($template)){
?>
<table id="id-form">
	<tr>
		<th>Subject:</th>
		<td><?php echo $template['subject']?></td>
	</tr>
	<tr>
		<th valign=top>Text Version:</th>
		<td><?php echo empty($template['text_body'])?'None':$template['text_body']?></td>
	</tr>	
	<tr>
		<th valign=top>HTML Version:</th>
		<td><?php echo empty($template['html_body'])?'None':$template['html_body']?></td>
	</tr>
	<tr>
		<td colspan=2>
			<input type="button" class="form-submit" onclick="document.location.href='<?php echo $base_url?>index.php/admin/templates/edit/<?php echo $template['template_id']?>'" value="Edit">
            <div class="clear"></div>
            <input type="button" class="form-reset" onclick="'<?php echo $base_url;?>index.php/admin/templates'" value="<< Back">
		</td>
	</tr>
</table>
<?php 
}else echo 'Template not found';?>
<?php require_once "content_footer1.php"; ?>