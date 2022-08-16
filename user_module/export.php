<?php
include("../config.php");

// Fetch records from database
$query = $db->query("SELECT * FROM cam_users ORDER BY users_id DESC");

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "Users_" . date('Y-m-d') . ".csv";

    // Create a file pointer
    $f = fopen('php://memory', 'w');

    // Set column headers
    $fields = array('Id','User Name', 'Mobile', 'Email', 'Role', 'Created At', 'Firstname', 'Lastname','Hiring Date','Job Title Description');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
    //    $status = ($row['status'] == 1)?'Active':'Inactive';
        $lineData = array($row['users_id'], $row['user_name'], $row['mobile'], $row['email'], $row['role'], $row['created_at'], $row['firstname'], $row['lastname'], $row['hiring_date'], $row['job_title_description']);
        fputcsv($f, $lineData, $delimiter);
    }

    // Move back to beginning of file
    fseek($f, 0);

    // Set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>
