<!-- Footer opened -->
<div class="main-footer">
    <div class="container-fluid pd-t-0-f ht-100p">
        Copyright © <?php echo date("Y"); ?> <a href="<?php echo $siteURL; ?>" target="_BLANK" style="color: #060818!important;"><?php echo $sitename; ?></a> All Rights
        Reserved.
    </div>
</div>
<!-- Footer closed -->
<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>
<?php  //include the timing configuration file
include("timings_config.php"); ?>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/time_display.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/push.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/serviceWorker.min.js"></script>
 <script>
	<?php

	use PHPMailer\PHPMailer\Exception;use PHPMailer\PHPMailer\PHPMailer;use PHPMailer\PHPMailer\SMTP;

	$loginid = $_SESSION["id"];
	$chicagotime1 = date('Y-m-d');
	$chicagotime = date("Y-m-d H:i:s");

	//    $sidebar_user_id = $_SESSION['session_user'];
	/*$query10 = sprintf("SELECT DISTINCT `sender`,`receiver` FROM sg_chatbox where sender = '$loginid' OR receiver = '$sidebar_user_id' ORDER BY createdat DESC ;  ");*/
	//$query_not = sprintf();
	$qur_not = mysqli_query($db, "SELECT * FROM `form_user_data` WHERE `created_by` = '$loginid' and DATE_FORMAT(`created_at`,'%Y-%m-%d') = '$chicagotime1'");
	$rowc_not = mysqli_fetch_array($qur_not);
	$form_user_data_id = $rowc_not["form_user_data_id"];
	$form_create_id = $rowc_not["form_create_id"];
	$date = $rowc_not["created_at"];
	$name = $rowc_not["form_name"];
	$msg = $rowc_not["form_name"] . ' Frequency time is over.';
	$notification_mail_flag = $rowc_not["notification_mail_flag"];
	$query_freq = sprintf("SELECT * FROM `form_create` WHERE form_create_id = '$form_create_id'");
	$qur_freq = mysqli_query($db, $query_freq);
	$rowc_freq = mysqli_fetch_array($qur_freq);

	$freq = $rowc_freq["frequency"];
	$from_time = strtotime($date);
	$to_time = strtotime($chicagotime);
	$station = $rowc_freq["station"];
	$form_type = $rowc_freq["form_type"];
	$part_family = $rowc_freq["part_family"];
	$part_number = $rowc_freq["part_number"];
	$form_name = $rowc_freq["name"];
	$group = explode(',', $rowc_freq["notification_list"]);

	$del_query = sprintf("SELECT part_name ,pn.part_number, line_name ,part_family_name , name as form_name   FROM  form_create as fc inner join cam_line as cl on fc.station = cl.line_id inner join pm_part_family as pf on fc.part_family= pf.pm_part_family_id 
    inner join pm_part_number as pn on fc.part_number=pn.pm_part_number_id where form_create_id='$form_create_id'");
	$del_query_01 = mysqli_query($db, $del_query);
	$del_query_row = mysqli_fetch_array($del_query_01);
	$del_user_id = $rowc_not['created_by'];
	$del_query_2 = sprintf("SELECT user_name from cam_users where users_id='$del_user_id'");
	$del_query_02 = mysqli_query($db, $del_query_2);
	$del_query_row_1 = mysqli_fetch_array($del_query_02);
	$line2 = $del_query_row['line_name'];
	$form_name = $del_query_row['form_name'];
	$p_num = $del_query_row['part_number'];
	$p_name = $del_query_row['part_name'];
	$pf_name = $del_query_row['part_family_name'];
	$form_submitted_by = $del_query_row_1['user_name'];
	$line1 = "A time sensitive form has not been completed in the alloted time and is now overdue. Please follow up with user to ensure this form is completed.";
	$message = '<br/><table rules=\"all\" style=\"border-color: #666;\" border=\"1\" cellpadding=\"10\">';
	$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Form Name : </strong> </td><td>" . $form_name . "</td></tr>";
	$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Station : </strong> </td><td>" . $line2 . "</td></tr>";
	$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Number : </strong> </td><td>" . $p_num . "</td></tr>";
	$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Name : </strong> </td><td>" . $p_name . "</td></tr>";
	$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Family : </strong> </td><td>" . $pf_name . "</td></tr>";
	$message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Operator/User : </strong> </td><td>" . $form_submitted_by . "</td></tr>";
	$message .= "</table>";
	$message .= "<br/>";
	$signature = "- USPL Process Control Team";

	$link = "form_module/user_form.php?id=" . $form_create_id . "&station=" . $station . "&form_type=" . $form_type . "&part_family=" . $part_family . "&part_number=" . $part_number . "&form_name=" . $form_name;
	$time = $to_time - $from_time;

	$days = floor($time / (24 * 60 * 60));
	$hours = floor(($time - ($days * 24 * 60 * 60)) / (60 * 60));
	$minutes = floor(($time - ($days * 24 * 60 * 60) - ($hours * 60 * 60)) / 60);
	$seconds = ($time - ($days * 24 * 60 * 60) - ($hours * 60 * 60) - ($minutes * 60)) % 60;

	$arrteam1 = explode(':', $freq);
	$hr = $arrteam1[0];
	$min = $arrteam1[1];

	if($hours >= $hr)
	{
	$diffhr = $hours - $hr;
	if($diffhr <= "0")
	{
	if($minutes >= $min)
	{
	if ($notification_mail_flag == '1') {
		require './vendor/autoload.php';
		$mail = new PHPMailer();
		$mail->isSMTP();
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->SMTPAuth = true;
		$mail->Username = EMAIL_USER;
		$mail->Password = EMAIL_PASSWORD;
		$mail->setFrom('admin@plantnavigator.com', 'Admin Plantnavigator');

		$structure = '<html><body>';
		$structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello,</span><br/><br/>";
		$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $line1 . "</span><br/> ";
		$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message . "</span><br/> ";
		$structure .= "<br/><br/>";
		$structure .= $signature;
		$structure .= "</body></html>";

		if ($group != "") {
			$grpcnt = count($group);
			for ($i = 0; $i < $grpcnt;) {
				$grp = $group[$i];
				$query = sprintf("SELECT * FROM  sg_user_group where group_id = '$grp' ");
				$qur = mysqli_query($db, $query);
				while ($rowc = mysqli_fetch_array($qur)) {
					$u_name = $rowc['user_id'];
					$query0003 = sprintf("SELECT * FROM  cam_users where users_id = '$u_name' ");
					$qur0003 = mysqli_query($db, $query0003);
					$rowc0003 = mysqli_fetch_array($qur0003);
					$email = $rowc0003["email"];
					$lasname = $rowc0003["lastname"];
					$firstname = $rowc0003["firstname"];
					$mail->addAddress($email, $firstname);
				}
				$i++;
			}
		}

//			$message = "Account has been created. Your Username :-" . $name . " and Password :- Welcome123!";
		//   $headers = "From: admin@plantnavigator.com\r\n";
//	$headers .= 'Cc: ' . $email . "\r\n";
		$subject = $msg;
		//$mail->addAddress($email, $firstname);
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $structure;
		if (!$mail->send()) {
//    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		}

		$sql1 = "update form_user_data set notification_mail_flag ='0',updated_by='$chicagotime' where form_user_data_id = '$form_user_data_id'";
		if (!mysqli_query($db, $sql1)) {
		} else {
		}


	}
	?>
    //push code
    Push.create("<?php echo $name; ?>", {
        body: "<?php echo $msg; ?>",
        icon: '../assets/images/SGG_logo.png',
        timeout: 4000,
        onClick: function () {
            window.location.href = "<?php echo $scriptName; ?><?php echo $link; ?>";
            window.focus();
            this.close();
        }
    });

	<?php            }
	}
	else
	{
	if ($notification_mail_flag == '1') {
	    $url = $siteURL . 'vendor/autoload.php';
		require $url;
		$mail = new PHPMailer();
		$mail->isSMTP();
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->SMTPAuth = true;
		$mail->Username = EMAIL_USER;
		$mail->Password = EMAIL_PASSWORD;
		$mail->setFrom('admin@plantnavigator.com', 'Admin Plantnavigator');

		$structure = '<html><body>';
		$structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello,</span><br/><br/>";
		$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $line1 . "</span><br/> ";
		$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message . "</span><br/> ";
		$structure .= "<br/><br/>";
		$structure .= $signature;
		$structure .= "</body></html>";

		if ($group != "") {
			$grpcnt = count($group);
			for ($i = 0; $i < $grpcnt;) {
				$grp = $group[$i];
				$query = sprintf("SELECT * FROM  sg_user_group where group_id = '$grp' ");
				$qur = mysqli_query($db, $query);
				while ($rowc = mysqli_fetch_array($qur)) {
					$u_name = $rowc['user_id'];
					$query0003 = sprintf("SELECT * FROM  cam_users where users_id = '$u_name' ");
					$qur0003 = mysqli_query($db, $query0003);
					$rowc0003 = mysqli_fetch_array($qur0003);
					$email = $rowc0003["email"];
					$lasname = $rowc0003["lastname"];
					$firstname = $rowc0003["firstname"];
					$mail->addAddress($email, $firstname);
				}
				$i++;
			}
		}

//			$message = "Account has been created. Your Username :-" . $name . " and Password :- Welcome123!";
		//   $headers = "From: admin@plantnavigator.com\r\n";
//	$headers .= 'Cc: ' . $email . "\r\n";
		$subject = $msg;
		//$mail->addAddress($email, $firstname);
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $structure;
		if (!$mail->send()) {
//    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		}
		$sql1 = "update form_user_data set notification_mail_flag ='0',updated_by='$chicagotime' where form_user_data_id = '$form_user_data_id'";
		if (!mysqli_query($db, $sql1)) {
		} else {
		}
	}

	?>
    Push.create("<?php echo $name; ?>", {
        body: "<?php echo $msg; ?>",
        icon: '<?php echo $siteURL; ?>assets/images/SGG_logo.png',
        timeout: 4000,
        onClick: function () {
            window.location.href = "<?php echo $scriptName; ?><?php echo $link; ?>";
            window.focus();
            this.close();
        }
    });

	<?php        }
	}

	?>

	<?php //} ?>
    //push code over
</script>

<!-- Footer --><br/>

<!-- /footer -->