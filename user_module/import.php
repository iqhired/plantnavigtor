<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']))
    {
        $file_name = $_FILES['file']['name'];
        $output = "";
        $allowed_ext = array("csv");
        $extension = end(explode("." ,$file_name));

       // if (in_array($extension,$allowed_ext)){
            $file_data = fopen($_FILES['file']['tmp_name'],"r");
            fgetcsv($file_data);
            while ($row = fgetcsv($file_data)){
             //   print_r($row);
                $name = mysqli_real_escape_string($db,$row[0]);
                $mobile = mysqli_real_escape_string($db,$row[1]);
                $email = mysqli_real_escape_string($db,$row[2]);
                $password = mysqli_real_escape_string($db,md5('Welcome123!'));
                $role = mysqli_real_escape_string($db,$row[3]);
                $profile = mysqli_real_escape_string($db,'user.png');
                $created_at = mysqli_real_escape_string($db,$chicagotime);
                $firstname = mysqli_real_escape_string($db,$row[4]);
                $lastname = mysqli_real_escape_string($db,$row[5]);
                $hiring_date = mysqli_real_escape_string($db,$row[6]);
                $job_title_description = mysqli_real_escape_string($db,$row[7]);
                $shift_location = mysqli_real_escape_string($db,$row[8]);
                $u_status = mysqli_real_escape_string($db,$row[9]);
                $query = "
                        INSERT INTO cam_users(user_name,mobile,email,password,role,profile_pic,created_at,firstname,lastname,hiring_date,job_title_description,shift_location,u_status)
                      VALUES('$name','$mobile','$email','$password','$role','$profile','$created_at','$firstname','$lastname','$hiring_date','$job_title_description','$shift_location','$u_status')
                ";
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