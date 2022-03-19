<?php
include("../config.php");
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

$user_id = $_SESSION["id"];
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
	$events_cat_name = $_POST['events_cat_name'];
    $events_reason = $_POST['reason'];

//create
	if ($events_cat_name != "") {
//		$name = $_POST['events_cat_name'];
//		$priority_order = $_POST['priority_order'];
//		$enabled = $_POST['enabled'];
		$sql0 = "INSERT INTO `events_category`(`events_cat_name`,`reason`,`created_by` , `created_on`) VALUES ('$events_cat_name' , '$events_reason','$user_id' ,  '$chicagotime')";
		$result0 = mysqli_query($db, $sql0);
		if ($result0) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Event Category created successfully.';
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Please Insert valid data';
		}
	}
//edit
	$edit_events_cat_name = $_POST['edit_events_cat_name'];
    $edit_reason = $_POST['edit_reason'];
	if ($edit_events_cat_name != "") {
		$id = $_POST['edit_id'];
		$sql = "update events_category set events_cat_name='$_POST[edit_events_cat_name]',reason='$_POST[edit_reason]'  where events_cat_id ='$id'";
		$result1 = mysqli_query($db, $sql);
		if ($result1) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Event Category  Updated successfully.';
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Please Insert valid data';
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
    <title><?php echo $sitename; ?> | Station</title>
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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
</head>

<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
        .form-horizontal {
            width: 100%;
        }
        .col-lg-7{
            width: 60%!important;
            float: left!important;
        }
        .col-md-4 {
            float: left;
        }
        .col-lg-5{
            width: 40%!important;
            float: right!important;
        }
    }
</style>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Add / Edit Events Category";
include("../header.php");
include("../heading_banner.php");
include("../admin_menu.php"); ?>
<!-- /main navbar -->
<body class="alt-menu sidebar-noneoverflow">
<!-- Page container -->
<div class="page-container">

            <!-- Content area -->
            <div class="content">
                <!-- Main charts -->
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <!--							<h5 class="panel-title">Stations</h5>-->
                        <!--							<hr/>-->
                        <div class="row">
                          <form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="col-md-12">
                                        <div class="col-md-4">
                                            <input type="text" name="events_cat_name" id="events_cat_name"
                                                   class="form-control" placeholder="Enter Event Category" required>
                                        </div>
                                        <div class="col-md-8">

                                            <label class="control-label" style=" padding: 15px 10px;"> Is Reason required : </label>

                                            <div class="form-check form-check-inline form_col_option">
                                                <input type="radio" id="yes" name="reason" value="yes">
                                                <label for="yes" class="item_label" id="">Yes</label>
                                                <input type="radio" id="no" name="reason" value="no" checked="checked">
                                                <label for="no" class="item_label" id="">No</label>
                                            </div>

                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2" style="width: 100%;padding-top: 20px;">
                                                <button type="submit" class="btn btn-primary"
                                                        style="background-color:#1e73be;">Create Event Category
                                                </button>
                                            </div>
                                        </div>

                                    </form>

                        </div>
                        <br/>
						<?php
						if (!empty($import_status_message)) {
							echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
						}
						?>
						<?php
						if (!empty($_SESSION[$import_status_message])) {
							echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
							$_SESSION['message_stauts_class'] = '';
							$_SESSION['import_status_message'] = '';
						}
						?>
                    </div>
                </div>
                <form action="delete_event_category.php" method="post" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Delete
                            </button>
                        </div>
                    </div>
                    <br/>
                    <div class="panel panel-flat">
                        <table class="table datatable-basic">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>S.No</th>
                                <th>Event Category</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  events_category");
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]"
                                               value="<?php echo $rowc["events_cat_id"]; ?>"></td>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php echo $rowc["events_cat_name"]; ?></td>
                                    <td><?php echo $rowc["reason"]; ?></td>
                                    <td>
                                        <button type="button" id="edit" class="btn btn-info btn-xs"
                                                data-id="<?php echo $rowc['events_cat_id']; ?>"
                                                data-reason="<?php echo $rowc['reason']; ?>"
                                                data-events_cat_name="<?php echo $rowc['events_cat_name']; ?>"
                                                style="background-color:#1e73be;"
                                                data-toggle="modal" style="background-color:#1e73be;"
                                                data-target="#edit_modal_theme_primary">Edit
                                        </button>
                                        <!--									&nbsp;
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['line_id']; ?>">Delete </button>
                                                    -->
                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                </form>
            </div>
            <!-- /basic datatable -->
            <!-- /main charts -->
            <!-- edit modal -->
            <div id="edit_modal_theme_primary" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">Edit Event Category</h6>
                        </div>
                        <form action="" id="user_form" class="form-horizontal" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label" style="color: #f1f2f3;" >Event Category:*</label>
                                            <div class="col-lg-5">
                                                <input type="text" name="edit_events_cat_name" id="edit_events_cat_name"
                                                       class="form-control" required>
                                                <input type="hidden" name="edit_id" id="edit_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label" style="color: #f1f2f3;">Is reason required ? *</label>
                                            <div class="col-lg-5">
                                            <div class="form-check form-check-inline form_col_option">
                                                <input type="radio" id="edit_yes" name="edit_reason" value="yes">
                                                <label for="yes" class="item_label" id="" style="color: #f1f2f3;">Yes</label>
                                                <input type="radio" id="edit_no" name="edit_reason" value="no" checked="checked">
                                                <label for="no" class="item_label" id="" style="color: #f1f2f3;">No</label>
                                            </div>
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
            </div>
            <!-- Dashboard content -->
            <!-- /dashboard content -->
            			<script> $(document).on('click', '#delete', function () {
                                var element = $(this);
                                var del_id = element.attr("data-id");
                                var info = 'id=' + del_id;
                                $.ajax({type: "POST", url: "ajax__delete.php", data: info, success: function (data) { }});
                                $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                            });</script>
            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '#edit', function () {
                        var element = $(this);
                        var edit_id = element.attr("data-id");
                        var events_cat_name = $(this).data("events_cat_name");
                        var edit_reason = $(this).data("reason");
                        if(edit_reason == 'no'){
                            document.getElementById("edit_no").checked = true;
                        }else{
                            document.getElementById("edit_yes").checked = true;
                        }
                        $("#edit_events_cat_name").val(events_cat_name);
                        $("#edit_id").val(edit_id);
                    });
                });
            </script>

            <script>
                window.onload = function () {
                    history.replaceState("", "", "<?php echo $scriptName; ?>config_module/event_category.php");
                }
            </script>

            <script>
                $("#checkAll").click(function () {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                });
            </script>
        </div>
        <!-- /content area -->

    <!-- /main content -->

<!-- /page container -->
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
