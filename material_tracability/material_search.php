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
    <title><?php echo $sitename; ?> | User Form List</title>
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
<?php $cust_cam_page_header = "View material Form";
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
<!--        <div class="panel panel-flat">-->
<!--            <div class="panel-heading">-->
<!--                						<h5 class="panel-title">Job-Title List</h5>-->
<!--              						<hr/>-->
<!---->
<!--                <form action="" id="user_form" class="form-horizontal" method="post" autocomplete="off">-->
<!---->
<!--                    <div class="row">-->
<!--                        <div class="col-md-12">-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-6 mobile">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-lg-3 control-label">Station * : </label>-->
<!--                                        <div class="col-lg-7">-->
<!--                                            <select name="station" id="station" class="select form-control" data-style="bg-slate" >-->
<!--                                                <option value="" selected disabled>--- Select Station ---</option>-->
<!--                                                --><?php
//                                                if($is_tab_login){
//                                                    $sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id = '$tab_line' ORDER BY `line_name` ASC";
//                                                    $result1 = $mysqli->query($sql1);
//                                                    //                                            $entry = 'selected';
//                                                    while ($row1 = $result1->fetch_assoc()) {
//                                                        $entry = 'selected';
//                                                        echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
//                                                    }
//                                                }else if($is_cell_login){
//                                                    $c_stations = implode("', '", $c_login_stations_arr);
//                                                    $sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id IN ('$c_stations') ORDER BY `line_name` ASC";
//                                                    $result1 = $mysqli->query($sql1);
////													                $                        $entry = 'selected';
//                                                    $i = 0;
//
////														$entry = 'selected';
//                                                    if(empty($_REQUEST) && empty($_REQUEST['line_number'])){
//                                                        while ($row1 = $result1->fetch_assoc()) {
//                                                            if($i == 0 ){
//                                                                $entry = 'selected';
//                                                                echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
//                                                                $c_station = $row1['line_id'];
//                                                            }else{
//                                                                echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";
//
//                                                            }
//                                                            $i++;
//                                                        }
//                                                    }else{
//                                                        while ($row1 = $result1->fetch_assoc()) {
//                                                            if($row1['line_id'] == $_REQUEST['line_number'] ){
//                                                                $entry = 'selected';
//                                                                echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
//                                                                $c_station = $row1['line_id'];
//                                                            }else{
//                                                                echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";
//
//                                                            }
//                                                            $i++;
//                                                        }
//                                                    }
//
//
//                                                }else{
//                                                    $st_dashboard = $_POST['line_number'];
//                                                    $station22 = $st_dashboard;
//                                                    $sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
//                                                    $result1 = $mysqli->query($sql1);
//                                                    //                                            $entry = 'selected';
//                                                    while ($row1 = $result1->fetch_assoc()) {
//                                                        if($st_dashboard == $row1['line_id'])
//                                                        {
//                                                            $entry = 'selected';
//                                                        }
//                                                        else
//                                                        {
//                                                            $entry = '';
//
//                                                        }
//                                                        echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
//                                                    }
//                                                }
//
//                                                ?>
<!--                                            </select>-->
<!--                                          <div id="error1" class="red">Please Select Station</div> -->
<!---->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6 mobile">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-lg-3 control-label">Part Family : </label>-->
<!--                                        <div class="col-lg-7">-->
<!--                                            <select name="part_family" id="part_family" class="select form-control" data-style="bg-slate" >-->
<!--                                                <option value="" selected disabled>--- Select Part Family ---</option>-->
<!--                                                --><?php
//                                                if(empty($_POST)){
//                                                    if($_SESSION['is_tab_user'] == 1 ){
//                                                        $station22 = $_SESSION['tab_station'];
//                                                    }
//                                                }
//                                                $st_dashboard = $_POST['part_family'];
//                                                if(empty($station22)){
//                                                    $station22 = $_POST['station'];
//                                                }
//
//                                                if(empty($station22) && ($is_cell_login == 1) && !empty($c_station)){
//                                                    $station22 = $c_station;
//                                                }
//                                                $part_family_name = $_POST['part_family_name'];
//                                                $sql1 = "SELECT * FROM `pm_part_family` where is_deleted = 0 and station = '$station22' ";
//                                                $result1 = $mysqli->query($sql1);
//                                                //                                            $entry = 'selected';
//                                                while ($row1 = $result1->fetch_assoc()) {
//                                                    if($st_dashboard == $row1['pm_part_family_id'])
//                                                    {
//                                                        $entry = 'selected';
//                                                    }
//                                                    else
//                                                    {
//                                                        $entry = '';
//
//                                                    }
//                                                    echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
//                                                }
//                                                ?>
<!--                                            </select>-->
<!--                                            <div id="error2" class="red">Please Select Part Family</div> -->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                            </div><br/>-->
<!--                            <div class="row">-->
<!---->
<!--                                <div class="col-md-6 mobile">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-lg-3 control-label">Part Number  : </label>-->
<!--                                        <div class="col-lg-7">-->
<!--                                            <select name="part_number" id="part_number" class="select form-control" data-style="bg-slate" >-->
<!--                                                <option value="" selected disabled>--- Select Part Number ---</option>-->
<!--                                                --><?php
//                                                $st_dashboard = $_POST['part_number'];
//                                                $part_family = $_POST['part_family'];
//
//                                                $sql1 = "SELECT * FROM `pm_part_number` where part_family = '$part_family' and is_deleted = 0 ";
//                                                $result1 = $mysqli->query($sql1);
//                                                //                                            $entry = 'selected';
//                                                while ($row1 = $result1->fetch_assoc()) {
//                                                    if($st_dashboard == $row1['pm_part_number_id'])
//                                                    {
//                                                        $entry = 'selected';
//                                                    }
//                                                    else
//                                                    {
//                                                        $entry = '';
//
//                                                    }
//                                                    echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] ." - ".$row1['part_name']  . "</option>";
//                                                }
//                                                ?>
<!--                                            </select>-->
<!--                                             <div id="error3" class="red">Please Select Part Number</div> -->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6 mobile">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-lg-3 control-label">Form Type : </label>-->
<!--                                        <div class="col-lg-7">-->
<!--                                            <select name="form_type" id="form_type" class="select form-control" data-style="bg-slate" >-->
<!--                                                <option value="" selected disabled>--- Select Form Type ---</option>-->
<!--                                                --><?php
//                                                $st_dashboard = $_POST['form_type'];
//
//                                                $sql1 = "SELECT * FROM `form_type` ";
//                                                $result1 = $mysqli->query($sql1);
//                                                //                                            $entry = 'selected';
//                                                while ($row1 = $result1->fetch_assoc()) {
//                                                    if($st_dashboard == $row1['form_type_id'])
//                                                    {
//                                                        $entry = 'selected';
//                                                    }
//                                                    else
//                                                    {
//                                                        $entry = '';
//
//                                                    }
//                                                    echo "<option value='" . $row1['form_type_id'] . "'  $entry>" . $row1['form_type_name'] . "</option>";
//                                                }
//                                                ?>
<!--                                            </select>-->
<!--                                           <div id="error4" class="red">Please Select Form Type</div> -->-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-6 date">-->
<!--                                                              <label class="control-label" style="float: left;padding: 10px 110px 10px 2px; font-weight: 500;">Date Range : &nbsp;&nbsp;</label>-->
<!--                                    --><?php
//                                    $myDate = date("m/d/y h:i:s");
//
//                                    ?>
<!---->
<!--                                    <input type="radio" name="button" id="button1" class="form-control" value="button1" style="float: left;width: initial; display: none;" checked>-->
<!---->
<!--                                    <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date From : &nbsp;&nbsp;</label>-->
<!--                                    <input type="date" name="date_from" id="date_from" class="form-control" value="--><?php //echo $datefrom; ?><!--" style="float: left;width: initial;" required>-->
<!--                                </div>-->
<!--                                <div class="col-md-6 date">-->
<!--                                    <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date To: &nbsp;&nbsp;</label>-->
<!--                                    <input type="date" name="date_to" id="date_to" class="form-control" value="--><?php //echo $dateto; ?><!--" style="float: left;width: initial;" required>-->
<!--                                </div>-->
<!---->
<!--                            </div><br/>-->
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </form>-->
<!---->
<!---->
<!---->
<!---->
<!--            </div>-->
<!--            <div class="panel-footer p_footer">-->
<!--                <div>-->
<!--                    <button type="submit" id="submit_btn" class="btn btn-primary submit_btn"  style="width:120px;margin-right: 20px;background-color:#1e73be;">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                    <button type="clear" id="btn" class="btn btn-primary"-->
<!--                            style="background-color:#1e73be;margin-right: 20px;width:120px;">Reset-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <?php

                    $result = "SELECT * FROM `material_tracability`";
                    $qur = mysqli_query($db,$result); ?>
            <div class="panel panel-flat" >
                <table class="table datatable-basic">
                    <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Action</th>
                        <th>Station</th>
                        <th>Material Type</th>
                        <th>Serial Number</th>
                        <th class="form_mob">Material status</th>
                        <th class="form_create">Created At</th>
                    </tr>
                    </thead>
                    <tbody>

                       <?php
                    while ($rowc = mysqli_fetch_array($qur)) {
                        $station = $rowc["line_number"];
                        $material_type = $rowc["material_type"];
                        $serial_number = $rowc["serial_number"];
                        $material_status = $rowc["material_status"];
                        $created_at= $rowc["created_at"]; ?>
                        <tr>
                            <td> <?php echo ++$counter; ?></td>
                            <td class="tooltip">
                                <a href="view_material.php?id=<?php echo $rowc['material_id']; ?>" class="btn btn-primary" style="background-color:#1e73be;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <span class="tooltiptext">View</span>
                            </td>

                            <td> <?php echo $station ?></td>
                            <td> <?php echo $material_type ?></td>
                            <td> <?php echo $serial_number ?></td>
                            <td> <?php echo $material_status ?></td>
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

<!-- <script>
	function clearForm()
{
document.getElementById("user_form").reset();

}
	</script> -->
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

