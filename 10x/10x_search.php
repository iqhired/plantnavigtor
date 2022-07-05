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
$station = $_GET['station'];
$station_event_id =  $_GET['station_event_id'];
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../dashboard.php');
}
if (count($_POST) > 0) {

    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];
}else{
    $curdate = date('Y-m-d');
    $dateto = $curdate;
    $yesdate = date('Y-m-d',strtotime("-1 days"));
    $datefrom = $yesdate;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> |10x Form List</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">


    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
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


        .col-md-6.date {
            width: 25%;
        }
        .create {
            float: right;
            padding: 12px;

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
<?php $cust_cam_page_header = "View 10x Form";
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
    <div class="col-md-2 create">
        <a href="<?php echo $siteURL; ?>10x/10x.php?station=<?php echo $station; ?>&station_event_id=<?php echo $station_event_id; ?>">
            <button type="submit" id="create" class="btn btn-primary" style="background-color: #009688;float:right">Add/Create New 10x Form</button>
        </a>
    </div>
    <div class="content" style="padding: 70px 30px !important;">

        <?php

                    $result = "SELECT * FROM `10x` where station_event_id = '$station_event_id' ORDER BY `10x_id` DESC";
                    $qur = mysqli_query($db,$result); ?>
            <div class="panel panel-flat" >
                <table class="table datatable-basic">
                    <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Action</th>
                        <th>Station</th>
                        <th>Part Family</th>
                        <th>Part Number</th>
                        <th class="form_create">Created At</th>
                    </tr>
                    </thead>
                    <tbody>

                       <?php
                    while ($rowc = mysqli_fetch_array($qur)) {
                        $line_name = $rowc["line_no"];
                        $sqlnumber = "SELECT * FROM `cam_line` where `line_id` = '$line_name'";
                        $resultnumber = mysqli_query($db,$sqlnumber);
                        $rowcnumber = mysqli_fetch_array($resultnumber);
                        $station = $rowcnumber['line_name'];

                        $part_no = $rowc["part_no"];
                        $sqlpart = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_no'";
                        $resultpart = mysqli_query($db,$sqlpart);
                        $rowcpart = mysqli_fetch_array($resultpart);
                        $part_number = $rowcpart['part_number'];

                        $part_family = $rowc["part_family_id"];
                        $sqlpartfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
                        $resultpartfamily = mysqli_query($db,$sqlpartfamily);
                        $rowcpartfamily = mysqli_fetch_array($resultpartfamily);
                        $part_family = $rowcpartfamily['part_family_name'];

                        $created_at= $rowc["created_at"];
                        $station_event_id = $_GET['station_event_id'];


                        ?>
                        <tr>
                            <td> <?php echo ++$counter; ?></td>
                            <td >
                                <a href="view_10x.php?id=<?php echo $rowc['10x_id']; ?>&station_event_id=<?php echo $station_event_id;?>" class="btn btn-primary" style="background-color:#1e73be;"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a href="edit_10x.php?id=<?php echo $rowc['10x_id']; ?>&station_event_id=<?php echo $station_event_id;?>" class="btn btn-primary" style="background-color:#1e73be;"> <i class="fa fa-edit"></i></i></a>

                            </td>

                            <td> <?php echo $station ?></td>

                            <td> <?php echo   $part_family;?></td>
                            <td> <?php echo $part_number; ?></td>

                            <td> <?php echo $created_at ?></td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
                </form>
            </div>


    </div>
</div>
<!-- Dashboard content -->
<!-- /dashboard content -->
<script> $(document).on('click', '#delete', function () {
        var element = $(this);
        var del_id = element.attr("data-id");
        var info = 'id=' + del_id;
        $.ajax({type: "POST", url: "ajax_job_title_delete.php", data: info, success: function (data) { }});
        $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
    });</script>
<script>
    jQuery(document).ready(function ($) {
        $(document).on('click', '#edit', function () {
            var element = $(this);
            var edit_id = element.attr("data-id");
            var name = $(this).data("name");
            $("#edit_name").val(name);
            $("#edit_id").val(edit_id);
            //alert(role);
        });
    });
</script>
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
<!-- /content area -->



<script>

    $('#station').on('change', function (e) {
        $("#user_form").submit();
    });
    $('#part_family').on('change', function (e) {
        $("#user_form").submit();
    });
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).on("click","#submit_btn",function() {

        var station = $("#station").val();
        var part_family = $("#part_family").val();
        var part_number = $("#part_number").val();
        var form_type = $("#form_type").val();
        $("#user_form").submit();
        // var flag= 0;
        // if(station == null){
        //     $("#error1").show();
        //     var flag= 1;
        // }
        // if(part_family == null){
        //     $("#error2").show();
        //     var flag= 1;
        // }
        // if(part_number == null){
        //     $("#error3").show();
        //     var flag= 1;
        // }
        // if(form_type == null){
        //     $("#error4").show();
        //     var flag= 1;
        // }
        // if (flag == 1) {
        //     return false;
        // }

    });

</script>

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
<?php include('../footer.php') ?>
</body>
</html>

