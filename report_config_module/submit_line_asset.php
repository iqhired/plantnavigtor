<?php
include("../config.php");
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
$asset_ide = $_GET['asset_id'];

if(empty($_SESSION['$asset_id'])){
	$_SESSION['timestamp_id'] = time();
}

$x_timestamp = time();
$idd = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
	, $_SERVER["HTTP_USER_AGENT"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $sitename; ?> |Edit Station Assets Config</title>
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
	<script type="text/javascript" src="../assets/js/core/app.js"></script>
	<script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
	<!--scan the qrcode -->

	<style>
		.sidebar-default .navigation li>a{color:#f5f5f5};
		a:hover {
			background-color: #20a9cc;
		}
		.sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
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
		}  @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
			.col-sm-2 {
				width: 10.66666667%;
			}
			.col-lg-2 {
				width: 28%!important;
				float: left;
			}
			.col-md-6 {
				width: 60%;
				float: left;
			}
			.col-lg-1 {
				width: 12%;
				float: right;
			}
		}
		input[type="file"] {
			display: block;
		}

		.container {
			margin: 0 auto;
		}

		.content_img {
			width: 113px;
			float: left;
			margin-right: 5px;
			border: 1px solid gray;
			border-radius: 3px;
			padding: 5px;
			margin-top: 10px;
		}

		/* Delete */
		.content_img span {
			border: 2px solid red;
			display: inline-block;
			width: 99%;
			text-align: center;
			color: red;
		}

		.content_img span:hover {
			cursor: pointer;
		}
		#results { padding:20px; border:1px solid; background:#ccc; }
	</style>
