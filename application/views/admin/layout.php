<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" href="<?php echo $base_url;?>application/css/screen.css" type="text/css" media="screen" title="default" />
    <!--[if IE]>
    <link rel="stylesheet" media="all" type="text/css" href="<?php echo $base_url;?>application/css/pro_dropline_ie.css" />
    <![endif]-->

	<title>Admin<?php echo isset($data['site_title'])?' :: '.$data['site_title']:''?></title>
    <!--  jquery core -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery-1.4.1.min.js" type="text/javascript"></script>

    <!--  checkbox styling script -->
    <script src="<?php echo $base_url;?>application/libraries/js/ui.core.js" type="text/javascript"></script>
    <script src="<?php echo $base_url;?>application/libraries/js/ui.checkbox.js" type="text/javascript"></script>
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.bind.js" type="text/javascript"></script>
    <script>
        var base_url="<?php echo $base_url; ?>";
    </script>
    <script type="text/javascript">
        $(function(){
            $('input').checkBox();
            $('#toggle-all').click(function(){
                $('#toggle-all').toggleClass('toggle-checked');
                $('#mainform input[type=checkbox]').checkBox('toggle');
                return false;
            });
        });
    </script>

    <![if !IE 7]>

    <!--  styled select box script version 1 -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.selectbox-0.5.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.styledselect').selectbox({ inputClass: "selectbox_styled" });
        });
    </script>


    <![endif]>

    <!--  styled select box script version 2 -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.styledselect_form_1').selectbox({ inputClass: "styledselect_form_1" });
            $('.styledselect_form_2').selectbox({ inputClass: "styledselect_form_2" });
        });
    </script>

    <!--  styled select box script version 3 -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.styledselect_pages').selectbox({ inputClass: "styledselect_pages" });
        });
    </script>

    <!--  styled file upload script -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.filestyle.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8">
        $(function() {
            $("input.file_1").filestyle({
                image: "images/forms/choose-file.gif",
                imageheight : 21,
                imagewidth : 78,
                width : 310
            });
        });
    </script>

    <!-- Custom jquery scripts -->
    <script src="<?php echo $base_url;?>application/libraries/js/custom_jquery.js" type="text/javascript"></script>

    <!-- Tooltips -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.tooltip.js" type="text/javascript"></script>
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.dimensions.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('a.info-tooltip ').tooltip({
                track: true,
                delay: 0,
                fixPNG: true,
                showURL: false,
                showBody: " - ",
                top: -35,
                left: 5
            });
        });
    </script>


    <!--  date picker script -->
    <link rel="stylesheet" href="<?php echo $base_url;?>application/css/datePicker.css" type="text/css" />
    <script src="<?php echo $base_url;?>application/libraries/js/date.js" type="text/javascript"></script>
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.datePicker.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8">
        $(function()
        {

// initialise the "Select date" link
            $('#date-pick')
                .datePicker(
                // associate the link with a date picker
                {
                    createButton:false,
                    startDate:'01/01/2005',
                    endDate:'31/12/2020'
                }
            ).bind(
                // when the link is clicked display the date picker
                'click',
                function()
                {
                    updateSelects($(this).dpGetSelected()[0]);
                    $(this).dpDisplay();
                    return false;
                }
            ).bind(
                // when a date is selected update the SELECTs
                'dateSelected',
                function(e, selectedDate, $td, state)
                {
                    updateSelects(selectedDate);
                }
            ).bind(
                'dpClosed',
                function(e, selected)
                {
                    updateSelects(selected[0]);
                }
            );

            var updateSelects = function (selectedDate)
            {
                var selectedDate = new Date(selectedDate);
                $('#d option[value=' + selectedDate.getDate() + ']').attr('selected', 'selected');
                $('#m option[value=' + (selectedDate.getMonth()+1) + ']').attr('selected', 'selected');
                $('#y option[value=' + (selectedDate.getFullYear()) + ']').attr('selected', 'selected');
            }
// listen for when the selects are changed and update the picker
            $('#d, #m, #y')
                .bind(
                'change',
                function()
                {
                    var d = new Date(
                        $('#y').val(),
                        $('#m').val()-1,
                        $('#d').val()
                    );
                    $('#date-pick').dpSetSelected(d.asString());
                }
            );

// default the position of the selects to today
            var today = new Date();
            updateSelects(today.getTime());

// and update the datePicker to reflect it...
            $('#d').trigger('change');
        });
    </script>

    <!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
    <script src="<?php echo $base_url;?>application/libraries/js/jquery.pngFix.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).pngFix( );
        });
    </script>
	<script type="text/javascript" src="<?php echo $base_url?>application/libraries/js/functions.js"></script>
    <script>
        var message='<?php echo $message; ?>';
        var errors='<?php echo $errors; ?>';
        var validation_errors='<?php echo function_exists('validation_errors')?strlen(validation_errors()):0; ?>';
        $(document).ready(function(){
            if(message!='')
                $('#message-green').show();

            if(errors!=''&&errors!='Array'||parseInt(validation_errors)>0)
                $('#message-red').show();
        })
    </script>
