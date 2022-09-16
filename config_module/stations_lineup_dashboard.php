<?php include("../config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title><?php echo $sitename; ?> | NPR Log</title>
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
    <link href="https://cdn.anychart.com/releases/8.11.0/fonts/css/anychart-font.min.css" type="text/css"
          rel="stylesheet">
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
        body{
             background-color: #000000;
             width: 100%;
         }
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Style the header */
        header {
            background-color: #666;
            padding: 30px;
            text-align: center;
            font-size: 35px;
            color: white;
        }

        /* Create two columns/boxes that floats next to each other */
        nav {
            float: left;
            width: 30%;
            height: 300px; /* only for demonstration, should be removed */
            background: #ccc;
            padding: 20px;
        }

        /* Style the list inside the menu */
        nav ul {
            list-style-type: none;
            padding: 0;
        }

        article {
            float: left;
            padding: 20px;
            width: 70%;
            background-color: #f1f1f1;
            height: 300px; /* only for demonstration, should be removed */
        }

        /* Clear floats after the columns */
        section::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Style the footer */
        footer {
            background-color: #777;
            padding: 10px;
            text-align: center;
            color: white;
        }

        /* Responsive layout - makes the two columns/boxes stack on top of each other instead of next to each other, on small screens */
        @media (max-width: 600px) {
            nav, article {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<!-- Main navbar -->
<?php
$cam_page_header = "";
include("../hp_header.php");
?>
<br/>
<body class="alt-menu.sidebar-noneoverflow.pace-done">
<form action="" id="form1" method="post">
    <div class="panel panel-flat">
        <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Station</th>
                <th>LineUp</th>
                <th>Date</th>
                <th>TotalTime</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                $qur11 = mysqli_query($db, "SELECT sg_station_event.station_event_id,sg_station_event.line_id,cam_line.line_name as line_name,sg_station_event.event_status,sg_station_event.created_on as created_on,sg_station_event_log.total_time as total_time FROM ((sg_station_event INNER JOIN cam_line ON sg_station_event.line_id = cam_line.line_id)INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id) WHERE sg_station_event.event_status = '1' and YEARWEEK(sg_station_event.created_on) = YEARWEEK(CURDATE())");
                while ($row11 = mysqli_fetch_array($qur11)) {
                $station_event_id = $row11["station_event_id"];
                $line_name = $row11["line_name"];
                $total_time = $row11["total_time"];
                $created_on = $row11["created_on"];
                $lineup = 'Yes';

                ?>
                <td><?php echo $line_name; ?></td>
                <td><?php echo $lineup; ?></td>
                <td><?php echo $created_on; ?></td>
                <td><?php echo $total_time; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
       <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Station</th>
                <th>LineUp</th>
                <th>Date</th>
                <th>TotalTime</th>
            </tr>
            </thead>
            <tbody>
            <tr>

                <?php
                $qur21 = mysqli_query($db, "SELECT sg_station_event.station_event_id,sg_station_event.line_id,cam_line.line_name as line_name,sg_station_event.event_status,sg_station_event.created_on as created_on,sg_station_event_log.total_time as total_time FROM ((sg_station_event INNER JOIN cam_line ON sg_station_event.line_id = cam_line.line_id)INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id) WHERE sg_station_event.event_status = '1' and YEARWEEK(sg_station_event.created_on) = YEARWEEK(CURDATE())");
                while ($row21 = mysqli_fetch_array($qur21)) {
                $station_event_id1 = $row21["station_event_id"];
                $line_name1 = $row21["line_name"];
                $total_time1 = $row21["total_time"];
                $created_on1 = $row21["created_on"];
                $lineup1 = 'Yes';

                ?>
                <td><?php echo $line_name1; ?></td>
                <td><?php echo $lineup1; ?></td>
                <td><?php echo $created_on1; ?></td>
                <td><?php echo $total_time1; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Station</th>
                <th>LineUp</th>
                <th>Date</th>
                <th>TotalTime</th>
            </tr>
            </thead>
            <tbody>
            <tr>

                <?php
                $qur31 = mysqli_query($db, "SELECT sg_station_event.station_event_id,sg_station_event.line_id,cam_line.line_name as line_name,sg_station_event.event_status,sg_station_event.created_on as created_on,sg_station_event_log.total_time as total_time FROM ((sg_station_event INNER JOIN cam_line ON sg_station_event.line_id = cam_line.line_id)INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id) WHERE sg_station_event.event_status = '1' and Month(sg_station_event.created_on) = Month(CURDATE())");
                while ($row31 = mysqli_fetch_array($qur31)) {
                $station_event_id2 = $row31["station_event_id"];
                $line_name2 = $row31["line_name"];
                $total_time2 = $row31["total_time"];
                $created_on2 = $row31["created_on"];
                $lineup2 = 'Yes';

                ?>
                <td><?php echo $line_name2; ?></td>
                <td><?php echo $lineup2; ?></td>
                <td><?php echo $created_on2; ?></td>
                <td><?php echo $total_time2; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Station</th>
                <th>LineUp</th>
                <th>Date</th>
                <th>TotalTime</th>
            </tr>
            </thead>
            <tbody>
            <tr>

                <?php
                $qur41 = mysqli_query($db, "SELECT sg_station_event.station_event_id,sg_station_event.line_id,cam_line.line_name as line_name,sg_station_event.event_status,sg_station_event.created_on as created_on,sg_station_event_log.total_time as total_time FROM ((sg_station_event INNER JOIN cam_line ON sg_station_event.line_id = cam_line.line_id)INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id) WHERE sg_station_event.event_status = '1' and Year(sg_station_event.created_on) = Year(CURDATE())");
                while ($row41 = mysqli_fetch_array($qur41)) {
                $station_event_id3 = $row41["station_event_id"];
                $line_name3 = $row41["line_name"];
                $total_time3 = $row41["total_time"];
                $created_on3 = $row41["created_on"];
                $lineup3 = 'Yes';

                ?>
                <td><?php echo $line_name3; ?></td>
                <td><?php echo $lineup3; ?></td>
                <td><?php echo $created_on3; ?></td>
                <td><?php echo $total_time3; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</form>
<form action="" id="form1" method="post">

</form>
<form action="" id="form1" method="post">
    <div class="panel panel-flat">

    </div>
</form>
<form action="" id="form1" method="post">
    <div class="panel panel-flat">

    </div>
</form>
</body>
</html>
