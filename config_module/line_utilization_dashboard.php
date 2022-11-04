<?php include("../config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Line Utilization Dashboard</title>
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
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <!--   <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
       <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>-->
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <!--pie chart links-->
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pie.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/js/8.0.1/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/js/8.0.1/anychart-pie.min.js"></script>
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
            .col-md-6 {
                width: 100%;
                float: right;
            }
            label.col-lg-3.control-label {
                width: 25%;
            }
        }


    </style>
    <script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $scriptName; ?>config_module/line_utilization_dashboard.php");
        }
    </script>
</head>
<body class="alt-menu sidebar-noneoverflow">
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Line Utilization Dashboard";
include("../header.php");
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
                <form action="" id="line_data" class="form-horizontal" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-md-6 mobile">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Station : </label>
                                <div class="col-lg-7">
                                    <select name="station" id="station" class="select form-control" data-style="bg-slate">
<!--                                        <option value="" selected disabled>--- Select Station --- </option>-->
                                        <?php
                                            $st_dashboard = $_POST['station'];
                                            if (!isset($st_dashboard)) {
                                                $st_dashboard = $_REQUEST['station'];
                                            }
                                            $sql1 = "SELECT * FROM `cam_line` where enabled = '1' and is_deleted != 1 ORDER BY `line_id` ASC ";
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
                        </div>
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
<!--                        <div class="col-md-2">-->
<!--                            <button type="button" class="btn btn-primary" id="update_btn">Update</button>-->
<!--                        </div>-->
                    </div>
                    <div class="row">
                        <div class="row " style="margin: 20px;">
                            <div class="col-md-6">
                                <div class="media" style="border: 1px solid black;">
                                    <div id="d_container" style="height: 350px; margin-top: 15px ;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="media" style="border: 1px solid black;">
                                    <div id="w_container" style="height: 350px; margin-top: 15px ;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row " style="margin: 20px;">
                            <div class="col-md-6">
                                <div class="media" style="border: 1px solid black;">
                                    <div id="m_container" style="height: 350px; margin-top: 15px ;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="media" style="border: 1px solid black;">
                                    <div id="y_container" style="height: 350px; margin-top: 15px ;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<!-- /page content -->
