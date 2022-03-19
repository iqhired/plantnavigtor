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
//if($_SESSION['user'] != "admin"){
//	header('location: dashboard.php');
//}
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}
if (count($_POST) > 0) {
    $edit_name = $_POST['edit_name'];
    $id = $_POST['edit_id'];
    if ($id != "") {
        $id = $_POST['edit_id'];
        $sql = "update cam_users set job_title_description='$_POST[edit_job_title_description]',shift_location='$_POST[edit_shift_location]' where users_id='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'User Updated Successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Try Again.';
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
        <title><?php echo $sitename; ?> | Taskboard Users</title>
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
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
    	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_popups.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/switchery.min.js"></script>
       <style>
            .sidebar-default .navigation li>a{color:#f5f5f5};
            a:hover {
                background-color: #20a9cc;
            }
            .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
            }
        </style>
    </head>

        <!-- Main navbar -->
        <?php
        $cam_page_header = "Taskboard Users List";
        include("../admin_menu.php");
        ?>

    <body class="alt-menu sidebar-noneoverflow">
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">

                    <div class="content">
                        <?php if (!empty($import_status_message)) { ?>
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <?php echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>'; ?>
                                </div>
                            </div>						
                        <?php } ?>	
                        <?php if (!empty($_SESSION['import_status_message'])) { ?>
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <?php
                                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                    $_SESSION['message_stauts_class'] = '';
                                    $_SESSION['import_status_message'] = '';
                                    ?>
                                </div>
                            </div>						
                        <?php } ?>
                        <form action="" id="update-form" method="post" class="form-horizontal">
                            <!-- Main charts -->
                            <!-- Basic datatable -->
                            <div class="panel panel-flat">                        						
                                <table class="table datatable-basic" id="example1">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Group</th>
                                            <th>Role</th>
                                            <th>Available</th>
<!--       <th>Action</th>
                                            -->       
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $group_id = $_GET['group_id'];
                                        $query = sprintf("SELECT * FROM  sg_user_group where group_id = '$group_id'  ;  ");
                                        $qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            $tm_task_id = "";
                                            $uid = $rowc["user_id"];
                                            $query2 = sprintf("SELECT * FROM  cam_users where role != '1' and users_id = '$uid' order by `firstname` ;  ");
                                            $qur2 = mysqli_query($db, $query2);
                                            $rowc2 = mysqli_fetch_array($qur2);
                                            ?> 
                                            <tr>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc2["firstname"]; ?>&nbsp;<?php echo $rowc2["lastname"]; ?></td>
                                                <?php
                                                $position = "";
                                                $position1 = $rowc2['users_id'];
                                                $qurtemp1 = mysqli_query($db, "SELECT * FROM  sg_user_group where user_id = '$position1' ");
                                                while ($rowctemp1 = mysqli_fetch_array($qurtemp1)) {
                                                    $qur1 = mysqli_query($db, "SELECT group_name FROM sg_group where group_id = '$rowctemp1[group_id]' ");
                                                    $rowc1 = mysqli_fetch_array($qur1);
                                                    $position .= $rowc1["group_name"] . " , ";
                                                }
                                                ?>                                
                                                <td><?php echo $position; ?></td>
                                                <td><?php
                                                    $qur1 = mysqli_query($db, "SELECT role_name FROM cam_role where role_id = '$rowc2[role]' ");
                                                    $rowc1 = mysqli_fetch_array($qur1);
                                                    echo $rowc1["role_name"];
                                                    ?>
                                                </td>
                                                <td >
                                                       <?php
                                                        $qur3 = mysqli_query($db, "SELECT tm_task_id FROM tm_task where  assign_to = '$uid' and status = '1' ");
                                                        $rowc3 = mysqli_fetch_array($qur3);
                                                        $tm_task_id = $rowc3["tm_task_id"];
                                                        if ($tm_task_id == "") {
                                                            ?>
                                                            <?php
                                                            $available = $rowc2['available'];
                                                            if ($available == '1') {
                                                                ?>
															<label class="checkbox-switchery switchery-xs " style="margin-bottom:16px;" >	
                                                                <input type="checkbox" style="opacity:0;"  class="switchery custom_switch" checked='checked' data-id="<?php echo $rowc2['users_id']; ?>" data-available="<?php echo $rowc2['available']; ?>">
                                                            </label>
															<?php } else { ?>		
                                                            <label class="checkbox-switchery switchery-xs " style="margin-bottom:16px;" >
															<input type="checkbox" style="opacity:0;" class="switchery custom_switch" data-id="<?php echo $rowc2['users_id']; ?>" data-available="<?php echo $rowc2['available']; ?>">
															</label>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?> 
															
															<label class="checkbox-switchery switchery-xs " style="margin-bottom:16px;" data-popup="tooltip" title="Personnel is assigned to a task. Finish task to mark Personnel unavailable">	
                                                            <input type="checkbox" disabled style="opacity:0;"  class="switchery custom_switch" checked='checked' data-id="<?php echo $rowc2['users_id']; ?>" data-available="<?php echo $rowc2['available']; ?>">
															</label>
                                                        <?php } ?>
                                                    
                                                </td>  
            <!--	 <td>
            <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc2['users_id']; ?>" data-name="<?php echo $rowc2['user_name']; ?>"   data-email="<?php echo $rowc2['email']; ?>" data-phone="<?php echo $rowc2['mobile']; ?>" data-role="<?php echo $rowc2['role']; ?>" data-s_q1="<?php echo $rowc2['s_question1']; ?>" data-s_q2="<?php echo $rowc2['s_question2']; ?>" data-s_q3="<?php echo $rowc2['s_question3']; ?>" data-firstname="<?php echo $rowc2['firstname']; ?>" data-lastname="<?php echo $rowc2['lastname']; ?>" data-hiring_date="<?php echo $rowc2['hiring_date']; ?>" data-total_days="<?php echo $rowc2['total_days']; ?>" data-job_title_description="<?php echo $rowc2['job_title_description']; ?>" data-shift_location="<?php echo $rowc2['shift_location']; ?>" data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
             
            &nbsp;	<button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['users_id']; ?>">Delete </button>
            </td>  -->
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                        </form>
                    </div>
                    <!-- /basic datatable -->
                    <!-- /main charts -->
                    <div id="modal_theme_primary" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title">Create User</h6>
                                </div>
                                <form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">UserName:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" id="name" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Email:</label>
                                                    <div class="col-lg-8">
                                                        <input type="email" name="email" id="email" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">First Name:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="firstname" id="firstname" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Last Name:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="lastname" id="lastname" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Hiring Date:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="hiring_date" id="hiring_date" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="total_days" id="total_days" class="form-control" disabled>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Job title description:*</label>
                                                    <div class="col-lg-8">
                                                        <select name="job_title_description" id="job_title_description" class="select" >
                                                            <option value="" selected disabled>--- Select Job-Title ---</option>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `cam_job_title`";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['job_name'] . "'$entry>" . $row1['job_name'] . "</option>";
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
                                                    <label class="col-lg-4 control-label">Shift Location:*</label>
                                                    <div class="col-lg-8">
                                                        <select name="shift_location" id="shift_location" class="select"  >
                                                            <option value="" selected disabled>--- Select Shift/Location ---</option>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `cam_shift`";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['shift_name'] . "'$entry>" . $row1['shift_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="col-lg-4 control-label">Role:*</label>
                                                <div class="col-lg-8">
                                                    <select name="role" id="role" class="select" >
                                                        <option value="" selected disabled>--- Select Role ---</option>
                                                        <?php
                                                        $sql1 = "SELECT * FROM `cam_role` where role_id != '1'";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            echo "<option value='" . $row1['role_id'] . "'$entry>" . $row1['role_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
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
                    <div id="edit_modal_theme_primary" class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title">Update User</h6>
                                </div>
                                <form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">UserName:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="edit_name" id="edit_name" class="form-control" required disabled>
                                                        <input type="hidden" name="edit_id" id="edit_id" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Email:</label>
                                                    <div class="col-lg-8">
                                                        <input type="email" name="edit_email" id="edit_email" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">First Name:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="edit_firstname" id="edit_firstname" class="form-control" required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Last Name:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="edit_lastname" id="edit_lastname" class="form-control" required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Hiring Date:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="edit_hiring_date" id="edit_hiring_date" class="form-control" required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Job title description:*</label>
                                                    <div class="col-lg-8">
                                                        <select name="edit_job_title_description" id="edit_job_title_description" class="form-control"  >
                                                            <option value="" disabled>--- Select Job-Title ---</option>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `cam_job_title`";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['job_name'] . "'$entry>" . $row1['job_name'] . "</option>";
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
                                                    <label class="col-lg-4 control-label">Shift Location:*</label>
                                                    <div class="col-lg-8">
                                                        <select name="edit_shift_location" id="edit_shift_location" class="form-control"  >
                                                            <option value=""  disabled>--- Select Shift/Location ---</option>
                                                            <?php
                                                            $sql1 = "SELECT * FROM `cam_shift`";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['shift_name'] . "'$entry>" . $row1['shift_name'] . "</option>";
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
                                                    <label class="col-lg-4 control-label">Mobile:</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="edit_mobile" id="edit_mobile" class="form-control" pattern= "[0-9]{10}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">New Password</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" name="newpass" id="newpass" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" name="generate" id="generate" disabled>Generate</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Profile Pic</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" name="image" id="image" class="form-control" disabled >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Role:</label>
                                                    <div class="col-lg-8">
                                                        <select name="edit_role" id="edit_role" class="form-control" disabled>
                                                            <option value="" selected disabled>--- Select Role ---</option>
                                                            <?php
//$select = $row['department_head_user_id'];
                                                            $sql1 = "SELECT * FROM `cam_role` where role_id != '1'";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                $select1 = $row1['role_id'];
                                                                if ($select == $select1) {
                                                                    $entry = "selected";
                                                                } else {
                                                                    $entry = "";
                                                                }
                                                                echo "<option value='" . $row1['role_id'] . "'$entry>" . $row1['role_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <!-- -->
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
                    <script>
                        $(document).on('click', '#delete', function () {
                            var element = $(this);
                            var del_id = element.attr("data-id");
                            var info = 'id=' + del_id;
                            $.ajax({type: "POST", url: "ajax_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });
                    </script>
                    <script>
                        jQuery(document).ready(function ($) {
                            $(document).on('click', '#edit', function () {
                                var element = $(this);
                                var edit_id = element.attr("data-id");
                                var name = $(this).data("name");
                                var email = $(this).data("email");
                                var phone = $(this).data("phone");
                                var role = $(this).data("role");
                                var s_q1 = $(this).data("s_q1");
                                var s_q2 = $(this).data("s_q2");
                                var s_q3 = $(this).data("s_q3");
                                var firstname = $(this).data("firstname");
                                var lastname = $(this).data("lastname");
                                var hiring_date = $(this).data("hiring_date");
                                var total_days = $(this).data("total_days");
                                var job_title_description = $(this).data("job_title_description");
                                var shift_location = $(this).data("shift_location");
                                $("#edit_name").val(name);
                                $("#edit_email").val(email);
                                $("#edit_mobile").val(phone);
                                $("#edit_id").val(edit_id);
                                $("#edit_s_question1").val(s_q1);
                                $("#edit_s_question2").val(s_q2);
                                $("#edit_s_question3").val(s_q3);
                                $("#edit_firstname").val(firstname);
                                $("#edit_lastname").val(lastname);
                                $("#edit_hiring_date").val(hiring_date);
                                $("#edit_total_days").val(total_days);
                                $("#edit_job_title_description").val(job_title_description);
                                $("#edit_shift_location").val(shift_location);
                                $select = role;
                                $('#edit_role [value=' + role + ']').attr('selected', 'true').change();
                                //alert($select);
                            });
                        });
                    </script>
                    <script>
                        $("body").on('change', '#hiring_date', function () {
                            var start = $('#hiring_date').val();
                            var end = new Date();
                            var startDay = new Date(start);
                            var endDay = new Date(end);
                            var millisecondsPerDay = 1000 * 60 * 60 * 24;
                            var millisBetween = endDay.getTime() - startDay.getTime();
                            var days = millisBetween / millisecondsPerDay;
                            // Round down.
                            var fin = (Math.floor(days));
                            //   alert(fin);
                            $("#total_days").val(fin);
                        });
                    </script>

                </div>
                <!-- /content area -->

    </div>
    <!-- /page container -->
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $('#generate').click(function () {
            let r = Math.random().toString(36).substring(7);
            $('#newpass').val(r);
        })
        function submitForm(url) {
            $(':input[type="button"]').prop('disabled', true);
            var data = $("#update-form").serialize();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (data) {
                    // window.location.href = window.location.href + "?aa=Line 1";
                    $(':input[type="button"]').prop('disabled', false);
                    location.reload();
                }
            });
        }
    </script>
    <script>
        $(document).on("click", ".custom_switch", function () {
            //      var available_var = '<?php echo $available_var; ?>';
            var edit_id = $(this).data("id");
            var available_var = $(this).data("available");
            $.ajax({
                url: "taskboard_available.php",
                type: "post",
                data: {available_var: available_var, edit_id: edit_id},
                success: function (response) {
                    //alert(response);
                    console.log(response);
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
	//$("#example1").datatable();
	//$('#example1').DataTable({
	//});

    </script>
        <?php include('../footer.php') ?>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>
