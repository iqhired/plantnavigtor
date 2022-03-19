<?php include("./../../sup_config.php");
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
}
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
//$role = $_SESSION["role_id"];
$role = 3;
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
//	header('location: ../line_status_overview_dashboard.php');
}
$user_id = $_SESSION["id"];
if (count($_POST) > 0) {
	$order_status_id = $_POST['edit_order_status'];
	$e_order_status = $_POST['e_order_status'];
	$order_id = $_POST['edit_order_id'];
	if(!is_null($order_status_id) && !empty($order_status_id)){
		$sql = "update sup_order set order_status_id='$order_status_id', modified_on='$chicagotime', modified_by='$user_id' where  order_id = '$order_id'";
		$result1 = mysqli_query($sup_db, $sql);
		if ($result1) {

			$message_stauts_class = 'alert-success';
			$import_status_message = 'Order status Updated successfully.';
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
    <title><?php echo $sitename; ?> | Active Orders</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="./../../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="./../../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="./../../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/core/app.js"></script>
    <script type="text/javascript" src="./../../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="./../../assets/plugins/ui/ripple.min.js"></script>
    <!--chart -->
    <style>
        td {
            /*width:50% !important;*/
        }

        .heading-elements {
            background-color: transparent;
        }

        .line_card {
            background-color: #181d50;
        }

        .bg-blue-400 {
            background-color: #181d50;
        }

        .bg-orange-400 {
            background-color: #dc6805;
        }

        .bg-teal-400 {
            background-color: #218838;
        }

        .bg-pink-400 {
            background-color: #c9302c;
        }

        .dashboard_line_heading {

            padding-top: 5px;
            font-size: 15px !important;
        }

        @media screen and (min-width: 2560px) {
            .dashboard_line_heading {
                font-size: 22px !important;
                padding-top: 5px;
            }
        }

        .thumb img:not(.media-preview) {
            height: 150px !important;
        }
    </style>    <!-- /theme JS files -->
</head>
<body>
<!-- Main navbar -->
<!-- /main navbar -->
<?php
$cam_page_header = "Active Orders";
include("./../sup_header.php");
?>
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main sidebar -->
        <!-- User menu -->
        <!-- /user menu -->
        <!-- Main navigation -->
		<?php include("./../sup_admin_menu.php"); ?>
        <!-- /main navigation -->
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div>
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
            <div class="content">
                <form action="" id="update-form" method="post" class="form-horizontal">
                    <br/>
                    <!-- Main charts -->
                    <!-- Basic datatable -->
                    <div class="panel panel-flat">
                        <table class="table datatable-basic">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Order ID</th>
                                <th>Order Desc</th>
                                <th>Ordered On</th>
                                <th>Order Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  sup_order  where order_active = 1 order by created_on DESC ;  ");
							$qur = mysqli_query($sup_db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								?>
                                <tr>
                                    <td><?php echo ++$counter; ?></td>
									<?php $order_id = $rowc['order_id']; $order_status_id = $rowc['order_status_id'];?>
                                    <td><?php echo $order_id; ?><input hidden id="edit_order_id" name ="edit_order_id" value="<?php echo $order_id; ?>">
                                        <input hidden id="e_order_status" name ="e_order_status" value="<?php echo $order_status_id; ?>"></td>
                                    <td><?php echo $rowc['order_desc']; ?></td>
									<?php

									$qurtemp = mysqli_query($sup_db, "SELECT * FROM  sup_order_status where sup_order_status_id  = '$order_status_id' ");
									while ($rowctemp = mysqli_fetch_array($qurtemp)) {
										$order_status = $rowctemp["sup_order_status"];
									}
									?>
                                    <td><?php echo $rowc['created_on']; ?></td>
                                    <td><select name="edit_order_status" id="edit_order_status" onchange="update_order_status()" class="form-control">
											<?php
											$os_access = 0;
											$os_sa_access = 0;
											if ($role == 3) {
												$os_access = 1;
												$sql1 = "SELECT * FROM `sup_order_status`  ORDER BY `sup_order_status_id` ASC ";
												$result1 = $mysqli->query($sql1);
												$selected = "";
												while ($row1 = $result1->fetch_assoc()) {
													if( $row1['sup_order_status_id'] == $order_status_id){
														$selected = "selected";
													}else{
														$selected = "";
													}
													if ($row1['sup_sa_os_access'] == 1) {
														echo "<option " . $selected . " disabled=\"disabled\" value='" . $row1['sup_order_status_id'] . "' >" . $row1['sup_order_status'] . "</option>";
													} else {
														echo "<option " . $selected . " value='" . $row1['sup_order_status_id'] . "'  >" . $row1['sup_order_status'] . "</option>";
													}

												}
											} else if ($role == 2) {
												$os_sa_access = 1;
												$sql1 = "SELECT * FROM `sup_order_status` ORDER BY `sup_order_status_id` ASC ";
												$result1 = $mysqli->query($sql1);
												while ($row1 = $result1->fetch_assoc()) {
													if( $row1['sup_order_status_id'] == $order_status_id){
														$selected = "selected";
													}else{
														$selected = "";
													}
													if ($row1['sup_os_access'] == 1) {
														echo "<option " . $selected . " disabled=\"disabled\" value='" . $row1['sup_order_status_id'] . "'  >" . $row1['sup_order_status'] . "</option>";
													} else {
														echo "<option " . $selected . " value='" . $row1['sup_order_status_id'] . "'  >" . $row1['sup_order_status'] . "</option>";
													}

												}
											}

											?>
                                        </select></td>
                                    <td>
                                        <button type="submit" id="edit" class="btn btn-info btn">Update</button>
<!--                                        <button type="button" id="edit" class="btn btn-info btn-xs"-->
<!--                                                data-id="--><?php //echo $order_id ?><!--"-->
<!--                                                data-station="--><?php //echo $station_id ?><!--" data-target="#edit_modal_theme_primary">Update</button>-->
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
            <div id="edit_modal_theme_primary" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">
                                Update Event Status
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard content -->
            <!-- /dashboard content -->
            <script>
                function update_order_status() {
                    var updatedVal = $("#edit_order_status").val();
                    $("input#e_order_status").val($("#edit_order_status").val());
                    if(updatedVal == 4){
                        $('#edit_modal_theme_primary').modal('show');
                    }
                }
            </script>
            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '#edit', function () {
                        var element = $(this);
                        var edit_id = $(this).data("id");
                        var station = $(this).data("station");
                        var part_family = $(this).data("part_family");
                        var part_number = $(this).data("part_number");
                        var event_type = $(this).data("event_type_id");
                        $("#edit_station").val(station);
                        $("#edit_part_family").val(part_family);
                        $("#edit_part_number").val(part_number);
                        $("#edit_event_type").val(event_type);
                        $("#edit_id").val(edit_id);
                    });
                });
            </script>
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>

<!-- new footer here -->
<?php
$i = $_SESSION["sqq1"];
if ($i == "") {
	?>

<?php }
?>
<script>
    setTimeout(function () {

        // Closing the alert
        $('.alert-success').fadeIn( 100 ).delay( 100 ).fadeOut( 500 );
    }, 2000);
    setTimeout(function () {
        //alert("reload");
        location.reload();
    }, 60000);
</script>
<?php include("footer.php"); ?> <!-- /page container -->
</body>
</html>