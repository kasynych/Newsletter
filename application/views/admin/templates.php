<?php
if(!empty($templates)){
?>
<script type="text/javascript">
<!--
$(document).ready(function(){
	$('#delete_submit').click(function(){
		$('form').attr('action','<?php echo $base_url;?>index.php/admin/templates/delete');
	});
})
//-->
</script>
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
                    <form action="<?php echo $base_url;?>index.php/admin/templates/setDefault" method="post">
                    <table class='list' border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                        <thead>
                            <tr>
                                <th class="table-header-check"><input type="checkbox" id="select_all" /></th>
                                <th width=30px class="table-header-repeat">&nbsp;</th>
                                <th class="table-header-repeat minwidth-1"><span>ID</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Subject</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Options</span> </th>
                            </tr>
                        </thead>
                        <tbody>

                    <?php
                        foreach($templates as $template){
                    ?>
                            <tr>
                                <td valign=top><input type="checkbox" name="template_id[]" value="<?php echo $template['template_id']?>" /></td>
                                <td valign=top>
                                    <input type="radio"
                                           name="template_id"
                                           value="<?php echo $template['template_id']?>"
                                           <?php echo $template['default']==1?'checked=checked':''?> />
                                </td>
                                <td valign=top>
                                    <a href="<?php echo $base_url?>index.php/admin/templates/showDetails/<?php echo $template['template_id']?>">
                                        <?php echo $template['template_id']?>
                                    </a>
                                </td>
                                <td valign=top>
                                    <a href="<?php echo $base_url?>index.php/admin/templates/showDetails/<?php echo $template['template_id']?>">
                                        <?php echo $template['subject']?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo $base_url;?>index.php/admin/templates/edit/<?php echo $template['template_id']?>" title="Edit" class="icon-1 info-tooltip"></a>
                                    <a href="<?php echo $base_url;?>index.php/admin/templates/delete/<?php echo $template['template_id']?>"
                                       title="Delete"
                                       class="icon-2 info-tooltip"
                                       onclick="return confirm('Are You sure You want to delete this template?')"></a>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <input type="image" id="delete_submit" src="<?php echo $base_url;?>application/images/table/action_delete.gif" />
                                </td>
                                <td>

                                    <input type="Submit" value="Default" class="form-submit2">
                                </td>
                            </tr>
    <?php if(isset($pagination)&&!empty($pagination)){ ?>
                            <tr>
                                <td colspan=5 class="pagination">
                                    <?php echo isset($pagination)?$paginstion:'';?>
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
} 
?>