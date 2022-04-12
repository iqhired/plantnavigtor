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
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" ) {
    header('location: ../dashboard.php');
}
$s_event_id = $_GET['station_event_id'];
$station_event_id = base64_decode(urldecode($s_event_id));
$sqlmain = "SELECT * FROM `sg_station_event` where `station_event_id` = '$station_event_id'";
$resultmain = mysqli_query($db,$sqlmain);
$rowcmain = mysqli_fetch_array($resultmain);
$part_family = $rowcmain['part_family_id'];
$part_number = $rowcmain['part_number_id'];

$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
$resultnumber = mysqli_query($db,$sqlnumber);
$rowcnumber = mysqli_fetch_array($resultnumber);
$pm_part_number = $rowcnumber['part_number'];
$pm_part_name = $rowcnumber['part_name'];

$sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
$resultfamily = mysqli_query($db,$sqlfamily);
$rowcfamily = mysqli_fetch_array($resultfamily);
$pm_part_family_name = $rowcfamily['part_family_name'];

$sqlaccount = "SELECT * FROM `part_family_account_relation` where `part_family_id` = '$part_family'";
$resultaccount = mysqli_query($db,$sqlaccount);
$rowcaccount = mysqli_fetch_array($resultaccount);
$account_id = $rowcaccount['account_id'];

$sqlcus = "SELECT * FROM `cus_account` where `c_id` = '$account_id'";
$resultcus =mysqli_query($db,$sqlcus);
$rowccus = mysqli_fetch_array($resultcus);
$cus_name = $rowccus['c_name'];
$logo = $rowccus['logo'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $sitename; ?> |document</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!--    <link rel=stylesheet href=https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css>-->
    <!--    <link rel=stylesheet href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css>-->

    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
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



    <style>

        @media (min-width: 576px)
            .d-sm-block {
                display: block!important;
            }
            .bg-white {
                background-color: #191e3a!important;
                height: 30px;
            }
            .shadow-sm {
                box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
            }
            .d-none {
                display: none!important;
            }
            @media (min-width: 992px){
                .navbar-expand-lg {
                    flex-wrap: nowrap;
                    justify-content: flex-start;
                }

            }
            #preview {
                padding-top: 20px;
            }
            .sidebar-default .navigation li>a {
                color: #f5f5f5;
            }
            label.col-lg-2.control-label{
                font-size: 16px;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {

                font-size: 16px;
            }
            .item_label {
                font-size: 16px;
            }

            .sidebar-default .navigation li>a:focus,
            .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
            }

            .form-control:focus {
                border-color: transparent transparent #1e73be !important;
                -webkit-box-shadow: 0 1px 0 #1e73be;
                box-shadow: 0 1px 0 #1e73be !important;
            }

            .form-control {
                border-color: transparent transparent #1e73be;
                border-radius: 0;
                -webkit-box-shadow: none;
                box-shadow: none;
                font-size: 16px;
            }

            span.select2-selection.select2-selection--multiple {
                border-bottom: 1px solid #1b2e4b !important;
            }
            .select2-selection--multiple:not([class*=bg-]):not([class*=border-]) {
                border-color: #1b2e4b;
            }

            .contextMenu{ position:absolute;  width:min-content; left: -18px; background:#e5e5e5; z-index:999;}

            .red {
                color: red;
                display: none;
            }
            .remove_btn {
                float: right;
                width: 2%;
            }
            input.select2-search__field {
                width: auto!important;

            }
            .collapse.in {
                display: block!important;
            }
            .select2-search--dropdown .select2-search__field {
                padding: 4px;
                width: 100%!important;
                box-sizing: border-box;
            }
        }

        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {

            .col-md-0\.5 {
                float: right;
                width: 5%;
            }
            .col-md-6 {
                width: 60%;
                float: left;
            }
            .col-lg-2 {
                width: 38%!important;
                float: left;

            }

            .col-md-3 {
                width: 30%;
                float: left;
            }
            .form-check.form-check-inline {
                width: 70%;
            }

        }

        .form-check-inline .form-check-input {
            position: static;
            margin-top: -4px!important;
            margin-right: 0.3125rem;
            margin-left: 10px!important;
        }
        .panel-heading>.dropdown .dropdown-toggle, .panel-title, .panel-title>.small, .panel-title>.small>a, .panel-title>a, .panel-title>small, .panel-title>small>a {
            color: inherit !important;
        }
        .item_label{
            margin-bottom: 0px !important;
            margin-right: 10px !important;
        }
        .select2-selection--multiple {
            border: 1px solid transparent !important;
        }
        .input-group-append {
            width: 112%;
        }

    </style>
</head>

