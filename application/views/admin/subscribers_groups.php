<?php
if(!empty($subscribers_groups)){
?>
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
                    <form action="<?php echo $base_url;?>index.php/admin/subscribers_groups/setDefault" method="post">
                    <table class='list' border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                        <thead>
                            <tr>
                                <th width=30px class="table-header-check"></th>
                                <th class="table-header-repeat minwidth-1"><span>ID</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Title</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Description</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Options</span></th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                        foreach($subscribers_groups as $group){
                    ?>
                            <tr>
                                <td valign=top>
                                    <input type="radio"
                                           name="group_id"
                                           value="<?php echo $group['group_id']?>"
                                           <?php echo $group['default']==1?'checked=checked':''?> />
                                </td>
                                <td valign=top><a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/showSubscribers/<?php echo $group['group_id']?>"><?php echo $group['group_id']?></a></td>
                                <td valign=top><a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/showSubscribers/<?php echo $group['group_id']?>"><?php echo $group['title']?></a></td>
                                <td valign=top><a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/showSubscribers/<?php echo $group['group_id']?>"><?php echo $group['description']?></a></td>
                                <td>
                                    <a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/edit/<?php echo $group['group_id']?>" title="Edit" class="icon-1 info-tooltip"></a>
                                    <a href="<?php echo $base_url;?>index.php/admin/subscribers_groups/delete/<?php echo $group['group_id']?>"
                                       onclick="return confirm('Are You sure You want to delete this group?')"
                                       title="Delete"
                                       class="icon-2 info-tooltip"></a>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan=5>
                                    <input type="Submit" value="Set Default" class="form-submit2">
                                </td>
                            </tr>
                            <tr>
                                <td colspan=5 class="pagination">
                                    <?php echo isset($pagination)?$paginstion:'';?>
                                </td>
                            </tr>
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