</head>
<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Edit Station Assets Config";
include("../header_folder.php");
include("../admin_menu.php");
include("../heading_banner.php");
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
				<h5 class="panel-title">Edit Station Assets Config</h5><br/>
				<div class="row">
					<div class="col-md-12">
						<form action="" id="asset_update" enctype="multipart/form-data"
							  class="form-horizontal" method="post">
                            <iframe height="100" id="resultFrame" style="" src="./../qr.php"></iframe>
							<div id="qr-reader" style="width: 600px"></div>


							<?php $id = $_GET['qr-reader'];
							$querymain = sprintf("SELECT * FROM `station_assests` where asset_id = '$id' ");
							$qurmain = mysqli_query($db, $querymain);
							while ($rowcmain = mysqli_fetch_array($qurmain)) {
								$asset_name = $rowcmain['asset_name'];
								$line_id = $rowcmain['line_id'];
								$created_date = $rowcmain['created_date'];
								$created_time = $rowcmain['created_time'];
								$created_by = $rowcmain['created_by'];
								$qrcode = $rowcmain['qrcode'];
								?>
								<div class="row">
									<label class="col-lg-2 control-label">Asset Name : </label>
									<div class="col-md-6">
										<input type="text" name="asset_name" id="asset_name" class="form-control"
											   value="<?php echo $asset_name; ?>"
											   disabled></div>
								</div>
								<br/>
								<div class="row">
									<label class="col-lg-2 control-label">Station Name : </label>
									<div class="col-md-6">
										<?php
										$qurtemp = mysqli_query($db, "SELECT * FROM cam_line where line_id = '$line_id' ");
										$rowctemp = mysqli_fetch_array($qurtemp);
										$line_name = $rowctemp["line_name"];
										?>
										<input type="text" name="station" id="station" class="form-control"
											   value="<?php echo $line_name; ?>"
											   disabled></div>
								</div>
								<br/>
								<div class="row">
									<label class="col-lg-2 control-label">Created Date : </label>
									<div class="col-md-6">
										<input type="text" name="c_date" id="c_date" class="form-control"
											   value="<?php echo $created_date .' - '. $created_time; ?>"
											   disabled></div>
								</div>
								<br/>
								<div class="row">
									<label class="col-lg-2 control-label">Created By : </label>
									<div class="col-md-6">
										<?php
										$qurtemp1 = mysqli_query($db, "SELECT * FROM cam_users where users_id = '$created_by' ");
										$rowctemp1 = mysqli_fetch_array($qurtemp1);
										$user_name = $rowctemp1["firstname"] .' - '. $rowctemp1["lastname"];
										?>
										<input type="text" name="c_by" id="c_by" class="form-control"
											   value="<?php echo $user_name; ?>"
											   disabled></div>
								</div>
								<br/>
								<div class="row">
									<label class="col-lg-2 control-label">QR Code : </label>
									<div class="col-md-6">
										<?php echo '<img src="data:image/gif;base64,' . $qrcode . '" style="height:150px;width:150px;" />'; ?>
									</div>
								</div>
								<br/>
							<?php } ?>
							<br/>
							<div class="row">
								<label class="col-lg-2 control-label">Notes : </label>
								<div class="col-md-6">
									<textarea id="notes"   name="10x_notes"   rows="4"    placeholder="Enter Notes..." class="form-control"></textarea>
								</div>
							</div>
							<br/>
							<div class="row">
								<label class="col-lg-2 control-label">Image : </label>
								<div class="col-md-6">
									<?php if(($idd == 0)){?>
										<div id="my_camera"></div>
										<br/>
										<input type=button class="btn btn-primary" value="Take Snapshot" onClick="take_snapshot()">
										<input type="hidden" name="image" id="image" class="image-tag" accept="image/*,capture=camera"/>
									<?php } ?>
									<?php if(($idd != 0)){?>
										<div style="display:none;" id="my_camera"></div>
										<label for="file" class="btn btn-primary ">Take Snapshot</label>
										<input type="file" name="image" id="file" class="image-tag" multiple accept="image/*;capture=camera" capture="environment" value="Take Snapshot" style="display: none"/>
										<div class="container"></div>
									<?php } ?>
								</div>
							</div>
							<div class="row" style="display: none">
								<label class="col-lg-2 control-label">Captured Image : </label>
								<div class="col-md-6">
									<div id="results"></div>
								</div>
							</div>
							<br/>
							<div class="row">
								<label class="col-lg-2 control-label">Previous Image : </label>
								<div class="col-md-6">
									<?php
									$time_stamp = $_SESSION['timestamp_id'];
									if(!empty($time_stamp)){
										$query2 = sprintf("SELECT * FROM assets_images order by created_at desc limit 1");

										$qurimage = mysqli_query($db, $query2);
										$i =0 ;
										while ($rowcimage = mysqli_fetch_array($qurimage)) {
											$image = $rowcimage['image_name'];
											$d_tag = "delete_image_" . $i;
											$r_tag = "remove_image_" . $i;
											?>

											<div class="col-lg-3 col-sm-6">
												<div class="thumbnail">
													<div class="thumb">
														<img src="../assets/images/assets_images/<?php echo $image; ?>"
															 alt="">
														<input type="hidden"  id="<?php echo $d_tag; ?>" name="<?php echo $d_tag; ?>" class="<?php echo $d_tag; ?>>" value="<?php echo $rowcimage['image_name']; ?>">
														<span class="remove remove_image" id="<?php echo $r_tag; ?>">Remove Image </span>
													</div>
												</div>
											</div>
											<?php
											$i++;}
									}
									?>
								</div>
							</div>
							<hr/>

					</div>
				</div>
			</div>


			<div class="panel-footer p_footer">

				<button type="submit" id="form_submit_btn" class="btn btn-primary submit_btn"
						style="background-color:#1e73be;">Submit
				</button>

			</div>
			</form>
		</div>
	</div>

</div>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>-->
<!--<script>-->
<!--    Webcam.set({-->
<!--        width: 290,-->
<!--        height: 190,-->
<!--        image_format: 'jpeg',-->
<!--        jpeg_quality: 90-->
<!--    });-->
<!--    var camera = document.getElementById("my_camera");-->
<!--    Webcam.attach( camera );-->
<!--</script>-->
<!--<script>-->
<!--    function take_snapshot() {-->
<!--        Webcam.snap( function(data_uri) {-->
<!--            var formData =  $(".image-tag").val(data_uri);-->
<!--            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';-->
<!--            $.ajax({-->
<!--                url: "assets_cam_backend.php",-->
<!--                type: "POST",-->
<!--                data: formData,-->
<!--                success: function (msg) {-->
<!--                    window.location.reload()-->
<!--                },-->
<!---->
<!--            });-->
<!--        } );-->
<!--    }-->
<!--</script>-->

<script>
    $(document).ready(function () {
        $('.select').select2();
    });


</script>
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>report_config_module/submit_line_asset.php");
    }
</script>
<?php include ('../footer.php') ?>
</body>
</html>

