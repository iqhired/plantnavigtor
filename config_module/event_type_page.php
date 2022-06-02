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
    $name = $_POST['name'];
    $stations1 = $_POST['stations'];
    foreach ($stations1 as $stations) {
        $array_stations .= $stations . ",";
    }
    //edit
    $edit_name = $_POST['edit_name'];
    if ($edit_name != "") {
        $id = $_POST['edit_id'];
        $actual_so = $_POST['act_so'];
        $edit_so = $_POST['edit_so'];
        $edit_stations1 = $_POST['edit_stations'];
        foreach ($edit_stations1 as $edit_stations) {
            $array_stations .= $edit_stations . ",";
        }
        $edit_color_code = $_POST['edit_color_code'];
        $edit_event_cat = $_POST['edit_event_cat'];
        $set = '';
        $where = '';
        if( $edit_so != $actual_so){

            if( $actual_so < $edit_so ){
                $set = 'so = so - 1';
                $where = 'so > ' . $actual_so . ' and so <= ' . $edit_so;
            }else{
                $set = 'so = so + 1';
                $where = 'so < ' . $actual_so . ' and so >= ' . $edit_so;
            }
        }
        if($set != '' && $where != ''){
            $sql = 'update event_type set ' .  $set . ' where ' . $where;
            $result1 = mysqli_query($db, $sql);
        }
        $sql = "update event_type set stations = '$array_stations', so = '$edit_so' , event_cat_id='$edit_event_cat' ,event_type_name='$_POST[edit_name]',color_code='$_POST[edit_color_code]',updated_at='$chicagotime' where event_type_id ='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $temp = "two";
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Event Type Updated Sucessfully.';
            header("Location:event_type.php");
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Event Type with this Name Already Exists';
        }
    }
}

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Event Type</title>
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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
</head>
<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
        .col-lg-6 {
            float: right;
            width: 60% !important;
        }


        label.col-lg-4.control-label {
            width: 40%;
        }
    }
</style>

<!-- Main navbar -->
<?php $cust_cam_page_header = "Edit Event Type";
include("../header_folder.php");
include("../admin_menu.php");
include("../heading_banner.php");?>

<body class="alt-menu sidebar-noneoverflow">
<!-- Page container -->
<div class="page-container">
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <form action="" id="user_form" class="form-horizontal" method="post">
                    <?php
                    $edit_id = $_GET['id'];
                    $event_type_name = $_GET['data-id'];
                  ?>
                    <?php
                    $sql1 = "SELECT * FROM `event_type` where event_type_id = '$edit_id' ";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        $row_event = $row1['event_type_name'];
                        $row_cat_id = $row1['event_cat_id'];
                        $color_code = $row1['color_code'];
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <label class="col-lg-4 control-label">Event Type * : </label>
                                <div class="col-lg-6">
                                    <input type="text" name="edit_name" id="edit_name" class="form-control" value="<?php echo  $row_event; ?>" required>
                                    <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Select Event Category * : </label>
                                <div class="col-lg-6">
                                    <select name="edit_event_cat" id="edit_event_cat" class="select-border-color select-access-multiple-open">
                                        <option value="" disabled>--- Select Event Category ---</option>
                                        <?php
                                        $sql1 = "SELECT * FROM `events_category` where events_cat_id = '$row_cat_id'";
                                        $result1 = $mysqli->query($sql1);
                                        while ($row1 = $result1->fetch_assoc()) {
                                            echo "<option value='" . $row1['events_cat_id'] . "'$entry>" . $row1['events_cat_name'] . "</option>";
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
                                <label class="col-lg-4 control-label">Select Color Code * : </label>
                                <div class="col-lg-6">
                                    <input type="color" id="edit_color_code" name="edit_color_code" value="<?php echo $color_code ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Select Station(s) : </label>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php
                                        $query = "SELECT * FROM  event_type where event_type_id = '$edit_id'";
                                        $qur = mysqli_query($db, $query);
                                        $rowc = mysqli_fetch_array($qur);
                                        ?>
                                        <select required class="select-border-color" data-placeholder=""  name="edit_stations[]" id="edit_stations" multiple="multiple">
                                         <?php
                                            $arrteam = explode(',', $rowc["stations"]);
                                            $sql1 = "SELECT DISTINCT(`line_id`) , line_name FROM `cam_line` where enabled = 1 order by line_name";
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
															if (in_array($row1['line_id'], $arrteam)) {
																$selected = "selected";
															} else {
																$selected = "";
															}

                                                echo "<option id='" . $row1['line_id'] . "' value='" . $row1['line_id'] . "' $selected>" . $row1['line_name'] . "</option>";
                                            }
                                         ?>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="stations_open()">Add More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $query = sprintf("SELECT * FROM  event_type as et inner join events_category as ec on et.event_cat_id = ec.events_cat_id order by so ASC");
                    $qur = mysqli_query($db, $query);
                    $total_rows = $qur->num_rows;

                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Event Sequence * : </label>
                                <div class="col-lg-6">
                                    <select name="edit_so" id="edit_so" class="select-border-color select-access-multiple-open">
                                        <?php
                                        $so = $rowc['so'];
                                        $r_count = 0;
                                        while ($r_count < $total_rows) {
                                            $r_count = $r_count + 1;
                                            if($so == $r_count){
                                                $selected = 'selected';
                                            }else{
                                                $selected = '';
                                            }
                                            echo "<option value='" . $r_count . "'$selected>" . $r_count . "</option>";
                                        }

                                        ?>

                                    </select>
                                    <input type="hidden" name="act_so" id="act_so">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer p_footer">
                        <button type="submit" class="btn btn-primary"style="background-color:#1e73be;">Save
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
