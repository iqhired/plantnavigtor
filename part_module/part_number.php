<?php include("../config.php");
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
$assign_by = $_SESSION["id"];

if (count($_POST) > 0) {
	$name = $_POST['part_number'];
	$part_name = $_POST['part_name'];
	$customer_part_number = $_POST['customer_part_number'];
	$station = $_POST['station'];
	$part_family = $_POST['part_family'];
	$npr = $_POST['npr'];
	$through_put = $_POST['through_put'];
	$budget_scrape_rate = $_POST['budget_scrape_rate'];
	$net_weight = $_POST['net_weight'];
	$part_length = $_POST['part_length'];
	$length_range = $_POST['length_range'];
	$notes = $_POST['notes'];
    $color = $_POST['color_code'];
	$created_by = $_POST['created_by'];

	//create

	if ($name != "") {
		$name = $_POST['part_number'];

//logo
//            if (isset($_FILES['image'])) {
		if (isset($_FILES['image'])) {
                $errors = array();
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $file_ext = strtolower(end(explode('.', $file_name)));
                $extensions = array("jpeg", "jpg", "png", "pdf");
                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Extension not allowed, please choose a JPEG or PNG file.';
                }
                if ($file_size > 2097152) {
                    $errors[] = 'File size must be excately 2 MB';
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: File size must be less than 2 MB';
                }
                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, "../assets/images/part_images/" . $name ."_".time().'_'. $file_name);
		$sql0 = "INSERT INTO `pm_part_number`(`part_images` ,`part_number` ,`part_name` , `customer_part_number`, `station` , `part_family` , `npr` , `through_put` , `budget_scrape_rate` , `net_weight` ,  `part_length`,`length_range`, `notes` ,`color_code`,`created_by`) VALUES ('$file_name','$name','$part_name','$customer_part_number','$station','$part_family','$npr','$through_put','$budget_scrape_rate','$net_weight','$part_length','$length_range','$notes','$color','$assign_by')";
                }
            }
			else
			{
		$sql0 = "INSERT INTO `pm_part_number`(`part_number` ,`part_name` , `customer_part_number`, `station` , `part_family` , `npr` , `through_put` , `budget_scrape_rate` , `net_weight` ,  `part_length`,`length_range`, `notes` ,`color_code`,`created_by`) VALUES ('$name','$part_name','$customer_part_number','$station','$part_family','$npr','$through_put','$budget_scrape_rate','$net_weight','$part_length','$length_range','$notes','$color','$assign_by')";
			}