<script>
    $('#station').on('change', function (e) {
        var data = $("#line_data").serialize();
        $.ajax({
            type: 'POST',
            url: './../log_module/sg_station_event_log_update_by_line_id.php',
            async: false,
            data: data,
            success: function (data) {
                event.preventDefault()
                window.scrollTo(0, 300);
            }
        });
        $("#line_data").submit();
    });
    //daily data
    anychart.onDocumentReady(function () {
        var data = $("#line_data").serialize();
        $.ajax({
            type: 'POST',
            url: 'line_count_daily.php',
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
                var eof = data.posts.map(function (elem) {
                    return elem.eof;
                });
                var others = data.posts.map(function (elem) {
                    return elem.others;
                });
                var d = data.posts.map(function (elem) {
                    return elem.d;
                });
                var dh = data.posts.map(function (elem) {
                    return elem.dh;
                });

                var data = [
                    {x: 'Line-Up', value: line_up, fill: '#177b09'},
                    {x: 'Line-Down', value: line_down, fill: '#FF0000'},
                    {x: 'Eop', value: eof, fill: '#000000'},
                    {x: 'Others', value: others, fill: '#E7BF23'},
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
                chart.title("Daily Utilization Data " + '<div style=\'color:#333; font-size: 14px;\'>Date : <span style="color:#009900; font-size: 12px;"><strong> ' +d+' </strong></span></div><br>'  +
                    '<div style=\'color:#333; font-size: 14px;\'>Total Hours: <span style="color:#009900; font-size: 12px;"><strong> ' +dh+' </strong></span>Hrs</div>');

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
                chart.container('d_container');
                chart.draw();
            }
        });

    });
    //Weekly data
    anychart.onDocumentReady(function () {
        var data = $("#line_data").serialize();
        $.ajax({
            type: 'POST',
            url: 'line_count_weekly.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var line_up1 = data.posts.map(function (elem) {
                    return elem.line_up1;
                });
                var line_down1 = data.posts.map(function (elem) {
                    return elem.line_down1;
                });
                var eof1 = data.posts.map(function (elem) {
                    return elem.eof1;
                });
                var others1 = data.posts.map(function (elem) {
                    return elem.others1;
                });
                var wf = data.posts.map(function (elem) {
                    return elem.wf;
                });
                var wt = data.posts.map(function (elem) {
                    return elem.wt;
                });
                var wh = data.posts.map(function (elem) {
                    return elem.wh;
                });


                var data = [
                    {x: 'Line-Up', value: line_up1, fill: '#177b09'},
                    {x: 'Line-Down', value: line_down1, fill: '#FF0000'},
                    {x: 'Eop', value: eof1, fill: '#000000'},
                    {x: 'Others', value: others1, fill: '#E7BF23'},
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
                chart.title("Weekly Utilization Data " + '<div style=\'color:#333; font-size: 14px;\'>From : <span style="color:#009900; font-size: 12px;"><strong> ' +wf+' </strong></span>To: <span style="color:#009900; font-size: 12px;"><strong> ' +wt+' </strong></span></div><br>' +
                    '<div style=\'color:#333; font-size: 14px;\'>Total Hours: <span style="color:#009900; font-size: 12px;"><strong> ' +wh+' </strong></span>Hrs</div>');

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
                chart.container('w_container');
                chart.draw();
            }
        });

    });
    //Monthly data
    anychart.onDocumentReady(function () {
        var data = $("#line_data").serialize();
        $.ajax({
            type: 'POST',
            url: 'line_count_monthly.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var line_up2 = data.posts.map(function (elem) {
                    return elem.line_up2;
                });
                var line_down2 = data.posts.map(function (elem) {
                    return elem.line_down2;
                });
                var eof2 = data.posts.map(function (elem) {
                    return elem.eof2;
                });
                var others2 = data.posts.map(function (elem) {
                    return elem.others2;
                });
                var mf = data.posts.map(function (elem) {
                    return elem.mf;
                });
                var mt = data.posts.map(function (elem) {
                    return elem.mt;
                });
                var mh = data.posts.map(function (elem) {
                    return elem.mh;
                });

                var data = [
                    {x: 'Line-Up', value: line_up2, fill: '#177b09'},
                    {x: 'Line-Down', value: line_down2, fill: '#FF0000'},
                    {x: 'Eop', value: eof2, fill: '#000000'},
                    {x: 'Others', value: others2, fill: '#E7BF23'},
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
                chart.title("Monthly Utilization Data " + '<div style=\'color:#333; font-size: 14px;\'>From : <span style="color:#009900; font-size: 12px;"><strong> ' +mf+' </strong></span>To: <span style="color:#009900; font-size: 12px;"><strong> ' +mt+' </strong></span></div><br>' +
                    '<div style=\'color:#333; font-size: 14px;\'>Total Hours: <span style="color:#009900; font-size: 12px;"><strong> ' +mh+' </strong></span>Hrs</div>');

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
                chart.container('m_container');
                chart.draw();
            }
        });

    });
    //Yearly data
    anychart.onDocumentReady(function () {
        var data = $("#line_data").serialize();
        $.ajax({
            type: 'POST',
            url: 'line_count_yearly.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var line_up3 = data.posts.map(function (elem) {
                    return elem.line_up3;
                });
                var line_down3 = data.posts.map(function (elem) {
                    return elem.line_down3;
                });
                var eof3 = data.posts.map(function (elem) {
                    return elem.eof3;
                });
                var others3 = data.posts.map(function (elem) {
                    return elem.others3;
                });
                var yf = data.posts.map(function (elem) {
                    return elem.yf;
                });
                var yt = data.posts.map(function (elem) {
                    return elem.yt;
                });
                var yh = data.posts.map(function (elem) {
                    return elem.yh;
                });
                var data = [
                    {x: 'Line-Up', value: line_up3, fill: '#177b09'},
                    {x: 'Line-Down', value: line_down3, fill: '#FF0000'},
                    {x: 'Eop', value: eof3, fill: '#000000'},
                    {x: 'Others', value: others3, fill: '#E7BF23'},
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
                chart.title("Yearly Utilization Data " + '<div style=\'color:#333; font-size: 14px;\'>From : <span style="color:#009900; font-size: 12px;"><strong> ' +yf+' </strong></span>To: <span style="color:#009900; font-size: 12px;"><strong> ' +yt+' </strong></span></div><br>' +
                    '<div style=\'color:#333; font-size: 14px;\'>Total Hours: <span style="color:#009900; font-size: 12px;"><strong> ' +yh+' </strong></span>Hrs</div>');

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
                chart.container('y_container');
                chart.draw();
            }
            });

        });

</script>
<script>
    $("#update_btn").click(function (e) {
        //          $(':input[type="button"]').prop('disabled', true);


        // e.preventDefault();
    });

</script>
<?php include('../footer.php') ?>
</body>
</html>
