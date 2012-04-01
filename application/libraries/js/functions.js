var attachments=0;
var max_attachments=10;
$(document).ready(function() {
	$('#select_all').click(function(){
		if($('#select_all:checked').val() !== undefined)
			$('form :checkbox').attr("checked","checked");
		else
			$('form :checkbox').removeAttr("checked");
	});
	
	$('#add_attachment').click(function(){
		if(attachments>=max_attachments){alert('Please add maximum '+max_attachments+' attachments');return false;}
		
		$('#attachments').prepend('<div class="attachment"><input type="file" name="attachment[]" class="file_1"><a href="javascript:void()"><img src="'+base_url+'application/images/table/action_delete.gif" style="margin:4px 0px 0px 4px" /></a></div>');
		
		$('#attachments :nth-child(1) :nth-child(2)').bind('click',function(){ // binding click event, otherwise does not work
			if(attachments<=0) {attachments=0; return false;}
			$(this).parent().hide();
			$(this).prev().attr('disabled','disabled');
			attachments--;
		});
		attachments++;
	});
	
	$('#time_rules').click(function(){
		$('#date :input[type=text]').val('');
	});
	
	$('#date').click(function(){
		$('#time_rules').children().val('');
	})
	
	$('#subscribers').click(function(){
		$('#subscribers_groups select').val('');		
	});
	
	$('#subscribers_groups').click(function(){
		$('#subscribers select').val('');	
	});
	
	$('#delete_submit').click(function(){
		return confirm('Are You sure?');		
	});
})