//logo code over

        if(!isset($sql0)){
			$sql0 = "INSERT INTO `pm_part_number`(`part_number` ,`part_name` , `customer_part_number`, `station` , `part_family` , `npr` , `through_put` , `budget_scrape_rate` , `net_weight` ,  `part_length`,`length_range`, `notes` ,`color_code`,`created_by`) VALUES ('$name','$part_name','$customer_part_number','$station','$part_family','$npr','$through_put','$budget_scrape_rate','$net_weight','$part_length','$length_range','$notes','$color','$assign_by')";
		}
		$result0 = mysqli_query($db, $sql0);
		if ($result0) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Part Number Created successfully.';
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Please Insert valid data';
		}
	}
	//edit
	$edit_name = $_POST['edit_name'];
	if ($edit_name != "") {
		$id = $_POST['edit_id'];
		$e_part_name = $_POST['edit_part_name'];
		$e_part_number = $_POST['edit_name'];
		$e_cpn = $_POST['edit_customer_part_number'];
		$e_station = $_POST['edit_station'];
		$e_pf = $_POST['edit_part_family'];
		$e_npr = $_POST['edit_npr'];
        $e_throughput = $_POST['edit_through_put'];
        $e_bsr = $_POST['edit_budget_scrape_rate'];
        $e_netweight = $_POST['edit_net_weight'];
        $e_part_length = $_POST['edit_part_length'];
        $e_length_range = $_POST['edit_length_range'];
        $e_notes = $_POST['edit_notes'];
        $e_color = $_POST['edit_color_code'];
		$sql = "update pm_part_number set part_number='$e_part_number',part_name='$e_part_name', customer_part_number='$e_cpn', station='$e_station', part_family='$e_pf', npr='$e_npr', through_put='$e_throughput',budget_scrape_rate='$e_bsr', net_weight='$e_netweight', part_length='$e_part_length',length_range='$e_length_range', notes='$e_notes',color_code='$e_color',created_by='$assign_by' where pm_part_number_id = '$id'";
		$result1 = mysqli_query($db, $sql);

		$query = sprintf("SELECT part_images FROM `pm_part_number` where pm_part_number_id = '$id'");
		$qur = mysqli_query($db, $query);
		$rowc = mysqli_fetch_array($qur);
		if(isset($qur)){
//			$part_images = mysqli_fetch_array($qur)[0];
			$p_ims = $rowc["part_images"];
			$part_images = explode(',', $rowc["part_images"]);
			$edit_pm_imgs = $p_ims;
        }

		if (isset($_FILES['edit_image'])) {
//		if (file_exists($_FILES['edit_image']) || is_uploaded_file($_FILES['edit_image'])) {
			$totalfiles = count($_FILES['edit_image']['name']);
			// Looping over all files
//            $edit_pm_imgs = $_POST['edit_pm_image'];
//            if(null != $edit_pm_imgs && '' != $edit_pm_imgs){
//				$edit_pm_imgs = trim($edit_pm_imgs, "Array,");
//				$sql0 = "update pm_part_number set part_images = '$edit_pm_imgs'   where pm_part_number_id = '$id'";
//				$result11 = mysqli_query($db, $sql0);
//            }else{
//					$sql0 = "update pm_part_number set part_images = ''   where pm_part_number_id = '$id'";
//					$result11 = mysqli_query($db, $sql0);
//			}
            if($totalfiles > 0 && $_FILES['edit_image']['name'][0] !='' && $_FILES['edit_image']['name'][0] != null){
//				$sql0 = "update pm_part_number set part_images = ''   where pm_part_number_id = '$id'";
//				$result11 = mysqli_query($db, $sql0);
				for($i=0;$i<$totalfiles;$i++){
					$errors = array();
					$file_name = $_FILES['edit_image']['name'][$i];
					$file_size = $_FILES['edit_image']['size'][$i];
					$file_tmp = $_FILES['edit_image']['tmp_name'][$i];
					$file_type = $_FILES['edit_image']['type'][$i];
					$file_ext = strtolower(end(explode('.', $file_name)));
					$extensions = array("jpeg", "jpg", "png", "pdf");
					if (in_array($file_ext, $extensions) === false) {
						$errors[] = "extension not allowed, please choose a JPEG or PNG file.";
						$message_stauts_class = 'alert-danger';
						$import_status_message = 'Error: Extension not allowed, please choose a JPEG or PNG file.';
					}
					if ($file_size > 2097152) {
						$errors[] = 'File size must be excately 2 MB';
						$message_stauts_class = 'alert-danger';
						$import_status_message = 'Error: File size must be less than 2 MB';
					}
					if (empty($errors) == true) {
					    $f_name = $e_part_number."_". time() ."_". $file_name;
						move_uploaded_file($file_tmp, "../assets/images/part_images/" . $f_name);
//					$sql0 = "select part_images from pm_part_number where pm_part_number_id = '$id'";

						$qurtemp = mysqli_query($db, "select part_images as pim from pm_part_number where pm_part_number_id = '$id'");
						$pnum = ($qurtemp->fetch_assoc())['pim'];
						if(isset($pnum)){
							$part_img = $pnum . ',' . $f_name;
							$sql0 = "update pm_part_number set part_images = '$part_img'   where pm_part_number_id = '$id'";
							$result11 = mysqli_query($db, $sql0);
						}else{
							$sql0 = "update pm_part_number set part_images = '$f_name'  where pm_part_number_id = '$id'";
							$result11 = mysqli_query($db, $sql0);
						}


//				$sql0 = "INSERT INTO `pm_part_number`(`part_images` ,`part_number` ,`part_name` , `customer_part_number`, `station` , `part_family` , `npr` , `through_put` , `budget_scrape_rate` , `net_weight` ,  `part_length`,`length_range`, `notes` ,`created_by`) VALUES ('$file_name','$name','$part_name','$customer_part_number','$station','$part_family','$npr','$through_put','$budget_scrape_rate','$net_weight','$part_length','$length_range','$notes','$assign_by')";
					}
// Upload files and store in database


				}
            }

		}
		if ($result1) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Part Number Updated successfully.';
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Please Insert valid data';
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
    <title><?php echo $sitename; ?>
        | Part Number</title>
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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <style>        .sidebar-default .navigation li > a {
            color: #f5f5f5
        }

        ;
        a:hover {
            background-color: #20a9cc;
        }

        .sidebar-default .navigation li > a:focus, .sidebar-default .navigation li > a:hover {
            background-color: #20a9cc;
        }

        input[type="file"] {
            display: block;
        }
        .imageThumb {
            max-height: 75px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }
        .remove {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .remove:hover {
            background: white;
            color: black;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-4 {
                float: left;
                width: 45%!important;
            }
            .col-lg-8 {
                float: right;
                width: 55%!important;
            }
            .col-lg-6 control-label {
                float: left;
                width: 50%!important;
            }
            .col-lg-6 {
                float: left;
                width: 50%!important;
            }

        }
    </style>
</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Add Part Number";
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
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <form action="" id="user_form" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="panel-heading">

                            <div class="row">
                                <!-- Part Number -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Part Number * : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="part_number" id="part_number" class="form-control"
                                                   placeholder="Enter Part Number" required>
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Part Name -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Part Name  : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="part_name" id="part_name"
                                                   class="form-control" placeholder="Enter Part Name"
                                                   required>
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--Customer Part Number -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">CPN  : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="customer_part_number" id="customer_part_number"
                                                   class="form-control" placeholder="Enter Customer Part Number">
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Part Family -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Part Family  : </label>
                                        <div class="col-lg-8">
                                            <select name="part_family" id="part_family" class="select"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Family ---</option>
												<?php
												$sql1 = "SELECT * FROM `pm_part_family` where is_deleted = 0 ORDER BY `part_family_name` ASC";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['pm_part_family_id'] . "'  >" . $row1['part_family_name'] . "</option>";
												}
												?>
                                            </select>
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Station -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Station * : </label>
                                        <div class="col-lg-8">
                                            <select name="station" id="station" class="select" data-style="bg-slate">
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
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- NPR -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">NPR/hr  : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="npr" id="npr" class="form-control"
                                                   placeholder="Enter NPR" >
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Throughput -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Throughput : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="through_put" id="through_put"
                                                   placeholder="Enter Throughput" class="form-control">
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Budget Scrap Rate -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">BSR ( % ) : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="budget_scrape_rate" id="budget_scrape_rate"
                                                   class="form-control" placeholder="Enter Budget Scrape Rate" >
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <!-- Net Weight -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Net Weight ( kg ) : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="net_weight" id="net_weight" class="form-control"
                                                   placeholder="Enter Net Weight" >
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Length -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Length ( mm ) : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="part_length" id="part_length" class="form-control"
                                                   placeholder="Enter Length">
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <!-- Length Range-->
                               <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Length Range ( -/+ mm ) * : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="length_range" id="length_range"
                                                   class="form-control"
                                                   placeholder="Enter Length" required>
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <!-- Notes -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Notes : </label>
                                        <div class="col-lg-8">
                                            <textarea id="notes" name="notes" rows="1" placeholder="Enter Notes..."
                                                      class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- File Upload -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">File : </label>
                                        <div class="col-lg-8">
                                            <input type="file" name="image" id="image" class="form-control" multiple="multiple">
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Select Color Code * : </label>
                                        <div class="col-lg-6">
                                            <input type="color" id="color_code" name="color_code" value="#0000"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>


							<?php
							if (!empty($import_status_message)) {
								echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
							}
							?>
							<?php
							if (!empty($_SESSION['import_status_message'])) {
								echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
								$_SESSION['message_stauts_class'] = '';
								$_SESSION['import_status_message'] = '';
							}
							?>
                        </div>
                        <div class="panel-footer p_footer">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                <form action="" id="update-form" method="post" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="submitForm('delete_part_number.php')"
                                    style="background-color:#1e73be;">Delete
                            </button>
                            <!-- <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button> -->
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="choose" id="choose" required>
                                <option value="" disabled selected>Select Action</option>
                                <option value="1">Add to Station</option>
                            </select>
                        </div>
                        <div class="col-md-2 group_div" style="display:none">
                            <select class="select form-control" name="station" id="station" required>
                                <option value="" disabled selected>Select Station</option>
								<?php
								$sql1 = "SELECT * FROM `cam_line` ORDER BY `line_name` ASC ";
								$result1 = $mysqli->query($sql1);
								while ($row1 = $result1->fetch_assoc()) {
									echo "<option value='" . $row1['line_id'] . "'$entry>" . $row1['line_name'] . "</option>";
								}
								?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-primary"
                                    onclick="submitForm11('part_number_option_backend.php')"
                                    style="background-color:#1e73be;">Go
                            </button>
                            <!--<button type="button" class="btn btn-primary" onclick="submitForm11('add_user_to_group.php')"  style="background-color:#1e73be;">Go</button>
																	<button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Add Users</button>  -->
                        </div>
                    </div>
                    <br/>
                    <!-- Main charts -->
                    <!-- Basic datatable -->
                    <div class="panel panel-flat">
                        <table class="table datatable-basic">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th>S.No</th>
                                <th>Part Number</th>
                                <th>Part Name</th>
                                <th>Station</th>
                                <th>Part Family</th>
                                <th>Color</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  pm_part_number where is_deleted = 0;  ");
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]"
                                               value="<?php echo $rowc["pm_part_number_id"]; ?>"></td>
                                    <td><?php echo ++$counter; ?>
                                    </td>
                                    <td><?php echo $rowc["part_number"]; ?>
                                    </td>
                                    <td><?php echo $rowc["part_name"]; ?>
                                    </td>
                                    <!--                                    <td>--><?php //echo $rowc["customer_part_number"]; ?>
                                    <!--                                    </td>-->
									<?php
									$station1 = $rowc['station'];
									$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id  = '$station1' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
										$station = $rowctemp["line_name"];
									}
									?>
                                    <td><?php echo $station; ?>
                                    </td>
									<?php
									$part_family = $rowc['part_family'];
									$qurtemp = mysqli_query($db, "SELECT * FROM  pm_part_family where pm_part_family_id  = '$part_family' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
										$part_family1 = $rowctemp["part_family_name"];
									}
									?>
                                    <td><?php echo $part_family1; ?></td>
                                    <td><input type="color" id="color_code" name="color_code" value="<?php echo $rowc["color_code"]; ?>"  disabled></td>

                                    <td>
