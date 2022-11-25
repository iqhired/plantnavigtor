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

    </style>
</head>

<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Material Tracabilty";
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

    $sql1 = "SELECT * FROM `cam_line` where line_id = '$st'";
    $result1 = $mysqli->query($sql1);
    //                                            $entry = 'selected';
    //    while ($row1 = $result1->fetch_assoc()) {
    //        $line_name = $row1['line_name'];
    //    }
    ?>
    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <?php


        $id = $_GET['id'];

        $querymain = sprintf("SELECT * FROM `material_tracability` where material_id = '$id' ");
        $qurmain = mysqli_query($db, $querymain);
        while ($rowcmain = mysqli_fetch_array($qurmain)) {
            $line_no = $rowcmain['line_no'];
            $station_event_id = $rowcmain['station_event_id'];
            $material_id = $rowcmain['material_id'];
            $part_number = $rowcmain['part_no'];
                $part_family= $rowcmain['part_family_id'];
            $pm_part_name= $rowcmain['part_name'];
            $material_type= $rowcmain['material_type'];
            $material_status= $rowcmain['material_status'];
            $fail_reason= $rowcmain['fail_reason'];
            $reason_desc= $rowcmain['reason_desc'];
            $quantity= $rowcmain['quantity'];
            $notes= $rowcmain['notes'];
            $created_at= $rowcmain['created_at'];

            $sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
            $resultfamily = mysqli_query($db,$sqlfamily);
            $rowcfamily = mysqli_fetch_array($resultfamily);
            $pm_part_family_name = $rowcfamily['part_family_name'];

            $sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
            $resultnumber = mysqli_query($db,$sqlnumber);
            $rowcnumber = mysqli_fetch_array($resultnumber);
            $pm_part_number = $rowcnumber['part_number'];
            $pm_part_name = $rowcnumber['part_name'];

            $sqlnumber = "SELECT * FROM `cam_line` where `line_id` = '$line_no'";
            $resultnumber = mysqli_query($db,$sqlnumber);
            $rowcnumber = mysqli_fetch_array($resultnumber);
            $line_name = $rowcnumber['line_name'];
            ?>
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
                            <form action="edit_material_backend.php" id="material_setting" enctype="multipart/form-data" class="form-horizontal" method="post">
                                <div class="row">
                                    <label class="col-lg-2 control-label" style="padding-top: 10px;">Station : </label>
                                    <div class="col-md-6">

                                        <input type="hidden" name="material_id" id="material_id" value="<?php echo $material_id ?>">
                                        <input type="hidden" name="station_event_id" value="<?php echo $station_event_id ?>">
                                        <input type="hidden" name="customer_account_id" value="<?php echo $account_id ?>">
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
                                    <label class="col-lg-2 control-label">Material type : </label>
                                    <div class="col-md-6">
                                        <select name="material_type" id="material_type" class="select" data-style="bg-slate" >
                                            <option value="" selected disabled>--- Select material Type ---</option>
                                            <?php
                                            $m_type = $rowcmain['material_type'];
                                            $sql1 = "SELECT material_id, material_type FROM `material_config` where material_id = '$m_type'";
                                            $result1 = mysqli_query($db, $sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if($m_type == $row1['material_id']){
                                                    $entry = 'selected';
                                                }else{
                                                    $entry = '';
                                                }

                                                echo "<option value='" . $row1['material_id'] . "' $entry>" . $row1['material_type'] . "</option>";

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
                                        <input type="file" name="edit_image[]" id="file-input" class="form-control" onchange="preview_image();" multiple="multiple">
                                        <!--                                    <div id="preview"></div>-->
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Previous Image : </label>
                                    <div class="col-md-6">
                                        <?php
                                        $query1 = sprintf("SELECT material_id FROM  material_tracability where material_id = '$id'");
                                        $qur1 = mysqli_query($db, $query1);
                                        $rowc1 = mysqli_fetch_array($qur1);
                                        $item_id = $rowc1['material_id'];

                                        $query2 = sprintf("SELECT * FROM  material_images where material_id = '$item_id'");

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
                                                        <img src="../assets/images/mt/<?php echo $image; ?>"
                                                             alt="">
                                                        <input type="hidden"  id="<?php echo $d_tag; ?>" name="<?php echo $d_tag; ?>" class="<?php echo $d_tag; ?>>" value="<?php echo $rowcimage['material_images_id']; ?>">
                                                        <span class="remove remove_image" id="<?php echo $r_tag; ?>">Remove Image </span>


                                                        <!--                                                <div class="caption-overflow">-->
                                                        <!--														<span>-->
                                                        <!--															<a href="../material_images/--><?php //echo $rowcimage['image_name']; ?><!--"-->
                                                        <!--                                                               data-popup="lightbox" rel="gallery"-->
                                                        <!--                                                               class="btn border-white text-white btn-flat btn-icon btn-rounded"><i-->
                                                        <!--                                                                        class="icon-plus3"></i></a>-->
                                                        <!--														</span>-->
                                                        <!---->
                                                        <!--                                                </div>-->

                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;} ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label" style="padding-top: 10px;">Serial Number : </label>
                                    <div class="col-md-6">
                                        <input type="number" name="serial_number" id="serial_number"  value="<?php echo $rowcmain['serial_number'];?>" class="form-control" placeholder="Enter Serial Number" required>
                                    </div>
                                    <div id="error1" class="red">Part Name</div>
                                </div>
                                <br/>

                                <div class="row">
                                    <label class="col-lg-2 control-label">Material Status : </label>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="pass" name="material_status" value="1" class="form-check-input" <?php if($rowcmain['material_status'] == "1"){ echo 'checked'; } ?> required>
                                            <label for="pass" class="item_label">Pass</label>

                                            <input type="radio" id="fail" name="material_status" value="0" class="form-check-input reject"  <?php if($rowcmain['material_status'] == "0"){ echo 'checked'; } ?> required>
                                            <label for="fail" class="item_label">Fail</label>


                                        </div>

                                    </div>
                                    <div id="error7" class="red">Please Enter material Status</div>

                                </div>
                                <br/>

                                <?php if($rowcmain['material_status'] == "0"){?>

                                    <div class="row desc" id="material_statusfail">
                                        <label class="col-lg-2 control-label">Reason : </label>
                                        <div class="col-md-6">
                                            <?php if(($rowcmain['fail_reason'] == 'onhold') || ($rowcmain['fail_reason'] == 'Hold')){ ?>
                                            <select name="reason" id="reason" class="select form-control" data-style="bg-slate">
<!--                                                <option value="" selected disabled>--- Select Reason ---</option>-->
                                                <option value="onhold" selected>On Hold</option>
                                                <option value="rejected" >Rejected</option>

                                            </select>
											<?php }else if(($rowcmain['fail_reason'] == 'rejected') || ($rowcmain['fail_reason'] == 'Reject')){?>
                                            <select name="reason" id="reason" class="select form-control" data-style="bg-slate">
                                                <!--                                                <option value="" selected disabled>--- Select Reason ---</option>-->
                                                <option value="onhold" >On Hold</option>
                                                <option value="rejected" selected >Rejected</option>

                                            </select>
											<?php }?>
                                        </div>
                                    </div>
                                    <br/>
<!---->
<!--                                    <div class="row desc" id="Reasonfail">-->
<!--                                        <label class="col-lg-2 control-label"> Reason Description: </label>-->
<!--                                        <div class="col-md-6">-->
<!--                                            <textarea class="form-control" name="reason_desc" rows="1" id="reason_desc" value="--><?php //echo $reason_desc;?><!--">--><?php //echo $reason_desc;?><!--</textarea>-->
<!--                                        </div>-->
<!---->
<!--                                  </div>-->
<!--                                    <br/>-->
                                    <div class="row desc" id="quantityfail">
                                        <label class="col-lg-2 control-label">Quantity: </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="quantity" rows="1" id="quantity" value="<?php echo $quantity;?>">
                                        </div>

                                    </div>
                                    <br/>
                                <?php }else{ ?>
                                    <div class="row desc" id="Reason0"  style="display: none;">
                                        <label class="col-lg-2 control-label"> Reason : </label>
                                        <div class="col-md-6">
                                            <select name="reason" id="reason" class="select form-control" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Reason ---</option>
                                                <?php
                                                $string = $reason;

                                                $str_arr = explode (",", $string);
                                                for ($i=0; $i < count($str_arr) ; $i++)
                                                {  ?>

                                                    <option value="<?php echo $str_arr[$i]; ?>"><?php echo $str_arr[$i]; ?></option>
                                                <?php     } ?>

                                            </select>                                </div>

                                    </div>
                                    <br/>

                                    <div class="row desc" id="quantity0" style="display: none;">
                                    <label class="col-lg-2 control-label">Quantity: </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="quantity" rows="1" id="quantity" value="<?php echo $quantity;?>">
                                    </div>

                                </div>
                                <br/>
                              <?php  }?>


                                <div class="row">
                                    <!--<div class="col-md-4">-->
                                    <label class="col-lg-2 control-label">Notes : </label>
                                    <div class="col-md-6">
                                        <textarea id="notes" name="material_notes" rows="4" placeholder="Enter Notes..." value =" <?php echo $notes;?>" class="form-control"><?php echo $notes;?></textarea>
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
        <?php } ?>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('.select').select2();
    });
