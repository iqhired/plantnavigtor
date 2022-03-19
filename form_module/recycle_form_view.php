<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	header('location: ../logout.php');
}
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
	header('location: ../dashboard.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php echo $sitename; ?> | Recycle View Form</title>
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
	<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../assets/js/core/app.js"></script>
	<script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
	<!--    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>-->
	<script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
	<style>
		.select2-selection{
			pointer-events: none;
		}
		 .sidebar-default .navigation li>a {
			 color: #f5f5f5
		 }

		a:hover {
			background-color: #20a9cc;
		}

		.sidebar-default .navigation li>a:focus,
		.sidebar-default .navigation li>a:hover {
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

		span.select2-selection.select2-selection--multiple {
			border-bottom: 1px solid #1e73be !important;
		}



		.contextMenu{ position:absolute;  width:min-content; left: -18px; background:#e5e5e5; z-index:999;}


		.arrow {
			border: solid black;
			border-width: 0 3px 3px 0;
			display: inline-block;
			padding: 3px;
		}

		.right {
			transform: rotate(-45deg);
			-webkit-transform: rotate(-45deg);
		}

		.left {
			transform: rotate(135deg);
			-webkit-transform: rotate(135deg);
		}

		.up {
			transform: rotate(-135deg);
			-webkit-transform: rotate(-135deg);
		}

		.down {
			transform: rotate(45deg);
			-webkit-transform: rotate(45deg);
		}
		.red {
			color: red;
			display: none;
		}
		.remove_btn {
			float: right;
			width: 2%;
		}
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-2{
                width: 35%!important;
            }
            .content:first-child {
                padding-top: 90px!important;
            }


        }
	</style>
</head>

<body>
<!-- Main navbar -->
<?php
$cam_page_header = "Recycle Form View";
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

				<?php
				$id = $_GET['id'];

				$querymain = sprintf("SELECT * FROM `form_create` where form_create_id = '$id' and delete_flag = '1'");
				$qurmain = mysqli_query($db, $querymain);
				while ($rowcmain = mysqli_fetch_array($qurmain)) {
					$formname = $rowcmain['name'];
					?>


					<div class="panel panel-flat">
						<div class="panel-heading">

							<?php if ($temp == "one") { ?>
								<br/>
								<div class="alert alert-success no-border">
									<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button> <span class="text-semibold">Group</span> Created Successfully. </div>
							<?php } ?>
							<?php if ($temp == "two") { ?>
								<br/>
								<div class="alert alert-success no-border">
									<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button> <span class="text-semibold">Group</span> Updated Successfully. </div>
							<?php } ?>
							<?php
							if (!empty($import_status_message)) {
								echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
							}
							?>
							<?php
							if (!empty($_SESSION[import_status_message])) {
								echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
								$_SESSION['message_stauts_class'] = '';
								$_SESSION['import_status_message'] = '';
							}
							?>

							<div class="row">
								<div class="col-md-12">
									<fieldset disabled="disabled">
									<form readonly="" id="form_settings" enctype="multipart/form-data" class="form-horizontal" method="post">
										<input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $id; ?>">

										<div class="row">
											<label class="col-lg-2 control-label">Name : </label>
											<div class="col-md-6">
												<input type="text" name="name" id="name" class="form-control" value="<?php echo $rowcmain['name']; ?>" placeholder="Enter Form Name" required> </div>
											<div id="error1" class="red">Please Enter Name</div>

										</div>
										<br/>
										<div class="row">

												<label class="col-lg-2 control-label" for="default">Form Classification:</label>

											<div class="col-md-6">
												<div class="form-check form-check-inline">
													<input type="radio" id="event" name="form_classification" value="event" class="form-check-input" <?php if($rowcmain['form_classification'] == "event"){ echo 'checked'; } ?>>
													<label for="event" class="item_label">Event</label>
													<input type="radio" id="general" name="form_classification" value="general" class="form-check-input" <?php if($rowcmain['form_classification'] == "general"){ echo 'checked'; } ?>>
													<label for="general" class="item_label">General</label>

												</div>
											</div>
										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">Form Type : </label>
											<div class="col-md-6">
												<select name="form_type" id="form_type" class="select" data-style="bg-slate">
													<option value="" selected disabled>--- Select Form Type ---</option>
													<?php
													$form_type = $rowcmain['form_type'];
													$sql1 = "SELECT * FROM `form_type` ";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														if($form_type == $row1['form_type_id'])
														{
															$entry = 'selected';
														}
														else
														{
															$entry = '';

														}
														echo "<option value='" . $row1['form_type_id'] . "'  $entry>" . $row1['form_type_name'] . "</option>";
													}
													?>
												</select>
												<div id="error2" class="red">Please Enter Form Type</div>

											</div>
										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">Station : </label>
											<div class="col-md-6">
												<select name="station" id="station" class="select" data-style="bg-slate">
													<option value="" selected disabled>--- Select Station ---</option>
													<?php
													$st_dashboard = $rowcmain['station'];
													$sql1 = "SELECT * FROM `cam_line`  where enabled = '1' ORDER BY `line_name` ASC";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														if($st_dashboard == $row1['line_id'])
														{
															$entry = 'selected';
														}
														else
														{
															$entry = '';
														}
														echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
													}
													?>
												</select>
												<div id="error3" class="red">Please Enter Station </div>
											</div>
										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">Part Family : </label>
											<div class="col-md-6">
												<select name="part_family" id="part_family" class="select" data-style="bg-slate">
													<option value="" selected disabled>--- Select Part Family ---</option>
													<?php
													$part_family = $rowcmain['part_family'];
													$sql1 = "SELECT * FROM `pm_part_family` ";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														if($part_family == $row1['pm_part_family_id'])
														{
															$entry = 'selected';
														}
														else
														{
															$entry = '';
														}
														echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
													}
													?>
												</select>
												<div id="error4" class="red">Please Enter Part Family</div>
											</div>
										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">Part Number : </label>
											<div class="col-md-6">
												<select name="part_number" id="part_number" class="select" data-style="bg-slate">
													<option value="" selected disabled>--- Select Part Number ---</option>
													<?php
													$part_number = $rowcmain['part_number'];
													$sql1 = "SELECT * FROM `pm_part_number` ";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														if($part_number == $row1['pm_part_number_id'])
														{
															$entry = 'selected';
														}
														else
														{
															$entry = '';
														}
														echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number']." - ".$row1['part_name']  . "</option>";
													}
													?>
												</select>
												<div id="error5" class="red">Please Enter Part Number</div>
											</div>
										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">Image : </label>
											<div class="col-md-6">
												<input type="file" name="image[]" id="image" class="form-control" multiple> </div>
										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">PO Number : </label>
											<div class="col-md-6">
												<input type="text" name="po_number" id="po_number" value="<?php echo $rowcmain['po_number']; ?>" class="form-control"> </div>
											<div id="error6" class="red">Please Enter PO Number</div>

										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">DA Number : </label>
											<div class="col-md-6">
												<input type="text" name="da_number" id="da_number" value="<?php echo $rowcmain['da_number']; ?>" class="form-control"> </div>
											<div id="error7" class="red">Please Enter DA Number</div>

										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">Out of tolerance Mail List : </label>
											<div class="col-md-6">
												<div class="form-group">
													<select class="select select-border-color" data-placeholder="Tolerance Mail List..."  name="out_of_tolerance_mail_list[]" id="out_of_tolerance_mail_list" data-style="bg-slate"  multiple="multiple">
														<?php
														$arrteam = explode(',', $rowcmain["out_of_tolerance_mail_list"]);
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
													<div id="error9" class="red">Please Select Tolerance Mail List</div>

												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-lg-2 control-label">Out of Control List : </label>
											<div class="col-md-6">
												<div class="form-group">
													<select class="select select-border-color select-access-multiple-open" data-placeholder="Out of Control List ..." name="out_of_control_list[]" data-style="bg-slate"  id="out_of_control_list" multiple="multiple">
														<?php
														$arrteam = explode(',', $rowcmain["out_of_control_list"]);
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
													<div id="error10" class="red">Please Select Out of Control List</div>

												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-lg-2 control-label">Notification List : </label>
											<div class="col-md-6">
												<div class="form-group">
													<select class="select select-border-color select-access-multiple-open" data-style="bg-slate"  data-placeholder="Notification List ..." name="notification_list[]" id="notification_list" multiple="multiple">
														<?php
														$arrteam1 = explode(',', $rowcmain["notification_list"]);
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
										</div>
										<div class="row">
											<label class="col-lg-8 control-label">*form is not filled within 30 min of the time then Notification List will get mail</label>
										</div>
										<div class="row">
											<!--<div class="col-md-4">-->
											<label class="col-lg-2 control-label">Notes : </label>
											<div class="col-md-6">
												<textarea id="notes" name="form_create_notes" rows="4" value="<?php echo $rowcmain['form_create_notes']; ?>" placeholder="Enter Notes..." class="form-control"></textarea>
											</div>
										</div>
										<br/>
										<div class="row">
											<label class="col-lg-2 control-label">Needs Approval : </label>
											<div class="col-md-6">
												<select name="need_approval" id="need_approval" class="select" data-style="bg-slate">
													<!--  <option value="" selected disabled>--- Select Options ---</option> -->
													<?php

													$need_approval = $rowcmain['need_approval'];
													if($need_approval == "yes"){
														$selectyes = 'selected';
														$selectno = '';
													}
													else
													{
														$selectno = 'selected';
														$selectyes = '';
													}

													?>
													<option value="yes" <?php echo $selectyes; ?>>Yes</option>
													<option value="no" <?php echo $selectno; ?>>No</option>
												</select>
											</div>
										</div>
										<br/>
										<div class="row" id="approve_row">
											<label class="col-lg-2 control-label">Approval By : </label>
											<div class="col-md-6">
												<div class="form-group">
													<select class="select select-border-color select-access-multiple-open" data-placeholder="Approval By ..." name="approval_by[]" data-style="bg-slate"  id="approval_by" multiple="multiple">
														<?php
														$arrteam = explode(',', $rowcmain["approval_by"]);
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
										</div>
										<div class="row">
											<!--<div class="col-md-4">-->
											<label class="col-lg-2 control-label">Valid From : </label>
											<div class="col-md-6">
												<input type="date" name="valid_from" id="valid_from" value="<?php echo $rowcmain["valid_from"]; ?>" class="form-control"> </div>
										</div>
										<br/>
										<div class="row">
											<!--<div class="col-md-4">-->
											<label class="col-lg-2 control-label">Valid Till : </label>
											<div class="col-md-6">
												<input type="date" name="valid_till" id="valid_till" value="<?php echo $rowcmain["valid_till"]; ?>" class="form-control"> </div>
										</div>
										<br/>
										<div class="row">
											<!--<div class="col-md-4">-->
											<label class="col-lg-2 control-label">Frequency : </label>
											<?php
											$arrteam1 = explode(':', $rowcmain["frequency"]);
											$hr = $arrteam1[0];
											$min = $arrteam1[1];
											?>
											<div class="col-md-3">
												<select name="duration_hh" id="duration_hh" value="<?php echo $hr; ?>" class="form-control">
													<option value="" disabled selected>--- Select Hours ---</option>
													<option value="00" <?php if($hr == '00'){echo 'selected';} ?>>00</option>
													<option value="01" <?php if($hr == '01'){echo 'selected';} ?>>01</option>
													<option value="02" <?php if($hr == '02'){echo 'selected';} ?>>02</option>
													<option value="03" <?php if($hr == '03'){echo 'selected';} ?>>03</option>
													<option value="04" <?php if($hr == '04'){echo 'selected';} ?>>04</option>
													<option value="05" <?php if($hr == '05'){echo 'selected';} ?>>05</option>
													<option value="06" <?php if($hr == '06'){echo 'selected';} ?>>06</option>
													<option value="07" <?php if($hr == '07'){echo 'selected';} ?>>07</option>
													<option value="08" <?php if($hr == '08'){echo 'selected';} ?>>08</option>
													<option value="09" <?php if($hr == '09'){echo 'selected';} ?>>09</option>
													<option value="10" <?php if($hr == '10'){echo 'selected';} ?>>10</option>
													<option value="11" <?php if($hr == '11'){echo 'selected';} ?>>11</option>
													<option value="12" <?php if($hr == '12'){echo 'selected';} ?>>12</option>
													<option value="13" <?php if($hr == '13'){echo 'selected';} ?>>13</option>
													<option value="14" <?php if($hr == '14'){echo 'selected';} ?>>14</option>
													<option value="15" <?php if($hr == '15'){echo 'selected';} ?>>15</option>
													<option value="16" <?php if($hr == '16'){echo 'selected';} ?>>16</option>
													<option value="17" <?php if($hr == '17'){echo 'selected';} ?>>17</option>
													<option value="18" <?php if($hr == '18'){echo 'selected';} ?>>18</option>
													<option value="19" <?php if($hr == '19'){echo 'selected';} ?>>19</option>
													<option value="20" <?php if($hr == '20'){echo 'selected';} ?>>20</option>
													<option value="21" <?php if($hr == '21'){echo 'selected';} ?>>21</option>
													<option value="22" <?php if($hr == '22'){echo 'selected';} ?>>22</option>
													<option value="23" <?php if($hr == '23'){echo 'selected';} ?>>23</option>
												</select>
											</div>
											<div class="col-md-3">
												<select name="duration_mm" id="duration_mm" value="<?php echo $min; ?>" class="form-control">
													<option value="" disabled selected>--- Select Minutes ---</option>
													<option value="00" <?php if($min == '00'){echo 'selected';} ?>>00</option>
													<option value="01" <?php if($min == '01'){echo 'selected';} ?>>01</option>
													<option value="02" <?php if($min == '02'){echo 'selected';} ?>>02</option>
													<option value="03" <?php if($min == '03'){echo 'selected';} ?>>03</option>
													<option value="04" <?php if($min == '04'){echo 'selected';} ?>>04</option>
													<option value="05" <?php if($min == '05'){echo 'selected';} ?>>05</option>
													<option value="06" <?php if($min == '06'){echo 'selected';} ?>>06</option>
													<option value="07" <?php if($min == '07'){echo 'selected';} ?>>07</option>
													<option value="08" <?php if($min == '08'){echo 'selected';} ?>>08</option>
													<option value="09" <?php if($min == '09'){echo 'selected';} ?>>09</option>
													<option value="10" <?php if($min == '10'){echo 'selected';} ?>>10</option>
													<option value="11" <?php if($min == '11'){echo 'selected';} ?>>11</option>
													<option value="12" <?php if($min == '12'){echo 'selected';} ?>>12</option>
													<option value="13" <?php if($min == '13'){echo 'selected';} ?>>13</option>
													<option value="14" <?php if($min == '14'){echo 'selected';} ?>>14</option>
													<option value="15" <?php if($min == '15'){echo 'selected';} ?>>15</option>
													<option value="16" <?php if($min == '16'){echo 'selected';} ?>>16</option>
													<option value="17" <?php if($min == '17'){echo 'selected';} ?>>17</option>
													<option value="18" <?php if($min == '18'){echo 'selected';} ?>>18</option>
													<option value="19" <?php if($min == '19'){echo 'selected';} ?>>19</option>
													<option value="20" <?php if($min == '20'){echo 'selected';} ?>>20</option>
													<option value="21" <?php if($min == '21'){echo 'selected';} ?>>21</option>
													<option value="22" <?php if($min == '22'){echo 'selected';} ?>>22</option>
													<option value="23" <?php if($min == '23'){echo 'selected';} ?>>23</option>
													<option value="24" <?php if($min == '24'){echo 'selected';} ?>>24</option>
													<option value="25" <?php if($min == '25'){echo 'selected';} ?>>25</option>
													<option value="26" <?php if($min == '26'){echo 'selected';} ?>>26</option>
													<option value="27" <?php if($min == '27'){echo 'selected';} ?>>27</option>
													<option value="28" <?php if($min == '28'){echo 'selected';} ?>>28</option>
													<option value="29" <?php if($min == '29'){echo 'selected';} ?>>29</option>
													<option value="30" <?php if($min == '30'){echo 'selected';} ?>>30</option>
													<option value="31" <?php if($min == '31'){echo 'selected';} ?>>31</option>
													<option value="32" <?php if($min == '32'){echo 'selected';} ?>>32</option>
													<option value="33" <?php if($min == '33'){echo 'selected';} ?>>33</option>
													<option value="34" <?php if($min == '34'){echo 'selected';} ?>>34</option>
													<option value="35" <?php if($min == '35'){echo 'selected';} ?>>35</option>
													<option value="36" <?php if($min == '36'){echo 'selected';} ?>>36</option>
													<option value="37" <?php if($min == '37'){echo 'selected';} ?>>37</option>
													<option value="38" <?php if($min == '38'){echo 'selected';} ?>>38</option>
													<option value="39" <?php if($min == '39'){echo 'selected';} ?>>39</option>
													<option value="40" <?php if($min == '40'){echo 'selected';} ?>>40</option>
													<option value="41" <?php if($min == '41'){echo 'selected';} ?>>41</option>
													<option value="42" <?php if($min == '42'){echo 'selected';} ?>>42</option>
													<option value="43" <?php if($min == '43'){echo 'selected';} ?>>43</option>
													<option value="44" <?php if($min == '44'){echo 'selected';} ?>>44</option>
													<option value="45" <?php if($min == '45'){echo 'selected';} ?>>45</option>
													<option value="46" <?php if($min == '46'){echo 'selected';} ?>>46</option>
													<option value="47" <?php if($min == '47'){echo 'selected';} ?>>47</option>
													<option value="48" <?php if($min == '48'){echo 'selected';} ?>>48</option>
													<option value="49" <?php if($min == '49'){echo 'selected';} ?>>49</option>
													<option value="50" <?php if($min == '50'){echo 'selected';} ?>>50</option>
													<option value="51" <?php if($min == '51'){echo 'selected';} ?>>51</option>
													<option value="52" <?php if($min == '52'){echo 'selected';} ?>>52</option>
													<option value="53" <?php if($min == '53'){echo 'selected';} ?>>53</option>
													<option value="54" <?php if($min == '54'){echo 'selected';} ?>>54</option>
													<option value="55" <?php if($min == '55'){echo 'selected';} ?>>55</option>
													<option value="56" <?php if($min == '56'){echo 'selected';} ?>>56</option>
													<option value="57" <?php if($min == '57'){echo 'selected';} ?>>57</option>
													<option value="58" <?php if($min == '58'){echo 'selected';} ?>>58</option>
													<option value="59" <?php if($min == '59'){echo 'selected';} ?>>59</option>
												</select>
											</div>
										</div>
										<hr/>
										<div class="query_rows">
											<?php
											$id = $_GET['id'];
											$rowcount = 1;
											$queryitem = sprintf("SELECT * FROM `form_item` where form_create_id = '$id' ");
											$quritem = mysqli_query($db, $queryitem);
											while ($rowcitem = mysqli_fetch_array($quritem)) {
												//$formname = $rowcitem['form_name'];
												$item_val = $rowcitem['item_val'];
												?>

												<div class="rowitem_<?php echo $rowcount; ?>">
													<br/>
													<div class="contextMenu">
														<button type="button" id="moveup" class="btn"><i class="fa fa-angle-up"></i></button>
														<button type="button" id="movedown" class="btn"><i class="fa fa-angle-down"></i></button>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $rowcount; ?>">Form Item <?php echo $rowcount; ?></a><button type="button" name="remove_btn" class="btn btn-danger btn-xs remove_btn" id="btn_id<?php echo $rowcount; ?>" data-id="<?php echo $rowcount; ?>">-</button></h4></div>
														<div id="<?php echo $rowcount; ?>" class="panel-collapse collapse in">
															<div class="panel-body">
																<div class="qry_section" id="section_<?php echo $rowcount; ?>">
																	<div class="row">
																		<div class="col-md-2">
																			<label for="query_text">Item Description :</label>
																		</div>
																		<div class="col-md-6">
																			<input class="form-control" name="query_text[]" id="query_text" value="<?php echo $rowcitem['item_desc']; ?>" autocomplete="off" placeholder="Form Item Description" required>
																		</div>
																	</div>
																	<br>
																	<div class="row">
																		<div class="col-md-2">
																			<label for="item_class">Form Item Type:</label>
																		</div>
																		<div class="col-md-6">
																			<div class="form-check form-check-inline">

																				<input type="radio" id="numeric_<?php echo $rowcount; ?>" <?php if($item_val == "numeric"){ echo 'checked'; } ?> name="item_<?php echo $rowcount; ?>[]" value="numeric" data-name="numeric_<?php echo $rowcount; ?>" class="form-check-input" checked>
																				<label for="numeric" class="item_label">Numeric</label>
																				<input type="radio" id="binary_<?php echo $rowcount; ?>" <?php if($item_val == "binary"){ echo 'checked'; } ?> name="item_<?php echo $rowcount; ?>[]" value="binary" data-name="binary_<?php echo $rowcount; ?>" class="form-check-input">
																				<label for="binary" class="item_label">Binary</label>
																				<input type="radio" id="text_<?php echo $rowcount; ?>_<?php echo $rowcount; ?>" <?php if($item_val == "text"){ echo 'checked'; } ?> name="item_<?php echo $rowcount; ?>[]" value="text" data-name="text_<?php echo $rowcount; ?>" class="form-check-input">
																				<label for="text" class="item_label">Text</label>
																				<input type="radio" id="header" name="item_<?php echo $rowcount; ?>[]" <?php if($item_val == "header"){ echo 'checked'; } ?> value="header" data-name="header_<?php echo $rowcount; ?>" class="form-check-input">
																				<label for="header" class="item_label">Header</label>
																			</div>
																		</div>
																	</div>
																	<br>
																	<div class="numeric_section" id="numericsection_<?php echo $rowcount; ?>" <?php if($item_val != "numeric"){ echo "style='display:none;'"; } ?>>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="normal">Measurement Unit:</label>
																			</div>
																			<div class="col-md-6">
																				<select name="unit_of_measurement[]" id="unit_of_measurement" class="form-control" >
																					<?php
																					$sql1 = "SELECT * FROM `form_measurement_unit` ";
																					$result1 = $mysqli->query($sql1);
																					$me = $rowcitem['unit_of_measurement'];
																					// $entry = 'selected';
																					while ($row1 = $result1->fetch_assoc()) {
																						if($me == $row1['form_measurement_unit_id'])
																						{
																							$entry = 'selected';
																						}
																						else
																						{
																							$entry = '';
																						}
																						echo "<option value='" . $row1['form_measurement_unit_id'] . "'  $entry>" . $row1['unit_of_measurement'] . "</option>";
																					}
																					?>
																				</select>
																			</div>
																		</div><br/>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="normal">Nominal:</label>
																			</div>
																			<div class="col-md-6">
																				<input class="form-control" name="normal[]" id="normal" autocomplete="off" value="<?php echo $rowcitem['numeric_normal']; ?>">
																			</div>
																		</div>
																		<br>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="lower_tolerance">LowerTolerance:</label>
																			</div>
																			<div class="col-md-6">
																				<input class="form-control" name="lower_tolerance[]" id="lower_tolerance" autocomplete="off" value="<?php echo $rowcitem['numeric_lower_tol']; ?>">
																			</div>
																		</div>
																		<br>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="upper_tolerance">UpperTolerance:</label>
																			</div>
																			<div class="col-md-6">
																				<input class="form-control" name="upper_tolerance[]" id="upper_tolerance" autocomplete="off" value="<?php echo $rowcitem['numeric_upper_tol']; ?>">
																			</div>
																		</div>
																		<br>
																	</div>
																	<div class="binary_section" id="binarysection_<?php echo $rowcount; ?>" <?php if($item_val != "binary"){ echo "style='display:none;'"; } ?>>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="default">Default:</label>
																			</div>
																			<div class="col-md-6">
																				<div class="form-check form-check-inline">
																					<?php $defaultbina = $rowcitem['binary_default']; ?>
																					<input type="hidden" name="bansi_row_click[]"  value="<?php echo $rowcount; ?>" >
																					<input type="radio" id="none" name="default_binary_<?php echo $rowcount; ?>[]" value="none" class="form-check-input" <?php if($defaultbina == "none"){ echo 'checked'; }  ?>>
																					<label for="none" class="item_label">None</label>
																					<input type="radio" id="yes" name="default_binary_<?php echo $rowcount; ?>[]" value="yes" class="form-check-input" <?php if($defaultbina == "yes"){ echo 'checked'; }  ?>>
																					<label for="yes" class="item_label">Yes</label>
																					<input type="radio" id="no" name="default_binary_<?php echo $rowcount; ?>[]" value="no" class="form-check-input" <?php if($defaultbina == "no"){ echo 'checked'; }  ?>>
																					<label for="no" class="item_label">No</label>
																				</div>
																			</div>
																		</div>
																		<br>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="normal">Nominal:</label>
																			</div>
																			<div class="col-md-6">
																				<?php $nominalbina = $rowcitem['binary_normal']; ?>
																				<div class="form-check form-check-inline">
																					<input type="radio" id="yes" name="normal_binary_<?php echo $rowcount; ?>[]" value="yes" class="form-check-input" <?php if($nominalbina == "yes"){ echo 'checked'; }  ?>>
																					<label for="yes" class="item_label">Yes</label>
																					<input type="radio" id="no" name="normal_binary_<?php echo $rowcount; ?>[]" value="no" class="form-check-input" <?php if($nominalbina != "yes"){ echo 'checked'; }  ?>>
																					<label for="no" class="item_label">No</label>
																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="yes_alias">Yes Alias:</label>
																			</div>
																			<div class="col-md-6">
																				<input class="form-control" name="yes_alias[]" id="yes_alias" autocomplete="off" value="<?php echo $rowcitem['binary_yes_alias']; ?>">
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-2">
																				<label for="no_alias">No Alias:</label>
																			</div>
																			<div class="col-md-6">
																				<input class="form-control" name="no_alias[]" id="no_alias" autocomplete="off" value="<?php echo $rowcitem['binary_no_alias']; ?>">
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-2">
																			<label for="notes">Notes:</label>
																		</div>
																		<div class="col-md-6">
																			<textarea class="form-control" aria-label="With textarea" id="notes" name="form_item_notes[]" autocomplete="off" ><?php echo $rowcitem['notes']; ?></textarea>
																		</div>
																	</div>
																	<br/>
																	<div class="row">
																		<div class="col-md-2">
																			<label for="notes">Description:</label>
																		</div>
																		<div class="col-md-6">
																			<textarea class="form-control" aria-label="With textarea" id="disc" name="form_item_disc[]" autocomplete="off" ><?php echo $rowcitem['discription']; ?></textarea>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<input type="hidden" name="not_click_id" id="not_click_id" value="<?php echo $rowcount; ?>" >
													<input type="hidden" name="formitemhiddenid[]" id="formitemhiddenid" value="<?php echo $rowcitem['form_item_id']; ?>" >

												</div>

												<?php
												$rowcount++;
											} ?>




										</div>
										<input type="hidden" id="collapse_id" value="<?php echo $rowcount; ?>">
									</form>
									</fieldset>
								</div>
							</div>
						</div>
					</div>

				<?php } ?>


				<!-- /main charts -->
				<!-- edit modal -->
				<!-- Dashboard content -->
				<!-- /dashboard content -->
			</div>

</div>
<!-- /page container -->


<script>

    $(document).on("click",".remove_btn",function() {

        var row_id = $(this).attr("data-id");
        $(".rowitem_"+row_id).remove();

    });
    $(document).on("click",".submit_btn",function() {
        //$("#form_settings").submit(function() {

        var station = $("#station").val();
        var part_family = $("#part_family").val();
        var part_number = $("#part_number").val();
        var form_type = $("#form_type").val();
        var classification = $('input:radio[name=form_classification]:checked').val();

        var flag= 0;
        if(form_type == null){
            $("#error2").show();
            var flag= 1;
        }

        if(station == null){
            $("#error3").show();
            var flag= 1;
        }
        if(classification == 'event'){

            if(part_family == null){
                $("#error4").show();
                var flag= 1;
            }
            if(part_number == null){
                $("#error5").show();
                var flag= 1;
            }
        }

        if (flag == 1) {
            return false;
        }

    });

    $('#need_approval').on('change', function() {
        var app_value = $(this).val();
        if(app_value == "yes"){
            $("#approve_row").show();
        }
        if(app_value == "no"){
            $("#approve_row").hide();
        }
    });



</script>
<?php include ('../footer.php') ?>
</body>

</html>