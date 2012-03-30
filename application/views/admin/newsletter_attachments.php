<?php
if(!empty($newsletter['attachments'])){
?>
	<table>
		<tr><td colspan=2>Existing attachments:</td></tr>
<?php	
	foreach($newsletter['attachments'] as $attachment){
?>
		<tr>
		<td>
			<?php echo $attachment['filename']?>
		</td>
		<td>
			<a href="<?php echo $base_url?>index.php/admin/newsletters/deleteAttachment/<?php echo $newsletter['newsletter_id'];?>/<?php echo $attachment['attachment_id']?>">delete</a>
		</td>
		</tr>
<?php		
	}
?></table>
<?php 
}
?>