<?php include("../config.php");

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
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <!--   <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
       <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>-->
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
            history.replaceState("", "", "<?php echo $scriptName; ?>config_module/form_submit_view_chart.php");
        }
    </script>
</head>
<body class="alt-menu sidebar-noneoverflow">
<!-- Main navbar -->
<?php
$cust_cam_page_header = "First Piece Sheet Dashboard";
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
                <form action="" id="count_view" class="form-horizontal" enctype="multipart/form-data" method="post">
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
        <div class="row " style="margin: 20px;">
            <div class="col-md-6">
                <div class="media">
                    <div id="lab_container" style="height: 350px; margin-top: 15px ;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="media">
                    <div id="op_container" style="height: 350px; margin-top: 15px ;"></div>
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
    $('#cus_id').on('change', function (e) {
        $("#count_view").submit();
    });
    //First Piece Sheet Lab data
    anychart.onDocumentReady(function () {
     //   var data = this.window.location.href.split('?')[1];
        var data = $("#count_view").serialize();
        $.ajax({
            type: 'POST',
            url: 'submit_count.php',
            // dataType: 'good_bad_piece_fa.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var d_count = data.posts.map(function (elem) {
                    return elem.d_count;
                });
                var w_count = data.posts.map(function (elem) {
                    return elem.w_count;
                });
                var m_count = data.posts.map(function (elem) {
                    return elem.m_count;
                });
                var y_count = data.posts.map(function (elem) {
                    return elem.y_count;
                });
                var data = [
                    {x: 'D', value: d_count, fill: '#177b09'},
                    {x: 'W', value: w_count, fill: '#FF0000'},
                    {x: 'M', value: m_count, fill: '#FFA500'},
                    {x: 'Y', value: y_count, fill: '#2643B9'},

                ];
                // create pareto chart with data
                var chart = anychart.column(data);
                // set chart title text settings
                //chart.title('Good Pieces & Bad Pieces');
                var title = chart.title();
                title.enabled(true);
//enables HTML tags
                title.useHtml(true);
                title.text(
                    "<br>First Piece Sheet Lab Data<br>"
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
    //First Piece Sheet Op data
    anychart.onDocumentReady(function () {
        // var data = this.window.location.href.split('?')[1];
        var data = $("#count_view").serialize();
        $.ajax({
            type: 'POST',
            url: 'submit_count1.php',
            // dataType: 'good_bad_piece_fa.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var d_count = data.posts.map(function (elem) {
                    return elem.d_count;
                });
                var w_count = data.posts.map(function (elem) {
                    return elem.w_count;
                });
                var m_count = data.posts.map(function (elem) {
                    return elem.m_count;
                });
                var y_count = data.posts.map(function (elem) {
                    return elem.y_count;
                });
                var data = [
                    {x: 'D', value: d_count, fill: '#177b09'},
                    {x: 'W', value: w_count, fill: '#FF0000'},
                    {x: 'M', value: m_count, fill: '#FFA500'},
                    {x: 'Y', value: y_count, fill: '#2643B9'},

                ];
                // create pareto chart with data
                var chart = anychart.column(data);
                // set chart title text settings
                //chart.title('Good Pieces & Bad Pieces');
                var title = chart.title();
                title.enabled(true);
//enables HTML tags
                title.useHtml(true);
                title.text(
                    "<br>First Piece Sheet Op Data<br>"
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
<?php include('../footer.php') ?>
</body>
</html>
