<?php
include("../config.php");
$temp = "";
$message_stauts_class = 'alert-danger';
$import_status_message = 'Error: Assignment Position Relation does not exist';
$assign_line = $_GET['line'];
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
}
if (count($_POST) > 0) {
//assign crew delete
	$jm = $_POST['assign_line'];
	if ($jm != "") {
		$assign_line = $jm;
	}
	$delete_check = $_POST['delete_check'];
	$delete_user = $_POST['delete_user'];
	$transaction = $_POST['transaction'];
	$delete_position = $_POST['delete_position'];
	$delete_station = $_POST['delete_station'];
	if ($delete_check != "") {
		$cnt = count($delete_check);
		for ($i = 0; $i < $cnt;) {
			$query0001 = sprintf("SELECT * FROM  cam_assign_crew WHERE `assign_crew_id`='$delete_check[$i]' ");
			$qur0001 = mysqli_query($db, $query0001);
			$rowc0001 = mysqli_fetch_array($qur0001);
			$posname = $rowc0001["position_name"];
			$linename = $rowc0001["line_name"];
			$username = $rowc0001["user_name"];
			$assigncrewtransactionid = $rowc0001["assign_crew_transaction_id"];
			$sql1 = "DELETE FROM `cam_assign_crew` WHERE `assign_crew_id`='$delete_check[$i]'";
			if (!mysqli_query($db, $sql1)) {
				echo "Invalid Data";
			} else {

			}
			$sql = "update cam_users set assigned ='0' where user_name='$username'";
			$result1 = mysqli_query($db, $sql);
			$sqltra = "update cam_assign_crew_log set status ='0' where assign_crew_transaction_id='$assigncrewtransactionid'";
			$resulttra = mysqli_query($db, $sqltra);
			$sql5 = "update cam_station_pos_rel set assigned ='0' where line_name='$linename' and position_name='$posname'";
			$result5 = mysqli_query($db, $sql5);
			$i++;
		}
		$_SESSION['message_stauts_class'] = 'alert-success';
		$_SESSION['import_status_message'] = 'Crew Unassigned Sucessfully.';
		$assign_line = $_POST['assignline'];
	}
}
$ps = $_SESSION['aasignline'];
if ($ps != "") {
	$assign_line = $ps;
	$_SESSION['aasignline'] = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $sitename; ?> | Assign crew</title>
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
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../assets/js/core/app.js"></script>
	<script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
</head>
<body>
<!-- Main navbar -->
<?php
$cam_page_header = "Assign Unassign Crew Members";
include("../header_folder.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
	<!-- Page content -->
	<div class="page-content">
		<!-- Main navigation -->
		<?php include("../admin_menu.php"); ?>
		<!-- /main navigation -->
		<!-- Main content -->
		<div class="content-wrapper">
			<div class="content">
				<!-- Main charts -->
				<!-- Basic datatable -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Select Station</h5>
						<hr/>
						<?php
						if (!empty($_SESSION[import_status_message])) {
							echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
							$_SESSION['message_stauts_class'] = '';
							$_SESSION['import_status_message'] = '';
						}
						?>
						<form action="" method="post"  class="form-horizontal">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<!--											<label class="col-lg-3 control-label">Line Name:</label>-->
										<div class="col-lg-6">
											<select name="assign_line" id="assign_line" class="select" data-style="bg-slate" >
												<option value="" selected disabled>--- Select Station ---</option>
												<?php
												$sql1 = "SELECT * FROM `cam_line` where enabled = '1'";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													$lin = $row1['line_id'];
													if ($lin == $assign_line) {
														$entry = 'selected';
													} else {
														$entry = '';
													}
													echo "<option value='" . $row1['line_id'] . "' $entry >" . $row1['line_name'] . "</option>";
												}
												?>
											</select>
										</div>
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</div>
						</form>
						<br/>
					</div>
				</div>
				<?php
				if ($assign_line != "") {
					$qur04 = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$assign_line' ");
					$rowc04 = mysqli_fetch_array($qur04);
					$lnname = $rowc04["line_name"];
					$cnt = 1;
					?>
					<div class="panel panel-heading">
						<form action="" method="post" id="update-form" class="form-horizontal">
							<h5 class="panel-title">Select Crew for <?php echo $lnname; ?> - Positions</h5><br/>
							<input type="checkbox" id="checkAll" > Select All to Unassign &nbsp;
							<hr/>
							<?php
							$query = sprintf("SELECT * FROM  cam_station_pos_rel where line_id = '$assign_line' ; ");
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								$message_stauts_class = '';
								$import_status_message = '';
								?>
								<div class="row">
									<div class="col-md-9">
										<div class="form-group">
											<?php
											$asign = $rowc["assigned"];
											if ($asign == "1") {
												?>
												<?php
												$query001 = sprintf("SELECT * FROM  cam_assign_crew where line_id = '$assign_line' and position_id = '$rowc[position_id]' and resource_type = 'regular' ; ");
												$qur001 = mysqli_query($db, $query001);
												$rowc001 = mysqli_fetch_array($qur001);
												$usrr = $rowc001["user_id"];
												$transidd = $rowc001["assign_crew_transaction_id"];
												$asigncrewid = $rowc001["assign_crew_id"];
												$res_type = $rowc001["resource_type"];
												$query002 = sprintf("SELECT * FROM  cam_users where users_id = '$usrr'; ");
												$qur002 = mysqli_query($db, $query002);
												while ($rowc002 = mysqli_fetch_array($qur002)) {
													$firstname = $rowc002["firstname"];
													$lastname = $rowc002["lastname"];
												}
												$query003 = sprintf("SELECT * FROM  cam_position where position_id = '$rowc[position_id]'; ");
												$qur003 = mysqli_query($db, $query003);
												while ($rowc003 = mysqli_fetch_array($qur003)) {
													$positionname = $rowc003["position_name"];
												}
												?>
												<div class="col-lg-2">
													<input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $asigncrewid; ?>">
													<input type="hidden" id="res_type[]" name="res_type[]" value="<?php echo $res_type; ?>">
												</div>
												<label class="col-lg-3 control-label"><?php echo $positionname; ?>:</label>
												<div class="col-lg-6">
													<input type="text" value="<?php echo $firstname; ?>&nbsp;<?php echo $lastname; ?>" disabled class="form-control">
												</div>
												<?php
											} else {
												?>
												<div class="col-lg-2">
												</div>
												<?php
												$query004 = sprintf("SELECT * FROM  cam_position where position_id = '$rowc[position_id]'; ");
												$qur004 = mysqli_query($db, $query004);
												while ($rowc004 = mysqli_fetch_array($qur004)) {
													$positionname = $rowc004["position_name"];
												}
												?>
												<label class="col-lg-3 control-label"><?php echo $positionname; ?>:</label>
												<div class="col-lg-6">
													<input type="hidden" name="position[]" value="<?php echo $rowc["position_id"]; ?>">
													<input type="hidden" name="assignline" value="<?php echo $assign_line; ?>">
													<input type="hidden" name="resource_type[]" value="regular">
													<select name="user_name[]" id="user_name<?php echo $cnt; ?>" class="update bootstrap-select" data-live-search="true" data-width="100%"   data-count="<?php echo $cnt; ?>">
														<option value="1" selected >--- Select User ---</option>
														<?php
														$sql1 = "SELECT * FROM `cam_users` WHERE `assigned2` = '0'  and `users_id` != '1' order BY `firstname`";
														$result1 = $mysqli->query($sql1);
														while ($row1 = $result1->fetch_assoc()) {
															$full = $row1['firstname'] . " " . $row1['lastname'];
															echo "<option value='" . $row1['users_id'] . "' data-fullnm = '$full' data-id='" . $row1['assigned'] . "'>$full</option>";
														}
														?>
													</select>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<br/>
								<?php $cnt++; ?>
							<?php } ?>
							<!-- last two line code starts -->
							<?php
							$priyantcount = 2;
							$qurtemp2 = mysqli_query($db, "SELECT * FROM cam_assign_crew WHERE line_id = '$assign_line' and resource_type != 'regular'  ORDER by created_at ");
							while ($rowctemp2 = mysqli_fetch_array($qurtemp2)) {
								$userid = $rowctemp2["user_id"];
								$assigncrewid = $rowctemp2["assign_crew_id"];
								$res_type = $rowctemp2["resource_type"];
								$po = $rowctemp2["position_id"];
								$qurtemp3 = mysqli_query($db, "SELECT firstname,lastname FROM cam_users WHERE users_id = '$userid'");
								$rowctemp3 = mysqli_fetch_array($qurtemp3);
								$firstname = $rowctemp3["firstname"];
								$lastname = $rowctemp3["lastname"];
								$qurtemp4 = mysqli_query($db, "SELECT position_name FROM cam_position WHERE position_id = '$po'");
								$rowctemp4 = mysqli_fetch_array($qurtemp4);
								$po_name = $rowctemp4["position_name"];
								$priyantcount--;
								?>
								<!-- if condition -->
								<div class="row">
									<div class="col-md-9">
										<div class="form-group">
											<div class="col-lg-2">
												<input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $assigncrewid; ?>">
												<input type="hidden" id="res_type[]" name="res_type[]" value="<?php echo $res_type; ?>">
											</div>
											<label class="col-lg-3 control-label"><?php echo $po_name; ?>:</label>
											<div class="col-lg-3">
												<input type="text" value="<?php echo $firstname; ?>&nbsp;<?php echo $lastname; ?>" disabled class="form-control">
											</div>
											<div class="col-lg-3">
												<input type="text" value="<?php echo $res_type; ?>" disabled class="form-control">
											</div>
										</div>
									</div>
								</div>	<br/>
							<?php } ?>
							<?php
							if ($priyantcount != "0") {
								for ($i = 0; $i < $priyantcount;) {
									?>
									<div class="row">
										<div class="col-md-9">
											<div class="form-group">
												<div class="col-lg-2">
												</div>
												<div class="col-lg-3">
													<select name="position[]" class="form-control" >
														<option value="1" selected >--- Select Position ---</option>
														<?php
														$sql1 = "SELECT * FROM  cam_station_pos_rel where line_id = '$assign_line'";
														$result1 = $mysqli->query($sql1);
														while ($row1 = $result1->fetch_assoc()) {
															$pid = $row1['position_id'];
															$qurtemp5 = mysqli_query($db, "SELECT position_name FROM cam_position WHERE position_id = '$pid'");
															$rowctemp5 = mysqli_fetch_array($qurtemp5);
															$p = $rowctemp5["position_name"];
															echo "<option value='" . $row1['position_id'] . "' >" . $p . "</option>";
														}
														?>
													</select></div>
												<!--		<label class="col-lg-3 control-label"><?php echo $rowc["position_name"]; ?>:</label> -->
												<div class="col-lg-4">
													<input type="hidden" name="assignline" value="<?php echo $assign_line; ?>">
													<select name="user_name[]" id="user_name<?php echo $cnt; ?>" class="update bootstrap-select" data-live-search="true" data-width="100%"  data-row="5"  data-count="<?php echo $cnt; ?>">
														<option value="1" selected >--- Select User ---</option>
														<?php
														$sql1 = "SELECT * FROM `cam_users` WHERE `assigned2` = '0'  and `users_id` != '1' order BY `firstname`";
														$result1 = $mysqli->query($sql1);
														while ($row1 = $result1->fetch_assoc()) {
															$full = $row1['firstname'] . " " . $row1['lastname'];
															echo "<option value='" . $row1['users_id'] . "' data-fullnm = '$full' data-row='5' data-id='" . $row1['assigned'] . "'>$full</option>";
														}
														?>
													</select>
												</div>
												<div class="col-lg-3">
													<select name="resource_type[]" id="resource_type<?php echo $cnt; ?>" class="update bootstrap-select" data-live-search="true" data-width="100%"  data-count="<?php echo $cnt; ?>">
														<option value="Cross Training" selected >--- Select Resource Type ---</option>
														<option value="Cross Training"  >Cross Training</option>
														<option value="Additional Personnel" >Additional Personnel</option>
													</select>
												</div>
											</div>
										</div>
									</div>	<br/>
									<?php
									$i++;
								}
							}
							?>
							<h2>Cross Training</h2>
							<div class="row">
								<div class="col-md-9">
									<div class="form-group">
										<div class="col-lg-2">
										</div>
										<div class="col-lg-3">
											<select name="position[]" class="form-control" >
												<option value="1" selected >--- Select Position ---</option>
												<?php
												$sql1 = "SELECT * FROM  cam_station_pos_rel where line_id = '$assign_line'";
												$result1 = $mysqli->query($sql1);
												while ($row1 = $result1->fetch_assoc()) {
													$pid = $row1['position_id'];
													$qurtemp5 = mysqli_query($db, "SELECT position_name FROM cam_position WHERE position_id = '$pid'");
													$rowctemp5 = mysqli_fetch_array($qurtemp5);
													$p = $rowctemp5["position_name"];
													echo "<option value='" . $row1['position_id'] . "' >" . $p . "</option>";
												}
												?>
											</select></div>
										<!--		<label class="col-lg-3 control-label"><?php echo $rowc["position_name"]; ?>:</label> -->
										<div class="col-lg-4">
											<input type="hidden" name="assignline" value="<?php echo $assign_line; ?>">
											<select name="user_name[]" id="user_name<?php echo $cnt; ?>" class="update bootstrap-select" data-live-search="true" data-width="100%"  data-row="5"  data-count="<?php echo $cnt; ?>">
												<option value="1" selected >--- Select User ---</option>
												<?php
												$sql1 = "SELECT * FROM `cam_users` WHERE `assigned2` = '0'  and `users_id` != '1' order BY `firstname`";
												$result1 = $mysqli->query($sql1);
												while ($row1 = $result1->fetch_assoc()) {
													$full = $row1['firstname'] . " " . $row1['lastname'];
													echo "<option value='" . $row1['users_id'] . "' data-fullnm = '$full' data-row='5' data-id='" . $row1['assigned'] . "'>$full</option>";
												}
												?>
											</select>
										</div>
										<div class="col-lg-3">
											<select name="resource_type[]" id="resource_type<?php echo $cnt; ?>" class="update bootstrap-select" data-live-search="true" data-width="100%"  data-count="<?php echo $cnt; ?>">
												<option value="Cross Training" selected >--- Select Resource Type ---</option>
												<option value="Cross Training"  >Cross Training</option>

											</select>
										</div>



										<div>

										</div>
									</div>
									<div class="col-md-3" >
									</div>

								</div>
								<div class="col-md-3"> <button type="button" class="btn btn-primary" onclick="submitForm11('assign_crew_unassign_submit.php')" style="background-color:#1e73be;">ADD MORE</button>
									<button  type="button" class="btn btn-primary" onclick="submitForm('assign_crew_submit.php')"  style="background-color:#1e73be;">DELETE</button>

								</div>
							</div>	<br/>
							<!-- last two line code ends -->
							<?php
							if ($message_stauts_class == '') {
								?>
								<button type="button" class="btn btn-primary" onclick="submitForm('assign_crew_submit.php')"  style="background-color:#1e73be;">Assign Crew</button> &nbsp;&nbsp;&nbsp; <button type="button" class="btn btn-primary" onclick="submitForm11('assign_crew_unassign_submit.php')" style="background-color:#1e73be;">Unassign Crew</button>
							<?php } ?>
						</form>
						<br/>
						<?php
						if (!empty($import_status_message)) {
							echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
						}
						?>
					</div>
				<?php } ?>
				<!-- /basic datatable -->
				<!-- /main charts -->
				<!-- Dashboard content -->
				<!-- /dashboard content -->
			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
</div>
<!-- /page container -->
<?php include ('../footer.php') ?>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>assignment_module/assign_crew.php");
    }
    $('.update').on('change', function (event) {
        //	debugger;
        var prevValue = $(this).data('previous');
        var neww = 0;
        var row_no = $(this).data('row');
        //    $('.update').not(this).find('option[value="' + prevValue + '"]').show();
        // The .each() method is unnecessary here:
        //    var count = 0;
        //   $( ".update" ).each(function() {
        //      var option2 = $('option:selected', this).val();
        //      if(option2 == prevValue){
        //          count++;
        //      }
        //      if(count == 0){
        // $('.update').find('option[value="' + prevValue + '"]').attr("data-id", "0");
        neww = $('.update').find('option[value="' + prevValue + '"]:selected').attr("data-row");
        //console.log("neww");
        //console.log(neww);
        //console.log(prevValue);
        //      }
        //    });
        var selected_val = $(this).attr("id");
        //console.log(selected_val);
        var fullnm = $('#' + selected_val).find(":selected").attr("data-fullnm");
        var sel_data_id = parseInt($('#' + selected_val).find(":selected").attr("data-id"));
        var prevValue = $(this).data('previous');
        if (prevValue) {
            var prev_dat_id = parseInt($("#" + selected_val + " option[value= '" + prevValue + "']")[0].attributes['data-id'].value);
            $('.update').find('option[value="' + prevValue + '"]').attr("data-id", parseInt(prev_dat_id - 1));
            prefullnm = $('.update').find('option[value="' + prevValue + '"]:selected').attr("data-fullnm");
            $('.update').not(this).find('option[value="' + prevValue + '"]').show();
            $this = $(".custom_cls > span:contains(" + prefullnm + ")");
            $this.parent().show()
        }
        var value = $(this).val();
        //console.log(prevValue);
        $('.update').find('option[data-row="' + neww + '"][value="' + prevValue + '"]').hide();
        if (value) {
            $(this).data('previous', value);
            if (sel_data_id == 1) {
                $('.update').not(this).find('option[value="' + value + '"]').hide();
                $this = $(".custom_cls > span:contains(" + fullnm + ")");
                $this.parent().hide()
            }
            $('.update').find('option[value="' + value + '"]').attr("data-id", sel_data_id + 1);
            $('.update').not(this).find('option[data-row="5"][value="' + value + '"]').hide();
            //$(".opt > span:contains('Additional Personnel')").hide ();
            //console.log(value);
        }
    });
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
    function submitForm11(url) {
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
</body>
</html>
