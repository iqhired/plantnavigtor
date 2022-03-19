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
        <title><?php echo $sitename; ?> | Approval List</title>
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
<?php $cam_page_header = "Approval List ";
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
				<?php if(($is_tab_login || $is_cell_login)){include("../tab_menu.php");}else{
                    include("../admin_menu.php");}  ?>
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
<?php
                                if (!empty($_SESSION[import_status_message])) {
                                ?>                      
					  <div class="panel panel-flat">
                            <div class="panel-heading">
<?php 															
                                
                                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                    $_SESSION['message_stauts_class'] = '';
                                    $_SESSION['import_status_message'] = '';
?>
                            </div>
                        </div>
  <?php                              }
                                ?>

                        <!-- Basic datatable -->
   
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
							$usid = $_SESSION["id"];
							$querygrp = sprintf("SELECT * FROM `sg_user_group` where user_id = '$usid' ");
							$qurgrp = mysqli_query($db, $querygrp);
							$i = 0;
							while ($rowcgrp = mysqli_fetch_array($qurgrp)) {
								$grp = $rowcgrp['group_id'];
								
							$query = sprintf("SELECT * FROM `form_approval` where approval_status = '1' and approval_dept = '$grp' ");
							$qur = mysqli_query($db, $query);
							
							while ($rowc = mysqli_fetch_array($qur)) {
								$form_user_dataid = $rowc['form_user_data_id'];
								
									$qur04 = mysqli_query($db, "SELECT * FROM  form_user_data where form_user_data_id= '$form_user_dataid' ");
									$rowc04 = mysqli_fetch_array($qur04);
									$form_create_id = $rowc04["form_name"];

								
								
								?>
                                <tr>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php echo $rowc04["form_name"]; ?></td>
									<?php
									$station1 = $rowc04['form_type'];
									$qurtemp = mysqli_query($db, "SELECT * FROM  form_type where form_type_id  = '$station1' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
										$station = $rowctemp["form_type_name"];
									}
									?>
                                    <td><?php echo $station; ?></td>
                                    
									<td><?php echo $rowc["created_at"]; ?></td>
									<td><a href="approval.php?id=<?php echo $rowc04['form_user_data_id']; ?>&approval_id=<?php echo $rowc['form_approval_id']; ?>" class="btn btn-primary" style="background-color:#1e73be;">View Form</a></td>
									
									
                                </tr>
							<?php 
							
							}
							}
							?>
                            </tbody>
                        </table>
                </form>
            </div>




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