<!--                                        <a href="edit_part_number.php.php?id=--><?php //echo $rowc['pm_part_number_id'];" class="btn btn-primary" data-id="<?php echo $rowc['defect_list_id']; ?><!--"  style="background-color:#1e73be;">Edit</a>-->
                                        <button type="button" id="edit" class="btn btn-info btn-xs"
                                                data-id="<?php echo $rowc['pm_part_number_id']; ?>"
                                                data-name="<?php echo $rowc['part_number']; ?>"
                                                data-part_name="<?php echo $rowc['part_name']; ?>"
                                                data-customer_part_number="<?php echo $rowc['customer_part_number']; ?>"
                                                data-station="<?php echo $rowc['station']; ?>"
                                                data-part_family="<?php echo $rowc['part_family']; ?>"
                                                data-npr="<?php echo $rowc['npr']; ?>"
                                                data-through_put="<?php echo $rowc['through_put']; ?>"
                                                data-budget_scrape_rate="<?php echo $rowc['budget_scrape_rate']; ?>"
                                                data-net_weight="<?php echo $rowc['net_weight']; ?>"
                                                data-part_length="<?php echo $rowc['part_length']; ?>"
                                                data-length_range="<?php echo $rowc['length_range']; ?>"
                                                data-color_code="<?php echo $rowc['color_code']; ?>"
                                                data-part_images="<?php
												if(substr($rowc['part_images'] , 0 , 1)=== ","){
													$str = ltrim($rowc['part_images'], ',');
													echo $str;
												}else{
													echo $rowc['part_images'];
												}
                                                ?>"
                                                data-pm_image="<?php
                                                if(substr($rowc['part_images'] , 0 , 1)=== ","){
													$str = ltrim($rowc['part_images'], ',');
													echo $str;
                                                }else{
													echo $rowc['part_images'];
                                                }
                                                 ?>"
                                                data-notes="<?php echo $rowc['notes']; ?>" data-toggle="modal"
                                                style="background-color:#1e73be;"
                                                data-target="#edit_modal_theme_primary">Edit
                                        </button>
                                        <!--								&nbsp;	<button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['users_id']; ?>">Delete </button>
                                                    -->
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
                            <h6 class="modal-title">
                                Update Part Details
                            </h6>
                        </div>
                        <form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal"
                              method="post">
                            <div class="modal-body">
                                <!--Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Part Number * : </label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_name" id="edit_name" class="form-control"
                                                       required>
                                                <input type="hidden" name="edit_id" id="edit_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Part Name * : </label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_part_name" id="edit_part_name"
                                                       class="form-control"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Customer Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Customer Part Number :</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_customer_part_number"
                                                       id="edit_customer_part_number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Station-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Station * :</label>
                                            <div class="col-lg-6">
                                                <select name="edit_station" id="edit_station" class="select form-control">
                                                    <option value="" selected disabled>--- Select Station ---</option>
													<?php
													$sql1 = "SELECT * FROM `cam_line` ORDER BY `line_name` ASC ";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Part Family-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Part Family:*</label>
                                            <div class="col-lg-6">
                                                <select name="edit_part_family" id="edit_part_family"
                                                        class="select form-control">
                                                    <option value="" selected disabled>--- Select Part Family ---
                                                    </option>
													<?php
													$sql1 = "SELECT * FROM `pm_part_family` ORDER BY `part_family_name` ASC ";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['pm_part_family_id'] . "'  >" . $row1['part_family_name'] . "</option>";
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--NPR-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">NPR/hr :</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_npr" id="edit_npr" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Through Put-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Throughput : </label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_through_put" id="edit_through_put"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Budget Scrap Rate-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">BSR ( % ) :</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_budget_scrape_rate"
                                                       id="edit_budget_scrape_rate" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Net Weight-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Net Weight ( kg ) : </label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_net_weight" id="edit_net_weight"
                                                       class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Length-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Length ( mm ) :</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="edit_part_length" id="edit_part_length"
                                                       class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Length Range-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <div class="form-group">-->
