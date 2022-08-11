<?php
include("../config.php");

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
                $password = mysqli_real_escape_string($db,$row[3]);
                $role = mysqli_real_escape_string($db,$row[4]);
                $s_question1 = mysqli_real_escape_string($db,$row[5]);
                $s_question2 = mysqli_real_escape_string($db,$row[6]);
                $s_question3 = mysqli_real_escape_string($db,$row[7]);
                $query = "
                        INSERT INTO cam_users(user_name,mobile,email,password,role,s_question1,s_question2,s_question3)
                      VALUES('$name','$mobile','$email','$password','$role','$s_question1','$s_question2','$s_question3')
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