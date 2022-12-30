<?php include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
        header($redirect_tab_logout_path);
    }else{
        header($redirect_logout_path);
    }
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
    if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
        header($redirect_tab_logout_path);
    }else{
        header($redirect_logout_path);
    }

//	header('location: ../logout.php');
    exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;

$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../line_status_overview_dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title><?php echo $sitename; ?>
        | Analytics Graph Representation</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"> </script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"> </script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-data-adapter.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pareto.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-circular-gauge.min.js"></script>
    <link href="https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/8.11.0/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-cartesian.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
    <style> .sidebar-default .navigation li > a {
            color: #f5f5f5
        }

        ;
        a:hover {
            background-color: #20a9cc;
        }

        .sidebar-default .navigation li > a:focus, .sidebar-default .navigation li > a:hover {
            background-color: #20a9cc;
        }

        .content-wrapper {
            display: block !important;
            vertical-align: top;
            padding: 20px !important;
        }



        .bg-primary {
            background-color: #606060!important;
        }

        .red {
            color: red;
            display: none;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .modal-dialog {
                position: relative;
                width: auto;
                margin: 80px;
                margin-top: 200px;
            }
        }
        #container {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cam_page_header = "Analytics Graph Representation";
include("../header_folder.php");
if ($is_tab_login || ($_SESSION["role_id"] == "pn_user")) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}

?>
<?php
$form_create_id = $_GET['id'];
$form_item_id = $_GET['item_id'];
$date_from = $_GET['date_from'];
$date_to = $_GET['date_to'];

$query = "SELECT pm_part_family.part_family_name as part_family_name,pm_part_number.part_number as part_number,pm_part_number.part_name as part_name,cus_account.c_name as c_name,cus_account.logo as logo FROM `form_create` 
          INNER JOIN pm_part_family ON pm_part_family.pm_part_family_id = form_create.`part_family` 
          INNER JOIN pm_part_number ON pm_part_number.pm_part_number_id = form_create.part_number 
          INNER JOIN part_family_account_relation ON part_family_account_relation.part_family_id = form_create.part_family 
          INNER JOIN cus_account ON cus_account.c_id = part_family_account_relation.account_id 
          WHERE form_create.`form_create_id` = '$form_create_id'";

 $result = mysqli_query($db,$query);
 while ($row = mysqli_fetch_array($result)){
     $part_family_name = $row['part_family_name'];
     $part_number = $row['part_number'];
     $part_name = $row['part_name'];
     $logo = $row['logo'];
     $cus_name = $row['c_name'];
 }
?>
<!-- Content area -->
<div class="content">
    <form action="" id="line_graph" class="form-horizontal" enctype="multipart/form-data" method="post">
    <div style="background-color: #fff;padding-bottom: 50px; margin-left:0px !important; margin-right: 0px !important;" class="row">
        <div class="col-lg-3 col-md-8"></div>
        <div class="col-lg-6 col-md-12">
            <div class="media" style="padding-top:50px;">
                <div class="media-left">
                    <img src="../supplier_logo/<?php if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?>" style=" height: 20vh;width:20vh;margin : 15px 25px 5px 5px;background-color: #ffffff;" class="img-circle" alt="">
                </div>

                <div class="media-body">
                    <input type="hidden" value="<?php echo $date_to; ?>" name="date_to" id="date_to">
                    <input type="hidden" value="<?php echo $date_from; ?>" name="date_from" id="date_from">
                    <input type="hidden" value="<?php echo $form_item_id; ?>" name="form_item_id" id="form_item_id">
                    <input type="hidden" value="<?php echo $form_create_id; ?>" name="form_create" id="form_create">
                    <h5 style="font-size: xx-large;background-color: #009688; color: #ffffff;padding : 5px; text-align: center;" class="text-semibold no-margin"><?php if($cus_name != ""){ echo $cus_name; }else{ echo "Customer Name";} ?> </h5>
                    <small style="font-size: x-large;margin-top: 15px;" class="display-block"><b>Part Family :-</b> <?php echo $part_family_name; ?></small>
                    <small style="font-size: x-large;" class="display-block"><b>Part Number :-</b> <?php echo $part_number; ?></small>
                    <small style="font-size: x-large;" class="display-block"><b>Part Name :-</b> <?php echo $part_name; ?></small>

                </div>
            </div>
            <!--							</div>-->
        </div>

    </div>
    </form>
    <div class="panel panel-flat">
        <div class="row" style="background-color: #f3f3f3;margin: 0px">
            <div class="col-md-12" style="height: 10vh; padding-top: 3vh; font-size: x-large; text-align: center;">
                <span><?php echo $form_name; ?></span>
            </div>

        </div>
    </div>
    <!-- Basic datatable -->
    <div class="row">
        <div class="col-md-12">
            <div id="container" style="height: 500px; width: 100%;"></div>
        </div>
    </div>

