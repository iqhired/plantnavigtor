<?php include("../config.php");
$station = $_GET['id'];
$sql1 = "SELECT * FROM `cam_line` WHERE gbd_id = '1' and line_id = '$station'";
$result1 = mysqli_query($db,$sql1);
while ($cam1 = mysqli_fetch_array($result1)){
    $station1 = $cam1['line_id'];
	$station2 = $cam1['line_name'];
}

$sqlmain = "SELECT * FROM `sg_station_event` where `line_id` = '$station1' and event_status = 1";
$resultmain = mysqli_query($db,$sqlmain);
if(!empty($resultmain)){
	$rowcmain = $resultmain->fetch_assoc();
	if(empty($rowcmain)){
		$part_family = $rowcmain['part_family_id'];
		$part_number = $rowcmain['part_number_id'];
		$station_id = $rowcmain['station_event_id'];
    }

    if(!empty($part_family)){
		$sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
		$resultfamily = mysqli_query($db,$sqlfamily);
		$rowcfamily = $resultfamily->fetch_assoc();
		$pm_part_family_name = $rowcfamily['part_family_name'];

		$sqlaccount = "SELECT * FROM `part_family_account_relation` where `part_family_id` = '$part_family'";
		$resultaccount = mysqli_query($db,$sqlaccount);
		$rowcaccount = $resultaccount->fetch_assoc();
		$account_id = $rowcaccount['account_id'];

		if(!empty($account_id)){
			$sqlcus = "SELECT * FROM `cus_account` where `c_id` = '$account_id'";
			$resultcus = mysqli_query($db,$sqlcus);
			$rowccus = $resultcus->fetch_assoc();
			$cus_name = $rowccus['c_name'];
			$logo = $rowccus['logo'];
        }
    }

}

$sql = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where sg_station_event.line_id = '$station1' and sg_station_event.event_status = 1" ;
$response = array();
$posts = array();
$result = mysqli_query($db,$sql);
//$result = $mysqli->query($sql);
$data =array();

while ($row=$result->fetch_assoc()){
    $posts[] = array('good_pieces'=> $row['good_pieces'], 'bad_pieces'=> $row['bad_pieces'], 'rework'=> $row['rework']);

}
$response['posts'] = $posts;
$filename = 'results_'.$station1.'.json';
$fp = fopen("./$filename", 'w');
fwrite($fp, json_encode($response));
fclose($fp);



//
////$sql1 = "SELECT bad_pieces,defect_name FROM `good_bad_pieces_details`";
//$sql1 = "SELECT good_bad_pieces_details.defect_name,SUM(good_bad_pieces_details.rework) AS rework,SUM(good_bad_pieces_details.bad_pieces) AS bad_pieces FROM `good_bad_pieces_details` INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id WHERE good_bad_pieces_details.station_event_id = sg_station_event.station_event_id and sg_station_event.line_id  = '$station1'  and sg_station_event.event_status = 1 and good_bad_pieces_details.defect_name IS NOT NULL group  by good_bad_pieces_details.defect_name";
//$response1 = array();
//$posts1 = array();
//$result1 = mysqli_query($db,$sql1);
////$result = $mysqli->query($sql);
//$data =array();
//
//while ($row=$result1->fetch_assoc()){
////	$posts1[] = array( 'bad_pieces'=> $row['bad_pieces'], 'rework'=> $row['rework'],'defect_name'=> $row['defect_name']);
//    $posts1[] = array(  $row['defect_name'] , $row['bad_pieces'], $row['rework']);
//}
//$response1['posts1'] = $posts1;
//$filename = 'results1_'.$station1.'.json';
//$fp = fopen("./$filename", 'w');
//fwrite($fp, json_encode($response1));
//fclose($fp);

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
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
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
        body.alt-menu.sidebar-noneoverflow.pace-done {
            background-color: #ccc!important;
        }
        .anychart-credits{
            display: none !important;
        }
        .datatable-scroll {
            width: 100%;
            overflow-x: scroll;
        }
    </style>
    <style type="text/css">

        .line_head{
            font-size: 16px !important;
            margin: 30px !important;
        }

        @media screen and (min-width:1440px)  {
            .line_head{
                font-size: x-large !important;
                margin: 30px !important;
            }

        }
        @media screen and (min-width:2560px)  {
            .line_head{
                font-size: xx-large !important;
                margin: 30px !important;
            }

        }



    </style>



