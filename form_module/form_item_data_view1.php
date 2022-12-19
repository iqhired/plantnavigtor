<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
        header($redirect_tab_logout_path);
    }else{
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
    if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
        header($redirect_tab_logout_path);
    }else{
        header($redirect_logout_path);
    }

//	header('location: ../logout.php');
    exit;
}
$is_tab_login = $_SESSION['is_tab_user'];
$is_cell_login = $_SESSION['is_cell_login'];
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Analytics Trend Form view</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">


    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/example.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
    <style>
        .red {
            color: red;
            display: none;
        }
        .tooltip {
            position: relative;
            display: inline-block;
            /*border-bottom: 1px dotted black;*/
            opacity: 1!important;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #26a69a;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        .col-md-6.date {
            width: 25%;
        }


        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px)  {

            .form_mob{
                display: none;
            }
            .form_create{
                display: none;
            }




        }
        @media
        only screen and (max-width: 400px),
        (min-device-width: 400px) and (max-device-width: 670px)  {

            .form_mob{
                display: none;
            }
            .form_create{
                display: none;
            }
            .col-md-6.date {
                width: 100%;
                float: right;
            }





        }
    </style>

</head>
<body>
<!-- Main navbar -->
<?php $cust_cam_page_header = "Analytics Trend Form view";
include("../header.php");

if (($is_tab_login || $is_cell_login)) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<div class="page-container">
    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">

                <form action="" id="form_item" class="form-horizontal" method="post" autocomplete="off">

                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $form_createid = $_GET['id'];
                            $query1 = sprintf("SELECT * FROM  form_create where form_create_id = '$form_createid' ");
                            $qur1 = mysqli_query($db, $query1);
                            $rowc1 = mysqli_fetch_array($qur1);
                            $name = $rowc1['name'];
                            $item_id = $rowc1['form_create_id'];
                            $part_family = $rowc1['part_family'];
                            $station = $rowc1['station'];
                            $form_type = $rowc1['form_type'];
                            $part_number = $rowc1['part_number'];

                            ?>
                            <b><h4 class="panel-title form_panel_title"><?php echo $name; ?>
                                </h4></b>
                            <input type="hidden" name="name" id="name" value="<?php echo $name; ?>">
                            <input type="hidden" name="createid" id="createid" value="<?php echo $form_createid; ?>">
                            <?php
                            $qur2 = mysqli_query($db, "SELECT * FROM form_type where form_type_id = '$form_type'");
                            $row2 = mysqli_fetch_array($qur2);
                            $form_type_name = $row2["form_type_name"];
                            ?>

                            <div class="form_row row">
                                <label class="col-lg-3 control-label">Form Type : </label>
                                <div class="col-md-7">
                                    <input type="text" name="form_type" id="form_type" class="form-control"
                                           value="<?php echo $form_type_name; ?>"
                                           disabled>
                                </div>
                            </div>
                            <br/>
                            <?php
                            $qur1 = mysqli_query($db, "SELECT * FROM cam_line where line_id = '$station' and enabled = 1");
                            $row1 = mysqli_fetch_array($qur1);
                            $line_name = $row1["line_name"];
                            ?>

                            <div class="form_row row">
                                <label class="col-lg-3 control-label">Station : </label>
                                <div class="col-md-7">
                                    <input type="text" name="station" id="station" class="form-control"
                                           value="<?php echo $line_name; ?>"
                                           disabled>
                                </div>
                            </div>

                            <br/>
                            <?php
                            $qurtemp = mysqli_query($db, "SELECT * FROM pm_part_family where pm_part_family_id = '$part_family' ");
                            $rowctemp = mysqli_fetch_array($qurtemp);
                            $part_family_name = $rowctemp["part_family_name"];
                            ?>

                            <div class="form_row row">
                                <label class="col-lg-3 control-label">Part Family : </label>
                                <div class="col-md-7">
                                    <input type="text" name="part_family" id="part_family" class="form-control"
                                           value="<?php echo $part_family_name; ?>"
                                           disabled>
                                </div>
                            </div>
                            <br/>
                            <?php
                            $qur3 = mysqli_query($db, "SELECT * FROM pm_part_number where pm_part_number_id = '$part_number'");
                            $row3 = mysqli_fetch_array($qur3);
                            $part_number = $row3["part_number"];
                            $part_name = $row3["part_name"];
                            ?>

                            <div class="form_row row">
                                <label class="col-lg-3 control-label">Part Number : </label>
                                <div class="col-md-7">
                                    <input type="text" name="part_number" id="part_number" class="form-control"
                                           value="<?php echo $part_number . ' - ' . $part_name; ?>"
                                           disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr/>
                <b><h4 class="panel-title form_panel_title">Form Item Information</h4></b>
                <form action="" id="form_trend" class="form-horizontal" method="post" autocomplete="off">

                    <?php
                    $result = "SELECT form_item_id,form_create_id,item_desc,item_val,created_at,updated_at FROM `form_item` WHERE form_create_id = '$form_createid' and `item_val` IN ('numeric','binary') ORDER BY form_item_id ASC";
                    $qur = mysqli_query($db,$result);
                    while ($rowc = mysqli_fetch_array($qur)) {
                        $item_desc = $rowc["item_desc"];
                        $form_item_id = $rowc["form_item_id"];
                        $item_val = $rowc["item_val"];
                        if($item_val == "numeric"){
                            $i_val = '(N)';
                        }else{
                            $i_val = '(B)';
                        }
                        ?>

                        <div class="form_row row">
                            <div class="col-md-7">
                                <input type="text" name="item_desc" id="item_desc"  class="form-control"
                                       value="<?php echo $i_val.'  '.$item_desc; ?>" style="cursor: pointer;" disabled></a>
                            </div>
                            <div class="col-md-1">
                                <a href="form_analytics.php?id=<?php echo $form_createid; ?>&item_id=<?php echo $form_item_id; ?>&date_from=<?php echo $datefrom; ?>&date_to=<?php echo $dateto; ?>" class="btn btn-primary" style="background-color:#1e73be;" target="_blank" ><i class="fa fa-line-chart"></i></a>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Dashboard content -->
<!-- /dashboard content -->
<script>
    $(function () {
        $('input:radio').change(function () {
            var abc = $(this).val()
            //alert(abc)
            if (abc == "button1")
            {
                $('#date_from').prop('disabled', false);
                $('#date_to').prop('disabled', false);
                $('#timezone').prop('disabled', true);
            }
        });
    });
</script>
</div>
<script type="text/javascript">
    $(function () {
        $("#btn").bind("click", function () {
            $("#station")[0].selectedIndex = 0;
            $("#part_family")[0].selectedIndex = 0;
            $("#part_number")[0].selectedIndex = 0;
            $("#form_type")[0].selectedIndex = 0;
        });
    });
</script>
<script>
    $(function(){
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;

        $('#date_to').attr('max', maxDate);
        $('#date_from').attr('max', maxDate);
    });
</script>
<?php include ('../footer.php') ?>
</body>
</html>

