<?php require_once "content_header1.php"; ?>
<form action="<?php echo $base_url?>index.php/admin/subscribers/<?php echo $form_action;?>" method="post">
    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
        <tr>
            <th>Name:</th>
            <td>
                <input type="text"
                       name="name"
                       value="<?php echo $subscriber['name']?>" class="inp-form" />
            </td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>
                <input type="text"
                       name="email"
                       value="<?php echo $subscriber['email']?>" class="inp-form" />
            </td>
        </tr>
        <tr>
            <th>Content Type:</th>
            <td>
                <select name="content_type"  class="styledselect_form_1">
                    <option value="html"
                            <?php echo $subscriber['content_type']=='html'?'selected=selected':''?>>HTML</option>
                    <option value="text"
                            <?php echo $subscriber['content_type']=='text'?'selected=selected':''?>>Text</option>
                </select>
            </td>
        </tr>
<?php
if(isset($groups)&&count($groups)>0){
?>
        <tr>
            <th valign=top>Group:</th>
            <td>
<?php
    foreach($groups as $group){
?>				<div>
                    <input type="checkbox"
                           name="group_id[]"
                           id="group_<?php echo $group['group_id']?>"
                           value="<?php echo $group['group_id']?>"
                           <?php echo in_array($group['group_id'],$subscriber['groups'])?'checked=checked':''?> />
                           <label for="group_<?php echo $group['group_id']?>"><?php echo $group['title']?></label>
                </div>
<?php
    }
?>
            </td>
        </tr>
<?php
}
?>
        <tr>
            <th>Status:</th>
            <td>
                <select name="status"  class="styledselect_form_1">
                    <option value="new"
                            <?php echo $subscriber['status']=='new'?'selected=selected':''?>>New</option>
                    <option value="subscribed"
                            <?php echo $subscriber['status']=='subscribed'?'selected=selected':''?>>Subscribed</option>
                    <option value="deleted"
                            <?php echo $subscriber['status']=='deleted'?'selected=selected':''?>>Deleted</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <input type="submit" value="Save" class="form-submit">&nbsp;&nbsp;
                <input type="button" value="Cancel" class="form-reset"  onclick="javascript:location.href='<?php echo $base_url?>index.php/admin/subscribers'" />
            </td>
        </tr>
    </table>
</form>
<?php require_once "content_footer1.php"; ?>