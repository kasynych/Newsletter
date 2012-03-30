<?php
if(!empty($schedules)){
?>
Server time: <?php echo date('d/m/Y H:i:s');?>
<form action="<?php echo $base_url;?>index.php/admin/schedules/delete" method="post">
<table class='list'>
	<thead>
		<tr>
			<th width=20px><input type="checkbox" id="select_all" /></th>
			<th>ID</th>
			<th>Title</th>
			<th>Newsletter</th>
			<th>Send date/Send rules</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($schedules as $schedule){	
?>		
		<tr>
			<td valign=top><input type="checkbox" name="schedule_id[]" value="<?php echo $schedule['schedule_id']?>" /></td>
			<td>
				<a href="<?php echo $base_url?>index.php/admin/schedules/showDetails/<?php echo $schedule['schedule_id']?>">
					<?php echo $schedule['schedule_id']?>
				</a>
			</td>
			<td>
				<a href="<?php echo $base_url?>index.php/admin/schedules/showDetails/<?php echo $schedule['schedule_id']?>">
					<?php echo $schedule['title']?>
				</a>
			</td>
			<td>
				<a href="<?php echo $base_url?>index.php/admin/schedules/showDetails/<?php echo $schedule['schedule_id']?>">
					<?php echo $schedule['subject']?>
				<a href="<?php echo $base_url?>index.php/admin/schedules/showDetails/<?php echo $schedule['schedule_id']?>">
			</td>
			<td>
				<a href="<?php echo $base_url?>index.php/admin/schedules/showDetails/<?php echo $schedule['schedule_id']?>">
					<?php echo is_null($schedule['time_rules'])||$schedule['time_rules']==''
									?date('d/m/Y H:i',strtotime($schedule['send_datetime']))
									:$schedule['time_rules']?>
				</a>
			</td>
			<td>
				<a href="<?php echo $base_url?>index.php/admin/schedules/showDetails/<?php echo $schedule['schedule_id']?>">
					<?php echo $schedule['status']?>
				</a>
			</td>
			<td>
				<a href="<?php echo $base_url;?>index.php/admin/schedules/edit/<?php echo $schedule['schedule_id']?>">edit</a>
				 | <a href="<?php echo $base_url;?>index.php/admin/schedules/delete/<?php echo $schedule['schedule_id']?>" onclick="return confirm('Are You sure You want to delete this schedule?')">delete</a>
				
			</td>
		</tr>
<?php 
		}?>	
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">
				<input type="submit" value="Delete" id="delete_submit">
			</td>
		</tr>
		<tr>
			<td colspan=5 class="pagination">
				<?php echo isset($pagination)?$pagination:'';?>
			</td>
		</tr>	
	</tfoot>
</table>
<?php 
}?>