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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Profile</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
        <style>
            .sidebar-default .navigation li>a{color:#f5f5f5};
            a:hover {
                background-color: #20a9cc;
            }
            .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
            }
        </style>
    </head>

        <!-- Main navbar -->
        <?php
        $cam_page_header = "Profile";
        include("header_folder.php");
        ?>
        <!-- /main navbar -->
        <!-- Main navigation -->
        <?php if(($is_tab_login || $is_cell_login)){include("tab_menu.php");}else{
            include("admin_menu.php");}  ?>
        <!-- /main navigation -->
        <body class="alt-menu sidebar-noneoverflow">
        <!-- Page container -->
        <div class="page-container">



                    <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <?php
                                if (!empty($import_status_message)) {
                                    echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div><br/>';
                                }
                                ?>	
                                <h5 class="panel-title">Profile</h5>
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="reload"></a></li>
                                    </ul>
                                </div>
                                <hr>
                            </div>
                            <?php
                            $query = sprintf("SELECT * FROM  cam_users where user_name = '$usr'  ; ");
                            $qur = mysqli_query($db, $query);
                            while ($rowc = mysqli_fetch_array($qur)) {
                                ?> 						
                                <div class="panel-body">
                                    <div class="row">	
                                        <div class="col-md-2">
                                            <div class="thumbnail no-padding">
                                                <div class="thumb">
                                                    <img src="user_images/<?php echo $rowc["profile_pic"]; ?>" alt="">
                                                </div>
                                            </div>
                                        </div>

                                            <div class="col-md-8">
                                                <form action="" id="user_form" class="form-horizontal" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">UserName:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" name="username" value="<?php echo $rowc["user_name"]; ?>" class="form-control" disabled>
                                                            </div>
                                                        </div>							
                                                    </div>
                                                </div>	
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">First Name:*</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" name="firstname" value="<?php echo $rowc["firstname"]; ?>" class="form-control" required>
                                                            </div>
                                                        </div>							
                                                    </div>
                                                </div>	
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Last Name:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" name="lastname" value="<?php echo $rowc["lastname"]; ?>" class="form-control">
                                                            </div>
                                                        </div>							
                                                    </div>
                                                </div>	
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Contact Number:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" name="mobile" value="<?php echo $rowc["mobile"]; ?>" class="form-control" >
                                                            </div>
                                                        </div>							
                                                    </div>
                                                </div>	
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Email:</label>
                                                            <div class="col-lg-9">
                                                                <input type="email" name="email" value="<?php echo $rowc["email"]; ?>" class="form-control" >
                                                            </div>
                                                        </div>							
                                                    </div>
                                                </div>
                                                <?php
                                                $pin_flag = $_SESSION["pin_flag"];
                                                if ($pin_flag == "1") {
                                                    ?>						
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="col-lg-3 control-label">Pin:</label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="pin" value="<?php echo $rowc["pin"]; ?>" maxlength="4"  id="pin" pattern="\d{4}"  title="Enter 4 digit pin number : e.g. 5382" required class="form-control" >
                                                                </div>
                                                            </div>							
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>						
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <?php
                                                        $qur1 = mysqli_query($db, "SELECT role_name FROM role where role_id = '$rowc[role]' ");
                                                        $rowc1 = mysqli_fetch_array($qur1);
                                                        $rl = $rowc1["role_name"];
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Role:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" name="role" value="<?php echo $rl; ?>" class="form-control" disabled>
                                                            </div>
                                                        </div>							
                                                    </div>
                                                </div>	
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Hiring Date:</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" name="hiringdate" value="<?php echo $rowc["hiring_date"]; ?>" class="form-control" disabled>
                                                            </div>
                                                        </div>							
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Profile Pic:</label>
                                                            <div class="col-lg-9">
                                                                <input type="file" name="file" id="file" />
                                                                <input type="hidden" name="rotation" id="rotation" value="0"/>
                                                                <div class="text-right">
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>							
                                                        <div class="img-preview" style="display: none;">
                                                            <button type="button" id="rleft">Left</button>
                                                            <button type="button" id="rright">Right</button><br/><br/>
                                                            <div id="imgPreview"></div>
                                                        </div>										
                                                    </div>
                                                </div>
                                                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                                                </form>
                                            </div>

                                    </div>	
                                </div>
                            <?php } ?>					
                        </div>
                        <!-- /basic datatable -->
                        <!-- /main charts -->
                        <!-- edit modal -->
                        <!-- Dashboard content -->
                        <!-- /dashboard content -->

                    </div>
                    <!-- /content area -->
                </div>

        <!-- /page container -->
        <script>
            window.onload = function () {
                history.replaceState("", "", "<?php echo $scriptName; ?>profile.php");
            }
        </script>
        <script>
            function filePreview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imgPreview + img').remove();
                        $('#imgPreview').after('<img src="' + e.target.result + '" class="pic-view" width="450" height="300"/>');
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
                        $(".pic-view").css({'width': '300px', 'height': '300px'});
                    } else {
                        $(".pic-view").css({'width': '100%', 'height': '300px'});
                    }
                    $('#rotation').val(rotation);
                });
                $("#rleft").click(function () {
                    rotation = (rotation + 90) % 360;
                    $(".pic-view").css({'transform': 'rotate(' + rotation + 'deg)'});
                    if (rotation != 0) {
                        $(".pic-view").css({'width': '300px', 'height': '300px'});
                    } else {
                        $(".pic-view").css({'width': '100%', 'height': '300px'});
                    }
                    $('#rotation').val(rotation);
                });
            });
        </script>
        <?php include ('footer.php') ?>
    </body>
</html>
