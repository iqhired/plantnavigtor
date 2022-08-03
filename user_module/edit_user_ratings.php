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

$u_id = $_GET['id'];

if (count($_POST) > 0) {
//edit
	$id = $_POST['edit_id'];

    $edit_ratings = $_POST['edit_ratings'];

	$sql = "update cam_user_rating set ratings ='$edit_ratings' where user_rating_id='$id'";

	$result1 = mysqli_query($db, $sql);
	if ($result1) {
		$message_stauts_class = 'alert-success';
		$import_status_message = 'User ratings Updated successfully.';
	} else {
		$message_stauts_class = 'alert-danger';
		$import_status_message = 'Error: Please Insert valid data';
	}

	header('location: user_ratings.php');

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | User ratings</title>
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

    .form-horizontal .form-group {
        font-size: 14px;
    }
    textarea.form-control {
        height: auto;
        border: 1px solid #dcd2d2;
    }
</style>

<!-- Main navbar -->
<?php
$cust_cam_page_header = " Edit User Ratings";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->

    <!-- Content area -->
    <div class="content">

        <div class="panel panel-flat">
            <div class="panel-heading">
                <form action="" id="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
							<?php
							$edit_id = $_GET['id'];

							$sql1 = "SELECT * FROM `cam_user_rating` where user_rating_id = '$edit_id' ";
							$result1 = mysqli_query($db, $sql1);

							while ($row1 = mysqli_fetch_array($result1)) {
                                $position = $row1['position_id'];
								$line_id = $row1['line_id'];
								$user_id = $row1['user_id'];
								$ratings = $row1['ratings'];
							}
							?>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Station:*</label>
                                    <div class="col-lg-7"  style="pointer-events: none;">
                                        <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
                                        <select name="edit_line_name" id="edit_line_name" class="select form-control" data-style="bg-slate" >
                                            <option value="" disabled>--- Select Station ---</option>
                                            <?php
                                            $sql_line = "SELECT line_id,line_name FROM `cam_line`";
                                            $result_line = mysqli_query($db,$sql_line);
                                            while ($row_line = mysqli_fetch_array($result_line)) {
                                                if($line_id == $row_line['line_id']){
                                                    $entry = 'selected';
                                                }else{
                                                    $entry = '';
                                                }
                                                echo "<option value='" . $row_line['line_id'] . "'$entry>" . $row_line['line_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Position:*</label>
                                    <div class="col-lg-7"  style="pointer-events: none;">
                                        <select name="edit_position_name" id="edit_position_name" class="select form-control" data-style="bg-slate" >
                                            <option value="" disabled>--- Select Position ---</option>
                                            <?php
                                            $sql1 = "SELECT position_id,position_name FROM `cam_position`";
                                            $result1 = mysqli_query($db,$sql1);
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                if($position == $row1['position_id']){
                                                    $entry = 'selected';
                                                }else{
                                                    $entry = '';
                                                }
                                                echo "<option value='" . $row1['position_id'] . "'$entry>" . $row1['position_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">user:*</label>
                                    <div class="col-lg-7"  style="pointer-events: none;">
                                        <input type="hidden" name="edit_e" id="edit_e" >
                                        <select name="edit_user_name" id="edit_user_name" class="select form-control" data-style="bg-slate" >
                                            <option value="" disabled>--- Select User ---</option>
                                            <?php
                                            $sql1 = "SELECT users_id,firstname,lastname FROM `cam_users`  where `users_id` != '1' order BY `user_name`";
                                            $result1 = mysqli_query($db,$sql1);
                                            while ($row1 =mysqli_fetch_array($result1)) {
                                                if($user_id == $row1['users_id']){
                                                    $entry = 'selected';
                                                }else{
                                                    $entry = '';
                                                }
                                                echo "<option value='" . $row1['user_id'] . "'$entry>" . $row1['firstname']. " " .$row1['lastname']. "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">User Rating:*</label>
                                    <div class="col-lg-7">
                                        <select name="edit_ratings" id="edit_ratings" class="select form-control" data-style="bg-slate" >

                                            <option value="0" <?php if($ratings == '0'){echo 'selected';} ?> >0</option>
                                            <option value="1" <?php if($ratings == '1'){echo 'selected';} ?>>1</option>
                                            <option value="2" <?php if($ratings == '2'){echo 'selected';} ?>>2</option>
                                            <option value="3" <?php if($ratings == '3'){echo 'selected';} ?>>3</option>
                                            <option value="4" <?php if($ratings == '4'){echo 'selected';} ?>>4</option>
                                            <option value="5" <?php if($ratings == '5'){echo 'selected';} ?>>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<!-- /page container -->

<script>
    //window.onload = function() {
    //    history.replaceState("", "", "<?php //echo $scriptName; ?>//config_module/edit_user_ratings.php?id=<?php //echo $edit_id;?>//");
    //}
</script>




<?php include('../footer.php') ?>
<!--<script type="text/javascript" src="../assets/js/core/app.js"></script>-->
</body>
</html>