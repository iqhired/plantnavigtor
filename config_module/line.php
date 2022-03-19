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
        $priority_order = $_POST['priority_order'];
        $enabled = $_POST['enabled'];
        $sql0 = "INSERT INTO `cam_line`(`line_name`,`priority_order` , `enabled` , `created_at`) VALUES ('$name' , '$priority_order' , '$enabled', '$chicagotime')";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Station created successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    }
//edit
    $edit_name = $_POST['edit_name'];
    if ($edit_name != "") {
        $id = $_POST['edit_id'];
        $sql = "update cam_line set line_name='$_POST[edit_name]', priority_order='$_POST[edit_priority_order]' , enabled='$_POST[edit_enabled]'  where line_id='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Station Updated successfully.';
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
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-md-3 {
                float: left;
            }
            .col-md-4 {
                float: left;
            }
            .col-md-2 {
                float: right;
            }
        }
    </style>

        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Station Configuration Management";
        include("../header.php");
        include("../heading_banner.php");
        include("../admin_menu.php");
        ?>
    <body class="alt-menu sidebar-noneoverflow">
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
                                <!--							<h5 class="panel-title">Stations</h5>-->
                                <!--							<hr/>-->
                                <div class="row">


                                            <form action="" id="user_form" class="form-horizontal" method="post">
                                                <div class="col-md-12">
                                                <div class="col-md-3">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Station" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" name="priority_order" id="priority_order" class="form-control" placeholder="Enter Priority Order" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">Enabled : </label>
                                                    <select  name="enabled" id="enabled" class="select form-control" data-style="bg-slate" style="float: left;
                                                             width: initial;" >
                                                        <!--        <option value="" selected disabled>--- Select Ratings ---</option>-->
                                                        <option value="0" >No</option>
                                                        <option value="1" >Yes</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mob_user">
                                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create Station</button>
                                                </div>
                                                </div>
                                            </form>


                                </div><br/>
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
                        </div>
                        <form action="delete_line.php" method="post" class="form-horizontal">
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
                                            <th>Station</th>
                                            <th>Priority Order</th>
                                            <th>Enabled</th>
                                            <th>Good Bad Pieces Required</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  cam_line");
                                        $qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["line_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["line_name"]; ?></td>
                                                <td><?php echo $rowc["priority_order"]; ?></td>
                                                <td><?php
                                                    $yn_result = ($rowc['enabled'] == 0) ? "No" : "Yes";
                                                    echo $yn_result;
                                                    ?></td>
        <!--                                        <td>--><?php //echo $rowc['created_at'];        ?><!--</td>-->
                                                <td>

<!--                                                    <label class="checkbox-switchery" style="margin-bottom:16px;" >-->
                                                        <input type="checkbox" name="gbpd" id="gbpd" value="<?php echo $rowc["line_id"]; ?>" <?php echo ($rowc['gbd_id']==1 ? 'checked' : '');?>>
<!--                                                    </label>-->
                                                </td>

                                                <td>

                                                    <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['line_id']; ?>" data-name="<?php echo $rowc['line_name']; ?>" data-priority_order="<?php echo $rowc['priority_order']; ?>" data-enabled="<?php echo $rowc['enabled']; ?>" data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
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
                                    <h6 class="modal-title">Edit Station</h6>
                                </div>
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="modal-body" style="color: #fff5f5">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Station:*</label>
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
                                                    <label class="col-lg-5 control-label">Priority Order:*</label>
                                                    <div class="col-lg-7">
                                                        <input type="number" name="edit_priority_order" id="edit_priority_order" class="form-control" required>
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
                                                                 width: initial;" >
                                                            <!--        <option value="" selected disabled>--- Select Ratings ---</option>-->
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
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
                                var priority_order = $(this).data("priority_order");
                                var enabled = $(this).data("enabled");
                                $("#edit_name").val(name);
                                $("#edit_id").val(edit_id);
                                $("#edit_priority_order").val(priority_order);
                                $("#edit_enabled").val(enabled);
                                //alert(role);
                            });
                        });
                    </script>
                    
                    <script>
                        window.onload = function() {
                            history.replaceState("", "", "<?php echo $scriptName; ?>config_module/line.php");
                        }
                    </script>
                    
                    <script>
                        $("#checkAll").click(function () {
                            $('input:checkbox').not(this).prop('checked', this.checked);
                        });
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

                </div>
                <!-- /content area -->

    </div>
    <!-- /page container -->
        <?php include('../footer.php') ?>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
