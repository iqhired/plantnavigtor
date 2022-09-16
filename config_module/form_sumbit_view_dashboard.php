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
       /* body{
            background-color: #000000;
            width: 100%;
        }*/
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
            <th>Station Name</th>
            <th>Form Type</th>
            <th>Daily Submitted</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            $qur1 = mysqli_query($db, "SELECT distinct `form_type`,`station`,count(created_at) as cc FROM `form_user_data` WHERE form_type in (4,5) and date(`created_at`) = CURDATE() GROUP BY form_type,station");
            while ($row1 = mysqli_fetch_array($qur1)) {
            $station = $row1["station"];
            $form_type = $row1["form_type"];
            $created_at = $row1["cc"];
            $sql1 = "SELECT * FROM `cam_line` where `line_id` = '$station'";
            $result1 = $mysqli->query($sql1);
            $rowc1 = $result1->fetch_assoc();
            $line_name = $rowc1['line_name'];
            $sql2 = "SELECT * FROM `form_type` where `form_type_id` = '$form_type'";
            $result2 = $mysqli->query($sql2);
            $rowc2 = $result2->fetch_assoc();
            $form_type_name = $rowc2['form_type_name'];
            ?>
            <td><?php echo $line_name; ?></td>
            <td><?php echo $form_type_name; ?></td>
            <td><?php echo $created_at; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</form>
<form action="" id="form2" method="post">
    <div class="panel panel-flat">
        <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Station Name</th>
                <th>Form Type</th>
                <th>Weekly Submitted</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                $qur2 = mysqli_query($db, "SELECT distinct `form_type`,`station`,count(created_at) as cd FROM `form_user_data` WHERE form_type in (4,5) and YEARWEEK(`created_at`) = YEARWEEK(CURDATE()) GROUP BY form_type,station");
                while ($row2 = mysqli_fetch_array($qur2)) {
                $station = $row2["station"];
                $form_type = $row2["form_type"];
                $cd = $row2["cd"];
                $sql21 = "SELECT * FROM `cam_line` where `line_id` = '$station'";
                $result21 = $mysqli->query($sql21);
                $rowc21 = $result21->fetch_assoc();
                $line_name = $rowc21['line_name'];
                $sql22 = "SELECT * FROM `form_type` where `form_type_id` = '$form_type'";
                $result22 = $mysqli->query($sql22);
                $rowc22 = $result22->fetch_assoc();
                $form_type_name = $rowc22['form_type_name'];
                ?>
                <td><?php echo $line_name; ?></td>
                <td><?php echo $form_type_name; ?></td>
                <td><?php echo $cd; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</form>
<form action="" id="form3" method="post">
    <div class="panel panel-flat">
        <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Station Name</th>
                <th>Form Type</th>
                <th>Monthly Submitted</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                $qur3 = mysqli_query($db, "SELECT distinct `form_type`,`station`,count(created_at) as ce FROM `form_user_data` WHERE form_type in (4,5) and Month(`created_at`) = Month(CURDATE()) GROUP BY form_type,station");
                while ($row3 = mysqli_fetch_array($qur3)) {
                $station = $row3["station"];
                $form_type = $row3["form_type"];
                $ce = $row3["ce"];
                $sql31 = "SELECT * FROM `cam_line` where `line_id` = '$station'";
                $result31 = $mysqli->query($sql31);
                $rowc31 = $result31->fetch_assoc();
                $line_name = $rowc31['line_name'];
                $sql32 = "SELECT * FROM `form_type` where `form_type_id` = '$form_type'";
                $result32 = $mysqli->query($sql32);
                $rowc32 = $result32->fetch_assoc();
                $form_type_name = $rowc32['form_type_name'];
                ?>
                <td><?php echo $line_name; ?></td>
                <td><?php echo $form_type_name; ?></td>
                <td><?php echo $ce; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</form>
<form action="" id="form4" method="post">
    <div class="panel panel-flat">
        <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Station Name</th>
                <th>Form Type</th>
                <th>Yearly Submitted</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                $qur4 = mysqli_query($db, "SELECT distinct `form_type`,`station`,count(created_at) as cf FROM `form_user_data` WHERE form_type in (4,5) and Year(`created_at`) = Year(CURDATE()) GROUP BY form_type,station");
                while ($row4 = mysqli_fetch_array($qur4)) {
                $station = $row4["station"];
                $form_type = $row4["form_type"];
                $cf = $row4["cf"];
                $sql41 = "SELECT * FROM `cam_line` where `line_id` = '$station'";
                $result41 = $mysqli->query($sql41);
                $rowc41 = $result41->fetch_assoc();
                $line_name = $rowc41['line_name'];
                $sql42 = "SELECT * FROM `form_type` where `form_type_id` = '$form_type'";
                $result42 = $mysqli->query($sql42);
                $rowc42 = $result42->fetch_assoc();
                $form_type_name = $rowc42['form_type_name'];
                ?>
                <td><?php echo $line_name; ?></td>
                <td><?php echo $form_type_name; ?></td>
                <td><?php echo $cf; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</form>
</body>
</html>
