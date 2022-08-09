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
if (count($_POST) > 0) {
    $name = $_POST['name'];

//create
    if ($name != "") {
        $name = $_POST['name'];
        $sqlquery = "INSERT INTO `cam_shift`(`shift_name`,`created_at`,`updated_at`) VALUES ('$name','$chicagotime','$chicagotime')";
        if (!mysqli_query($db, $sqlquery)) {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Shift/Location with this Name Already Exists';
        } else {
            $temp = "one";
        }
    }
//edit
    $edit_name = $_POST['edit_name'];
    if ($edit_name != "") {
        $id = $_POST['edit_id'];
        $sql = "update cam_shift set shift_name='$_POST[edit_name]',updated_at='$chicagotime' where shift_id='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $temp = "two";
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Shift/Location with this Name Already Exists';
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
        <title><?php echo $sitename; ?> | Shift / Location</title>
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
        <style>
            .sidebar-default .navigation li>a{color:#f5f5f5};
            a:hover {
                background-color: #20a9cc;
            }
            .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
            }
            @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
                .col-md-6 {
                    float: left;
                }
                .col-md-4 {
                    float: right;
                }
                .col-md-4.mob_user {
                    float: left;
                    margin-top: 10px;
                }
            }
        </style>
    </head>

        <!-- Main navbar -->
<?php $cust_cam_page_header = "Shift Configuration Management";
 include("../header.php");
 include("../admin_menu.php");
include("../heading_banner.php");?>
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
                                <!--							<h5 class="panel-title">Shift / Location</h5>-->
                                <!--							<hr/>-->
                                <div class="row">
                                    <div class="col-md-9">

                                            <form action="" id="user_form" class="form-horizontal" method="post">
                                                <div class="col-md-6 mob_user">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Shift Location" required>
                                                </div>
                                                <div class="col-md-4 mob_user">
                                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create Shift Location</button>
                                                </div>
                                            </form>

                                    </div>
                                </div><br/>
<?php if ($temp == "one") { ?>
                                    <div class="alert alert-success no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold">Shift/Location</span> Created Successfully.
                                    </div>
<?php } ?>
<?php if ($temp == "two") { ?>
                                    <div class="alert alert-success no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold">Shift/Location</span> Updated Successfully.
                                    </div>
<?php } ?>
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
                        <form action="delete_shift_location.php" method="post" class="form-horizontal">
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
                                            <th>Sl. No</th>
                                            <th>Shift / Location</th>
<!--                                      <th>Created At</th>-->
<!--                                      <th>Updated At</th>-->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$query = sprintf("SELECT * FROM  cam_shift where is_deleted!='1'");
$qur = mysqli_query($db, $query);
while ($rowc = mysqli_fetch_array($qur)) {
    ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["shift_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["shift_name"]; ?></td>
      <!--                                         <td>--><?php //echo $rowc['created_at']; ?><!--</td>-->
      <!--                                        <td>--><?php //echo $rowc['updated_at']; ?><!--</td>-->
                                                <td>
                                                    <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['shift_id']; ?>" data-name="<?php echo $rowc['shift_name']; ?>"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
                                                    <!--									&nbsp; 
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['shift_id']; ?>">Delete </button>
                                                    -->									
                                                </td>
                                            </tr>
<?php } ?>
                                    </tbody>
                                </table>
                        </form>					</div>
                    <!-- /basic datatable -->
                    <!-- /main charts -->
                    <!-- edit modal -->
                    <div id="edit_modal_theme_primary" class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title">Edit Shift/Location</h6>
                                </div>
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Shift/Location:*</label>
                                                    <div class="col-lg-7">
                                                        <input type="text" name="edit_name" id="edit_name" class="form-control" required>
                                                        <input type="hidden" name="edit_id" id="edit_id" >
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
                            $.ajax({type: "POST", url: "ajax_shift_location_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });</script>
                    <script>
                        jQuery(document).ready(function ($) {
                            $(document).on('click', '#edit', function () {
                                var element = $(this);
                                var edit_id = element.attr("data-id");
                                var name = $(this).data("name");
                                $("#edit_name").val(name);
                                $("#edit_id").val(edit_id);
                                //alert(role);
                            });
                        });
                    </script>

                </div>
                <!-- /content area -->

    <!-- /page container -->

<script>
window.onload = function() {
    history.replaceState("", "", "<?php echo $scriptName; ?>config_module/shift_location.php");
}
</script>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
        <?php include('../footer.php') ?>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
