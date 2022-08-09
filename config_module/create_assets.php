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
    $equipment = $_POST['equipment'];
    $description = $_POST['description'];
    $property = $_POST['property'];
    $building = $_POST['building'];
    $created_by = $_SESSION["id"];
//create
    if ($equipment != "") {
        $sql0 = "INSERT INTO `tm_equipment`(`tm_equipment_name`, `created_by` ) VALUES ('$equipment' , '$created_by')";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Equipment created successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
////$temp = "one";
    } else if ($description != "") {
        $sql0 = "INSERT INTO `tm_description`(`tm_description_name`, `created_by` ) VALUES ('$description' , '$created_by')";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Description created successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    } else if ($property != "") {
        $sql0 = "INSERT INTO `tm_property`(`tm_property_name`, `created_by` ) VALUES ('$property' , '$created_by')";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Property created successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    } else if ($building != "") {
        $sql0 = "INSERT INTO `tm_building`(`tm_building_name`, `created_by` ) VALUES ('$building' , '$created_by')";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Building created successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    }
//edit
    $edit_equipment = $_POST['edit_equipment'];
    $edit_description = $_POST['edit_description'];
    $edit_property = $_POST['edit_property'];
    $edit_building = $_POST['edit_building'];
    if ($edit_equipment != "") {
        $id = $_POST['edit_equipment_id'];
        $sql = "update tm_equipment set tm_equipment_name ='$_POST[edit_equipment]'  where tm_equipment_id ='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Equipment Updated successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    } else if ($edit_description != "") {
        $id = $_POST['edit_description_id'];
        $sql = "update tm_description set tm_description_name ='$_POST[edit_description]'  where tm_description_id ='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Description Updated successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    } else if ($edit_property != "") {
        $id = $_POST['edit_property_id'];
        $sql = "update tm_property set tm_property_name ='$_POST[edit_property]'  where tm_property_id ='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Property Updated successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    } else if ($edit_building != "") {
        $id = $_POST['edit_building_id'];
        $sql = "update tm_building set tm_building_name ='$_POST[edit_building]'  where tm_building_id ='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Building Updated successfully.';
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
        <title><?php echo $sitename; ?> | Create Assets</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <link href="../assets/css/extras/animate.min.css" rel="stylesheet" type="text/css">
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
            .col-lg-3{
                width: 40%!important;
            }

            .col-lg-9 {
                float: right;
                width: 60%!important;
            }
            .col-md-4 {
                margin-top: 15px;
            }
            .col-md-6.mob_main {
                width: 50%;
                float: left;
            }
            .col-md-6.mob_main1 {
                width: 50%;
                float: right;
            }
        }
        #myTabContent {
            margin-top: 15px;
        }
        #flash-msg, .alert {

            top: -21px !important;

        }
    </style>

        <!-- Main navbar -->
<?php $cust_cam_page_header = "Assets Configuration";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
    <body class="alt-menu sidebar-noneoverflow">
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
           <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">Select any Assets option</h4>
                            <div class="panel-body">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs  nav-tabs-highlight" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#css-animate-tab1" role="tab" aria-controls="css-animate-tab1" aria-selected="true">Equipment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#css-animate-tab3" role="tab" aria-controls="css-animate-tab3" aria-selected="false">Property</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#css-animate-tab4" role="tab" aria-controls="css-animate-tab4" aria-selected="false">Building</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane animated fadeInUp active" id="css-animate-tab1" role="tabpanel" aria-labelledby="css-animate-tab1-tab">
                                        <form action="" id="user_form" class="form-horizontal" method="post">
                                            <div class="col-md-4">
                                                <input type="text" name="equipment" id="equipment" class="form-control" placeholder="Enter Equipment" required>
                                            </div>
                                            <div class="col-md-4 mobile">
                                                <button type="submit" class="btn btn-primary mob_btn" style="background-color:#1e73be;">Add</button>
                                            </div>
                                        </form>
                                    </div>
<!--                                    <div class="tab-pane animated fadeInUp active" id="home" role="tabpanel" aria-labelledby="home-tab">abc</div>-->
                                    <div class="tab-pane animated fadeInUp" id="css-animate-tab3" role="tabpanel" aria-labelledby="css-animate-tab3-tab">
                                        <form action="" id="user_form" class="form-horizontal" method="post">
                                            <div class="col-md-4">
                                                <input type="text" name="property" id="property" class="form-control" placeholder="Enter Property" required>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary mob_btn" style="background-color:#1e73be;">Add</button>
                                            </div>
                                        </form>
                                    </div>
