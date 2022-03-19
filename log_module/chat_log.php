<?php
include("../config.php");
$curdate = date('Y-m-d');
$dateto = $curdate;
$datefrom = $curdate;
$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
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

$_SESSION['usr2'] = "";
$_SESSION['usr1'] = "";
$_SESSION['date_to'] = "";
$_SESSION['date_from'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
if (count($_POST) > 0) {
	
    $_SESSION['usr2'] = $_POST['usr2'];
    $_SESSION['usr1'] = $_POST['usr1'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['button'] = $_POST['button'];
    $_SESSION['timezone'] = $_POST['timezone'];

    $usr1 = $_POST['usr1'];
    $usr2 = $_POST['usr2'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];
    $timezone = $_POST['timezone'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Chat Log</title>
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
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
        <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
        
        <script>
            window.onload = function() {
                history.replaceState("", "", "<?php echo $scriptName; ?>log_module/assign_crew_log.php");
         // $('#timezone').prop('disabled', true);	 
                        
            }
        </script>
        
        <?php
        if ($button == "button2") {
            ?>
            <script>
                $(function () {
                    $('#date_from').prop('disabled', true);
                    $('#date_to').prop('disabled', true);
                    $('#timezone').prop('disabled', false);
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                $(function () {
                    $('#date_from').prop('disabled', false);
                    $('#date_to').prop('disabled', false);
                    $('#timezone').prop('disabled', true);
                });
            </script>
            <?php
        }
        ?>
    </head>
    <body>
        <!-- Main navbar -->
        <?php
        $cam_page_header = "Chat Log";
        include("../header_folder.php");
        include("../admin_menu.php");
        ?>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">

                    <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <!--							<h5 class="panel-title">Stations</h5>-->
                                <!--							<hr/>-->
                                <div class="row">
                                    <form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="col-md-1">
                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">User 1: &nbsp;&nbsp;</label>
                                        </div>
                                        <div class="col-md-3">
                                            <select  name="usr1" id="usr1" class="select"  style="float: left;width: initial;" >
                                                <option value="" selected disabled>--- Select User 1---</option>
                                                <?php
                                                                $sql1 = "SELECT * FROM `cam_users` WHERE `users_id` != '1' order BY `firstname`";
                                                                $result1 = $mysqli->query($sql1);
                                                                //                                            $entry = 'selected';
                                                                while ($row1 = $result1->fetch_assoc()) {
																$number = $row1['users_id'];
																$postnumber = $_POST['usr1'];
																if($number == $postnumber)
																{
																	$entry = 'selected';																	
																}
																else
																{
																	$entry = '';
																}	
                                                $full = $row1['firstname'] . " " . $row1['lastname'];
                                                                    echo "<option value='" . $row1['users_id'] . "' $entry>$full</option>";
                                                                                    }
                                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">Date Range : &nbsp;&nbsp;</label>
                                            <?php
                                            if ($button != "button2") {
                                                $checked = "checked";
                                            } else {
                                                $checked == "";
                                            }
                                            ?>
                                            <input type="radio" name="button" id="button1" class="form-control" value="button1" style="float: left;width: initial;"<?php echo $checked; ?>>
                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date From : &nbsp;&nbsp;</label>
                                            <input type="date" name="date_from" id="date_from" class="form-control" value="<?php echo $datefrom; ?>" style="float: left;width: initial;" required>
                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date To: &nbsp;&nbsp;</label>
                                            <input type="date" name="date_to" id="date_to" class="form-control" value="<?php echo $dateto; ?>" style="float: left;width: initial;" required>
                                        </div>
                                </div>
                                <div class="row">
                                    <br/>
                                    <div class="col-md-1">
                                        <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">User 2: &nbsp;&nbsp;</label>
                                    </div>
                                   <div class="col-md-3">
                                            <select  name="usr2" id="usr2" class="select"  style="float: left;width: initial;" >
                                                <option value="" selected disabled>--- Select User 2---</option>
                                                <?php
                                                                $sql1 = "SELECT * FROM `cam_users` WHERE `users_id` != '1' order BY `firstname`";
                                                                $result1 = $mysqli->query($sql1);
                                                                //                                            
                                                                while ($row1 = $result1->fetch_assoc()) {
																$number = $row1['users_id'];
																$postnumber = $_POST['usr2'];
																if($number == $postnumber)
																{
																	$entry = 'selected';																	
																}
																else
																{
																	$entry = '';
																}
                                                $full = $row1['firstname'] . " " . $row1['lastname'];
                                                                    echo "<option value='" . $row1['users_id'] . "' $entry>$full</option>";
                                                                                    }
                                                                ?>
                                            </select>
                                        </div>
                                    <div class="col-md-4">
                                        <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">Select Period : &nbsp;&nbsp;</label>
                                        <?php
                                        if ($button == "button2") {
                                            $checked = "checked";
                                        } else {
                                            $checked = "";
                                        }
                                        ?>
                                        <input type="radio" name="button" id="button2" value="button2" class="form-control" style="float: left;width: initial;" <?php echo $checked; ?>></input>
                                        <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <select  name="timezone" id="timezone" class="form-control" style="float: left;width: initial;" >
                                            <option value="" selected disabled>--- Select Period ---</option>
                                            <?php
                                            if ($timezone == "1") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>
                                            <option value="1" <?php echo $selected; ?>>One Day</option>
                                            <?php
                                            if ($timezone == "7") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>
                                            <option value="7" <?php echo $selected; ?>>One Week</option>
                                            <?php
                                            if ($timezone == "30") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>
                                            <option value="30" <?php echo $selected; ?>>One Month</option>
                                            <?php
                                            if ($timezone == "90") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>
                                            <option value="90" <?php echo $selected; ?>>Three Month</option>
                                            <?php
                                            if ($timezone == "180") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>
                                            <option value="180" <?php echo $selected; ?>>Six Month</option>
                                            <?php
                                            if ($timezone == "365") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            ?>
                                            <option value="365" <?php echo $selected; ?>>One Year</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <br/>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Search</button>
                                    </div>
                                    <div class="col-md-2" style="text-align: center;">
                                        <button type="button" class="btn btn-primary" onclick='window.location.reload();' style="background-color:#1e73be;">Reset</button>
                                    </div>
                                    </form>
                                    <div class="col-md-2" style="text-align: left;">
                                        <form action="export_chat_log.php" method="post" name="export_excel">
                                            <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" id="export" name="export"   data-loading-text="Loading...">Export Data</button>
                                        </form>
                                    </div>
                                </div><br/>
                                <?php
                                if (!empty($import_status_message)) {
                                    echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                                }
                                ?>
                                <?php
                                if (!empty($_SESSION[import_status_message])) {
                                    echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                    $_SESSION['message_stauts_class'] = '';
                                    $_SESSION['import_status_message'] = '';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="panel panel-flat">					
                            <table class="table datatable-basic">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Sender</th>
                                        <th>Receiver</th>
                                        <th>Chat</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' ");
                                    if (count($_POST) > 0) {
                                        $usr2 = $_POST['usr2'];
                                        $usr1 = $_POST['usr1'];
                                        $dateto = $_POST['date_to'];
                                        $datefrom = $_POST['date_from'];
                                        $button = $_POST['button'];
                                        $timezone = $_POST['timezone'];
                                        if ($button == "button1") {
                                            if ($usr1 != "" && $usr2 != "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' and (sender = '$usr1' AND receiver = '$usr2' OR sender = '$usr2' AND receiver = '$usr1')");
                                            } else if ($usr1 != "" && $usr2 != "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE  sender = '$usr1' AND receiver = '$usr2' OR sender = '$usr2' AND receiver = '$usr1'");
                                            } else if ($usr1 != "" && $usr2 == "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' and (sender = '$usr1' OR receiver = '$usr1') ");
                                            } else if ($usr1 != "" && $usr2 == "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE sender = '$usr1' OR receiver = '$usr1'");
                                            } else if ($ur1 == "" && $usr2 != "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' and (sender = '$usr2' OR receiver = '$usr2')");
                                            } else if ($usr1 == "" && $usr2 != "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE sender = '$usr2' OR receiver = '$usr2'");
                                            } else if ($usr1 == "" && $usr2 == "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$dateto' ");
                                            }
                                        } else {
                                            $curdate = date('Y-m-d');
                                            if ($timezone == "7") {
                                                $countdate = date('Y-m-d', strtotime('-7 days'));
                                            } else if ($timezone == "1") {
                                                $countdate = date('Y-m-d', strtotime('-1 days'));
                                            } else if ($timezone == "30") {
                                                $countdate = date('Y-m-d', strtotime('-30 days'));
                                            } else if ($timezone == "90") {
                                                $countdate = date('Y-m-d', strtotime('-90 days'));
                                            } else if ($timezone == "180") {
                                                $countdate = date('Y-m-d', strtotime('-180 days'));
                                            } else if ($timezone == "365") {
                                                $countdate = date('Y-m-d', strtotime('-365 days'));
                                            }
                                            if ($usr1 != "" && $usr2 != "" && $timezone != "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$curdate' and (sender = '$usr1' AND receiver = '$usr2' OR sender = '$usr2' AND receiver = '$usr1')");
                                            } else if ($usr1 != "" && $usr2 != "" && $timezone == "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE  sender = '$usr1' AND receiver = '$usr2' OR sender = '$usr2' AND receiver = '$usr1'");
                                            } else if ($usr1 == "" && $usr2 != "" && $timezone != "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$curdate' and (sender = '$usr2' OR  receiver = '$usr2')");
                                            } else if ($usr1 == "" && $usr2 != "" && $timezone == "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE  sender = '$usr2' OR receiver = '$usr2'");
                                            } else if ($usr1 != "" && $usr2 == "" && $timezone != "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$curdate' and (sender = '$usr1' OR receiver = '$usr1') ");
                                            } else if ($usr1 != "" && $usr2 == "" && $timezone == "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE sender = '$usr1'  OR receiver = '$usr1'");
                                            } else if ($usr1 == "" && $usr2 == "" && $timezone != "") {
                                                $qur = mysqli_query($db, "SELECT `sender`,`receiver`,`message`,`createdat` FROM `sg_chatbox` WHERE DATE_FORMAT(`createdat`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`createdat`,'%Y-%m-%d') <= '$curdate' ");
                                            }
                                        }