<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Plantnavigator Documents";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <?php
    $st = $_REQUEST['station'];
    $st_dashboard = base64_decode(urldecode($st));
    $sql1 = "SELECT * FROM `cam_line` where line_id = '$st_dashboard'";
    $result1 = $mysqli->query($sql1);
    //                                            $entry = 'selected';
    while ($row1 = $result1->fetch_assoc()) {
        $line_name = $row1['line_name'];
    }
    ?>
    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">

                <?php if ($temp == "one") { ?>
                    <br/>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button> <span class="text-semibold">Group</span> Created Successfully. </div>
                <?php } ?>
                <?php if ($temp == "two") { ?>
                    <br/>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button> <span class="text-semibold">Group</span> Updated Successfully. </div>
                <?php } ?>
                <?php
                if (!empty($import_status_message)) {
                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                }
                ?>
                <?php
                if (!empty($_SESSION[import_status_message])) {
                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                    $_SESSION['message_stauts_class'] = '';
                    $_SESSION['import_status_message'] = '';
                }
                ?>


                <div class="row">
                    <div class="col-md-12">
                        <form action="document_backend.php" id="document_setting" enctype="multipart/form-data" class="form-horizontal" method="post">

                            <div class="row">
                                <label class="col-lg-2 control-label">Document file : </label>
                                <div class="col-md-6">
                                    <input type="file" name="file[]" id="file-input" class="form-control" required>
                                    <div id="preview"></div>
                                </div>

                            </div>
                            <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Document Name : </label>
                                <div class="col-md-6">
                                    <input type="text" name="doc_name" id="doc_name" class="form-control" placeholder="Enter Doc name" required>
                                </div>
                                <div id="error1" class="red">Document Name</div>
                            </div>
                            <br/>

                            <div class="row">
                                <label class="col-lg-2 control-label">station : </label>
                                <div class="col-md-6">
                                    <select name="station" id="station" class="select" data-style="bg-slate">
                                        <option value="" selected disabled>--- Select station ---</option>
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
                                            echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="error6" class="red">Please Enter station</div>
                            <br/>

                            <div class="row">
                                <label class="col-lg-2 control-label">Document Type : </label>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="pass" name="doc_type" value ="station" class="form-check-input" checked required>
                                        <label for="pass" class="item_label">Station</label>

                                        <input type="radio" id="fail" name="doc_type"  value ="part_number" class="form-check-input reject" required>
                                        <label for="fail" class="item_label">Part Number</label>


                                    </div>

                                </div>
                                <div id="error7" class="red">Please select station or part number</div>

                            </div>
                            <br/>




                            <div class="row desc" id="Carspart_number" style="display: none;">
                                <div class="row">

                                    <label class="col-lg-2 control-label" style="margin-left: 10px;">Part Family *  :</label>

                                    <div class="col-md-6">
                                        <select name="part_family" id="part_family" class="select" data-style="bg-slate" >
                                            <option value="" selected disabled>--- Select Part Family ---</option>
                                            <?php
                                            $st_dashboard = $_POST['part_family'];
                                            $station = $_POST['station'];
                                            $ss = (isset($station)?' and station = ' . $station : '');
                                            $sql1 = "SELECT * FROM `pm_part_family` where is_deleted = 0" . $ss;
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if($st_dashboard == $row1['pm_part_family_id'])
                                                {
                                                    $entry = 'selected';
                                                }
                                                else
                                                {
                                                    $entry = '';

                                                }
                                                echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">


                                    <label class="col-lg-2 control-label" style="margin-left: 10px;">Part Number *  :</label>

                                    <div class="col-md-6">
                                        <select name="part_number" id="part_number" class="select" data-style="bg-slate" >
                                            <option value="" selected disabled>--- Select Part Number ---</option>
                                            <?php
                                            $st_dashboard = $_POST['part_number'];
                                            $part_family = $_POST['part_family'];
                                            $sql1 = "SELECT * FROM `pm_part_number` where part_family = '$part_family' and is_deleted = 0 ";
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if($st_dashboard == $row1['pm_part_number_id'])
                                                {
                                                    $entry = 'selected';
                                                }
                                                else
                                                {
                                                    $entry = '';

                                                }
                                                echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] ." - ".$row1['part_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label">Status : </label>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="active" name="status" value="active" class="form-check-input" checked required>
                                        <label for="pass" class="item_label">Active</label>

                                        <input type="radio" id="inactive" name="status" value="inactive" class="form-check-input reject" required>
                                        <label for="fail" class="item_label">Inactive</label>


                                    </div>

                                </div>
                                <div id="error7" class="red">Please select station or part number</div>

                            </div>
                            <br/>


                            <div class="row">
                                <!--<div class="col-md-4">-->
                                <label class="col-lg-2 control-label">Expiry Date : </label>
                                <div class="col-md-6">
                                    <input type="date" name="exp_date" id="exp_date"  class="form-control"  required>
                                </div>
                            </div>
                            <br/>

                            <hr/>



                            <br/>

                    </div>
                </div>
            </div>


            <div  class="panel-footer p_footer">
                <button type="submit" id="form_submit_btn" class="btn btn-primary submit_btn" style="background-color:#1e73be;">Submit</button>
            </div>
            </form>


        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('.select').select2();
    });
</script>

<script>
    $('#station').on('change', function (e) {
        $("#document_setting").submit();
    });
    $('#part_family').on('change', function (e) {
        $("#document_setting").submit();
    });
    function group1()
    {
        $("#out_of_tolerance_mail_list").select2("open");
    }
    function group2()
    {
        $("#out_of_control_list").select2("open");
    }

    $(document).on("click",".submit_btn",function() {
        //$("#form_settings").submit(function() {

        var line_number = $("#line_number").val();
        var material_type = $("#material_type").val();
        var material_status = $("#material_status").val();



    });


    //image preview

    function previewImages() {


        $("#preview").html(" ");

        var preview = document.querySelector('#preview');

        if (this.files) {
            [].forEach.call(this.files, readAndPreview);
        }

        function readAndPreview(file) {

            // Make sure `file.name` matches our extensions criteria
            if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                return alert(file.name + " is not an image");
            } // else...

            var reader = new FileReader();

            reader.addEventListener("load", function() {
                var image = new Image();
                image.height = 100;
                image.title  = file.name;
                image.src    = this.result;
                preview.appendChild(image);
            });

            reader.readAsDataURL(file);

        }

    }

    document.querySelector('#file-input').addEventListener("change", previewImages);


</script>
<script>
    $(document).ready(function() {
        $("input[name$='doc_type']").click(function() {
            var test = $(this).val();
            //    console.log(test);
            $("div.desc").hide();
            $("#Cars" + test).show();

        });
    });
</script>


<?php include('../footer.php') ?>

</body>

</html>