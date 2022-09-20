<?php include("../config.php");
$curdate = date('Y-m-d');
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
$button_event = "button3";
if(empty($dateto)){
    $curdate = date('Y-m-d');
    $dateto = $curdate;
}

if(empty($datefrom)){
    $yesdate = date('Y-m-d',strtotime("-1 days"));
    $datefrom = $yesdate;
}
$button = "";
$temp = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
$_SESSION['button_event'] = "";
$_SESSION['event_type'] = "";
$_SESSION['event_category'] = "";
$_SESSION['pf'] = "";

if (count($_POST) > 0) {
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['button'] = $_POST['button'];
    $_SESSION['timezone'] = $_POST['timezone'];
    $_SESSION['button_event'] = $_POST['button_event'];
    $_SESSION['event_type'] = $_POST['event_type'];
    $_SESSION['event_category'] = $_POST['event_category'];
    $button_event = $_POST['button_event'];
    $event_type = $_POST['event_type'];
    $event_category = $_POST['event_category'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];
    $timezone = $_POST['timezone'];
}
if (count($_POST) > 0) {
    $cus_id = $_POST['cus_id'];
    $pf = $_POST['part_family'];
}

if(empty($dateto)){
    $curdate = date('Y-m-d');
    $dateto = $curdate;
}

if(empty($datefrom)){
    $yesdate = date('Y-m-d',strtotime("-1 days"));
    $datefrom = $yesdate;
}

$wc = '';
if(isset($pf)){
    $_SESSION['pf'] = $pf;
    $wc = $wc . " and form_user_data.part_family = '$pf'";
}

