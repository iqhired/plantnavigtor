<?php
include("../config.php");
$temp = "";
$chicagotime = date("Y-m-d H:i:s");
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

if (count($_POST) > 0) {
	$name = $_POST['position_name'];
	$description = $_POST['description'];
//create
	if ($name != "") {
		$position_name = $_POST['position_name'];
		$line_name = $_POST['line_name'];
		$query01 = sprintf("SELECT * FROM `cam_station_pos_rel` WHERE `position_id` = '$position_name' AND `line_id` = '$line_name'; ");
		$qur01 = mysqli_query($db, $query01);
		$rowc01 = mysqli_fetch_array($qur01);
		$po_1 = $rowc01["position_id"];
		$li_1 = $rowc01["line_id"];
		if ($po_1 == $position_name && $li_1 == $line_name) {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Data Relation already Exist...';
		} else {
			$cc = $_POST['cc'];
			$to = $_POST['to'];
			$message = $_POST['message'];
			$ratings = $_POST['ratings'];
			$signature = $_POST['signature'];
			$priority_order = $_POST['priority_order'];
//mysqli_query($db, "INSERT INTO `data`(`position_name`,`line_name`,`email_from`,`email_to`,`email_msg`,`ratings`) VALUES ('$position_name','$line_name' ,'$from','$to','$message','$ratings' )");
			$sql0 = "INSERT INTO `cam_station_pos_rel`(`position_id`,`line_id`,`priority_order`,`email_cc`,`email_to`,`email_signature`,`email_msg`,`ratings`,`assigned`,`created_at`) VALUES ('$position_name','$line_name','$priority_order' ,'$cc','$to','$signature','$message','$ratings','0','$chicagotime' )";
			$result0 = mysqli_query($db, $sql0);
			if ($result0) {
				$message_stauts_class = 'alert-success';
				$import_status_message = 'Station Position Relation Created successfully.';
			} else {
				$message_stauts_class = 'alert-danger';
				$import_status_message = 'Error: Please Insert valid data';
			}
		}
	}
//edit
	$edit_name = $_POST['edit_position_name'];
	if ($edit_name != "") {
		$id = $_POST['edit_id'];
		$sql00 = "update cam_station_pos_rel set email_signature='$_POST[edit_signature]',priority_order='$_POST[edit_priority_order]', position_id='$_POST[edit_position_name]',line_id='$_POST[edit_line_name]' , email_cc='$_POST[edit_cc]' , email_to='$_POST[edit_to]', email_msg='$_POST[edit_message]', ratings='$_POST[edit_ratings]' where station_pos_rel_id='$id'";
		$result1 = mysqli_query($db, $sql00);
		if ($result1 != "") {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Station Position Relation Updated successfully.';
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
    <title><?php echo $sitename; ?> | Station Position Configuration</title>
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
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <style>
        .datatable-scroll {
            width: 100%;
            overflow-x: scroll;
        }
        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px)  {
            .col-md-9 {
                width: 70%;
                float: right;
            }
        }
    </style>
</head>

<!-- Main navbar -->
<?php $cust_cam_page_header = "Station Position Configuration";
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
				<?php
				if (!empty($import_status_message)) {
					echo '<div class="panel panel-flat"><div class="panel-heading"><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>
 						</div>
						</div> ';
				}
				?>
				<?php
				if (!empty($_SESSION['import_status_message'])) {
					echo '
<div class="panel panel-flat">
						<div class="panel-heading">
							<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>
						</div>
						</div>';
					$_SESSION['message_stauts_class'] = '';
					$_SESSION['import_status_message'] = '';
				}
				?>
                <form action="delete_station_pos_rel.php" method="post" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-3" style="float: left;">
                            <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Delete
                            </button>
                        </div>
                        <div class="col-md-9" style="text-align: right;">
                            <button type="button" data-toggle="modal" class="btn btn-primary"
                                    style="background-color:#1e73be;" data-target="#modal_theme_primary1">Create Station
                                Position Relation
                            </button>
                        </div>
                    </div>
                    <br/>
                    <div class="panel panel-flat">
                        <table class="table datatable-basic">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>Sl. No</th>
                                <th>Position</th>
                                <th>Station</th>
                                <th>Priority Order</th>
                                <th>Required Rating</th>
                                <th>Email Configuration</th>
                                <!--                                      <th>Created At</th>-->
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  cam_station_pos_rel where is_deleted!='1'");
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]"
                                               value="<?php echo $rowc["station_pos_rel_id"]; ?>"></td>
                                    <td><?php echo ++$counter; ?></td>
									<?php
									$position1 = $rowc['position_id'];
									$qurtemp1 = mysqli_query($db, "SELECT * FROM  cam_position where position_id = '$position1' ");
									while ($rowctemp1 = mysqli_fetch_array($qurtemp1)) {
										$position = $rowctemp1["position_name"];
									}
									?>
                                    <td><?php echo $position; ?></td>
									<?php
									$station1 = $rowc['line_id'];
									$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station1' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
										$station = $rowctemp["line_name"];
									}
									?>
                                    <td><?php echo $station; ?></td>
                                    <td><?php echo $rowc['priority_order']; ?></td>
                                    <td><?php echo $rowc['ratings']; ?></td>
									<?php
									$configuration = $rowc['email_to'];
									if ($configuration != "") {
										$answer = "<span class='label label-block label-success'>Configured</span>";
									} else {
										$answer = "<span class='label label-block label-danger'>Pending</span>";
									}
									?>
                                    <td><?php echo $answer; ?></td>
                                    <!--
									   <td>--><?php //echo $rowc['created_at'];?><!--</td>-->
                                    <td>
                                        <button type="button" id="edit" class="btn btn-info btn-xs"
                                                data-signature="<?php echo $rowc['email_signature']; ?>"
                                                data-priority_order="<?php echo $rowc['priority_order']; ?>"
                                                data-cc="<?php echo $rowc['email_cc']; ?>"
                                                data-to="<?php echo $rowc['email_to']; ?>"
                                                data-message="<?php echo $rowc['email_msg']; ?>"
                                                data-ratings="<?php echo $rowc['ratings']; ?>"
                                                data-id="<?php echo $rowc['station_pos_rel_id']; ?>"
                                                data-name="<?php echo $rowc['position_id']; ?>"
                                                data-line="<?php echo $rowc['line_id']; ?>" data-toggle="modal"
                                                style="background-color:#1e73be;"
                                                data-target="#edit_modal_theme_primary">Edit
                                        </button>
                                        <!--									&nbsp;
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['station_pos_rel_id']; ?>">Delete </button>
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
            <div id="modal_theme_primary1" class="modal ">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">Configure Station Position Relation</h6>
                        </div>
                        <form action="" id="user_form" class="form-horizontal" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Station : </label>
                                            <div class="col-lg-7">
                                                <select name="line_name" id="line_name" class="select form-control">
                                                    <option value="" selected disabled>--- Select Station ---</option>
													<?php
													$sql1 = "SELECT * FROM `cam_line` where enabled = 1 order by line_name";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['line_id'] . "'$entry>" . $row1['line_name'] . "</option>";
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
                                            <label class="col-lg-3 control-label">Position : </label>
                                            <div class="col-lg-7">
                                                <select name="position_name" id="position_name" class="select form-control">
                                                    <option value="" selected disabled>--- Select Position ---</option>
													<?php
													$sql1 = "SELECT * FROM `cam_position`";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['position_id'] . "'$entry>" . $row1['position_name'] . "</option>";
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
                                            <label class="col-lg-3 control-label">Priority Order : </label>
                                            <div class="col-lg-7">
                                                <input type="text" name="priority_order" id="priority_order" value="any"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Required Rating : </label>
                                            <div class="col-lg-7">
                                                <select name="ratings" id="ratings" class="select form-control">
                                                    <option value="" selected disabled>--- Select Rating ---</option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Email To : </label>
                                            <div class="col-lg-7">
                                                <input type="email" name="to" id="to" class="form-control" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Email CC : </label>
                                            <div class="col-lg-7">
                                                <input type="email" name="cc" id="cc" class="form-control" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Message : </label>
                                            <div class="col-lg-7">
                                                <textarea id="message" name="message" rows="4"
                                                          class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Signature : </label>
                                            <div class="col-lg-7">
                                                <textarea id="signature" name="signature" rows="2"
                                                          class="form-control"></textarea>
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
            <!-- edit modal -->
            <div id="edit_modal_theme_primary" class="modal ">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">Update Station Position Relation</h6>
                        </div>
                        <form action="" id="user_form" class="form-horizontal" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Station : </label>
                                            <div class="col-lg-7">
                                                <select name="edit_line_name" id="edit_line_name" class="select form-control">
                                                    <option value="" disabled>--- Select Station ---</option>
													<?php
													$sql1 = "SELECT * FROM `cam_line` where enabled = '1'";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['line_id'] . "'$entry>" . $row1['line_name'] . "</option>";
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
                                            <label class="col-lg-3 control-label">Position : </label>
                                            <div class="col-lg-7">
                                                <select name="edit_position_name" id="edit_position_name"
                                                        class="select form-control">
                                                    <option value="" disabled>--- Select Position ---</option>
													<?php
													$sql1 = "SELECT * FROM `cam_position`";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['position_id'] . "'$entry>" . $row1['position_name'] . "</option>";
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
                                            <label class="col-lg-3 control-label">Priority Order: </label>
                                            <div class="col-lg-7">
                                                <input type="text" name="edit_priority_order" id="edit_priority_order"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Required Rating : </label>
                                            <div class="col-lg-7">
                                                <select name="edit_ratings" id="edit_ratings" class="select form-control">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Email To : </label>
                                            <div class="col-lg-7">
                                                <input type="email" name="edit_to" id="edit_to" class="form-control"
                                                       multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Email CC: </label>
                                            <div class="col-lg-7">
                                                <input type="email" name="edit_cc" id="edit_cc" class="form-control"
                                                       multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Message : </label>
                                            <div class="col-lg-7">
                                                <textarea id="edit_message" name="edit_message" class="form-control"
                                                          rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Email Signature : </label>
                                            <div class="col-lg-7">
                                                <textarea id="edit_signature" name="edit_signature" class="form-control"
                                                          rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="edit_id" id="edit_id">
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
                    $.ajax(
                        {
                            type: "POST",
                            url: "ajax_data_delete.php",
                            data: info,
                            success: function (data) {
                            }
                        });
                    $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                });
            </script>
            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '#edit', function () {
                        var element = $(this);
                        var edit_id = element.attr("data-id");
                        var name = $(this).data("name");
                        var line = $(this).data("line");
                        var cc = $(this).data("cc");
                        var to = $(this).data("to");
                        var message = $(this).data("message");
                        var ratings = $(this).data("ratings");
                        var priority_order = $(this).data("priority_order");
                        var signature = $(this).data("signature");
                        $("#edit_position_name").val(name);
                        $("#edit_line_name").val(line);
                        $("#edit_id").val(edit_id);
                        $("#edit_cc").val(cc);
                        $("#edit_to").val(to);
                        $("#edit_message").val(message);
                        $("#edit_ratings").val(ratings);
                        $("#edit_signature").val(signature);
                        $("#edit_priority_order").val(priority_order);

                        // Load Taskboard
                        const sb1 = document.querySelector('#edit_ratings');
                        var options1 = sb1.options;
                        $('#edit_modal_theme_primary .select2 .selection select2-selection select2-selection--single .select2-selection__choice').remove();
                        for (var i = 0; i < options1.length; i++) {
                            if(ratings == (options1[i].value)){ // EDITED THIS LINE
                                options1[i].selected="selected";
                                options1[i].className = ("select2-results__option--highlighted");
                                var opt = options1[i].outerHTML.split(">");
                                $('#select2-results .select2-results__option').prop('selectedIndex',i);
                                var gg = '<span class="select2-selection__rendered" id="select2-edit_ratings-container" title="' + opt[1].replace('</option','') + '">' + opt[1].replace('</option','') + '</span>';
                                $("#select2-edit_ratings-container")[0].outerHTML = gg;
                            }
                        }
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
        history.replaceState("", "", "<?php echo $scriptName; ?>config_module/station_pos_rel.php");
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
