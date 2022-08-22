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
            $page = "passuccess.php";
            header('Location: '.$page, true, 303);
        }
        mysqli_query($db, "UPDATE cam_users set u_status = '0' where user_name = '$mob'");
       // mysqli_query($db, "UPDATE cam_users set createdate = '$date' where user_name = '$mob'");
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
    <script>
        function enableButton2() {
            document.getElementById("button2").disabled = false;
        }
    </script>
    <script>
        function displaymessage()
        {
            document.getElementById("change_pass").value;
            alert("password change successfully!...");

        }
    </script>
    <script>
        $('form#id').submit(function(e){
            $(this).children('input[type=submit]').attr('disabled', 'disabled');
            // this is just for demonstration
            e.preventDefault();
            return false;
        });
    </script>
    <!-- /theme JS files -->
   <!-- <style>
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
    </style>-->
    <style>


        @media screen and (min-width: 1440px) and (max-width: 1899px){
            .line_head {
                font-size: 18px !important;
                /*margin-top: 30px !important;*/
            }

        }
        /* CSS Display for TV */
        @media screen and (max-width:1899px) {
            .line_head {
                font-size: large !important;
                /*margin-top: 30px !important;*/
            }

        }
        /* CSS Display for TV */
        @media screen and (min-width:1900px) {
            .navbar-collapse .col-md-3 {
                /*width: 25%;*/
            }
            .line_head {
                font-size: xx-large !important;
                /*margin-top: 30px !important;*/
            }

            .e_progress .circle .title {
                color: #333333 !important;
                font-size: 30px !important;
                line-height: 30px;
                margin: 10px;
                padding: 30px 10px 30px 10px;
                position: absolute;
            }
            .event-timer , .event-timer-val{
                font-size: 100px !important;
                padding: 10px;
                height: 20%;
                text-align: center;
                font-family: inherit;
            }

            #screen_header{
                font-size:  2em;
                margin-top: 0px !important;
                /*color:#286090;*/
                color: #f7f7f7;
                /*margin-top: 15px !important;*/
                /*float:left;*/
            }
            #site_logo{
                width: 250px;
                padding: 5px 15px;
                height: 70px;
                margin-top: 10px;
            }
            .sidebar{
                width: 250px !important;
                font-size: medium;
            }
            #dash_view_name{
                font-size: 2.5em;
                letter-spacing: 1px;
            }
            #dash_view_position{
                color: white;
                text-transform: uppercase;
                font-size: 1.8em;
            }

            #dash_view_rtype{
                color: white;
                /*text-transform: uppercase;*/
                font-size: 2em;
            }
            .dash_view_timer{
                font-size:1.4em;
                background-color: black;
            }
            .dash_timer_counter{
                font-size: 1.5em;
            }
            .thumb-rounded-cust {
                margin: 10px auto 10px;
                min-height: 250px !important;
                max-height: 250px !important;
                overflow: hidden;
                min-width: 250px !important;
                max-width: 250px !important;
            }

            .event-status-heading-end{
                /*background-color: #94241c;*/
                color: #ffffff;
                font-size: 60px !important;
                padding: 20px;
                height: 20%;
                text-align: center;
                font-family: inherit;
            }

            .event-status-heading{
                /*background-color: #27882b;*/
                color: #ffffff;
                font-size: 60px !important;
                padding: 20px;
                height: 20%;
                text-align: center;
                font-family: inherit;
            }

            .event-pf-heading{
                background-color: #f9f9f9;
                font-size: 60px !important;
                padding: 20px;
                text-align: center;
                height: 20%;
                font-family: inherit;
            }

            .event-pn-heading{
                font-size: 50px !important;
                padding: 20px;
                text-align: center;
                height: 20%;
                font-family: inherit;
            }

            .event-timer , .event-timer-val{
                font-size: 120px !important;
                padding: 20px;
                height: 40%;
                text-align: center;
                font-family: inherit;
            }
            .e_progress .circle .label {
                display: inline-block;
                width: 100px !important;
                height: 100px !important;
                border-radius: 80px !important;
                color: #b5b5ba;
                font-size: 60px !important;
            }

        }



    </style>
    <style>
        .header {
            overflow: initial;
            background-color: #060818;
            padding: 18px 25px;
        }

        .header a {
            /*float: left;*/
            color: #fff5f5;
            /*text-align: center;*/
            padding: 2px;
            text-decoration: none;
            font-size: 14px;
            line-height: 25px;
            border-radius: 4px;
        }

        .header a.logo {
            font-size: 25px;
            font-weight: bold;
        }

        /*.header a:hover {*/
        /*    background-color: #ddd;*/
        /*    color: black;*/
        /*}*/

        .header a.active {
            background-color: dodgerblue;
            color: white;
        }

        .header-right {
            float: right;
        }

        @media screen and (max-width: 500px) {
            .header a {
                float: none;
                display: block;
                text-align: left;
            }

            .header-right {
                float: right;
                margin-top: -28px;
            }
            .logo_img {
                height: auto;
                width: 80px!important;
            }
            img.dropbtn_img {
                height: auto;
                width: 25px!important;
                border-radius: 4px;

            }
            .dropbtn{
                font-size: 12px!important;
            }
            svg.arrow.dropbtn {
                margin-left: 94px!important;
                margin-top: -18px!important;
            }

        }
        .dropbtn {
            background-color: #060818;
            color: white;
            /*padding: 16px;*/
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        /*.dropbtn:hover, .dropbtn:focus {*/
        /*    background-color: #2980B9;*/
        /*}*/

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: fixed;
            background-color: #191e3a;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 9999;
            border-radius: 6px;
        }

        .dropdown-content a {
            color: #fff5f5;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #524d4d;
        }
        .logo_img{
            height: auto;
            width: 150px;
        }
        img.dropbtn_img {
            height: auto;
            width: 28px!important;
            border-radius: 4px;
        }
        #screen_header {
            color: #f7f7f7;
            margin-top: -38px;
            /* font-size: 1em; */
            /* margin-top: 30px !important; */
        }
        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {
            .logo_img{
                height: auto;
                width: 120px;
                margin-top: -12px;
            }
            .content_noheader {
                padding: 50px 30px !important;
            }
            #screen_header{
                margin-top: -32px;
            }

        }


        /*.dropdown a:hover {background-color: #ddd;}*/

        .show {display: block;}
    </style>
</head>

<!-- Main navbar -->


<!-- /main navbar -->

<!-- Main navigation -->
<?php /*if(($is_tab_login || $is_cell_login)){include("tab_menu.php");}else{
    include("admin_menu.php");}  */?>

<body class="alt-menu sidebar-noneoverflow">
<div class="header">

    <a class="logo">
        <img class = "logo_img" src="<?php $siteURL ?>assets/img/SGG_logo.png" alt="logo">
    </a>

  <!-- <h3 class="navbar-center" id="screen_header" style=""><span class="text-semibold"><?php /*echo $cam_page_header; */?></span></h3>-->


</div>
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

                <form action="" id="id" method="post">
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
        history.replaceState("", "", "<?php echo $scriptName; ?>change_password.php");



    }
</script>
<?php include('footer.php') ?>
</body>
</html>
