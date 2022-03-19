<?php
include("../config.php");
$import_status_message = "";
//include("../sup_config.php");
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

//$sql = "select stations from `sg_cust_dashboard`";
//$result1 = mysqli_query($db, $sql);
//$line_array = array();
//while ($rowc = mysqli_fetch_array($result1)) {
//	$arr_stations = explode(',', $rowc['stations']);
//	foreach ($arr_stations as $station){
//		if(isset($station) && $station != ''){
//			array_push($line_array , $station);
//		}
//	}
//}
if (count($_POST) > 0) {
	//edit
	$edit_name = $_POST['edit_cell_name'];
	//$edit_file = $_FILES['edit_logo_image']['name'];
	if ($edit_name != "") {

		$id = $_POST['edit_id'];
		$stations = $_POST["edit_cell_stations"];
		//$account = (isset($_POST['edit_cell_account']))?$_POST['edit_cell_account']:NULL;
		foreach ($stations as $station) {
			$array_stations .= $station . ",";
		}
//eidt logo
		$sql = "update `sg_cust_dashboard` set sg_cust_dash_name = '$edit_name',  stations = '$array_stations', enabled = '$_POST[edit_enabled]'  where sg_cust_group_id='$id'";
		$result1 = mysqli_query($db, $sql);
		if ($result1) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Dashboard Updated Successfully.';
//			$sql = "select stations from `sg_cust_dashboard`";
//			$result1 = mysqli_query($db, $sql);
//			$line_array = array();
//			while ($rowc = mysqli_fetch_array($result1)) {
//				$arr_stations = explode(',', $rowc['stations']);
//				foreach ($arr_stations as $station){
//					if(isset($station) && $station != ''){
//						array_push($line_array , $station);
//					}
//				}
//			}
		} else {
			$message_stauts_class = 'alert-danger';
			if($import_status_message == "")
			{
				$import_status_message = 'Error: Please Try Again.';
			}
		}

	}else{
		$cell_name = $_POST['c_grp_name'];
//create
		if (isset($cell_name)) {
			$enabled = $_POST['enabled'];
			$stations = $_POST['stations'];
			foreach ($stations as $station) {
				$array_stations .= $station . ",";
			}
		}
		$sql = "INSERT INTO `sg_cust_dashboard`(`sg_cust_dash_name`,  `stations`, `enabled`, `created_at`) VALUES('$cell_name','$array_stations','$enabled','$chicagotime')";
		$result1 = mysqli_query($db, $sql);
		if (!$result1) {
			$message_stauts_class = 'alert-danger';
			if($import_status_message == "")
			{
				$import_status_message = 'Error: Dashboard Already Exists';
			}
		} else {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Dashboard Created Successfully';
//			$sql = "select stations from `sg_cust_dashboard`";
//			$result1 = mysqli_query($db, $sql);
//			$line_array = array();
//			while ($rowc = mysqli_fetch_array($result1)) {
//				$arr_stations = explode(',', $rowc['stations']);
//				foreach ($arr_stations as $station){
//					if(isset($station) && $station != ''){
//						array_push($line_array , $station);
//					}
//				}
//			}
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
	<title><?php echo $sitename; ?> | Custom Dashboard Configuration</title>
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
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
	<style>
		select option[disabled] {
			display: none;
		}

		@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
			.col-lg-8 {
				float: right;
				width: 60% !important;
			}
			.col-lg-7 {
				float: right;
				width: 60% !important;
			}
			.col-lg-6 {
				float: right;
				width: 60% !important;
			}


			label.col-lg-4.control-label {
				width: 40%;
			}
			label.col-lg-5.control-label {
				width: 40%;
			}

		}
        .panel.panel-flat {
            background-color: white;
            margin-top: 15px;
        }
	</style>
</head>

<!-- Main navbar -->
<?php $cam_page_header = "Dashboard Configuration";
include("../header.php");
include("../admin_menu.php");
//include("../tab_menu.php");
?>
<body>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
	<!-- Page content -->

	<!-- Content area -->
	<div class="content">
		<!-- Basic datatable -->
		<div class="panel panel-flat">
			<form action="" id="cell_grp_form" class="form-horizontal" method="post" enctype="multipart/form-data">
				<div class="panel-heading">

					<div class="row">
						<!-- Customer Name -->
						<div class="col-md-6 mobile">
							<div class="form-group">
								<label class="col-lg-4 control-label">Dashboard Name * : </label>
								<div class="col-lg-8">
									<input type="text" name="c_grp_name" id="c_grp_name" class="form-control"
										   placeholder="Enter Cell Group Name" required>
									<div id="error6" class="red">
									</div>
								</div>
							</div>
						</div>
                        <!-- Enabled -->
                        <div class="col-md-6 mobile">
                            <div class="form-group">
                                <!--										<div class="col-lg-8 mobile">-->
                                <label class="col-lg-4 control-label">Enabled: </label>
                                <div class="col-lg-8">

                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="yes" name="enabled" value="1" class="form-check-input" checked>
                                        <label for="yes" class="item_label">Yes</label>
                                        <input type="radio" id="no" name="enabled" value="0" class="form-check-input" >
                                        <label for="no" class="item_label">No</label>

                                    </div>
                                    <!--										</div>-->
                                </div>
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-8 mobile" style="margin-top: 15px;">
							<div class="form-group">
								<label class="col-lg-4 control-label mobile">Select Stations * : </label>

								<div class="col-lg-6" style="margin-left: -66px;">
									<select required class="select-border-color" data-placeholder="Add Stations..."  name="stations[]" id="stations" multiple="multiple"  >
										<?php
										//$assigned_stations = implode("', '", $line_array);
										$sql1 = "SELECT `line_id`, `line_name` FROM `cam_line` where enabled = 1 order by line_name ASC";
										//												$sql1 = "SELECT `line_id`, `line_name` FROM `cam_line` where enabled = 1 order by line_name ASC";
										$result1 = $mysqli->query($sql1);
										while ($row1 = $result1->fetch_assoc()) {
											echo "<option id='" . $row1['line_id'] . "'  value='" . $row1['line_id'] . "' $selected>" . $row1['line_name'] . "</option>";
										}
										?>

									</select>
								</div>

								<div>
									<button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group1()">Add More</button>
								</div>
							</div>
						</div>
						<?php
						if (!empty($import_status_message)) {
							echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
						}
						?>
						<?php
						if (!empty($_SESSION[import_status_message])) {
							echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
							$_SESSION['message_stauts_class'] = '';
							$_SESSION['import_status_message'] = '';
						}
						?>
					</div>
					<div class="panel-footer p_footer">
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Add</button>
						</div>
					</div>
				</div>
			</form>
		</div>

		<form action="" id="update-form" method="post" class="form-horizontal">
			<div class="row">
				<div class="col-md-3">
					<button type="button" class="btn btn-primary" onclick="submitForm('delete_dash.php')"
							style="background-color:#1e73be;">Delete
					</button>
					<!-- <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button> -->
				</div>
			</div>

			<!-- Basic datatable -->
			<div class="panel panel-flat">
				<table class="table datatable-basic">
					<thead>
					<tr>
						<th>
							<input type="checkbox" id="checkAll">
						</th>
						<th>S.No</th>
						<th>Dashboard Name</th>
						<th>Stations</th>
						<th>Dashboard Status</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$query = sprintf("SELECT * FROM sg_cust_dashboard ;  ");
					$qur = mysqli_query($db, $query);

					while ($rowc = mysqli_fetch_array($qur)) {
						$c_id = $rowc["sg_cust_group_id"];
//						$cust_id = $rowc["account_id"];
						?>
						<tr>
							<td><input type="checkbox" id="delete_check[]" name="delete_check[]"
									   value="<?php echo $c_id; ?>"></td>
							<td><?php echo ++$counter; ?>
							</td>
							<td><?php echo $rowc["sg_cust_dash_name"]; ?>
							</td>
							<?php
							$enabled = $rowc['enabled'];
							$c_status = "Active";
							if($enabled == 0){
								$c_status = "Inactive";
							}
							?>
							<td>
								<?php
								$stations = $rowc['stations'];
								$arr_stations = explode(',', $stations);

								// glue them together with ', '
								$stationStr = implode("', '", $arr_stations);
								$sql = "SELECT line_name FROM `cam_line` WHERE line_id IN ('$stationStr')";
								$result1 = mysqli_query($db, $sql);
								$line = '';
								$i = 0;
								while ($row =  $result1->fetch_assoc()) {
									if($i == 0){
										$line = $row['line_name'];
									}else{
										$line .= " , " . $row['line_name'];
									}
									$i++;
								}
								echo $line;
								?>
							</td>
							<td><?php echo $c_status; ?>
							</td>
							<td>
								<button type="button" id="edit" class="btn btn-info btn-xs"
										data-id="<?php echo $rowc['sg_cust_group_id']; ?>"
										data-cell_name="<?php echo $rowc['sg_cust_dash_name']; ?>"
										data-cell_enabled="<?php echo $rowc['enabled']; ?>"
										data-cell_stations="<?php echo $stations; ?>"
										data-assigned_line="<?php echo implode(",", $line_array); ?>"
										data-toggle="modal" style="background-color:#1e73be;"
										data-target="#edit_modal_theme_primary">Edit
								</button>
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
						<h6 class="modal-title">
							Update Cell
						</h6>
					</div>
					<form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal"
						  method="post">
						<div class="modal-body" style="color: #fff5f5;">
							<!--Part Number-->
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-lg-4 control-label">Dashboard Name * : </label>
										<div class="col-lg-8">
                                            <?php $edit_id = $_GET['data-id']; ?>

											<input type="text" name="edit_cell_name" id="edit_cell_name"
												   class="form-control" required>
											<input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>">
										</div>
									</div>
								</div>
							</div>
							<!--Station-->
							<div class="row">

								<div class="col-md-12">
									<div class="form-group">
										<label class="col-lg-4 control-label">Stations : *</label>
										<div class="col-lg-8">
											<?php
                                            $query = sprintf("SELECT * FROM sg_cust_dashboard ;  ");
											$qur = mysqli_query($db, $query);
											$rowc = mysqli_fetch_array($qur);
											?>
											<select required name="edit_cell_stations[]" id="edit_cell_stations"  class="select-border-color form-control"
													multiple="multiple">
												<!--                                                        <select name="edit_part_number[]" id="edit_part_number" class="form-control" multiple>-->
												<?php
												$arrteam = explode(',', $rowc["stations"]);
												$sql1 = "SELECT `line_id`, `line_name` FROM `cam_line` where enabled = 1  order by line_name ASC";

												//$sql1 = "SELECT line_id , line_name FROM `cam_line` where enabled = 1 and line_id NOT in ('$assigned_stations') order by line_name ASC";
												$result1 = $mysqli->query($sql1);
												while ($row1 = $result1->fetch_assoc()) {
													if (in_array($row1['line_id'], $arrteam)) {
														$selected = "selected";
//															echo "<option id='" . $row1['line_id'] . "'  value='" . $row1['line_id'] . "' $selected>" . $row1['line_name'] . "</option>";
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
										<label class="col-lg-4 control-label">Enabled : </label>

										<div class="col-lg-8">
											<select name="edit_enabled" id="edit_enabled" class="form-control"
													style="float: left;
                                                             width: initial;">
												<!--        <option value="" selected disabled>--- Select Ratings ---</option>-->
												<option value="1">Yes</option>
												<option value="0">No</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</div>
				</div>

				</form>
			</div>
		</div>

		<!-- /dashboard content -->

	</div>
	<!-- /content area -->

</div>
<script>
    $(document).on('click', '#edit', function () {
        var element = $(this);
        var edit_id = $(this).data("id");
        var cell_name = $(this).data("cell_name");
        var cell_enabled = $(this).data("cell_enabled");
        var assigned_line = $(this).data("assigned_line");
        var cell_stations = $(this).data("cell_stations");
        $("#edit_name").val(name);
        $("#edit_cell_name").val(cell_name);
        $("#edit_cs").val(cell_stations);
        // $("#edit_cell_account").val(cell_account_id);
        $("#edit_cell_stations").val(cell_stations);
        $("#edit_enabled").val(cell_enabled);
        // $("#editlogo").attr("src","../supplier_logo/"+cell_logo);
        $("#edit_id").val(edit_id);

        var assLineArr = assigned_line.split(',');

        // const sb = document.querySelector('#cell_stations');
        var sb1 = document.querySelector('#edit_cell_stations');
        // create a new option
        var stations = cell_stations.split(',');
        var options = [];
        var options1 = sb1.options;
        var nasslinearr = [];
        // $("#edit_part_number").val(options);
        $('#edit_modal_theme_primary .select2 .selection .select2-selection--multiple .select2-selection__choice').remove();
        var j = assigned_line.length;

        for (var i = 0; i < options1.length; i++) {
            if(stations.includes(options1[i].value)){ // EDITED THIS LINE
                options1[i].selected="selected";
                options1[i].className = ("select2-results__option--highlighted");
                var opt = document.getElementById(options1[i].value).outerHTML.split(">");
                // $('#edit_cell_stations').prop('selectedIndex',i);
                $('#select2-results .select2-results__option').prop('selectedIndex',i);
                var gg = '<li class="select2-selection__choice" title="' + opt[1].replace('</option','') + '"><span class="select2-selection__choice__remove" role="presentation">×</span>' + opt[1].replace('</option','') + '</li>';
                $('#edit_modal_theme_primary .select2-selection__rendered').append(gg);
                options[j]= options1[i];
                j++;
                nasslinearr [j] = options1[i].value;
                // $('.select2-search__field').style.visibility='hidden';
            }else if(assLineArr.includes(options1[i].value)){
                document.getElementById(options1[i].value).remove();
                i--;
            }

        }
    });
    $(".select").select2();
</script>

<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>config_module/create_cust_dashboard.php");
    }
</script>
<script>
    function submitForm(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js">
    </body>
    </html>
