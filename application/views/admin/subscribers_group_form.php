<?php require_once "content_header1.php"; ?>
<form action="<?php echo $base_url?>index.php/admin/subscribers_groups/<?php echo $form_action;?>" method="post">
    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
        <tr>
            <th>Title:</th>
            <td><input class="inp-form" type="text" name="title" value="<?php echo $subscribers_group['title']?>" /></td>
        </tr>
        <tr>
            <th valign="top">Description:</th>
            <td><textarea class="form-textarea" name="description" cols=30 rows=5><?php echo $subscribers_group['description']?></textarea></td>
        </tr>
        <tr>
            <td colspan=2><input type="submit" value="Save" class="form-submit" />
                <input type="button" value="Cancel" class="form-reset"  onclick="javascript:location.href='<?php echo $base_url?>index.php/admin/subscribers'" />
            </td>
        </tr>
    </table>
</form>
<?php require_once "content_footer1.php"; ?>