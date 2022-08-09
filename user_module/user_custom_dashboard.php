<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
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
$array_station = $_POST['menu_value'];
$user_id = $_SESSION["id"];
if(isset($array_station) && count($array_station) > 0) {
    $line_str = '';
    foreach ($array_station as $station) {
        $line_str .= $station . ',';
    }
    $sqlquery = "update `cam_users` set is_cust_dash=1 , line_cust_dash = '$line_str' where users_id = '$user_id'";
    if (!mysqli_query($db, $sqlquery)) {
        $message_stauts_class = 'alert-danger';
        $import_status_message = 'Error: Unable to update Stations. Please try after sometime';
    } else {
        $temp = "one";
        $_SESSION['line_cust_dash'] = $line_str;
        $_SESSION['is_cust_dash'] = 1;
        $line_cust_dash_arr = explode(',', $line_str);
    }
}
else {
    $sqlquery = "update `cam_users` set is_cust_dash = 0 , line_cust_dash = '' where users_id = '$user_id'";
    if (mysqli_query($db, $sqlquery)) {
        $_SESSION['is_cust_dash'] = 0;
        $_SESSION['line_cust_dash'] = '';
        $message_stauts_class = 'alert-success';
        $import_status_message = 'Custom Dashboard Settings updated Successfully';
    } else {
        $message_stauts_class = 'alert-danger';
        $import_status_message = 'Error updating Custom Dashboard Settings. Try after sometime.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $sitename; ?> | Custom Dashboard</title>
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
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
	<style>
		.sidebar-default .navigation li>a{color:#f5f5f5};
		a:hover {
			background-color: #20a9cc;
		}
		.sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
			background-color: #20a9cc;
		}
		.red{
			color:red;
		}
	</style>
</head>
<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Custom Dashboard Settings";
include("../header_folder.php");
include("../heading_banner.php");
include("../admin_menu.php");
?>
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
						<h5 class="panel-title">Select Station(s) for Custom Dashboard</h5>
						<hr/>
						<form action="" id="user_form" class="form-horizontal" method="post" style="padding: 15px;">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div id="error1" class="red" style="display:none;color:red;">Please select Station</div>
										<div class="row">
											<div id="error1" class="red" style="display:none;color:red;">Please select Module</div>
											<?php
											$query12 = sprintf("SELECT * FROM  cam_line where enabled = 1 order by line_name ASC");
											$qur12 = mysqli_query($db, $query12);
											while ($rowc12 = mysqli_fetch_array($qur12)) {
												$parentid = $rowc12["line_id"];

												?>
												<div class="col-md-3 rmchk">
													<div class="checkbox">
														<label>
															<input type="checkbox" class="control-primary chk_menu" name="menu_value[]" id="<?php echo $parentid; ?>" value="<?php echo $parentid; ?>"  <?php if(in_array("$parentid", $line_cust_dash_arr)){echo "checked";}?> >
															<?php echo $rowc12["line_name"]; ?>
														</label>
													</div>
												</div>
												<?php
											}
											?>

										</div>
										<div class="row" style="margin-top: 25px;">
											<div class="col-md-4">
												<button type="submit" class="btn btn-primary create" style="background-color:#1e73be;">Save</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>


						<?php if ($temp == "one") { ?>
							<br/>					<div class="alert alert-success no-border">
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
								<span class="text-semibold">Stations</span> Updated Successfully.
							</div>
						<?php } ?>
						<?php if ($temp == "two") { ?>
							<br/>					<div class="alert alert-success no-border">
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
								<span class="text-semibold">Stations</span> Updated Successfully.
							</div>
						<?php } ?>
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

			</div>
			<!-- /basic datatable -->

<!-- /page content -->
</div>
<!-- /page container -->

<script>
    window.onload = function() {
        $(".control-primary").uniform({
            radioClass: 'choice',
            wrapperClass: 'border-primary-600 text-primary-800'
        });
        $(".control-danger").uniform({
            radioClass: 'choice',
            wrapperClass: 'border-danger-600 text-danger-800'
        });
        history.replaceState("", "", "<?php echo $scriptName; ?>user_module/user_custom_dashboard.php");
    }
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });


</script>
<script>
    $('button[type="submit"]').on('click', function() {
        var flag = 0;
        if($("#name").val().length > 0){

            $("#error2").hide();

        }else{
            var flag = 1;
            $("#error2").show();


        }
        // skipping validation part mentioned above
        //if($('.chk_menu:checkbox:checked').length > 0){
        if($('.checked').length > 0){

            $("#error1").hide();
        }else{
            var flag = 1;
            $("#error1").show();
        }

        if(flag == 0){
            return true;
        }
        else{
            return false;
        }

    });
    $(".chk_menu").click(function() {
        var value_c =   $(this).val();
        if($(this).prop("checked") == true){

            $(".cl"+value_c).show();

        } else {
            var abc = "cl" +value_c+" span";
            //		console.log(abc);
            $(".cl"+value_c).hide();
            $(".cl"+value_c).find('input:checkbox:first').prop('checked', false);
            //  $(".cl"+value_c).prop('checked', false);
            $('.'+ abc).removeClass();

        }
    });


</script>
<?php include ('../footer.php') ?>
</body>
</html>
