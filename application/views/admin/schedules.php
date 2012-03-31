<?php
if(!empty($schedules)){
?>
Server time: <?php echo date('d/m/Y H:i:s');?>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
    <tr>
        <th rowspan="3" class="sized"><img src="<?php echo $base_url;?>application/images/shared/side_shadowleft.jpg" width="20" height="300" alt=""/>
        </th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="<?php echo $base_url;?>application/images/shared/side_shadowright.jpg" width="20" height="300" alt=""/>
        </th>
    </tr>
    <tr>
        <td id="tbl-border-left"></td>
        <td>
            <!--  start content-table-inner ...................................................................... START -->
            <div id="content-table-inner">
                <div id="table-content">
                    <form action="<?php echo $base_url;?>index.php/admin/schedules/delete" method="post">
                    <table class='list' border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                        <thead>
                            <tr>
                                <th width=20px class="table-header-check"><input type="checkbox" id="select_all" /></th>
                                <th class="table-header-repeat minwidth-1"><span>ID</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Title</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Newsletter</span></th>
                                <th class="table-header-repeat"><span>Send date/Send rules</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Status</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Options</span></th>
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
                                    <a href="<?php echo $base_url;?>index.php/admin/schedules/edit/<?php echo $schedule['schedule_id']?>" title="Edit" class="icon-1 info-tooltip"></a>
                                    <a href="<?php echo $base_url;?>index.php/admin/schedules/delete/<?php echo $schedule['schedule_id']?>"
                                       title="Delete"
                                       class="icon-2 info-tooltip"
                                       onclick="return confirm('Are You sure You want to delete this schedule?')"></a>

                                </td>
                            </tr>
                    <?php
                            }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <input type="submit" value="Delete" id="delete_submit" class="form-submit2">
                                </td>
                            </tr>
    <?php if(isset($pagination)&&!empty($pagination)){ ?>
                            <tr>
                                <td colspan=5 class="pagination">
                                    <?php echo isset($pagination)?$pagination:'';?>
                                </td>
                            </tr>
    <?php }?>
                        </tfoot>
                    </table>
                    </form>
                </div>
                <div class="clear"></div>
            </div>
            <!--  end content-table-inner ............................................END  -->
        </td>
        <td id="tbl-border-right"></td>
    </tr>
    <tr>
        <th class="sized bottomleft"></th>
        <td id="tbl-border-bottom">&nbsp;</td>
        <th class="sized bottomright"></th>
    </tr>
</table>
<?php 
}?>