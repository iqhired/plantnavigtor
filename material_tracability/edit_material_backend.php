<?php
include("../config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);
//echo "<pre>";print_r($drag_drop_res);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

if(count($_POST)>0) {
    $material_id = $_POST['material_id'];
    $station_event_id = $_POST['station_event_id'];
    $customer_account_id = $_POST['customer_account_id'];
    $line_number = $_POST['line_number'];
    $part_number = $_POST['part_number'];
    $part_family = $_POST['part_family'];
    $part_name = $_POST['part_name'];
    $serial_number = $_POST['serial_number'];
    $material_type = $_POST['material_type'];
    $material_status = $_POST['material_status'];
    $fail_reason = $_POST['reason'];
    $reason_desc = $_POST['reason_desc'];
    $quantity = $_POST['quantity'];
    $notes = $_POST['material_notes'];
    $created_by = date("Y-m-d H:i:s");
    $edit_file = $_FILES['edit_image']['name'];
	$updated_by_user = $_SESSION['id'];

    //$sql0 = "UPDATE `material_tracability` SET `line_number`='$line_number',`part_number`='$part_number',`part_family`='$part_family',`part_name`='$part_name',`material_type`='$material_type',`serial_number`='$serial_number',`material_status`='$material_status',`fail_reason`='$fail_reason',`reason_desc`='$reason_desc',`quantity`='$quantity',`notes`='$notes',`created_at`='$created_by' WHERE `material_id` = '$form_id'";
	$sql0 = "UPDATE `material_tracability` SET `created_by`='$updated_by_user',`line_no`='$line_number',`part_no`='$part_number',`part_family_id`='$part_family',`part_name`='$part_name',`material_type`='$material_type',`serial_number`='$serial_number',`material_status`='$material_status',`fail_reason`='$fail_reason',`reason_desc`='$reason_desc',`quantity`='$quantity',`notes`='$notes',`created_at`='$created_by' WHERE `material_id` = '$material_id'";
    $result0 = mysqli_query($db, $sql0);
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Form Updated Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';
    }
//    $qur04 = mysqli_query($db, "SELECT * FROM  material_tracability where material_id= '$material_id' ");
//    $rowc04 = mysqli_fetch_array($qur04);
//    $material_id = $rowc04["material_id"];


//multiple image
    if($edit_file != "") {
        if (isset($_FILES['edit_image'])) {
            $totalfiles = count($_FILES['edit_image']['name']);

            if($totalfiles > 0 && $_FILES['edit_image']['name'][0] !='' && $_FILES['edit_image']['name'][0] != null){
                for($i=0;$i<$totalfiles;$i++){
                    $errors = array();
                    $file_name = $_FILES['edit_image']['name'][$i];
                    $file_rename = "material_id_".$material_id."_".$file_name;
                    $file_size = $_FILES['edit_image']['size'][$i];
                    $file_tmp = $_FILES['edit_image']['tmp_name'][$i];
                    $file_type = $_FILES['edit_image']['type'][$i];
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
                        $import_status_message = 'Error: File size must be less than 2 MB';
                    }
                    if (empty($errors) == true) {

                        move_uploaded_file($file_tmp, "../assets/images/mt/" . "material_id_".$material_id."_".$file_name);

                        $sql = "INSERT INTO `material_images`(`image_name`,`material_id`,`created_at`) VALUES ('$file_rename' , '$material_id' , '$created_by' )";
                        $result1 = mysqli_query($db, $sql);
                        if ($result1) {
                            $message_stauts_class = 'alert-success';
                            $import_status_message = 'Image Added Successfully.';
                        } else {
                            $message_stauts_class = 'alert-danger';
                            $import_status_message = 'Error: Please Try Again.';
                        }


                    }

                }
            }

        }
    }

	if ($material_status == '0') {

		$qur05 = mysqli_query($db, "SELECT * FROM `material_config` where material_id = '$material_type' ");
		$rowc05 = mysqli_fetch_array($qur05);
		$out_of_tolerance_mail_list1 = $rowc05['teams'];
		$out_of_tolerance_mail_list_users = $rowc05['users'];
//	$subject = "Users Mail Report";
// mail code over
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USER;
        $mail->Password = EMAIL_PASSWORD;
        $mail->setFrom('admin@plantnavigator.com', 'Admin Plantnavigator');
//	$message = "This is System generated Mail when out of telerance value added into the form. please go to below link to check the form.";
		$del_query = sprintf("SELECT pn.part_name ,pn.part_number, cl.line_name ,part_family_name , mt.created_by as created_by   FROM  material_tracability as mt inner join cam_line as cl on mt.line_no = cl.line_id inner join pm_part_family as pf on mt.part_family_id= pf.pm_part_family_id 
inner join pm_part_number as pn on mt.part_no=pn.pm_part_number_id where mt.material_id='$material_id'");
		$del_query_01 = mysqli_query($db, $del_query);
		$del_query_row = mysqli_fetch_array($del_query_01);
//		$del_user_id = '1';
        $del_user_id = $del_query_row['created_by'];
		$del_query_2 = sprintf("SELECT user_name , firstname , lastname from cam_users where users_id='$del_user_id'");
		$del_query_02 = mysqli_query($db, $del_query_2);
		$del_query_row_1 = mysqli_fetch_array($del_query_02);
		$line1 = "There have been issue(s) found with the following material(s):";
		$line2 = $del_query_row['line_name'];
		$subject = $line2 . " - Material Rejected";
//    $form_name = $del_query_row['form_name'];
		$p_num = $del_query_row['part_number'];
		$p_name = $del_query_row['part_name'];
		$pf_name = $del_query_row['part_family_name'];
		$form_submitted_by = $del_query_row_1['firstname'] . " " . $del_query_row_1['lastname'];

		$message = '<br/><table rules=\"all\" style=\"border-color: #666;\" border=\"1\" cellpadding=\"10\">';
//    $message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Form Name : </strong> </td><td>" . $form_name . "</td></tr>";
		$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Area / Station : </strong> </td><td>" . $line2 . "</td></tr>";
		$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Number : </strong> </td><td>" . $p_num . "</td></tr>";
		$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Name : </strong> </td><td>" . $p_name . "</td></tr>";
		$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Family : </strong> </td><td>" . $pf_name . "</td></tr>";
		$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Reject Reason : </strong> </td><td>" . $fail_reason . "</td></tr>";
		$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Quantity : </strong> </td><td>" . $quantity . "</td></tr>";
		$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Operator/User : </strong> </td><td>" . $form_submitted_by . "</td></tr>";
//    $message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Number of items that are out of specification: </strong> </td><td>" . $temp_j . "</td></tr>";
		$message .= "</table>";
		$message .= "<br/>";
		$message1 = "Please click on the following link to review the values that were uploaded : ";
		$message2 = $siteURL . "material_tracability/view_material_mail.php?id=" . $material_id;
		$signature = "- USPL Process Control Team";


		$structure = '<html><body>';
		$structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello,</span><br/><br/>";
		$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $line1 . "</span><br/> ";
		$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message . "</span><br/> ";
		$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message1 . "</span><br/> ";
		$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > <a href=" . $message2 . ">View Form Data</a></span><br/> ";
		$structure .= "<br/><br/>";
		$structure .= $signature;
		$structure .= "</body></html>";
//	$mail->addAddress('ayesha@hematechservices.com', 'ayesha@hematechservices.com');
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $structure;
		$arr_out_of_tolerance_mail_list = explode(',', $out_of_tolerance_mail_list1);
		$users = explode(',', $out_of_tolerance_mail_list_users);
		foreach ($arr_out_of_tolerance_mail_list as $out_of_tolerance_mail_list) {
			if ($out_of_tolerance_mail_list != "") {
				$query0004 = sprintf("SELECT * FROM  sg_user_group where group_id = '$out_of_tolerance_mail_list' ");
				$qur0004 = mysqli_query($db, $query0004);
				while ($rowc0004 = mysqli_fetch_array($qur0004)) {
					$u_name = $rowc0004['user_id'];
					array_push($users ,$u_name );
				}
			}
		}
		$u_users = array_unique($users);
		foreach ($u_users as $u) {
			if ($u != "") {
				$query0005 = sprintf("SELECT * FROM  cam_users where users_id = '$u' ");
				$qur0005 = mysqli_query($db, $query0005);
				$rowc0005 = mysqli_fetch_array($qur0005);
				$email = $rowc0005["email"];
				$lasname = $rowc0005["lastname"];
				$firstname = $rowc0005["firstname"];
				$mail->addAddress($email, $firstname);
			}
		}
		if (!$mail->send()) {
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			$path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
			$imapStream = imap_open($path, $mail->Username, $mail->Password);
			$result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
			imap_close($imapStream);
		}
	}
}
//header("Location:form_edit.php?id=$hidden_id");
$page = "edit_material.php?id=$material_id";
header('Location: '.$page, true, 303);
exit;

?>