</head>
<body>
<!-- Start: page-top-outer -->
<div id="page-top-outer">

    <!-- Start: page-top -->
    <div id="page-top">

        <!-- start logo -->
        <div id="logo">
            <a href="<?php echo $base_url;?>index.php/admin/home"><img src="<?php echo $base_url?>application/images/logo.png" height="80" alt="" /></a>
        </div>
        <!-- end logo -->

        <div class="clear"></div>

    </div>
    <!-- End: page-top -->

</div>
<!-- End: page-top-outer -->
<!--  start nav-outer-repeat................................................................................................. START -->
<div class="nav-outer-repeat">
    <!--  start nav-outer -->
    <div class="nav-outer">
        <!-- start nav-right -->
        <div id="nav-right">

            <div class="nav-divider">&nbsp;</div>
            <a href="<?php echo $base_url;?>index.php/admin/home/logout" id="logout"><img src="<?php echo $base_url?>application/images/shared/nav/nav_logout.gif" width="64" height="14" alt="" /></a>
            <div class="clear">&nbsp;</div>
        </div>
        <!--  start nav -->
        <div class="nav">
            <div class="table">

                <ul class="<?php echo isset($title)&&($title=='Subscribers'||$title=='Subscribers groups'||$title=='Add subscriber'||$title=='Import subscribers (CSV format)')||$title=='Add subscribers group'?'current':'select' ?>">
                    <li><a href="<?php echo $base_url?>index.php/admin/subscribers/index/reset"><b>Subscribers</b></a>
                        <div class="select_sub <?php echo isset($title)&&($title=='Subscribers'||$title=='Subscribers groups'||$title=='Add subscriber'||$title=='Import subscribers (CSV format)'||$title=='Add subscribers group')?'show':'' ?>">
                        <ul class="sub">
                            <li><a href="<?php echo $base_url?>index.php/admin/subscribers/add">Add Subscriber</a></li>
                            <li><a href="<?php echo $base_url?>index.php/admin/subscribers/import">Import Subscribers</a></li>
                            <li><a href="<?php echo $base_url?>index.php/admin/subscribers_groups">Groups</a></li>
                            <li><a href="<?php echo $base_url?>index.php/admin/subscribers_groups/add">Add Group</a></li>
                        </ul>
                        </div>
                    </li>
                </ul>

                <div class="nav-divider">&nbsp;</div>

                <ul class="<?php echo isset($title)&&($title=='Newsletters'||$title=='Add issue'||$title=='Newsletters groups'||$title=='Add newsletters group')?'current':'select' ?>">
                    <li><a href="<?php echo $base_url?>index.php/admin/newsletters"><b>Newsletters</b></a>
                        <div class="select_sub <?php echo isset($title)&&($title=='Newsletters'||$title=='Add issue'||$title=='Newsletters groups'||$title=='Add newsletters group')?'show':'' ?>">
                            <ul class="sub">
                                <li><a href="<?php echo $base_url?>index.php/admin/newsletters/add">Add Issue</a></li>
                                <li><a href="<?php echo $base_url?>index.php/admin/newsletters_groups">Groups</a></li>
                                <li><a href="<?php echo $base_url?>index.php/admin/newsletters_groups/add">Add Group</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <div class="nav-divider">&nbsp;</div>

                <ul class="<?php echo isset($title)&&($title=='Templates'||$title=='Add template')?'current':'select' ?>">
                            <li><a href="<?php echo $base_url?>index.php/admin/templates"><b>Templates</b></a>
                                <div class="select_sub <?php echo isset($title)&&($title=='Templates'||$title=='Add template')?'show':'' ?>">
                                    <ul class="sub">
                                        <li><a href="<?php echo $base_url?>index.php/admin/templates/add">Add Template</a></li>
                                    </ul>
                                </div>
                            </li>
                    </ul>
                <div class="nav-divider">&nbsp;</div>
                <ul class="<?php echo isset($title)&&($title=='Delivery'||$title=='Schedules'||$title=='Add schedule')?'current':'select' ?>">
                    <li>
                        <a href="<?php echo $base_url?>index.php/admin/schedules"><b>Delivery</b></a>
                        <div class="select_sub <?php echo isset($title)&&($title=='Delivery'||$title=='Schedules'||$title=='Add schedule')?'show':'' ?>">
                            <ul class="sub">
                                <li><a href="<?php echo $base_url?>index.php/admin/schedules/add">New Schedule</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <div class="nav-divider">&nbsp;</div>

                <ul class="<?php echo isset($title)&&$title=='Statistics'?'current':'select' ?>">
                    <li><a href="<?php echo $base_url?>index.php/admin/statistics"><b>Statistics</b></a></li>
                </ul>

                <div class="nav-divider">&nbsp;</div>

                <ul class="<?php echo isset($title)&&$title=='Settings'?'current':'select' ?>">
                    <li><a href="<?php echo $base_url?>index.php/admin/settings"><b>Settings</b></a></li>
                </ul>

                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <!--  start nav -->

    </div>
    <div class="clear"></div>
    <!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->

