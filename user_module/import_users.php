<?php
include("../config.php");
if (isset($_POST['import_data'])) {
    // validate to check uploaded file is a valid csv file
    $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
            //fgetcsv($csv_file);            
            // get data records from csv file
            while (($emp_record = fgetcsv($csv_file)) !== FALSE) {
                $ro = $emp_record[5];
                if ($ro == "admin") {
                    $t = "2";
                }
                if ($ro == "user") {
                    $t = "3";
                }
                $mysql_insert = "INSERT INTO cam_users (user_name,firstname,lastname,email,role,hiring_date,job_title_description,shift_location)VALUES('" . $emp_record[1] . "','" . $emp_record[2] . "','" . $emp_record[3] . "','" . $emp_record[4] . "','" . $t . "','" . $emp_record[6] . "','" . $emp_record[7] . "','" . $emp_record[8] . "')";
                mysqli_query($db, $mysql_insert) or die("database error:" . mysqli_error($conn));
            }
            fclose($csv_file);
            $import_status = '?import_status=success';
        } else {
            $import_status = '?import_status=error';
        }
    } else {
        $import_status = '?import_status=invalid_file';
    }
}
header("Location: users_list.php" . $import_status);
?>