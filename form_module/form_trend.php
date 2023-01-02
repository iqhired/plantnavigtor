<?php
include("../config.php");
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
$is_tab_login = $_SESSION['is_tab_user'];
$is_cell_login = $_SESSION['is_cell_login'];
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $sitename; ?> |SPC Analytics Trend Graph</title>
    <!-- Global stylesheets -->


    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">


    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <!--    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>

    <!--Internal  Datetimepicker-slider css -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/amazeui.datetimepicker.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/jquery.simple-dtpicker.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/picker.min.css" rel="stylesheet">
    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/form_css/bootstrap-datepicker.css">
    <!-- Internal Select2 css -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/select2.min.css" rel="stylesheet">
    <!-- STYLES CSS -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style-dark.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style-transparent.css" rel="stylesheet">
    <!---Internal Fancy uploader css-->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/fancy_fileupload.css" rel="stylesheet" />
    <!--Internal  Datepicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/datepicker.js"></script>
    <!-- Internal Select2.min js -->
    <!--Internal  jquery.maskedinput js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/jquery.maskedinput.js"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/spectrum.js"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/datetimepicker.min.js"></script>
    <!-- Ionicons js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/jquery.simple-dtpicker.js"></script>
    <!--Internal  pickerjs js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/picker.min.js"></script>
    <!--internal color picker js-->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/pickr.es5.min.js"></script>
    <script src="<?php echo $siteURL; ?>assets/js/form_js/colorpicker.js"></script>
    <!--Bootstrap-datepicker js-->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $siteURL; ?>assets/js/form_js/select2.min.js"></script>
    <!-- Internal form-elements js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/form-elements.js"></script>
    <link href="<?php echo $siteURL; ?>assets/js/form_js/demo.css" rel="stylesheet"/>
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
    <style>
        .navbar {

            padding-top: 0px!important;
        }
        .dropdown .arrow {

            margin-top: -25px!important;
            width: 1.5rem!important;
        }
        #ic .arrow {
            margin-top: -22px!important;
            width: 1.5rem!important;
        }
        .fs-6 {
            font-size: 1rem!important;
        }

        .content_img {
            width: 113px;
            float: left;
            margin-right: 5px;
            border: 1px solid gray;
            border-radius: 3px;
            padding: 5px;
            margin-top: 10px;
        }

        /* Delete */
        .content_img span {
            border: 2px solid red;
            display: inline-block;
            width: 99%;
            text-align: center;
            color: red;
        }
        .remove_btn{
            float: right;
        }
        .contextMenu{ position:absolute;  width:min-content; left: 204px; background:#e5e5e5; z-index:999;}
        .collapse.in {
            display: block!important;
        }
        .file-image-1 .icons li a {
            height: 30px;
            width: 30px;
        }
        .remove {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .remove:hover {
            background: white;
            color: black;
        }
        input[type="file"] {
            display: block;
        }
        .imageThumb {
            max-height: 100px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }

        button.remove {
            margin-left: 15px;
        }
        .row-body {
            display: flex;
            flex-wrap: wrap;
            margin-left: -8.75rem;
            margin-right: 6.25rem;
        }
        @media (min-width: 320px) and (max-width: 480px) {
            .row-body {

                margin-left: 0rem;
                margin-right: 0rem;
            }
        }

        @media (min-width: 481px) and (max-width: 768px) {
            .row-body {

                margin-left: -15rem;
                margin-right: 0rem;
            }
            .col-md-1 {
                flex: 0 0 8.33333%;
                max-width: 10.33333%!important;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .row-body {

                margin-left:-15rem;
                margin-right: 0rem;
            }

        }
        .red-star {
            color: red;
        }
        #sub_app {
            padding: 20px 40px;
            color: red;
            font-size: initial;
        }


    </style>
</head>
<!-- Main navbar -->
<?php include("../header.php");
if (($is_tab_login || $is_cell_login)) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}
?>
<body class="ltr main-body app sidebar-mini">
<div class="main-content app-content">
    <div class="row-body row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="breadcrumb-header justify-content-between">
                <div class="left-content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Logs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SPC Analytics Trend Graph</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form action="" id="line_graph" class="form-horizontal" method="post" autocomplete="off">
        <?php
        $form_iitem_id = $_GET['item_id'];
        $station = $_GET['station'];
        $form_type = $_GET['form_type'];
        $form_create_id = $_GET['id'];
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

        <div class="row-body row-sm">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card  box-shadow-0">
                    <div class="card-header">
                        <span class="main-content-title mg-b-0 mg-b-lg-1">SPC Analytics Item Information</span>
                    </div>
                    <div class="card-body pt-0">
                        <div class="pd-30 pd-sm-20">
                            <div class=" row row-xs align-items-center mg-b-20">
                                <div class="col-md-2">
                                    <div class="media-left">
                                        <img src="../supplier_logo/<?php if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?>" style=" height: 20vh;width:20vh;margin : 15px 25px 5px 5px;background-color: #ffffff;" class="img-circle" alt="">
                                    </div>
                                </div>
                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                    <input type="hidden" value="<?php echo $form_iitem_id; ?>" name="form_item_id" id="form_item_id">
                                    <input type="hidden" value="<?php echo $date_to; ?>" name="date_to" id="date_to">
                                    <input type="hidden" value="<?php echo $date_from; ?>" name="date_from" id="date_from">
                                    <input type="hidden" value="<?php echo $form_create_id; ?>" name="form_create" id="form_create">
                                    <h5 style="font-size: xx-large;background-color: #009688; color: #ffffff;padding : 5px; text-align: center;" class="text-semibold no-margin"><?php if($cus_name != ""){ echo $cus_name; }else{ echo "Customer Name";} ?> </h5>
                                    <?php
                                    $qur2 = mysqli_query($db, "SELECT * FROM form_type where form_type_id = '$form_type'");
                                    $row2 = mysqli_fetch_array($qur2);
                                    $form_type_name = $row2["form_type_name"];
                                    ?>
                                    <small style="font-size: x-large;" class="display-block"><b>Form Type :-</b> <?php echo $form_type_name; ?></small><br/>
                                    <?php
                                    $qur1 = mysqli_query($db, "SELECT * FROM cam_line where line_id = '$station' and enabled = 1");
                                    $row1 = mysqli_fetch_array($qur1);
                                    $line_name = $row1["line_name"];
                                    ?>
                                    <small style="font-size: x-large;" class="display-block"><b>Station :-</b> <?php echo $line_name; ?></small><br/>
                                    <small style="font-size: x-large;margin-top: 15px;" class="display-block"><b>Part Family :-</b> <?php echo $part_family_name; ?></small><br/>
                                    <small style="font-size: x-large;" class="display-block"><b>Part Number :-</b> <?php echo $part_number; ?></small><br/>
                                    <small style="font-size: x-large;" class="display-block"><b>Part Name :-</b> <?php echo $part_name; ?></small><br/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-body row-sm">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card  box-shadow-0">
                    <div class="card-header">
                        <span class="main-content-title mg-b-0 mg-b-lg-1">SPC Analytics Trend Graph</span>
                    </div>
                    <div class="card-body pt-0">
                        <div class="pd-30 pd-sm-20">
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-12 mg-t-5 mg-md-t-0">
                                    <div id="container" style="height: 500px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
                var upper_tol = data.posts.map(function (elem) {
                    return elem.upper_tol;
                });
                var lower_tol = data.posts.map(function (elem) {
                    return elem.lower_tol;
                });
                // Creates data.
                var dataSet = anychart.data.set([]);
                var dataSet1 = anychart.data.set([]);
                var dataSet2 = anychart.data.set([]);

                var mapping = dataSet.mapAs({x: 0, value: 1 , fill:2});
                var mapping1 = dataSet1.mapAs({x: 0, value: 1 , fill:2});
                var mapping2 = dataSet2.mapAs({x: 0, value: 1 , fill:2});


                for (var i = 0; i < item_value.length; i++) {
                    const i_val = item_value[i];
                    const myArray = i_val.split("~");
                    dataSet.append([myArray[0], myArray[1] , '#008000']);
                }
                for (var j = 0; j < upper_tol.length; j++) {
                    const up_tol = upper_tol[j];
                    const myArray = up_tol.split("~");
                    dataSet1.append([myArray[0], myArray[1] , '#FFA500']);
                }
                for (var k = 0; k < lower_tol.length; k++) {
                    const low_tol = lower_tol[k];
                    const myArray = low_tol.split("~");
                    dataSet2.append([myArray[0], myArray[1] , '#FFA500']);
                }
                // create pareto chart with data
                var chart = anychart.line();

                var series1 = chart.line(dataSet);
                series1.markers(true);
                // disable clipping series by data plot
                series1.clip(false);
                // place series under axis
                series1.zIndex(100);

                var series2 = chart.line(dataSet1);
                series2.markers(true);
                // disable clipping series by data plot
                series2.clip(false);
                // place series under axis
                series2.zIndex(100);

                var series3 = chart.line(dataSet2);
                series3.markers(true);
                // disable clipping series by data plot
                series3.clip(false);
                // place series under axis
                series3.zIndex(100);

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
<?php include ('../footer.php') ?>
</body>