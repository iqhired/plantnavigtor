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

$l_id = $_GET['id'];
if(!empty($l_id) && ($l_id > 0)){
	$dir_path = "../assets/label_files/" . $l_id;
	$output = file_get_contents($dir_path.'/'.'f1');
	$output_bad = file_get_contents($dir_path.'/'.'f2');
}

if (count($_POST) > 0) {

//edit

	$edit_name = $_POST['edit_name'];
	$id = $_POST['edit_id'];
	$dir_path = "../assets/label_files/" . $id;
	$content = $_POST['good_file'];
	$file = $dir_path.'/'.'f1' ; // cannot be an online resource
	$Saved_File = fopen($file, 'w');
	fwrite($Saved_File, $content);
	fclose($Saved_File);
	$file1 = $dir_path.'/'.'g_label';
	$g_label_file = fopen($file1,'w');
	fwrite($g_label_file, $content);
	fclose($g_label_file);
	$content_bad = $_POST['bad_file'];
	$file_bad = $dir_path.'/'.'f2' ; // cannot be an online resource
	$Saved_File_bad = fopen($file_bad, 'w');
	fwrite($Saved_File_bad, $content_bad);
	fclose($Saved_File_bad);
	$file_bad1 = $dir_path.'/'.'b_label' ; // cannot be an online resource
	$Saved_File_bad1 = fopen($file_bad1, 'w');
	fwrite($Saved_File_bad1, $content_bad);
	fclose($Saved_File_bad1);

	$output = file_get_contents($dir_path.'/'.'f1');
	$output_bad = file_get_contents($dir_path.'/'.'f2');

	$sql = "update cam_line set line_name='$_POST[edit_name]', priority_order='$_POST[edit_priority_order]' , enabled='$_POST[edit_enabled]'  where line_id='$id'";

	$result1 = mysqli_query($db, $sql);
	if ($result1) {
		$message_stauts_class = 'alert-success';
		$import_status_message = 'Station Updated successfully.';
	} else {
		$message_stauts_class = 'alert-danger';
		$import_status_message = 'Error: Please Insert valid data';
	}
    header('location: line.php');

	if (isset($_FILES['good_file']) && isset($_FILES['bad_file'])) {
		$errors = array();
		$good_name = $_FILES['good_file']['name'];
		$bad_name = $_FILES['bad_file']['name'];
//    $rework_name = $_FILES['rework_file'];
		$good_size = $_FILES['good_file']['size'];
		$bad_size = $_FILES['bad_file']['size'];
//    $rework_size = $_FILES['rework_file']['size'];
		$good_tmp = $_FILES['good_file']['tmp_name'];
		$good_tmp1 = $good_tmp;
		$bad_tmp = $_FILES['bad_file']['tmp_name'];
//    $rework_tmp = $_FILES['rework_file']['tmp_name'];
		$good_type = $_FILES['good_file']['type'];
		$bad_type = $_FILES['bad_file']['type'];
//    $rework_type = $_FILES['rework_file']['type'];


//    $good_ext = strtolower(end(explode('.', $good_name)));
//    $bad_ext = strtolower(end(explode('.', $bad_name)));
		$good_extensions = array("application/octet-stream","doc","docx");
		$bad_extensions = array("application/octet-stream","doc","docx");
//    $rework_extensions = array("doc","docx");
//    if (in_array($good_type, $good_extensions) == false && in_array($bad_type, $bad_extensions) == false ) {
//    $errors[] = "extension not allowed, please choose a doc file.";
//    $message_stauts_class = 'alert-danger';
//    $import_status_message = 'Error: Extension not allowed, please choose a doc file.';
//
//}
//    if ($good_size > 2097152 && $bad_size > 2097152 && $rework_size > 2097152) {
//        $errors[] = 'File size must be excately 2 MB';
//        $message_stauts_class = 'alert-danger';
//        $import_status_message = 'Error: File size must be less than 2 MB';
//    }
		if (empty($errors) == true) {
			$dir_path = "../assets/label_files/" . $_POST['edit_id'];
			if (file_exists($dir_path)) {
				$files = glob("$dir_path/*"); // get all file names
				foreach ($files as $file) { // iterate files
					if (is_file($file)) {
						unlink($file); // delete file
					}
				}
			}else if (!file_exists($dir_path)) {
				mkdir($dir_path, 0777, true);
			}
			move_uploaded_file($good_tmp, $dir_path . '/' . 'g' . "_" . 'label');
			copy($dir_path . '/' . 'g' . "_" . 'label', $dir_path . '/' . 'f1');
//		move_uploaded_file($good_tmp1, $dir_path . '/' . 'f1');
			move_uploaded_file($bad_tmp, $dir_path . '/' . 'b' . "_" . 'label');
			copy($dir_path . '/' . 'b' . "_" . 'label', $dir_path . '/' . 'f2');

			$zpl_id = $_POST['label_line_id'];
			$sql1 = "update cam_line set zpl_file_status = '1',print_label = '1' where line_id ='$zpl_id'";
			$result1 = mysqli_query($db, $sql1);
			//    $sql0 = "INSERT INTO `cam_line`('logo',`line_name`,`priority_order` , `enabled` , `created_at`) VALUES (''$file_name','$name' , '$priority_order' , '$enabled', '$chicagotime')";
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Station Updated successfully.';
//            $message_stauts_class = 'alert-success';
//			$import_status_message = 'Upload Files Successfully';
		}
	}

    header('location: line.php');

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Station</title>
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
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/pn.js"></script>
</head>
<style>

    .form-horizontal .form-group {
        font-size: 14px;
    }
    textarea.form-control {
        height: auto;
        border: 1px solid #dcd2d2;
    }
</style>

<!-- Main navbar -->
<?php
$cust_cam_page_header = " Edit Station Configuration Management";
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

        <div class="panel panel-flat">
            <div class="panel-heading">
                <form action="" id="" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
							<?php
							$edit_id = $_GET['id'];
							?>
							<?php
							$sql1 = "SELECT * FROM `cam_line` where line_id = '$edit_id' ";
							$result1 = $mysqli->query($sql1);
							while ($row1 = $result1->fetch_assoc()) {
                                $line_id = $row1['line_id'];
								$line_name = $row1['line_name'];
								$p_order = $row1['priority_order'];
								$enabled = $row1['enabled'];
								$zpl_status = $row1['zpl_file_status'];
                                $print_label = $row1['print_label'];
                                $indivisual_label = $row1['indivisual_label'];
							}
							?>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Station:*</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="edit_name" id="edit_name" class="form-control" value="<?php echo $line_name; ?>" required>
                                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Priority Order:*</label>
                                    <div class="col-lg-7">
                                        <input type="number" name="edit_priority_order" id="edit_priority_order" class="form-control"
                                               value="<?php echo $p_order; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Enabled:*</label>
                                    <div class="col-lg-7">
                                        <input type="hidden" name="edit_e" id="edit_e" >
                                        <select  name="edit_enabled" id="edit_enabled" class="select form-control" data-style="bg-slate" style="float: left;
                                                                 width: initial;">
											<?php if($enabled == 1){
												$selected = "selected";
												echo "<option value ='1'  $selected>Yes</option>
                                                   <option value='0'>No</option>";
											}
                                            elseif($enabled == 0){
												$selected = "selected";
												echo "<option value ='1'>Yes</option>
                                                      <option value ='0'$selected>No</option>";
											}
											?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Print label Enabled:*</label>
                                    <div class="col-lg-7">
                                        <input type="checkbox" class="print_status" name="print_status" id="print_status" value="<?php echo $line_id; ?>" <?php echo ($print_label == 1 ? 'checked' : '');?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Print Individual label :*</label>
                                    <div class="col-lg-7">
                                        <input type="checkbox" class="print_status" name="p_label" id="p_label" value="<?php echo $line_id; ?>" <?php echo ($indivisual_label == 1 ? 'checked' : '');?>>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php if ($zpl_status == '1'){
                            if ($print_label == '1'){ ?>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Good Piece File : </label>
                                        <div class="col-lg-7">

                                            <textarea rows="5" name="good_file" id="good_file" class="form-control" required><?php echo $output; ?></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Bad Piece File : </label>
                                        <div class="col-lg-7">

                                            <textarea rows="5" name="bad_file" id="bad_file" class="form-control" required><?php echo $output_bad; ?></textarea>

                                        </div>

                                    </div>
                                </div>
                            </div>
                              <?php } else if ($print_label == '0') {  ?>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Good Piece File : </label>
                                            <div class="col-lg-7">

                                                <textarea rows="5" name="good_file" id="good_file" class="form-control"><?php echo $output; ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Bad Piece File : </label>
                                            <div class="col-lg-7">

                                                <textarea rows="5" name="bad_file" id="bad_file" class="form-control"><?php echo $output_bad; ?></textarea>

                                            </div>

                                        </div>
                                    </div>
                                </div>
						<?php } }?>
                    </div>
                    <div class="modal-footer">
                        <!--                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<!-- /page container -->

<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>config_module/edit_line.php?id=<?php echo $edit_id;?>");
    }
</script>



<script>
    $("input#gbpd").click(function () {
        var isChecked = $(this)[0].checked;
        var val = $(this).val();
        var data_1 = "&gbpd=" + val+ "&isChecked=" + isChecked;
        $.ajax({
            type: 'POST',
            url: "GBPD_backend.php",
            data: data_1,
            success: function (response) {

            }
        });

    });

</script>
<script>
    $("input#print_status").click(function () {
        var element = $(this)[0].checked;
        var print_id = $(this).val();
        var info = '&print=' + print_id+"&isChecked=" + element;;
        $.ajax({
            type: "POST",
            url: "print_action.php",
            data: info,
            success: function (data) {

            }
        });

    });
</script>
<script>
    $("input#p_label").click(function () {
        var isChecked = $(this)[0].checked;
        var val = $(this).val();
        var data_1 = "&p_label=" + val+ "&isChecked=" + isChecked;
        $.ajax({
            type: 'POST',
            url: "print_label.php",
            data: data_1,
            success: function (response) {
            }
        });
    });
</script>

<?php include('../footer.php') ?>
<!--<script type="text/javascript" src="../assets/js/core/app.js"></script>-->
</body>
</html>