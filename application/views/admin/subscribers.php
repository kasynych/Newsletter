<?php
if (!empty($subscribers)) {
    ?>
<script>
    $(document).ready(function () {
        $(':input[name=group_id]').click(function () {
            $('form').attr('action', '<?php echo $base_url;?>index.php/admin/subscribers/' + $('#group_action').val() + '/' + $(this).attr('id'));
            $('form').attr('target', '_self');
            $(this).val($(this).attr('id'));
        });
        $('#delete_submit').click(function () {
            $('form').attr('action', '<?php echo $base_url;?>index.php/admin/subscribers/delete');
            $('form').attr('target', '_self');
        });
        $('#delete_submit2').click(function () {
            if (!confirm('Are You sure?')) return false
            $('form').attr('action', '<?php echo $base_url;?>index.php/admin/subscribers/deleteForever');
            $('form').attr('target', '_self');
        });
        <?php if (isset($subscribers_group)) {
            ?>
            $('#exclude_from_group').click(function () {
                $('form').attr('action', '<?php echo $base_url;?>index.php/admin/subscribers_groups/excludeSubscribers/<?php echo $subscribers_group['group_id']?>');
                $('form').attr('target', '_self');
            });
            <?php }?>
    });

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
                    <form action="<?php echo $base_url;?>index.php/admin/subscribers/search" method="post">
                        <div id="top-search">
                            <div>
                                <input type="text" name="search" value="<?php echo isset($search) ? $search : ''?>" onblur="if (this.value=='') { this.value='Search'; }" onfocus="if (this.value=='Search') { this.value=''; }" class="top-search-inp">
                            </div>
                            <div>
                                <input type="image" src="<?php echo $base_url;?>application/images/shared/top_search_btn.gif">
                            </div>
                            <a href="<?php echo $base_url;?>index.php/admin/subscribers/search/reset"/>Reset</a>
                        </div>
                    </form>
                    <form action="<?php echo $base_url;?>index.php/admin/subscribers/export" method="post" target="_blank">

                        <table class='list' border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                            <thead>
                            <tr>
                                <th class="table-header-check"><input type="checkbox" id="select_all"/></th>
                                <th class="table-header-repeat minwidth-1"><span>ID</span></th>
                                <th width="80px" class="table-header-repeat minwidth-1"><span>Last Name</span></th>
                                <?php    if (isset($component) && $component == 'subscribers_groups') { ?>
                                <th width="80px" class="table-header-repeat minwidth-1"><span>Group</span></th>
                                <th width="150px" class="table-header-repeat minwidth-1"><span>Email</span></th>
                                <th width="150px" class="table-header-repeat minwidth-1"><span>Email Content Type</span></th>
                                <th width="50px" class="table-header-repeat minwidth-1"><span>Status</span></th>
                                <?php } else { ?>

                                <th width="80px" class="table-header-repeat minwidth-1"><a
                                    href="<?php echo $base_url;?>index.php/admin/subscribers/index/order/title">Group</a></th>
                                <th width="150px" class="table-header-repeat minwidth-1"><span>Email</span></th>
                                <th width="150px" class="table-header-repeat minwidth-1"><a href="<?php echo $base_url;?>index.php/admin/subscribers/index/order/content_type">Email
                                    Content Type</a></th>
                                <th width="50px" class="table-header-repeat minwidth-1"><a
                                    href="<?php echo $base_url;?>index.php/admin/subscribers/index/order/status">Status</a></th>

                                <?php }?>
                                <th class="table-header-repeat minwidth-1"><span>Options</span></th>
                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($subscribers as $subscriber) {
                                    ?>
                                <tr>
                                    <td valign=top><input type="checkbox" name="subscriber_id[]"
                                                          value="<?php echo $subscriber['subscriber_id']?>"/></td>
                                    <td valign=top>
                                        <a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
                                            <?php echo $subscriber['subscriber_id']?>
                                        </a>
                                    </td>
                                    <td valign=top>
                                        <a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
                                            <?php echo $subscriber['name']?>
                                        </a>
                                    </td>
                                    <td valign=top>
                                        <?php
                                        $groups_titles = explode(',<br>', $subscriber['group_title']);
                                        $groups_ids = explode(',', $subscriber['group_id']);

                                        foreach ($groups_titles as $index => $group_title)
                                            echo '<div><a href="' . $base_url . 'index.php/admin/subscribers_groups/showSubscribers/' . $groups_ids[$index] . '">' . $group_title . '</a></div>';
                                        ?>
                                    </td>
                                    <td valign=top>
                                        <a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
                                            <?php echo $subscriber['email']?>
                                        </a>
                                    </td>
                                    <td valign=top>
                                        <a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
                                            <?php echo $subscriber['content_type']?>
                                        </a>
                                    </td>
                                    <td valign=top>
                                        <a href="<?php echo $base_url?>index.php/admin/subscribers/showDetails/<?php echo $subscriber['subscriber_id']?>">
                                            <?php echo $subscriber['status']?>
                                        </a>
                                    </td>
                                    <td valign=top>
                                        <a href="<?php echo $base_url;?>index.php/admin/subscribers/edit/<?php echo $subscriber['subscriber_id']?>" title="Edit" class="icon-1 info-tooltip"></a>
                                        <?php if ($subscriber['status'] !== 'deleted') { ?>
                                        <a href="<?php echo $base_url;?>index.php/admin/subscribers/delete/<?php echo $subscriber['subscriber_id']?>"
                                           title="Delete"
                                           class="icon-2 info-tooltip"
                                           onclick="return confirm('Are You sure You want to delete this subscriber?')"></a>
                                        <?php
                                    }
                                        if ($subscriber['status'] !== 'subscribed') {
                                            ?>
                                            <a href="<?php echo $base_url;?>index.php/admin/subscribers/activate/<?php echo $subscriber['subscriber_id']?>" title="Activate" class="icon-5 info-tooltip"></a>
                                            <?php }?>
                                    </td>
                                </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan=8>
                                    <input type="submit" value="Delete" id="delete_submit" class="form-submit2"/><br/>
                                    <input type="submit" value="Remove" id="delete_submit2" class="form-submit2"/><br/>
                                    <input type="Submit" value="Export" class="form-submit2">
                                    <?php
                                    if (!empty($subscribers_groups)) {
                                        ?>
                                        <br>
                                        <select id="group_action">
                                            <option value="setGroup">Move to group</option>
                                            <option value="copyToGroup">Copy to group</option>
                                        </select>:
                                        <?php
                                        foreach ($subscribers_groups as $group) {
                                            ?>
                                            <input type="submit" name="group_id" value="<?php echo $group['title']?>"
                                                   id="<?php echo $group['group_id']?>" class="form-submit2"/>
                                            <?php
                                        }
                                    }

                                    if (isset($component))
                                        if ($component == 'subscribers_groups') {
                                            ?>
                                            <br/><input type="submit" value="Exclude" id='exclude_from_group' class="form-submit2"/>
                                            <?php
                                        }
                                    ?>
                                </td>
                            </tr>
<?php if(isset($pagination)&&!empty($pagination)){?>
                            <tr>
                                <td colspan=8 class="pagination">
                                    <?php echo isset($pagination) ? $pagination : '';?>
                                </td>
                            </tr>
<?php }?>
                            </tfoot>
                        </table>
                    </form>
                        <?php
                    } else echo 'Empty result';
                    if (isset($component))
                        if ($component == 'subscribers_groups') {
                            ?>
                            <input type="button" class="form-reset" onclick="javascript:history.back()" value="<< Back" />
                            <?php
                        }
                    ?>
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