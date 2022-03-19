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
        <title><?php echo $sitename; ?> | User Form List</title>
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
        <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
				<style>
		.red {
    color: red;
    display: none;
}
		</style>
    </head>
    <body>
        <!-- Main navbar -->
<?php $cam_page_header = "User Form List ";
include("../header_folder.php");
?>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                <!-- User menu -->
                <!-- /user menu -->
                <!-- Main navigation -->
<?php include("../admin_menu.php"); ?>
                <!-- /main navigation -->
                <!-- /main sidebar -->
                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Page header -->
                    <!--                <div class="content">-->
                    <!--                <div class="panel panel-flat">-->
                    <!--                    <div class="panel-heading text_center">-->
                    <!--                        <h3><span class="text-semibold">Job Title </span> - Management</h3>-->
                    <!--                    </div>-->
                    <!--                </div>-->
                    <!--                </div>-->
                    <!-- /page header -->
                    <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <!--							<h5 class="panel-title">Job-Title List</h5>-->
                                <!--							<hr/>-->
								
								<form action="" id="user_form" class="form-horizontal" method="post">

									<div class="row">
										<div class="col-md-12">
											<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-lg-5 control-label">Station * : </label>
															<div class="col-lg-7">
																<select name="station" id="station" class="select" data-style="bg-slate" >
																	<option value="" selected disabled>--- Select Station ---</option>
																		<?php
																		$st_dashboard = $_POST['station'];
																		$sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
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
																<div id="error1" class="red">Please Select Station</div>

															</div>
														</div>
													</div>
															<div class="col-md-6">
														<div class="form-group">
															<label class="col-lg-5 control-label">Part Family * : </label>
															<div class="col-lg-7">
																<select name="part_family" id="part_family" class="select" data-style="bg-slate" >
																	<option value="" selected disabled>--- Select Part Family ---</option>
																	<?php
																	$st_dashboard = $_POST['part_family'];
																	$station = $_POST['station'];
																	$sql1 = "SELECT * FROM `pm_part_family` where station = '$station' ";
																	$result1 = $mysqli->query($sql1);
																	//                                            $entry = 'selected';
																	while ($row1 = $result1->fetch_assoc()) {
																		if($st_dashboard == $row1['pm_part_family_id'])
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
																<div id="error2" class="red">Please Select Part Family</div>
															</div>
														</div>
													</div>
											
											</div><br/>
											<div class="row">
												
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-lg-5 control-label">Part Number * : </label>
															<div class="col-lg-7">
																<select name="part_number" id="part_number" class="select" data-style="bg-slate" >
																	<option value="" selected disabled>--- Select Part Number ---</option>
																	<?php
																	$st_dashboard = $_POST['part_number'];
																	$part_family = $_POST['part_family'];
																	
																	$sql1 = "SELECT * FROM `pm_part_number` where part_family = '$part_family' ";
																	$result1 = $mysqli->query($sql1);
																	//                                            $entry = 'selected';
																	while ($row1 = $result1->fetch_assoc()) {
																		if($st_dashboard == $row1['pm_part_number_id'])
																			{
																				$entry = 'selected';
																			}
																			else
																			{
																				$entry = '';
																				
																			}
																		echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] ." - ".$row1['part_name']  . "</option>";
																	}
																	?>
																</select>
															<div id="error3" class="red">Please Select Part Number</div>
															</div>
														</div>
													</div>
																										<div class="col-md-6">
														<div class="form-group">
															<label class="col-lg-5 control-label">Form Type * : </label>
															<div class="col-lg-7">
																<select name="form_type" id="form_type" class="select" data-style="bg-slate" >
																	<option value="" selected disabled>--- Select Form Type ---</option>
																	<?php
																	$st_dashboard = $_POST['form_type'];
																	
																	$sql1 = "SELECT * FROM `form_type` ";
																	$result1 = $mysqli->query($sql1);
																	//                                            $entry = 'selected';
																	while ($row1 = $result1->fetch_assoc()) {
																		if($st_dashboard == $row1['form_type_id'])
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
															<div id="error4" class="red">Please Select Form Type</div>
															</div>
														</div>
													</div>

												</div><br/>
												
											<div class="row">
												
													<div class="col-md-4">
													<button type="submit" class="btn btn-primary submit_btn" style="background-color:#1e73be;">Submit</button></div>
												
											</div>
										</div>
									</div><br/>

								</form>
                            </div>
                        </div>

<?php
if(count($_POST) > 0)
{
?>

                    <div class="panel panel-flat">
                        <table class="table datatable-basic">
                            <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Form Name</th>
                                <th>Form Type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$station = $_POST['station'];
							$part_number = $_POST['part_number'];
							$part_family = $_POST['part_family'];
							$form_type = $_POST['form_type'];
							
							$query = sprintf("SELECT * FROM `form_user_data` where station = '$station' and part_family = '$part_family' and part_number = '$part_number' and form_type = '$form_type' ");
							
							if($station != "" && $part_family == "" && $part_number == "" && $form_type == "")
							{
								$query = sprintf("SELECT * FROM `form_user_data` where station = '$station' ");
							
							}
							else if($station != "" && $part_family != "" && $part_number == "" && $form_type == "")
							{
								$query = sprintf("SELECT * FROM `form_user_data` where station = '$station' and part_family = '$part_family'  ");
														
							}
							else if($station != "" && $part_family != "" && $part_number != "" && $form_type == "")
							{
								$query = sprintf("SELECT * FROM `form_user_data` where station = '$station' and part_family = '$part_family' and part_number = '$part_number' ");
														
							}
							else
							{
								$query = sprintf("SELECT * FROM `form_user_data` where station = '$station' and part_family = '$part_family' and part_number = '$part_number' and form_type = '$form_type' ");
							}
							
							
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php echo $rowc["form_name"]; ?></td>
									<?php
									$station1 = $rowc['form_type'];
									$qurtemp = mysqli_query($db, "SELECT * FROM  form_type where form_type_id  = '$station1' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
										$station = $rowctemp["form_type_name"];
									}
									?>
                                    <td><?php echo $station; ?></td>
                                    
									<td><?php echo $rowc["created_at"]; ?></td>
									<td><a href="view_user_form_data.php?id=<?php echo $rowc['form_user_data_id']; ?>" class="btn btn-primary" style="background-color:#1e73be;">View Form Data</a></td>
									
									
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                </form>
            </div>

<?php
}
?>


                    <!-- Dashboard content -->
                    <!-- /dashboard content -->
                    <script> $(document).on('click', '#delete', function () {
                            var element = $(this);
                            var del_id = element.attr("data-id");
                            var info = 'id=' + del_id;
                            $.ajax({type: "POST", url: "ajax_job_title_delete.php", data: info, success: function (data) { }});
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
                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->
    </div>
    <!-- /page container -->

<script>
	$('#station').on('change', function (e) {
$("#user_form").submit();
});
		$('#part_family').on('change', function (e) {
$("#user_form").submit();
});
</script>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
		
		$(document).on("click",".submit_btn",function() {

var station = $("#station").val();
var part_family = $("#part_family").val();
var part_number = $("#part_number").val();
var form_type = $("#form_type").val();
var flag= 0;
if(station == null){
	$("#error1").show();
	var flag= 1;
}
if(part_family == null){
	$("#error2").show();
	var flag= 1;
}
if(part_number == null){
	$("#error3").show();
	var flag= 1;
}
if(form_type == null){
	$("#error4").show();
	var flag= 1;
}
if (flag == 1) {
       return false;
       }

    });
		
    </script>
        <?php include ('../footer.php') ?>
</body>
</html>
