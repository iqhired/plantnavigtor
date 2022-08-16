<?php
include("../config.php");
$sessionid = $_SESSION["id"];
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
	$name = $_POST['group_name'];
	if ($name != "") {
//$group_id = $_POST['group_id'];
		$group_name = $_POST['group_name'];
		$disc = $_POST['disc'];
		$sql12 = "INSERT INTO `sg_defect_group`(`d_group_name`,`description`,`creator_id`,`created_at`) VALUES ('$group_name','$disc','$sessionid','$chicagotime')";
		if ($db->query($sql12) === TRUE) {
			$last_id = $db->insert_id;
			$def_array = $_POST['defect_list'];
			foreach ($def_array as $defect){
				if(isset($defect) && $defect != ''){
					$sql12 = "INSERT INTO `sg_def_defgroup`(`defect_list_id`,`d_group_id`) VALUES ('$defect','$last_id')";
					mysqli_query($db, $sql12);
				}
			}

			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'Defect Group Created Sucessfully.';
		}else{
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Try Again.';
        }
//		if (!mysqli_query($db, $sql12)) {
//
//		} else {
//
//		}
	}
	$edit_name = $_POST['edit_name'];
	if ($edit_name != "") {
		$id = $_POST['edit_id'];
		$defects = $_POST['edit_defects'];
		$array_defects = '';
		$sql12 = "delete from `sg_def_defgroup` where d_group_id = '$id'";
		mysqli_query($db, $sql12);
		foreach ($defects as $defect) {
			if(isset($defect) && $defect != ''){
				$sql12 = "INSERT INTO `sg_def_defgroup`(`defect_list_id`,`d_group_id`) VALUES ('$defect','$id')";
				mysqli_query($db, $sql12);
			}
		}
//		$parent_id = $_POST['edit_parent'];
		$sql = "update sg_defect_group set d_group_name ='$_POST[edit_name]', description ='$_POST[edit_disc]' where d_group_id ='$id'";
		$result1 = mysqli_query($db, $sql);
		if ($result1) {
			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'Defect Group Updated Sucessfully.';
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Defect Group with this Name Already Exists';
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
	<title><?php echo $sitename; ?> | Group</title>
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

    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<!--        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>-->

	<script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
	<!--        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>-->
	<!--	<script type="text/javascript" src="assets/js/pages/form_select2.js"></script>
			-->
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
	<style>
		.sidebar-default .navigation li>a{color:#f5f5f5};
		a:hover {
			background-color: #20a9cc;
		}
		.sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
			background-color: #20a9cc;
		}
        .form-group {
            margin-top: 20px;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-md-5{
                width: 40%!important;
                float: left;
            }
            .col-md-6{
                width: 60%!important;
                float: right;
            }
            .form-group {
                margin-top: 50px;
            }
            form#user_form {
                width: 100%;
            }
            .col-lg-4{
                width: 44%!important;
            }
            .col-lg-8{
                width: 56%!important;
            }
        }
	</style>
</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Defect Group(s)";
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
						<h5 class="panel-title">Defect Group List</h5>
						<hr/>
						<div class="row">
							<form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="col-md-12">
										<div class="col-md-5 mob_page">
											<input type="text" name="group_name" id="group_name" class="form-control" placeholder="Enter Defect Group Name" required>
										</div>

										<div class="col-md-6 mob_page">
											<input type="text" name="disc" id="disc" class="form-control" placeholder="Enter Defect Group Description" required>
										</div>
                                        </div>
                                        <div class="col-md-11">
                                            <div class="form-group">
                                                <select class="select-border-color select-access-multiple-open" data-placeholder="Select Defects..." name="defect_list[]" id="defect_list" multiple="multiple" >
<!--                                                    <option value="" disabled selected>Select Defects </option>-->
													<?php
													$sql1 = "SELECT * FROM `defect_list`";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['defect_list_id'] . "'>" . $row1['defect_list_name'] . "</option>";
													}
													?>
                                                </select>
                                            </div>
                                        </div>
										<!--<input type="number" name="priority_order" id="priority_order" class="form-control" placeholder="Enter Priority Order" required>-->
										<!--</div>-->
										<div class="col-md-2">
											<button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create Defect Group</button>
										</div>
									</form>

						</div>
						<?php
						if (!empty($import_status_message)) {
							echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
						}
						?>
						<?php
						if (!empty($_SESSION['import_status_message'])) {
							echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
							$_SESSION['message_stauts_class'] = '';
							$_SESSION['import_status_message'] = '';
						}
						?>
					</div>
				</div>
				<form action="../delete_defect_group_list.php" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button>
						</div>
					</div>
					<br/>
					<div class="panel panel-flat">
						<table class="table datatable-basic">
							<thead>
							<tr>
								<th><input type="checkbox" id="checkAll" ></th>
								<th>S.No</th>
								<th>Name</th>