<!--                                            <label class="col-lg-4 control-label">Length Range ( -/+ mm ) * :</label>-->
<!--                                            <div class="col-lg-8">-->
<!--                                                <input type="text" name="edit_length_range" id="edit_length_range"-->
<!--                                                       class="form-control" required>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <!--Notes-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Notes : </label>
                                            <div class="col-lg-6">
                                                <textarea id="edit_notes" name="edit_notes" rows="4"
                                                          placeholder="Enter Notes..." class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--color-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">Color : </label>
                                            <div class="col-lg-6">
                                                <input type="color" id="edit_color_code" name="edit_color_code" value="<?php echo $color_code ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--File-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-6 control-label">File:</label>
                                            <div class="col-lg-6" id="pnum_images">
                                                <input type="text" hidden name="edit_pm_image" id="edit_pm_image">
                                                <input type="file" name="edit_image[]" id="edit_image" class="form-control" data-ex-files="" multiple="multiple">
<!--                                                <input type="file" id="files" name="files[]" multiple />-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <div class="form-group">-->
<!--                                            <label class="col-lg-4 control-label">Part Image : </label>-->
<!--                                            <div class="col-lg-8">-->
<!--                                                <img src="" alt="Image not Available" name="edit_p_image[]" id="edit_p_image" style="height:150px;width:150px;"/>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->


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
            <script>
                $(document).on('click', '#delete', function () {
                    var element = $(this);
                    var del_id = element.attr("data-id");
                    var info = 'id=' + del_id;
                    $.ajax({
                        type: "POST", url: "ajax_delete.php", data: info, success: function (data) {
                        }
                    });
                    $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                });
            </script>
            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '#edit', function () {
                        var element = $(this);
                        var edit_id = element.attr("data-id");
                        var name = $(this).data("name");
                        var part_name = $(this).data("part_name");
                        var customer_part_number = $(this).data("customer_part_number");
                        var station = $(this).data("station");
                        var part_family = $(this).data("part_family");
                        var npr = $(this).data("npr");
                        var through_put = $(this).data("through_put");
                        var budget_scrape_rate = $(this).data("budget_scrape_rate");
                        var net_weight = $(this).data("net_weight");
                        var part_length = $(this).data("part_length");
                        var length_range = $(this).data("length_range");
                        var notes = $(this).data("notes");
                        var color = $(this).data("color_code");
                        var part_images = $(this).data("part_images");
                        var image_path =  "./assets/images/part_images/"
                        $("#edit_name").val(name);
                        $("#edit_part_name").val(part_name);
                        $("#edit_customer_part_number").val(customer_part_number);
                        $("#edit_station").val(station);
                        $("#edit_part_family").val(part_family);
                        $("#edit_npr").val(npr);
                        $("#edit_through_put").val(through_put);
                        $("#edit_budget_scrape_rate").val(budget_scrape_rate);
                        $("#edit_net_weight").val(net_weight);
                        $("#edit_part_length").val(part_length);
                        $("#edit_length_range").val(length_range);
                        $("#edit_notes").val(notes);
                        $("#edit_color_code").val(color);
                        if(part_images !== null && part_images !== '') {
                            $("#edit_p_image").attr("src","../assets/images/part_images/"+part_images);

                        }

                        $("#edit_id").val(edit_id);
                        // Load Taskboard
                        const sb1 = document.querySelector('#edit_station');
                        var options1 = sb1.options;
                        $('#edit_modal_theme_primary .select2 .selection select2-selection select2-selection--single .select2-selection__choice').remove();
                        for (var i = 0; i < options1.length; i++) {
                            if(station == (options1[i].value)){ // EDITED THIS LINE
                                options1[i].selected="selected";
                                options1[i].className = ("select2-results__option--highlighted");
                                var opt = options1[i].outerHTML.split(">");
                                $('#select2-results .select2-results__option').prop('selectedIndex',i);
                                var gg = '<span class="select2-selection__rendered" id="select2-edit_station-container" title="' + opt[1].replace('</option','') + '">' + opt[1].replace('</option','') + '</span>';
                                $("#select2-edit_station-container")[0].outerHTML = gg;
                            }
                        }

                        // Load Part Family
                        const sb2 = document.querySelector('#edit_part_family');
                        var options1 = sb2.options;
                        $('#edit_modal_theme_primary .select2 .selection select2-selection select2-selection--single .select2-selection__choice').remove();
                        for (var i = 0; i < options1.length; i++) {
                            if(part_family == (options1[i].value)){ // EDITED THIS LINE
                                options1[i].selected="selected";
                                options1[i].className = ("select2-results__option--highlighted");
                                var opt = options1[i].outerHTML.split(">");
                                $('#select2-results .select2-results__option').prop('selectedIndex',i);
                                var gg = '<span class="select2-selection__rendered" id="select2-edit_part_family-container" title="' + opt[1].replace('</option','') + '">' + opt[1].replace('</option','') + '</span>';
                                $("#select2-edit_part_family-container")[0].outerHTML = gg;
                            }
                        }
                        $('.pip').remove();
                        if(part_images !== null && part_images !== '') {
                            var pm_files = part_images.split(",");
                            for (var i = 0; i < pm_files.length; i++) {
                                $("<span class=\"pip\" id=\"" +i+"\" >" +
                                    "<img style=\"height:150px;width:150px;\" name=\"edit_image[" +i+"]\" id=\"edit_image_" +i+"\" src=\"" + "../assets/images/part_images/"+ pm_files[i] + "\"/>" +
                                    "<br/><span class=\"remove\">Remove image</span>" +
                                    "</span>").insertAfter("#edit_image");

                            }
                            $(".remove").click(function(){
                                var index = $(this).parent(".pip")[0].id;
                                $(this).parent(".pip").remove();

                                pm_files.splice(index, 1);
                                var info = "images="+pm_files.toString()+"&id="+edit_id;
                                // $("#edit_pm_image").val(pm_files.toString());
                                $.ajax({
                                    type: "POST", url: "delete_pnum_image.php", data: info, success: function (data) {
                                    }
                                });
                            });
                        }
                    });
                });
            </script>
        </div>
        <!-- /content area -->

