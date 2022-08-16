<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
		header($redirect_tab_logout_path);
	}else{
		header($redirect_logout_path);
	}
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
	if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
		header($redirect_tab_logout_path);
	}else{
		header($redirect_logout_path);
	}

//	header('location: ../logout.php');
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$is_tab_login = $_SESSION['is_tab_user'];
$is_cell_login = $_SESSION['is_cell_login'];
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
	header('location: ../dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Submit Form</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
    <style>
        .red {
            color: red;
            display: none;
        }
        .hero{
            top: 45%!important;
        }
        .page-container {
            margin-top: 0px!important;
        }
        #ic .menu ul {
            margin-top: -1.5rem!important;

        }
        #mainDropdown {
            top: -30px!important;

        }



    </style>

</head>

<!-- Main navbar -->
<?php $cust_cam_page_header = "Submit Form ";
include("../header.php");

if (($is_tab_login || $is_cell_login)) {
	include("../tab_menu.php");
} else {
	include("../admin_menu.php");
}
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<div class="page-container">
    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <form action="" id="user_form" class="form-horizontal" method="post">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Station * : </label>
                                        <div class="col-lg-7">
                                            <select name="station" id="station" class="select form-control" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Station --- </option>
												<?php
												if($_SESSION["role_id"] == "pn_user" &&  (!empty($is_tab_login) || $is_tab_login == 1) && (empty($is_cell_login) || $is_cell_login == 0)){
													$is_tab_login = 1;
													$tab_line = $_REQUEST['station'];
													if(empty($tab_line)){
														$tab_line = $_SESSION['tab_station'];
													}
												}
												if($is_tab_login){
													$sql1 = "SELECT line_id, line_name FROM `cam_line`  where enabled = '1' and line_id = '$tab_line' and is_deleted != 1 ORDER BY `line_name` ASC";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														$entry = 'selected';
														echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
													}
												}else if($is_cell_login){
													if(empty($_REQUEST)) {
														$c_stations = implode("', '", $c_login_stations_arr);
														$sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id IN ('$c_stations') and is_deleted != 1 ORDER BY `line_name` ASC";
														$result1 = $mysqli->query($sql1);
														//													                $                        $entry = 'selected';
														$i = 0;
														while ($row1 = $result1->fetch_assoc()) {
															//														$entry = 'selected';
															if ($i == 0) {
																$entry = 'selected';
																echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
																$c_station = $row1['line_id'];
															} else {
																echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";

															}
															$i++;
														}
													}else{
														$line_id = $_REQUEST['line'];
														if(empty($line_id)){
															$line_id = $_REQUEST['station'];
														}
														$sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id ='$line_id' and is_deleted != 1";
														$result1 = $mysqli->query($sql1);
														while ($row1 = $result1->fetch_assoc()) {
															$entry = 'selected';
															$station = $row1['line_id'];
															echo "<option value='" . $station . "'  $entry>" . $row1['line_name'] . "</option>";

														}
													}
												}else{
													$st_dashboard = $_POST['station'];
													if (!isset($st_dashboard)) {
														$st_dashboard = $_REQUEST['station'];
													}
													$sql1 = "SELECT * FROM `cam_line` where enabled = '1' and is_deleted != 1 ORDER BY `line_name` ASC ";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														if ($st_dashboard == $row1['line_id']) {
															$entry = 'selected';
														} else {
															$entry = '';

														}
														echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
													}
												}
												?>
                                            </select>
                                            <div id="error1" class="red">Please Select Station</div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Part Family * : </label>
                                        <div class="col-lg-7">
                                            <select name="part_family" id="part_family" class="select form-control"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Family ---
                                                </option>
												<?php
												$st_dashboard = $_POST['part_family'];
												if(empty($st_dashboard) && !empty($_REQUEST['part_family'])){
													$st_dashboard = $_REQUEST['part_family'];
												}
												$station = $_POST['station'];
												if(empty($station) && !empty($_REQUEST['station'])){
													$station = $_REQUEST['station'];
												}
												if(empty($station) && !empty($tab_line)){
													$station = $tab_line;
												}
												if(empty($station) && ($is_cell_login == 1) && !empty($c_station)){
													$station = $c_station;
												}
												$sql1 = "SELECT * FROM `pm_part_family` where station = '$station' and is_deleted != 1 ORDER BY `part_family_name` ASC";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													if ($st_dashboard == $row1['pm_part_family_id']) {
														$entry = 'selected';
													} else {
														$entry = '';

													}
													echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
												}
												?>

                                            </select>
                                            <!-- <div id="error2" class="red">Please Select Part Family</div> -->

                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Part Number * : </label>
                                        <div class="col-lg-7">
                                            <select name="part_number" id="part_number" class="select form-control"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Number ---
                                                </option>
												<?php
												//	$st_dashboard = $_POST['part_number'];
												$part_family = $_REQUEST['part_family'];
												$st_dashboard = $_REQUEST['part_number'];
												$sql1 = "SELECT * FROM `pm_part_number` where part_family = '$part_family' and is_deleted != 1  ORDER BY `part_name` ASC";
												$result1 = $mysqli->query($sql1);
												while ($row1 = $result1->fetch_assoc()) {
													if ($st_dashboard == $row1['pm_part_number_id']) {
														$entry = 'selected';
													} else {
														$entry = '';

													}
													echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] . " - " . $row1['part_name'] . "</option>";
												}
												?>
                                            </select>
                                            <!-- <div id="error3" class="red">Please Select Part Number</div> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Form Type * : </label>
                                        <div class="col-lg-7">
                                            <select name="form_type" id="form_type" class="select form-control"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Form Type ---
                                                </option>
												<?php
												$st_dashboard = $_POST['form_type'];

												$sql1 = "SELECT * FROM `form_type` where is_deleted != 1 ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													if ($st_dashboard == $row1['form_type_id']) {
														$entry = 'selected';
													} else {
														$entry = '';

													}
													echo "<option value='" . $row1['form_type_id'] . "'  $entry>" . $row1['form_type_name'] . "</option>";
												}
												?>
                                            </select>
                                            <!-- <div id="error4" class="red">Please Select Form Type</div> -->
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <br/>
                        </div>
                    </div>

                    <div class="panel-footer p_footer">
                        <div>
                            <button type="submit" class="btn btn-primary submit_btn"
                                    style="width:120px;margin-right: 20px;background-color:#1e73be;">Submit
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="clear" id="btn" class="btn btn-primary"
                                    style="background-color:#1e73be;margin-right: 20px;width:120px;">Reset
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

		<?php
		if (count($_POST) > 0) {
			?>

            <div class="panel panel-flat">
                <table class="table datatable-basic">
                    <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Action</th>
                        <th>Form Name</th>
                        <th>Form Type</th>
                        <th>PO Number</th>
                        <th>DA Number</th>

                    </tr>
                    </thead>
                    <tbody>
					<?php
					$station = $_POST['station'];
					$part_number = $_POST['part_number'];
					$part_family = $_POST['part_family'];
					$form_type = $_POST['form_type'];


					if ($station != "" && $part_family == "" && $part_number == "" && $form_type == "") {
						$query = sprintf("SELECT * FROM `form_create` where station = '$station' and delete_flag = '0'");
					} else if ($station != "" && $part_family != "" && $part_number == "" && $form_type == "") {
						$query = sprintf("SELECT * FROM `form_create` where station = '$station' and part_family = '$part_family' and delete_flag = '0'");
					} else if ($station != "" && $part_family != "" && $part_number != "" && $form_type == "") {
						$query = sprintf("SELECT * FROM `form_create` where station = '$station' and part_family = '$part_family' and part_number = '$part_number' and delete_flag = '0'");
					} else {
						$query = sprintf("SELECT * FROM `form_create` where station = '$station' and part_family = '$part_family' and part_number = '$part_number' and form_type = '$form_type' and delete_flag = '0'");
					}

					$qur = mysqli_query($db, $query);
					while ($rowc = mysqli_fetch_array($qur)) {
						?>
                        <tr>
                            <td><?php echo ++$counter; ?></td>
                            <td>
                                <a href="user_form.php?id=<?php echo $rowc['form_create_id']; ?>&station=<?php echo $rowc['station']; ?>&form_type=<?php echo $rowc['form_type']; ?>&part_family=<?php echo $rowc['part_family']; ?>&part_number=<?php echo $rowc['part_number']; ?>&form_name=<?php echo $rowc['name']; ?>"
                                   class="btn btn-primary" style="background-color:#1e73be;">Submit</a>
                            </td>
                            <td><?php echo $rowc["name"]; ?></td>
							<?php
							$station1 = $rowc['form_type'];
							$qurtemp = mysqli_query($db, "SELECT * FROM  form_type where form_type_id  = '$station1' ");
							while ($rowctemp = mysqli_fetch_array($qurtemp)) {
								$station = $rowctemp["form_type_name"];
							}
							?>
                            <td><?php echo $station; ?></td>

                            <td><?php echo $rowc["po_number"]; ?></td>
                            <td><?php echo $rowc["da_number"]; ?></td>
							<?php

							$opt_sub = mysqli_query($db, "SELECT form_create_id FROM  form_user_data");

							while ($rowcopt = mysqli_fetch_array($opt_sub)) {
								$opt_id = $rowcopt["form_create_id"];
							}

							$option_submit = mysqli_query($db, "SELECT optional FROM  form_item where form_create_id  = '$opt_id'");
							while ($rowcoptional = mysqli_fetch_array($option_submit)) {
								$option = $rowcoptional["optional"];
							}
							// echo $opt_id;

							?>
                        </tr>
					<?php } ?>
                    </tbody>
                </table>
                <!--                </form>-->
            </div>

			<?php
		}
		?>
    </div>
