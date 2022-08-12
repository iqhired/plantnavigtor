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
    $group_id = $_POST['group_id'];
    $created_by = $_SESSION["id"];
    if ($name != "") {
        $sql0 = "INSERT INTO `sg_taskboard`(`taskboard_name`,`group_id` , `created_by` ) VALUES ('$name' , '$group_id' , '$created_by')";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
            $query1 = sprintf("SELECT * FROM `sg_taskboard` where taskboard_name = '$name'");
            $qur1 = mysqli_query($db, $query1);
            $rowc1 = mysqli_fetch_array($qur1);
            $val = $rowc1['sg_taskboard_id'];
            $sql1 = "INSERT INTO `tm_task_log_config`( `taskboard` ) VALUES ('$val')";
            $result11 = mysqli_query($db, $sql1);
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Taskboard created successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
////$temp = "one";
    }
    $edit_name = $_POST['edit_name'];
    if ($edit_name != "") {
        $id = $_POST['edit_id'];
        $sql = "update sg_taskboard set taskboard_name ='$_POST[edit_name]', group_id ='$_POST[edit_group_id]'  where sg_taskboard_id ='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Taskboard Updated successfully.';
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
        <title><?php echo $sitename; ?> | Create Taskboard</title>
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
        <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
<!--        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>-->

        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
        <!--    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>-->
    </head>
    <style>
        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px)  {
            .col-lg-9 {
                float: right;
                width: 68%;
            }
            label.col-lg-3.control-label {
                width: 32%;
            }
            .col-md-3 {
                width: 100%;
            }
            .modal-dialog {
                margin: 60px;
            }
        }
    </style>

        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Create Taskboard";
        include("../header.php");
        include("../admin_menu.php");
        include("../heading_banner.php");
        ?>
        <body class="alt-menu sidebar-noneoverflow">
        <!-- /main navbar -->

                    <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <!--							<h5 class="panel-title">Stations</h5>-->
                                <!--							<hr/>-->
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Name : </label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="name" id="name" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Group Name : </label>
                                                <div class="col-lg-9">
                                                    <select name="group_id" id="group_id" class="select form-control" data-style="bg-slate">
                                                        <option value="" selected disabled>--- Select Group ---</option>
                                                        <?php
                                                        $sql1 = "SELECT DISTINCT `group_id` FROM `sg_group` where is_deleted != '1'";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            $station1 = $row1['group_id'];
                                                            $qurtemp = mysqli_query($db, "SELECT group_name FROM  sg_group where group_id = '$station1' ");
                                                            $rowctemp = mysqli_fetch_array($qurtemp);
                                                            $station = $rowctemp["group_name"];
                                                            echo "<option value='" . $row1['group_id'] . "'$entry>" . $station . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary"

                                            >Create Taskboard</button>
                                        </div>
                                    </div>
                                </form>
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
                        <form action="delete_taskboard.php" method="post" class="form-horizontal">
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
                                            <th>Group</th>
                                            <th>Created By</th>
      <!--                                      <th>Created At</th>-->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  sg_taskboard");
                                        $qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["sg_taskboard_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["taskboard_name"]; ?></td>
                                                <?php
                                                $station1 = $rowc['group_id'];
                                                $qurtemp = mysqli_query($db, "SELECT * FROM  sg_group where group_id = '$station1' ");
                                                while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                                                    $station = $rowctemp["group_name"];
                                                }
                                                ?>
                                                <td><?php echo $station; ?></td>
                                                <?php
                                                $un = $rowc['created_by'];
                                                $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                                                while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                    $first = $rowc04["firstname"];
                                                    $last = $rowc04["lastname"];
                                                }
                                                ?>
                                                <td><?php echo $first; ?>&nbsp;<?php echo $last; ?></td>
                                                <td>
                                                    <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['sg_taskboard_id']; ?>" data-name="<?php echo $rowc['taskboard_name']; ?>" data-group_id="<?php echo $rowc['group_id']; ?>" data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
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
                                    <h6 class="modal-title">Edit Taskboard</h6>
                                </div>
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group modal_group">
                                                    <label class="col-lg-3 control-label modal_label">Name:*</label>
                                                    <div class="col-lg-9 modal_text">
                                                        <input type="text" name="edit_name" id="edit_name" class="form-control" required>
                                                        <input type="hidden" name="edit_id" id="edit_id" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group modal_group">
                                                    <label class="col-lg-3 control-label modal_label">Group Name:*</label>
                                                    <div class="col-lg-9 modal_text">
                                                        <select name="edit_group_id" id="edit_group_id" class="select select2 form-control" data-style="bg-slate">
<!--                                                            <option value="" selected disabled>--- Select Group ---</option>-->
                                                            <?php
                                                            $sql1 = "SELECT DISTINCT `group_id` FROM `sg_group` where is_deleted != 1";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                $station1 = $row1['group_id'];
                                                                $qurtemp = mysqli_query($db, "SELECT group_name FROM  sg_group where group_id = '$station1' and is_deleted != 1 ");
                                                                $rowctemp = mysqli_fetch_array($qurtemp);
                                                                $station = $rowctemp["group_name"];
                                                                echo "<option value='" . $row1['group_id'] . "'$entry>" . $station . "</option>";
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
                            $.ajax({type: "POST", url: "ajax_line_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });</script>
                    <script>
                        jQuery(document).ready(function ($) {
                            $(document).on('click', '#edit', function () {
                                var element = $(this);
                                var edit_id = element.attr("data-id");
                                var name = $(this).data("name");
                                var group_id = $(this).data("group_id");
                                $("#edit_name").val(name);
                                $("#edit_id").val(edit_id);
                                $("#edit_group_id").val(group_id);
                                //alert(role);
                                const sb = document.querySelector('#group_id');
                                const sb1 = document.querySelector('#edit_group_id');
                                // create a new option
                                // var pnums = part_number.split(',');
                                var options = sb.options;
                                var options1 = sb1.options;
                                // $("#edit_part_number").val(options);
                                $('#edit_modal_theme_primary .select2 .selection select2-selection select2-selection--single .select2-selection__choice').remove();

                                for (var i = 0; i < options1.length; i++) {
                                    if(group_id == (options1[i].value)){ // EDITED THIS LINE
                                        options1[i].selected="selected";
                                        options1[i].className = ("select2-results__option--highlighted");
                                        var opt = options1[i].outerHTML.split(">");
                                        $('#select2-results .select2-results__option').prop('selectedIndex',i);
                                        var gg = '<span class="select2-selection__rendered" id="select2-edit_group_id-container" title="' + opt[1].replace('</option','') + '">' + opt[1].replace('</option','') + '</span>';
                                        $("#select2-edit_group_id-container")[0].outerHTML = gg;
                                    }
                                }
                            });
                        });
                    </script>
                    
                    <script>
                        window.onload = function() {
                            history.replaceState("", "", "<?php echo $scriptName; ?>taskboard_module/create_taskboard.php");
                        }
                    </script>
                    
                    <script>
                        $("#checkAll").click(function () {
                            $('input:checkbox').not(this).prop('checked', this.checked);
                        });
                    </script>
                </div>
                <!-- /content area -->

    <?php include ('../footer.php') ?>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>
