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
$is_tab_login = $_SESSION['is_tab_user'];
$is_cell_login = $_SESSION['is_cell_login'];
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../dashboard.php');
}
if (count($_POST) > 0) {

    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];

    $_SESSION['station_1'] = $_POST['station'];
    $_SESSION['part_family_1'] = $_POST['part_family'];
    $_SESSION['part_number_1'] = $_POST['part_number'];
    $_SESSION['form_type_1'] = $_POST['form_type'];
    $_SESSION['date_from_1'] = $_POST['date_from'];
    $_SESSION['date_to_1'] = $_POST['date_to'];
    $_SESSION['timezone_1'] = $_POST['timezone'];
}else{
    $curdate = date('Y-m-d');
    $dateto = $curdate;
    $yesdate = date('Y-m-d',strtotime("-1 days"));
    $datefrom = $yesdate;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | View Rejection Form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
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

        .mb-4, .my-4 {
            margin-bottom: 0rem!important;
        }
        .pb-2, .py-2 {
            margin-bottom: 0rem;
        }
        .card-body {
            flex: 1 1 auto;
            padding: 2rem 3rem!important;
        }
        .mt-3{
            font-size: 15px!important;
        }
        .card-footer {
            padding: 0.5rem 2rem!important;

        }
        .col-lg-6 {
            width: 100%;
        }
        .scrollable {
            height: 540px; /* or any value */
            overflow-y: auto;
        }
        .thumbnail{
            padding: 0px;
            width: 100px;
            height: 100px;
        }
        .thumb img:not(.media-preview){
            height: 100px !important;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .com-mobile-version {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php $cust_cam_page_header = "Rejected Form Action";
include("../header.php");

if (($is_tab_login || $is_cell_login)) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}
include("../heading_banner.php");
?>
<div class="page-container">
    <!-- Content area -->
    <div class="content">
        <?php
        if (!empty($import_status_message)) {
            echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
        }
        ?>
        <?php
        if (!empty($_SESSION['import_status_message'])) {
            echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
            $_SESSION['message_stauts_class'] = '';
            $_SESSION['import_status_message'] = '';
        }
        ?>
        <div class="col-md-12" style="background-color: #eee;">
            <div class="col-md-6 com-mobile-version">
                <form action="" id="form_update" enctype="multipart/form-data"
                      class="form-horizontal" method="post" autocomplete="off" style="padding-top: 30px;">
                    <?php
                    $id = $_GET['id'];
                    $fill_op_data = $_GET['optional'];

                    $querymain = sprintf("SELECT * FROM `form_user_data` where form_user_data_id = '$id' ");
                    $qurmain = mysqli_query($db, $querymain);

                    while ($rowcmain = mysqli_fetch_array($qurmain)) {
                        $formname = $rowcmain['form_name'];
                        $form_user_data_id = $rowcmain['form_user_data_id'];

                        ?>

                        <div class="panel panel-flat">
                            <!--                <h5 style="text-align: left;margin-right: 120px;"> <b>Submitted on : </b>--><?php //echo date('d-M-Y h:m'); ?><!--</h5>-->
                            <div class="panel-heading">
                                <h5 class="panel-title form_panel_title"><?php echo $rowcmain['form_name']; ?>  </h5>
                                <div class="row ">
                                    <div class="col-md-12">

                                        <input type="hidden" name="name" id="name"
                                               value="<?php echo $rowcmain['form_name']; ?>">
                                        <input type="hidden" name="formcreateid" id="formcreateid"
                                               value="<?php echo $rowcmain['form_create_id']; ?>">
                                        <input type="hidden" name="form_user_data_id" id="form_user_data_id"
                                               value="<?php echo $id; ?>">

                                        <div class="form_row row">
                                            <label class="col-lg-2 control-label">Form link : </label>
                                            <div class="col-md-6">
                                                <a href="view_rejetion.php?id=<?php echo $rowcmain['form_user_data_id'];?>">
                                                    <u>Link for view the form</u>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form_row row">
                                            <label class="col-lg-2 control-label">Form Type : </label>
                                            <div class="col-md-6">
                                                <?php
                                                $get_form_type = $rowcmain['form_type'];
                                                if ($get_form_type != '') {
                                                    $disabled = 'disabled';
                                                } else {
                                                    $disabled = '';
                                                }
                                                ?>
                                                <input type="hidden" name="form_type" id="form_type"
                                                       value="<?php echo $get_form_type; ?>">
                                                <select name="form_type1" id="form_type"
                                                        class="select-border-color form-control" <?php echo $disabled; ?>>
                                                    <option value="" selected disabled>--- Select Form Type ---</option>
                                                    <?php

                                                    $sql1 = "SELECT * FROM `form_type` ";
                                                    $result1 = $mysqli->query($sql1);
                                                    // $entry = 'selected';
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        if ($get_form_type == $row1['form_type_id']) {
                                                            $entry = 'selected';
                                                        } else {
                                                            $entry = '';
                                                        }
                                                        echo "<option value='" . $row1['form_type_id'] . "'  $entry>" . $row1['form_type_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form_row row">
                                            <label class="col-lg-2 control-label">Station : </label>
                                            <div class="col-md-6">

                                                <?php
                                                $get_station = $rowcmain['station'];
                                                if ($get_station != '') {
                                                    $disabled = 'disabled';
                                                } else {
                                                    $disabled = '';
                                                }
                                                ?>

                                                <input type="hidden" name="station" id="station"
                                                       value="<?php echo $get_station; ?>">
                                                <select name="station1" id="station1"
                                                        class="select-border-color form-control" <?php echo $disabled; ?>>
                                                    <option value="" selected disabled>--- Select Station ---</option>
                                                    <?php
                                                    $sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
                                                    $result1 = $mysqli->query($sql1);
                                                    //                                            $entry = 'selected';
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        if ($get_station == $row1['line_id']) {
                                                            $entry = 'selected';
                                                        } else {
                                                            $entry = '';
                                                        }
                                                        echo "<option value='" . $row1['line_id'] . "' $entry >" . $row1['line_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form_row row">
                                            <label class="col-lg-2 control-label">Part Family : </label>
                                            <div class="col-md-6">

                                                <?php
                                                $get_part_family = $rowcmain['part_family'];
                                                if ($get_part_family != '') {
                                                    $disabled = 'disabled';
                                                } else {
                                                    $disabled = '';
                                                }
                                                ?>

                                                <input type="hidden" name="part_family" id="part_family"
                                                       value="<?php echo $get_part_family; ?>">
                                                <select name="part_family1" id="part_family1"
                                                        class="select-border-color form-control" <?php echo $disabled; ?>>
                                                    <option value="" selected disabled>--- Select Part Family ---</option>
                                                    <?php
                                                    $sql1 = "SELECT * FROM `pm_part_family` ";
                                                    $result1 = $mysqli->query($sql1);
                                                    //                                            $entry = 'selected';
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        if ($get_part_family == $row1['pm_part_family_id']) {
                                                            $entry = 'selected';
                                                        } else {
                                                            $entry = '';
                                                        }
                                                        echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form_row row">
                                            <label class="col-lg-2 control-label">Part Number : </label>
                                            <div class="col-md-6">

                                                <?php
                                                $get_part_number = $rowcmain['part_number'];
                                                if ($get_part_number != '') {
                                                    $disabled = 'disabled';
                                                } else {
                                                    $disabled = '';
                                                }
                                                ?>

                                                <input type="hidden" name="part_number" id="part_number"
                                                       value="<?php echo $get_part_number; ?>">
                                                <select name="part_number1" id="part_number1"
                                                        class="select-border-color form-control" <?php echo $disabled; ?> style=" width: 360px;">
                                                    <option value="" selected disabled>--- Select Part Number ---</option>
                                                    <?php
                                                    $sql1 = "SELECT * FROM `pm_part_number` ";
                                                    $result1 = $mysqli->query($sql1);
                                                    //                                            $entry = 'selected';
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        if ($get_part_number == $row1['pm_part_number_id']) {
                                                            $entry = 'selected';
                                                        } else {
                                                            $entry = '';
                                                        }
                                                        echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] . " - " . $row1['part_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form_row row">
                                            <label class="col-lg-2 control-label">Operator : </label>
                                            <div class="col-md-6">

                                                <?php
                                                $createdby = $rowcmain['created_by'];
                                                $datetime = $rowcmain["created_at"];
                                                $create_date = strtotime($datetime);
                                                $qur04 = mysqli_query($db, "SELECT firstname,lastname,pin FROM  cam_users where users_id = '$createdby' ");
                                                $rowc04 = mysqli_fetch_array($qur04);
                                                $fullnnm = $rowc04["firstname"] . " " . $rowc04["lastname"];
                                                $pin = $rowc04["pin"];

                                                ?>
                                                <input type="hidden" name="pin1" class="form-control" id="pin1"
                                                       value="<?php echo $pin; ?>" disabled>

                                                <input type="text" name="createdby" class="form-control" id="createdby"
                                                       value="<?php echo $fullnnm; ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="form_row row">
                                            <?php
                                            $qur1 = mysqli_query($db, "SELECT r_flag FROM  form_rejection_data where form_user_data_id = '$form_user_data_id' ");
                                            $row1 = mysqli_fetch_array($qur1);
                                            $r_flag = $row1["r_flag"];
                                            ?>
                                            <input type="hidden" name="r_flag" class="form-control" id="r_flag"
                                                   value="<?php echo $r_flag; ?>" disabled>

                                        </div>


                                        <div class="form_row row" style="background-color: #eee;">
                                            <label class="col-lg-2 control-label" style="width: 140px;">Loop Closed By : </label>
                                            <div class="col-md-6">

                                                    <input type="hidden" id="userid" name="userid" value="<?php echo $id; ?>">
                                                    <?php
                                                    $qurtemp = mysqli_query($db, "SELECT * FROM `form_rejection_data` where form_user_data_id = '$form_user_data_id' ");
                                                    while ( $rowctemp = mysqli_fetch_array($qurtemp)) {
                                                     $closed_by = $rowctemp['closed_by'];
                                                    }
                                                    $quruser = mysqli_query($db, "SELECT users_id,firstname,lastname FROM `cam_users` where users_id = '$closed_by' ");
                                                    $rowcuser = mysqli_fetch_array($quruser);
                                                    $user_name = $rowcuser['firstname']." ".$rowcuser['lastname'];

                                                    ?>
                                                    <input class="form-control" name="username" id="username" value="<?php echo $user_name; ?>" disabled>


                                            </div>


                                     <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </form>
            </div>

            <div class="col-md-6 com-mobile-version">
                <form action="" id="update-form" method="post"  class="form-horizontal">
                    <section>
                        <div class="container my-5">
                            <div class="row d-flex justify-content-center ">
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <div class="card">
                                        <div class="card-body scrollable" id="scroll">
                                            <?php
                                            $qurt = mysqli_query($db, "SELECT message,comment_date,slno FROM  comments where rej_loop_form_id = '$form_user_data_id' ");
                                            while ($rowct = mysqli_fetch_array($qurt)) {
                                                $comment_id = $rowct["slno"];
                                                $message = $rowct["message"];
                                                $comment_date = $rowct["comment_date"];
                                                ?>
                                                <p class="mt-3 pb-2">
                                                    <?php echo $rowct["message"]."<br/>"; ?>
                                                </p>
                                                <p class="small mb-0">
                                                <?php
                                                $file_name = "";
                                                $c_file = mysqli_query($db, "SELECT * FROM  comment_files where comment_id = '$comment_id' ");
                                                $file_name = null;
                                                while ($rowct = mysqli_fetch_array($c_file)) {
                                                    $file_name = $rowct["file_name"];

                                                }
                                                if(!empty($file_name)){
                                                    ?>

                                                    <div class="thumbnail">
                                                        <div class="thumb">
                                                            <?php
                                                            $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                                                            if ($imageFileType == "xls") { ?>
                                                                <img src="../assets/comment_files/excel.png" alt="">
                                                            <?php } else if($imageFileType == "doc" || $imageFileType == "docx") { ?>
                                                                <img src="../assets/comment_files/word.png" alt="">
                                                            <?php } else if($imageFileType == "pdf") {  ?>
                                                                <img src="../assets/comment_files/pdf.jpg" alt="">
                                                            <?php }else{ ?>
                                                                <img src="../assets/comment_files/<?php echo $file_name; ?>" alt="">
                                                            <?php } ?>
                                                            <div class="caption-overflow">
														<span>
															<a href="../assets/comment_files/<?php echo $file_name; ?>"
                                                               data-popup="lightbox" rel="gallery"
                                                               class="btn border-white text-white btn-flat btn-icon btn-rounded"><i
                                                                        class="icon-plus3" style="color: #fff"></i></a>
														</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    </p>
                                                <?php } ?>
                                                <p class="small mb-0">
                                                    <?php echo $fullnnm;?> - <?php echo $comment_date;?>
                                                </p>
                                                <hr>


                                            <?php } ?>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>

<!--//to close the form-->
<script>
    var comment = document.querySelector('#scroll');
    comment.scrollTop = comment.scrollHeight - comment.clientHeight;
</script>

<script>
    let flag = document.getElementById('r_flag').value;
    if(flag == '0')
    {
        document.getElementById('save').disabled = true;
        document.getElementById('com_file').disabled = true;
        document.getElementById('send').disabled = true;
        document.getElementById('username').disabled = true;
        document.getElementById('pin').disabled = true;
        document.getElementById('enter-message').disabled = true;

    }else{}
</script>

<!--update the filename to database-->

</body>