<div class="clear"></div>

        <!-- start content-outer ........................................................................................................................START -->
        <div id="content-outer">
            <!-- start content -->
            <div id="content">

                <!--  start page-heading -->
                <div id="page-heading">
                    <h1><?php echo isset($title)?$title:'';?></h1>
                </div>
<!--                <div class="errors"><?php /*require_once('errors.php');*/?></div>-->
                <div id="message-red">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td class="red-left">
                                <?php
                                    require_once('errors.php');
                                    if(function_exists('validation_errors'));
                                        echo validation_errors();
                                ?>
                            </td>
<!--                            <td class="red-right"><a class="close-red"><img src="<?php /*echo $base_url*/?>application/images/table/icon_close_red.gif" alt=""></a></td>-->
                        </tr>
                        </tbody></table>
                </div>
                <div id="message-green">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td class="green-left"><?php echo $message?></td>
                            <td class="green-right"><a class="close-green"><img src="<?php echo $base_url?>application/images/table/icon_close_green.gif" alt=""></a></td>
                        </tr>
                        </tbody></table>
                </div>
			    <?php if(isset($content)) require_once $content.'.php';?>
            </div>
            <!--  end content -->
            <div class="clear">&nbsp;</div>
        </div>
        <!--  end content-outer........................................................END -->
<div class="clear">&nbsp;</div>

<!-- start footer -->
<div id="footer">
    <!--  start footer-left -->
    <div id="footer-left">
        Designed by <a href="http://www.netdreams.co.uk" target="_blank">www.netdreams.co.uk</a>. &copy; Copyright Internet Dreams Ltd. All rights reserved.</div>
    <!--  end footer-left -->
    <div class="clear">&nbsp;</div>
</div>
<!-- end footer -->
</body>
</html>