<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Admin</title>

    <link rel="stylesheet" href="<?php echo $base_url;?>application/css/screen.css" type="text/css" media="screen" title="default" />
    <!--  jquery core -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery-1.4.1.min.js" type="text/javascript"></script>

    <!-- Custom jquery scripts -->
    <script src="<?php echo $base_url;?>application/libraries/js/custom_jquery.js" type="text/javascript"></script>

    <!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.pngFix.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).pngFix( );
        });
    </script>
</head>
<body id="login-bg">


    <!-- Start: login-holder -->
    <div id="login-holder">

        <!-- start logo -->
        <div id="logo-login">
            <a href="index.html"><img src="<?php echo $base_url;?>application/images/logo.png" height="141" alt="" /></a>
        </div>
        <!-- end logo -->

        <div class="clear"></div>

        <!--  start loginbox ................................................................................. -->
        <div id="loginbox">
            <form action="<?php echo $base_url?>index.php/admin/home/login" method="post">
            <!--  start login-inner -->
            <div id="login-inner">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan=2>
                            <div class="errors"><?php require_once('errors.php');?>
                                <?php
                                echo validation_errors();
                                ?>
                            </div>
                            <div class="message"><?php echo $message?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><input type="text" name="name" value="" class="login-inp" /></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input type="password" name="password" value="" class="login-inp" /></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><input type="submit" class="submit-login"  /></td>
                    </tr>
                </table>
                <div id="forgotbox-text">Demo username: demo<br/>Demo password: demo</div>
            </div>
            </form>
            <!--  end login-inner -->
        </div>
        <!--  end loginbox -->

    </div>
</body>
</html>