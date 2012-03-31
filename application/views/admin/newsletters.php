<?php
if(!empty($newsletters)){
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
                    <form action="<?php echo $base_url;?>index.php/admin/newsletters/delete" method="post">
                    <table class='list' border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                        <thead>
                            <tr>
                                <th class="table-header-check"><input type="checkbox" id="select_all" /></th>
                                <th class="table-header-repeat minwidth-1"><span>ID</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Subject</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Groups</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Last updated</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Status</span></th>
                                <th class="table-header-repeat minwidth-1"><span>Options</span></th>
                            </tr>
                        </thead>
                        <tbody>

                    <?php
                        foreach($newsletters as $newsletter){
                    ?>
                            <tr>
                                <td valign=top><input type="checkbox" name="newsletter_id[]" value="<?php echo $newsletter['newsletter_id']?>" /></td>
                                <td valign=top>
                                    <a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
                                        <?php echo $newsletter['newsletter_id']?>
                                    </a>
                                </td>
                                <td valign=top>
                                    <a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
                                        <?php echo $newsletter['subject']?>
                                    </a>
                                </td>
                                <td valign=top>
                                    <?php
                                        $groups_titles=explode(',<br>',$newsletter['group_title']);
                                        $groups_ids=explode(',',$newsletter['group_id']);

                                        foreach($groups_titles as $index=>$group_title)
                                            echo '<div><a href="'.$base_url.'index.php/admin/newsletters_groups/showNewsletters/'.$groups_ids[$index].'">'.$group_title.'</a></div>';
                                    ?>
                                </td>
                                <td valign=top>
                                    <a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
                                        <?php echo $newsletter['updated']?>
                                    </a>
                                </td>
                                <td valign=top>
                                    <a href="<?php echo $base_url?>index.php/admin/newsletters/showDetails/<?php echo $newsletter['newsletter_id']?>">
                                        <?php echo $newsletter['status']?>
                                    </a>
                                </td>
                                <td valign=top>
                                    <a href="<?php echo $base_url;?>index.php/admin/newsletters/edit/<?php echo $newsletter['newsletter_id']?>" title="Edit" class="icon-1 info-tooltip"></a>
                                    <a href="<?php echo $base_url;?>index.php/admin/newsletters/delete/<?php echo $newsletter['newsletter_id']?>"
                                       title="Delete"
                                       class="icon-2 info-tooltip"
                                       onclick="return confirm('Are You sure You want to delete newsletter with whole it\'s content and attachments?')"
                                        ></a>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <input type="submit" value="Delete" id="delete_submit" class="form-submit2" />
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
}else echo 'Empty result';
if(isset($component))
	if($component=='newsletters_groups'){?><br>
	<a href="<?php echo $base_url;?>index.php/admin/newsletters/add/group/<?php echo $newsletters_group['group_id']?>">Create new issue</a><br>
<br/><a href="javascript:history.back()"><< Back</a>
<?php
	}
?>