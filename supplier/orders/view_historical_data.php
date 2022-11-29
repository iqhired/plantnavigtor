<?php include("./../../sup_config.php");
include("./../../config.php");
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | View Order Data</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="./../../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="./../../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="./../../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="./../../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/core/app.js"></script>
    <script type="text/javascript" src="./../../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="./../../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="./../../assets/js/pages/form_layouts.js"></script>
    <style>
        .col-lg-12{
            background-color: #FFFFFF;
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
include("../sup_header.php");
?>
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- content wrapper-->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <form action="" id="" enctype="multipart/form-data" class="form-horizontal"
                          method="post">
                        <div class="col-lg-12">
                            <h4 style="margin-top: 20px;margin-left: 10px;">Order Details : </h4>
                            <hr>
                            <?php
                            $sql = sprintf("SELECT * FROM sup_order where order_id = '$id' ");
                            $qur = mysqli_query($sup_db, $sql);
                            $row = mysqli_fetch_array($qur);
                            $order_name = $row['order_name'];
                            $order_desc = $row['order_desc'];
                            $order_status_id = $row['order_status_id'];
                            $created_on = $row['created_on'];
                            $created_by = $row['created_by'];
                            $shipment_details = $row['shipment_details'];
                            $c_id = $row['c_id'];
                            ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Supplier Name : </label>
                                        <?php
                                        $sql5 = sprintf("SELECT * FROM sup_account where c_id = '$c_id'");
                                        $qur5 = mysqli_query($sup_db, $sql5);
                                        $row5 = mysqli_fetch_array($qur5);
                                        $c_name = $row5['c_name'];
                                        ?>
                                        <div class="col-lg-6">
                                            <input type="text" name="s_name" id="s_name" class="form-control" value="<?php echo $c_name; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Order Name : </label>
                                        <div class="col-lg-6">
                                            <input type="text" name="o_name" id="o_name" class="form-control" value="<?php echo $order_name; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Order Description : </label>
                                        <div class="col-lg-6">
                                            <input type="text" name="o_desc" id="o_desc" class="form-control" value="<?php echo $order_desc; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Order Status : </label>
                                        <?php
                                        $sql1 = sprintf("SELECT * FROM sup_order_status where sup_order_status_id = '$order_status_id' ");
                                        $qur1 = mysqli_query($sup_db, $sql1);
                                        $row1 = mysqli_fetch_array($qur1);
                                        $sup_order_status = $row1['sup_order_status'];
                                        ?>
                                        <div class="col-lg-6">
                                            <input type="text" name="o_status" id="o_status" class="form-control" value="<?php echo $sup_order_status; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Created By : </label>
                                        <?php
                                        $sql2 = sprintf("SELECT * FROM cam_users where users_id = '$created_by' and is_deleted != 1");
                                        $qur2 = mysqli_query($db, $sql2);
                                        $row2 = mysqli_fetch_array($qur2);
                                        $full_name = $row2['firstname'] . ' ' . $row2['lastname'];
                                        ?>
                                        <div class="col-lg-6">
                                            <input type="text" name="c_by" id="c_by" class="form-control" value="<?php echo $full_name; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Created On : </label>
                                        <div class="col-lg-6">
                                            <input type="text" name="c_date" id="c_date" class="form-control" value="<?php echo $created_on; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                    <h4 style="margin-top: 20px;margin-left: 10px;">Shipment Details : </h4>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Shipment Name : </label>
                                            <div class="col-lg-6">
                                                <input type="text" name="ship_name" id="ship_name" class="form-control" value="<?php echo $shipment_details; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Attach Invoice : </label>
                                            <?php
                                            $sql3 = sprintf("SELECT * FROM order_files where order_id = '$id' and file_type = 'invoice'");
                                            $qur3 = mysqli_query($sup_db, $sql3);
                                            $row3 = mysqli_fetch_array($qur3);
                                            $file_name = $row3['file_name'];
                                            ?>
                                            <a href="../order_invoices/<?php echo $file_name; ?>" target="_blank">
                                                <div class="col-md-6">
                                                    <input type="text" name="att_voice" class="form-control pn_none" id="att_voice"
                                                           value="<?php echo $file_name; ?>">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Other Attachments : </label>
                                            <?php
                                            $sql4 = sprintf("SELECT * FROM order_files where order_id = '$id' and file_type = 'attachment'");
                                            $qur4 = mysqli_query($sup_db, $sql4);
                                            $row4 = mysqli_fetch_array($qur4);
                                            $file_name4 = $row4['file_name'];
                                            ?>
                                            <a href="../order_invoices/<?php echo $file_name4; ?>" target="_blank">
                                                <div class="col-md-6">
                                                    <input type="text" name="att_doc" class="form-control pn_none" id="att_doc"
                                                           value="<?php echo $file_name4; ?>">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- /content area -->
</div>
<!-- /main content -->
</div>
<!-- /page content -->
</div>
<?php include('../footer.php') ?>
</body>
</html>
