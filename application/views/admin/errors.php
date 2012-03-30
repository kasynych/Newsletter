<?php  
if(isset($errors)||!empty($errors)){
?>
<ul class="errors">
<?php	
	if(is_array($errors)&&count($errors)>0){
		foreach($errors as $error){
?>
	<li><?php 	echo $error?></li>
<?php   } 
	}elseif(is_string($errors)){
?>	
	<li><?php 	echo $errors?></li>
<?php
	} 
?>		
</ul>
<?php		
}
?>