/* If Data Range is selected */
if ($button == "button1") {
    if(isset($datefrom)){
        $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' ";
    }
    if(isset($dateto)){
        $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";
    }
} else if ($button == "button2"){
    /* If Date Period is Selected */
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
    if(isset($countdate)){
        $wc = $wc . " AND DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(created_at,'%Y-%m-%d') <= '$curdate' ";
    }
} else{
    $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | </title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-data-adapter.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pareto.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-circular-gauge.min.js"></script>
    <link href="https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/8.11.0/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
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
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <style>
        .anychart-credits{
            display: none !important;
        }
        .datatable-scroll {
            width: 100%;
            overflow-x: scroll;
        }
        .col-md-6.date {
            width: 25%;
        }
        .col-md-2 {
            width: 8.666667%!important;
        }
        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-md-3 {
                width: 30%;
                float: left;
            }
            .col-md-2 {
                width: 20%;
                float: left;
            }
            .col-lg-8 {
                float: right;
                width: 58%;
            }
            label.col-lg-3.control-label {
                width: 42%;
            }
            .col-md-6.date {
                width: 100%;
                float: left;
            }
            .col-md-2 {
                width: 30%!important;
                float: left;
            }
        }
    </style>
    <script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $scriptName; ?>form_module/form_submit_view.php");
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


    <!-- event -->
    <?php
    if ($button_event == "button4") {
        ?>
        <script>
            $(function () {
                $('#event_type').prop('disabled', true);
                $('#event_category').prop('disabled', false);
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(function () {
                $('#event_type').prop('disabled', false);
                $('#event_category').prop('disabled', true);
            });
        </script>
        <?php
    }
    ?>


</head>
<body class="alt-menu sidebar-noneoverflow">
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Form Submit View Count";
include("../header_folder.php");

include("../admin_menu.php");
include("../heading_banner.php");
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
                <form action="" id="view_count" class="form-horizontal" method="post">
                    <div class="row">
                        <div class="col-md-6 mobile">


                            <label class="col-lg-2 control-label">Customer :</label>

                            <div class="col-lg-8">
                                <select name="cus_id" id="cus_id" class="select"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Customer ---</option>

                                    <?php
                                    $entry = '';
                                    $st_dashboard = $_POST['cus_id'];
                                    $sql11 = "SELECT * FROM `cus_account` ORDER BY `c_name` ASC ";
                                    $result11 = $mysqli->query($sql11);
                                    while ($row11 = $result11->fetch_assoc()) {
                                        if($st_dashboard == $row11['c_id'])
                                        {
                                            $entry = 'selected';
                                        }
                                        else
                                        {
                                            $entry = '';

                                        }
                                        echo "<option value='" . $row11['c_id'] . "'$entry>" . $row11['c_name'] . "</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mobile">

                            <label class="col-lg-3 control-label" >Part Family  :</label>

                            <div class="col-lg-8">
                                <select name="part_family" id="part_family" class="select"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Part Family ---</option>

                                    <?php
                                    $cus_id = $_POST['cus_id'];
                                    $st_dashboard = $_POST['part_family'];
                                    $sql21 = "SELECT * FROM `part_family_account_relation` where account_id = '$cus_id'";
                                    $result21 = $mysqli->query($sql21);
                                        while ($row21 = $result21->fetch_assoc()) {
                                            $part_family_id = $row21['part_family_id'];
                                            if ($st_dashboard == $row21['part_family_id']) {
                                                $entry = 'selected';
                                            } else {
                                                $entry = '';
                                            }
                                                $sqlp = "SELECT pm_part_family_id,part_family_name,station FROM `pm_part_family` where `pm_part_family_id` = '$part_family_id'";
                                                $resultp = $mysqli->query($sqlp);
                                                while($row2 = $resultp->fetch_assoc())
                                                {

                                                   echo "<option value='" . $row2['pm_part_family_id'] . "'$entry>" . $row2['part_family_name'] . "</option>";

                                                }
                                        }
                                        ?>


                                </select>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-3 date">
                            <label class="control-label"
                                   style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date
                                From : &nbsp;&nbsp;</label>
                            <input type="date" name="date_from" id="date_from" class="form-control"
                                   value="<?php echo $datefrom; ?>" style="float: left;width: initial;"
                                   required>
                        </div>
                        <div class="col-md-3 date">
                            <label class="control-label"
                                   style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date
                                To: &nbsp;&nbsp;</label>
                            <input type="date" name="date_to" id="date_to" class="form-control"
                                   value="<?php echo $dateto; ?>" style="float: left;width: initial;" required>

                        </div>
                    </div>
                    <br/>
                    <?php
                    if (!empty($import_status_message)) {
                        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                    }
                    ?>
                    <?php
                    if (!empty($_SESSION['import_status_message'])) {
                        echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                        $_SESSION['message_stauts_class'] = '';
                        $_SESSION['import_status_message'] = '';
                    }
                    ?>

                    <div class="panel-footer p_footer">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary"
                                        style="background-color:#1e73be;">
                                    Submit
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" onclick='window.location.reload();'
                                        style="background-color:#1e73be;">Reset
                                </button>
                            </div>
                </form>

            </div>

        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-md-4">
                <div id="lab_container" style="height: 500px; width: 100%;"></div>
            </div>
            <div class="col-md-4">
                <div id="op_container" style="height: 500px; width: 100%;"></div>
            </div>
        </div>
    </form>



    <!-- /content area -->

</div>
<!-- /main content -->
</br>

</div>
<!-- /page content -->
<script>
    $('#cus_id').on('change', function (e) {
        $("#view_count").submit();
    });
    /*$('#part_family').on('change', function (e) {
        $("#view_count").submit();
    });*/
    anychart.onDocumentReady(function () {
        var data = $("#view_count").serialize();
        $.ajax({
            type: 'POST',
            url: 'lab_form_count.php',
            // dataType: 'good_bad_piece_fa.php',
            data: data,
            success: function(data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var d_count = data.posts.map(function (elem) {
                    return elem.d_count;
                });
                var data = [
                    {x: 'Total First Piece Sheet Lab Submitted', value: d_count, fill: '#177b09'},

                ];
                // create pareto chart with data
                var chart = anychart.column(data);
                // set chart title text settings
                // chart.title('Good Pieces & Bad Pieces');
                var title = chart.title();
                title.enabled(true);
//enables HTML tags
                title.useHtml(true);
                title.text(
                    "<br><br>"
                );

                // set measure y axis title
                // chart.yAxis(0).title('Numbers');
                // cumulative percentage y axis title
                // chart.yAxis(1).title(' Percentage');
                // set interval
                // chart.yAxis(1).scale().ticks().interval(10);

                // get pareto column series and set settings
                var column = chart.getSeriesAt(0);

                column.labels().enabled(true).format('{%Value}');
                column.tooltip().format('Value: {%Value}');

                var labels = column.labels();
                labels.fontFamily("Courier");
                labels.fontSize(24);
                labels.fontColor("#125393");
                labels.fontWeight("bold");
                labels.useHtml(false);
                // // background border color
                // column.labels().background().stroke("#663399");
                // column.labels().background().enabled(true).stroke("Green");

                var xLabelsBackground = column.labels().background();
                xLabelsBackground.enabled(true);
                xLabelsBackground.stroke("#cecece");
                xLabelsBackground.cornerType("round");
                xLabelsBackground.corners(5);


                var labels = chart.xAxis().labels();
                labels.fontFamily("Courier");
                labels.fontSize(18);
                labels.fontColor("#125393");
                labels.fontWeight("bold");
                labels.useHtml(false);
                // // background border color
                // column.labels().background().stroke("#663399");
                // column.labels().background().enabled(true).stroke("Green");

                var xLabelsBackground = chart.xAxis().labels().background();
                xLabelsBackground.enabled(true);
                xLabelsBackground.stroke("#cecece");
                xLabelsBackground.cornerType("round");
                xLabelsBackground.corners(5);

                //
                // // get pareto line series and set settings
                // var line = chart.getSeriesAt(1);
                // line
                //     .tooltip()
                //     // .format('Good Pieces: {%CF}% \n Bad Pieces: {%RF}%');
                //     .format('Percent : {%RF}%');
                //
                // // turn on the crosshair and set settings
                // chart.crosshair().enabled(true).xLabel(false);
                // chart.xAxis().labels().rotation(-90);

                // set container id for the chart
                chart.container('lab_container');
                // initiate chart drawing
                chart.draw();
            }
        });
    });
</script>
<script>
    //op
    anychart.onDocumentReady(function () {
        var data = $("#view_count").serialize();
        $.ajax({
            type: 'POST',
            url: 'lab_form_count1.php',
            // dataType: 'good_bad_piece_fa.php',
            data: data,
            success: function(data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var cd = data.posts.map(function (elem) {
                    return elem.cd;
                });
                var data = [
                    {x: 'Total First Piece Sheet Op Submitted', value: cd, fill: '#177b09'},

                ];
                // create pareto chart with data
                var chart = anychart.column(data);
                // set chart title text settings
                // chart.title('Good Pieces & Bad Pieces');
                var title = chart.title();
                title.enabled(true);
//enables HTML tags
                title.useHtml(true);
                title.text(
                    "<br><br>"
                );

                // set measure y axis title
                // chart.yAxis(0).title('Numbers');
                // cumulative percentage y axis title
                // chart.yAxis(1).title(' Percentage');
                // set interval
                // chart.yAxis(1).scale().ticks().interval(10);

                // get pareto column series and set settings
                var column = chart.getSeriesAt(0);

                column.labels().enabled(true).format('{%Value}');
                column.tooltip().format('Value: {%Value}');

                var labels = column.labels();
                labels.fontFamily("Courier");
                labels.fontSize(24);
                labels.fontColor("#125393");
                labels.fontWeight("bold");
                labels.useHtml(false);
                // // background border color
                // column.labels().background().stroke("#663399");
                // column.labels().background().enabled(true).stroke("Green");

                var xLabelsBackground = column.labels().background();
                xLabelsBackground.enabled(true);
                xLabelsBackground.stroke("#cecece");
                xLabelsBackground.cornerType("round");
                xLabelsBackground.corners(5);


                var labels = chart.xAxis().labels();
                labels.fontFamily("Courier");
                labels.fontSize(18);
                labels.fontColor("#125393");
                labels.fontWeight("bold");
                labels.useHtml(false);
                // // background border color
                // column.labels().background().stroke("#663399");
                // column.labels().background().enabled(true).stroke("Green");

                var xLabelsBackground = chart.xAxis().labels().background();
                xLabelsBackground.enabled(true);
                xLabelsBackground.stroke("#cecece");
                xLabelsBackground.cornerType("round");
                xLabelsBackground.corners(5);

                //
                // // get pareto line series and set settings
                // var line = chart.getSeriesAt(1);
                // line
                //     .tooltip()
                //     // .format('Good Pieces: {%CF}% \n Bad Pieces: {%RF}%');
                //     .format('Percent : {%RF}%');
                //
                // // turn on the crosshair and set settings
                // chart.crosshair().enabled(true).xLabel(false);
                // chart.xAxis().labels().rotation(-90);

                // set container id for the chart
                chart.container('op_container');
                // initiate chart drawing
                chart.draw();
            }
        });
    });
</script>

<!-- /dashboard content -->
<script>
    $(function () {
        $('input:radio').change(function () {
            var abc = $(this).val()
            //  alert(abc);
            if (abc == "button1") {
                $('#date_from').prop('disabled', false);
                $('#date_to').prop('disabled', false);
                $('#timezone').prop('disabled', true);
            } else if (abc == "button2") {
                $('#period').prop('disabled', false);
                $('#timezone').prop('disabled', true);
            } else if (abc == "button3") {
                $('#event_category').prop('disabled', true);
                $('#event_type').prop('disabled', false);
            } else if (abc == "button4") {
                $('#event_type').prop('disabled', true);
                $('#event_category').prop('disabled', false);
            }


        });
    });
</script>
<?php include('../footer.php') ?>
</body>
</html>
