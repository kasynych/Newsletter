<?php require_once "content_header1.php"; ?>
                            <form action="<?php echo $base_url?>index.php/admin/subscribers/import" method="post" enctype="multipart/form-data" id="id-form" >
                            <input type="file" name="file"><br>
                            <input type="submit" name="submit" class="form-submit" value="Import"/>&nbsp;&nbsp;
                                                      <input type="button" class="form-reset"  value="Cancel" onclick="javascript:location.href='<?php echo $base_url?>index.php/admin/subscribers'" />
                            </form>
<?php require_once "content_footer1.php"; ?>