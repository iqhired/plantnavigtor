<?php
include("config.php");
$temp = "";
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
}
if (count($_POST) > 0) {
	$mob = $_SESSION['user'];
    $password = $_POST['newpass'];

    if( strlen($password ) > 20 ) {
        $error .= "Password too long!";
    }
    if( strlen($password ) < 8 ) {
        $error .= "Password too short!";
    }
    if( !preg_match("@[0-9]@", $password ) ) {
        $error .= "Password must include at least one number!";
    }
    if( !preg_match("@[a-z]@", $password ) ) {
        $error .= "Password must include at least one letter!";
    }
    if( !preg_match("#[A-Z]+#", $password ) ) {
        $error .= "Password must include at least one CAPS!";
    }
    if( !preg_match("@[^\w]@", $password ) ) {
        $error .= "Password must include at least one symbol!";
    }
    if($error){
      //  echo "Password validation failure: $error";
    } else {
      //  echo "Your password is strong.";
        $sql1 = "UPDATE `cam_users` SET password='" . (md5($_POST["newpass"])) . "' where user_name = '$mob'";
        if (!mysqli_query($db, $sql1)) {
// die('Unable to Connect');
            echo "Invalid Data";
        } else {
            $temp = "one";
            $page = "profile.php";
            header('Location: '.$page, true, 303);
        }
        mysqli_query($db, "UPDATE cam_users set status = '0' where user_name = '$mob'");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Change Password</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/pickers/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/dashboard.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /theme JS files -->
    <style>
        .sidebar-default .navigation li > a {
            color: #f5f5f5
        }

        ;
        a:hover {
            background-color: #20a9cc;
        }

        .sidebar-default .navigation li > a:focus, .sidebar-default .navigation li > a:hover {
            background-color: #20a9cc;
        }
    </style>
</head>

<!-- Main navbar -->
<?php $cam_page_header = "Change Your Password"; ?>
<?php include("header_folder.php"); ?>
<!-- /main navbar -->

<!-- Main navigation -->
<?php if(($is_tab_login || $is_cell_login)){include("tab_menu.php");}else{
    include("admin_menu.php");}  ?>
<body class="alt-menu sidebar-noneoverflow">
<!-- Page container -->
<div class="page-container">


            <!-- Content area -->
            <div class="content">
                <!-- Main charts -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Change Password</h5>
                        <hr/>

                        <?php if ($temp == "one") { ?>
                            <div class="alert alert-success no-border">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span><span class="sr-only">Close</span></button>
                                <span class="text-semibold">Password!</span> has been changed successfully.
                            </div>
                        <?php } ?>
                        <?php if ($error) { ?>
                            <div class="alert alert-success no-border">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span><span class="sr-only">Close</span></button>
                                <span class="text-semibold">Password</span> validation failure: <?php echo $error ?>
                            </div>
                        <?php } ?>

                        <form action="" method="post">
                            <div id="col-md-6 mobile" >
                                <br/>
                                <label><b>Enter New Password: </b></label>
                                <input type="password" class="form-control" name="newpass" id="newpass"
                                       style="width: 25%;"required >
                            </div>
                            <br/><br/>
                            <button type="submit" name="submit" id= "change_pass" class="btn btn-primary button-loading">
                                Change Your Password
                            </button>

                        </form>
                        <br/>
                    </div>
                </div>

            </div>
            <!-- /content area -->

</div>
<!-- /page container -->
<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>change_pass.php");



    }
</script>
<?php include('footer.php') ?>
</body>
</html>
