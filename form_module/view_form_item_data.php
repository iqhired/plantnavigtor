<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
        header($redirect_tab_logout_path);
    } else {
        header($redirect_logout_path);
    }
}
//Set the session duration for 10800 seconds - 3 hours
$duration = $auto_logout_duration;
//Read the request time of the user
$time = $_SERVER['REQUEST_TIME'];
//Check the user's session exist or not
if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $duration) {
    //Unset the session variables
    session_unset();
    //Destroy the session
    session_destroy();
    if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
        header($redirect_tab_logout_path);
    } else {
        header($redirect_logout_path);
    }

//	header('location: ../logout.php');
    exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1) {
    header('location: ../dashboard.php');
}
?>
    <!DOCTYPE html>
    <html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $sitename; ?> | User Form</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->

    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/gallery.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>

    <style>
        #sub_app {
            padding: 20px 40px;
            color: red;
            font-size: initial;
        }

        #approve_msg {
            color: red;
            font-size: x-small;;
        }
        #success_msg{
            font-size: large;
            padding: 12px;
            width: 30%;

        }
        .form-control[disabled]{
            color: #000 !important;
        }
        #rej_reason_div_{
            display: none;
        }
        .select2-container {
            width: auto !important;
            float: left !important;
        }

        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #060818!important;
            border-block-start: none;
            border-bottom-color: #191e3a!important;
        }
        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #999;
            border-bottom-style: none;
        }
        .approve {
            background-color: #1e73be;
            font-size: 12px;
            margin-left: 16px;
            margin-top: 1px;
        }
        .reject {
            background-color: #1e73be;
            font-size: 12px;
            margin-left: 16px;
            margin-top: 1px;
        }
        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {
            #success_msg{

                width: 45%;

            }

            .form_row_item{
                width: 100%;
            }

            .col-md-3.mob{
                width:40%;
            }
            .form_tab_td{
                padding: 10px 100px;
            }
            /*.reject {*/
            /*    background-color: #1e73be;*/
            /*    font-size: 12px;*/
            /*    margin-left: 16px;*/
            /*    margin-top: -36px;*/
            /*    float: right;*/
            /*}*/
            textarea.form-control {
                height: auto;
                font-size: 15px;
            }

        }
        @media
        only screen and (max-width: 400px),
        (min-device-width: 400px) and (max-device-width: 670px)  {
            #success_msg{

                width: 45%;

            }
            .form_tab_td{
                padding: 0px 0px;
            }

        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 21px!important;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-3{
                width: 35%!important;
            }

            .select2-selection--single{
                border-block-start: inherit;
            }

        }
    </style>
</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "SPC Analytics";
$get_form_name = $_GET['form_name'];
$timedisplay = $chicagotime;
//echo $timedisplay;
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- Main content -->
<div class="page-container">
    <div class="content">
        <!-- Page header -->
        <div class="panel panel-flat">
            <div class="row ">
                    <div class="col-md-12">
                        <form action="" id="form_settings" enctype="multipart/form-data"
                              class="form-horizontal" method="post" autocomplete="off">
                         <?php $form_create_id =  $_GET['id'];
                         $query = "select * from form_item where form_create_id = '$form_create_id'";
                         $result = mysqli_query($db,$query);
                          while($row = mysqli_fetch_array($result)){
                              $item_desc = $row['item_desc'];
                         ?>

                            <div class="form_row row">
                                <label class="col-lg-3 control-label">Item Description : </label>
                                <div class="col-md-7">

                             <a href="form_analytics.php?id=<?php echo $form_create_id ?>" target="_blank" >
                                 <input type="text" name="item_desc" id="item_desc"  class="form-control"
                                                value="<?php echo $item_desc; ?>" style="cursor: pointer;"></a>

                                </div>
                            </div>
                        <?php } ?>
                            <br/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
</div>
<?php include('../footer.php') ?>
</body>
</html>
