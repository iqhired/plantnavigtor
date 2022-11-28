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
	
	$choose = $_POST['choose'];
    if($choose == '5')
	{
		$message_stauts_class = 'alert-info';
            $import_status_message = 'select user to remove from approver list.';
		$ch = '5';	
            
	}
	else
	{	
	
    $name = $_POST['name'];
    require '../vendor/autoload.php';
    include ("../email_config.php");
    if ($name != "") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = md5("Welcome123!");
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $hiring_date = $_POST['hiring_date'];
        $job_title_description = $_POST['job_title_description'];
        $shift_location = $_POST['shift_location'];
        $total_days = $_POST['total_days'];
		$station = $_POST['station'];
		$position = $_POST['position'];
		$trainee1 = $_POST['trainee1'];
        $status = '1';
        $signature = '- Plantnavigator Admin';
        $link = $siteURL;

if ($email != "") {
    // Compose a simple HTML email message
    $message  = "Hello  " .$firstname .$lastname;
    $message .= "<br>";
    $message .= "Congratulations your plantnavigator account has been created. Please find the details below!";
    $message .= "<br>";
    $message .= "Login Id :-" . $name;
    $message .= "<br>";
    $message .= "One time Password :-  Welcome123!";
    $message .= "<br>";
    $message .= "Please find the login link below";
    $message .= "<br>";
    $message .= "<br>";
    $message .= "Click to login the page :-" .$link;
    $message .= "<br>";
    $message .= "<br>";
    $message .= " " .$signature;

   /* $message  = '<html><body>';
    $message .= '<p style="font-size:14px;"><b>Hello '.$firstname.' '.$lastname.'</b></p>';
    $message .= '<p style="font-size:14px;">Congratulations your plantnavigator account has been created. Please find the details below!</p>';
    $message .= '<p style="font-size:14px;"><b>Login Id : </b>'.$name.'</p>';
    $message .= '<p style="font-size:14px;"><b>One time Password : </b> Welcome123!</p>';
    $message .= '<br>';
    $message .= '<p style="font-size:14px;">please find the login link below</p>';
    $message .= '<p style="font-size:14px;"><b>'.$link.'</b></p>';
    $message .= '<br>';
    $message .= '<p style="font-size:14px;"><b>'.$signature.'</b></p>';
    $message .= '</body></html>';*/

            //   $headers = "From: admin@plantnavigator.com\r\n";
//	$headers .= 'Cc: ' . $email . "\r\n";
            $subject = "Account created.";
            $mail->addAddress($email, $firstname);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            if (!$mail->send()) {
//    echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                //   $_SESSION['message_stauts_class'] = 'alert-success';
//$_SESSION['import_status_message'] = 'Mail-Sent Sucessfully.';
            }
            function save_mail($mail) {
                $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
                $imapStream = imap_open($path, $mail->Username, $mail->Password);
                $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                imap_close($imapStream);
                return $result;
            }
        }
        $sql1 = "INSERT INTO `cam_users`(`training_station`,`training_position`,`training`,`user_name`, `email`, `role`, `password` , `profile_pic` , `assigned` ,`assigned2` , `firstname`, `lastname`, `hiring_date`, `total_days`, `job_title_description`, `shift_location`, `created_at`, `updated_at`,`u_status`) 
                          VALUES ('$station','$position','$trainee1','$name','$email','$role','$password','user.png','0','0','$firstname','$lastname','$hiring_date','$total_days','$job_title_description','$shift_location','$chicagotime','$chicagotime','$status')";
        if (!mysqli_query($db, $sql1)) {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: User with this Username or Mail-id Already Exists';
        } else {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'User Created Successfully.';
        }
    }
    $edit_name = $_POST['edit_name'];
    $id = $_POST['edit_id'];

    if ($id != "") {
        $id = $_POST['edit_id'];
        $validator = $_FILES['image']['name'];
        if ($validator != "") {
            if (isset($_FILES['image'])) {
                $errors = array();
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $file_ext = strtolower(end(explode('.', $file_name)));
                $extensions = array("jpeg", "jpg", "png", "pdf");
                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Extension not allowed, please choose a JPEG or PNG file.';
                }
                if ($file_size > 2097152) {
                    $errors[] = 'File size must be excately 2 MB';
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: File size must be excately 2 MB';
                }
                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, "../user_images/" . $file_name);
                    $pass = $_POST['newpass'];
                    if ($pass != "") {
                        $mmm = $_POST['edit_email'];
                        $fnm = $_POST['edit_firstname'];
                        $message = "Password has been Updated. Your new password is :- " . $pass;
                        $subject = "Password Updated.";
                        $mail->addAddress($mmm, $fnm);
                        $mail->isHTML(true);
                        $mail->Subject = $subject;
                        $mail->Body = $message;
                        if (!$mail->send()) {
//    echo 'Mailer Error: ' . $mail->ErrorInfo;
                        } else {
                            //   $_SESSION['message_stauts_class'] = 'alert-success';
//$_SESSION['import_status_message'] = 'Mail-Sent Sucessfully.';
                        }
                        function save_mail($mail) {
                            $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
                            $imapStream = imap_open($path, $mail->Username, $mail->Password);
                            $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                            imap_close($imapStream);
                            return $result;
                        }
                        $sql = "update cam_users set training_station='$_POST[edit_station]',training_position='$_POST[edit_position]', password = '" . (md5($_POST["newpass"])) . "',user_name='$_POST[edit_name]',profile_pic='$file_name',mobile='$_POST[edit_mobile]',email='$_POST[edit_email]',role='$_POST[edit_role]',updated_at='$chicagotime',firstname='$_POST[edit_firstname]',lastname='$_POST[edit_lastname]',hiring_date='$_POST[edit_hiring_date]',job_title_description='$_POST[edit_job_title_description]',shift_location='$_POST[edit_shift_location]' where users_id='$id'";
                    } else {
                        $sql = "update cam_users set training_station='$_POST[edit_station]',training_position='$_POST[edit_position]',profile_pic='$file_name',user_name='$_POST[edit_name]',mobile='$_POST[edit_mobile]',email='$_POST[edit_email]',role='$_POST[edit_role]',updated_at='$chicagotime',firstname='$_POST[edit_firstname]',lastname='$_POST[edit_lastname]',hiring_date='$_POST[edit_hiring_date]',job_title_description='$_POST[edit_job_title_description]',shift_location='$_POST[edit_shift_location]' where users_id='$id'";
                    }
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
        } else {
            $pass = $_POST['newpass'];
            if ($pass != "") {
                $sql = "update cam_users set training_station='$_POST[edit_station]',training_position='$_POST[edit_position]', password = '" . (md5($_POST["newpass"])) . "',user_name='$_POST[edit_name]',mobile='$_POST[edit_mobile]',email='$_POST[edit_email]',role='$_POST[edit_role]',updated_at='$chicagotime',firstname='$_POST[edit_firstname]',lastname='$_POST[edit_lastname]',hiring_date='$_POST[edit_hiring_date]',job_title_description='$_POST[edit_job_title_description]',shift_location='$_POST[edit_shift_location]' where users_id='$id'";
                $emailto = $_POST['edit_email'];
                $fnm = $_POST['edit_firstname'];
                if ($emailto != "") {
                    $subject = "Password changed";
                    $message = "Your Password has been changed. New Password is :- " . $pass;
                    $mail->addAddress($emailto, $fnm);
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    if (!$mail->send()) {
//    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    } else {
                        //   $_SESSION['message_stauts_class'] = 'alert-success';
//$_SESSION['import_status_message'] = 'Mail-Sent Sucessfully.';
                    }
                    function save_mail($mail) {
                        $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
                        $imapStream = imap_open($path, $mail->Username, $mail->Password);
                        $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                        imap_close($imapStream);
                        return $result;
                    }
                }
            } else {
                $sql = "update cam_users set training_station='$_POST[edit_station]',training_position='$_POST[edit_position]', mobile='$_POST[edit_mobile]',user_name='$_POST[edit_name]',email='$_POST[edit_email]',role='$_POST[edit_role]',firstname='$_POST[edit_firstname]',lastname='$_POST[edit_lastname]',hiring_date='$_POST[edit_hiring_date]',job_title_description='$_POST[edit_job_title_description]',shift_location='$_POST[edit_shift_location]' where users_id='$id'";
            }
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


    $update_id = $_POST['update_id'];
    if ($update_id != "") {

		$update_position = $_POST['update_position'];
		$update_station = $_POST['update_station'];

    $sql = "update cam_users set training_station='$_POST[update_station]',training_position='$_POST[update_position]',training='1' where users_id='$update_id'";
    $result1 = mysqli_query($db, $sql);
    if ($result1) {
		$message_stauts_class = 'alert-success';
        $import_status_message = 'Trainee Details Updated Successfully.';
    } else {
        $message_stauts_class = 'alert-danger';
        $import_status_message = 'Error: Please Try Again.';
    }
}	

}
}
if (!empty($_GET['import_status'])) {
    switch ($_GET['import_status']) {
        case 'success':
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Data inserted successfully.';
            break;
        case 'error':
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please try again.';
            break;
        case 'invalid_file':
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please upload a valid CSV file.';
            break;
        default:
            $message_stauts_class = '';
            $import_status_message = '';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Users</title>
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
    </head>

        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Create or Add Users";
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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5 class="panel-title">Users List</h5>  
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="text-right">
                                            <button type="button"  class="btn btn-primary" style="background-color:#1e73be;" data-toggle="modal"  data-target="#modal_theme_primary">Create User</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>						
                                <div class="row">

                                    <form action="" id="upload_csv" method="post" enctype="multipart/form-data" id="import_form">
                                        <div class="col-md-4">
                                            <input type="file" name="file" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-primary" style="background-color:#1e73be;" name="import_data" value="IMPORT">
                                            <a href="export.php" class="btn btn-primary" style="background-color:#1e73be;"><i class="fa fa-download" aria-hidden="true"></i> Export</a>
                                        </div>

                                    </form>
                                </div>
                                <?php if (!empty($import_status_message)) { ?>
                                    <?php echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>'; ?>
                                <?php } ?>	
                                <?php if (!empty($_SESSION['import_status_message'])) { ?>
                                    <?php
                                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                    $_SESSION['message_stauts_class'] = '';
                                    $_SESSION['import_status_message'] = '';
                                    ?>
                                <?php }
								
								?>
								
                            </div>
                        </div>

                        <form action="" id="update-form" method="post" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary" onclick="submitForm('delete_users_list.php')"  style="background-color:#1e73be;">Delete</button>
                                    <!-- <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button> -->
                                </div>
                                <div class="col-md-4">	
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="choose" id="choose"  required>
                                        <option value="" disabled selected>Select Action </option> 
                                        <option value="1" >Add to Group </option> 
                                        <option value="2" >Remove from Group </option> 
                                        <option value="3" >Add to Approver list </option> 
										<option value="5" <?php if($ch == '5'){ echo "selected"; } ?>>Remove from Approver list</option> 
										<option value="4" >Filter Trainee </option> 
										
                                    </select>
                                </div>
                                <div class="col-md-2 group_div" style="display:none">
                                    <select class="form-control" name="group_id" id="group_id"   required>
                                        <option value="" disabled selected>Select Group </option> 
                                        <?php
                                        $sql1 = "SELECT * FROM `sg_group`";
                                        $result1 = $mysqli->query($sql1);
                                        while ($row1 = $result1->fetch_assoc()) {
                                            echo "<option value='" . $row1['group_id'] . "'>" . $row1['group_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-primary" onclick="submitForm11('user_list_option_backend.php')"  style="background-color:#1e73be;">Go</button>
                                    <!--<button type="button" class="btn btn-primary" onclick="submitForm11('add_user_to_group.php')"  style="background-color:#1e73be;">Go</button>
                                        <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Add Users</button>  -->
                                </div>
                            </div><br/>
                            <!-- Main charts -->
                            <!-- Basic datatable -->
                            <div class="panel panel-flat">                        						
                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" ></th>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Group</th>
                                            <th>Role</th>
											<th>Trainee</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  cam_users where role != '1' AND is_deleted !='1' order by `firstname` ;  ");
$sessiontraiong = $_SESSION['training'];
 if($sessiontraiong == "1")
 {
		$query = sprintf("SELECT * FROM  cam_users where role != '1' and training = '1' AND is_deleted !='1' order by `firstname` ;  ");
 $_SESSION['training'] = "";
 }
 if($ch == '5')
 {
		$query = sprintf("SELECT * FROM  cam_users where pin_flag = '1' and role != '1'  AND is_deleted !='1' order by `firstname` ; ");
 }

										$qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["users_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["firstname"]; ?>&nbsp;<?php echo $rowc["lastname"]; ?></td>
                                                <?php
                                                $position = "";
                                                $position1 = $rowc['users_id'];
                                                $qurtemp1 = mysqli_query($db, "SELECT * FROM  sg_user_group where user_id = '$position1' ");
                                                while ($rowctemp1 = mysqli_fetch_array($qurtemp1)) {
                                                    $qur1 = mysqli_query($db, "SELECT group_name FROM sg_group where group_id = '$rowctemp1[group_id]' ");
                                                    $rowc1 = mysqli_fetch_array($qur1);
                                                    $position .= $rowc1["group_name"] . " , ";
                                                }
                                                ?>                                
                                                <td><?php echo $position; ?></td>
                                                <td><?php
                                                    $qur1 = mysqli_query($db, "SELECT role_name FROM cam_role where role_id = '$rowc[role]' ");
                                                    $rowc1 = mysqli_fetch_array($qur1);
                                                    echo $rowc1["role_name"];
                                                    ?>
                                                </td>
												<td >
                                                       <?php
                                                        $training = $rowc["training"];
                                                            if ($training == '1') {
                                                                ?>
															<label class="checkbox-switchery switchery-xs " style="margin-bottom:16px;" >	
                                                                <input type="checkbox" style="opacity:0;"  class="switchery custom_switch" checked='checked' data-id="<?php echo $rowc['users_id']; ?>" data-available="<?php echo $rowc['training']; ?>" >
                                                            </label>
															<?php } else { ?>		
                                                            <label class="checkbox-switchery switchery-xs " style="margin-bottom:16px;" >
															<input type="checkbox" style="opacity:0;" class="switchery custom_switch" data-id="<?php echo $rowc['users_id']; ?>" data-available="<?php echo $rowc['training']; ?>" data-toggle="modal" data-target="#update_modal_theme_primary">
															</label>
                                                                <?php
                                                            } ?>
                                                    
                                                </td> 
                                                <td>
                                                    <button type="button" id="edit" class="btn btn-info btn-xs" data-trainee="<?php echo $rowc['training']; ?>"  data-station="<?php echo $rowc['training_station']; ?>" data-position="<?php echo $rowc['training_position']; ?>"  data-id="<?php echo $rowc['users_id']; ?>" data-name="<?php echo $rowc['user_name']; ?>"   data-email="<?php echo $rowc['email']; ?>" data-phone="<?php echo $rowc['mobile']; ?>" data-role="<?php echo $rowc['role']; ?>" data-s_q1="<?php echo $rowc['s_question1']; ?>" data-s_q2="<?php echo $rowc['s_question2']; ?>" data-s_q3="<?php echo $rowc['s_question3']; ?>" data-firstname="<?php echo $rowc['firstname']; ?>" data-lastname="<?php echo $rowc['lastname']; ?>" data-hiring_date="<?php echo $rowc['hiring_date']; ?>" data-total_days="<?php echo $rowc['total_days']; ?>" data-job_title_description="<?php echo $rowc['job_title_description']; ?>" data-shift_location="<?php echo $rowc['shift_location']; ?>" data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>
            <!--								&nbsp;	<button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['users_id']; ?>">Delete </button>
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
                    <div id="modal_theme_primary" class="modal">
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
												<div class="form-group">
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
                                            </div></div>
                                        </div>
										
										<div class="row">
                                            <div class="col-md-12">
												<div class="form-group">
                                                <label class="col-lg-4 control-label">Trainee:</label>
                                                <div class="col-lg-8">
                                                    <label class="checkbox-switchery switchery-xs " style="margin-bottom:16px;" >	
                                                                <input type="checkbox" id="trainee1" name="trainee1" style="opacity:0;"  class="switchery switch_trainee" >
                                                    </label>
                                                </div>
                                            </div></div>
                                        </div>
										
										<div class="row" id="station_row" style="display:none;">
                                            <div class="col-md-12">
												<div class="form-group">
                                                <label class="col-lg-4 control-label">Training Station:</label>
                                                <div class="col-lg-8">
                                                    <select name="station" id="station" class="select" >
                                                        <option value="" selected disabled>--- Select Station ---</option>
                                                        <?php
                                                        $sql1 = "SELECT * FROM `cam_line` ";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            echo "<option value='" . $row1['line_id'] . "'$entry>" . $row1['line_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div></div>
                                        </div>
										<div class="row" id="position_row" style="display:none;">
                                            <div class="col-md-12">
											<div class="form-group">
                                                <label class="col-lg-4 control-label">Training Position:</label>
                                                <div class="col-lg-8">
                                                    <select name="position" id="position" class="select" >
                                                        <option value="" selected disabled>--- Select Position ---</option>
                                                        <?php
                                                        $sql1 = "SELECT * FROM `cam_position` ";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            echo "<option value='" . $row1['position_id'] . "'$entry>" . $row1['position_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div></div>
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
                                                        <input type="text" name="edit_name" id="edit_name" class="form-control" required>
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
                                                        <input type="email" name="edit_email" id="edit_email" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">First Name:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="edit_firstname" id="edit_firstname" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Last Name:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="edit_lastname" id="edit_lastname" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Hiring Date:*</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="edit_hiring_date" id="edit_hiring_date" class="form-control" required>
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
                                                        <input type="text" name="edit_mobile" id="edit_mobile" class="form-control" pattern= "[0-9]{10}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">New Password</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="newpass" id="newpass" class="form-control">
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" name="generate" id="generate" >Generate</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Profile Pic</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" name="image" id="image" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Role:</label>
                                                    <div class="col-lg-8">
                                                        <select name="edit_role" id="edit_role" class="form-control" >
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
										
										<div class="row" id="edit_station_row">
                                            <div class="col-md-12">
												<div class="form-group">
                                                <label class="col-lg-4 control-label">Training Station:</label>
                                                <div class="col-lg-8">
                                                    <select name="edit_station" id="edit_station" class="form-control" >
                                                        <option value="" selected disabled>--- Select Station ---</option>
                                                        <?php
                                                        $sql1 = "SELECT * FROM `cam_line` ";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            echo "<option value='" . $row1['line_id'] . "'$entry>" . $row1['line_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div></div>
                                        </div>
										<div class="row" id="edit_position_row">
                                            <div class="col-md-12">
											<div class="form-group">
                                                <label class="col-lg-4 control-label">Training Position:</label>
                                                <div class="col-lg-8">
                                                    <select name="edit_position" id="edit_position" class="form-control" >
                                                        <option value="" selected disabled>--- Select Position ---</option>
                                                        <?php
                                                        $sql1 = "SELECT * FROM `cam_position` ";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            echo "<option value='" . $row1['position_id'] . "'$entry>" . $row1['position_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div></div>
										
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

<!-- update trainee-->

                    <div id="update_modal_theme_primary" class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title">Update Trainee Info</h6>
                                </div>
                                <form action="" id="user_form" enctype="multipart/form-data" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        
                                        <div class="row" id="update_station1">
                                            <div class="col-md-12">
												<div class="form-group">
                                                <label class="col-lg-4 control-label">Training Station:*</label>
                                                <div class="col-lg-8">
                                                    <select name="update_station" id="update_station" class="form-control" required>
                                                        <option value="" selected disabled>--- Select Station ---</option>
                                                        <?php
                                                        $sql1 = "SELECT * FROM `cam_line` ";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            echo "<option value='" . $row1['line_id'] . "'$entry>" . $row1['line_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                        <input type="hidden" name="update_id" id="update_id" >
                                                </div>
                                            </div>
											</div>
                                        </div>
										<div class="row" id="update_position1">
                                            <div class="col-md-12">
												<div class="form-group">
                                                <label class="col-lg-4 control-label">Training Position:*</label>
                                                <div class="col-lg-8">
                                                    <select name="update_position" id="update_position" class="form-control" required>
                                                        <option value="" selected disabled>--- Select Position ---</option>
                                                        <?php
                                                        $sql1 = "SELECT * FROM `cam_position` ";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            echo "<option value='" . $row1['position_id'] . "'$entry>" . $row1['position_name'] . "</option>";
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


                    <!-- /dashboard content -->
                    <script> $(document).on('click', '#delete', function () {
                            var element = $(this);
                            var del_id = element.attr("data-id");
                            var info = 'id=' + del_id;
                            $.ajax({type: "POST", url: "ajax_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });</script>
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
                                var station = $(this).data("station");
                                var position = $(this).data("position");
                                var trainee = $(this).data("trainee");
								
								if(trainee == "1")
								{
									
									$('#edit_station_row').show();
									$('#edit_position_row').show();
								}
								else
								{
									$('#edit_station_row').hide();
									$('#edit_position_row').hide();
								}
                                
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
                                $("#edit_station").val(station);
                                $("#edit_position").val(position);
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
window.onload = function() {
    history.replaceState("", "", "<?php echo $scriptName; ?>user_module/users_list.php");
}
</script>

        <script>
            $(document).ready(function (){
                $('#upload_csv').on('submit',function (e){
                    e.preventDefault();
                    $.ajax({
                        url:"import.php",
                        method:"POST",
                        data:new FormData(this),
                        contentType:false,
                        cache:false,
                        processData:false,
                        success:function (data){
                           // console.log(data);
                            alert('done');

                        }
                    });
                });
            });
        </script>
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
        $(document).on("click", ".custom_switch", function () {
            //      var available_var = '<?php echo $available_var; ?>';
            var update_id = $(this).data("id");
            var available_var = $(this).data("available");
			$("#update_id").val(update_id);	
                                
if(available_var == "1")
{
            var edit_id = $(this).data("id");
            $.ajax({
                url: "training_available.php",
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
}
        });
		
        $(document).on("click", ".custom_switch2", function () {
            //      var available_var = '<?php echo $available_var; ?>';
            var edit_id = $(this).data("id");
            var available_var = $(this).data("available");
                                
            $.ajax({
                url: "training_available.php",
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


		
	 $(document).on("click", ".switch_trainee", function () {	
var abc = 	 $(this).is(':checked'); 
if(abc == true){
	$("#station").prop("required", true);
	$("#position").prop("required", true);
	
	$("#station_row").show();
	$("#position_row").show();
}else{
	
	$("#station").prop("required", false);
	$("#position").prop("required", false);
	$("#station_row").hide();
	$("#position_row").hide();
}

	 });
		
	 $(document).on("click", ".switch_edit_trainee", function () {	
var abc = 	 $(this).is(':checked'); 
if(abc == true){
	$("#edit_station").prop("required", true);
	$("#edit_position").prop("required", true);
	
	$("#edit_station_row").show();
	$("#edit_position_row").show();
}else{
	
	$("#edit_station").prop("required", false);
	$("#edit_position").prop("required", false);
	$("#edit_station_row").hide();
	$("#edit_position_row").hide();
}

	 });		
		
	//$("#example1").datatable();
	//$('#example1').DataTable({
	//});

    </script>
        <?php include ('../footer.php') ?>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
