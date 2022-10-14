<?php include("../config.php");
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
$edit_name = $_POST['edit_cell_name'];
$enabled = $_POST['edit_enabled'];
$edit_file = $_FILES['upload_image']['name'];
if ($edit_name != "") {
    $id = $_POST['edit_id'];
    $stations = $_POST["edit_cell_stations"];
    $account = (isset($_POST['edit_cell_account']))?$_POST['edit_cell_account']:NULL;
    foreach ($stations as $station) {
        $array_stations .= $station . ",";
    }
//eidt logo
    if($edit_file != "")
    {
        if (isset($_FILES['upload_image'])) {
            $errors = array();
            $file_name = $_FILES['upload_image']['name'];
            $file_size = $_FILES['upload_image']['size'];
            $file_tmp = $_FILES['upload_image']['tmp_name'];
            $file_type = $_FILES['upload_image']['type'];
            $file_ext = strtolower(end(explode('.', $file_name)));
            $extensions = array("jpeg", "jpg", "png", "pdf");
            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: Extension not allowed, please choose a JPEG or PNG file.';
            }
            if ($file_size > 2097152) {
                $errors[] = 'File size must be excately 2 MB';
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: File size must be less than 2 MB';
            }
            if (empty($errors) == true) {
                $fname = "cell_grp_" .time() . "_" . $file_name;
                move_uploaded_file($file_tmp, "../supplier_logo/" . $file_name);

                if(isset($account)){
                    $sql = "update `cell_grp` set c_name = '$edit_name',cell_logo = '$file_name',account_id = '$account',stations = '$array_stations', enabled = '$enabled'  where c_id='$id'";

                }else{
                    $sql = "update `cell_grp` set c_name = '$edit_name',cell_logo = '$file_name',stations = '$array_stations', enabled = '$enabled'  where c_id='$id'";

                }
            }
        }

    }
    else
    {
        if(isset($account)){
            $sql = "update `cell_grp` set c_name = '$edit_name', account_id = '$account',  stations = '$array_stations', enabled = '$enabled'  where c_id='$id'";

        }else{
            $sql = "update `cell_grp` set c_name = '$edit_name',  stations = '$array_stations', enabled = '$enabled'  where c_id='$id'";

        }
    }
    $result1 = mysqli_query($db, $sql);
    if ($result1) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Cell Updated Sucessfully.';
        header("Location:dashboard_config.php");
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Error: Please Retry';
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Update Dashboard</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
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
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <style>
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-md-10{
                width: 72%;
                float: right;
            }
            .col-md-2 control-label{
                width: 26%!important;
            }
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php $cust_cam_page_header = "Edit Dashboard";
include("../header_folder.php");
include("../admin_menu.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">

    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <?php
                                $id = $_GET['id'];
                            ?>
                            <form action="" id="edit_form_dash" class="form-horizontal" method="post">
                                <div class="modal-body">
                                    <div class="row">

                                        <?php
                                        $query = sprintf("SELECT * FROM cell_grp where c_id = '$id' AND is_deleted != '1'");
                                        $qur = mysqli_query($db, $query);
                                        $rowc = mysqli_fetch_array($qur);
                                        $cust_id = $rowc["account_id"];
                                        ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Cell Name * :</label>
                                                <div class="col-md-10">
                                                    <input type="text" name="edit_cell_name" id="edit_cell_name" class="form-control" value = "<?php echo $rowc['c_name']; ?>" required>
                                                    <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $id; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Stations:</label>

                                                <div class="col-md-10">
                                                    <select required name="edit_cell_stations[]" id="edit_cell_stations"  class="select-border-color"
                                                            multiple="multiple">
                                                        <?php
                                                        $arrteam = explode(',', $rowc["stations"]);
                                                        $sql1 = "SELECT line_id,line_name FROM `cam_line`";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if (in_array($row1['line_id'], $arrteam)) {
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                            echo "<option id='" . $row1['line_id'] . "'  value='" . $row1['line_id'] . "' $selected>" . $row1['line_name'] . "</option>";
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Account :</label>
                                            <div class="col-md-10">
                                                <select name="edit_cell_account" id="edit_cell_account"
                                                        class="form-control">
                                                    <option value="" selected disabled>--- Select Account Type ---
                                                    </option>
                                                    <?php
                                                    $sql1 = "SELECT * FROM `cus_account` where is_deleted != 1 ORDER BY `c_name` ASC";
                                                    $result1 = $mysqli->query($sql1);
                                                    //                                            $entry = 'selected';
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        echo "<option value='" . $row1['c_id'] . "'  >" . $row1['c_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Enabled : </label>

                                                <div class="col-lg-8">
                                                    <select name="edit_enabled" id="edit_enabled" class="form-control"
                                                            style="float: left;
                                                             width: initial;">
                                                        <option value="1"<?php if ($rowc["enabled"] == '1'){echo 'selected';} ?>>Yes</option>
                                                        <option value="0"<?php if ($rowc["enabled"] == '0'){echo 'selected';} ?>>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Upload Logo Image : </label>
                                                <div class="col-lg-9">
                                                    <input type="file" name="upload_image" id="upload_image"
                                                           class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Previous Logo Preview : </label>
                                                <div class="col-lg-9">

                                                    <img src="" alt="Image not Available" name="editlogo" id="editlogo" style="height:150px;width:150px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /basic datatable -->
                    <!-- /main charts -->


                    <!-- Dashboard content -->

                    <script>
                        $('#choose').on('change', function () {
                            var selected_val = this.value;
                            if (selected_val == 1 || selected_val == 2) {
                                $(".group_div").show();
                            } else {
                                $(".group_div").hide();
                            }
                            if (selected_val == 5 ) {
                                $('#delete_form').submit();
                            }
                        });
                    </script>
                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->
    </div>
</div>
<!-- /page container -->
<?php include ('../footer.php') ?>

</body>
</html>
