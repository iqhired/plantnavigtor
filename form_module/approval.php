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
$i = $_SESSION["role_id"];
//if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
//	header('location: ../dashboard.php');
//}
$ssid = $_SESSION['id'];
$qurpin = mysqli_query($db, "SELECT pin FROM `cam_users` where users_id = '$ssid' ");
													$rowcpin = mysqli_fetch_array($qurpin);
													$password123 = $rowcpin["pin"];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
		<?php echo $sitename; ?> | Approval Form</title>
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
$cam_page_header = "Approval Form";
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
        <div class="content-wrapper" style="padding: 20px;">
            <!-- Page header -->
            <!-- /page header -->
            <!-- Content area -->
            <!-- Main charts -->
            <!-- Basic datatable -->
			<?php
							$id = $_GET['id'];
							
							$querymain = sprintf("SELECT * FROM `form_user_data` where form_user_data_id = '$id' ");
							$qurmain = mysqli_query($db, $querymain);
							while ($rowcmain = mysqli_fetch_array($qurmain)) {
								$formname = $rowcmain['form_name'];
								?>
			
			
            <div class="panel panel-flat form_panel">
                <div class="panel-heading form_panel_heading">
                    <b><h4 class="panel-title form_panel_title"><?php echo $rowcmain['form_name']; ?></h4></b>
					<?php if ($temp == "one") { ?>
                        <br/>
                        <div class="alert alert-success no-border">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                        class="sr-only">Close</span></button>
                            <span class="text-semibold">Group</span> Created Successfully.
                        </div>
					<?php } ?>
					<?php if ($temp == "two") { ?>
                        <br/>
                        <div class="alert alert-success no-border">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                        class="sr-only">Close</span></button>
                            <span class="text-semibold">Group</span> Updated Successfully.
                        </div>
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
                    <div class="row ">
                        <div class="col-md-12">
                            <form action="approval_backend.php" id="form_settings" enctype="multipart/form-data"
                                  class="form-horizontal" method="post">
                                <input type="hidden" name="formid" id="formid" value="<?php echo $_GET['id']; ?>">
								<input type="hidden" name="approvalid" id="approvalid" value="<?php echo $_GET['approval_id']; ?>">

                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Form Type : </label>
                                    <div class="col-md-8">
										<?php
										$get_form_type = $rowcmain['form_type'];
										if ($get_form_type != '') {
											$disabled = 'disabled';
										} else {
											$disabled = '';
										}
										?>

                                        <input type="hidden" name="form_type" id="form_type"
                                               value="<?php echo $get_form_type; ?>">
                                        <select name="form_type1" id="form_type"
                                                class="select-border-color" <?php echo $disabled; ?>>
                                            <option value="" selected disabled>--- Select Form Type ---</option>
											<?php

											$sql1 = "SELECT * FROM `form_type` ";
											$result1 = $mysqli->query($sql1);
											//                                            $entry = 'selected';
											while ($row1 = $result1->fetch_assoc()) {
												if ($get_form_type == $row1['form_type_id']) {
													$entry = 'selected';
												} else {
													$entry = '';
												}
												echo "<option value='" . $row1['form_type_id'] . "'  $entry>" . $row1['form_type_name'] . "</option>";
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Station : </label>
                                    <div class="col-md-8">

										<?php
										$get_station = $rowcmain['station'];
										if ($get_station != '') {
											$disabled = 'disabled';
										} else {
											$disabled = '';
										}
										?>

                                        <input type="hidden" name="station" id="station"
                                               value="<?php echo $get_station; ?>">
                                        <select name="station1" id="station1"
                                                class="select-border-color" <?php echo $disabled; ?>>
                                            <option value="" selected disabled>--- Select Station ---</option>
											<?php
											$sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
											$result1 = $mysqli->query($sql1);
											//                                            $entry = 'selected';
											while ($row1 = $result1->fetch_assoc()) {
												if ($get_station == $row1['line_id']) {
													$entry = 'selected';
												} else {
													$entry = '';
												}
												echo "<option value='" . $row1['line_id'] . "' $entry >" . $row1['line_name'] . "</option>";
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Part Family : </label>
                                    <div class="col-md-8">

										<?php
										$get_part_family = $rowcmain['part_family'];
										if ($get_part_family != '') {
											$disabled = 'disabled';
										} else {
											$disabled = '';
										}
										?>

                                        <input type="hidden" name="part_family" id="part_family"
                                               value="<?php echo $get_part_family; ?>">
                                        <select name="part_family1" id="part_family1"
                                                class="select-border-color" <?php echo $disabled; ?>>
                                            <option value="" selected disabled>--- Select Part Family ---</option>
											<?php
											$sql1 = "SELECT * FROM `pm_part_family` ";
											$result1 = $mysqli->query($sql1);
											//                                            $entry = 'selected';
											while ($row1 = $result1->fetch_assoc()) {
												if ($get_part_family == $row1['pm_part_family_id']) {
													$entry = 'selected';
												} else {
													$entry = '';
												}
												echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Part Number : </label>
                                    <div class="col-md-8">

										<?php
										$get_part_number = $rowcmain['part_number'];
										if ($get_part_number != '') {
											$disabled = 'disabled';
										} else {
											$disabled = '';
										}
										?>

                                        <input type="hidden" name="part_number" id="part_number"
                                               value="<?php echo $get_part_number; ?>">
                                        <select name="part_number1" id="part_number1"
                                                class="select-border-color" <?php echo $disabled; ?>>
                                            <option value="" selected disabled>--- Select Part Number ---</option>
											<?php
											$sql1 = "SELECT * FROM `pm_part_number` ";
											$result1 = $mysqli->query($sql1);
											//                                            $entry = 'selected';
											while ($row1 = $result1->fetch_assoc()) {
												if ($get_part_number == $row1['pm_part_number_id']) {
													$entry = 'selected';
												} else {
													$entry = '';
												}
												echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] . " - " . $row1['part_name'] . "</option>";
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="form_row row">
									<?php 
									
									
								$query1 = sprintf("SELECT form_create_id FROM  form_create where form_type = '$get_form_type' and station = '$get_station' and part_family = '$get_part_family' and part_number = '$get_part_number' and name = '$formname'");
                                            $qur1 = mysqli_query($db, $query1);
								$rowc1 = mysqli_fetch_array($qur1);
								$item_id = $rowc1['form_create_id'];
										
										  $qurimage = mysqli_query($db, "SELECT * FROM  form_images where form_create_id = '$item_id'");
                                            while ($rowcimage = mysqli_fetch_array($qurimage)) {
											
									
									?>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="thumbnail">
                                                <div class="thumb">
                                                    <img src="../form_images/<?php echo $rowcimage['image_name']; ?>"
                                                         alt="">
                                                    <div class="caption-overflow">
														<span>
															<a href="../form_images/<?php echo $rowcimage['image_name']; ?>"
                                                               data-popup="lightbox" rel="gallery"
                                                               class="btn border-white text-white btn-flat btn-icon btn-rounded"><i
                                                                        class="icon-plus3"></i></a>
															
														</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

									<?php } ?>
                                </div>
                                <b><h4 class="panel-title form_panel_title">Form Information</h4></b>



								<?php
								
                                            $query = sprintf("SELECT * FROM  form_item where form_create_id = '$item_id'");
                                            $qur = mysqli_query($db, $query);
											$aray_item_cnt = 0;
											$arrteam = explode(',', $rowcmain["form_user_data_item"]);
                                            while ($rowc = mysqli_fetch_array($qur)) {
												$item_val = $rowc['item_val'];
												
                                if($item_val == "header"){
									
								?>
                                        <div class="row form_row_item">
                                            <b><h4 class="panel-title form_sub_header"><?php echo $rowc['item_desc']; ?></h4></b>
                                        </div>
									<?php }
									if ($item_val == "numeric") {
										$checked = $arrteam[$aray_item_cnt];
										?>
                                        <div class="row form_row_item">
                                            <div class="col-md-4 form_col_item"><?php echo $rowc['item_desc']; ?> </div>
                                            <div class="col-md-4 ">
											
                                                <input type="text" name="<?php echo $rowc['form_item_id']; ?>" 
                                                       id="<?php echo $rowc['form_item_id']; ?>" class="form-control compare_text" value="<?php echo $checked; ?>"  disabled>
                                            </div>
                                           
                                        </div>
										<?php 
								$aray_item_cnt++;
								}
								if($item_val == "binary"){
									$checked = $arrteam[$aray_item_cnt];
								?>	
									    <div class="row form_row_item">
                                            <div class="col-md-4 form_col_item"><?php echo $rowc['item_desc']; ?> </div>


                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline form_col_option">
                                                    <input type="radio" disabled id="yes"
                                                           name="<?php echo $rowc['form_item_id']; ?>"
                                                           value="yes"
                                                           class="form-check-input" <?php if($checked == "yes"){ echo 'checked'; } ?>>
                                                    <label for="yes"
                                                           class="item_label <?php echo $rowc['form_item_id']; ?>""
														   id="<?php echo $rowc['form_item_id']; ?>"><?php echo $rowc['binary_yes_alias']; ?></label>
                                                    <input type="radio" disabled id="no"
                                                           name="<?php echo $rowc['form_item_id']; ?>"
                                                           value="no"
                                                           class="form-check-input" <?php if($checked == "no"){ echo 'checked'; } ?>>
                                                    <label for="no"
                                                           class="item_label <?php echo $rowc['form_item_id']; ?>""
														   id="<?php echo $rowc['form_item_id']; ?>"><?php echo $rowc['binary_no_alias']; ?></label>
                                                </div>
                                            </div>
                                        </div>
									<?php
								$aray_item_cnt++;
								
								} 
								if($item_val == "text"){

								?>	
                                        <div class="row form_row_item">
                                            <div class="col-md-4 form_col_item"><?php echo $rowc['item_desc']; ?> </div>
                                            <div class="col-md-4">
                                                <input type="hidden" name="form_item_array[]"
                                                       value="<?php echo $rowc['form_item_id']; ?>">
                                                <input type="text" name="<?php echo $rowc['form_item_id']; ?>"
                                                       id="<?php echo $rowc['form_item_id']; ?>" class="" value="<?php echo $arrteam[$aray_item_cnt]; ?>">
                                            </div>
                                        </div>
										<?php
								$aray_item_cnt++;
								
									} 
								}
								?>
                                <hr class="form_hr"/>
                                
                                <br/>
                                <!-- Approval List-->
							
								
                                    <b><h4 class="panel-title form_panel_title">Approval List</h4></b>
                                    <table class="form_table">
                                        <tr class="form_tab_tr">
                                            <th class="form_tab_th">Department</th>
                                            <th class="form_tab_th">Approver Initials</th>
                                            <th class="form_tab_th">Passcode / Pin</th>
                                        </tr>
									<?php
									$query1 = sprintf("SELECT * FROM  form_create where form_create_id = '$item_id' and need_approval = 'yes'");
									$qur1 = mysqli_query($db, $query1);
									$i = 0;
									while ($rowc1 = mysqli_fetch_array($qur1)) {
										$approval_by_array = $rowc1['approval_by'];
										$arrteam = explode(',', $approval_by_array);

										foreach ($arrteam as $arr) {
											if ($arr != "") {
												$ussid = $_SESSION['id'];
												$groupid = "";				
												$qurtemp = mysqli_query($db, "SELECT * FROM `sg_user_group` where group_id = '$arr' and user_id = '$ussid' ");
													$rowctemp = mysqli_fetch_array($qurtemp);
													$groupid = $rowctemp["group_id"];

												if($groupid != ""){
												?>
                                                <tr class="form_tab_tr">
													<?php
													$qurtemp = mysqli_query($db, "SELECT group_name FROM `sg_group` where group_id = '$arr' ");
													$rowctemp = mysqli_fetch_array($qurtemp);
													$groupname = $rowctemp["group_name"];

													?>
                                                    <td class="form_tab_td">
                                                    <input type="hidden" name="approval_dept[]"
                                                           value="<?php echo $arr; ?>">
                                                        <?php echo $groupname; ?>
                                                    </td>
                                                    <td class="form_tab_td">
                                                        <select class="select-border-color" name="approval_initials[]"
                                                                id="app" disabled>
                                                            <option value="" selected disabled>--- Select Approver ---
                                                            </option>
															<?php
															$sql1 = "SELECT * FROM `sg_user_group` where group_id = '$arr' ";
															$result1 = $mysqli->query($sql1);
															while ($row1 = $result1->fetch_assoc()) {

																$user_id = $row1['user_id'];
																if($user_id == $ussid)
																{
																$qurtemp = mysqli_query($db, "SELECT users_id,firstname,lastname FROM `cam_users` where users_id = '$ussid' and pin_flag = '1' ");
																$rowctemp = mysqli_fetch_array($qurtemp);
																if ($rowctemp != NULL) {
																	
																	$fullnn = $rowctemp["firstname"] . " " . $rowctemp["lastname"];

																	echo "<option value='" . $user_id . "' selected >" . $fullnn . "</option>";
																}
																$fullnm = "";
																}
															}
															?>
                                                        </select>
                                                    </td>
                                                    <td class="form_tab_td">
                                                        <input type="number" name="pin" id="pin" class="form-control"
                                                               placeholder="Enter Pin...">
                                                    </td>
                                                </tr>
												<?php
											} }
										}
									}
									?>
                                    </table>
                                        
                                <br/>
								
								<div class="row form_row_item">
                                    <input type="hidden" name="click_id" id="click_id">
                                    <div class="col-md-2">
									<input type="hidden" id="passcode_txt" value="<?php echo $password123; ?>">
                                        <button type="submit" class="btn btn-primary submit_btn" style="background-color:#1e73be;">
                                            Submit
                                        </button>
                                    </div>
                                </div>
								
								</form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /main charts -->
            <!-- edit modal -->
            <!-- Dashboard content -->
            <!-- /dashboard content -->
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
							<?php } ?>	
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
            success: function (data) {
                // $("#textarea").val("")
                // window.location.href = window.location.href + "?aa=Line 1";
                //                   $(':input[type="button"]').prop('disabled', false);
                //                   location.reload();
                //$(".enter-message").val("");
            }
        });
    }
		$(".compare_text").keyup(function () {
	var text_id = $(this).attr("id");
	var lower_compare = parseInt($( ".lower_compare[data-id='" + text_id + "']" ).val());
	var upper_compare = parseInt($( ".upper_compare[data-id='" + text_id + "']" ).val());
var text_val = $(this).val();

                if ($(".compare_text").val().length == 0) {
				               $(this).css("background-color", "white");
                    return false;
                }else{
					if($.isNumeric(text_val)){
					
				if(text_val >= lower_compare && text_val <= upper_compare){
				 $(this).css("background-color", "green");
				}else{
				 $(this).css("background-color", "red");
				}
				}
		}
                
            });
			
			//passcode_txt
			$("#pin").keyup(function () {
				
				var passcode = $(this).val();
				var password = parseInt($("#passcode_txt").val());
				
				if(passcode == password ){
					$(".submit_btn").attr("disabled", false);
					
				}else{
					$(".submit_btn").attr("disabled", true);
					
				}
				
			});
			
			        $("input:radio").click(function(){
						var radio_id = $(this).attr("name");
						var binary_compare = $( ".binary_compare[data-id='" + radio_id + "']" ).val();
	
						
				var exact_val =	$('input[name="'+ radio_id +'"]:checked').val();


			if( exact_val == binary_compare ){
              $("."+radio_id).css("background-color", "green");
            }
			else{
				 $("."+radio_id).css("background-color", "red");
			}

            
            




        })
			
			
</script>
<?php include('../footer.php') ?>
</body>





</html>