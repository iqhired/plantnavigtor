<?php include("../config.php");
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
// to display error msg
if (!empty($_SESSION['import_status_message'])) {
    $message_stauts_class = $_SESSION['message_stauts_class'];
    $import_status_message = $_SESSION['import_status_message'];
    $_SESSION['message_stauts_class'] = '';
    $_SESSION['import_status_message'] = '';
}
$user_id = $_GET['user_id'];
$user_name = $_GET['user_name'];
$sql1 = "SELECT * FROM `cam_users` where `users_id` = '$user_id'";
$result1 = $mysqli->query($sql1);
$rowc1 = $result1->fetch_assoc();
$email = $rowc1['email'];
$trainee = $rowc1['trainee'];
$training_station = $rowc1['training_station'];
$training_position = $rowc1['training_position'];
$mobile = $rowc1['mobile'];
$role = $rowc1['role'];
$s_question1 = $rowc1['s_question1'];
$s_question2 = $rowc1['s_question2'];
$s_question3 = $rowc1['s_question3'];
$firstname = $rowc1['firstname'];
$lastname = $rowc1['lastname'];
$hiring_date = $rowc1['hiring_date'];
$total_days = $rowc1['total_days'];
$job_title_description = $rowc1['job_title_description'];
$shift_location = $rowc1['shift_location'];
if (count($_POST) > 0) {
    $edit_user_id = $_POST['edit_user_id'];
    $name = $_POST['username'];
    $email_id = $_POST['email_id'];
    $edit_firstname = $_POST['edit_firstname'];
    $edit_lastname = $_POST['edit_lastname'];
    $edit_hiring_date = $_POST['edit_hiring_date'];
    $edit_job_title_description = $_POST['edit_job_title_description'];
    $edit_shift_location = $_POST['edit_shift_location'];
    $edit_mobile = $_POST['edit_mobile'];
    $newpass = $_POST['newpass'];
    $edit_role = $_POST['edit_role'];
    $sql121 = "delete from `restore_cam_users` where users_id = '$edit_user_id'";
	mysqli_query($db, $sql121);
    $sql11 = "INSERT INTO `restore_cam_users` select * from cam_users where users_id = '$edit_user_id'";
    if (!mysqli_query($db, $sql11)) {
        $message_stauts_class = 'alert-danger';
        $import_status_message = 'No Data Stored..';
    } else {
		$sql = "update cam_users set user_name='$name',mobile='$edit_mobile',email='$email_id',role='$edit_role',updated_at='$chicagotime',firstname='$edit_firstname',lastname='$edit_lastname',hiring_date='$edit_hiring_date',job_title_description='$edit_job_title_description',shift_location='$edit_shift_location',is_deleted = '0',is_restored = '1' where users_id='$edit_user_id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'User Data Restored Successfully.';
			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'User Data Restored Successfully.';
			$page = "users_list.php";
			header('Location: '.$page, true, 303);
			exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $sitename; ?> | Update Restore User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">

    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>

    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_popups.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/styling/switchery.min.js"></script>
    <style>
        .sidebar-default .navigation li>a{color:#f5f5f5};
        a:hover {
            background-color: #20a9cc;
        }
        .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
            background-color: #20a9cc;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-4{
                width: 45%!important;
            }
            .col-lg-8{
                width: 55%!important;
            }
            .col-md-6 {
                width: 60%;
                float: left;
            }
            .modal-dialog {
                position: relative;
                width: auto;
                margin: 50px;
            }

        }
    </style>
    <style>
        body{
            margin-top:20px;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
            font-size: medium;
        }
        .main-body {
            padding: 15px;
        }
        .card {
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 2rem!important;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col, .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }
        .mb-3, .my-3 {
            margin-bottom: 1rem!important;
        }

        .col-md-4 {
            width: 20.333333%;
        }
        #ic .menu ul{
            margin-top: -2.5rem;
        }
        .header{
            margin-top: -20px;
        }
        input.form-control {
            border: solid 1px #ddd;
            padding: 12px;
        }

    </style>
