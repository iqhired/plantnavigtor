<?php
ini_set('display_errors', 'off');
include '../config.php';
$curdate = date('Y-m-d');

$usr2 = $_SESSION['usr2'];
$usr1 = $_SESSION['usr1'];
$dateto = $_SESSION['date_to'];
$datefrom = $_SESSION['date_from'];
$button = $_SESSION['button'];
$timezone = $_SESSION['timezone'];

if ($button == "button1") {
    if ($usr1 != "" && $usr2 != "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' and (sender = '$usr1' AND receiver = '$usr2' OR sender = '$usr2' AND receiver = '$usr1')");
    } else if ($usr1 != "" && $usr2 != "" && $datefrom == "" && $dateto == "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE  sender = '$usr1' AND receiver = '$usr2' OR sender = '$usr2' AND receiver = '$usr1'");
    } else if ($usr1 != "" && $usr2 == "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' and (sender = '$usr1' OR receiver = '$usr1') ");
    } else if ($usr1 != "" && $usr2 == "" && $datefrom == "" && $dateto == "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE sender = '$usr1' OR receiver = '$usr1'");
    } else if ($ur1 == "" && $usr2 != "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' and (sender = '$usr2' OR receiver = '$usr2')");
    } else if ($usr1 == "" && $usr2 != "" && $datefrom == "" && $dateto == "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE sender = '$usr2' OR receiver = '$usr2'");
    } else if ($usr1 == "" && $usr2 == "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' ");
    } else {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox`");
    }
} else {
    $curdate = date('Y-m-d');
    if ($timezone == "7") {
        $countdate = date('Y-m-d', strtotime('-7 days'));
    } else if ($timezone == "1") {
        $countdate = date('Y-m-d', strtotime('-1 days'));
    } else if ($timezone == "30") {
        $countdate = date('Y-m-d', strtotime('-30 days'));
    } else if ($timezone == "90") {
        $countdate = date('Y-m-d', strtotime('-90 days'));
    } else if ($timezone == "180") {
        $countdate = date('Y-m-d', strtotime('-180 days'));
    } else if ($timezone == "365") {
        $countdate = date('Y-m-d', strtotime('-365 days'));
    }
    if ($usr1 != "" && $usr2 != "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$curdate' and (sender = '$usr1' AND receiver = '$usr2' OR sender = '$usr2' AND receiver = '$usr1')");
    } else if ($usr1 != "" && $usr2 != "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE  sender = '$usr1' AND receiver = '$usr2' OR sender = '$usr2' AND receiver = '$usr1'");
    } else if ($usr1 == "" && $usr2 != "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$curdate' and (sender = '$usr2' OR  receiver = '$usr2')");
    } else if ($usr1 == "" && $usr2 != "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE  sender = '$usr2' OR receiver = '$usr2'");
    } else if ($usr1 != "" && $usr2 == "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$curdate' and (sender = '$usr1' OR receiver = '$usr1') ");
    } else if ($usr1 != "" && $usr2 == "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE sender = '$usr1'  OR receiver = '$usr1'");
    } else if ($usr1 == "" && $usr2 == "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$curdate' ");
    } else {
        $exportData = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox`");
    }
}
//$exportData = mysqli_query($db, "SELECT user_name,firstname,lastname,email,role,hiring_date,job_title_description,shift_location FROM users where users_id !='1' ");
$header = "Sender" . "\t" . "Receiver" . "\t" . "Message" . "\t" . "Chat Date" . "\t";
$result = '';
$fields = mysqli_num_fields($db, $exportData);
for ($i = 0; $i < $fields; $i++) {
    $header .= mysqli_field_name($db, $exportData, $i) . "\t";
}
while ($row = mysqli_fetch_row($exportData)) {
    $line = '';
    $j = 1;
    foreach ($row as $value) {
        if ((!isset($value) ) || ( $value == "" )) {
            $value = "\t";
        } else {
            $value = str_replace('"', '""', $value);
            if ($j == 1) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $first = $rowc04["firstname"];
                    $last = $rowc04["lastname"];
                }
                $value = $first . " " . $last;
            }
            if ($j == 2) {
               $un = $value;
                $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $first = $rowc04["firstname"];
                    $last = $rowc04["lastname"];
                }
                $value = $first . " " . $last;
            }
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
        $j++;
    }
    $result .= trim($line) . "\n";
}
$result = str_replace("\r", "", $result);
if ($result == "") {
    $result = "\nNo Record(s) Found!\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Chat Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
?>