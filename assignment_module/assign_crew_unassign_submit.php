<?php
include("../config.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Error: Connection Error. Please Try Again';
    die();
}
$sessionuser = $_SESSION["fullname"];
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
$message_stauts_class = 'alert-danger';
$import_status_message = 'Error: Assignment Position Relation does not exist';
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
if (count($_POST) > 0) {
//assign crew delete
    $jm = $_POST['assign_line'];
    if ($jm != "") {
        $assign_line = $jm;
    }
    $delete_check = $_POST['delete_check'];
    $delete_user = $_POST['delete_user'];
    $transaction = $_POST['transaction'];
    $delete_position = $_POST['delete_position'];
    $delete_station = $_POST['delete_station'];
    $res_type = $_POST['res_type'];
    if ($delete_check != "") {
        $cnt = count($delete_check);
        for ($i = 0; $i < $cnt;) {
            try {
                //here start transaction
                mysqli_query($conn, "START TRANSACTION");
                $query0001 = sprintf("SELECT * FROM  cam_assign_crew WHERE `assign_crew_id`='$delete_check[$i]' ");
                $qur0001 = mysqli_query($db, $query0001);
                $rowc0001 = mysqli_fetch_array($qur0001);
                $posname = $rowc0001["position_id"];
                $linename = $rowc0001["line_id"];
                $username = $rowc0001["user_id"];
                $assigncrewtransactionid = $rowc0001["assign_crew_transaction_id"];
                $res_type1 = $rowc0001["resource_type"];
                //user unassing
                $queryaa = sprintf("SELECT * FROM  cam_users WHERE users_id = '$username'");
                $quraa = mysqli_query($db, $queryaa);
                $rowcaa = mysqli_fetch_array($quraa);
                $ass = $rowcaa["assigned"];
                $ass1 = $rowcaa["assigned2"];
                $sql_ass_log = "select * from `cam_assign_crew_log` where  assign_crew_transaction_id='$assigncrewtransactionid' and user_id = '$username'";
                $result_ass_log = mysqli_fetch_array(mysqli_query($db, $sql_ass_log));
                if ($ass != 0 && $ass1 == '0') {
                    if (empty($result_ass_log['first_assign_log_id'])) {
                        $qurtime = mysqli_query($db, "SELECT * FROM  cam_assign_crew_log where first_assign_log_id= '$result_ass_log[assign_crew_log_id]' ");
                        $rowctime = mysqli_fetch_array($qurtime);
                        $tottime = "00:00:00";
                        if ($rowctime != null) {
                            $tottime = $rowctime["total_time"];
                        }
                        $sqltra = "update cam_assign_crew_log SET `total_time` = (SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime' ,`assign_time`)) - TIME_TO_SEC('$tottime'))) where assign_crew_transaction_id='$assigncrewtransactionid' and user_id = '$username'";
                        $resulttra = mysqli_query($db, $sqltra);
                    } else {
                        $sql = "SELECT * FROM `cam_assign_crew_log` where assign_crew_log_id = '$result_ass_log[first_assign_log_id]'";
                        $result1 = mysqli_fetch_array(mysqli_query($db, $sql));
                        $sqltra = "update cam_assign_crew_log SET `total_time` = ADDTIME(SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime' ,'$result1[unassign_time]'))),TIME_TO_SEC(TIMEDIFF('$result1[unassign_time]' , '$result_ass_log[assign_time]')) / 2) where assign_crew_transaction_id='$assigncrewtransactionid' and user_id = '$username' ";
                        $resulttra = mysqli_query($db, $sqltra);
                    }
                    $sql = "update cam_users set assigned ='0' where users_id='$username'";
                    $result1 = mysqli_query($db, $sql);
                    $sqltra = "update cam_assign_crew_log set status ='0',last_unassigned_by ='$sessionuser',unassign_time = '$chicagotime' where assign_crew_transaction_id='$assigncrewtransactionid' and user_id = '$username'  ";
                    $resulttra = mysqli_query($db, $sqltra);
                } else {
                    if ($result_ass_log != null) {
                        if (empty($result_ass_log['first_assign_log_id'])) {
                            $sql = "SELECT * FROM `cam_assign_crew_log` where first_assign_log_id = '$result_ass_log[assign_crew_log_id]' and status = 1";
                            $result1 = mysqli_fetch_array(mysqli_query($db, $sql));
                            $sqltra = "update cam_assign_crew_log SET `total_time` = ADDTIME(TIME_TO_SEC(TIMEDIFF('$result1[assign_time]' ,`assign_time`)),SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime' ,'$result1[assign_time]')) / 2)) where assign_crew_transaction_id='$assigncrewtransactionid' and user_id = '$username'";
                            $resulttra = mysqli_query($db, $sqltra);
                        } else {
                            $sqltra = "update cam_assign_crew_log SET `total_time` = ADDTIME('00:00:00',SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime' ,`assign_time`)) / 2)) where assign_crew_transaction_id='$assigncrewtransactionid' and user_id = '$username'";
                            $resulttra = mysqli_query($db, $sqltra);
                            $tottime = $result_ass_log["total_time"];
                            $first_assign_log_id = $result_ass_log["first_assign_log_id"];
                            $sqltime2 = "update cam_assign_crew_log SET `total_time` = ADDTIME('$tottime',`total_time`) where assign_crew_log_id = '$first_assign_log_id'";
                            $resulttime2 = mysqli_query($db, $sqltime2);
                        }
                    }
                    $sql = "update cam_users set assigned2 ='0' where users_id ='$username'";
                    $result1 = mysqli_query($db, $sql);
                    $sqltra = "update cam_assign_crew_log set status ='0',last_unassigned_by ='$sessionuser',unassign_time = '$chicagotime' where assign_crew_transaction_id='$assigncrewtransactionid' and user_id = '$username' ";
                    $resulttra = mysqli_query($db, $sqltra);
                }
                $sql1 = "DELETE FROM `cam_assign_crew` WHERE `assign_crew_id`='$delete_check[$i]'";
                if (!mysqli_query($db, $sql1)) {
                    echo "Invalid Data";
                }
                //user unassing over
                if ($res_type1 == "regular") {
                    $sql5 = "update cam_station_pos_rel set assigned ='0' where line_id='$linename' and position_id='$posname'";
                    $result5 = mysqli_query($db, $sql5);
                }
//first assign log become 0 into log table
                $qurlog01 = mysqli_query($db, "SELECT * FROM  cam_assign_crew WHERE line_id = '$linename'");
                $rowclog01 = mysqli_fetch_array($qurlog01);
                $assign_crew_id01 = $rowclog01["assign_crew_id"];
                if ($assign_crew_id01 == "" || $assign_crew_id01 == NULL) {
                    $sql6 = "update cam_log set flag ='0' , updated_at = '$chicagotime' where line_id='$linename' and flag = '1'";
                    $result6 = mysqli_query($db, $sql6);
                }
//first assign log become 0 into log table over
                mysqli_query($conn, "COMMIT");
            } catch (\Throwable $e) {
                // An exception has been thrown
                // We must rollback the transaction
                //$conn->rollback();
                mysqli_query($conn, "ROLLBACK");
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Error: Assign Un-Successful. Please Try Again';
                //  throw $e; // but the error must be handled anyway
            }
            $i++;
        }
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Crew Unassigned Sucessfully.';
        $assign_line = $_POST['assignline'];
        //$_SESSION['aasignline'] = $_POST['assignline'] ;
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please select crew for Unassign.';
        $assign_line = $_POST['assignline'];
    }
}
$_SESSION['aasignline'] = $_POST['assignline'];
?>