</script>

<script>
    $(document).on('click', '.remove_image', function () {
        var del_id = this.id.split("_")[2];
        var mat_img_id = this.parentElement.childNodes[3].value;
        var info =  document.getElementById("delete_image"+del_id);
        var info =  "id="+del_id+"&material_id="+mat_img_id;
        $.ajax({
            type: "POST", url: "../material_tracability/delete_material_image.php", data: info, success: function (data) {
            }
        });
        location.reload(true);
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

                // Old code here
                /*$("<img></img>", {
                  class: "imageThumb",
                  src: e.target.result,
                  title: file.name + " | Click to remove"
                }).insertAfter("#files").click(function(){$(this).remove();});*/

            });
            fileReader.readAsDataURL(f);
        }
    });

</script>

<!--<script>-->
<!--    function submitFormSettings(url) {-->
<!--        //          $(':input[type="button"]').prop('disabled', true);-->
<!--        var data = $("#material_setting").serialize();-->
<!--        $.ajax({-->
<!--            type: 'POST',-->
<!--            url: url,-->
<!--            data: data,-->
<!--            success: function(data) {-->
<!--                // $("#textarea").val("")-->
<!--                // window.location.href = window.location.href + "?aa=Line 1";-->
<!--                //                   $(':input[type="button"]').prop('disabled', false);-->
<!--                //                   location.reload();-->
<!--                //$(".enter-message").val("");-->
<!--            }-->
<!--        });-->
<!--    }-->
<!--</script><script>-->
<!--    function submitFormSettings(url) {-->
<!--        //          $(':input[type="button"]').prop('disabled', true);-->
<!--        var data = $("#material_setting").serialize();-->
<!--        $.ajax({-->
<!--            type: 'POST',-->
<!--            url: url,-->
<!--            data: data,-->
<!--            success: function(data) {-->
<!--                // $("#textarea").val("")-->
<!--                // window.location.href = window.location.href + "?aa=Line 1";-->
<!--                //                   $(':input[type="button"]').prop('disabled', false);-->
<!--                //                   location.reload();-->
<!--                //$(".enter-message").val("");-->
<!--            }-->
<!--        });-->
<!--    }-->
<!--</script>-->
<script>
    function group1()
    {
        $("#out_of_tolerance_mail_list").select2("open");
    }
    function group2()
    {
        $("#out_of_control_list").select2("open");
    }

    // $(document).on("click",".submit_btn",function() {
    //     //$("#form_settings").submit(function() {
    //
    //     var line_number = $("#line_number").val();
    //     var material_type = $("#material_type").val();
    //     var material_status = $("#material_status").val();
    //
    //
    //
    // });

    // function preview_image()
    // {
    //     var total_file=document.getElementById("file-input").files.length;
    //     for(var i=0;i<total_file;i++)
    //     {
    //         $('#preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'><br>");
    //     }
    // }


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
        $("input[name$='material_status']").click(function() {
            var test = $(this).val();
            //    console.log(test);
            $("div.desc").hide();
            $("#Reason" + test).show();
            $("#material_status" + test).show();
            $("#quantity" + test).show();
            $("#Reason" + test).prop('required',true);


        });
    });
</script>

<?php include('../footer.php') ?>

</body>

</html>