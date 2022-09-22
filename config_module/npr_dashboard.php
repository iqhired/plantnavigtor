<?php include("../config.php");
$chicagotime = date("Y-m-d");
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    <!--<script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>

    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>-->
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <style>
        div.panel panel-flat{
            padding-top: 2px;
        }
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
        table {
            border-collapse: separate;
            width: 100%;
        }

        thead {
            border-collapse: separate;
            position: sticky;
            top: 0px;
            background-color: white;
        }


        /* for styling only */

        td {
            top: 0px;
            border: 1px solid black;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
            padding: 0.5px!important;
        }
    </style>
</head>


<!-- Main navbar -->
<?php
$cam_page_header = "NPR Dashboard - " . $station2;
include("../hp_header1.php");
?>

<body class="alt-menu sidebar-noneoverflow">
<div class="panel panel-flat">
    <div class="table-responsive-sm">
    <table class="table table-sm">
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
                $pm_npr= 30;
                $qur04 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '00' and date(`update_date`) = CURDATE() group by npr_h";
                $result333 = mysqli_query($db,$qur04);
                $rowc04 = $result333->fetch_assoc();
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
                    if($npr_h == '00'){
                ?>
                <td><?php echo '00-01AM'; ?></td>
                <td><?php echo $npr_gr; ?></td>
                <td><?php echo $npr_b; ?></td>
                <td><?php echo $target_npr; ?></td>
                <td><?php echo $actual_npr; ?></td>
                <td><?php echo $eff; ?></td>
                <?php }else{ ?>
                    <td><?php echo '00-01AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr2= 30;
                $qur042 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '01' and date(`update_date`) = CURDATE() group by npr_h";
                $result332 = mysqli_query($db,$qur042);
                $rowc042 = $result332->fetch_assoc();
                $h2 = 1;
                //npr
                $npr_h2 = $rowc042["npr_h"];
                $npr_gr2 = $rowc042["npr_gr"];
                $npr_b2 = $rowc042["npr_b"];
                $target_npr2 = $pm_npr2;
                $actual_npr2 = round($npr_gr2/$h2,2);
                //effieciency
                $target_eff2 = round($pm_npr2 * $h2);
                $actual_eff2 = $npr_gr2;
                $eff2 = round(100 * ($actual_eff2/$target_eff2));
                if($npr_h2 == '01'){
                ?>
                <td><?php echo '01-02AM'; ?></td>
                    <td><?php echo $npr_gr2; ?></td>
                    <td><?php echo $npr_b2; ?></td>
                    <td><?php echo $target_npr2; ?></td>
                    <td><?php echo $actual_npr2; ?></td>
                    <td><?php echo $eff2; ?></td>
                <?php }else{ ?>
                    <td><?php echo '01-02AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr2; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php }?>
            </tr>
           <tr>
                <?php
                $pm_npr311= 30;
                $qur043 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '02' and date(`update_date`) = CURDATE() group by npr_h";
                $result33 = mysqli_query($db,$qur043);
                $rowc043 = $result33->fetch_assoc();
                $h3 = 1;
                    //npr
                    $npr_h3 = $rowc043["npr_h"];
                    $npr_gr33 = $rowc043["npr_gr"];
                    $npr_b33 = $rowc043["npr_b"];
                    $target_npr33 = $pm_npr311;
                    $actual_npr33 = round($npr_gr33/$h3,2);
                    //effieciency
                    $target_eff33 = round($pm_npr311 * $h3);
                    $actual_eff33 = $npr_gr33;
                    $eff3 = round(100 * ($actual_eff33/$target_eff33));
                    if($npr_h3 == '02'){
                    ?>
                    <td><?php echo '02-03AM'; ?></td>
                    <td><?php echo $npr_gr33; ?></td>
                    <td><?php echo $npr_b33; ?></td>
                    <td><?php echo $target_npr33; ?></td>
                    <td><?php echo $actual_npr33; ?></td>
                    <td><?php echo $eff3; ?></td>
                <?php }else{ ?>
                    <td><?php echo '02-03AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr33; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
               <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr4= 30;
                $qur31 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '03' and date(`update_date`) = CURDATE() group by npr_h";
                $result34 = mysqli_query($db,$qur31);
                $rowc044 = $result34->fetch_assoc();
                    $h4 = 1;
                    //npr
                    $npr_h4 = $rowc044["npr_h"];
                    $npr_gr4 = $rowc044["npr_gr"];
                    $npr_b4 = $rowc044["npr_b"];
                    $target_npr4 = $pm_npr4;
                    $actual_npr4 = round($npr_gr4/$h4,2);
                    //effieciency
                    $target_eff4 = round($pm_npr4 * $h4);
                    $actual_eff4 = $npr_gr4;
                    $eff4 = round(100 * ($actual_eff4/$target_eff4));
                   if($npr_h3 == '03'){
                    ?>
                    <td><?php echo '03-04AM'; ?></td>
                    <td><?php echo $npr_gr4; ?></td>
                    <td><?php echo $npr_b4; ?></td>
                    <td><?php echo $target_npr4; ?></td>
                    <td><?php echo $actual_npr4; ?></td>
                    <td><?php echo $eff4; ?></td>
                   <?php }else{ ?>
                       <td><?php echo '03-04AM'; ?></td>
                       <td><?php echo '0'; ?></td>
                       <td><?php echo '0'; ?></td>
                       <td><?php echo $target_npr4; ?></td>
                       <td><?php echo '0'; ?></td>
                       <td><?php echo '0'; ?></td>
                   <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr55= 30;
                $qur55 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '04' and date(`update_date`) = CURDATE() group by npr_h";
                $result55 = mysqli_query($db,$qur55);
                $row55 = $result55->fetch_assoc();
                $h55 = 1;
                //npr
                $npr_h55 = $row55["npr_h"];
                $npr_gr55 = $row55["npr_gr"];
                $npr_b55 = $row55["npr_b"];
                $target_npr55 = $pm_npr55;
                $actual_npr55 = round($npr_gr55/$h55,2);
                //effieciency
                $target_eff55 = round($pm_npr55 * $h55);
                $actual_eff55 = $npr_gr55;
                $eff55 = round(100 * ($actual_eff55/$target_eff55));
                if($npr_h55 == '04'){
                    ?>
                    <td><?php echo '04-05AM'; ?></td>
                    <td><?php echo $npr_gr55; ?></td>
                    <td><?php echo $npr_b55; ?></td>
                    <td><?php echo $target_npr55; ?></td>
                    <td><?php echo $actual_npr55; ?></td>
                    <td><?php echo $eff55; ?></td>
                <?php }else{ ?>
                    <td><?php echo '04-05AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr55; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr2= 30;
                $qur21 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '05' and date(`update_date`) = CURDATE() group by npr_h";
                $result211 = mysqli_query($db,$qur21);
                $row211 = $result211->fetch_assoc();
                $h2 = 1;
                //npr
                $npr_h2 = $row211["npr_h"];
                $npr_gr2 = $row211["npr_gr"];
                $npr_b2 = $row211["npr_b"];
                $target_npr2 = $pm_npr2;
                $actual_npr2 = round($npr_gr2/$h2,2);
                //effieciency
                $target_eff2 = round($pm_npr2 * $h2);
                $actual_eff2 = $npr_gr2;
                $eff2 = round(100 * ($actual_eff2/$target_eff2));
                if($npr_h2 == '05'){
                    ?>
                    <td><?php echo '05-06AM'; ?></td>
                    <td><?php echo $npr_gr2; ?></td>
                    <td><?php echo $npr_b2; ?></td>
                    <td><?php echo $target_npr2; ?></td>
                    <td><?php echo $actual_npr2; ?></td>
                    <td><?php echo $eff2; ?></td>
                <?php }else{ ?>
                    <td><?php echo '05-06AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr2; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr3= 30;
                $qur31 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '06' and date(`update_date`) = CURDATE() group by npr_h";
                $result311 = mysqli_query($db,$qur31);
                $row311 = $result311->fetch_assoc();
                $h3 = 1;
                //npr
                $npr_h3 = $row311["npr_h"];
                $npr_gr3 = $row311["npr_gr"];
                $npr_b3 = $row311["npr_b"];
                $target_npr3 = $pm_npr3;
                $actual_npr3 = round($npr_gr3/$h3,2);
                //effieciency
                $target_eff3 = round($pm_npr3 * $h3);
                $actual_eff3 = $npr_gr3;
                $eff3 = round(100 * ($actual_eff3/$target_eff3));
                if($npr_h3 == '06'){
                    ?>
                    <td><?php echo '06-07AM'; ?></td>
                    <td><?php echo $npr_gr3; ?></td>
                    <td><?php echo $npr_b3; ?></td>
                    <td><?php echo $target_npr3; ?></td>
                    <td><?php echo $actual_npr3; ?></td>
                    <td><?php echo $eff3; ?></td>
                <?php }else{ ?>
                    <td><?php echo '06-07AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr3; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr41= 30;
                $qur41 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '07' and date(`update_date`) = CURDATE() group by npr_h";
                $result411 = mysqli_query($db,$qur41);
                $row411 = $result411->fetch_assoc();
                $h41 = 1;
                //npr
                $npr_h41 = $row411["npr_h"];
                $npr_gr41 = $row411["npr_gr"];
                $npr_b41 = $row411["npr_b"];
                $target_npr41 = $pm_npr41;
                $actual_npr41 = round($npr_gr41/$h41,2);
                //effieciency
                $target_eff41 = round($pm_npr41 * $h41);
                $actual_eff41 = $npr_gr41;
                $eff41 = round(100 * ($actual_eff41/$target_eff41));
                if($npr_h41 == '07'){
                    ?>
                    <td><?php echo '07-08AM'; ?></td>
                    <td><?php echo $npr_gr41; ?></td>
                    <td><?php echo $npr_b41; ?></td>
                    <td><?php echo $target_npr41; ?></td>
                    <td><?php echo $actual_npr41; ?></td>
                    <td><?php echo $eff41; ?></td>
                <?php }else{ ?>
                    <td><?php echo '07-08AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr41; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr51= 30;
                $qur51 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '08' and date(`update_date`) = CURDATE() group by npr_h";
                $result511 = mysqli_query($db,$qur51);
                $row511 = $result511->fetch_assoc();
                $h51 = 1;
                //npr
                $npr_h51 = $row511["npr_h"];
                $npr_gr51 = $row511["npr_gr"];
                $npr_b51 = $row511["npr_b"];
                $target_npr51 = $pm_npr51;
                $actual_npr51 = round($npr_gr51/$h51,2);
                //effieciency
                $target_eff51 = round($pm_npr51 * $h51);
                $actual_eff51 = $npr_gr51;
                $eff51 = round(100 * ($actual_eff51/$target_eff51));
                if($npr_h51 == '08'){
                    ?>
                    <td><?php echo '08-09AM'; ?></td>
                    <td><?php echo $npr_gr51; ?></td>
                    <td><?php echo $npr_b51; ?></td>
                    <td><?php echo $target_npr51; ?></td>
                    <td><?php echo $actual_npr51; ?></td>
                    <td><?php echo $eff51; ?></td>
                <?php }else{ ?>
                    <td><?php echo '08-09AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr41; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr61= 30;
                $qur61 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '09' and date(`update_date`) = CURDATE() group by npr_h";
                $result611 = mysqli_query($db,$qur61);
                $row611 = $result611->fetch_assoc();
                $h61 = 1;
                //npr
                $npr_h61 = $row611["npr_h"];
                $npr_gr61 = $row611["npr_gr"];
                $npr_b61 = $row611["npr_b"];
                $target_npr61 = $pm_npr61;
                $actual_npr61 = round($npr_gr61/$h61,2);
                //effieciency
                $target_eff61 = round($pm_npr61 * $h61);
                $actual_eff61 = $npr_gr61;
                $eff61 = round(100 * ($actual_eff61/$target_eff61));
                if($npr_h61 == '09'){
                    ?>
                    <td><?php echo '09-10AM'; ?></td>
                    <td><?php echo $npr_gr61; ?></td>
                    <td><?php echo $npr_b61; ?></td>
                    <td><?php echo $target_npr61; ?></td>
                    <td><?php echo $actual_npr61; ?></td>
                    <td><?php echo $eff61; ?></td>
                <?php }else{ ?>
                    <td><?php echo '09-10AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr61; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr71= 30;
                $qur71 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '10' and date(`update_date`) = CURDATE() group by npr_h";
                $result711 = mysqli_query($db,$qur71);
                $row711 = $result711->fetch_assoc();
                $h71 = 1;
                //npr
                $npr_h71 = $row711["npr_h"];
                $npr_gr71 = $row711["npr_gr"];
                $npr_b71 = $row711["npr_b"];
                $target_npr71 = $pm_npr71;
                $actual_npr71 = round($npr_gr71/$h71,2);
                //effieciency
                $target_eff71 = round($pm_npr71 * $h71);
                $actual_eff71 = $npr_gr71;
                $eff71 = round(100 * ($actual_eff71/$target_eff71));
                if($npr_h71 == '10'){
                    ?>
                    <td><?php echo '10-11AM'; ?></td>
                    <td><?php echo $npr_gr71; ?></td>
                    <td><?php echo $npr_b71; ?></td>
                    <td><?php echo $target_npr71; ?></td>
                    <td><?php echo $actual_npr71; ?></td>
                    <td><?php echo $eff71; ?></td>
                <?php }else{ ?>
                    <td><?php echo '10-11AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr71; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr81= 30;
                $qur81 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '11' and date(`update_date`) = CURDATE() group by npr_h";
                $result811 = mysqli_query($db,$qur81);
                $row811 = $result811->fetch_assoc();
                $h81 = 1;
                //npr
                $npr_h81 = $row811["npr_h"];
                $npr_gr81 = $row811["npr_gr"];
                $npr_b81 = $row811["npr_b"];
                $target_npr81 = $pm_npr81;
                $actual_npr81 = round($npr_gr81/$h81,2);
                //effieciency
                $target_eff81 = round($pm_npr81 * $h81);
                $actual_eff81 = $npr_gr81;
                $eff81 = round(100 * ($actual_eff81/$target_eff81));
                if($npr_h81 == '11'){
                    ?>
                    <td><?php echo '11-12AM'; ?></td>
                    <td><?php echo $npr_gr81; ?></td>
                    <td><?php echo $npr_b81; ?></td>
                    <td><?php echo $target_npr81; ?></td>
                    <td><?php echo $actual_npr81; ?></td>
                    <td><?php echo $eff81; ?></td>
                <?php }else{ ?>
                    <td><?php echo '11-12AM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr81; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr91= 30;
                $qur91 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '12' and date(`update_date`) = CURDATE() group by npr_h";
                $result911 = mysqli_query($db,$qur91);
                $row911 = $result911->fetch_assoc();
                $h91 = 1;
                //npr
                $npr_h91 = $row911["npr_h"];
                $npr_gr91 = $row911["npr_gr"];
                $npr_b91 = $row911["npr_b"];
                $target_npr91 = $pm_npr91;
                $actual_npr91 = round($npr_gr91/$h91,2);
                //effieciency
                $target_eff91 = round($pm_npr91 * $h91);
                $actual_eff91 = $npr_gr91;
                $eff91 = round(100 * ($actual_eff91/$target_eff91));
                if($npr_h91 == '12'){
                    ?>
                    <td><?php echo '12-13PM'; ?></td>
                    <td><?php echo $npr_gr91; ?></td>
                    <td><?php echo $npr_b91; ?></td>
                    <td><?php echo $target_npr91; ?></td>
                    <td><?php echo $actual_npr91; ?></td>
                    <td><?php echo $eff91; ?></td>
                <?php }else{ ?>
                    <td><?php echo '12-13PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr91; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr911= 30;
                $qur911 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '13' and date(`update_date`) = CURDATE() group by npr_h";
                $result9111 = mysqli_query($db,$qur911);
                $row9111 = $result911->fetch_assoc();
                $h911 = 1;
                //npr
                $npr_h911 = $row9111["npr_h"];
                $npr_gr911 = $row9111["npr_gr"];
                $npr_b911 = $row9111["npr_b"];
                $target_npr911 = $pm_npr911;
                $actual_npr911 = round($npr_gr911/$h911,2);
                //effieciency
                $target_eff911 = round($pm_npr911 * $h911);
                $actual_eff911 = $npr_gr911;
                $eff911 = round(100 * ($actual_eff911/$target_eff911));
                if($npr_h911 == '13'){
                    ?>
                    <td><?php echo '13-14PM'; ?></td>
                    <td><?php echo $npr_gr911; ?></td>
                    <td><?php echo $npr_b911; ?></td>
                    <td><?php echo $target_npr911; ?></td>
                    <td><?php echo $actual_npr911; ?></td>
                    <td><?php echo $eff911; ?></td>
                <?php }else{ ?>
                    <td><?php echo '13-14PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr911; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr921= 30;
                $qur921 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '14' and date(`update_date`) = CURDATE() group by npr_h";
                $result9211 = mysqli_query($db,$qur921);
                $row9211 = $result9211->fetch_assoc();
                $h921 = 1;
                //npr
                $npr_h921 = $row9211["npr_h"];
                $npr_gr921 = $row9211["npr_gr"];
                $npr_b921 = $row9211["npr_b"];
                $target_npr921 = $pm_npr921;
                $actual_npr921 = round($npr_gr921/$h921,2);
                //effieciency
                $target_eff921 = round($pm_npr921 * $h921);
                $actual_eff921 = $npr_gr921;
                $eff921 = round(100 * ($actual_eff921/$target_eff921));
                if($npr_h921 == '14'){
                    ?>
                    <td><?php echo '14-15PM'; ?></td>
                    <td><?php echo $npr_gr921; ?></td>
                    <td><?php echo $npr_b921; ?></td>
                    <td><?php echo $target_npr921; ?></td>
                    <td><?php echo $actual_npr921; ?></td>
                    <td><?php echo $eff921; ?></td>
                <?php }else{ ?>
                    <td><?php echo '14-15PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr921; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr931= 30;
                $qur931 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '15' and date(`update_date`) = CURDATE() group by npr_h";
                $result9311 = mysqli_query($db,$qur931);
                $row9311 = $result9311->fetch_assoc();
                $h931 = 1;
                //npr
                $npr_h931 = $row9311["npr_h"];
                $npr_gr931 = $row9311["npr_gr"];
                $npr_b931 = $row9311["npr_b"];
                $target_npr931 = $pm_npr931;
                $actual_npr931 = round($npr_gr931/$h931,2);
                //effieciency
                $target_eff931 = round($pm_npr931 * $h931);
                $actual_eff931 = $npr_gr931;
                $eff931 = round(100 * ($actual_eff931/$target_eff931));
                if($npr_h931 == '15'){
                    ?>
                    <td><?php echo '15-16PM'; ?></td>
                    <td><?php echo $npr_gr931; ?></td>
                    <td><?php echo $npr_b931; ?></td>
                    <td><?php echo $target_npr931; ?></td>
                    <td><?php echo $actual_npr931; ?></td>
                    <td><?php echo $eff931; ?></td>
                <?php }else{ ?>
                    <td><?php echo '15-16PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr931; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr941= 30;
                $qur941 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '16' and date(`update_date`) = CURDATE() group by npr_h";
                $result9411 = mysqli_query($db,$qur941);
                $row9411 = $result9411->fetch_assoc();
                $h941 = 1;
                //npr
                $npr_h941 = $row9411["npr_h"];
                $npr_gr941 = $row9411["npr_gr"];
                $npr_b941 = $row9411["npr_b"];
                $target_npr941 = $pm_npr941;
                $actual_npr941 = round($npr_gr941/$h941,2);
                //effieciency
                $target_eff941 = round($pm_npr941 * $h941);
                $actual_eff941 = $npr_gr941;
                $eff941 = round(100 * ($actual_eff941/$target_eff941));
                if($npr_h941 == '16'){
                    ?>
                    <td><?php echo '16-17PM'; ?></td>
                    <td><?php echo $npr_gr941; ?></td>
                    <td><?php echo $npr_b941; ?></td>
                    <td><?php echo $target_npr941; ?></td>
                    <td><?php echo $actual_npr941; ?></td>
                    <td><?php echo $eff941; ?></td>
                <?php }else{ ?>
                    <td><?php echo '16-17PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr941; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr951= 30;
                $qur951 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '17' and date(`update_date`) = CURDATE() group by npr_h";
                $result9511 = mysqli_query($db,$qur951);
                $row9511 = $result9511->fetch_assoc();
                $h951 = 1;
                //npr
                $npr_h951 = $row9511["npr_h"];
                $npr_gr951 = $row9511["npr_gr"];
                $npr_b951 = $row9511["npr_b"];
                $target_npr951 = $pm_npr951;
                $actual_npr951 = round($npr_gr951/$h951,2);
                //effieciency
                $target_eff951 = round($pm_npr951 * $h951);
                $actual_eff951 = $npr_gr951;
                $eff951 = round(100 * ($actual_eff951/$target_eff951));
                if($npr_h951 == '17'){
                    ?>
                    <td><?php echo '17-18PM'; ?></td>
                    <td><?php echo $npr_gr951; ?></td>
                    <td><?php echo $npr_b951; ?></td>
                    <td><?php echo $target_npr951; ?></td>
                    <td><?php echo $actual_npr951; ?></td>
                    <td><?php echo $eff951; ?></td>
                <?php }else{ ?>
                    <td><?php echo '17-18PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr951; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr961= 30;
                $qur961 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '18' and date(`update_date`) = CURDATE() group by npr_h";
                $result9611 = mysqli_query($db,$qur961);
                $row9611 = $result9611->fetch_assoc();
                $h961 = 1;
                //npr
                $npr_h961 = $row9611["npr_h"];
                $npr_gr961 = $row9611["npr_gr"];
                $npr_b961 = $row9611["npr_b"];
                $target_npr961 = $pm_npr961;
                $actual_npr961 = round($npr_gr961/$h961,2);
                //effieciency
                $target_eff961 = round($pm_npr961 * $h961);
                $actual_eff961 = $npr_gr961;
                $eff961 = round(100 * ($actual_eff961/$target_eff961));
                if($npr_h961 == '18'){
                    ?>
                    <td><?php echo '18-19PM'; ?></td>
                    <td><?php echo $npr_gr961; ?></td>
                    <td><?php echo $npr_b961; ?></td>
                    <td><?php echo $target_npr961; ?></td>
                    <td><?php echo $actual_npr961; ?></td>
                    <td><?php echo $eff961; ?></td>
                <?php }else{ ?>
                    <td><?php echo '18-19PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr961; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr971= 30;
                $qur971 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '19' and date(`update_date`) = CURDATE() group by npr_h";
                $result9711 = mysqli_query($db,$qur971);
                $row9711 = $result9711->fetch_assoc();
                $h971 = 1;
                //npr
                $npr_h971 = $row9711["npr_h"];
                $npr_gr971 = $row9711["npr_gr"];
                $npr_b971 = $row9711["npr_b"];
                $target_npr971 = $pm_npr971;
                $actual_npr971 = round($npr_gr971/$h971,2);
                //effieciency
                $target_eff971 = round($pm_npr971 * $h971);
                $actual_eff971 = $npr_gr971;
                $eff971 = round(100 * ($actual_eff971/$target_eff971));
                if($npr_h971 == '19'){
                    ?>
                    <td><?php echo '19-20PM'; ?></td>
                    <td><?php echo $npr_gr971; ?></td>
                    <td><?php echo $npr_b971; ?></td>
                    <td><?php echo $target_npr971; ?></td>
                    <td><?php echo $actual_npr971; ?></td>
                    <td><?php echo $eff971; ?></td>
                <?php }else{ ?>
                    <td><?php echo '19-20PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr971; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr981= 30;
                $qur981 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '20' and date(`update_date`) = CURDATE() group by npr_h";
                $result9811 = mysqli_query($db,$qur981);
                $row9811 = $result9811->fetch_assoc();
                $h981 = 1;
                //npr
                $npr_h981 = $row9811["npr_h"];
                $npr_gr981 = $row9811["npr_gr"];
                $npr_b981 = $row9811["npr_b"];
                $target_npr981 = $pm_npr981;
                $actual_npr981 = round($npr_gr981/$h981,2);
                //effieciency
                $target_eff981 = round($pm_npr981 * $h981);
                $actual_eff981 = $npr_gr981;
                $eff981 = round(100 * ($actual_eff981/$target_eff981));
                if($npr_h981 == '20'){
                    ?>
                    <td><?php echo '20-21PM'; ?></td>
                    <td><?php echo $npr_gr981; ?></td>
                    <td><?php echo $npr_b981; ?></td>
                    <td><?php echo $target_npr981; ?></td>
                    <td><?php echo $actual_npr981; ?></td>
                    <td><?php echo $eff981; ?></td>
                <?php }else{ ?>
                    <td><?php echo '20-21PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr981; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr991= 30;
                $qur991 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '21' and date(`update_date`) = CURDATE() group by npr_h";
                $result9911 = mysqli_query($db,$qur991);
                $row9911 = $result9911->fetch_assoc();
                $h991 = 1;
                //npr
                $npr_h991 = $row9911["npr_h"];
                $npr_gr991 = $row9911["npr_gr"];
                $npr_b991 = $row9911["npr_b"];
                $target_npr991 = $pm_npr991;
                $actual_npr991 = round($npr_gr991/$h991,2);
                //effieciency
                $target_eff991 = round($pm_npr991 * $h991);
                $actual_eff991 = $npr_gr991;
                $eff991 = round(100 * ($actual_eff991/$target_eff991));
                if($npr_h991 == '21'){
                    ?>
                    <td><?php echo '21-22PM'; ?></td>
                    <td><?php echo $npr_gr991; ?></td>
                    <td><?php echo $npr_b991; ?></td>
                    <td><?php echo $target_npr991; ?></td>
                    <td><?php echo $actual_npr991; ?></td>
                    <td><?php echo $eff991; ?></td>
                <?php }else{ ?>
                    <td><?php echo '21-22PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr991; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr191= 30;
                $qur191 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,update_date FROM `npr_data` where station_event_id = '$station_id' and npr_h = '22' and date(`update_date`) = CURDATE() group by npr_h";
                $result1911 = mysqli_query($db,$qur191);
                $row1911 = $result1911->fetch_assoc();
                $h191 = 1;
                //npr
                $npr_h191 = $row1911["npr_h"];
                $npr_gr191 = $row1911["npr_gr"];
                $npr_b191 = $row1911["npr_b"];
                $target_npr191 = $pm_npr191;
                $actual_npr191 = round($npr_gr191/$h191,2);
                //effieciency
                $target_eff191 = round($pm_npr191 * $h191);
                $actual_eff191 = $npr_gr191;
                $eff191 = round(100 * ($actual_eff191/$target_eff191));
                if($npr_h191 == '22'){
                    ?>
                    <td><?php echo '22-23PM'; ?></td>
                    <td><?php echo $npr_gr191; ?></td>
                    <td><?php echo $npr_b191; ?></td>
                    <td><?php echo $target_npr191; ?></td>
                    <td><?php echo $actual_npr191; ?></td>
                    <td><?php echo $eff191; ?></td>
                <?php }else{ ?>
                    <td><?php echo '22-23PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr191; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                $pm_npr291= 30;
                $qur291 = "SELECT distinct npr_h,max(`npr_b`) as npr_b,max(`npr_gr`) as npr_gr,date(`update_date`) FROM `npr_data` where station_event_id = '$station_id' and npr_h = '23' and date(`update_date`) = CURDATE() group by npr_h";
                $result2911 = mysqli_query($db,$qur291);
                $row2911 = $result2911->fetch_assoc();
                $h291 = 1;
                //npr
                $npr_h291 = $row2911["npr_h"];
                $npr_gr291 = $row2911["npr_gr"];
                $npr_b291 = $row2911["npr_b"];
                $target_npr291 = $pm_npr291;
                $actual_npr291 = round($npr_gr291/$h291,2);
                //effieciency
                $target_eff291 = round($pm_npr191 * $h291);
                $actual_eff291 = $npr_gr291;
                $eff291 = round(100 * ($actual_eff291/$target_eff291));
                if($npr_h291 == '23'){
                    ?>
                    <td><?php echo '23-24PM'; ?></td>
                    <td><?php echo $npr_gr291; ?></td>
                    <td><?php echo $npr_b291; ?></td>
                    <td><?php echo $target_npr291; ?></td>
                    <td><?php echo $actual_npr291; ?></td>
                    <td><?php echo $eff291; ?></td>
                <?php }else{ ?>
                    <td><?php echo '23-24PM'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo $target_npr291; ?></td>
                    <td><?php echo '0'; ?></td>
                    <td><?php echo '0'; ?></td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</div>
</div>
</body>
</html>