</div>
<!-- /page container -->

<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>part_module/part_number.php");
    }
</script>
<script>
    $("#edit_image").on("change", function(e) {
        var files = e.target.files,
            filesLength = files.length;
        var tot = e.currentTarget.attributes.length;
        var ij = tot - filesLength + 1 ;
        var j =0 ;
        for (var i = ij ; i <= tot; i++) {
            var f = files[j];
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
                var file = e.target;
                $("<span class=\"pip\" id=\"" +(ij++)+"\" >" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + f.name + "\"/>" +
                    "<br/><span class=\"remove\">Remove image</span>" +
                    "</span>").insertAfter("#edit_image");
                $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                });

                // Old code here
                /*$("<img></img>", {
				  class: "imageThumb",
				  src: e.target.result,
				  title: file.name + " | Click to remove"
				}).insertAfter("#files").click(function(){$(this).remove();});*/

            });
            fileReader.readAsDataURL(f);

            // console.log(files);
            j++;
        }
        console.log(files);
    });
    $(".remove").click(function(){
        $(this).parent(".pip").remove();
    });
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('#generate').click(function () {
        let r = Math.random().toString(36).substring(7);
        $('#newpass').val(r);
    })

    function submitForm(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    function submitForm11(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    function submitForm12(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    $('#choose').on('change', function () {
        var selected_val = this.value;
        if (selected_val == 1 || selected_val == 2) {
            $(".group_div").show();
        } else {
            $(".group_div").hide();
        }
    });
</script>
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
