<?php
include("../config.php");
$import_status_message = "";
include("../sup_config.php");
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
	$cust_name = $_POST['cust_name'];
//create
	if ($cust_name != "") {
		$enabled = $_POST['enabled'];
		$cust_type = $_POST['account_type'];
		$cust_address = $_POST['address'];
		$cust_contact = $_POST['contact_number'];
		$cust_website = $_POST['website'];
//		$cust_logo = $_POST['cust_name'];
//logo
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
                    move_uploaded_file($file_tmp, "../supplier_logo/" . $file_name);
		$sql = "INSERT INTO `cus_account`( `logo`,`c_name`, `c_type`, `c_mobile`, `c_address`, `c_website`, `c_status`, `created_at`) VALUES ('$file_name','$cust_name','$cust_type','$cust_contact','$cust_address','$cust_website','$enabled','$chicagotime')";
                }
            }
			else
			{
		$sql = "INSERT INTO `cus_account`( `c_name`, `c_type`, `c_mobile`, `c_address`, `c_website`, `c_status`, `created_at`) VALUES ('$cust_name','$cust_type','$cust_contact','$cust_address','$cust_website','$enabled','$chicagotime')";
				
			}

//logo code over
//		$sql = "INSERT INTO `sup_account`( `logo`,`c_name`, `c_type`, `c_mobile`, `c_address`, `c_website`, `c_status`, `created_at`) VALUES ('$file_name','$cust_name','$cust_type','$cust_contact','$cust_address','$cust_website','$enabled','$chicagotime')";
		$result1 = mysqli_query($db, $sql);
		if (!$result1) {
			$message_stauts_class = 'alert-danger';
			if($import_status_message == "")
			{
			$import_status_message = 'Error: Account Already Exists';
			}
		} else {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Account Created Successfully';
		}
	}
