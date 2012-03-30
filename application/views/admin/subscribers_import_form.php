<div class="errors">
<?php
echo validation_errors(); 
?>
</div>
<form action="<?php echo $base_url?>index.php/admin/subscribers/import" method="post" enctype="multipart/form-data" >
<input type="file" name="file"><br>
<input type="submit" name="submit" value="Import"/>&nbsp;&nbsp;
						  <input type="button" value="Cancel" onclick="javascript:location.href='<?php echo $base_url?>index.php/admin/subscribers'" />
</form>