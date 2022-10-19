<?php include("../config.php");
$curdate = date('Y-m-d');
$button = "";
$temp = "";
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
$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
$_SESSION['button_event'] = "";
$_SESSION['event_type'] = "";
$_SESSION['event_category'] = "";

if (count($_POST) > 0) {
    $_SESSION['station'] = $_POST['station'];
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
    $station = $_POST['station'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];
    $timezone = $_POST['timezone'];
}
if (count($_POST) > 0) {
    $st = $_POST['station'];
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
/*if(isset($station)){
    $_SESSION['station'] = $station;
    $wc = $wc . " and sg_station_event_log_update.line_id = '$station'";
}*/

/* If Data Range is selected */
if ($button == "button1") {
    if(isset($datefrom)){
        $wc = $wc . " and DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' ";
    }
    if(isset($dateto)){
        $wc = $wc . " and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' ";
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
        $wc = $wc . " AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(created_on,'%Y-%m-%d') <= '$curdate' ";
    }
} else{
    $wc = $wc . " and DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' ";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Line Utilization By Date</title>
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
            history.replaceState("", "", "<?php echo $scriptName; ?>config_module/line_utilization_view.php");
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
$cust_cam_page_header = "Line Utilization Data By Date";
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
                <form action="" id="line_count" class="form-horizontal" method="post">
                    <div class="row">
                        <div class="col-md-6 mobile">
                            <label class="col-lg-2 control-label">Station :</label>
                            <div class="col-lg-8">
                                <select name="station" id="station" class="select"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Station ---</option>
                                    <?php
                                    $st_dashboard = $_POST['station'];
                                    $sql1 = "SELECT * FROM `cam_line` where is_deleted != 1 ORDER BY `line_name` ASC ";
                                    $result1 = $mysqli->query($sql1);
                                    //                                            $entry = 'selected';
                                    while ($row1 = $result1->fetch_assoc()) {
                                        if ($st_dashboard == $row1['line_id']) {
                                            $entry = 'selected';
                                        } else {
                                            $entry = '';

                                        }
                                        echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

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
            <div class="row " style="margin: 20px;">
                <div class="col-md-6">
                    <div class="media" style="border: 1px solid black;">
                        <div id="line_container" style="height: 350px; margin-top: 15px ;"></div>
                    </div>
                </div>
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
    /*$('#station').on('change', function (e) {
        $("#line_count").submit();
    });*/
    anychart.onDocumentReady(function () {
        var data = $("#line_count").serialize();
        $.ajax({
            type: 'POST',
            url: 'line_utilization_count.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var line_up = data.posts.map(function (elem) {
                    return elem.line_up;
                });
               var line_down = data.posts.map(function (elem) {
                    return elem.line_down;
                });
                var eop = data.posts.map(function (elem) {
                    return elem.eop;
                });
                var df = data.posts.map(function (elem) {
                    return elem.df;
                });
                var dt = data.posts.map(function (elem) {
                    return elem.dt;
                });
                var h = data.posts.map(function (elem) {
                    return elem.h;
                });

                var data = [
                    {x: 'Line-Up', value: line_up, fill: '#12AD2B'},
                    {x: 'Line-Down', value: line_down, fill: '#FF0000'},
                    {x: 'Eop', value: eop, fill: '#000000'},
                ];
                // create pareto chart with data
                var chart = anychart.pie();


                // enable html for the legend
                chart.legend().useHtml(true);

                // configure the format of legend items
                chart.legend().itemsFormat(
                    "<span style='color:#455a64;font-weight:600'>" +
                    "{%x}:</span> {%value}Hr"
                );

                // set the chart title
                chart.title(
                    '<div style=\'color:#333; font-size: 14px;\'>Line Utilization Data From : <span style="color:#009900; font-size: 12px;"><strong> ' +df+' </strong></span>To: <span style="color:#009900; font-size: 12px;"><strong> ' +dt+' </strong></span></div><br>' +
                    '<div style=\'color:#333; font-size: 14px;\'>Total : <span style="color:#009900; font-size: 12px;"><strong> ' +h+' </strong></span>Hrs</div>'
                );
                chart
                    .title()
                    .useHtml(true)
                    .padding(0)
                    .fontColor('#212121')
                    .hAlign('center')
                    .margin([0, 0, 10, 0]);

                // add the data
                chart.data(data);

                // set legend position
                chart.legend().position("right");
                // set items layout
                chart.legend().itemsLayout("vertical");

                // display the chart in the container
                chart.container('line_container');
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