//edit
	$edit_name = $_POST['edit_cust_name'];
	$edit_file = $_FILES['edit_logo_image']['name'];
	if ($edit_name != "") {
	
		$id = $_POST['edit_id'];
//eidt logo
		if($edit_file != "")
		{	
            if (isset($_FILES['edit_logo_image'])) {
                $errors = array();
                $file_name = $_FILES['edit_logo_image']['name'];
                $file_size = $_FILES['edit_logo_image']['size'];
                $file_tmp = $_FILES['edit_logo_image']['tmp_name'];
                $file_type = $_FILES['edit_logo_image']['type'];
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
                    $import_status_message = 'Error: File size must be excately 2 MB';
                }
                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, "../supplier_logo/" . $file_name);
                    
					$sql = "update cus_account set logo='$file_name',c_name='$_POST[edit_cust_name]',c_type='$_POST[edit_account_type]',c_mobile='$_POST[edit_contact_number]',c_address='$_POST[edit_address]',c_website='$_POST[edit_website]',c_status='$_POST[edit_enabled]' where c_id='$id'";
                }
            }
		}	
			else
			{
					$sql = "update cus_account set c_name='$_POST[edit_cust_name]',c_type='$_POST[edit_account_type]',c_mobile='$_POST[edit_contact_number]',c_address='$_POST[edit_address]',c_website='$_POST[edit_website]',c_status='$_POST[edit_enabled]' where c_id='$id'";
			}	

			$result1 = mysqli_query($db, $sql);
            if ($result1) {
				$message_stauts_class = 'alert-success';
				$import_status_message = 'Account Updated Successfully.';
            } else {
				$message_stauts_class = 'alert-danger';
				if($import_status_message == "")
				{
					$import_status_message = 'Error: Please Try Again.';
				} 
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
    <title><?php echo $sitename; ?> | Customer Account(s)</title>
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
</head>
<body>
<!-- Main navbar -->
<?php $cam_page_header = "Customer Account";
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
            <!-- Content area -->
            <div class="content">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <form action="" id="user_form" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="panel-heading">

                            <div class="row">
                                <!-- Customer Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Account Name * : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="cust_name" id="cust_name" class="form-control"
                                                   placeholder="Enter Customer Name" required>
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Customer Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Account Type * : </label>
                                        <div class="col-lg-8">
                                            <select required name="account_type" id="account_type" class="select"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Account Type ---</option>
												<?php
												$sql1 = "SELECT * FROM `cus_account_type` ORDER BY `cus_account_type_name` ASC";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['cus_account_type_id'] . "'  >" . $row1['cus_account_type_name'] . "</option>";
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
                                <!--Mobile -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Contact Number : </label>
                                        <div class="col-lg-8">
                                            <input type="number" name="contact_number" id="contact_number"
                                                   class="form-control" placeholder="Enter Contact Number">
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Website -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Website : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="website" id="website"
                                                   class="form-control" placeholder="Enter website">
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- File Upload -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Upload Logo : </label>
                                        <div class="col-lg-8">
                                            <input type="file" name="image" id="image" required
                                                   class="form-control">
                                            <div id="1" style="color:red;">* File size must be less than 2 MB.
                                            </div>
											<div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Enabled -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-lg-8">
                                            <label class="control-label"
                                                   style="float: left;padding-top: 10px; font-weight: 500;">Enabled
                                                : </label>
                                            <select name="enabled" id="enabled" class=" form-control"
                                                     style="float: left;
                                                             width: initial;">
                                                <!--        <option value="" selected disabled>--- Select Ratings ---</option>-->
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">


                                <!--Address -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Address : </label>
                                        <div class="col-lg-8">
											<textarea id="address" name="address" rows="3"
                                                      placeholder="Enter Address..."
                                                      class="form-control"></textarea>
                                            <div id="error6" class="red">
                                            </div>
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
							if (!empty($_SESSION[import_status_message])) {
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
            </div>

            <div class="content">
                <form action="" id="update-form" method="post" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="submitForm('delete_cus_accounts.php')"
                                    style="background-color:#1e73be;">Delete
                            </button>
                            <!-- <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button> -->
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
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th>Account Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  cus_account ;  ");
							$qur = mysqli_query($db, $query);

							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]"
                                               value="<?php echo $rowc["c_id"]; ?>"></td>
                                    <td><?php echo ++$counter; ?>
                                    </td>
                                    <td><?php echo $rowc["c_name"]; ?>
                                    </td>
                                    <td><?php
                                        $c_type = $rowc["c_type"];
                                        $query34 = sprintf("SELECT * FROM  cus_account_type where cus_account_type_id = '$c_type'");
										$qur34 = mysqli_query($db, $query34);
										$rowc34 = mysqli_fetch_array($qur34);
                                        echo $rowc34["cus_account_type_name"]; ?>
                                    </td>
									<?php
									$enabled = $rowc['c_status'];
									$c_status = "Active";
									if($enabled == 0){
										$c_status = "Inactive";
                                    }
									?>
                                    <td><?php echo $c_status; ?>
                                    </td>
                                    <td>
                                        <button type="button" id="edit" class="btn btn-info btn-xs"
                                                data-id="<?php echo $rowc['c_id']; ?>"
                                                data-cust_name="<?php echo $rowc['c_name']; ?>"
                                                data-cust_type="<?php echo $rowc['c_type']; ?>"
                                                data-customer_enabled="<?php echo $rowc['c_status']; ?>"
                                                data-cust_address="<?php echo $rowc['c_address']; ?>"
                                                data-cust_mobile="<?php echo $rowc['c_mobile']; ?>"
                                                data-cust_website="<?php echo $rowc['c_website']; ?>"
                                                data-cust_logo="<?php echo $rowc['logo']; ?>"
                                                data-toggle="modal" style="background-color:#1e73be;"
                                                data-target="#edit_modal_theme_primary">Edit
                                        </button>
                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                </form>
            </div>

            <!-- edit modal -->
            <div id="edit_modal_theme_primary" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">
                                Update Accounts
                            </h6>
                        </div>
                        <form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal"
                              method="post">
                            <div class="modal-body">
                                <!--Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Account Name * : </label>
                                            <div class="col-lg-8">
                                                <input type="text" name="edit_cust_name" id="edit_cust_name"
                                                       class="form-control" required>
                                                <input type="hidden" name="edit_id" id="edit_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Account Type * : </label>
                                            <div class="col-lg-8">
                                                <select required name="edit_account_type" id="edit_account_type"
                                                        class="form-control">
                                                    <option value="" selected disabled>--- Select Account Type ---
                                                    </option>
													<?php
													$sql1 = "SELECT * FROM `cus_account_type` ORDER BY `cus_account_type_name` ASC";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['cus_account_type_id'] . "'  >" . $row1['cus_account_type_name'] . "</option>";
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Contact Number : </label>
                                            <div class="col-lg-8">
                                                <input type="text" name="edit_contact_number" id="edit_contact_number"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Customer Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Website : </label>
                                            <div class="col-lg-8">
                                                <input type="text" name="edit_website" id="edit_website"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Station-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Enabled : </label>
                                            
											<div class="col-lg-8">
                                                <select name="edit_enabled" id="edit_enabled" class="form-control"
                                                         style="float: left;
                                                             width: initial;">
                                                    <!--        <option value="" selected disabled>--- Select Ratings ---</option>-->
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Part Family-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Address : </label>
                                            <div class="col-lg-8">
											<textarea id="edit_address" name="edit_address" rows="3"
                                                      class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--NPR-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Upload New Logo : </label>
                                            <div class="col-lg-8">
                                                <input type="file" name="edit_logo_image" id="edit_logo_image1" 
                                                       class="form-control">
                                                <div id="error6" class="red">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Previous Logo Preview : </label>
                                            <div class="col-lg-8">
											
                                                 <img src="" alt="Image not Available" name="editlogo" id="editlogo" style="height:150px;width:150px;"/>
                                                </div>
                                            </div>
                                        </div>
                                </div>
<div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>                            
							</div>
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
                        var cust_name = $(this).data("cust_name");
                        var cust_type = $(this).data("cust_type");
                        var customer_enabled = $(this).data("customer_enabled");
                        var cust_address = $(this).data("cust_address");
                        var cust_mobile = $(this).data("cust_mobile");
                        var cust_website = $(this).data("cust_website");
                        var cust_logo = $(this).data("cust_logo");
                        $("#edit_name").val(name);
                        $("#edit_cust_name").val(cust_name);
                        $("#edit_account_type").val(cust_type);
                        $("#edit_enabled").val(customer_enabled);
                        $("#edit_address").val(cust_address);
                        $("#edit_contact_number").val(cust_mobile);
                        $("#edit_website").val(cust_website);
                        $("#editlogo").attr("src","../supplier_logo/"+cust_logo);
                        $("#edit_id").val(edit_id);
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
<?php include('../footer.php') ?>
<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>config_module/cus_accounts.php");
    }
</script>
<script>
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
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
</body>
</html>
