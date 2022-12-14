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
	$wol = $_POST['enabled'];
//create
	if ($name != "") {
	    $n_wol = 1;
		if(empty($wol) || $wol == 'no'){
			$n_wol = 0;
        }
		$sqlquery = "INSERT INTO `document_type`(`document_type_name`,`enabled`,`created_at`,`updated_at`) VALUES ('$name','$n_wol','$chicagotime','$chicagotime')";
        $result = mysqli_query($db, $sqlquery);
        if ($result) {
            $temp = "one";

		} else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Document Type with this Name Already Exists';
		}
	}
//edit
	$edit_name = $_POST['edit_name'];
	$edit_wol = $_POST['edit_enabled'];
	$wol = 1;
	if($edit_wol == 'no'){
	    $wol = 0;
    }
	if ($edit_name != "") {
		$id = $_POST['edit_id'];
		$sql = "update document_type set document_type_name='$edit_name',enabled = '$wol',updated_at='$chicagotime' where document_type_id ='$id'";
		$result1 = mysqli_query($db, $sql);
		if ($result1) {
			$temp = "two";
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Form Type with this Name Already Exists';
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
    <title><?php echo $sitename; ?> | Document Type</title>
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

        .col-md-2 {
            margin-top: 60px;
        }
        .col-md-5 {
            width: 55%;
            float: left;
        }
        .col-md-4 {
            float: left;
            width: 50%;
        }
        .col-md-8 {
            width: 100%;
            float: right;
        }
    }
    @media (min-width: 769px), (min-device-width: 820px) and (max-device-width: 1180px)
        .form-horizontal .control-label:not(.text-right) {
            text-align: left;
            width: 40%;
        }
        .col-lg-6 {
            width: 50%;
            float: right;
        }
</style>

<!-- Main navbar -->
<?php $cust_cam_page_header = "Document Category";
//include("../header_folder.php");
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
                <!-- Main charts -->
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">

                        <div class="row">
                                    <form action="" id="user_form" class="form-horizontal" method="post">
                                <div class="col-md-12">
                                        <div class="col-md-4">
                                            <input type="text" name="name" id="name" class="form-control"
                                                   placeholder="Enter Document Type" required>
                                        </div>
                                        <div class="col-md-8">
                                        <div class="col-md-5">
                                            <label class="control-label" style=" padding: 15px 10px;">Enabled / Disabled : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-inline form_col_option">
                                                <input type="radio" id="yes" name="enabled" value="yes">
                                                <label for="yes" class="item_label" id="">Yes</label>
                                                <input type="radio" id="no" name="enabled" value="no" checked="checked">
                                                <label for="no" class="item_label" id="">No</label>
                                            </div>

                                        </div>
                                        </div>

                                </div>
                                    <div class="row">
                                        <div class="col-md-2" style="width: 100%;padding-top: 20px;">
                                            <button type="submit" class="btn btn-primary"
                                                    style="background-color:#1e73be;">Create Document Type
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <br/>
					<?php if ($temp == "one") { ?>
                        <div class="alert alert-success no-border">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                        class="sr-only">Close</span></button>
                            <span class="text-semibold">Document Type</span> Created Successfully.
                        </div>
					<?php } ?>
					<?php if ($temp == "two") { ?>
                        <div class="alert alert-success no-border">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                        class="sr-only">Close</span></button>
                            <span class="text-semibold">Document Type</span> Updated Successfully.
                        </div>
					<?php } ?>
					<?php
					if (!empty($import_status_message)) {
						echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
					}
					?>
					<?php
                    if (!empty($_SESSION['import_status_message'])) {
						echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
						$_SESSION['message_stauts_class'] = '';
						$_SESSION['import_status_message'] = '';
					}
					?>

                <form action="delete_document_category.php" method="post" class="form-horizontal">
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
                                <th>Form Type</th>
                                <th>Is Work Order/Lot required ?</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  document_type where is_deleted != '1'");
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]"
                                               value="<?php echo $rowc["document_type_id"]; ?>"></td>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php echo $rowc["document_type_name"]; ?></td>
                                    <td><?php if($rowc["enabled"] == 0){ echo 'No' ;}else{ echo 'Yes' ;}?></td>
                                    <!--                                         <td>-->
									<?php //echo $rowc['created_at']; ?><!--</td>-->
                                    <!--                                        <td>-->
									<?php //echo $rowc['updated_at']; ?><!--</td>-->
                                    <td>
                                        <button type="button" id="edit" class="btn btn-info btn-xs"
                                                data-id="<?php echo $rowc['document_type_id']; ?>"
                                                data-name="<?php echo $rowc['document_type_name']; ?>"
                                                data-enabled="<?php if($rowc["enabled"] == 0){ echo 'no' ;}else{ echo 'yes' ;} ?>"
                                                data-toggle="modal"
                                                style="background-color:#1e73be;"
                                                data-target="#edit_modal_theme_primary">
                                            Edit
                                        </button>
                                        <!--									&nbsp;
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['job_title_id']; ?>">Delete </button>
                                                    -->
                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>

            <!-- edit modal -->
            <div id="edit_modal_theme_primary" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">Update Form Type</h6>
                        </div>
                        <form action="" id="user_form" class="form-horizontal" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Form Type:*</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_name" id="edit_name" class="form-control"
                                                       required>
                                                <input type="hidden" name="edit_id" id="edit_id">
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Enabled/Disabled:*</label>
                                            <div class="col-lg-6">

                                                    <input type="radio" id="edit_yes" name="edit_enabled" value="yes" >
                                                    <label for="yes" class="item_label" id="">Yes</label>
                                                    <input type="radio" id="edit_no" name="edit_enabled" value="no">
                                                    <label for="no" class="item_label" id="">No</label>
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

            <script> $(document).on('click', '#delete', function () {
                    var element = $(this);
                    var del_id = element.attr("data-id");
                    var info = 'id=' + del_id;
                    $.ajax({
                        type: "POST", url: "ajax_job_title_delete.php", data: info, success: function (data) {
                        }
                    });
                    $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                });</script>
            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '#edit', function () {
                        var element = $(this);
                        var edit_id = element.attr("data-id");
                        var name = $(this).data("name");
                        var enabled = $(this).data("enabled");
                        $("#edit_name").val(name);
                        if(enabled == 'no'){
                            document.getElementById("edit_no").checked = true;
                        }else{
                            document.getElementById("edit_yes").checked = true;
                        }
                        // $("#edit_wol").val(wol);
                        $("#edit_id").val(edit_id);
                        //alert(role);
                    });
                });
            </script>
        </div>
        <!-- /content area -->


</div>
<!-- /page container -->

<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>document_module/document_category.php");
    }
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
