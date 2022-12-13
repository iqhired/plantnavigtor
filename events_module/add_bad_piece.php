<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	header('location: ../logout.php');
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

$i = $_SESSION["role_id"];
//if ($i != "super" && $i != "admin") {
//    header('location: ../dashboard.php');
//}
$station_event_id = $_GET['station_event_id'];
$sqlmain = "SELECT * FROM `sg_station_event` where `station_event_id` = '$station_event_id'";
$resultmain = $mysqli->query($sqlmain);
$rowcmain = $resultmain->fetch_assoc();
$part_family = $rowcmain['part_family_id'];
$part_number = $rowcmain['part_number_id'];
$p_line_id = $rowcmain['line_id'];

$sqlprint = "SELECT * FROM `cam_line` where `line_id` = '$p_line_id'";
$resultnumber = $mysqli->query($sqlprint);
$rowcnumber = $resultnumber->fetch_assoc();
$printenabled = $rowcnumber['print_label'];
$p_line_name = $rowcnumber['line_name'];
$individualenabled = $rowcnumber['indivisual_label'];


$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
$resultnumber = $mysqli->query($sqlnumber);
$rowcnumber = $resultnumber->fetch_assoc();
$pm_part_number = $rowcnumber['part_number'];
$pm_part_name = $rowcnumber['part_name'];
$pm_npr= $rowcnumber['npr'];
$defect_list_id = $_GET['defect_list_id'];



$gp_timestamp = time();
$idddd = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
	, $_SERVER["HTTP_USER_AGENT"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> |Add bad piece</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


    <!--scan the qrcode -->

    <style>
        .sidebar-default .navigation li>a{color:#f5f5f5};
        a:hover {
            background-color: #20a9cc;
        }
        .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
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
        }  @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-sm-2 {
                width: 10.66666667%;
            }
            .col-lg-2 {
                width: 28%!important;
                float: left;
            }
            .col-md-6 {
                width: 60%;
                float: left;
            }
            .col-lg-1 {
                width: 12%;
                float: right;
            }
        }
        input[type="file"] {
            display: block;
        }

        .container {
            margin: 0 auto;
        }

        .content_img {
            width: 113px;
            float: left;
            margin-right: 5px;
            border: 1px solid gray;
            border-radius: 3px;
            padding: 5px;
            margin-top: 10px;
        }

        /* Delete */
        .content_img span {
            border: 2px solid red;
            display: inline-block;
            width: 99%;
            text-align: center;
            color: red;
        }

        .content_img span:hover {
            cursor: pointer;
        }
        #results { padding:20px; border:1px solid; background:#ccc; }
    </style>
</head>
<body onload="openScanner()">
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Add Bad Piece";
include("../header_folder.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->

    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Add Bad Piece</h5><br/>
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="bad_form" enctype="multipart/form-data"
                              class="form-horizontal" method="post">
							<?php
							$cell_id = $_GET['cell_id'];
							$cell_name = $_GET['c_name'];

							$sql1 = "SELECT * FROM `defect_list` where  defect_list_id = '$defect_list_id'";
							$result1 = $mysqli->query($sql1);
							while ($row1 = $result1->fetch_assoc()) {

							$defect_list_name = $row1['defect_list_name'];
							?>
                            <input type="hidden" name="station_event_id" value="<?php echo $station_event_id; ?>" >
                            <input type="hidden" name="edit_seid" value="<?php echo $station_event_id; ?>">
                            <input type="hidden" name="line_id" value="<?php echo $p_line_id; ?>">
                            <input type="hidden" name="pe" value="<?php echo $printenabled; ?>">
                            <input type="hidden" name="time" value="<?php echo time(); ?>">
                            <input type="hidden" name="line_name" value="<?php echo $p_line_name; ?>">
                            <input type="hidden" name="ipe" value="<?php echo $individualenabled; ?>">

                            <input type="hidden" name="cell_id" value="<?php echo $cell_id; ?>">
                            <input type="hidden" name="c_name" value="<?php echo $cell_name; ?>">

                            <div class="row">
                                <label class="col-lg-2 control-label">Select Type * : </label>
                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label class="radio-inline">
                                            <input type="radio" name="bad_type" value="bad_piece" class="styled" checked="checked">
                                            Bad Piece
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="radio-inline">
                                            <input type="radio" name="bad_type" value="rework" class="styled">
                                            Re-Work
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br/>


                            <div class="row"  id="badpiece">
                                <label class="col-lg-2 control-label">Defect Name * : : </label>
                                <div class="col-md-6">
                                    <input type="text" name="add_defect_name" id="add_defect_name" class="form-control" value="<?php echo $defect_list_name; ?>" readonly>
                                </div>
                            </div>
                            <br/>


                            <div class="row">
                                <label class="col-lg-2 control-label">No of Pieces : </label>
                                <div class="col-md-6">
                                    <input type="number" name="good_bad_piece_name" id="good_bad_piece_name" class="form-control" placeholder="Enter Pieces..." value="1" required>
                                </div>
                            </div>
                            <br/>

                            <div class="row">
                                <label class="col-lg-2 control-label">Image : </label>
                                <div class="col-md-6">
									<?php if(($idddd == 0)){?>
                                        <div id="my_camera"></div>
                                        <br/>
                                        <input type=button class="btn btn-primary" value="Take Snapshot" onClick="take_snapshot()">
                                        <input type="hidden" name="image" id="image" class="image-tag" accept="image/*,capture=camera"/>
									<?php } ?>
									<?php if(($idddd != 0)){?>
                                        <div style="display:none;" id="my_camera"></div>
                                        <label for="file" class="btn btn-primary ">Take Snapshot</label>
                                        <input type="file" name="image" id="file" class="image-tag" multiple accept="image/*;capture=camera" capture="environment" value="Take Snapshot" style="display: none"/>
                                        <!-- <div class="container"></div>-->
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
                                    <div class="container"></div>
									<?php
									$time_stamp = $_SESSION['good_timestamp_id'];
									if(!empty($time_stamp)){
                                        $query2 = sprintf("SELECT * FROM good_piece_images where bad_piece_id = '$time_stamp'");

										$qurimage = mysqli_query($db, $query2);
										$i =0 ;
										while ($rowcimage = mysqli_fetch_array($qurimage)) {
											$image = $rowcimage['good_image_name'];
											$mime_type = "image/gif";
											$file_content = file_get_contents("$image");
											$d_tag = "delete_image_" . $i;
											$r_tag = "remove_image_" . $i;
											?>

                                            <div class="col-lg-3 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
														<?php echo '<img src="' . $image . '" style="height:50px;width:150px;border: 1px solid #555;" alt=""/>'; ?>

                                                        <input type="hidden"  id="<?php echo $d_tag; ?>" name="<?php echo $d_tag; ?>" class="<?php echo $d_tag; ?> >" value="<?php echo $rowcimage['good_image_id']; ?>">
                                                        <span class="remove remove_image" id="<?php echo $r_tag; ?>">Remove Image </span>
                                                    </div>
                                                </div>
                                            </div>
											<?php
											$i++;}
									}
									?>
                                </div>
                            </div>
                            <br/>
                            <hr/>

                    </div>
                </div>
            </div>


            <div class="panel-footer p_footer">
				<?php if(($idddd != 0) && ($printenabled == 1)){?>
                    <iframe height="100" id="resultFrame" style="display: none;" src="./pp.php"></iframe>
				<?php }?>
                <button type="submit" id="submitForm_bad" class="btn btn-primary submit_btn"
                        style="background-color:#1e73be;">Submit
                </button>

            </div>
			<?php } ?>
            </form>
        </div>
    </div>

</div>
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
<script>
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            var formData =  $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            $.ajax({
                url: "bad_piece_cam_backend.php",
                type: "POST",
                data: formData,
                success: function (msg) {
                    window.location.reload()
                },

            });
        });
    }
