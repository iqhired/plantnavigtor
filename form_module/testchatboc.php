<?php
include("../config.php");
//print_r($_SESSION['id']);


$sql1 = "SELECT DISTINCT  `status` FROM sg_chatbox WHERE `sender` ='" . $_SESSION['id'] . "'";
$result1 = $mysqli->query($sql1);
while ($row1 = $result1->fetch_assoc()) {
    $status = $row1['status'];
    if($status == "Available"){

        $user_color = "green";

    }else if($status  == "Away"){
        $user_color = "orange";

    }else if($status  == "Busy"){
        $user_color = "red";

    }
//print_r($reciver_color);
}



$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
if(isset($_POST['status'])){
    $sql1 = "UPDATE `sg_chatbox` SET status='" . $_POST['status'] . "' where sender = '" . $_SESSION['id'] . "'";
    if (!mysqli_query($db, $sql1)) {
// die('Unable to Connect');
        echo "Invalid Data";
    } else {

        $temp = $_POST['status'];
        exit(json_encode($temp));
    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Chatbot</title>
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
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/support_chat_layouts.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
    <style>
        .sidebar-default .navigation li>a{color:#f5f5f5};

        #dLabel:hover {
            background-color: #20a9cc;
        }
        .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
            background-color: #20a9cc;
        }

        .avilable, .logout, .away ,.dot{
            height: 16px;
            width: 16px;
            border-radius: 50%;
            display: inline-block;
            float: right;
            margin-top: -27px;

        }
        .avilable{ background-color: green;}
        .dot{

            float: right;
            margin-top: 5px;
            margin-right: 0px;}

        .logout{ background-color: red;}
        .away{ background-color: orange;}
        .card{
            width: 19rem;
            float: right;
            margin-top: 0px;
            background: white;
            border-radius: 9px;
            height: 132px;
            font-size: 15px;
            float: right;
            display: none;
            border: 2px solid #1b67ab;
        }
        #status{
            width: auto;
            border-radius: 10px;
            margin-right: 10px;
            background: #1e73be;
        }
        .head{
            font-size: 17px;
            font-weight: 500;
            color: black;
            background: #bdbcbc;
            font-style: oblique;
        }
        a, #noHover{
            color: white;


        }

        /* CSS used here will be applied after bootstrap.css */

        .dropdown {
            display:inline-block;
            margin-left:20px;
            padding:0px;
        }


        .glyphicon-bell {
            font-size: 19px;
            margin-top: 17px;
        }

        .notifications {
            min-width:420px;
        }
        .notifications1 {
            min-width:162px;
        }
        .dropdown-menu:not([class*=border-]) {
            /* border-width: 0px; */
            margin-right: 21px;
        }
        .notifications-wrapper {
            overflow:auto;
            max-height:250px;
        }
        .notifications1-wrapper {
            overflow:auto;
            max-height:250px;
        }

        .menu-title {
            color:#ff7788;
            font-size:1.5rem;
            display:inline-block;
        }

        .glyphicon-circle-arrow-right {
            margin-left:10px;
        }


        .notification-heading, .notification-footer  {
            padding:2px 10px;
        }


        .dropdown-menu.divider {
            margin:5px 0;
        }

        .item-title {

            font-size:1.3rem;
            color:#000;

        }

        .notifications a.content1 {
            text-decoration:none;
            background:#ccc;

        }

        .notification-item {
            padding:10px;
            margin:5px;
            background:#ccc;
            border-radius:4px;
        }
        .noHover{
            pointer-events: none;
        }
        .dropdown-menu>li>a {
            font-size: 1.2rem !important;
            color: black!important;

        }

        .sidebar-secondary {
            z-index: 0;
        }

    </style>
</head>

<!-- Main navbar -->
<?php
$cam_page_header = "Chat Box";
include("../header.php");
include("../admin_menu.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">

        <div class="sidebar sidebar-secondary sidebar-default">

        <div class="content-wrapper">
            <div class="content">


                <div class="tabbable tab-content-bordered content-group-lg">
                            <form action="comment_backend.php" id="update-form" method="post" class="form-horizontal">
                                <input type="text" id="sender" name="sender">
                                <textarea name="enter-message" class="form-control content-group enter-message" rows="3" cols="1" placeholder="Enter your message..."></textarea>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <!--			                        <ul class="icons-list icons-list-extended mt-10">
                                                                                    <li><a href="#" data-popup="tooltip" title="Send photo" data-container="body"><i class="icon-file-picture"></i></a></li>
                                                                                    <li><a href="#" data-popup="tooltip" title="Send video" data-container="body"><i class="icon-file-video"></i></a></li>
                                                                                    <li><a href="#" data-popup="tooltip" title="Send file" data-container="body"><i class="icon-file-plus"></i></a></li>
                                                                                </ul>
                                        -->		                    		</div>

                                    <div class="col-xs-6 text-right">
                                        <button type="button" class="btn btn-primary" onclick="submitForm('comment_backend.php')"  style="background-color:#1e73be;">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>


                </div>

            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>

<!-- /page container -->
<script>

    $(document).on('click', "#status", function() {

        $(".card").show();
        window.setTimeout(function(){
            $(".card").hide();
        }, 3000);
    });


    function getPaging(str) {
        if(str == 1){
            var status = "Available";
        }else if(str == 2){
            status = "Away";

        }else if(str == 3){
            status = "Busy";
        }
        $.ajax({
            type: 'post',
            dataType : 'json',
            encode   : true,
            cache:false,
            data: {status},
            success: function(response){
                //alert(response);
                var sen = response.sen;
                var rec = response.rec;
                /*$(".dot1").css('background-color','sen');
                $(".dot").css('background-color','rec');*/
                window.setTimeout(function(){
                    window.location.href = "chat.php";

                }, 10);



            }
        });
    }


    function startTimer() {
        $(".chat-list").load("chat.php .chat-list > *", function(){
            //repeats itself after 1 seconds
            setTimeout(startTimer, 1000);
        });
    }
    function startTimer1() {
        $(".chat-list1").load("chat.php .chat-list1 > *", function(){
            //repeats itself after 1 seconds
            setTimeout(startTimer1, 1000);
        });
    }
    startTimer();
    startTimer1();

    function submitForm(url) {
        //          $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {

                $("#textarea").val("")
                // window.location.href = window.location.href + "?aa=Line 1";
                //                   $(':input[type="button"]').prop('disabled', false);
                //                   location.reload();
                $(".enter-message").val("");
            }
        });
    }

</script>
<?php include ('../footer.php') ?>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>
