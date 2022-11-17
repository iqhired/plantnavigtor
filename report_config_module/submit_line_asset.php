<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
		header($redirect_tab_logout_path);
	} else {
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
	if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
		header($redirect_tab_logout_path);
	} else {
		header($redirect_logout_path);
	}

//	header('location: ../logout.php');
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1) {
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
	<title><?php echo $sitename; ?> |Submit Line Asset</title>
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
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

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
<body onload="openScanner()">
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Submit Station Asset";
include("../header_folder.php");
include("../admin_menu.php");
include("../heading_banner.php");
if ($is_tab_login || ($_SESSION["role_id"] == "pn_user")) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}
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
				<h5 class="panel-title">Submit Station Asset</h5><br/>
				<div class="row">
					<div class="col-md-12">
						<form action="submit_image_backend.php" id="asset_update" enctype="multipart/form-data"
							  class="form-horizontal" method="post">
							<?php $id = $_GET['assets_id'];
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
                                <input type="hidden" name="asset_id" id="asset_id" class="form-control"
                                       value="<?php echo $id; ?>" >
								<div class="row">
									<label class="col-lg-2 control-label">Asset Name : </label>
									<div class="col-md-6">
										<input type="text" name="asset_name" id="asset_name" class="form-control"
											   value="<?php echo $asset_name; ?>"></div>
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
                                        <select name="station" id="station" class="select form-control" data-style="bg-slate">
                                            <option value="" selected>--- Select Station ---</option>
                                            <?php
                                            $querymain = sprintf("SELECT * FROM `station_assests` where asset_id = '$id' ");
                                            $qurmain = mysqli_query($db, $querymain);
                                            while ($rowcmain = mysqli_fetch_array($qurmain)) {
                                                $line_id = $rowcmain['line_id'];

                                            }
                                            $sql1 = "SELECT * FROM `cam_line`  where enabled = '1' and is_deleted != 1 ORDER BY `line_name` ASC";
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if($line_id == $row1['line_id'])
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
                                    </div>
								</div>
								<br/>

							<?php } ?>
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
                                    <div class="container"></div>
									<?php
									$time_stamp = $_SESSION['assets_timestamp_id'];
									if(!empty($time_stamp)){
										$query2 = sprintf("SELECT * FROM station_assets_images where station_asset_id = '$time_stamp'");

										$qurimage = mysqli_query($db, $query2);
										$i =0 ;
										while ($rowcimage = mysqli_fetch_array($qurimage)) {
											$image = $rowcimage['station_asset_image'];
                                            $mime_type = "image/gif";
                                            $file_content = file_get_contents("$image");
                                            $d_tag = "delete_image_" . $i;
                                            $r_tag = "remove_image_" . $i;
											?>

											<div class="col-lg-3 col-sm-6">
												<div class="thumbnail">
													<div class="thumb">
                                                        <?php echo '<img src="data:image/gif;base64,' . $image . '" style="height:150px;width:150px;" />'; ?>
														<input type="hidden"  id="<?php echo $d_tag; ?>" name="<?php echo $d_tag; ?>" class="<?php echo $d_tag; ?>>" value="<?php echo $rowcimage['asset_images_id']; ?>">
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
                            <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label">Notes : </label>
                                <div class="col-md-6">
                                    <textarea id="notes"  name="notes"  rows="4" placeholder="Enter Notes..." class="form-control"></textarea>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>
    Webcam.set({
        width: 290,
        height: 190,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    var camera = document.getElementById("my_camera");
    Webcam.attach( camera );
</script>
<script>
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            var formData =  $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            $.ajax({
                url: "assets_cam_backend.php",
                type: "POST",
                data: formData,
                success: function (msg) {
                    window.location.reload()
                },

            });
        } );
    }
</script>

<script>
    // Upload
    $("#file").on("change", function () {
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file', files);
        fd.append('request', 1);

        // AJAX request
        $.ajax({
            url: 'add_delete_assets_image.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response != 0) {
                    var count = $('.container .content_img').length;
                    count = Number(count) + 1;

                    // Show image preview with Delete button
                    $('.container').append("<div class='content_img' id='content_img_" + count + "' ><img src='" + response + "' width='100' height='100'><span class='delete' id='delete_" + count + "'>Delete</span></div>");
                }
            }
        });
    });


    // Remove file
    $('.container').on('click', '.content_img .delete', function () {

        var id = this.id;
        var split_id = id.split('_');
        var num = split_id[1];
        // Get image source
        var imgElement_src = $('#content_img_' + num)[0].children[0].src;
        //var deleteFile = confirm("Do you really want to Delete?");
        var succ = false;
        // AJAX request
        $.ajax({
            url: 'add_delete_assets_image.php',
            type: 'post',
            data: {path: imgElement_src, request: 2},
            async: false,
            success: function (response) {
                // Remove <div >
                if (response == 1) {
                    succ = true;
                }
            }, complete: function (data) {
                if (succ) {
                    var id = 'content_img_' + num;
                    // $('#content_img_'+num)[0].remove();
                    var elem = document.getElementById(id);
                    document.getElementById(id).style.display = 'none';
                    var nodes = $(".container")[2].childNodes;
                    for (var i = 0; i < nodes.length; i++) {
                        var node = nodes[i];
                        if (node.id == id) {
                            node.style.display = 'none';
                        }
                    }
                }
            }
        });
    });

</script>

<script>
    $(document).on('click', '.remove_image', function () {
        var del_id = this.id.split("_")[2];
        var x_img_id = this.parentElement.childNodes[3].value;
        var info =  document.getElementById("delete_image"+del_id);
        var info =  "id="+del_id+"&station_asset_id="+ x_img_id;
        $.ajax({
            type: "POST",
            url: "delete_assets_image.php",
            data: info,
            success: function (data) {
            }
        });
        location.reload(true);
    });
</script>

<script>
    $(document).ready(function () {
        $('.select').select2();
    });


</script>
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>report_config_module/submit_line_asset.php?assets_id=<?php echo $id; ?>");
    }
</script>
<?php include ('../footer.php') ?>
</body>
</html>

