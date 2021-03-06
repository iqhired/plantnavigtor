<?php include("../config.php");
$import_status_message = "";
include("../sup_config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	header('location: ../logout.php');
}
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
	header('location: ../dashboard.php');
}

if (count($_POST) > 0) {

	$order_name = $_POST['order_name'];
//create
  	if ($order_name != "") {
		$c_id = $_POST['c_id'];
		$order_name = $_POST['order_name'];
		$order_desc = $_POST['order_desc'];
		$created_by = $_SESSION['id'];
            
		$sql = "INSERT INTO `sup_order`( `c_id`, `order_name`, `order_desc`, `order_status_id`, `order_active`, `created_on`, `created_by`) VALUES ('$c_id','$order_name','$order_desc','1','1','$created_by','$chicagotime')";
		
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
 	$edit_order_name = $_POST['edit_order_name'];
	if ($edit_order_name != "") {
	
		$id = $_POST['edit_id'];
//eidt logo
				$sql = "update sup_order set c_id='$_POST[edit_c_id]',order_desc='$_POST[edit_order_desc]',order_name='$_POST[edit_order_name]' where order_id='$id'";
		
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
<?php $cam_page_header = "Create Order";
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
                                <!--Address -->
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
                                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create Order
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="content">
                    
                    <!-- Main charts -->
                    <!-- Basic datatable -->
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
							$query = sprintf("SELECT * FROM  sup_order ;  ");
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
										<button type="button" id="view" class="btn btn-info btn-xs" title="View"
                                                data-id="<?php echo $rowc['order_id']; ?>"
                                                data-c_id ="<?php echo $rowc['c_id']; ?>"
                                                data-order_name="<?php echo $rowc['order_name']; ?>"
                                                data-order_desc="<?php echo $rowc['order_desc']; ?>"
                                                data-order_status_id ="<?php echo $rowc['order_status_id']; ?>"
                                                data-toggle="modal" style="background-color:#1e73be;"
                                                data-target="#view_modal_theme_primary"><i class="glyphicon glyphicon-eye-open"></i> 
                                        </button>
								&nbsp;	
									   <button type="button" id="edit" class="btn btn-info btn-xs" title="Edit"
                                                data-id="<?php echo $rowc['order_id']; ?>"
                                                data-c_id ="<?php echo $rowc['c_id']; ?>"
                                                data-order_name="<?php echo $rowc['order_name']; ?>"
                                                data-order_desc="<?php echo $rowc['order_desc']; ?>"
                                                data-order_status_id ="<?php echo $rowc['order_status_id']; ?>"
                                                data-toggle="modal" style="background-color:#1e73be;"
                                                data-target="#edit_modal_theme_primary"><i class="glyphicon glyphicon-edit"></i> 
                                        </button>
								&nbsp;	<button type="button" id="delete" class="btn btn-danger btn-xs" title="Delete" data-id="<?php echo $rowc['order_id']; ?>"><i class="icon-cancel-circle2"></i> </button>
                                                   							
                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
               
            </div>
            <!-- view modal -->
            <div id="view_modal_theme_primary" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">
                                View Order
                            </h6>
                        </div>
                        <form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal"
                              method="post">
                            <div class="modal-body">
                                <!--Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Supplier Name * : </label>
                                            <div class="col-lg-8">
                                                <select required name="view_c_id" disabled id="view_c_id"
                                                        class="form-control">
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
                                                <input type="hidden" name="view_id" id="view_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Order Name * : </label>
                                            <div class="col-lg-8">
                                                <input type="text" name="view_order_name" disabled id="view_order_name"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
								<div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Order Description : </label>
                                            <div class="col-lg-8">
											<textarea id="view_order_desc" disabled name="view_order_desc" rows="3"
                                                      class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               

<div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>                            
							</div>
                            </div>
                            
                        </form>
                    </div>
                </div>

            <!--/ view modal -->

            <!-- edit modal -->
            <div id="edit_modal_theme_primary" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">
                                Update Order
                            </h6>
                        </div>
                        <form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal"
                              method="post">
                            <div class="modal-body">
                                <!--Part Number-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Supplier Name * : </label>
                                            <div class="col-lg-8">
                                                <select required name="edit_c_id" id="edit_c_id"
                                                        class="form-control">
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
                                            <label class="col-lg-4 control-label">Order Name * : </label>
                                            <div class="col-lg-8">
                                                <input type="text" name="edit_order_name" id="edit_order_name"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
								<div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Order Description : </label>
                                            <div class="col-lg-8">
											<textarea id="edit_order_desc" name="edit_order_desc" rows="3"
                                                      class="form-control"></textarea>
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
<script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '#view', function () {
                        var element = $(this);
                        var edit_id = element.attr("data-id");
                        var c_id = $(this).data("c_id");
                        var order_name = $(this).data("order_name");
                        var order_desc = $(this).data("order_desc");
                        var cust_address = $(this).data("cust_address");
                       
                        $("#view_c_id").val(c_id);
                        $("#view_order_name").val(order_name);
                        $("#view_order_desc").val(order_desc);
                        $("#view_id").val(edit_id);
                    });
                });
				
	        </script>
			
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
