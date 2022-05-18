<?php
include("../config.php");
include("../config/pn_config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
		header($redirect_tab_logout_path);
	} else {
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
	if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
		header($redirect_tab_logout_path);
	} else {
		header($redirect_logout_path);
	}

//	header('location: ../logout.php');
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user") {
	header('location: ../dashboard.php');
}
$s_event_id = $_GET['station_event_id'];
$station = $_GET['station'];

$station_event_id = $s_event_id;
//$station_event_id = base64_decode(urldecode($s_event_id));
$sqlmain = "SELECT * FROM `sg_station_event` where `station_event_id` = '$s_event_id'";
$resultmain = mysqli_query($db, $sqlmain);
$rowcmain = mysqli_fetch_array($resultmain);
$part_family = $rowcmain['part_family_id'];
$part_number = $rowcmain['part_number_id'];

$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
$resultnumber = mysqli_query($db, $sqlnumber);
$rowcnumber = mysqli_fetch_array($resultnumber);
$pm_part_number = $rowcnumber['part_number'];
$pm_part_name = $rowcnumber['part_name'];

$sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
$resultfamily = mysqli_query($db, $sqlfamily);
$rowcfamily = mysqli_fetch_array($resultfamily);
$pm_part_family_name = $rowcfamily['part_family_name'];

$sqlaccount = "SELECT * FROM `part_family_account_relation` where `part_family_id` = '$part_family'";
$resultaccount = mysqli_query($db, $sqlaccount);
$rowcaccount = mysqli_fetch_array($resultaccount);
$account_id = $rowcaccount['account_id'];

