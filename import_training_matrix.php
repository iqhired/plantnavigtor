<?php
include("config.php");
$chicagotime = date("Y-m-d H:i:s");
// Validate whether selected file is a CSV file
$created_by_user = $_SESSION['id'];

if (!empty($_FILES['file']['name']))
{
    $file_name = $_FILES['file']['name'];
    $ln = $_POST['li'];
    $output = "";
    $allowed_ext = array("csv");
    $extension = end(explode("." ,$file_name));

    // if (in_array($extension,$allowed_ext)){
    $file_data = fopen($_FILES['file']['tmp_name'],"r");
    fgetcsv($file_data);
    while ($row = fgetcsv($file_data)){
        //   print_r($row);
        $position_name = mysqli_real_escape_string($db,$row[0]);
        $position_id = mysqli_real_escape_string($db,$row[1]);
        $line_name = mysqli_real_escape_string($db,$row[2]);
        $line_id = mysqli_real_escape_string($db,$row[3]);
        $user_name = mysqli_real_escape_string($db,$row[4]);
        $user_id = mysqli_real_escape_string($db,$row[5]);
        $ratings = mysqli_real_escape_string($db,$row[5]);
        $created_at = mysqli_real_escape_string($db,$chicagotime);

        $query = "INSERT INTO cam_user_rating(position_name,position_id,line_name,line_id,user_name,user_id,ratings,created_at)
                      VALUES('$position_name','$position_id','$line_name','$line_id','$user_name','$user_id','$ratings','$created_at')";

        mysqli_query($db,$query);


    }
    //   }



}
else
{
    echo "Please select valid file";
}


//header("Location: users_list.php" );
?>