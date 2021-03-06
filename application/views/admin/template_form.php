<script>
	$(document).ready(function(){
		$('#text_body').hide();
		$('#text_label,#html_label').click(function(){
			$('#text_body').toggle('fast');
			$('#html_area').toggle('fast');
		});

	});
</script>
<script type="text/javascript" src="<?php echo $base_url?>application/libraries/js/ckeditor/ckeditor.js"></script>
<?php require_once "content_header1.php"; ?>
<form action="<?php echo $base_url?>index.php/admin/templates/<?php echo $form_action;?>" method="post">
    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
        <tr>
            <th>Subject:</th>
            <td><input type="text" class="inp-form" name="subject" value="<?php echo $template['subject']?>" size=70 /></td>
        </tr>
        <tr>
            <th valign="top" width=100><a href="javascript:void(0);" id="text_label">Text Version</a>:</th>
            <td><textarea name="text_body" rows="10" cols="70" class="form-textarea" id="text_body"><?php echo $template['text_body']?></textarea></td>
        </tr>
        <tr>
            <th valign="top"><a href="javascript:void(0);" id="html_label">HTML Version</a>:</th>
            <td><div id="html_area"><textarea name="html_body" cols=30 rows=5><?php echo $template['html_body']?></textarea></div>
                <script type="text/javascript">

                    CKEDITOR.replace( 'html_body',
                            {
                        toolbar : [
                                    { name: 'document', items : [ 'Source']},
                                    { name: 'basicstyles', items : [ 'Bold','Italic' ] },
                                    { name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
                                    { name: 'tools', items : [ 'Maximize','-','About' ] },
                                    { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'
                                                                ,'Iframe' ] },
                                    { name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
                                    { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
                                    { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                                    { name: 'tools', items : [ 'Maximize','-','About' ] },
                                    { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
                                    { name: 'colors', items : [ 'TextColor','BGColor' ] },
                                    { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
                                ]
                    });
                </script>
            </td>
        </tr>
        <tr>
            <td colspan=2><input type="submit" value="Save" class="form-submit" />&nbsp;&nbsp;
                          <input type="button" value="Cancel" class="form-reset" onclick="javascript:location.href='<?php echo $base_url?>index.php/admin/templates'" />
            </td>
        </tr>
    </table>
</form>
<?php require_once "content_footer1.php"; ?>