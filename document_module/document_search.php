<?php include("../config.php");
$curdate = date('Y-m-d');
$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
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
    header($redirect_logout_path);
//	header('location: ../logout.php');
    exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$button_event = "button3";
$curdate = date('Y-m-d');
$dfrom =   date('Y-m-d',strtotime("-1 days"));
$dateto = $curdate;
$datefrom = $dfrom;
$temp = "";

$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['part_number'] = "";

if (count($_POST) > 0) {
    $_SESSION['station'] = $_POST['station'];
    $_SESSION['part_number'] = $_POST['part_number'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];


    $station = $_POST['station'];
    $pn = $_POST['part_number'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
}

$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station' ");
while ($rowctemp = mysqli_fetch_array($qurtemp)) {
    $station1 = $rowctemp["line_name"];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Document List</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">


    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
    <style>
        .red {
            color: red;
            display: none;
        }
        .col-md-6.date {
            width: 25%;
        }
        .create {
            float: right;
            padding: 12px;
        }
        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px)  {

            .form_mob{
                display: none;
            }
            .form_create{
                display: none;
            }
        }
        @media
        only screen and (max-width: 400px),
        (min-device-width: 400px) and (max-device-width: 670px)  {

            .form_mob{
                display: none;
            }
            .form_create{
                display: none;
            }
            .col-md-6.date {
                width: 100%;
                float: right;
            }
        }
    </style>

</head>
<body>
<!-- Main navbar -->
<?php $cust_cam_page_header = "View Document Form";
include("../header.php");

if (($is_tab_login || $is_cell_login)) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<div class="page-container">
    <!-- Content area -->

    <div class="content">
        <div class="panel panel-flat">
            <form action="" id="doc_form" class="form-horizontal" method="post">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6 mobile">


                            <label class="col-lg-2 control-label">Station :</label>

                            <div class="col-lg-8">
                                <select name="station" id="station" class="select"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Station ---</option>
                                    <?php
                                    $st_dashboard = $_POST['station'];
                                    $sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
                                    $result1 = $mysqli->query($sql1);
                                    //                                            $entry = 'selected';
                                    while ($row1 = $result1->fetch_assoc()) {
                                        if($st_dashboard == $row1['line_id'])
                                        {
                                            $entry = 'selected';
                                        }
                                        else
                                        {
                                            $entry = '';

                                        }
                                        echo "<option value='" . $row1['line_id'] . "' $entry>" . $row1['line_name'] . "</option>";
                                    }
                                    ?>

                                </select>
                            </div>

                        </div>
                        <div class="col-md-6 mobile">
                            <label class="col-lg-3 control-label">Part Number *  :</label>
                            <div class="col-lg-8">
                                <select name="part_number" id="part_number" class="select" data-style="bg-slate" >
                                    <option value="" selected disabled>--- Select Part Number ---</option>
                                    <?php
                                    $st_part = $_POST['part_number'];
                                    $sql1 = "SELECT * FROM `pm_part_number` where  is_deleted = 0 ";
                                    $result1 = $mysqli->query($sql1);
                                    while ($row1 = $result1->fetch_assoc()) {
                                        if($st_part == $row1['pm_part_number_id'])
                                        {
                                            $entry = 'selected';
                                        }
                                        else
                                        {
                                            $entry = '';

                                        }
                                        echo "<option value='" . $row1['pm_part_number_id'] . "'$entry>" . $row1['part_number']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <br>

<!--                    <div class="row">-->
<!--                        <div class="col-md-6 date">-->
<!---->
<!--                            <label class="control-label"-->
<!--                                   style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date-->
<!--                                From : &nbsp;&nbsp;</label>-->
<!--                            <input type="date" name="date_from" id="date_from" class="form-control"-->
<!--                                   value="--><?php //echo $datefrom; ?><!--" style="float: left;width: initial;"-->
<!--                                   required>-->
<!--                        </div>-->
<!--                        <div class="col-md-6 date">-->
<!--                            <label class="control-label"-->
<!--                                   style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date-->
<!--                                To: &nbsp;&nbsp;</label>-->
<!--                            <input type="date" name="date_to" id="date_to" class="form-control"-->
<!--                                   value="--><?php //echo $dateto; ?><!--" style="float: left;width: initial;" required>-->
<!---->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!--                    <br/>-->
                    <?php
                                        if (!empty($import_status_message)) {
                                            echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                                        }
                                        ?>
                                        <?php
                                        if (!empty($_SESSION['import_status_message'])) {
                                            echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                            $_SESSION['message_stauts_class'] = '';
                                            $_SESSION['import_status_message'] = '';
                                        }
                    ?>

                </div>
                <div class="panel-footer p_footer">
                    <div class="row">
                        <div class="col-md-2">
                            <button type="submit" id="submit_btn" class="btn btn-primary"
                                    style="background-color:#1e73be;">
                                Submit
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary"  onclick="window.reload();"
                                    style="background-color:#1e73be;">Reset
                            </button>
                        </div>

            </form>

        </div>
    </div>
</div>
        <div class="panel panel-flat">
            <table class="table datatable-basic">
                <thead>
                <tr>

                    <th>Action</th>
                    <th>Document Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Expiry date</th>

                </tr>
                </thead>
                <tbody>
                <?php

                if ($station != "" && $pn == ""){
                    $q = ("SELECT cl.line_name,dd.created_at,dd.doc_id,dd.doc_name,dd.part_number,dd.doc_category,dd.status,dd.expiry_date from document_data as dd INNER JOIN cam_line as cl ON dd.station = cl.line_id where cl.line_id='$station';");

                }

                if ($station != ""  && $pn != ""){
                    $q = ("SELECT pn.part_number,pn.part_name,cl.line_name,dd.created_at,dd.doc_id,dd.doc_name,dd.doc_category,dd.status,dd.expiry_date FROM  document_data as dd inner join cam_line as cl on dd.station = cl.line_id inner join pm_part_number as pn on dd.part_number=pn.pm_part_number_id where  cl.line_id='$station' and pn.pm_part_number_id='$pn'");

                }

                $qur = mysqli_query($db, $q);

                while ($rowc = mysqli_fetch_array($qur)) {
                    ?>
                    <tr>
                        <?php
                        $un = $rowc['station'];
                        $qur04 = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$station' ");
                        while ($rowc04 = mysqli_fetch_array($qur04)) {
                            $lnn = $rowc04["line_name"];
                        }
                        ?>
                        <td>

                        <a href="<?php echo $siteURL; ?>document_module/edit_document.php?id=<?php echo $rowc['doc_id'];?>" class="btn btn-primary legitRipple" style="background-color:#1e73be;" target="_blank"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        </td>
                        <td><?php echo $rowc['doc_name']; ?></td>
                        <td><?php
                            $doc_cat =  $rowc['doc_category'];
                            $doc_sql ="select document_type_id,document_type_name from document_type where document_type_id = '$doc_cat'";
                            $doc_que = mysqli_query($db,$doc_sql);
                            while ($row_doc = mysqli_fetch_array($doc_que)) {
                                $doc_name = $row_doc['document_type_name'];
                                echo $doc_name;
                            }
                            ?></td>
                        <td><?php echo $rowc['status']; ?></td>

                        <td><?php echo $rowc['expiry_date']; ?></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>



</div>
<!-- /content area -->


<script>
    $('#station').on('change', function (e) {
        $("#doc_form").submit();
    });

    });
    $('#part_number').on('change', function (e) {
        $("#doc_form").submit();
    });

    $(document).on("click","#submit_btn",function() {

        var station = $("#station").val();
        var part_number = $("#part_number").val();
        $("#user_form").submit();


    });
</script>

<?php include ('../footer.php') ?>
</body>
</html>


