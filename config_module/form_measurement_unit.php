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

if (count($_POST) > 0) {
    $name = $_POST['name'];
//create
    if ($name != "") {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $unit_of_measurement = $_POST['unit_of_measurement'];
        
        $sql0 = "INSERT INTO `form_measurement_unit`(`name`,`description` , `unit_of_measurement` , `created_at`) VALUES ('$name' , '$description' , '$unit_of_measurement', '$chicagotime')";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Form Unit created successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    }
//edit
    $edit_name = $_POST['edit_name'];
    if ($edit_name != "") {
        $id = $_POST['edit_id'];
        $sql = "update form_measurement_unit set name='$_POST[edit_name]', description ='$_POST[edit_description]' , unit_of_measurement ='$_POST[edit_unit_of_measurement]'  where form_measurement_unit_id='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Form Unit Updated successfully.';
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
        <title><?php echo $sitename; ?> | Form Measurement Unit</title>
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
        <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    </head>
    <style>
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {

            .col-md-3 {

                float: left;
            }
            .col-md-4 {

                float: left;
            }
            .col-md-5 {
                float: left;
                width: 65%;
            }
            .col-md-2.create {
                margin-top: 53px;
            }
            .col-md-2.create {
                margin-top: 130px!important;
                margin-left: 30px;
            }
        }
        .col-md-2.create {
            margin-top: 28px;
            margin-left: 30px;
        }
    </style>

        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Form Measurement Unit";
        include("../header.php");
        include("../admin_menu.php");
        include("../heading_banner.php");
        ?>
        <body class="alt-menu sidebar-noneoverflow">
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">

                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">

                                            <form action="" id="user_form" class="form-horizontal" method="post">
                                                <div class="col-md-12">
                                                <div class="col-md-3">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="description" id="description" class="form-control" placeholder="Enter Description" >
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" name="unit_of_measurement" id="unit_of_measurement" class="form-control" placeholder="Enter Unit Of Measurement" required>
                                                </div>
                                                </div>
                                                <div class="row">
                                                <div class="col-md-2 create">
                                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create</button>
                                                </div>
                                                </div>
                                            </form>


                           <br/>
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
                        </div>
                        <form action="delete_form_measurement_unit.php" method="post" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button>
                                </div>
                            </div>	
                            <br/>	
                            <div class="panel panel-flat">					
                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" ></th>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Unit Of Measurement</th>
                                            <!--    <th>Created At</th>-->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  form_measurement_unit where is_deleted!='1'");
                                        $qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["form_measurement_unit_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["name"]; ?></td>
                                                <td><?php echo $rowc["description"]; ?></td>
                                                <td><?php echo $rowc["unit_of_measurement"]; ?></td>
                                                
        <!--                                        <td>--><?php //echo $rowc['created_at'];        ?><!--</td>-->
                                                <td>
                                                    <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['form_measurement_unit_id']; ?>" data-name="<?php echo $rowc['name']; ?>" data-description="<?php echo $rowc['description']; ?>" data-unit_of_measurement="<?php echo $rowc['unit_of_measurement']; ?>"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
                                                    <!--									&nbsp; 
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['line_id']; ?>">Delete </button>
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
                                    <h6 class="modal-title">Edit Unit</h6>
                                </div>
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Name:*</label>
                                                    <div class="col-lg-7">
                                                        <input type="text" name="edit_name" id="edit_name" class="form-control" required>
                                                        <input type="hidden" name="edit_id" id="edit_id" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Description:</label>
                                                    <div class="col-lg-7">
                                                        <input type="text" name="edit_description" id="edit_description" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
										<div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Unit Of Measurement:*</label>
                                                    <div class="col-lg-7">
                                                        <input type="text" name="edit_unit_of_measurement" id="edit_unit_of_measurement" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										
										
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
                    <script> $(document).on('click', '#delete', function () {
                            var element = $(this);
                            var del_id = element.attr("data-id");
                            var info = 'id=' + del_id;
                            $.ajax({type: "POST", url: "ajax_line_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });</script>
                    <script>
                        jQuery(document).ready(function ($) {
                            $(document).on('click', '#edit', function () {
                                var element = $(this);
                                var edit_id = element.attr("data-id");
                                var name = $(this).data("name");
                                var description = $(this).data("description");
                                var unit_of_measurement = $(this).data("unit_of_measurement");
                                
								
								$("#edit_name").val(name);
                                $("#edit_id").val(edit_id);
                                $("#edit_description").val(description);
                                $("#edit_unit_of_measurement").val(unit_of_measurement);
                               
							   //alert(role);
                            });
                        });
                    </script>
                    
                    <script>
                        window.onload = function() {
                            history.replaceState("", "", "<?php echo $scriptName; ?>config_module/form_measurement_unit.php");
                        }
                    </script>
                    
                    <script>
                        $("#checkAll").click(function () {
                            $('input:checkbox').not(this).prop('checked', this.checked);
                        });
                    </script>
                </div>
                <!-- /content area -->

    </div>
    <!-- /page container -->
        <?php include('../footer.php') ?>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