<!--                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">fvc</div>-->
                                    <div class="tab-pane animated fadeInUp" id="css-animate-tab4" role="tabpanel" aria-labelledby="css-animate-tab4-tab">
                                        <form action="" id="user_form" class="form-horizontal" method="post">
                                            <div class="col-md-4">
                                                <input type="text" name="building" id="building" class="form-control" placeholder="Enter Building" required>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary mob_btn" style="background-color:#1e73be;">Add</button>
                                            </div>
                                        </form>
                                    </div>
<!--                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">sd</div>-->
                                </div> <br/><br/>
<?php
if (!empty($import_status_message)) {
    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
}
?>
<?php
if (!empty($_SESSION['import_status_message'])) {
    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
    $_SESSION['message_stauts_class'] = '';
    $_SESSION['import_status_message'] = '';
}
?>
                            </div>
                        </div>
                        </div>
<!--                        <div class="row">-->
<!--                            <div class="col-md-3">-->
<!--                                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button>-->
<!--                            </div>-->
<!--                        </div>	-->

                        <div class="row">
                            <div class="col-md-6 mob_main">
                                <div class="panel panel-flat">					
                                    <table class="table datatable-basic">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkAll" class="chk_all_eq"></th>
                                                <th>Equipment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                <?php
                                $query = sprintf("SELECT * FROM  tm_equipment where is_deleted!='1'");
                                $qur = mysqli_query($db, $query);
                                while ($rowc = mysqli_fetch_array($qur)) {
                                    ?> 
                                                <tr>
                                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["tm_equipment_id"]; ?>" class="del_eq"></td>
                                                    <td><?php echo $rowc["tm_equipment_name"]; ?></td>
                                                    <td>
                                                        <ul class="icons-list">
                                                            <li class="text-primary-600"><button type="button" data-popup="tooltip" title="Edit" id="edit1" data-id1="<?php echo $rowc['tm_equipment_id']; ?>" data-name1="<?php echo $rowc['tm_equipment_name']; ?>" data-toggle="modal"  data-target="#edit_modal_theme_primary1"><i class="icon-pencil7"></i></button>
                                                            </li>&nbsp; <li class="text-danger-600"><button type="button" id="delete" data-name="equipment" data-id="<?php echo $rowc['tm_equipment_id']; ?>"><i class="icon-trash"></i></button></li>
                                                        </ul>
    <!--									
                                                <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['tm_equipment_id']; ?>">Delete </button>
                                                        -->									
                                                    </td>
                                                </tr>
<?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 mob_main1">
                                <div class="panel panel-flat">					
                                    <table class="table datatable-basic">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkAll" ></th>
                                                <th>Property</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$query = sprintf("SELECT * FROM  tm_property where is_deleted!='1'");
$qur = mysqli_query($db, $query);
while ($rowc = mysqli_fetch_array($qur)) {
    ?> 
                                                <tr>
                                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["tm_property_id"]; ?>"></td>
                                                    <td><?php echo $rowc["tm_property_name"]; ?></td>
                                                    <td>
                                                        <ul class="icons-list">
                                                            <li class="text-primary-600"><button type="button" data-popup="tooltip" title="Edit" id="edit3" data-id3="<?php echo $rowc['tm_property_id']; ?>" data-name3="<?php echo $rowc['tm_property_name']; ?>"  data-toggle="modal"  data-target="#edit_modal_theme_primary3"><i class="icon-pencil7"></i></button>
                                                            </li>&nbsp; <li class="text-danger-600"><button type="button" id="delete" data-name="property" data-id="<?php echo $rowc['tm_property_id']; ?>"><i class="icon-trash"></i></button></li>
                                                        </ul>
                                                        <!--									&nbsp; 
                                                                                                                                <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['line_id']; ?>">Delete </button>
                                                        -->									
                                                    </td>
                                                </tr>
<?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>	
                        <div class="row">
                            <div class="col-md-6 mob_main">
                                <div class="panel panel-flat">					
                                    <table class="table datatable-basic">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkAll" ></th>
                                                <th>Building</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$query = sprintf("SELECT * FROM  tm_building where is_deleted!='1'");
$qur = mysqli_query($db, $query);
while ($rowc = mysqli_fetch_array($qur)) {
    ?> 
                                                <tr>
                                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["tm_building_id"]; ?>"></td>
                                                    <td><?php echo $rowc["tm_building_name"]; ?></td>
                                                    <td>
                                                        <ul class="icons-list">
                                                            <li class="text-primary-600"><button type="button" data-popup="tooltip" title="Edit" id="edit4" data-id4="<?php echo $rowc['tm_building_id']; ?>" data-name4="<?php echo $rowc['tm_building_name']; ?>" data-toggle="modal"  data-target="#edit_modal_theme_primary4"><i class="icon-pencil7"></i></button>
                                                            </li>&nbsp; <li class="text-danger-600"><button type="button" id="delete" data-name="building" data-id="<?php echo $rowc['tm_building_id']; ?>"><i class="icon-trash"></i></button></li>
                                                        </ul>
                                                        <!--									&nbsp; 
                                                                                                                                <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['line_id']; ?>">Delete </button>
                                                        -->									
                                                    </td>
                                                </tr>
<?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>	
                        <!-- /basic datatable -->
                        <!-- /main charts -->
                        <!-- edit modal -->
                        <div id="edit_modal_theme_primary1" class="modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h6 class="modal-title">Update Equipment</h6>
                                    </div>
                                    <form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">Equipment:*</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="edit_equipment" id="edit_equipment" class="form-control" required>
                                                            <input type="hidden" name="edit_equipment_id" id="edit_equipment_id" >
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
                        <div id="edit_modal_theme_primary2" class="modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h6 class="modal-title">Update Description</h6>
                                    </div>
                                    <form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">Description:*</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="edit_description" id="edit_description" class="form-control" required>
                                                            <input type="hidden" name="edit_description_id" id="edit_description_id" >
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
                        <div id="edit_modal_theme_primary3" class="modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h6 class="modal-title">Update Property</h6>
                                    </div>
                                    <form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">Property:*</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="edit_property" id="edit_property" class="form-control" required>
                                                            <input type="hidden" name="edit_property_id" id="edit_property_id" >
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
                        <div id="edit_modal_theme_primary4" class="modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h6 class="modal-title">Update Building</h6>
                                    </div>
                                    <form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label">Building:*</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="edit_building" id="edit_building" class="form-control" required>
                                                            <input type="hidden" name="edit_building_id" id="edit_building_id" >
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
								var del_name = element.attr("data-name");
								                                $.ajax({type: "POST", 
								url: "ajax_assets_delete.php",
								data:{
									info:del_id,
									name:del_name
								},  
								success: function (data) {
									//alert(data);
									
									}});
								$(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                            	
                            });</script>
                        <script>
                            jQuery(document).ready(function ($) {
                                $(document).on('click', '#edit1', function () {
                                    var element = $(this);
                                    var edit_id1 = element.attr("data-id1");
                                    var name1 = $(this).data("name1");
                                    $("#edit_equipment").val(name1);
                                    $("#edit_equipment_id").val(edit_id1);
                                    //alert(role);
                                });
                                $(document).on('click', '#edit2', function () {
                                    var element = $(this);
                                    var edit_id2 = element.attr("data-id2");
                                    var name2 = $(this).data("name2");
                                    $("#edit_description").val(name2);
                                    $("#edit_description_id").val(edit_id2);
                                    //alert(role);
                                });
                                $(document).on('click', '#edit3', function () {
                                    var element = $(this);
                                    var edit_id3 = element.attr("data-id3");
                                    var name3 = $(this).data("name3");
                                    $("#edit_property").val(name3);
                                    $("#edit_property_id").val(edit_id3);
                                    //alert(role);
                                });
                                $(document).on('click', '#edit4', function () {
                                    var element = $(this);
                                    var edit_id4 = element.attr("data-id4");
                                    var name4 = $(this).data("name4");
                                    $("#edit_building").val(name4);
                                    $("#edit_building_id").val(edit_id4);
                                    //alert(role);
                                });
                            });
                        </script>
                        
                        <script>
                            window.onload = function() {
                                history.replaceState("", "", "<?php echo $scriptName; ?>config_module/create_assets.php");
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
        <?php include ('../footer.php') ?>
        <script type="text/javascript" src="../assets/js/core/app.js">
    </body>
</html>
