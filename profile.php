<?php
include("config.php");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
$usr = $_SESSION['user'];
// to display error msg
if (!empty($_SESSION['import_status_message'])) {
    $message_stauts_class = $_SESSION['message_stauts_class'];
    $import_status_message = $_SESSION['import_status_message'];
    $_SESSION['message_stauts_class'] = '';
    $_SESSION['import_status_message'] = '';
}
if (count($_POST) > 0) {
    $uploadPath = 'user_images/';
    $statusMsg = '';
    $upload = 0;
    $pin = $_SESSION["pin"];
    $pin_flag = $_SESSION["pin_flag"];
    if (!empty($_FILES['file']['name'])) {
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileTemp = $_FILES['file']['tmp_name'];
        $filePath = $uploadPath . basename($fileName);
        // Allow certain file formats
        $allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
        if (in_array($fileType, $allowTypes)) {
            $rotation = $_POST['rotation'];
            if ($rotation == -90 || $rotation == 270) {
                $rotation = 90;
            } elseif ($rotation == -180 || $rotation == 180) {
                $rotation = 180;
            } elseif ($rotation == -270 || $rotation == 90) {
                $rotation = 270;
            }
            if (!empty($rotation)) {
                switch ($fileType) {
                    case 'image/png':
                        $source = imagecreatefrompng($fileTemp);
                        break;
                    case 'image/gif':
                        $source = imagecreatefromgif($fileTemp);
                        break;
                    default:
                        $source = imagecreatefromjpeg($fileTemp);
                }
                $imageRotate = imagerotate($source, $rotation, 0);
                switch ($fileType) {
                    case 'image/png':
                        $upload = imagepng($imageRotate, $filePath);
                        break;
                    case 'image/gif':
                        $upload = imagegif($imageRotate, $filePath);
                        break;
                    default:
                        $upload = imagejpeg($imageRotate, $filePath);
                }
            } elseif (move_uploaded_file($fileTemp, $filePath)) {
                $upload = 1;
            } else {
                $statusMsg = 'File upload failed, please try again.';
            }
        } else {
            $statusMsg = 'Sorry, only JPG/JPEG/PNG/GIF files are allowed to upload.';
        }
        if ($upload == 1) {
            if ($pin_flag == "1") {
                $_SESSION["pin"] = $_POST['pin'];
                $sql = "update cam_users set pin='$_POST[pin]',profile_pic='$fileName',firstname='$_POST[firstname]',lastname='$_POST[lastname]',mobile='$_POST[mobile]',email='$_POST[email]' where user_name='$usr'";
            } else {
                $sql = "update cam_users set profile_pic='$fileName',firstname='$_POST[firstname]',lastname='$_POST[lastname]',mobile='$_POST[mobile]',email='$_POST[email]' where user_name='$usr'";
            }
            $result1 = mysqli_query($db, $sql);
            if ($result1) {
                $_SESSION["fullname"] = $_POST['firstname'] . "&nbsp;" . $_POST['lastname'];
                $message_stauts_class = 'alert-success';
                $import_status_message = 'Success: Profile Updated Sucessfully.';
            } else {
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: Please Try Again.';
            }
            $_SESSION["uu_img"] = $fileName;
        } else {
            echo '<h4>' . $statusMsg . '</h4>';
        }
    } else {
        if ($pin_flag == "1") {
            $_SESSION["pin"] = $_POST['pin'];
            $sql = "update cam_users set pin='$_POST[pin]',firstname='$_POST[firstname]',lastname='$_POST[lastname]',mobile='$_POST[mobile]',email='$_POST[email]' where user_name='$usr'";
        } else {
            $sql = "update cam_users set firstname='$_POST[firstname]',lastname='$_POST[lastname]',mobile='$_POST[mobile]',email='$_POST[email]' where user_name='$usr'";
        }
        $_SESSION["fullname"] = $_POST['firstname'] . "&nbsp;" . $_POST['lastname'];
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Success: Profile Updated Sucessfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Try Again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $sitename; ?> | Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">

    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>

    <!-- /core JS files -->

    <style type="text/css">
        body{
            margin-top:20px;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
            font-size: medium;
        }
        .main-body {
            padding: 15px;
        }
        .card {
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 2rem!important;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col, .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }
        .mb-3, .my-3 {
            margin-bottom: 1rem!important;
        }

        .col-md-4 {
            width: 20.333333%;
        }
        #ic .menu ul{
            margin-top: -2.5rem;
        }
        .header{
            margin-top: -20px;
        }
        input.form-control {
            border: solid 1px #ddd;
            padding: 12px;
        }

    </style>
</head>
<?php
$cam_page_header = "Profile";
include("header_folder.php");
?>
<!-- /main navbar -->
<!-- Main navigation -->
<?php if(($is_tab_login || $is_cell_login)){include("tab_menu.php");}else{
    include("admin_menu.php");}  ?>
<body>
<div class="container">
    <?php
    if (!empty($import_status_message)) {
        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div><br/>';
    }
    ?>
    <div class="main-body">
        <?php
        $query = sprintf("SELECT * FROM  cam_users where user_name = '$usr'  ; ");
        $qur = mysqli_query($db, $query);
        while ($rowc = mysqli_fetch_array($qur)) {
            ?>
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center" style="display: block!important;">
                                <img src="user_images/<?php echo $rowc["profile_pic"]; ?>" alt="" style="height: 180px;width: 189px;">
                                <div class="mt-3" style="margin-top: 3rem!important;margin-left: 80px;">


                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="text-left" style="margin-top: 10px;">
                        <a href="<?php echo $siteURL; ?>change_pass.php"> <button type="submit" class="btn btn-primary" style="background-color: #191e3a;">Change Password</button></a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <form action="" id="user_form" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">User Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="username" value="<?php echo $rowc["user_name"]; ?>" class="form-control" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">First Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="firstname" value="<?php echo $rowc["firstname"]; ?>" class="form-control" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Last Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="lastname" value="<?php echo $rowc["lastname"]; ?>" class="form-control">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Contact Number</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="mobile" value="<?php echo $rowc["mobile"]; ?>" class="form-control" >
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" name="email" value="<?php echo $rowc["email"]; ?>" class="form-control" >
                                    </div>
                                </div>
                                <hr>
                                <?php
                                $pin_flag = $_SESSION["pin_flag"];
                                if ($pin_flag == "1") {
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Pin</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="pin" value="<?php echo $rowc["pin"]; ?>" maxlength="4"  id="pin" pattern="\d{4}"  title="Enter 4 digit pin number : e.g. 5382" required class="form-control" >

                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <hr>
                                <?php
                                $qur1 = mysqli_query($db, "SELECT role_name FROM cam_role where role_id = '$rowc[role]' ");
                                $rowc1 = mysqli_fetch_array($qur1);
                                $rl = $rowc1["role_name"];
                                ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Role</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="role" value="<?php echo $rl; ?>" class="form-control" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Hiring Date</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="hiringdate" value="<?php echo $rowc["hiring_date"]; ?>" class="form-control" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Upload New Image</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="file" id="file" />
                                        <input type="hidden" name="rotation" id="rotation" value="0"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9 text-secondary" >
                                        <div class="img-preview" style="display: none;">
                                            <button type="button" id="rleft">Left</button>
                                            <button type="button" id="rright">Right</button><br/><br/>
                                        </div>
                                        <div id="imgPreview"></div>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-info ">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>





                </div>
            </div>
        <?php } ?>
    </div>
</div>


<script>
    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgPreview + img').remove();
                $('#imgPreview').after('<img src="' + e.target.result + '" class="pic-view" width="200" height="150" float="left"/>');
            };
            reader.readAsDataURL(input.files[0]);
            $('.img-preview').show();
        } else {
            $('#imgPreview + img').remove();
            $('.img-preview').hide();
        }
    }
    $("#file").change(function () {
        // Image preview
        filePreview(this);
    });
    $(function () {
        var rotation = 0;
        $("#rright").click(function () {
            rotation = (rotation - 90) % 360;
            $(".pic-view").css({'transform': 'rotate(' + rotation + 'deg)'});
            if (rotation != 0) {
                $(".pic-view").css({'width': '100px', 'height': '132px'});
            } else {
                $(".pic-view").css({'width': '24%', 'height': '132px'});
            }
            $('#rotation').val(rotation);
        });
        $("#rleft").click(function () {
            rotation = (rotation + 90) % 360;
            $(".pic-view").css({'transform': 'rotate(' + rotation + 'deg)'});
            if (rotation != 0) {
                $(".pic-view").css({'width': '100px', 'height': '132px'});
            } else {
                $(".pic-view").css({'width': '24%', 'height': '132px'});
            }
            $('#rotation').val(rotation);
        });
    });
</script>
</body>
</html>
