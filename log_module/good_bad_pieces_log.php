<?php include("../config.php");
$button_event = "button3";
$curdate = date('Y-m-d');
$dateto = $curdate;
$datefrom = $curdate;
$button = "";
$temp = "";
// if (!isset($_SESSION['user'])) {
// 	header('location: logout.php');
// }
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
	$station1 = $_POST['station'];
	$sta = $_POST['station'];
	$pf = $_POST['part_family'];
	$pn = $_POST['part_number'];
	$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station1' ");
	while ($rowctemp = mysqli_fetch_array($qurtemp)) {
		$station1 = $rowctemp["line_name"];
	}
}else{
    $curdate = date('Y-m-d');
    $dateto = $curdate;
    $yesdate = date('Y-m-d',strtotime("-1 days"));
    $datefrom = $yesdate;
//	$datefrom = $curdate;
//	$dateto = $curdate;
}
$wc = '';

if(isset($station)){
	$wc = $wc . " and sg_station_event.line_id = '$station'";
}
if(isset($pf)){
	$wc = $wc . " and sg_station_event.part_family_id = '$pf'";
}
if(isset($pn)){
	$wc = $wc . " and sg_station_event.part_number_id = '$pn'";
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

$sql = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where 1 " . $wc;
$response = array();
$posts = array();
$result = mysqli_query($db,$sql);
//$result = $mysqli->query($sql);
$data =array();
if( null != $result){
	while ($row=$result->fetch_assoc()){
		$posts[] = array('good_pieces'=> $row['good_pieces'], 'bad_pieces'=> $row['bad_pieces'], 'rework'=> $row['rework']);
	}
}

$response['posts'] = $posts;
//$fp = fopen('./results.json', 'w');
//fwrite($fp, json_encode($response));
//fclose($fp);
if(null == $sta){
	$sta = '';
}
$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);

//$sql1 = "SELECT bad_pieces,defect_name FROM `good_bad_pieces_details`";
$sql1 = "SELECT good_bad_pieces_details.defect_name,SUM(good_bad_pieces_details.rework) AS rework,SUM(good_bad_pieces_details.bad_pieces) AS bad_pieces FROM `good_bad_pieces_details` INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id WHERE defect_name IS NOT NULL " . $wc . " GROUP BY defect_name";
$response1 = array();
$posts1 = array();
$result1 = mysqli_query($db,$sql1);
//$result = $mysqli->query($sql);
$data =array();
if( null != $result1){
	while ($row=$result1->fetch_assoc()){
//	$posts1[] = array( 'bad_pieces'=> $row['bad_pieces'], 'rework'=> $row['rework'],'defect_name'=> $row['defect_name']);
		$posts1[] = array(  $row['defect_name'] , $row['bad_pieces'], $row['rework']);
	}
}