//$message = "Date :- ".$name;
//echo "<script type='text/javascript'>alert('$message');</script>";
//$qur =  mysqli_query($db,"SELECT * FROM `assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') = '$date' and `user` = '$name'");
                                    }
                                    while ($rowc = mysqli_fetch_array($qur)) {
                                        $dateTime = $rowc["assign_time"];
                                        $dateTime2 = $rowc["unassign_time"];
//$nt = TIMEDIFF($dateTime, $dateTime2);
                                        ?> 
                                        <tr>
                                            <td><?php echo ++$counter; ?></td>
                                            <?php
                                            $un = $rowc['sender'];
                                            $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $first = $rowc04["firstname"];
                                                $last = $rowc04["lastname"];
                                            }
                                            ?>
                                            <td><?php echo $first; ?>&nbsp;<?php echo $last; ?></td>
                                            
											<?php
                                            $un = $rowc['receiver'];
                                            $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $first = $rowc04["firstname"];
                                                $last = $rowc04["lastname"];
                                            }
                                            ?>
                                            <td><?php echo $first; ?>&nbsp;<?php echo $last; ?></td>
                                            
                                            <td><?php echo $rowc["message"]; ?></td>
											
                                            <td><?php echo $rowc["createdat"]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /basic datatable -->
                        <!-- /main charts -->
                        <!-- edit modal -->
                        <!-- Dashboard content -->
                        <!-- /dashboard content -->
                        <script>
                            $(function () {
                                $('input:radio').change(function () {
                                    var abc = $(this).val()
                                    //  alert(abc);
                                    if (abc == "button1")
                                    {
                                        $('#date_from').prop('disabled', false);
                                        $('#date_to').prop('disabled', false);
                                        $('#timezone').prop('disabled', true);
                                    } else if (abc == "button2")
                                    {
                                        $('#date_from').prop('disabled', true);
                                        $('#date_to').prop('disabled', true);
                                        $('#timezone').prop('disabled', false);
                                    }
                                });
                            });
                        </script>
                    </div>
                    <!-- /content area -->
                    
                </div>

        <?php include ('../footer.php') ?>
    </body>
</html>
