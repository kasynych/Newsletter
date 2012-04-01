
<script type="text/javascript" src="<?php echo $base_url?>application/libraries/js/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		$('#text_body').hide();
	<?php if(!isset($show_schedule_form)){?>
		$('#send_form').hide();
	<?php }else{?>
		$('form').attr('action','<?php echo $base_url?>index.php/admin/newsletters/addAndDeliver');	
	<?php }?>
		$('#text_label,#html_label').click(function(){
			$('#text_body').toggle('fast');
			$('#html_area').toggle('fast');
		});

		$('select[name=template_id]').change(function(){
			if($(this).val()==0)return true;
			confirmation=confirm('Are You sure You want insert this template? This action will replace existing content with new one');
			if(confirmation) getTemplate($(this).val());
		});

		$('#show_send_form').click(function(){
			$('#send_form').slideToggle();

			if($('#send_form').is(':visible'))
				$('form').attr('action','<?php echo $base_url?>index.php/admin/newsletters/addAndDeliver');
			else
				$('form').attr('action','<?php echo $base_url?>index.php/admin/newsletters/<?php echo $form_action;?>');
		});
	});

	function getTemplate(template_id){
		hostname=window.location.hostname;
		$.ajax({
			  url: '<?php echo $base_url;?>index.php/admin/templates/get/'+template_id,
			  success: function(data) {				  
				var tplObject = JSON.parse(data);
				$('input[name=subject]').val(tplObject.subject);			
				$('#text_body').val(tplObject.text_body);
				CKEDITOR.instances.html_body.setData(tplObject.html_body);
			  }
			});
	}	
</script>
<?php require_once "content_header1.php"; ?>
<form action="<?php echo $base_url?>index.php/admin/newsletters/<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
        <tr>
            <th>Subject:</th>
            <td>
                <input class="inp-form" type="text" name="subject" value="<?php echo $newsletter['subject']?>" size=70 />
            </td>
        </tr>
        <tr>
            <th>Template:</th>
            <td>
                <select name="template_id"  class="styledselect_form_1"><option value="0">Select Template</option>
<?php if(!empty($templates)){
        foreach($templates as $template){
?>
                    <option value="<?php echo $template['template_id']?>"
                            <?php echo $template['template_id']==$newsletter['template_id']?'selected=selected':''?>><?php echo $template['subject']?>
                    </option>
<?php
        }
?>
<?php }?>
                </select>
            </td>
        </tr>
        <tr>
            <th valign=top width=100><a href="javascript:void()" id="text_label">Text Version</a>:</th>
            <td>
                <textarea rows="10" cols="70" class="form-textarea" name="text_body" id="text_body"><?php echo $newsletter['text_body']?></textarea>
            </td>
        </tr>
        <tr>
            <th valign=top width=100><a href="javascript:void()" id="html_label">HTML Version</a>:</th>
            <td>
                <div id="html_area">
                <textarea rows="10" cols="40" name="html_body" id="html_body"><?php echo $newsletter['html_body']?></textarea>
                </div>
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
<?php
if(isset($groups)&&count($groups)>0){
?>
        <tr>
            <th valign=top>Group:</th>
            <td>
                <select name='group_id[]' multiple class="styledselect_form_1">
<?php
    foreach($groups as $group){
?>
                     <option value="<?php echo $group['group_id']?>"
                             <?php echo in_array($group['group_id'],$newsletter['groups'])?'selected=selected':''?>><?php echo $group['title']?></option>
<?php
    }
?>
                </select>
            </td>
        </tr>
<?php
}
?>
        <tr>
            <td colspan=2><?php require_once 'newsletter_attachments.php';?></td>
        </tr>
        <tr>
            <th colspan=2>
                <a href="javascript:void(0);" id="add_attachment">Add attachment</a>
                <div id="attachments">
                </div>
            </th>
        </tr>
<?php if($form_action=='add'){?>
        <tr>
            <th colspan="2" style="padding-top:20px">
                <a href="javascript:void(0);" id="show_send_form">Set Delivery Options</a>
            </th>
        </tr>
        <tr id="send_form">
            <td colspan="2">
                <?php require_once('newsletter_send_form.php')?>
            </td>
        </tr>
<?php }?>
        <tr>
            <td colspan=2>
                <input type="submit" value="Save" name='submit' class="form-submit">
                <input type="button" value="Cancel" class="form-reset" onclick="javascript:document.location.href='<?php echo $base_url?>index.php/admin/newsletters'" />
            </td>
        </tr>


    </table>
</form>
<?php require_once "content_footer1.php"; ?>