$response1['posts1'] = $posts1;
$fp = fopen('results1.json', 'w');
fwrite($fp, json_encode($response1));
fclose($fp);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Good Bad Pieces Log</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-data-adapter.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pareto.min.js"></script>
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
        }
    </style>
    <script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $scriptName; ?>log_module/good_bad_pieces_log.php");
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
$cust_cam_page_header = "Good Bad Pieces Log";
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
                        <form action="" id="good_bad_piece_form" class="form-horizontal" method="post">
                            <div class="row">

                                <div class="col-md-2">
                                    <label class="control-label"
                                           style="float: left;padding-top: 10px; font-weight: 500;">Station :</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="station" id="station" class="select"
                                            style="float: left;width: initial;">
                                        <option value="" selected disabled>--- Select Station ---</option>
										<?php
										$st_dashboard = $_POST['station'];
										$sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
										$result1 = $mysqli->query($sql1);
										//                                            $entry = 'selected';
										while ($row1 = $result1->fetch_assoc()) {
											if($st_dashboard == $row1['line_id'])
											{
												$entry = 'selected';
											}
											else
											{
												$entry = '';

											}
											echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
										}
										?>

                                    </select>
                                </div>
                                <!--                                <div class="col-md-1"></div>-->

                                <div class="col-md-2">
                                    <label class="control-label"
                                           style="float: left;padding-top: 10px; font-weight: 500;">Part Family *  :</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="part_family" id="part_family" class="select" data-style="bg-slate" >
                                        <option value="" selected disabled>--- Select Part Family ---</option>
										<?php
										$st_dashboard = $_POST['part_family'];
										$station = $_POST['station'];
										$ss = (isset($station)?' and station = ' . $station : '');
										$sql1 = "SELECT * FROM `pm_part_family` where is_deleted = 0" . $ss;
										$result1 = $mysqli->query($sql1);
										while ($row1 = $result1->fetch_assoc()) {
											if($st_dashboard == $row1['pm_part_family_id'])
											{
												$entry = 'selected';
											}
											else
											{
												$entry = '';

											}
											echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">


                                <div class="col-md-2">
                                    <label class="control-label"
                                           style="float: left;padding-top: 10px; font-weight: 500;">Part Number *  :</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="part_number" id="part_number" class="select" data-style="bg-slate" >
                                        <option value="" selected disabled>--- Select Part Number ---</option>
										<?php
										$st_dashboard = $_POST['part_number'];
										$part_family = $_POST['part_family'];
										$sql1 = "SELECT * FROM `pm_part_number` where part_family = '$part_family' and is_deleted = 0 ";
										$result1 = $mysqli->query($sql1);
										while ($row1 = $result1->fetch_assoc()) {
											if($st_dashboard == $row1['pm_part_number_id'])
											{
												$entry = 'selected';
											}
											else
											{
												$entry = '';

											}
											echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] ." - ".$row1['part_name'] . "</option>";
										}
										?>
                                    </select>
                                </div>