$sqlcus = "SELECT * FROM `cus_account` where `c_id` = '$account_id'";
$resultcus = mysqli_query($db, $sqlcus);
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
		<?php echo $sitename; ?> |Material tracability</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"></script>
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
                display: block !important;
            }

            .bg-white {
                background-color: #191e3a !important;
                height: 30px;
            }

            .shadow-sm {
                box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            }

            .d-none {
                display: none !important;
            }

            @media (min-width: 992px) {
                .navbar-expand-lg {
                    flex-wrap: nowrap;
                    justify-content: flex-start;
                }

            }
            #preview {
                padding-top: 20px;
            }

            .sidebar-default .navigation li > a {
                color: #f5f5f5;
            }

            label.col-lg-2.control-label {
                font-size: 16px;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {

                font-size: 16px;
            }

            .item_label {
                font-size: 16px;
            }

            .sidebar-default .navigation li > a:focus,
            .sidebar-default .navigation li > a:hover {
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

            .contextMenu {
                position: absolute;
                width: min-content;
                left: -18px;
                background: #e5e5e5;
                z-index: 999;
            }

            .red {
                color: red;
                display: none;
            }

            .remove_btn {
                float: right;
                width: 2%;
            }

            input.select2-search__field {
                width: auto !important;

            }

            .collapse.in {
                display: block !important;
            }

            .select2-search--dropdown .select2-search__field {
                padding: 4px;
                width: 100% !important;
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
                width: 38% !important;
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
            margin-top: -4px !important;
            margin-right: 0.3125rem;
            margin-left: 10px !important;
        }

        .panel-heading > .dropdown .dropdown-toggle, .panel-title, .panel-title > .small, .panel-title > .small > a, .panel-title > a, .panel-title > small, .panel-title > small > a {
            color: inherit !important;
        }

        .item_label {
            margin-bottom: 0px !important;
            margin-right: 10px !important;
        }

        .select2-selection--multiple {
            border: 1px solid transparent !important;
        }

        .input-group-append {
            width: 112%;
        }

        input[type="file"] {
            display: block;
        }

        .imageThumb {
            max-height: 100px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }

        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }

        .remove {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }

        .remove:hover {
            background: white;
            color: black;
        }

        /*#rej_fail {*/
        /*    display: none;*/
        /*}*/

    </style>
</head>

<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Material Tracabilty";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
include("../cell_new_page.php");

?>
<!-- /main navbar -->
<!-- Page container -->
<div class="section-container">
<div class="page-container">
    <!-- Page content -->
	<?php
	$st = $_REQUEST['station'];
	//$st_dashboard = base64_decode(urldecode($st));
	$sql1 = "SELECT * FROM `cam_line` where line_id = '$st'";
	$result1 = $mysqli->query($sql1);
	//                                            $entry = 'selected';
	while ($row1 = $result1->fetch_assoc()) {
		$line_name = $row1['line_name'];
		$line_no = $row1['line_id'];


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
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span></button>
                        <span class="text-semibold">Group</span> Created Successfully.
                    </div>
				<?php } ?>
				<?php if ($temp == "two") { ?>
                    <br/>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span></button>
                        <span class="text-semibold">Group</span> Updated Successfully.
                    </div>
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
                        <form action="material_backend.php" id="material_setting" enctype="multipart/form-data"
                              class="form-horizontal" method="post">
                            <div class="row">
                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Station : </label>
                                <div class="col-md-6">
									<?php $form_id = $_GET['id'];
									//$station_event_id = base64_decode(urldecode($station_event_id)); ?>
                                    <input type="hidden" name="station_event_id"
                                           value="<?php echo $station_event_id ?>">
                                    <input type="hidden" name="customer_account_id" value="<?php echo $account_id ?>">
                                    <input type="hidden" name="station" value="<?php echo $st; ?>">
                                    <input type="hidden" name="line_number" value="<?php echo $line_no; ?>">
                                    <input type="text" name="line_number1" id="line_number"
                                           value="<?php echo $line_name ?>" class="form-control"
                                           placeholder="Enter Line Number">
                                </div>
                                <div id="error1" class="red">Line Number</div>
                            </div>
                            <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Number : </label>
                                <div class="col-md-6">
                                    <input type="hidden" name="part_number" value="<?php echo $part_number; ?>">
                                    <input type="text" name="part_number1" id="part_number"
                                           value="<?php echo $pm_part_number; ?>" class="form-control"
                                           placeholder="Enter Part Number">
                                </div>
                                <div id="error1" class="red">Part Number</div>
                            </div>
                            <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Family : </label>
                                <div class="col-md-6">
                                    <input type="hidden" name="part_family" value="<?php echo $part_family; ?>">
                                    <input type="text" name="part_family1" id="part_family"
                                           value="<?php echo $pm_part_family_name; ?>" class="form-control"
                                           placeholder="Enter Part Family">
                                </div>
                                <div id="error1" class="red">Part family</div>
                            </div>
                            <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Name : </label>
                                <div class="col-md-6">
                                    <!--                                    <input type="hidden" name="part_name" value="-->
									<?php //echo $part_family; ?><!--">-->
                                    <input type="text" name="part_name" id="part_name"
                                           value="<?php echo $pm_part_name; ?>" class="form-control"
                                           placeholder="Enter Part Name">
                                </div>
                                <div id="error1" class="red">Part Name</div>
                            </div>
                            <br/>


                            <div class="row">
                                <label class="col-lg-2 control-label">Material type : </label>
                                <div class="col-md-6">
                                    <select name="material_type" id="material_type" class="select" data-style="bg-slate"
                                    /required>
                                    <option value="" selected disabled>--- Select material Type ---</option>
									<?php
									$sql1 = "SELECT material_id, material_type FROM `material_config`";
									$result1 = mysqli_query($db, $sql1);
									while ($row1 = $result1->fetch_assoc()) {

										echo "<option value='" . $row1['material_id'] . "'>" . $row1['material_type'] . "</option>";

									}
									?>
                                    </select>
                                </div>
                            </div>
                            <div id="error6" class="red">Please Enter Material Type</div>
                            <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label">Image : </label>
                                <div class="col-md-6">
                                    <input type="file" name="image[]" id="file-input" class="form-control" multiple
                                           required>
                                    <!--                                    <div id="preview"></div>-->
                                </div>

                            </div>
                            <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Serial Number
                                    : </label>
                                <div class="col-md-6">
                                    <input type="number" name="serial_number" id="serial_number" class="form-control"
                                           placeholder="Enter Serial Number" required>
                                </div>
                                <div id="error1" class="red">Part Name</div>
                            </div>
                            <br/>

                            <div class="row">
                                <label class="col-lg-2 control-label">Material Status : </label>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="pass" name="material_status" value="1"
                                               class="form-check-input" checked required>
                                        <label for="pass" class="item_label">Pass</label>

                                        <input type="radio" id="fail" name="material_status" value="0"
                                               class="form-check-input reject" required>
                                        <label for="fail" class="item_label">Fail</label>


                                    </div>

                                </div>
                                <div id="error7" class="red">Please Enter material Status</div>

                            </div>
                            <br/>
                            <div id="rej_fail" style="display: none;">

                            </div>
                            <div class="row">
                                <label class="col-lg-2 control-label">Notes : </label>
                                <div class="col-md-6">
                                    <textarea id="notes" name="material_notes" rows="4" placeholder="Enter Notes..."
                                              class="form-control"></textarea>
                                </div>
                            </div>
                            <br/>
                            <hr/>
                            <br/>
                    </div>
                </div>
            </div>


            <div class="panel-footer p_footer">
                <button type="submit" id="form_submit_btn" class="btn btn-primary submit_btn"
                        style="background-color:#1e73be;">Submit
                </button>
            </div>
            </form>


        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $('.select').select2();
    });