</head>
<?php
$cust_cam_page_header = "Update Restore User";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<!-- /main navbar -->
<!-- Main navigation -->
<body>
<div class="container">
    <?php
    if (!empty($import_status_message)) {
        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div><br/>';
    }
    ?>
    <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <form action="" id="restore_user" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">User Name:*</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="hidden" name="edit_user_id" value="<?php echo $user_id; ?>">
                                        <input type="text" name="username" value="<?php echo $user_name; ?>" class="form-control" required>
                                        <input type="hidden" name="edit_id" id="edit_id" >
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="email_id" value="<?php echo $email; ?>" class="form-control">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">First Name:* </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="edit_firstname" value="<?php echo $firstname; ?>" class="form-control" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Last Name:* </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="edit_lastname" value="<?php echo $lastname; ?>" class="form-control" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Hiring Date:*</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="date" name="edit_hiring_date" value="<?php echo $hiring_date; ?>" class="form-control" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Job title description:*</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select name="edit_job_title_description" id="edit_job_title_description" class="form-control">
                                            <option value=" " selected disabled>--- Select Job-Title ---</option>
                                            <?php
                                            $sql1 = "SELECT * FROM `cam_job_title`";
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if($job_title_description == $row1['job_name'])
                                                {
                                                    $entry = 'selected';
                                                }
                                                else
                                                {
                                                    $entry = '';
                                                }
                                                echo "<option value='" . $row1['job_name'] . "'$entry>" . $row1['job_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Shift Location:*</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select name="edit_shift_location" id="edit_shift_location" class="form-control"  >
                                            <option value=" " selected disabled>--- Select Shift/Location ---</option>
                                            <?php
                                            $sql1 = "SELECT * FROM `cam_shift`";
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if($shift_location == $row1['shift_name'])
                                                {
                                                    $entry = 'selected';
                                                }
                                                else
                                                {
                                                    $entry = '';
                                                }
                                                echo "<option value='" . $row1['shift_name'] . "'$entry>" . $row1['shift_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Mobile:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text"  name="edit_mobile" id="edit_mobile" class="form-control" pattern= "[0-9]{10}" value="<?php echo $mobile; ?>" class="form-control" >
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">New Password: </h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <input type="text" name="newpass" id="newpass" class="form-control" required>
                                    </div>
                                    <div class="col-sm-2 text-secondary">
                                        <button type="button" name="generate" id="generate" >Generate</button>
                                    </div>
                                </div>
                                <hr>
<!--                                <div class="row">-->
<!--                                    <div class="col-sm-3">-->
<!--                                        <h6 class="mb-0">Profile Pic: </h6>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm-9 text-secondary">-->
<!--                                        <input type="file" name="image" id="image" class="form-control" >-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <hr>-->
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Role: </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select name="edit_role" id="edit_role" class="form-control">
                                            <option value=" " selected disabled>--- Select Role ---</option>
                                            <?php
                                            $sql1 = "SELECT * FROM `cam_role` where role_id != '0'";
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if($role == $row1['role_id'])
                                                {
                                                    $entry = 'selected';
                                                }
                                                else
                                                {
                                                    $entry = '';
                                                }
                                                echo "<option value='" . $row1['role_id'] . "'$entry>" . $row1['role_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-info ">Restore</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>

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
    function submitForm11(url) {
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
    function submitForm12(url) {
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
    $('#choose').on('change', function () {
        var selected_val = this.value;
        if (selected_val == 1 || selected_val == 2) {
            $(".group_div").show();
        } else {
            $(".group_div").hide();
        }
        if (selected_val == 5 ) {
            $('#update-form').submit();
        }
    });
</script>
<script>
    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgPreview + img').remove();
                $('#imgPreview').after('<img src="' + e.target.result + '" class="pic-view" width="200" height="150" float="left"/>');
            };
            reader.readAsDataURL(input.files[0]);
            $('.img-preview').show();
        } else {
            $('#imgPreview + img').remove();
            $('.img-preview').hide();
        }
    }
    $("#file").change(function () {
        // Image preview
        filePreview(this);
    });
    $(function () {
        var rotation = 0;
        $("#rright").click(function () {
            rotation = (rotation - 90) % 360;
            $(".pic-view").css({'transform': 'rotate(' + rotation + 'deg)'});
            if (rotation != 0) {
                $(".pic-view").css({'width': '100px', 'height': '132px'});
            } else {
                $(".pic-view").css({'width': '24%', 'height': '132px'});
            }
            $('#rotation').val(rotation);
        });
        $("#rleft").click(function () {
            rotation = (rotation + 90) % 360;
            $(".pic-view").css({'transform': 'rotate(' + rotation + 'deg)'});
            if (rotation != 0) {
                $(".pic-view").css({'width': '100px', 'height': '132px'});
            } else {
                $(".pic-view").css({'width': '24%', 'height': '132px'});
            }
            $('#rotation').val(rotation);
        });
    });
</script>
</body>
</html>
