<?php
include("config.php");
$sessionid = $_SESSION["id"];
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
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
    header('location: dashboard.php');
}
if (count($_POST) > 0) {
    $name = $_POST['group_name'];
    if ($name != "") {
//$group_id = $_POST['group_id'];
        $group_name = $_POST['group_name'];
        $parent_id = $_POST['parent_id'];
        $disc = $_POST['disc'];
        $sql12 = "INSERT INTO `sg_group`(`group_name`,`parent_id`,`description`,`creator_id`,`datetime`) VALUES ('$group_name','$parent_id','$disc','$sessionid','$chicagotime')";
        if (!mysqli_query($db, $sql12)) {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Try Again.';
        } else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Group Relation Created Sucessfully.';
        }
    }
    $edit_name = $_POST['edit_name'];
    if ($edit_name != "") {
        $id = $_POST['edit_id'];
        $sql = "update sg_group set group_name ='$_POST[edit_name]',parent_id ='$_POST[edit_parent]', description ='$_POST[edit_disc]' where group_id ='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Group Relation Updated Sucessfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Role with this Name Already Exists';
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
        <title><?php echo $sitename; ?> | Group</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
        <style>
            .sidebar-default .navigation li>a{color:#f5f5f5};
            a:hover {
                background-color: #20a9cc;
            }
            .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
            }
            /*.select2-container--default .select2-selection--single .select2-selection__rendered {*/
            /*    color: #fff5f5!important;*/
            /*    line-height: 20px!important;*/
            /*}*/
            @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
                .col-md-3{
                    float: left;
                }
                .col-md-4{
                    float: left;
                }
                .col-md-2{
                    float: right;
                }
            }
        </style>
    </head>
    <body>
        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Group(s)";
        include("header.php");

        include("admin_menu.php");
        include("heading_banner.php");
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
                                <h5 class="panel-title">Group List</h5>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">

                                            <form action="" id="user_form" class="form-horizontal" method="post">
                                                <div class="col-md-3">
                                                    <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Enter Group Name" required>
                                                </div>
                                                <!--<div class="col-md-4">-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select class="select form-control " placeholder="Select Parent Group..." name="parent_id" id="parent_id"  data-style="bg-slate">
                                                            <option value="" disabled selected> Select Parent Group </option>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `sg_group`";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['group_id'] . "'>" . $row1['group_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>	
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="disc" id="disc" class="form-control" placeholder="Enter Group Description" required>
                                                </div>
                                                <!--<input type="number" name="priority_order" id="priority_order" class="form-control" placeholder="Enter Priority Order" required>-->
                                                <!--</div>-->
                                                <div class="col-md-2 mob_user">
                                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create Group</button>
                                                </div>
                                            </form>

                                    </div>
                                </div>
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
                        <form action="delete_group_list.php" method="post" class="form-horizontal">
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
                                            <th>Parent Group</th>
                                            <th>Discription</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  sg_group where is_deleted!='1' ");
                                        $qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["group_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["group_name"]; ?></td>
                                                <?php
                                                $station1 = $rowc['parent_id'];
                                                $qurtemp = mysqli_query($db, "SELECT * FROM  sg_group where group_id = '$station1' ");
                                                while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                                                    $station = $rowctemp["group_name"];
                                                }
                                                if ($station1 == "0") {
                                                    $station = "-";
                                                }
                                                ?>
                                                <td><?php echo $station; ?></td>
                                                <td><?php echo $rowc['description']; ?></td>
                                                <td>
                                                    <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['group_id']; ?>" data-name="<?php echo $rowc['group_name']; ?>" data-parent="<?php echo $rowc['parent_id']; ?>" data-disc="<?php echo $rowc['description']; ?>"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
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
                    <!-- edit modal -->
                    <div id="edit_modal_theme_primary" class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title">Update Group</h6>
                                </div>
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Group Name:*</label>
                                                    <div class="col-lg-7">
                                                        <input type="text" name="edit_name" id="edit_name" class="form-control" required>
                                                        <input type="hidden" name="edit_id" id="edit_id" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">`
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Parent Group:*</label>
                                                    <div class="col-lg-7">
                                                        <select name="edit_parent" id="edit_parent" class="select form-control" >
                                                            <option value="" disabled>--- Select Parent Group ---</option>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `sg_group`";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['group_id'] . "'$entry>" . $row1['group_name'] . "</option>";
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
                                                    <label class="col-lg-4 control-label">Discription:*</label>
                                                    <div class="col-lg-7">
                                                        <input type="text" name="edit_disc" id="edit_disc" class="form-control" required>
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
                                var parent = $(this).data("parent");
                                var disc = $(this).data("disc");
                                console.log(name);
                                $("#edit_name").val(name);
                                $("#edit_id").val(edit_id);
                                $("#edit_parent").val(parent);
                                $("#edit_disc").val(disc);
                                //alert(role);

                                // Load Taskboard
                                const sb1 = document.querySelector('#edit_parent');
                                var options1 = sb1.options;
                                $('#edit_modal_theme_primary .select2 .selection select2-selection select2-selection--single .select2-selection__choice').remove();
                                for (var i = 0; i < options1.length; i++) {
                                    if(parent == (options1[i].value)){ // EDITED THIS LINE
                                        options1[i].selected="selected";
                                        options1[i].className = ("select2-results__option--highlighted");
                                        var opt = options1[i].outerHTML.split(">");
                                        $('#select2-results .select2-results__option').prop('selectedIndex',i);
                                        var gg = '<span class="select2-selection__rendered" id="select2-edit_parent-container" title="' + opt[1].replace('</option','') + '">' + opt[1].replace('</option','') + '</span>';
                                        $("#select2-edit_parent-container")[0].outerHTML = gg;
                                    }
                                }
                            });
                        });
                    </script>
                    
                </div>
                <!-- /content area -->

    </div>
    <!-- /page container -->

    <script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $scriptName; ?>group.php");
        }
    </script>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

        <?php include ('footer.php') ?>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>