</div>
<script>
    anychart.onDocumentReady(function () {
        var data = $("#line_graph").serialize();
        $.ajax({
            type: 'POST',
            url: 'form_line_graph.php',
            // dataType: 'good_bad_piece_fa.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var item_value = data.posts.map(function (elem) {
                    return elem.item_value;
                });
                // Creates data.
                var dataSet = anychart.data.set([]);

                var mapping = dataSet.mapAs({x: 0, value: 1 , fill:2});


                for (var i = 0; i < item_value.length; i++) {
                    const i_val = item_value[i];
                    const myArray = i_val.split("~");
                    dataSet.append([myArray[0], myArray[1] , '#177b09']);
                }
                // create pareto chart with data
                var chart = anychart.line(dataSet);

                // chart.xGrid().enabled(true);
                chart.yGrid().enabled(true);
                chart.xAxis().labels().rotation(-90);
                // set chart padding
                chart.padding([10, 20, 5, 20]);

                // turn on chart animation
                chart.animation(true);
                // var xLabels = chart.xAxis().labels();
                // xLabels.width(150);
                // xLabels.wordWrap("break-word");
                // xLabels.wordBreak("break-all");

                // turn on X Scroller
                chart.xScroller(true);
                chart.xZoom().setToPointsCount(5, false);
                chart.labels().fontSize(14);
                // enable HTML for tooltips
                chart.tooltip().useHtml(true);

                // set chart title text settings
                // chart.title('Good Pieces & Bad Pieces');
                var title = chart.title();
                title.enabled(true);
//enables HTML tags
                title.useHtml(true);
                title.text(
                    "<br><br>"
                );

                // get pareto column series and set settings
                var column = chart.getSeriesAt(0);

                column.labels().enabled(true).format('{%Value}');
                column.tooltip().format('Value: {%Value}');

                var labels = column.labels();
                labels.fontFamily("Courier");
                labels.fontSize(14);
                labels.fontColor("#125393");
                labels.fontWeight("bold");
                labels.useHtml(true);
                // // background border color

                var labels = chart.xAxis().labels();
                labels.fontFamily("Courier");
                labels.fontSize(14);
                labels.fontColor("#125393");
                labels.fontWeight("bold");
                labels.useHtml(true);
                // // background border color
                // column.labels().background().stroke("#663399");
                // column.labels().background().enabled(true).stroke("Green");

                // var xLabelsBackground = chart.xAxis().labels().background();
                // xLabelsBackground.enabled(true);
                // xLabelsBackground.stroke("#cecece");
                // xLabelsBackground.cornerType("round");
                // xLabelsBackground.corners(5);

                // set container id for the chart
                chart.container('container');
                // initiate chart drawing
                chart.draw();
            }
        });
    });
</script>
<?php include('../footer.php') ?>
<!--<script type="text/javascript" src="../assets/js/core/app.js">-->
</body>
</html>
