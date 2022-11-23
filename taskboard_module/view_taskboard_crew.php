<?php
include("../config.php");
$temp = "";
/* if(!isset($_SESSION['user'])){
  header('location: logout.php');
  }
 */
//$assign_line = $_GET['assign_line'];
$group_id = htmlspecialchars($_GET["group_id"]);
$taskboard_name = htmlspecialchars($_GET["taskboard"]);
$curdate = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Taskboard Crew</title>
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
        <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
        <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
        <script type="text/javascript" src="assets/js/time_display.js"></script>
    </head>
    <?php
    $cam_page_header = "Crew Members for&nbsp".$taskboard_name;

      include("../hp_header.php");  ?>

    <body class="alt-menu sidebar-noneoverflow">
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <div class="panel panel-flat panel-full-height padding_top_50px">
                    <div class="panel-heading">
                        <div class="row">
                            <?php
                            $countervariable = 0;
                            $sql1 = "SELECT * FROM  sg_user_group WHERE `group_id` = '$group_id'";
                            $result1 = $mysqli->query($sql1);
                            //                                            $entry = 'selected';
                            while ($rowc = $result1->fetch_assoc()) {
                                $user = $rowc["user_id"];
                                $color = "";
                                $qur03 = mysqli_query($db, "SELECT * FROM `tm_task` where assign_to = '$user' and status = '1' ");
                                while ($rowc03 = mysqli_fetch_array($qur03)) {
									$estimateduration = $rowc03["duration"];
                                    $time = $rowc03["duration"];
                                    $t11 = $rowc03["duration"];
                                    $eq = $rowc03["equipment"];
                                    $des = $rowc03["description"];
                                    $bui = $rowc03["building"];
                                    $pro = $rowc03["property"];
                                    $pri = $rowc03["priority"];
                                    $qur0351 = mysqli_query($db, "SELECT * FROM `tm_building` where tm_building_id = '$bui' ");
                                    $rowc0351 = mysqli_fetch_array($qur0351);
                                    $qur0352 = mysqli_query($db, "SELECT * FROM `tm_description` where tm_description_id = '$des' ");
                                    $rowc0352 = mysqli_fetch_array($qur0352);
                                    $qur0353 = mysqli_query($db, "SELECT * FROM `tm_equipment` where tm_equipment_id = '$eq'  ");
                                    $rowc0353 = mysqli_fetch_array($qur0353);
                                    $qur0354 = mysqli_query($db, "SELECT * FROM `tm_property` where tm_property_id = '$pro'  ");
                                    $rowc0354 = mysqli_fetch_array($qur0354);
                                    $eq1 = $rowc0353['tm_equipment_name'];
                                    $des1 = $rowc0352['tm_description_name'];
                                    $bui1 = $rowc0351['tm_building_name'];
                                    $pro1 = $rowc0354['tm_property_name'];
                                    $arrteam1 = explode(':', $t11);
                                    $hours = $arrteam1[0];
                                    $minutes = $arrteam1[1];
                                    $hours1 = $hours * 60;
                                    $minutes1 = $minutes + $hours1;
                                    $date = $rowc03["assigned_time"];
                                    $date = strtotime($date);
                                    $date = strtotime("+" . $minutes1 . " minute", $date);
                                    $date = date('Y-m-d H:i:s', $date);
									$working_from_time = $rowc03["assigned_time"];
//echo date('Y-m-d H:i:s', $date);
                                    $calcdatet = strtotime($date);
                                    $calccurrdate = strtotime($curdate);
                                }
                                $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$user' and available = '1' ");
                                while ($rowc04 = mysqli_fetch_array($qur04)) {
                                    $firstname = $rowc04["firstname"];
                                    $lastname = $rowc04["lastname"];
                                    $image = $rowc04["profile_pic"];
                                    $nm = $rowc04["available"];
                                    $countervariable++;
                                    $buttonclass = "218838";
                                    if ($date != "") {
                                        if ($pri == "Low") {
                                            $buttonclass = "FFFF00";
                                        } else if ($pri == "Medium") {
                                            $buttonclass = "dc6805";
                                        } else if ($pri == "High") {
                                            $buttonclass = "c9302c";
                                        } else {
                                            $buttonclass = "c9302c";
                                        }
                                    }
                                    /*
                                      if($ratecheck == "1")
                                      {
                                      $buttonclass = "FBB200"; orange
                                      }
                                      else if($ratecheck == "2")
                                      {
                                      $buttonclass = "FFFF00"; yellow
                                      }else if($ratecheck == "3")
                                      {
                                      $buttonclass = "26A33A"; green
                                      }else if($ratecheck == "4")
                                      {
                                      $buttonclass = "105DB6"; blue
                                      }
                                      else
                                      {
                                      $buttonclass = "c9302c"; red
                                      }
                                     */
                                    ?>
                                    <div class="col-lg-3 col-sm-6">
                                        <style>
                                        </style>
                                        <div class="thumbnail" style="background-color:#16b0de1f;">
                                            <div class="thumb thumb-rounded thumb-rounded-cust">
                                                <img src="../user_images/<?php echo $image; ?>" alt="" >
                                            </div>
                                            <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $date; ?>">
                                            <input type="hidden" id="working_from_time<?php echo $countervariable; ?>" value="<?php echo $working_from_time; ?>">
                                            <div class="caption text-center" style="background-color:#122c5a;">
                                                <h5 class="text-semibold no-margin" id="dash_view_name" ><?php echo $firstname; ?>&nbsp;<?php echo $lastname; ?></h5><hr>
                                            </div>
                                            <div class="" style="background-color:#122c5a;">
                                                <div class="display-block" style="padding:3px 30px;" id="dash_view_position"><b>Building :</b> <?php echo $bui1; ?></div>
                                                <div class="display-block" style="padding:3px 30px;" id="dash_view_position"><b>Property :</b> <?php echo $pro1; ?></div>
                                                <div class="display-block" style="padding:3px 30px;" id="dash_view_position"><b>Equipment :</b> <?php echo $eq1; ?></div>
                                                <div class="display-block" style="padding:3px 30px;" id="dash_view_position"><b>Priority :</b> <?php echo $pri; ?></div>
                                                <div class="display-block" style="padding:3px 30px;" id="dash_view_position"><b>Estimated Duration :</b> <?php echo $estimateduration; ?></div>
                                            </div>
                                            <div class="caption text-center" style="background-color:#122c5a;">
                                                <h4 style="text-align: center;padding:5px; background-color:#<?php echo $buttonclass; ?>">
                                                    <?php if ($date != "") { ?>
                                                        <div id="demo<?php echo $countervariable; ?>" style="background-color: black;">&nbsp;</div>
                                                    <?php } else { ?>
                                                        <div id="dmo<?php echo $countervariable; ?>" style="background-color: black;">Available</div>
                                                    <?php } ?>
                                                </h4>	
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function calcTime(city, offset) {
                                            d = new Date();
                                            utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                                            nd = new Date(utc + (3600000 * offset));
                                            return nd;
                                        }
                                        // Set the date we're counting down to
                                        var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                                       
									   var working_from_time<?php echo $countervariable; ?> = $("#working_from_time<?php echo $countervariable; ?>").val();
                                       
									   //console.log(iddd<?php echo $countervariable; ?>);
                                        var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                                       
									    var countDownworkingDate<?php echo $countervariable; ?> = new Date(working_from_time<?php echo $countervariable; ?>).getTime();
                                       
										// Update the count down every 1 second
                                        var x = setInterval(function () {
                                            // Get today's date and time
                                            // var now = new Date().getTime();
                                            var now = calcTime('Chicago', '-6');
                                            // Find the distance between now and the count down date
                                            //aaya change karvano che	
                                            var distance = countDownDate<?php echo $countervariable; ?> - now;
                                            // Time calculations for days, hours, minutes and seconds
                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                           // console.log(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
                                          //  console.log("------------------------");
                                            // Output the result in an element with id="demo"
                                            document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Next available in: ' + hours + "h "
                                                    + minutes + "m ";
                                            // If the count down is over, write some text 
                                            if (distance <= 0) {
                                                // clearInterval(x);
											    var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                        	 var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                            var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);
                                            
                                            document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Working Since: ' + workinghours + "h "
                                                    + workingminutes + "m ";
                                            }
                                        }, 1000);
                                    </script>
                                    <?php
									$estimateduration = "";
                                    $eq1 = "";
                                    $des1 = "";
                                    $pro1 = "";
                                    $bui1 = "";
                                    $pri = "";
                                    $buttonclass = "218838";
                                    $date = "";
                                    ?>				
                                    <?php
                                    $ratecheck = "";
                                }
                            }
                            ?>
                        </div>	
                    </div>
                    <script>
                        setTimeout(function () {
                            //alert("reload");
                            location.reload();
                        }, 30000);
                    </script>
                </div>
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
    <?php include('../footer.php') ?>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
</html>