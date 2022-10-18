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
if (count($_POST) > 0) {
    $teams1 = $_POST['teams'];
    $users1 = $_POST['users'];
    foreach ($teams1 as $teams) {
        $array_team .= $teams . ",";
    }
    foreach ($users1 as $users) {
        $array_user .= $users . ",";
    }
    $sql = "update sg_email_report_config set teams='$array_team',users='$array_user',subject='$_POST[subject]',message='$_POST[message]',signature='$_POST[signature]' where sg_mail_report_config_id='5'";
    $result1 = mysqli_query($db, $sql);
    if ($result1) {
        $message_stauts_class = 'alert-success';
        $import_status_message = 'Data Updated successfully.';
    } else {
        $message_stauts_class = 'alert-danger';
        $import_status_message = 'Error: Please Retry...';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Daily Efficiency Report Log </title>
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
        }  @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
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
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Daily Efficiency Report Log ";
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
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Daily Efficiency Report Log </h5>
                <?php if ($temp == "one") { ?>
                    <br/>					<div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">Group</span> Created Successfully.
                    </div>
                <?php } ?>
                <?php if ($temp == "two") { ?>
                    <br/>					<div class="alert alert-success no-border">
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
                <?php
                $query = sprintf("SELECT * FROM  sg_email_report_config where sg_mail_report_config_id = '5'");
                $qur = mysqli_query($db, $query);
                while ($rowc = mysqli_fetch_array($qur)) {
                    ?>
                    <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $rowc['sg_mail_report_config_id']; ?>" >
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" id="user_form" enctype="multipart/form-data"  class="form-horizontal" method="post">
                                <div class="row">
                                    <label class="col-lg-2 control-label">To Teams : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="select-border-color" data-placeholder="Add Teams..." value="<?php echo $rowc["teams"]; ?>" name="teams[]" id="teams" multiple="multiple"  >
                                                <?php
                                                $arrteam = explode(',', $rowc["teams"]);
                                                $sql1 = "SELECT DISTINCT(`group_id`) FROM `sg_user_group`";
                                                $result1 = $mysqli->query($sql1);
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if (in_array($row1['group_id'], $arrteam)) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    $station1 = $row1['group_id'];
                                                    $qurtemp = mysqli_query($db, "SELECT * FROM  sg_group where group_id = '$station1' ");
                                                    $rowctemp = mysqli_fetch_array($qurtemp);
                                                    $groupname = $rowctemp["group_name"];
                                                    echo "<option value='" . $row1['group_id'] . "' $selected>" . $groupname . "</option>";
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
                                    <label class="col-lg-2 control-label">To Users : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="select-border-color" data-placeholder="Add Users ..." name="users[]" id="users"  multiple="multiple" >
                                                <?php
                                                $arrteam1 = explode(',', $rowc["users"]);
                                                $sql1 = "SELECT * FROM `cam_users` WHERE `assigned2` = '0'  and `users_id` != '1' order BY `firstname` ";
                                                $result1 = $mysqli->query($sql1);
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if (in_array($row1['users_id'], $arrteam1)) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    echo "<option value='" . $row1['users_id'] . "' $selected>" . $row1['firstname'] . "&nbsp;" . $row1['lastname'] . "</option>";
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
                                    <label class="col-lg-2 control-label" >Subject : </label>
                                    <div class="col-md-6">
                                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject" value="<?php echo $rowc["subject"]; ?>" required>
                                    </div>
                                </div><br/>
                                <div class="row">
                                    <!--<div class="col-md-4">-->
                                    <label class="col-lg-2 control-label">Message : </label>
                                    <div class="col-md-6">
                                        <textarea id="message" name="message" rows="4" placeholder="Enter Message..." class="form-control" ><?php echo $rowc["message"]; ?></textarea>
                                    </div>
                                </div><br/>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Signature : </label>
                                    <div class="col-md-6">
                                        <input type="text" name="signature" id="signature" class="form-control" value="<?php echo $rowc["signature"]; ?>" placeholder="Enter Signature..." required>
                                    </div>
                                </div>
                                <br/>

                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="panel-footer p_footer">
                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Update</button>
            </div>

            </form>
        </div>
        <!-- /main charts -->
        <!-- edit modal -->
        <!-- Dashboard content -->
        <!-- /dashboard content -->

    </div>

</div>
<!-- /page container -->

<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>report_config_module/daily_report_gbp_config.php");
    }
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
<?php include ('../footer.php') ?>
</body>
</html>
