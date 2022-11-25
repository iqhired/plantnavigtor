<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: ../logout.php');

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
    header($redirect_logout_path);
//	header('location: ../logout.php');
    exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;

$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}

$edit_id = $_POST['edit_id'];
if ($edit_id != "") {
    // edit material config
    $id = $_POST['edit_id'];
    $edit_teams1 = $_POST['edit_teams'];
    $edit_users1 = $_POST['edit_users'];
    $edit_m_type = $_POST['edit_material_type'];
    $edit_material_type = count($_POST['edit_material_type']);
    $edit_serial_check = $_POST['serial_status'];
    foreach ($edit_teams1 as $edit_teams) {
        $array_team .= $edit_teams . ",";
    }

    foreach ($edit_users1 as $edit_users) {
        $array_user .= $edit_users . ",";
    }
    if ($edit_material_type > 1) {
        for ($i = 0; $i < $edit_material_type; $i++) {
            if (trim($_POST['edit_material_type'][$i]) != '') {
                if($edit_serial_check == ""){
                $sql = "update `material_config` set `teams` = '$array_team', `users` = '$array_user', `material_type` = '  $edit_m_type[$i]',`serial_num_required` = '0', `created_at` = '$chicagotime' where `material_id`='$id'";
                }else{
                    $sql = "update `material_config` set `teams` = '$array_team', `users` = '$array_user', `material_type` = '  $edit_m_type[$i]',`serial_num_required` = '1', `created_at` = '$chicagotime' where `material_id`='$id'";

                }
                $result1 = mysqli_query($db, $sql);
                if ($result1) {
                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Data Updated successfully.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Retry...';
                }
            }
        }
    } else {
        if($edit_serial_check == ""){
        $sql = "update `material_config` set `teams` = '$array_team', `users` = '$array_user', `material_type` = '$edit_m_type[0]',`serial_num_required` = '0', `created_at` = '$chicagotime' where `material_id`='$id'";
        }else{
            $sql = "update `material_config` set `teams` = '$array_team', `users` = '$array_user', `material_type` = '$edit_m_type[0]',`serial_num_required` = '1', `created_at` = '$chicagotime' where `material_id`='$id'";

        }
        $result1 = mysqli_query($db, $sql);

        if ($result1) {
            $temp = "two";
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Data Updated successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Retry...';
        }
        header("Location:material_config.php");

    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $siteURL; ?> | material Config</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <style>
        .sidebar-default .navigation li>a{color:#f5f5f5};
        a:hover {
            background-color: #20a9cc;
        }
        .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
            background-color: #20a9cc;
        }
        .form-control:focus {
            border-color: transparent transparent #1e73be !important;
            -webkit-box-shadow: 0 1px 0 #1e73be;
            box-shadow: 0 1px 0 #1e73be !important;
        }
        .form-control {
            border-color: transparent transparent #1e73be;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .input-group-append {
            width: 112%;
        }
        .mb-3 {
            margin-bottom: 1rem!important;
            width: 90%;
        }
        #addRow {
            float: right;
            margin-top: -45px;
            margin-right: -66px;
        }
        #removeRow {
            float: right;
        }
        #addRow1 {
            float: right;
            margin-top: -45px;
            margin-right: -66px;
        }
        #removeRow1 {
            float: right;
            margin-left: -25px;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-2 {
                width: 28%!important;
                float: left;
            }
            .col-md-6 {
                width: 60%;
                float: left;
            }
            .col-lg-1 {
                width: 12%;
                float: right;
            }
            .input-group-append {
                width: 122%!important;
            }
        }
        .c_footer{
            margin-left: 110px;
            margin-top: -50px;
        }
        .checkbox-control {
            height: 15px;
            width: 15px;
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Material Tracability Config";
include("../header_folder.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->

    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->

        <div class="panel panel-flat focus" id="edit_modal_theme_primary">
            <div class="panel-heading">
                <h5 class="panel-title">Edit Material Tracability Config</h5>
                <?php if ($temp == "one") { ?>
                    <br/>					<div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">Group</span> Created Successfully.
                    </div>
                <?php } ?>
                <?php if ($temp == "two") { ?>
                    <br/><div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">Group</span> Updated Successfully.
                    </div>
                <?php } ?>
                <?php
                if (!empty($import_status_message)) {
                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                }
                ?>
                <?php
                if (!empty($_SESSION['import_status_message'])) {
                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                    $_SESSION['message_stauts_class'] = '';
                    $_SESSION['import_status_message'] = '';
                }
                ?>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="user_form" class="form-horizontal" method="post">
                            <?php
                            $edit_id = $_GET['id'];
                            ?>
                            <?php
                            $sql1 = "SELECT * FROM `material_config` where material_id = '$edit_id' ";
                            $result1 = $mysqli->query($sql1);
                            while ($row1 = $result1->fetch_assoc()) {
                                $teams = $row1['teams'];
                                $users = $row1['users'];
                                $material_type = $row1['material_type'];
                                $serial_check = $row1['serial_num_required'];
                            }
                            ?>
                            <div class="row">
                                <label class="col-lg-2 control-label">Material Teams : </label>
                                <div class="col-md-6"  id="edit_teams_val">
                                    <div class="form-group">

                                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>">
                                        <select class="select-border-color" data-placeholder="Add Teams..." name="edit_teams[]" id="edit_teams" multiple="multiple" >

                                            <?php
                                            $arrteam = explode(',',$teams);
                                            $sql1 = "SELECT * FROM sg_group order by group_name ASC";
                                            $result1 = $mysqli->query($sql1);
                                            while ($rowt = $result1->fetch_assoc()) {
                                                if (in_array($rowt['group_id'], $arrteam)) {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = "";
                                                }

                                                echo "<option id='" . $rowt['group_id'] . "' value='" . $rowt['group_id'] . "' $selected>" . $rowt['group_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group1()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-lg-2 control-label">Material Users : </label>
                                <div class="col-md-6"  id="edit_users_val">
                                    <div class="form-group">
                                        <select class="select-border-color" data-placeholder="Add Users ..." name="edit_users[]" id="edit_users"  multiple="multiple" >
                                            <?php
                                            $arrteam = explode(',',$users);
                                            $sql12= "SELECT users_id, firstname,lastname FROM cam_users order by firstname ASC";
                                            $result2 = mysqli_query($db,$sql12);
                                            while ($rowu = $result2->fetch_assoc()) {
                                                if (in_array($rowu['users_id'], $arrteam)) {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = "";
                                                }
                                                echo "<option id='" . $rowu['users_id'] . "' value='" . $rowu['users_id'] . "' $selected>" . $rowu['firstname'] . "&nbsp" . $rowu['lastname'] . "</option>";
                                            }


                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group2()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-lg-2 control-label" >Material Type : </label>
                                <div class="col-md-6">
                                    <div id="inputFormRow2">
                                        <div class="input-group mb-3">
                                            <input type="text" name="edit_material_type[]" id="edit_material_type" value="<?php echo  $material_type; ?>" class="form-control m-input" placeholder="Enter Material Type" autocomplete="off">
                                        </div>
                                    </div>
<!--                                    <div id="newRow1"></div>-->
<!--                                    <button id="addRow1" type="button" class="btn btn-primary" style="background-color: #1e73be;"><i class="fa fa-plus" aria-hidden="true"></i></button>-->
                                </div>
                            </div><br/>
                            <div class="row">
                                <label class="col-lg-2 control-label">Is Serial Number Required:*</label>
                                <div class="col-md-6">
                                    <input type="checkbox" class="checkbox-control" name="serial_status" id="serial_status" <?php if($serial_check == 1){echo 'checked';} ?> >
                                </div>
                            </div>

                            <br/>

                            <br/>

                    </div>
                </div>

            </div>
            <div class="panel-footer p_footer">
                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Save</button>
            </div>
            </form>
            <div class="c_footer">
                <button type="submit"  class="btn btn-primary" style="background-color:#1e73be;" onclick="history.go(-1)">Cancel </button>
            </div>
        </div>


        <!-- /main charts -->
     </div>



</div>

</div>


<script>
    // add row
    $("#addRow2").click(function () {
        var html = '';
        html += '<div id="inputFormRow2">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="material_type[]" class="form-control m-input" placeholder="Enter Material Type" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow2" type="button" class="btn btn-danger"><i class="fa fa-minus" aria-hidden="true"></i></button>';
        html += '</div>';
        html += '</div>';

        $('#newRow1').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow2', function () {
        $(this).closest('#inputFormRow2').remove();
    });
</script>


<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    function group1()
    {
        $("#teams").select2("open");
    }
    function group2()
    {
        $("#users").select2("open");
    }
</script>
<script>
    function showDiv() {
        document.getElementById('edit_modal_theme_primary').style.display = "block";
        $('.focus').focus();
    }
    function hideDiv() {
        document.getElementById('edit_modal_theme_primary').style.display = "none";

    }
</script>

<!-- /page container -->

<?php include ('../footer.php') ?>
</body>
</html>