</script>
<script>
    $("#file-input").on("change", function (e) {
        var files = e.target.files,
            filesLength = files.length;

        const boxes = document.querySelectorAll('.pip');

        boxes.forEach(box => {
            box.remove();
        });
        var tot = e.currentTarget.attributes.length;
        var ij = tot - filesLength + 1;
        for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function (e) {

                var id_text = 'pip_' + (ij++);
                var file = e.target;
                $("<span class=\"pip\">" +
                    "<img id='" + id_text + "' class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "<br/></span>").insertAfter("#file-input");
                $(".remove").click(function () {
                    $(this).parent(".pip").remove();
                });
            });
            fileReader.readAsDataURL(f);
        }
    });
</script>

<script>

    $(document).on("click", ".submit_btn", function () {
        var line_number = $("#line_number").val();
        var material_type = $("#material_type").val();
        var material_status = $("#material_status").val();
    });

</script>
<script>
    $("input[name$='material_status']").click(function () {
        var test = $(this).val();
        //    console.log(test);
        var z = document.getElementById("rej_fail");
        if ((test === "0") && (z.style.display === "none")) {
            z.style.display = "block";
            z.innerHTML = '<div class="row desc" id="Reason0">\n' +
                '                                    <label class="col-lg-2 control-label">Reason : </label>\n' +
                '                                    <div class="col-md-6">\n' +
                '                                        <select name="reason" id="reason" required class="select form-control"\n' +
                '                                                data-style="bg-slate">\n' +
                '                                            <option value="Reject" selected >Reject</option>\n' +
                '                                            <option value="Hold" >On Hold</option>\n' +
                '                                        </select>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <br/>\n' +
                '                                <div class="row desc" id="quantity0">\n' +
                '                                    <label class="col-lg-2 control-label"> Quantity : </label>\n' +
                '                                    <div class="col-md-6">\n' +
                '                                        <input class="form-control" name="quantity" rows="1" id="quantity" required>\n' +
                '                                    </div>\n' +
                '\n' +
                '                                </div>\n' +
                '                                <br/>';
        } else if (test === "1") {
            z.style.display = "none";
            z.innerHTML = '';
        }
    });
</script>


<?php include('../footer.php') ?>

</body>

</html>