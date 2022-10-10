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
        | Good & Bad Pieces</title>
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
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" rel="stylesheet" type="text/css">
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
$cam_page_header = "Good & Bad Pieces";
include("../header_folder.php");
if ($is_tab_login || ($_SESSION["role_id"] == "pn_user")) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}

?>
<?php
$form_create_id = $_GET['id'];

$query = "select fc.form_create_id,fc.name,fi.form_create_id,fc.station,fc.part_family,part_account.account_id,c_acc.c_name,c_acc.logo,pm_family.part_family_name,part_num.part_number,
part_num.part_name from form_create AS fc INNER Join form_item AS fi ON fc.form_create_id = fi.form_create_id 
INNER JOIN pm_part_family AS pm_family ON fc.part_family = pm_family.pm_part_family_id
INNER JOIN pm_part_number AS part_num ON pm_family.pm_part_family_id = part_num.part_family
INNER JOIN part_family_account_relation AS part_account ON fc.part_family = part_account.part_family_id
INNER JOIN cus_account AS c_acc ON part_account.account_id = c_acc.c_id WHERE fc.form_create_id = '$form_create_id'";

 $result = mysqli_query($db,$query);
 while ($row = mysqli_fetch_array($result)){
     $pm_part_family_name = $row['part_family_name'];
     $pm_part_number = $row['part_number'];
     $pm_part_name = $row['part_name'];
     $logo = $row['logo'];
     $cus_name = $row['c_name'];
     $form_name = $row['name'];
 }
?>
<!-- Content area -->
<div class="content">
    <div style="background-color: #fff;padding-bottom: 50px; margin-left:0px !important; margin-right: 0px !important;" class="row">
        <div class="col-lg-3 col-md-8"></div>
        <div class="col-lg-6 col-md-12">
            <div class="media" style="padding-top:50px;">
                <div class="media-left">
                    <img src="../supplier_logo/<?php if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?>" style=" height: 20vh;width:20vh;margin : 15px 25px 5px 5px;background-color: #ffffff;" class="img-circle" alt="">
                </div>

                <div class="media-body">
                    <input type="hidden" value="<?php echo $form_create_id; ?>" name="form_create" id="form_create">
                    <h5 style="font-size: xx-large;background-color: #009688; color: #ffffff;padding : 5px; text-align: center;" class="text-semibold no-margin"><?php if($cus_name != ""){ echo $cus_name; }else{ echo "Customer Name";} ?> </h5>
                    <small style="font-size: x-large;margin-top: 15px;" class="display-block"><b>Part Family :-</b> <?php echo $pm_part_family_name; ?></small>
                    <small style="font-size: x-large;" class="display-block"><b>Part Number :-</b> <?php echo $pm_part_number; ?></small>
                    <small style="font-size: x-large;" class="display-block"><b>Part Name :-</b> <?php echo $pm_part_name; ?></small>

                </div>
            </div>
            <!--							</div>-->
        </div>

    </div>
    <div class="panel panel-flat">
        <div class="row" style="background-color: #f3f3f3;margin: 0px">
            <div class="col-md-12" style="height: 10vh; padding-top: 3vh; font-size: x-large; text-align: center;">
                <span><?php echo $form_name; ?></span>
            </div>

        </div>
    </div>
    <!-- Basic datatable -->
    <div id="container"></div>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <script type="text/javascript">
        anychart.onDocumentReady(function () {

            // create data
            var data = [
                {x: "January", value: 10000},
                {x: "February", value: 12000},
                {x: "March", value: 18000},
                {x: "April", value: 11000},
                {x: "May", value: 9000}
            ];

            // create a chart
            var chart = anychart.line();

            // create a spline series and set the data
            var series = chart.spline(data);

            // set the chart title
            chart.title("Spline Chart");

            // set the titles of the axes
            var xAxis = chart.xAxis();
            xAxis.title("Month");
            var yAxis = chart.yAxis();
            yAxis.title("Sales, $");

            // set the container id
            chart.container("container");

            // initiate drawing the chart
            chart.draw();
        });

        function getData() {
            return [
                ['1986', 3.6, 2.3, 2.8, 11.5],
                ['1987', 7.1, 4.0, 4.1, 14.1],
                ['1988', 8.5, 6.2, 5.1, 17.5],
                ['1989', 9.2, 11.8, 6.5, 18.9],
                ['1990', 10.1, 13.0, 12.5, 20.8],
                ['1991', 11.6, 13.9, 18.0, 22.9],
                ['1992', 16.4, 18.0, 21.0, 25.2],
                ['1993', 18.0, 23.3, 20.3, 27.0],
                ['1994', 13.2, 24.7, 19.2, 26.5],
                ['1995', 12.0, 18.0, 14.4, 25.3],
                ['1996', 3.2, 15.1, 9.2, 23.4],
                ['1997', 4.1, 11.3, 5.9, 19.5],
                ['1998', 6.3, 14.2, 5.2, 17.8],
                ['1999', 9.4, 13.7, 4.7, 16.2],
                ['2000', 11.5, 9.9, 4.2, 15.4],
                ['2001', 13.5, 12.1, 1.2, 14.0],
                ['2002', 14.8, 13.5, 5.4, 12.5],
                ['2003', 16.6, 15.1, 6.3, 10.8],
                ['2004', 18.1, 17.9, 8.9, 8.9],
                ['2005', 17.0, 18.9, 10.1, 8.0],
                ['2006', 16.6, 20.3, 11.5, 6.2],
                ['2007', 14.1, 20.7, 12.2, 5.1],
                ['2008', 15.7, 21.6, 10, 3.7],
                ['2009', 12.0, 22.5, 8.9, 1.5]
            ];
        }
    </script>
</div>
<!-- /content area -->

<?php include('../footer.php') ?>
<!--<script type="text/javascript" src="../assets/js/core/app.js">-->
</body>
</html>