<!--                                <div class="col-md-2">-->
<!--                                    <label class="control-label"-->
<!--                                           style="float: left;padding-top: 10px; font-weight: 500;">Select Period  :</label>-->
<!--                                </div>-->
<!--                                <div class="col-md-4">-->
<!--									--><?php
//									if ($button == "button2") {
//										$checked = "checked";
//									} else {
//										$checked = "";
//									}
//									?>
<!--                                    <input type="radio" name="button" id="button2" value="button2" class="form-control"-->
<!--                                           style="float: left;width: initial;" --><?php //echo $checked; ?><!--
<!--                                    <label class="control-label"-->
<!--                                           style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>-->
<!--                                    <select name="period" id="period" class="form-control"-->
<!--                                            style="float: left;width: 60%;">-->
<!--                                        <option value="" selected disabled>--- Select Period ---</option>-->
<!--										--><?php
//										if ($timezone == "1") {
//											$selected = "selected";
//										} else {
//											$selected = "";
//										}
//										?>
<!--                                        <option value="1" --><?php //echo $selected; ?><!--One Day</option>-->
<!--										--><?php
//										if ($timezone == "7") {
//											$selected = "selected";
//										} else {
//											$selected = "";
//										}
//										?>
<!--                                        <option value="7" --><?php //echo $selected; ?><!--One Week</option>-->
<!--										--><?php
//										if ($timezone == "30") {
//											$selected = "selected";
//										} else {
//											$selected = "";
//										}
//										?>
<!--                                        <option value="30" --><?php //echo $selected; ?><!--One Month</option>-->
<!--										--><?php
//										if ($timezone == "90") {
//											$selected = "selected";
//										} else {
//											$selected = "";
//										}
//										?>
<!--                                        <option value="90" --><?php //echo $selected; ?><!--Three Month</option>-->
<!--										--><?php
//										if ($timezone == "180") {
//											$selected = "selected";
//										} else {
//											$selected = "";
//										}
//										?>
<!--                                        <option value="180" --><?php //echo $selected; ?><!--Six Month</option>-->
<!--										--><?php
//										if ($timezone == "365") {
//											$selected = "selected";
//										} else {
//											$selected = "";
//										}
//										?>
<!--                                        <option value="365" --><?php //echo $selected; ?><!--One Year</option>-->
<!--                                    </select>-->
<!--                                </div>-->
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label"
                                           style="float: left;padding-top: 10px; font-weight: 500;">Date Range  :</label>
                                </div>
                                <div class="col-md-10">
									<?php
									if ($button = "button1") {
										$checked = "checked";
									} else {
										$checked == "";
									}
									?>
                                    <input type="radio" name="button" id="button1" class="form-control" value="button1"
                                           style="float: left;width: initial;"<?php echo $checked; ?>>
                                    <label class="control-label"
                                           style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date
                                        From : &nbsp;&nbsp;</label>
                                    <input type="date" name="date_from" id="date_from" class="form-control"
                                           value="<?php echo $datefrom; ?>" style="float: left;width: initial;"
                                           required>
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
							if (!empty($_SESSION[import_status_message])) {
								echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
								$_SESSION['message_stauts_class'] = '';
								$_SESSION['import_status_message'] = '';
							}
							?>

                    <div class="panel-footer p_footer">
                        <div>
                            <button type="submit" class="btn btn-primary"
                                    style="width:120px;margin-right: 20px;background-color:#1e73be;">
                                Submit
                            </button>
                            <button type="button" class="btn btn-primary" onclick='window.location.reload();'
                                    style="background-color:#1e73be;margin-right: 20px;width:120px;">Reset
                            </button>
                            <!--                            <form action="export_station_events_log.php" method="post" name="export_excel">-->
                            <!--                                <button type="submit" class="btn btn-primary"-->
                            <!--                                        style="background-color:#1e73be;width:120px;"-->
                            <!--                                        id="export" name="export" data-loading-text="Loading...">Export Data-->
                            <!--                                </button>-->
                            <!--                            </form>-->
                        </div>
                    </div>
                    </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div id="gf_container" style="height: 500px; width: 100%;"></div>
                    </div>
                    <div class="col-md-8">
                        <div id="gf_container1" style="height: 500px; width: 100%;"></div>
                    </div>
                </div>


                <!-- /content area -->

            </div>
            <!-- /main content -->
            </br>

        </div>
        <!-- /page content -->

    <script>
        $('#station').on('change', function (e) {
            $("#good_bad_piece_form").submit();
        });
        $('#part_family').on('change', function (e) {
            $("#good_bad_piece_form").submit();
        });
        anychart.onDocumentReady(function () {
            var data = $("#good_bad_piece_form").serialize();
            $.ajax({
                type: 'POST',
                url: 'good_bad_piece_fa.php',
                // dataType: 'good_bad_piece_fa.php',
                data: data + "&fa_op=1",
                success: function(data1) {
                    var data = JSON.parse(data1);
                    // console.log(data);
                    var good_pieces = data.posts .map(function(elem){
                        return elem.good_pieces;
                    });
                    // console.log(goodpiece);
                    var bad_pieces = data.posts .map(function(elem){
                        return elem.bad_pieces;
                    });
                    var rework = data.posts .map(function(elem){
                        return elem.rework;
                    });
                    var data = [
                        {x: 'Good Pieces', value: good_pieces , fill : '#177b09'},
                        {x: 'Bad Pieces', value: bad_pieces ,  fill : '#BE0E31'},
                        {x: 'Rework', value: rework ,  fill : '#2643B9'},

                    ];
                    // create pareto chart with data
                    var chart = anychart.pareto(data);
                    // set chart title text settings
                    // chart.title('Good Pieces & Bad Pieces');
                    var title = chart.title();
                    title.enabled(true);
//enables HTML tags
                    title.useHtml(true);
                    title.text(
                        "<br><br>"+"Good Pieces & Bad Pieces"+
                        "<br><br><br>"
                    );

                    // set measure y axis title
                    chart.yAxis(0).title('Numbers');
                    // cumulative percentage y axis title
                    chart.yAxis(1).title(' Percentage');
                    // set interval
                    chart.yAxis(1).scale().ticks().interval(10);

                    // get pareto column series and set settings
                    var column = chart.getSeriesAt(0);

                    column.labels().enabled(true).format('{%Value}');
                    column.tooltip().format('Value: {%Value}');

                    // background border color
                    // column.labels().background().stroke("#663399");
                    column.labels().background().enabled(true).stroke("Green");

                    // get pareto line series and set settings
                    var line = chart.getSeriesAt(1);
                    line
                        .tooltip()
                        // .format('Good Pieces: {%CF}% \n Bad Pieces: {%RF}%');
                        .format('Percent : {%RF}%');

                    // turn on the crosshair and set settings
                    chart.crosshair().enabled(true).xLabel(false);
                    chart.xAxis().labels().rotation(-90);

                    // set container id for the chart
                    chart.container('gf_container');
                    // initiate chart drawing
                    chart.draw();
                }
            });
        });

    </script>
    <script>

        anychart.onDocumentReady(function () {
            var data = $("#good_bad_piece_form").serialize();
            $.ajax({
                type: 'POST',
                url: 'good_bad_piece_fa.php',
                // dataType: 'good_bad_piece_fa.php',
                data: data+ "&fa_op=0",
                success: function(data1) {
                    var data = JSON.parse(data1);
                    //var data = JSON.parse(this.responseText);
                    // console.log(data);
                    // create a data set
                    var data = anychart.data.set(data.posts1);

                    // map the data
                    var seriesData_1 = data.mapAs({x: 0, value: 1 });
                    // var seriesData_2 = data.mapAs({x: 0, value: 2 });

                    // create a chart
                    var chart = anychart.column();
                    // turn on X Scroller
                    chart.xScroller(true);
                    chart.xZoom().setToPointsCount(5, false);

                    // enable HTML for tooltips
                    chart.tooltip().useHtml(true);

// tooltip settings
                    var tooltip = chart.tooltip();
                    tooltip.positionMode("point");
                    tooltip.format("Defect Count: <b>{%value}</b>\nPercent: <b>{%RF}%</b>\n");


                    // create the first series, set the data and name
                    var series1 = chart.column(seriesData_1);
                    series1.name("Defect");

                    // configure the visual settings of the first series
                    series1.normal().fill("#BE0E31", 1);
                    series1.hovered().fill("#BE0E31", 0.8);
                    series1.selected().fill("#BE0E31", 0.5);
                    series1.normal().stroke("#BE0E31");
                    series1.hovered().stroke("#BE0E31", 2);
                    series1.selected().stroke("#BE0E31", 4);
                    series1.labels().enabled(true);
                    // background settings
                    var background = series1.labels().background();
                    background.enabled(true);
                    background.fill("#ffffff");
                    background.stroke("green");
                    background.cornerType("round");
                    background.corners(5);

                    //var chart = anychart.pareto(data);
                    // set the chart title
                    //chart.title("'Good Piece Bad Piece'");
                    // enable title
                    var title = chart.title();
                    title.enabled(true);
//enables HTML tags
                    title.useHtml(true);
                    title.text(
                        "<br><br>"+"Bad Piece(s) - Defects"+
                        "<br><br><br>"
                    );

                    // set the titles of the axes
                    chart.xAxis().title("Defect(s)");
                    chart.yAxis(0).title("Numbers");
                    // cumulative percentage y axis title
                    // chart.yAxis(1).title(' Percentage');
                    // set interval
                    // chart.yAxis(1).scale().ticks().interval(10);
                    // cumulative percentage y axis title
                    // chart.yAxis(1).title(' Percentage');
                    // set interval
                    // chart.yAxis(1).scale().ticks().interval(10);
                    chart.xGrid().enabled(true);
                    chart.yGrid().enabled(true);
                    chart.xAxis().labels().rotation(-90);
                    // set the container id
                    chart.container("gf_container1");

                    // initiate drawing the chart
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
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>
