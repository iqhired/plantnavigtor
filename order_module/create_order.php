<?php include("../config.php");
$import_status_message = "";
include("../sup_config.php");
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
$is_tab_login = $_SESSION['is_tab_user'];
$is_cell_login = $_SESSION['is_cell_login'];
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
/*$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../dashboard.php');
}*/
if (count($_POST) > 0) {
	$order_name = $_POST['order_name'];
//create
  	if ($order_name != "") {
		$c_id = $_POST['c_id'];
		$order_name = $_POST['order_name'];
		$order_desc = $_POST['order_desc'];
		$created_by = $_SESSION['id'];
            
		$sql = "INSERT INTO `sup_order`( `c_id`, `order_name`, `order_desc`, `order_status_id`, `order_active`, `created_on`, `created_by`) VALUES ('$c_id','$order_name','$order_desc','1','1','$chicagotime','$created_by')";
		
		$result1 = mysqli_query($sup_db, $sql);
		if (!$result1) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			if($_SESSION['import_status_message'] == "")
			{
				$_SESSION['import_status_message'] = 'Error: Order Already Exists';
			}
		} else {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Order Created Successfully';
		}
	}

//edit
    $edit_order_status = $_POST['order_status'];
	if ($edit_order_status != "") {
        $id = $_POST['edit_id'];
	if($edit_order_status == 6){
        $sql111 = "update sup_order set order_active = 0,order_status_id='$_POST[order_status]' where order_id='$id'";
        $result111 = mysqli_query($sup_db, $sql111);
        if ($result111) {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Order Updated Successfully.';
        } else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            if($_SESSION['import_status_message'] == "")
            {
                $_SESSION['import_status_message'] = 'Error: Please Try Again.';
            }
        }

    }else{
//eidt logo
        $sql = "update sup_order set order_status_id='$_POST[order_status]' where order_id='$id'";
        $result1 = mysqli_query($sup_db, $sql);
            if ($result1) {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Order Updated Successfully.';
            } else {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				if($_SESSION['import_status_message'] == "")
				{
					$_SESSION['import_status_message'] = 'Error: Please Try Again.';
				} 
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
    <title><?php echo $sitename; ?> | Create Order</title>
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
<?php
$cust_cam_page_header = "Create Order";
include("../header_folder.php");
if (($is_tab_login || $is_cell_login)) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}
include("../heading_banner.php");
?>
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- content wrapper-->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <form action="" id="user_form" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="panel-heading">

                            <div class="row">
                                <!-- Customer Name -->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Supplier Name * : </label>
                                        <div class="col-lg-8">
                                            <select required name="c_id" id="c_id" class="select"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Supplier ---</option>
												<?php
												$sql1 = "SELECT * FROM `sup_account` ORDER BY `c_name` ASC";
												$result1 = $sup_mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['c_id'] . "'  >" . $row1['c_name'] . "</option>";
												}
												?>
                                            </select>
											<div id="error6" class="red" style="display:none">Please Select Supplier </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Customer Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Order Name * : </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="order_name" id="order_name"
                                                   class="form-control" placeholder="Enter Order">
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Order Description : </label>
                                        <div class="col-lg-8">
											<textarea id="order_desc" name="order_desc" rows="3"
                                                      placeholder="Enter Description..."
                                                      class="form-control"></textarea>
                                            <div id="error6" class="red">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer p_footer">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create Order
                                </button>
                            </div>
                        </div>
                    </form>
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
                    <div class="panel panel-flat">
                        <table class="table datatable-basic">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Suplier Name</th>
                                <th>Order Name</th>
                                <th>Order Description</th>
                                <th>Order Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM sup_order order by order_status_id asc");
							$qur = mysqli_query($sup_db, $query);

							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><?php echo ++$counter; ?>
                                    </td>
                                    <td>
									<?php
                                        $c_id = $rowc["c_id"];
                                        $query34 = sprintf("SELECT c_name FROM  sup_account where c_id = '$c_id'");
										$qur34 = mysqli_query($sup_db, $query34);
										$rowc34 = mysqli_fetch_array($qur34);
                                        echo $rowc34["c_name"]; ?>
                                    </td>
									<td><?php echo $rowc["order_name"]; ?>
                                    </td>
                                    <td><?php echo $rowc["order_desc"]; ?>
                                    </td>
                                    
									<td>
									<?php
                                        $order_status_id = $rowc["order_status_id"];
                                        $query34 = sprintf("SELECT sup_order_status FROM  sup_order_status where sup_order_status_id = '$order_status_id'");
										$qur34 = mysqli_query($sup_db, $query34);
										$rowc34 = mysqli_fetch_array($qur34);
                                        echo $rowc34["sup_order_status"]; ?>
                                    </td>
									
									<td>
								      <a href="view_order_data.php?id=<?php echo $rowc['order_id']; ?>" class="btn btn-info btn-xs" style="background-color:#1e73be;" target="_blank"><i class="fa fa-eye"></i></a>
									   <button type="button" id="edit" class="btn btn-info btn-xs" title="Edit"
                                                data-id="<?php echo $rowc['order_id']; ?>"
                                                data-c_id ="<?php echo $rowc['c_id']; ?>"
                                                data-order_name="<?php echo $rowc['order_name']; ?>"
                                                data-order_desc="<?php echo $rowc['order_desc']; ?>"
                                                data-order_status_id ="<?php echo $rowc['order_status_id']; ?>"
                                                data-toggle="modal" style="background-color:#1e73be;margin-top: 0px!important;"
                                                data-target="#edit_modal_theme_primary"><i class="fa fa-edit"></i>
                                        </button>
                                        <?php if($order_status_id == 1){ ?>
									<button type="button" id="delete" class="btn btn-danger btn-xs" title="Delete" style="margin-top: 0px!important;" data-id="<?php echo $rowc['order_id']; ?>"><i class="fa fa-delete">-</i> </button>
                                        <?php } else { }?>
                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
               
            </div>
            </div>
        </div>


            <!-- edit modal -->
            <div id="edit_modal_theme_primary" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">
                                Update Order Status
                            </h6>
                        </div>
                        <form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal"
                              method="post">
                            <div class="modal-body">
                                <!--Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label" style="color: #90A4AE">Supplier Name * : </label>
                                            <div class="col-lg-8">
                                                <select required name="edit_c_id" id="edit_c_id"
                                                        class="form-control" disabled>
                                                    <option value="" selected disabled>--- Select Supplier ---
                                                    </option>
													<?php
													$sql1 = "SELECT * FROM `sup_account` ORDER BY `c_name` ASC";
													$result1 = $sup_mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['c_id'] . "'  >" . $row1['c_name'] . "</option>";
													}
													?>
                                                </select>
                                                <input type="hidden" name="edit_id" id="edit_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label" style="color: #90A4AE">Order Name * : </label>
                                            <div class="col-lg-8">
                                                <input type="text" name="edit_order_name" id="edit_order_name"
                                                       class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Order Status * : </label>
                                        <div class="col-lg-8">
                                            <select required name="order_status" id="order_status"
                                                    class="form-control">
                                                <option value="" selected disabled>--- Select Order Status ---
                                                </option>
                                                <?php
                                                $sql11 = mysqli_query($sup_db, "SELECT * FROM `sup_order_status` where sup_sa_os_access = 1 ORDER BY `sup_order_status_id` ASC ");
                                                $selected = "";
                                                while ($row11 = mysqli_fetch_array($sql11)) {
                                                    if ($row11['sup_order_status_id'] == $order_status_id) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    echo "<option value='" . $row11['sup_order_status_id'] . "'  >" . $row11['sup_order_status'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                </div>
								<div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label" style="color: #90A4AE">Order Description : </label>
                                            <div class="col-lg-8">
											<textarea id="edit_order_desc" name="edit_order_desc" rows="3"
                                                      class="form-control" disabled></textarea>
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
            <!-- /dashboard content -->
            <script>
                $(document).on('click', '#delete', function () {
                    var element = $(this);
                    var del_id = element.attr("data-id");
                    var info = 'id=' + del_id;
			        var main_url = "<?php echo $url; ?>";

                    $.ajax({
                        type: "POST", url: "order_delete.php", data: info, success: function (data) {
							
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
                        var c_id = $(this).data("c_id");
                        var order_name = $(this).data("order_name");
                        var order_desc = $(this).data("order_desc");
                        var cust_address = $(this).data("cust_address");
                       
                        $("#edit_c_id").val(c_id);
                        $("#edit_order_name").val(order_name);
                        $("#edit_order_desc").val(order_desc);
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

<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>order_module/create_order.php");
    }
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });	
</script>
<?php include('../footer.php') ?>
</body>
</html>
