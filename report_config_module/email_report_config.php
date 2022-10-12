<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: ../logout.php');
}

//Set the session duration for 10800 seconds - 3 hours
$duration = $auto_logout_duration;
//Read the request time of the user
$time = $_SERVER['REQUEST_TIME'];
//Check the user's session exist or not
if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $duration) {
    //Unset the session variables
    session_unset();
    //Destroy the session
    session_destroy();
    header($redirect_logout_path);
//	header('location: ../logout.php');
    exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;

$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Email Report Config</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <style>
        .sidebar-default .navigation li>a{color:#f5f5f5};
        a:hover {
            background-color: #20a9cc;
        }
        .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
            background-color: #20a9cc;
        }
        .form-control:focus {
            border-color: transparent transparent #1e73be !important;
            -webkit-box-shadow: 0 1px 0 #1e73be;
            box-shadow: 0 1px 0 #1e73be !important;
        }
        .form-control {
            border-color: transparent transparent #1e73be;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }  @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-2 {
                width: 28%!important;
                float: left;
            }
            .col-md-6 {
                width: 60%;
                float: left;
            }
            .col-lg-1 {
                width: 12%;
                float: right;
            }
        }
        .abc{
            margin-left: 20px;
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Email Report Config";
include("../header_folder.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<!-- Page container -->
<div class="page-container">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                <h5 class="panel-title">Email Report Config</h5><br>
                <form action="" id="user_form" class="form-horizontal" method="post">

                        <div>
                            <div class="panel panel-flat">
                                <table class="table datatable-basic">
                                    <tbody>
                                    <?php
                                    $query = sprintf("SELECT * FROM  sg_email_report_config");
                                    $qur = mysqli_query($db, $query);
                                    while ($rowc = mysqli_fetch_array($qur)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $rowc["sg_mail_report_name"]; ?></td>
                                            <td class="abc">
                                                <input type="checkbox" name="mail_box" id="mail_box" value="<?php echo $rowc["sg_mail_report_config_id"]; ?>" <?php echo ($rowc['mail_box']==1 ? 'checked' : '');?>>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                        </div>
                </form>
                </div>
                <br/>
            </div>
        </div>
    </div>
</div>
<script>
    $("input#mail_box").click(function () {
        var isChecked = $(this)[0].checked;
        var val = $(this).val();
        var data_1 = "&mail_box=" + val+ "&isChecked=" + isChecked;
        $.ajax({
            type: 'POST',
            url: "mail_box_backend.php",
            data: data_1,
            success: function (response) {

            }
        });

    });

</script>
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>report_config_module/email_report_config.php");
    }
</script>
<?php include ('../footer.php') ?>
</body>
</html>