<!--								<th>Parent Group</th>-->
								<th>Description</th>
								<th>Defect List</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$query = sprintf("SELECT * FROM  sg_defect_group ");
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								?>
								<tr>
									<td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["d_group_id"]; ?>"></td>
									<td><?php echo ++$counter; ?></td>
									<td><?php echo $rowc["d_group_name"]; ?></td>
									<?php
                                    $d_gid = $rowc["d_group_id"];
									$qurtemp = mysqli_query($db, "SELECT * FROM  sg_defect_group where d_group_id = '$d_gid' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
										$station = $rowctemp["d_group_name"];
									}
									?>
									<td><?php echo $rowc['description']; ?></td>
                                    <?php
									$i=0;
									$array_defList = '';
									$array_defList_id = '';
									$qurtemp = mysqli_query($db, "SELECT dl.defect_list_id as defect_list_id , dl.defect_list_name as defect_list_name FROM sg_defect_group as sdg inner join sg_def_defgroup as sdd on sdg.d_group_id = sdd.d_group_id inner join defect_list as dl on sdd.defect_list_id = dl.defect_list_id where sdg.d_group_id =  '$d_gid' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
											if($i==0){
												$array_defList .= $rowctemp['defect_list_name'] ;
												$array_defList_id .= $rowctemp['defect_list_id'] ;
											}else{
												$array_defList .= " , "  .$rowctemp['defect_list_name'] ;
												$array_defList_id .= " , "  .$rowctemp['defect_list_id'] ;
											}
											$i++;

									}
                                    ?>
                                    <td><?php echo $array_defList; ?></td>
									<td>

										<button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['d_group_id']; ?>" data-name="<?php echo $rowc['d_group_name']; ?>" data-dl="<?php echo $array_defList_id; ?>" data-disc="<?php echo $rowc['description']; ?>"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
<!--                                        <a href="defect_group_page_1.php?id=--><?php //echo  $rowc['d_group_id']; ?><!--" class="btn btn-primary" data-id="--><?php //echo $rowc['d_group_id']; ?><!--"  data-target="#edit_modal_theme_primary" id="edit"  style="background-color:#1e73be;">Edit</a>-->

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
							<h6 class="modal-title">Update Group</h6>
						</div>
						<form action="" id="user_form" class="form-horizontal" method="post">
							<div class="modal-body" >
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="col-lg-4 control-label">Defect Group Name:*</label>
											<div class="col-lg-8">
												<input type="text" name="edit_name" id="edit_name" class="form-control" required>
												<input type="hidden" name="edit_id" id="edit_id" >
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="col-lg-4 control-label">Description : *</label>
											<div class="col-lg-8">
												<input type="text" name="edit_disc" id="edit_disc" class="form-control" required>
											</div>
										</div>
									</div>
								</div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Defects : </label>
                                            <div class="col-lg-8">
                                                <select required name="edit_defects[]" id="edit_defects"  class="select-border-color"
                                                        multiple="multiple">
													<?php
													$sql1 = "SELECT defect_list_id, defect_list_name FROM defect_list order by defect_list_name ASC";
													$result1 = $mysqli->query($sql1);
													$selected = "";
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option id='" . $row1['defect_list_id'] . "' value='" . $row1['defect_list_id'] . "' >" . $row1['defect_list_name'] . "</option>";
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
                                            <label class="col-lg-4 control-label">Defects : *</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="edit_disc" id="edit_disc" class="form-control" required>
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
                    $.ajax({type: "POST", url: "ajax_role_delete.php", data: info, success: function (data) { }});
                    $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                });
            </script>
			<script>
                $(document).on('click', '#edit', function () {
                    var element = $(this);
                    var edit_id = element.attr("data-id");
                    var name = $(this).data("name");
                    var parent = $(this).data("parent");
                    var disc = $(this).data("disc");
                    var dl = $(this).data("dl").toString();
                    if((null != dl) && ( dl !='')){
                        dl = dl.toString();
                    }
                    // console.log(name);
                    $("#edit_name").val(name);
                    $("#edit_id").val(edit_id);
                    $("#edit_parent").val(parent);
                    $("#edit_disc").val(disc);
                    //alert(role);

                    const sb1 = document.querySelector('#edit_defects');
                    // create a new option
                    var pnums = null;
                    if (dl.indexOf(',') > -1){
                        pnums = dl.replaceAll(' ','').split(',');
                    }else{
                        pnums = dl.replaceAll(' ','')
                    }
                    var options1 = sb1.options;
                    // $("#edit_part_number").val(options);
                    $('#edit_modal_theme_primary .select2 .selection .select2-selection--multiple .select2-selection__choice').remove();
                    // $('select2-search select2-search--inline').remove();

                    for (var i = 0; i < options1.length; i++) {
                        if(pnums.includes(options1[i].value)){ // EDITED THIS LINE
                            options1[i].selected="selected";
                            // options1[i].className = ("select2-results__option--highlighted");
                            var opt = document.getElementById(options1[i].value).outerHTML.split(">");
                             // $('#edit_defects').prop('selectedIndex',i);
                            $('#edit_defects #select2-results .select2-results__option').prop('selectedIndex',i);
                            var gg = '<li class="select2-selection__choice" title="' + opt[1].replace('</option','') + '"><span class="select2-selection__choice__remove" role="presentation">×</span>' + opt[1].replace('</option','') + '</li>';
                            $('#edit_modal_theme_primary .select2-selection__rendered').append(gg);
                            // $('.select2-search__field').style.visibility='hidden';
                        }
                    }

                });
			</script>

		</div>

</div>
<!-- /page container -->

<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>config_module/defect_group.php");
    }

</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $(".select").select2();
    // $(document).on('select2:open', () => {
    //     document.querySelector('.select2-search__field').focus();
    // });
</script>
<?php include('footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
