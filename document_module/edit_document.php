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



$yesdate = date('Y-m-d',strtotime("365 days"));
$datefrom = $yesdate;
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
        .col-lg-3.file {
            width: 45%;
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
        .container {
            margin: 0 auto;
        }

        .content_img {
            /*width: 220px;*/
            width: 112px;
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
            margin-top: 6px;
        }

        .content_img span:hover {
            cursor: pointer;
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
    $id = $_GET['id'];
    $_SESSION['edit_id'] = $id;
    $sql1 = "SELECT * FROM `document_data` where doc_id = '$id'";
    $result1 = mysqli_query($db, $sql1);

    while ($row1 = mysqli_fetch_assoc($result1)) {
        $doc_name = $row1['doc_name'];
        $doc_type = $row1['doc_type'];
        $doc_cat = $row1['doc_category'];
        $status = $row1['status'];
        $station = $row1['station'];
        $expirydate = $row1['expiry_date'];
        $part_number = $row1['part_number'];
        $_SESSION['doc_station'] = $station;
        $_SESSION['doc_part_number'] = $part_number;

        $sql1 = "SELECT * FROM `cam_line` where line_id = '$station'";
        $result1 = mysqli_query($db,$sql1);
        //                                            $entry = 'selected';
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $line_name = $row1['line_name'];
        }

        $sql_cat = "SELECT * FROM `document_type` where document_type_id = '$doc_cat'";
        $result_cat = mysqli_query($db,$sql_cat);
        while ($row_cat = mysqli_fetch_assoc($result_cat)){
            $doc_category = $row_cat['document_type_name'];
        }

        $path = "../document_files/".$id.'/';
        $sql_file = sprintf("SELECT * FROM `document_files` where station = '$station' AND part_number  = '0' ");
        $qurmain1 = mysqli_query($db, $sql_file);
        while($rowcmain1 = mysqli_fetch_array($qurmain1)){
            $file_name = $rowcmain1['file_name'];
        }
        ?>
        <!-- Content area -->
        <div class="content">
            <!-- Main charts -->
            <!-- Basic datatable -->
            <div class="panel panel-flat">
                <form action="edit_document_backend.php" id="document_setting" enctype="multipart/form-data" class="form-horizontal" method="post">
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

                                <div class="row">

                                    <label class="col-lg-2 control-label" style="padding-top: 10px;">Station : </label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="doc_id" value="<?php echo $id; ?>">
<!--                                        <input type="hidden" name="station" value="--><?php //echo $station; ?><!--">-->
                                        <select name="station" id="station" class="select form-control"
                                                style="float: left;width: initial;">
                                            <option value="" selected disabled>--- Select Station ---</option>
                                            <?php
                                            $sql1 = "SELECT * FROM `cam_line` ";
                                            $result1 = $mysqli->query($sql1);
                                            //                                            $entry = 'selected';
                                            while ($row1 = $result1->fetch_assoc()) {
                                                $lin = $row1['line_id'];

                                                if ($station == $lin) {
                                                    $entry = 'selected';
                                                } else {
                                                    $entry = '';
                                                }
                                                echo "<option value='" . $row1['line_id'] . "' $entry >" . $row1['line_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div id="error1" class="red">Document Name</div>
                                </div>
                                </br>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Document file : </label>
                                    <div class="col-md-6">
                                        <input type="file" name="file[]" id="file" class="form-control">
                                        <div class="container"></div>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <label class="col-lg-2 control-label">Previous Image : </label>
                                    <div class="col-md-6">
                                        <?php
                                        $query1 = sprintf("SELECT doc_id FROM  document_data where doc_id = '$id'");
                                        $qur1 = mysqli_query($db, $query1);
                                        $rowc1 = mysqli_fetch_array($qur1);
                                        $item_id = $rowc1['doc_id'];

                                        $query2 = sprintf("SELECT * FROM  document_files where doc_id = '$item_id'");

                                        $qurimage = mysqli_query($db, $query2);
                                        $i =0 ;
                                        while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                            $image = $rowcimage['file_name'];
                                            $d_tag = "delete_image_" . $i;
                                            $r_tag = "remove_image_" . $i;
                                            ?>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
                                                        <img src="../document_files/<?php echo $item_id; ?>/<?php echo $image; ?>"
                                                             alt="">
                                                        <input type="hidden"  id="<?php echo $d_tag; ?>" name="<?php echo $d_tag; ?>" class="<?php echo $d_tag; ?>" value="<?php echo $rowcimage['doc_file_id']; ?>">
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
                                    <label class="col-lg-2 control-label" style="padding-top: 10px;">Document Name : </label>
                                    <div class="col-md-6">
                                        <input type="text" name="doc_name" id="doc_name" class="form-control"  value="<?php echo $doc_name; ?>" placeholder="Enter Doc name" required>
                                    </div>
                                    <div id="error1" class="red">Document Name</div>
                                </div>
                                <br/>

                                <div class="row">
                                    <label class="col-lg-2 control-label">Document Type : </label>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="pass" name="doc_type" value="1" class="form-check-input"  <?php if($doc_type == "1"){echo 'checked';} ?>  required>
                                            <label for="pass" class="item_label">Station</label>

                                            <input type="radio" id="fail" name="doc_type" value="0" class="form-check-input reject" <?php if($doc_type == "0"){echo 'checked';}?> required>
                                            <label for="fail" class="item_label">Part Number</label>
                                        </div>

                                    </div>
                                    <div id="error7" class="red">Please select station or part number</div>

                                </div>

                               <?php if($doc_type == "0"){ ?>
                                <div class="row desc" id="Carspart_number">
                                    <br/>

                                    <div class="row">
                                        <label class="col-lg-2 control-label" style="margin-left: 10px;">Part Number *  :</label>
                                        <div class="col-md-6">
                                            <select name="part_number" id="part_number" class="select" data-style="bg-slate" >
                                                <option value="" selected disabled>--- Select Part Number ---</option>
                                                <?php
                                                $sql1 = "SELECT * FROM `pm_part_number` where station = '$station' ORDER BY `part_number` ASC  ";
                                                $result1 = $mysqli->query($sql1);
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if ($part_number = $row1['pm_part_number_id']){
                                                        $entry = 'selected';
                                                    }else{
                                                        $entry = '';
                                                    }

                                                    echo "<option value='" . $row1['pm_part_number_id'] . "' $entry>" . $row1['part_number'] ." - ".$row1['part_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <?php } else { ?>
                                   <div class="row desc" id="Cars0" style="display: none;">
                                       <br/>

                                       <div class="row">
                                           <label class="col-lg-2 control-label" style="margin-left: 10px;">Part Number *  :</label>
                                           <div class="col-md-6">
                                               <select name="part_number" id="part_number" class="select" data-style="bg-slate" >
                                                   <option value="" selected disabled>--- Select Part Number ---</option>
                                                   <?php
                                                   $sql1 = "SELECT * FROM `pm_part_number` where station = '$station' ORDER BY `part_number` ASC  ";
                                                   $result1 = $mysqli->query($sql1);
                                                   while ($row1 = $result1->fetch_assoc()) {
                                                       if ($part_number = $row1['pm_part_number_id']){
                                                           $entry = 'selected';
                                                       }else{
                                                           $entry = '';
                                                       }

                                                       echo "<option value='" . $row1['pm_part_number_id'] . "' $entry>" . $row1['part_number'] ." - ".$row1['part_name'] . "</option>";
                                                   }
                                                   ?>
                                               </select>
                                           </div>
                                       </div>
                                   </div>
                                   <br/>
                                <?php } ?>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Document Category : </label>
                                    <div class="col-md-6">
                                        <select name="category" id="category" class="select" data-style="bg-slate">
                                            <option value="" selected disabled>--- Select Category ---</option>
                                            <?php

                                            $sql2 = "SELECT * FROM `document_type` where enabled = '1' ORDER BY `document_type_name` ASC ";
                                            $result2 = mysqli_query($db,$sql2);
                                            //                                            $entry = 'selected';
                                            while ($row1 = mysqli_fetch_assoc($result2)) {
                                                if($doc_cat == $row1['document_type_id']){
                                                    $entry = 'selected';
                                                }else{
                                                    $entry = '';
                                                }

                                                echo "<option value='" . $row1['document_type_id'] . "' $entry>" . $row1['document_type_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="error6" class="red">Please Enter Document Category</div>
                                <br/>

                                <div class="row">
                                    <label class="col-lg-2 control-label">Status : </label>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="active" name="status" value="active" <?php if($status == "active"){echo 'checked';} ?> class="form-check-input" checked required>
                                            <label for="pass" class="item_label">Active</label>

                                            <input type="radio" id="inactive" name="status" value="inactive" <?php if($status == "inactive"){echo 'checked';} ?> class="form-check-input reject" required>
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
                                        <input type="date" name="exp_date" id="exp_date"  class="form-control" value="<?php echo $expirydate; ?>"  required>
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
    <?php } ?>
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
        var info =  "id="+del_id+"&doc_id="+mat_img_id;
        $.ajax({
            type: "POST",
            url: "../document_module/delete_document_file.php",
            data: info,
            success: function (data) {
            }
        });
        location.reload(true);
    });
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
<script>
    $("#file").on("change", function () {
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file', files);
        fd.append('request', 1);

        // AJAX request
        $.ajax({
            url: 'edit_delete_doc_file.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response != 0) {
                    var count = $('.container .content_img').length;
                    count = Number(count) + 1;

                    // Show image preview with Delete button
                    // $('.container').append("<div class='content_img' id='content_img_" + count + "' ><img src='" + response + "' width='100' height='100'><div class='action'> <span class='rename' id='rename_" + count + "'>Rename</span><span class='delete' id='delete_" + count + "'>Delete</span></div><div id='Renamediv'><input type='text' class='form-control' name='rename' id='rename_" + count + "' placeholder='rename file'><button type='submit' id='renamebtn_" + count + "' class='btn-primary renamebtn'>Save</button></div></div>");
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
            url: 'edit_delete_doc_image.php',
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

    // $("#file-input").on("change", function(e) {
    //     var files = e.target.files,
    //         filesLength = files.length;
    //     for (var i = 0; i < filesLength; i++) {
    //         var f = files[i]
    //         var fileReader = new FileReader();
    //         fileReader.onload = (function(e) {
    //             var file = e.target;
    //             $("<span class=\"pip\">" +
    //                 "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
    //                 "<br/><span class=\"remove\">Remove image</span>" +
    //                 "</span>").insertAfter("#file-input");
    //             $(".remove").click(function(){
    //                 $(this).parent(".pip").remove();
    //             });
    //
    //             // Old code here
    //             /*$("<img></img>", {
    //               class: "imageThumb",
    //               src: e.target.result,
    //               title: file.name + " | Click to remove"
    //             }).insertAfter("#files").click(function(){$(this).remove();});*/
    //
    //         });
    //         fileReader.readAsDataURL(f);
    //     }
    // });

</script>

<?php include('../footer.php') ?>

</body>

</html>