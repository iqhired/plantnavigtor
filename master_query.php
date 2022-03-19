<?php
include("config.php");
//$chicagotime = "2021-02-11 01:46:32";
$conn = mysqli_connect($servername, $username, $password, $dbname);
//$conn = new mysqli($servername, $username, $password, '');
if (!$conn) {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Error: Connection Error. Please Try Again';
    die();
}
try {
    //here start transaction
    mysqli_query($conn, "START TRANSACTION");
    $qur1 = mysqli_query($conn, "select * from `cam_assign_crew_log` "); // give assign_crew_log_id here from table assign_crew_log
    while ($rowc1 = mysqli_fetch_array($qur1)) {
        $id = $rowc1['assign_crew_log_id'];
        $user_id = $rowc1['user_id'];
        $assign_time = $rowc1['assign_time'];
        $unassign_time = $rowc1['unassign_time'];
        $chicagotime = $rowc1['unassign_time'];
        $first_log = $rowc1['first_assign_log_id'];
        $tottime = $rowc1['total_time'];
        if ($first_log == "") {
            $qur2 = mysqli_query($conn, "select * from `cam_assign_crew_log` where  first_assign_log_id = '$id'");
            $rowc2 = mysqli_fetch_array($qur2);
            $assign_time2 = $rowc2['assign_time'];
            $unassign_time2 = $rowc2['unassign_time'];
            if ($assign_time2 != "") {
                if ($unassign_time < $unassign_time2) {
                    $sqltra = "update cam_assign_crew_log SET `total_time` = ADDTIME(SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$assign_time2' ,'$assign_time'))),SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime' ,'$assign_time2')) / 2)) where assign_crew_log_id = '$id'";
//$resulttra = mysqli_query($db, $sqltra);
                    if (!mysqli_query($conn, $sqltra)) {
                        echo "Invalid Data";
                    } else {
                        echo "<br/>";
                        echo "query 1";
                        echo "<br/>";
                    }
                } else {
                    $sqltra = "update cam_assign_crew_log SET `total_time` = (SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime' ,`assign_time`)) - TIME_TO_SEC(TIMEDIFF('$unassign_time2' ,'$assign_time2')) / 2)) where assign_crew_log_id = '$id'";
                    $resulttra = mysqli_query($conn, $sqltra);
                    echo "<br/>";
                    echo "query 2";
                    echo "<br/>";
                }
            } else {
                $sqltra = "update cam_assign_crew_log SET `total_time` = TIMEDIFF('$chicagotime' ,`assign_time`) where assign_crew_log_id = '$id'";
                $resulttra = mysqli_query($conn, $sqltra);
                echo "<br/>";
                echo "query 3";
                echo "<br/>";
            }
        } else {
            $qur3 = mysqli_query($conn, "select * from `cam_assign_crew_log` where  assign_crew_log_id = '$first_log' ");
            $rowc3 = mysqli_fetch_array($qur3);
            $assign_time3 = $rowc3['assign_time'];
            $unassign_time3 = $rowc3['unassign_time'];
            if ($unassign_time < $unassign_time3) {
                $sqltra = "update cam_assign_crew_log SET `total_time` = ADDTIME('00:00:00',SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime' ,`assign_time`)) / 2)) where assign_crew_log_id = '$id'";
                $resulttra = mysqli_query($conn, $sqltra);
                echo "<br/>";
                echo "query 4";
                echo "<br/>";
            } else {
                $sqltra = "update cam_assign_crew_log SET `total_time` = ADDTIME(SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime' ,'$unassign_time3'))),SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$unassign_time3','$assign_time')) / 2)) where assign_crew_log_id = '$id'";
                $resulttra = mysqli_query($conn, $sqltra);
                echo "<br/>";
                echo "query 5";
                echo "<br/>";
            }
        }
    }
    echo "hi";
    mysqli_query($conn, "COMMIT");
} catch (\Throwable $e) {
    // An exception has been thrown
    // We must rollback the transaction
    //$conn->rollback();
    mysqli_query($conn, "ROLLBACK");
    echo 'Error: Assign Un-Successful. Please Try Again';
    //  throw $e; // but the error must be handled anyway
}
?>