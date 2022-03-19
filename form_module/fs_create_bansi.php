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
		<?php echo $sitename; ?> | User Form</title>
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
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
	<script type="text/javascript" src="../assets/js/pages/gallery.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
 </head>

<body>
<!-- Main navbar -->
<?php
$cam_page_header = "Create Form";
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
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Main charts -->
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">User Form</h5>
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
                        <hr/>
                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $rowc['sg_communicator_config_id']; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="fs_backend.php" id="form_settings" enctype="multipart/form-data" class="form-horizontal" method="post">
                                    
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Form Type : </label>
                                        <div class="col-md-6">
                                            <select name="form_type" id="form_type" class="select-border-color" >
                                                <option value="" selected disabled>--- Select Form Type ---</option>
												<?php
												$sql1 = "SELECT * FROM `form_type` ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['form_type_id'] . "'  >" . $row1['form_type_name'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Station : </label>
                                        <div class="col-md-6">
                                            <select name="station" id="station" class="select-border-color" >
                                                <option value="" selected disabled>--- Select Station ---</option>
												<?php
												$sql1 = "SELECT * FROM `cam_line` ORDER BY `line_name` ASC";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Part Family : </label>
                                        <div class="col-md-6">
                                            <select name="part_family" id="part_family" class="select-border-color" >
                                                <option value="" selected disabled>--- Select Part Family ---</option>
												<?php
												$sql1 = "SELECT * FROM `pm_part_family` ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['pm_part_family_id'] . "'  >" . $row1['part_family_name'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Part Number : </label>
                                        <div class="col-md-6">
                                            <select name="part_number" id="part_number" class="select-border-color" >
                                                <option value="" selected disabled>--- Select Part Number ---</option>
												<?php
												$sql1 = "SELECT * FROM `pm_part_number` ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['pm_part_number_id'] . "'  >" . $row1['part_number'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
										<div class="col-lg-3 col-sm-6">
											<div class="thumbnail">
												<div class="thumb">
													<img src="../assets/images/demo/flat/1.png" alt="">
													<div class="caption-overflow">
														<span>
															<a href="../assets/images/demo/flat/1.png" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>
															
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-sm-6">
											<div class="thumbnail">
												<div class="thumb">
													<img src="../assets/images/demo/flat/1.png" alt="">
													<div class="caption-overflow">
														<span>
															<a href="../assets/images/demo/flat/1.png" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>
															
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
                                    <br/>
                                    
									<hr/>
								<div class="row">
                                        <label class="col-lg-6 control-label"><h2>Form Information</h2> </label>
                                </div>	
								<hr/>	
								<?php
                                            $query = sprintf("SELECT * FROM  form_item where form_create_id = '15'");
                                            $qur = mysqli_query($db, $query);
                                            while ($rowc = mysqli_fetch_array($qur)) {
												$item_val = $rowc['item_val'];
												
                                if($item_val == "header"){
									
								?>
								<div class="row">
                                        <label class="col-lg-6 control-label"><h4><b><u><?php echo $rowc['item_desc']; ?></b></u></h4> </label>
                                </div>
											<?php }
								if($item_val == "numeric")
								{		
											?>		
								
								<div class="row">
                                        <label class="col-lg-4 control-label"><?php echo $rowc['item_desc']; ?> </label>
                                        <div class="col-md-4">
                                            <input type="text" name="answer" id="answer" class="form-control"> </div>
                                </div><br/>	
								<?php 
								}
								if($item_val == "binary"){
								?>								
								<div class="row">
									<div class="col-md-4">
									<label for="default"><?php echo $rowc['item_desc']; ?></label>
									</div>
									
									<div class="col-md-6">
										<div class="form-check form-check-inline">
										<input type="radio" id="yes" name="binary" value="<?php echo $rowc['binary_yes_alias']; ?>" class="form-check-input"> 
										<label for="yes" class="item_label"><?php echo $rowc['binary_yes_alias']; ?></label> 
										<input type="radio" id="no" name="binary" value="<?php echo $rowc['binary_no_alias']; ?>" class="form-check-input">
										<label for="no" class="item_label"><?php echo $rowc['binary_no_alias']; ?></label>
										</div>
									</div>
								</div>
									<br/>
								<?php  } 
								if($item_val == "text"){

								?>	
								<div class="row">
                                        <label class="col-lg-4 control-label"><?php echo $rowc['item_desc']; ?> </label>
                                        <div class="col-md-4">
                                            <input type="text" name="text" id="text" class="form-control"> </div>
                                </div><br/>
								<?php
									} 
								}
								?>
<hr/>
								<div class="row">
                                        <label class="col-lg-6 control-label"><h2>Approval List</h2> </label>
                                </div>
								
								<div class="row">
                                
								    <label class="col-lg-3 control-label"><h4><b><u>Department</u></b></h4> </label>
								    <label class="col-lg-3 control-label"><h4><b><u>Approvar Initials</u></b></h4> </label>
								    <label class="col-lg-3 control-label"><h4><b><u>Passcode / Pin</u></b></h4> </label>
                                
								</div>
								
								
								
								<?php
                                            $query1 = sprintf("SELECT * FROM  form_create where form_create_id = '15'");
                                            $qur1 = mysqli_query($db, $query1);
											$i = 0;
                                            while ($rowc1 = mysqli_fetch_array($qur1)) {
												$approval_by_array = $rowc1['approval_by'];
											$arrteam = explode(',', $approval_by_array );
                                            
								foreach ($arrteam as $arr) {
    							if($arr != ""){						
								?>
								<div class="row">
									<?php
										$qurtemp = mysqli_query($db, "SELECT group_name FROM `sg_group` where group_id = '$arr' ");
                                        $rowctemp = mysqli_fetch_array($qurtemp);
										$groupname = $rowctemp["group_name"]
                                                                    
									?>
									<label class="col-lg-3 control-label"><h4><?php echo $groupname; ?></h4> </label>	
									<div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="select-border-color" data-placeholder="Add Teams..."  name="teams[]" id="teams"  >
                                                                <?php
                                                                $sql1 = "SELECT * FROM `sg_user_group` where group_id = '$arr'";
                                                                $result1 = $mysqli->query($sql1);
                                                                while ($row1 = $result1->fetch_assoc()) {
                                                                    
                                                                    $user_id = $row1['user_id'];
                                                                    $qurtemp = mysqli_query($db, "SELECT firstname,lastname FROM `cam_users` where users_id = '$user_id' ");
                                                                    $rowctemp = mysqli_fetch_array($qurtemp);
                                                                    $fullnn = $rowctemp["firstname"]." ".$rowctemp["lastname"]; 
                                                                    echo "<option value='" . $user_id . "' >" . $fullnn . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>	
                                    </div>
									<div class="col-md-3">
                                            <input type="number" name="pin" id="pin" class="form-control" placeholder="Enter Pin..." required> 
									</div>
								</div>
								<?php
											} }
								     }
								?>
								
								
								<div class="row">
										<input type="hidden" name="click_id" id="click_id" >
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Submit</button>
                                        </div>
                                    </div>
                                    <br/> </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /main charts -->
                <!-- edit modal -->
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

<script>
    function submitFormSettings(url) {
        //          $(':input[type="button"]').prop('disabled', true);
        var data = $("#form_settings").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(data) {
                // $("#textarea").val("")
                // window.location.href = window.location.href + "?aa=Line 1";
                //                   $(':input[type="button"]').prop('disabled', false);
                //                   location.reload();
                //$(".enter-message").val("");
            }
        });
    }
</script>
<?php include ('../footer.php') ?>
</body>

</html>