</script>

<script>
    $("#submitForm_bad").click(function (e) {

        // function submitForm_good(url) {
        // printing only rework not bad piece
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#bad_form").serialize();
        $.ajax({
            type: 'POST',
            url: 'create_good_bad_piece.php',
            data: data,
            cache: false,
            async: false,
            success: function (data) {
                console.log('wfe');
                var line_id = this.data.split('&')[2].split("=")[1];
                var pe = this.data.split('&')[3].split("=")[1];
                var ff2 = this.data.split('&')[4].split("=")[1];
                var deftype = this.data.split('&')[9].split("=")[1];
                var file2 = '../assets/label_files/' + line_id +'/b_'+ff2;
                if((pe == '1') && (deftype != 'bad_piece')){
                    document.getElementById("resultFrame").contentWindow.ss(file2);
                }
            }
        });
        history.replaceState("", "", "<?php echo $scriptName; ?>events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>");
    });

    // Upload
    $("#file").on("change", function () {
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file', files);
        fd.append('request', 1);

        // AJAX request
        $.ajax({
            url: 'add_delete_bad_piece_image.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response != 0) {
                    var count = $('.container .content_img').length;
                    count = Number(count) + 1;

                    // Show image preview with Delete button
                    $('.container').append("<div class='content_img' id='content_img_" + count + "' ><img src='" + response + "' width='100' height='100'><span class='delete' id='delete_" + count + "'>Delete</span></div>");
                }
            }
        });
    });


    // Remove file
    $('.container').on('click', '.content_img .delete', function () {

        var id = this.id;
        var split_id = id.split('_');
        var num = split_id[1];
        // Get image source
        var imgElement_src = $('#content_img_' + num)[0].children[0].src;
        //var deleteFile = confirm("Do you really want to Delete?");
        var succ = false;
        // AJAX request
        $.ajax({
            url: 'add_delete_bad_piece_image.php',
            type: 'post',
            data: {path: imgElement_src, request: 2},
            async: false,
            success: function (response) {
                // Remove <div >
                if (response == 1) {
                    succ = true;
                }
            }, complete: function (data) {
                if (succ) {
                    var id = 'content_img_' + num;
                    // $('#content_img_'+num)[0].remove();
                    var elem = document.getElementById(id);
                    document.getElementById(id).style.display = 'none';
                    var nodes = $(".container")[2].childNodes;
                    for (var i = 0; i < nodes.length; i++) {
                        var node = nodes[i];
                        if (node.id == id) {
                            node.style.display = 'none';
                        }
                    }
                }
            }
        });
    });

</script>

<script>
    $(document).on('click', '.remove_image', function () {
        var del_id = this.id.split("_")[2];
        var x_img_id = this.parentElement.childNodes[3].value;
        var info =  document.getElementById("delete_image"+del_id);
        var info =  "id="+del_id+"&bad_image_id="+ x_img_id;
        $.ajax({
            type: "POST",
            url: "delete_bad_piece_image.php",
            data: info,
            success: function (data) {
            }
        });
        location.reload(true);
    });
</script>

<script>
    $(document).ready(function () {
        $('.select').select2();
    });


</script>
<script>



    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".view_gpbp").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

</script>
<script>
    //window.onload = function() {
    //    history.replaceState("", "", "<?php //echo $scriptName; ?>//events_module/add_bad_piece.php?station_event_id=<?php //echo $station_event_id; ?>//&defect_list_id=<?php //echo $defect_list_id; ?>//&cell_id=<?php //echo $cell_id?>//&c_name=<?php //echo $cell_name; ?>//");
    //}
</script>
<?php include ('../footer.php') ?>
</body>
</html>

