<?php require_once "content_header1.php"; ?>
<form action="<?php echo $base_url?>index.php/admin/settings" method="post">
    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
        <tr>
            <th>From email:</th>
            <td><input type="text" class="inp-form" name="from" value="<?php echo $settings['from']?>" /></td>
        </tr>
        <tr>
            <td>From name:</td>
            <td><input type="text" class="inp-form" name="from_name" value="<?php echo $settings['from_name']?>" /></td>
        </tr>
        <tr>
            <td>Attachment Max Size:</td>
            <td><input type="text" class="inp-form" name="attachment_max_size" value="<?php echo $settings['attachment_max_size']?>" /></td>
        </tr>
        <tr>
            <td>Attachment Allowed extensions:</td>
            <td><input type="text" class="inp-form" name="attachment_allowed_exts" value="<?php echo $settings['attachment_allowed_exts']?>" /></td>
        </tr>
        <tr>
            <td>Attachment Max Filename Length:</td>
            <td><input type="text" class="inp-form" name="attachment_max_filename_length" value="<?php echo $settings['attachment_max_filename_length']?>" /></td>
        </tr>
        <tr>
            <td>Temp path:</td>
            <td><input type="text" class="inp-form" name="tmp_path" value="<?php echo $settings['tmp_path']?>" /></td>
        </tr>
        <tr>
            <td>Mailer:</td>
            <td><input type="text" class="inp-form" name="mailer" value="<?php echo $settings['mailer']?>" /></td>
        </tr>
        <tr>
            <td>SMTP Host:</td>
            <td><input type="text" class="inp-form" name="SMTP_host" value="<?php echo $settings['SMTP_host']?>" /></td>
        </tr>
        <tr>
            <td>SMTP User:</td>
            <td><input type="text" class="inp-form" name="SMTP_user" value="<?php echo $settings['SMTP_user']?>" /></td>
        </tr>
        <tr>
            <td>SMTP Password:</td>
            <td><input type="text" class="inp-form" name="SMTP_password" value="<?php echo $settings['SMTP_password']?>" /></td>
        </tr>
        <tr>
            <td>Newsletters Per Page:</td>
            <td><input type="text" class="inp-form" name="newsletters_per_page" value="<?php echo $settings['newsletters_per_page']?>" /></td>
        </tr>
        <tr>
            <td>Subscribers Per page:</td>
            <td><input type="text" class="inp-form" name="subscribers_per_page" value="<?php echo $settings['subscribers_per_page']?>" /></td>
        </tr>
        <tr>
            <td>Schedules Per Page:</td>
            <td><input type="text" class="inp-form" name="schedules_per_page" value="<?php echo $settings['schedules_per_page']?>" /></td>
        </tr>
        <tr>
            <td>Send Activation Email:</td>
            <td>
                <select name="send_activation_email" class="styledselect_form_2">
                    <option value="Yes" <?php echo ($settings['send_activation_email']=='Yes'?'selected=selected':'')?>>Yes</option>
                    <option value="No" <?php echo ($settings['send_activation_email']=='No'?'selected=selected':'')?>>No</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan=2><input type="submit" class="form-submit" value="Save" />&nbsp;&nbsp;
                          <input type="button" class="form-reset" value="Cancel" onclick="javascript:document.location.href='<?php echo $base_url?>index.php/admin'" />
            </td>
        </tr>
    </table>
</form>
<?php require_once "content_footer1.php"; ?>