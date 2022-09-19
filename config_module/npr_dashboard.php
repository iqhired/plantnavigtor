<?php include("../config.php");
$station = $_GET['id'];
$sql1 = "SELECT * FROM `cam_line` WHERE line_id = '$station'";
$result1 = mysqli_query($db, $sql1);
while ($cam1 = mysqli_fetch_array($result1)) {
    $station1 = $cam1['line_id'];
    $station2 = $cam1['line_name'];
}

$sqlmain = "SELECT * FROM `sg_station_event` where `line_id` = '$station1' and event_status = 1";
$resultmain = mysqli_query($db, $sqlmain);
if (!empty($resultmain)) {
    $rowcmain = mysqli_fetch_array($resultmain);
    if (!empty($rowcmain)) {
        $part_family = $rowcmain['part_family_id'];
        $part_number = $rowcmain['part_number_id'];
        $station_id = $rowcmain['station_event_id'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        body.alt-menu.sidebar-noneoverflow.pace-done {
            background-color: #ccc !important;
        }

        .anychart-credits {
            display: none !important;
        }

        .datatable-scroll {
            width: 100%;
            overflow-x: scroll;
        }
    </style>
    <style type="text/css">

        .line_head {
            font-size: 16px !important;
            margin: 30px !important;
        }

        @media screen and (min-width: 1440px) {
            .line_head {
                font-size: x-large !important;
                margin: 30px !important;
            }

        }

        @media screen and (min-width: 2560px) {
            .line_head {
                font-size: xx-large !important;
                margin: 30px !important;
            }

        }
        table, th, td {
            border:1px solid black;
        }
    </style>
</head>


<!-- Main navbar -->
<?php
$cam_page_header = "NPR Dashboard - " . $station2;
include("../hp_header.php");
?>

<body class="alt-menu sidebar-noneoverflow">
<div class="panel panel-flat">
    <table class="table datatable-basic">
        <thead>
        <tr>
            <th>Hours</th>
            <th>Goodpiece</th>
            <th>Badpiece</th>
            <th>Target NPR</th>
            <th>Actul NPR</th>
            <th>Effieciency</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $chicagotime = date("Y-m-d");
                $sqlpnum= "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
                $resultpnum = mysqli_query($db,$sqlpnum);
                $rowcpnum = $resultpnum->fetch_assoc();
                $pm_npr= $rowcpnum['npr'];
                $qur04 = mysqli_query($db, "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and date(update_date) = CURDATE() group by npr_h");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $h = 1;
                    //npr
                    $npr_h = $rowc04["npr_h"];
                    $npr_gr = $rowc04["npr_gr"];
                    $npr_b = $rowc04["npr_b"];
                    $target_npr = $pm_npr;
                    $actual_npr = round($npr_gr/$h,2);
                    //effieciency
                    $target_eff = round($pm_npr * $h);
                    $actual_eff = $npr_gr;
                    $eff = round(100 * ($actual_eff/$target_eff));
                ?>
                <td><?php echo $npr_h; ?></td>
                <td><?php echo $npr_gr; ?></td>
                <td><?php echo $npr_b; ?></td>
                <td><?php echo $target_npr; ?></td>
                <td><?php echo $actual_npr; ?></td>
                <td><?php echo $eff; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