</head>


<!-- Main navbar -->
<?php
$cam_page_header = "Good Bad Pieces Dashboard - " . $station2;
include("../hp_header.php");
?>

<body class="alt-menu sidebar-noneoverflow">

<div class="row col-md-12" style="margin: 50px;width: 95%;">
    <div id="sgf_container" style="height: 800px; width: 100%;"></div>
</div>
            <!-- /main content -->
            <script>

                anychart.onDocumentReady(function () {
                    var data = this.window.location.href.split('?')[1];
                    $.ajax({
                        type: 'POST',
                        url: 'good_bad_piece_fac.php',
                        // dataType: 'good_bad_piece_fa.php',
                        data: data ,
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
                            var chart = anychart.column(data);
                            // set chart title text settings
                            // chart.title('Good Pieces & Bad Pieces');
                            var title = chart.title();
                            title.enabled(true);
//enables HTML tags
                            title.useHtml(true);
                            title.text(
                                "<br><br><br>"
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
                            labels.fontSize(50);
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
                            labels.fontSize(24);
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
                            chart.container('sgf_container');
                            // initiate chart drawing
                            chart.draw();
                        }
                    });
                });

                // anychart.onDocumentReady(function () {
                //     anychart.data.loadJsonFile("./results_"+this.document.location.search.split('=')[1]+".json", function (data) {
                //
                //         var xmlhttp = new XMLHttpRequest();
                //         var url = "./results_"+this.document.location.search.split('=')[1]+".json";
                //         xmlhttp.open("GET",url,true);
                //         xmlhttp.send();
                //         xmlhttp.onreadystatechange = function() {
                //             if (this.readyState == 4 && this.status == 200) {
                //                 var data = JSON.parse(this.responseText);
                //                 // console.log(data);
                //                 var good_pieces = data.posts .map(function(elem){
                //                     return elem.good_pieces;
                //                 });
                //                 // console.log(goodpiece);
                //                 var bad_pieces = data.posts .map(function(elem){
                //                     return elem.bad_pieces;
                //                 });
                //                 var rework = data.posts .map(function(elem){
                //                     return elem.rework;
                //                 });
                //                 var data = [
                //                     {x: 'Good Pieces', value: good_pieces , fill : '#177b09'},
                //                     {x: 'Bad Pieces', value: bad_pieces ,  fill : '#BE0E31'},
                //                     {x: 'Rework', value: rework ,  fill : '#2643B9'},
                //
                //                 ];
                //                 // create pareto chart with data
                //                 var chart = anychart.pareto(data);
                //                 // set chart title text settings
                //                 chart.title('Good Pieces & Bad Pieces is Required');
                //                 // set measure y axis title
                //                 chart.yAxis(0).title('Stations');
                //                 // cumulative percentage y axis title
                //                 chart.yAxis(1).title(' Numbers');
                //                 // set interval
                //                 chart.yAxis(1).scale().ticks().interval(10);
                //
                //                 // get pareto column series and set settings
                //                 var column = chart.getSeriesAt(0);
                //                 // column.fill(function () {
                //                 //     if (this.rf < 10) {
                //                 //         return '#E24B26';
                //                 //     }
                //                 //     return this.sourceColor;
                //                 // });
                //                 // column.stroke(function () {
                //                 //     if (this.rf < 10) {
                //                 //         return '#60727B';
                //                 //     }
                //                 //     return this.sourceColor;
                //                 // });
                //                 column.labels().enabled(true).format('{%RF}');
                //                 column.tooltip().format('Value: {%Value}');
                //
                //                 // get pareto line series and set settings
                //                 var line = chart.getSeriesAt(1);
                //                 line
                //                     .tooltip()
                //                     .format('Good Pieces: {%CF} \n Bad Pieces: {%RF}');
                //
                //
                //                 // turn on the crosshair and set settings
                //                 chart.crosshair().enabled(true).xLabel(false);
                //                 chart.xAxis().labels().rotation(-45);
                //
                //                 // set container id for the chart
                //                 chart.container('container');
                //                 // initiate chart drawing
                //                 chart.draw();
                //
                //
                //             }
                //         }
                //
                //     });
                // });

            </script>

<?php include('../footer.php') ?>
            <script type="text/javascript" src="../assets/js/app.js"></script>
</body>
</html>
