<?php
include("config.php");
$temp = "";
/* if(!isset($_SESSION['user'])){
  header('location: logout.php');
  }
 */
//$assign_line = $_GET['assign_line'];
$assign_line = htmlspecialchars($_GET["station"]);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Assign crew</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style_main.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <!-- Core JS files -->
        <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="assets/js/pages/form_layouts.js"></script>

        <style type="text/css">
            
                .line_head{
                font-size: 16px !important;
                /*margin-top: 30px !important;*/
                }

          
            @media screen and (min-width:1440px)  {
                .line_head{
                font-size: 18px !important;
                /*margin-top: 0px !important;*/
                }
                
            }
            @media screen and (min-width:2560px)  {
                .line_head{
                font-size: 33px !important;
                /*margin-top: 30px !important;*/
                }
                
            }

                .fade-carousel {
                    position: relative;
                    margin-top: 30px;
                    z-index: -1;
                }

          
            
        </style>
    </head>
  <?php     $qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$assign_line' ");
                  while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                      $linename = $rowctemp["line_name"];
                  }

                  $cust_cam_page_header = "Today's Crew Members for&nbsp".$linename;

       include("hp_header.php");
      include("heading_banner.php");?>
    <body class="alt-menu sidebar-noneoverflow">

        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="content" style="padding: 20px!important;">
                <div class="panel panel-flat panel-full-height padding_top_50px">
                    <div class="panel-heading">
                        <div class="row">
                            <?php
                            $countervariable = 0;
                            $sql1 = "SELECT * FROM  cam_assign_crew WHERE `line_id` = '$assign_line'";
                            $result1 = $mysqli->query($sql1);
//                            $rowc1 = $result1->fetch_assoc();
							while ($rowc = $result1->fetch_assoc()) {
                            if ($rowc == null){ ?>

                                    <h1 style="color: black; margin-left: 460px;">No Records Found!</h1>

                            <?php } else{


                                $countervariable++;
                                $user = $rowc["user_id"];
                                $resourcetype = $rowc["resource_type"];
                                $poss = $rowc["position_id"];
                                $color = "";
                                $nm = $rowc["email_notification"];
                                $time = $rowc["created_at"];
                                $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$user' ");
                                while ($rowc04 = mysqli_fetch_array($qur04)) {
                                    $firstname = $rowc04["firstname"];
                                    $lastname = $rowc04["lastname"];
                                    $image = $rowc04["profile_pic"];
                                }
                                if ($image == "") {
                                    $image = "user.png";
                                }
                                if ($nm == "1") {
                                    $buttonclass = "c9302c";
                                } else {
                                    $buttonclass = "218838";
                                }
                                $qur05 = mysqli_query($db, "SELECT * FROM  cam_user_rating where user_id = '$user' and position_id = '$poss' and line_id = '$assign_line' ");
                                while ($rowc05 = mysqli_fetch_array($qur05)) {
                                    $ratecheck = $rowc05["ratings"];
                                }
                                if ($ratecheck == "1") {
                                    $buttonclass = "FBB200";
                                } else if ($ratecheck == "2") {
                                    $buttonclass = "FFFF00";
                                } else if ($ratecheck == "3") {
                                    $buttonclass = "26A33A";
                                } else if ($ratecheck == "4") {
                                    $buttonclass = "105DB6";
                                } else {
                                    $buttonclass = "c9302c";

                                }
                                ?>
                                <div class="col-lg-2 col-sm-4">

                                    <div class="thumbnail" style="background-color:#16b0de1f;">
                                        <div class="thumb thumb-rounded thumb-rounded-cust">
                                            <img src="../user_images/<?php echo $image; ?>" alt="" >
                                        </div>
                                        <div class="caption text-center" style="background-color:#122c5a;">
                                            <h5 class="text-semibold no-margin" id="dash_view_name" ><?php echo $firstname; ?>&nbsp;<?php echo $lastname; ?></h5>
                                            <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $time; ?>">
                                            <?php
                                            $qurtemp = mysqli_query($db, "SELECT * FROM  cam_position where position_id = '$poss' ");
                                            while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                                                $positionname = $rowctemp["position_name"];
                                            }
                                            ?>                        	
                                            <div class="display-block" id="dash_view_position"><?php echo $positionname; ?></div>
                                            <div class="display-block" id="dash_view_rtype"><?php echo $resourcetype; ?></div>
                                            <h4 style="text-align: center;padding:5px; background-color:#<?php echo $buttonclass; ?>">
                                                <div id="demo<?php echo $countervariable; ?>" style="background-color: black;">&nbsp;</div></h4>	
                                        </div>
                                    </div>
                                </div>

                               <!-- <script>
                                    // Set the date we're counting down to
                                    var iddd<?php /*echo $countervariable; */?> = $("#id<?php /*echo $countervariable; */?>").val();
                                    console.log(iddd<?php /*echo $countervariable; */?>);
                                    var countDownDate<?php /*echo $countervariable; */?> = new Date(iddd<?php /*echo $countervariable; */?>).getTime();
                                    // Update the count down every 1 second
                                    var x = setInterval(function () {
                                        // Get today's date and time
                                        // var now = new Date().getTime();
                                        var now = getCurrentTime();
                                        // Find the distance between now and the count down date
                                        var distance = now - countDownDate<?php /*echo $countervariable; */?>;
                                        // Time calculations for days, hours, minutes and seconds
                                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                        console.log(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
                                        console.log("------------------------");
                                        // Output the result in an element with id="demo"
                                        document.getElementById("demo<?php /*echo $countervariable; */?>").innerHTML = days + "d " + hours + "h "
                                                + minutes + "m " + seconds + "s ";
                                        // If the count down is over, write some text 
                                        if (distance < 0) {
                                            clearInterval(x);
                                            document.getElementById("demo<?php /*echo $countervariable; */?>").innerHTML = "EXPIRED";
                                        }
                                    }, 1000);
                                </script>-->
                                <?php
                                //include the timing configuration file
                                include("timings_config.php");
                                $ratecheck = ""; ?>
                           <?php }
                            }                       ?>
                        </div>	
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
        <?php include("footer.php"); ?>	<!-- /page container -->
    </body>
</html>