</div>
<!-- Dashboard content -->
<!-- /dashboard content -->
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
            $("#edit_name").val(name);
            $("#edit_id").val(edit_id);
            //alert(role);
        });
    });
</script>

<!-- /content area -->




<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });


    $('#station').on('change', function (e) {
        $("#user_form").submit();
    });
    $('#part_family').on('change', function (e) {
        $("#user_form").submit();
    });
    $(document).on("click", ".submit_btn", function () {

        var station = $("#station").val();
        var part_family = $("#part_family").val();
        var part_number = $("#part_number").val();
        var form_type = $("#form_type").val();
// var flag= 0;
// if(station == null){
// 	$("#error1").show();
// 	var flag= 1;
// }
// if(part_family == null){
// 	$("#error2").show();
// 	var flag= 1;
// }
// if(part_number == null){
// 	$("#error3").show();
// 	var flag= 1;
// }
// if(form_type == null){
// 	$("#error4").show();
// 	var flag= 1;
// }
// if (flag == 1) {
//        return false;
//        }

    });

</script>
<script type="text/javascript">
    $(function () {
        $("#btn").bind("click", function () {
            var url = window.location.origin + "/form_module/options.php?station=" + $("#station")[0].value;
            window.close();
            window.open(url,"_blank");

        });
    });
</script>
<?php include('../footer.php') ?>
<!--<script type="text/javascript" src="../assets/js/core/app.js"></script>-->
</body>

</html>