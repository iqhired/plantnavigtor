<?php
include("../config.php");
include("../config/pn_config.php");
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


$idddd = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
	, $_SERVER["HTTP_USER_AGENT"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
		<?php echo $sitename; ?> |10x</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


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
        .form-control[disabled], fieldset[disabled] .form-control {
            background-color: #eee;
        }
        #line_number1 , #part_number1 , #part_family1 , #part_name , #material_type{
            pointer-events: none;
            background-color: #efefef;
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
        .create {
            float: right;
            padding: 12px;

        }

    </style>
</head>

<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "10x";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
	<?php


	$id = $_GET['id'];

	$querymain = sprintf("SELECT * FROM `10x` where 10x_id = '$id' ");
	$qurmain = mysqli_query($db, $querymain);
	while ($rowcmain = mysqli_fetch_array($qurmain)) {
		$line_no = $rowcmain['line_no'];
		$station_event_id = $rowcmain['station_event_id'];
		$x_id = $rowcmain['10x_id'];
		$part_number = $rowcmain['part_no'];
		$part_family = $rowcmain['part_family_id'];
		$pm_part_name = $rowcmain['part_name'];

		$notes = $rowcmain['notes'];
		$created_at = $rowcmain['created_at'];

		$sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
		$resultfamily = mysqli_query($db, $sqlfamily);
		$rowcfamily = mysqli_fetch_array($resultfamily);
		$pm_part_family_name = $rowcfamily['part_family_name'];

		$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
		$resultnumber = mysqli_query($db, $sqlnumber);
		$rowcnumber = mysqli_fetch_array($resultnumber);
		$pm_part_number = $rowcnumber['part_number'];
		$pm_part_name = $rowcnumber['part_name'];

		$sqlnumber = "SELECT * FROM `cam_line` where `line_id` = '$line_no'";
		$resultnumber = mysqli_query($db, $sqlnumber);
		$rowcnumber = mysqli_fetch_array($resultnumber);
		$line_name = $rowcnumber['line_name'];
		$_SESSION['edit_10x_id'] = $id;

		$station_event_id = $_GET['station_event_id'];
		?>
        <!--    <div class="col-md-2 create">-->
        <!--        <a href="--><?php //echo $siteURL; ?><!--10x/10x_search.php?station=--><?php //echo $line_no; ?><!--&station_event_id=--><?php //echo $station_event_id;?><!--">-->
        <!--            <button type="submit" id="create" class="btn btn-primary" style="background-color: #009688;float:right">View 10x </button>-->
        <!--        </a>-->
        <!--    </div>-->
        <!-- Content area -->
        <div class="content" style="padding: 70px 30px !important;">
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
					if (!empty($_SESSION['import_status_message'])) {
						echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
						$_SESSION['message_stauts_class'] = '';
						$_SESSION['import_status_message'] = '';
					}
					?>


                    <div class="row">
                        <div class="col-md-12">
                            <form action="edit_10x_backend.php" id="10x_setting" enctype="multipart/form-data" class="form-horizontal" method="post">
                                <div class="row">
                                    <label class="col-lg-2 control-label" style="padding-top: 10px;">Station : </label>
                                    <div class="col-md-6">

                                        <input type="hidden" name="10x_id" id="10x_id" value="<?php echo $x_id ?>">
                                        <input type="hidden" name="station_event_id" value="<?php echo $station_event_id ?>">
                                        <input type="hidden" name="line_number" id="line_number" value="<?php echo $line_no; ?>">
                                        <input type="text" name="line_number1" id="line_number1"  value="<?php echo $line_name ?>" class="form-control" placeholder="Enter Line Number">
                                    </div>
                                    <div id="error1" class="red">Line Number</div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Number : </label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="part_number" id="part_number"  value="<?php echo $part_number; ?>">
                                        <input type="text" name="part_number1" id="part_number1"  value="<?php echo $pm_part_number; ?>" class="form-control" placeholder="Enter Part Number">
                                    </div>
                                    <div id="error1" class="red">Part Number</div>
                                </div>
                                <br/>   <div class="row">
                                    <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Family : </label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="part_family" id="part_family"  value="<?php echo $part_family; ?>">
                                        <input type="text" name="part_family1" id="part_family1"  value="<?php echo $pm_part_family_name; ?>" class="form-control" placeholder="Enter Part Family">
                                    </div>
                                    <div id="error1" class="red">Part family</div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Name : </label>
                                    <div class="col-md-6">
                                        <input type="text" name="part_name" id="part_name"  value="<?php echo $pm_part_name; ?>" class="form-control" placeholder="Enter Part Name">
                                    </div>
                                    <div id="error1" class="red">Part Name</div>
                                </div>
                                <br/>

                                <div class="row">
                                    <label class="col-lg-2 control-label">Image : </label>
                                    <div class="col-md-6">
										<?php if($idddd == 0){?>
                                            <div id="my_camera"></div>
                                            <br/>
                                            <input type="button" class="btn btn-primary " value="Take Snapshot" onClick="take_snapshot(<?php echo $x_id?>)">
                                            <input type="hidden" name="image" id="image" class="image-tag" accept="image/*,capture=camera"/>
										<?php } ?>
									<?php if($idddd != 0){?>
                                            <div style ="display:none" id="my_camera"></div>
                                            <label for="file-input" class="btn btn-primary ">Take Snapshot</label>
                                            <input type="file" name="edit_image[]" id="file-input" class="image-tag" multiple accept="image/*;capture=camera" capture="environment" value="Take Snapshot" style="display: none"/>

<!--                                            <input type="file" name="edit_image[]" id="file-input" accept="image/*;capture=camera" capture="environment"  multiple="multiple" value="Take Snapshot" style="display: none">-->
                                            <div class="container"></div>
										<?php } ?>
                                    </div>
                                </div>
                                <div class="row" style="display: none">
                                    <label class="col-lg-2 control-label">Captured Image : </label>
                                    <div class="col-md-6">
                                        <div id="results"></div>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Previous Image : </label>
                                    <div class="col-md-6">
										<?php
//										$query1 = sprintf("SELECT 10x_id FROM  10x where 10x_id = '$id'");
										$item_id = $x_id;

//										$query2 = sprintf("SELECT * FROM  10x_images where 10x_id = '$item_id'");
										$query2 = sprintf("SELECT * FROM `10x_images` where 10x_id = '$item_id'");

										$qurimage = mysqli_query($db, $query2);
										$i =0 ;
										while ($rowcimage = mysqli_fetch_array($qurimage)) {
											$image = $rowcimage['image_name'];
											$d_tag = "delete_image_" . $i;
											$r_tag = "remove_image_" . $i;
											?>

                                            <div class="col-lg-3 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
                                                        <img src="../assets/images/10x/<?php echo $item_id; ?>/<?php echo $image; ?>"
                                                             alt="">
                                                        <input type="hidden"  id="<?php echo $d_tag; ?>" name="<?php echo $d_tag; ?>" class="<?php echo $d_tag; ?>>" value="<?php echo $rowcimage['10x_images_id']; ?>">
                                                        <span class="remove remove_image" id="<?php echo $r_tag; ?>">Remove Image </span>
                                                    </div>
                                                </div>
                                            </div>
											<?php
											$i++;} ?>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <!--<div class="col-md-4">-->
                                    <label class="col-lg-2 control-label">Notes : </label>
                                    <div class="col-md-6">
                                        <textarea id="notes" name="10x_notes" rows="4" placeholder="Enter Notes..." value =" <?php echo $notes;?>" class="form-control"><?php echo $notes;?></textarea>
                                    </div>
                                </div>
                                <br/>

                                <hr/>



                                <br/>

                        </div>
                    </div>
                </div>


                <div  class="panel-footer p_footer">
                    <button type="submit" id="form_submit_btn" class="btn btn-primary submit_btn" style="background-color:#1e73be;">Update</button>
                </div>
                </form>


            </div>

        </div>
	<?php } ?>
</div>

<!-- Configure a few settings and attach camera -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>
    Webcam.set({
        width: 290,
        height: 190,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    var camera = document.getElementById("my_camera");
    Webcam.attach( camera );
</script>
<script language="JavaScript">
    function take_snapshot(id) {
        Webcam.snap( function(data_uri) {
            var formData =  $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            $.ajax({
                url: "webcam_backend.php?10x_id="+id,
                type: "POST",
                data: formData,
                success: function () {
                    window.location.reload()
                },

            });

        } );
    }
</script>

<script>
    $(document).ready(function() {
        $('.select').select2();
    });
</script>

<script>
    $(document).on('click', '.remove_image', function () {
        var del_id = this.id.split("_")[2];
        var x_img_id = this.parentElement.childNodes[3].value;
        var info =  document.getElementById("delete_image"+del_id);
        var info =  "id="+del_id+"&10x_id="+ x_img_id;
        $.ajax({
            type: "POST",
            url: "delete_10x_image.php",
            data: info,
            success: function (data) {
            }
        });
        window.location.reload()
    });
</script>
<script>

    $("#file-input").on("change", function(e) {
        var files = e.target.files,
            filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
                var file = e.target;
                $("<span class=\"pip\">" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "<br/><span class=\"remove\">Remove image</span>" +
                    "</span>").insertAfter("#file-input");
                $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                });



            });
            fileReader.readAsDataURL(f);
        }
    });

</script>

<script>
    function group1()
    {
        $("#out_of_tolerance_mail_list").select2("open");
    }
    function group2()
    {
        $("#out_of_control_list").select2("open");
    }




</script>


<?php include('../footer.php') ?>

</body>

</html>