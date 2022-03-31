<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
//if($_SESSION['user'] != "admin"){
//	header('location: dashboard.php');
//}
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}
if (count($_POST) > 0) {
    $name = $_POST['name'];
    $parent_id = $_POST['parent_id'];
	if($parent_id == "")
	{
		$parent_id = '0';
	}
    if ($name != "") {
        $name = $_POST['name'];
        $sqlquery = "INSERT INTO `side_menu`(`menu_name`,`parent_id`,`created_at`,`updated_at`) VALUES ('$name','$parent_id','$chicagotime','$chicagotime')";
        if (!mysqli_query($db, $sqlquery)) {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Menu with this Name Already Exists';
        } else {
            $temp = "one";
        }
    }
    $edit_name = $_POST['edit_name'];
    if ($edit_name != "") {
        $id = $_POST['edit_id'];
        $sql = "update side_menu set menu_name='$_POST[edit_name]',parent_id='$_POST[edit_parent_id]',updated_at='$chicagotime' where side_menu_id='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $temp = "two";
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Menu with this Name Already Exists';
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
        <title><?php echo $sitename; ?> | Modules For Access & Permission</title>
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
        <style>
            .sidebar-default .navigation li>a{color:#f5f5f5};
            a:hover {
                background-color: #20a9cc;
            }
            .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
            }
            label.col-lg-5.control-label {
                color: #333;
            }
        </style>
    </head>
    <body>
        <!-- Main navbar -->
        <?php
        $cam_page_header = "Access & Permission";
        include("../header_folder.php");
        include("../admin_menu.php");
        ?>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">

                    <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title"> Modules For Access & Permission</h5>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <form action="" id="user_form" class="form-horizontal" method="post">
                                                <div class="col-md-4">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Menu Name" required>
                                                </div>
												<div class="col-md-5">
                                                    <div class="form-group">
                                                        <select class="select form-control select-border-color" placeholder="Select Parent Group..." name="parent_id" id="parent_id"  >
                                                            <option value="" disabled selected>Select Parent Menu </option> 
                                                            <?php
                                                            $sql1 = "SELECT * FROM `side_menu` where side_menu_id != '1' and parent_id = '0'";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['side_menu_id'] . "'>" . $row1['menu_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>	
                                                </div>
                                                <!--<div class="col-md-4">-->
                                                <!--<input type="number" name="priority_order" id="priority_order" class="form-control" placeholder="Enter Priority Order" required>-->
                                                <!--</div>-->
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create Menu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($temp == "one") { ?>
                                    <br/>					<div class="alert alert-success no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold">Menu</span> Created Successfully.
                                    </div>
                                <?php } ?>
                                <?php if ($temp == "two") { ?>
                                    <br/>					<div class="alert alert-success no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold">Menu</span> Updated Successfully.
                                    </div>
                                <?php } ?>
                                <?php
                                if (!empty($import_status_message)) {
                                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                                }
                                ?>
                                <?php
                                if (!empty($_SESSION[import_status_message])) {
                                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                    $_SESSION['message_stauts_class'] = '';
                                    $_SESSION['import_status_message'] = '';
                                }
                                ?>
                            </div>
                        </div>
                        <form action="delete_menu.php" method="post" class="form-horizontal">
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
                                            <th>Menu Name</th>
                                            <th>Parent Menu</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  side_menu where side_menu_id != '1'");
                                        $qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["side_menu_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["menu_name"]; ?></td>
                                                <td><?php echo $rowc["parent_id"]; ?></td>
                                                <td>
                                                    <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['side_menu_id']; ?>" data-parent_id="<?php echo $rowc['parent_id']; ?>" data-name="<?php echo $rowc['menu_name']; ?>"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
                                                    <!--									&nbsp; 
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['role_id']; ?>">Delete </button>
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
                    <div id="modal_theme_primary1" class="modal ">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title">Create Menu</h6>
                                </div>
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="modal-body"  style="color: #FFFFFF;">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Menu:*</label>
                                                    <div class="col-lg-7">
                                                        <input type="text" name="name" id="name" class="form-control" required>
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
                    <!-- edit modal -->
                    <div id="edit_modal_theme_primary" class="modal ">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title">Update Menu</h6>
                                </div>
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="modal-body" style="color: #FFFFFF;">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Menu Name:*</label>
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
                                                    <label class="col-lg-5 control-label">Parent Menu:*</label>
                                                    <div class="col-lg-7">
                                                        <select name="edit_parent_id" id="edit_parent_id" class=" select form-control" >
                                                            <option value="" disabled>--- Select Parent Menu ---</option>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `side_menu` where side_menu_id != '1' and parent_id = '0'";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['side_menu_id'] . "'$entry>" . $row1['menu_name'] . "</option>";
                                                            }
                                                            ?>
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
                            $.ajax({type: "POST", url: "ajax_role_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });</script>
                    <script>
                        jQuery(document).ready(function ($) {
                            $(document).on('click', '#edit', function () {
                                var element = $(this);
                                var edit_id = element.attr("data-id");
                                var name = $(this).data("name");
                                var parent_id = $(this).data("parent_id");
                                $("#edit_name").val(name);
                                $("#edit_parent_id").val(parent_id);
                                $("#edit_id").val(edit_id);
                                //alert(role);
                            });
                        });
                    </script>
                  
                </div>
                <!-- /content area -->

    <!-- /page container -->


    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
        <?php include ('../footer.php') ?>

</body>
</html>
