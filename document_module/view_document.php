<?php
include("../config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $sitename; ?> | View Form</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/gallery.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=WindSong&display=swap');

        .signature {

            font-family: 'WindSong', swap;
            font-size: 25px;
            font-weight: 600;
        }

        .form_table_mobile {
            display: none;
        }

        #form_save_btn {
            background-color: #1e73be;
            margin-left: 35px;
            padding: 12px 22px 10px 18px;
            margin-bottom: 10px;
        }

        .pn_none {
            pointer-events: none;
            color: #050505;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #191e3a!important;
            line-height: 20px!important;

        }
        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #060818!important;
            border-block-start: none;

        }
        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #999;
            border-bottom-style: inset;
        }
        .form-control {
            font-size: 15px;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-2{
                width: 35%!important;
            }
            .content:first-child {
                padding-top: 90px!important;
            }
            .col-md-3 {
                width: 35%;
                float: left;
            }
            .col-md-1 {
                width: 5%;
                float: right;
            }
            .col-md-8.form_col_item {
                float: left;
                width: 100%;
            }
            .col-md-4.form {
                width: 100%;
                float: right;
                margin-top: 10px;
            }

            .form_table_mobile {
                width: 100%;
                background-color: #eee;
                margin-top: 12px;
            }
            .form_row_mobile {
                width: 100%;
                height: auto;
            }
            .col-lg-8.mobile {
                width: 58%;
                float: right;
                padding: 10px 30px 10px 26px;
            }
            label.col-lg-3.control-label.mobile {
                width: 42%;
                float: left;
                padding: 10px 30px 10px 26px;
            }
            .form_table_mobile {
                display: block;
            }
            table.form_table {
                display: none;
            }
            .col-md-1 {
                width: 50%;
                float: right;
            }
            .col-md-2 {
                width: 50%;
                float: left;
            }
            .border-primary {
                border-color: #ffffff;
            }
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "View Document";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">

    <!-- Content area -->
    <div class="content">
       <?php

             $station = $_GET['station'];
             $part =   $_GET['part_number'];
       $sql_file_station = sprintf("SELECT * FROM `document_data` where part_number = '$part'");
       $qurmain = mysqli_query($db, $sql_file_station);
       while($rowcmain = mysqli_fetch_array($qurmain)){
           $doc_type = $rowcmain['doc_type'];


       }
       $sql_station = "SELECT * FROM `cam_line` where line_id = '$station'";
       $qurst = mysqli_query($db, $sql_station);
        while($rowcst = mysqli_fetch_array($qurst)){
            $station_name = $rowcst['line_name'];
        }

            ?>
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title form_panel_title"><?php echo $station_name; ?>
                </h5>
                <div class="row ">
                    <form action="" id="form_settings" enctype="multipart/form-data"
                          class="form-horizontal" method="post" autocomplete="off">
                    <div class="col-md-12">
                        <?php
                        $sql_file = sprintf("SELECT * FROM `document_files` where station = '$station' AND part_number  = '0' ");
                        $qurmain1 = mysqli_query($db, $sql_file);
                        while($rowcmain1 = mysqli_fetch_array($qurmain1)){
                            $file_name = $rowcmain1['file_name'];
                            $id =  $rowcmain1['doc_id'];
                            $station =  $rowcmain1['station'];

                        $img_file = sprintf("SELECT * FROM `document_data` where doc_id = '$id'");
                        $qurmain1_d = mysqli_query($db, $img_file);
                        while($rowcmain1_d = mysqli_fetch_array($qurmain1_d)){
                            $doc_name_station = $rowcmain1_d['doc_name'];

                            ?>


                        <div class="form_row row">
                            <a href="../document_files/<?php echo $id; ?>/<?php echo $file_name; ?>" target="_blank">
                            <div class="col-md-6">

                            <input type="text" name="notes" class="form-control pn_none" id="notes"
                                       value="<?php echo $doc_name_station; ?>">
                            </div>
                            </a>

                        </div>
                        <?php } }?>

                            </div>
                        </form>
                    </div>
                <?php
                $sql_part = "SELECT * FROM `pm_part_number` where pm_part_number_id = '$part'";
                $qur_part = mysqli_query($db, $sql_part);
                while($row_part = mysqli_fetch_array($qur_part)){
                    $part_number = $row_part['part_number'];
                    $part_name = $row_part['part_name'];
                }
                ?>
                <?php $query = sprintf("SELECT line_id,event_status FROM `sg_station_event` where line_id = '$station' ORDER BY created_on DESC");

                $qur_st = mysqli_query($db, $query);
                while($row_st = mysqli_fetch_array($qur_st)){
                $event_status = $row_st['event_status'];

                if ($event_status == '1'){ ?>
                        <h5 class="panel-title form_panel_title"><?php echo $part_number."-".$part_name; ?></h5>
                <div class="row ">
                    <form action="" id="form_settings" enctype="multipart/form-data"
                          class="form-horizontal" method="post" autocomplete="off">
                        <div class="col-md-12">
                            <?php
                            $sql_file = sprintf("SELECT * FROM `document_files` where station = '$station' AND part_number = '$part' AND  part_number != '0' ");
                            $qurmain1 = mysqli_query($db,$sql_file);
                            while($rowcmain1 = mysqli_fetch_array($qurmain1)){
                                $file_name = $rowcmain1['file_name'];
                                $id =  $rowcmain1['doc_id'];

                                $img_file_p = sprintf("SELECT * FROM `document_data` where doc_id = '$id'");
                                $qurmain1_p = mysqli_query($db, $img_file_p);
                                while($rowcmain1_p = mysqli_fetch_array($qurmain1_p)){
                                    $doc_name_part = $rowcmain1_p['doc_name'];

                                    ?>

                                <div class="form_row row">
                                    <a href="../document_files/<?php echo $id; ?>/<?php echo $file_name; ?>" target="_blank">
                                        <div class="col-md-6">
                                            <input type="text" name="notes" class="form-control pn_none" id="notes"
                                                   value="<?php echo $doc_name_part; ?>">
                                        </div>
                                    </a>

                                </div>
                            <?php } } ?>

                        </div>
                    </form>
                </div>
               <?php  }  ?>

               <?php } ?>
                </div>

            </div>
        </div>




        <!-- /page container -->

        <?php include('../footer.php') ?>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>

</body>

</html>