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

if (count($_POST) > 0) {
    $name = $_POST['name'];
//create
    if ($name != "") {
        $name = $_POST['name'];
        $priority_order = $_POST['priority_order'];
        $enabled = $_POST['enabled'];
        $gbpd = $_POST['gbpd'] ;
        if($gbpd == '1'){
            $g = '1';
        }else{
            $g = '0';
        }
        $npd = $_POST['npd'] ;
        if($npd == '1'){
            $n = '1';
        }else{
            $n = '0';
        }
        $p_label1 = $_POST['p_label1'] ;
        if($p_label1 == '1'){
            $i = '1';
        }else{
            $i = '0';
        }
        $sql0 = "INSERT INTO `cam_line`(`line_name`,`priority_order` , `enabled` ,`gbd_id` ,`npr_id` ,`indivisual_label` , `created_at`) VALUES ('$name' , '$priority_order' , '$enabled','$g','$n','$i', '$chicagotime')";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Station created successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
    }




    }

//upload file

if (isset($_FILES['good_file']) && isset($_FILES['bad_file'])) {
    $errors = array();
    $good_name = $_FILES['good_file']['name'];
    $bad_name = $_FILES['bad_file']['name'];
//    $rework_name = $_FILES['rework_file'];
    $good_size = $_FILES['good_file']['size'];
    $bad_size = $_FILES['bad_file']['size'];
//    $rework_size = $_FILES['rework_file']['size'];
    $good_tmp = $_FILES['good_file']['tmp_name'];
    $good_tmp1 = $good_tmp;
    $bad_tmp = $_FILES['bad_file']['tmp_name'];
//    $rework_tmp = $_FILES['rework_file']['tmp_name'];
    $good_type = $_FILES['good_file']['type'];
    $bad_type = $_FILES['bad_file']['type'];
//    $rework_type = $_FILES['rework_file']['type'];


//    $good_ext = strtolower(end(explode('.', $good_name)));
//    $bad_ext = strtolower(end(explode('.', $bad_name)));
    $good_extensions = array("application/octet-stream","doc","docx");
    $bad_extensions = array("application/octet-stream","doc","docx");
//    $rework_extensions = array("doc","docx");
//    if (in_array($good_type, $good_extensions) == false && in_array($bad_type, $bad_extensions) == false ) {
//    $errors[] = "extension not allowed, please choose a doc file.";
//    $message_stauts_class = 'alert-danger';
//    $import_status_message = 'Error: Extension not allowed, please choose a doc file.';
//
//}
//    if ($good_size > 2097152 && $bad_size > 2097152 && $rework_size > 2097152) {
//        $errors[] = 'File size must be excately 2 MB';
//        $message_stauts_class = 'alert-danger';
//        $import_status_message = 'Error: File size must be less than 2 MB';
//    }
    if (empty($errors) == true) {
        $dir_path = "../assets/label_files/" . $_POST['label_line_id'];
		if (!file_exists($dir_path)) {
			mkdir($dir_path, 0777, true);
		}
        move_uploaded_file($good_tmp, $dir_path . '/' . 'g' . "_" . 'label');
		copy($dir_path . '/' . 'g' . "_" . 'label', $dir_path . '/' . 'f1');
//		move_uploaded_file($good_tmp1, $dir_path . '/' . 'f1');
        move_uploaded_file($bad_tmp, $dir_path . '/' . 'b' . "_" . 'label');
		copy($dir_path . '/' . 'b' . "_" . 'label', $dir_path . '/' . 'f2');
        $zpl_id = $_POST['label_line_id'];
        $sql1 = "update cam_line set zpl_file_status = '1',print_label = '1' where line_id ='$zpl_id'";
        $result1 = mysqli_query($db, $sql1);
    //    $sql0 = "INSERT INTO `cam_line`('logo',`line_name`,`priority_order` , `enabled` , `created_at`) VALUES (''$file_name','$name' , '$priority_order' , '$enabled', '$chicagotime')";
        $message_stauts_class = 'alert-success';
        $import_status_message = 'Upload Files Successfully';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Station</title>
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
        <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
        <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/pn.js"></script>
        <script>
            $('#gbpd').on('change', function(){
                this.value = this.checked ? 1 : 0;
                // alert(this.value);
            }).change();
        </script>
    </head>
    <style>
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-md-3 {
                float: left;
            }
            .col-md-4 {
                float: left;
            }
            .col-md-2 {
                float: right;
            }
            .col-md-2.mob_user {
                float: left;
                margin-top: 10px;
            }
        }
        .col-lg-2 {
            width: 21.666667%;
        }
    </style>

        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Station Configuration Management";
        include("../header.php");
        include("../admin_menu.php");
        include("../heading_banner.php");
        ?>
    <body class="alt-menu sidebar-noneoverflow">
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
                                <!--							<h5 class="panel-title">Stations</h5>-->
                                <!--							<hr/>-->
                                <div class="row">


                                            <form action="" id="user_form" class="form-horizontal" method="post">
                                                <div class="col-md-12">
                                                <div class="col-md-3">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Station" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" name="priority_order" id="priority_order" class="form-control" placeholder="Enter Priority Order" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">Enabled : </label>
                                                    <select  name="enabled" id="enabled" class="select form-control" data-style="bg-slate" style="float: left;
                                                             width: initial;" >
                                                        <!--        <option value="" selected disabled>--- Select Ratings ---</option>-->
                                                        <option value="0" >No</option>
                                                        <option value="1" >Yes</option>
                                                    </select>
                                                </div>
                                                </div><br><br><br>
                                                <div class="col-md-12">
                                                    <div class="col-md-8">
                                                    <div id="checkboxes">
                                                        <label class="whatever" for="gbpd"><b>GBP Dashboard Required :</b></label>
                                                        <input type="checkbox" name="gbpd" id="gbpd" value="1">
                                                        <label class="whatever" for="npd">&nbsp;&nbsp;&nbsp;&nbsp;<b>NPR Dashboard Required : </b></label>
                                                        <input type="checkbox" name="npd" id="npd" value="1">
                                                        <label class="whatever" for="p_label">&nbsp;&nbsp;&nbsp;&nbsp;<b>Print Individual Required : </b></label>
                                                        <input type="checkbox" name="p_label1" id="p_label1" value="1">
                                                    </div>
                                                    </div>
                                                    <div class="col-md-2 mob_user">
                                                        <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create Station</button>
                                                    </div>


                                                </div>
                                            </form>


                                </div><br/>
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
                        </div>
                        <form action="delete_line.php" method="post" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button>
                                </div>
                            </div>	
                            <br/>	
                            <div class="panel panel-flat">					
                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" ></th>
                                            <th>S.No</th>
                                            <th>Station</th>
                                            <th>Priority Order</th>
                                            <th>Enabled</th>
                                            <th>GBP Dashboard Required</th>
                                            <th>NPR Dashboard Required</th>
                                            <th>Print Individual Required</th>
                                            <th>Print Required</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = sprintf("SELECT * FROM  cam_line where is_deleted!='1'");
                                        $qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["line_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["line_name"]; ?></td>
                                                <td><?php echo $rowc["priority_order"]; ?></td>
                                                <td><?php
                                                    $yn_result = ($rowc['enabled'] == 0) ? "No" : "Yes";
                                                    echo $yn_result;
                                                    ?></td>
        <!-- <td>--><?php //echo $rowc['created_at'];        ?><!--</td>-->
                                               <td>
                                                        <input type="checkbox" name="gbpd" id="gbpd" value="<?php echo $rowc["line_id"]; ?>" <?php echo ($rowc['gbd_id']==1 ? 'checked' : '');?>>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="npd" id="npd" value="<?php echo $rowc["line_id"]; ?>" <?php echo ($rowc['npr_id']==1 ? 'checked' : '');?>>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="p_label" id="p_label" value="<?php echo $rowc["line_id"]; ?>" <?php echo ($rowc['indivisual_label']==1 ? 'checked' : '');?>>
                                                </td>
                                                <td>
                                                    <?php
                                                    $zpl_result = ($rowc['zpl_file_status'] == 0) ? "Off" : "On"; ?>
                                                   <?php if($zpl_result == "Off"){ ?>
                                                    <button type="button" id="edit_label" class="btn btn-info btn-xs" style="background-color: #d84315" data-id="<?php echo $rowc['line_id']; ?>"  data-toggle="modal" data-target="#edit_modal_theme_primary1"><?php echo $zpl_result ?> </button>
                                                  <?php  }else {
                                                       $print = ($rowc['print_label'] == 0) ? "Off" : "On";
                                                       if($print == "Off"){?>
                                                    <button type="button" class="print_status btn btn-info btn-xs"  style="background-color: #d84315" data-id="<?php echo $rowc['line_id']; ?>"  data-toggle="modal"><?php echo $print ?> </button>
                                                         <?php  }else{ ?>
                                                               <button type="button" class="print_status btn btn-info btn-xs"  style="background-color: #43a047" data-id="<?php echo $rowc['line_id']; ?>"  data-toggle="modal"><?php echo $print ?> </button>
                                                         <?php   } ?>
                                                 <?php   } ?>
                                                </td>
                                                <td>
                                                    <a href="edit_line.php?id=<?php echo $rowc['line_id']; ?>" class="btn btn-primary" data-name="<?php echo $rowc['line_name']; ?>"  style="background-color:#1e73be;">Edit</a>

                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                        </form>
                    </div>
                    <!-- /basic datatable -->

            <!-- enabled modal -->
            <div id="edit_modal_theme_primary1" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">Upload Label File</h6>
                        </div>
                        <form action="" id="" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <label class="col-lg-2 control-label">Good Piece File : </label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="label_line_id" id="label_line_id" >
                                        <input type="file" name="good_file" id="good_file" value="" required
                                               class="form-control">
<!-- <div id="preview"></div>-->
                                    </div>

                                </div>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Bad Piece File : </label>
                                    <div class="col-md-6">
                                        <input type="file" name="bad_file" id="bad_file" required
                                               class="form-control">
<!-- <div id="preview"></div>-->
                                    </div>

                                </div>
<!--                                <div class="row">-->
<!--                                    <label class="col-lg-2 control-label">Select Printer : </label>-->
<!--                                    <div class="col-md-6">-->
<!--                                        <select  name="printer" id="printer" class="select form-control" data-style="bg-slate">-->
<!--                                            <option value="" disabled selected>Select Printer</option>-->
<!--                                            <option value="0" >Zebra Printer</option>-->
<!--                                            <option value="1" >EPSON Printer</option>-->
<!--                                            <option value="1" >HP Printer</option>-->
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content area -->

        </div>
        <!-- /page container -->
                    <!-- Dashboard content -->
                    <!-- /dashboard content -->
                    <script> $(document).on('click', '#delete', function () {
                            var element = $(this);
                            var del_id = element.attr("data-id");
                            var info = 'id=' + del_id;
                            $.ajax({type: "POST", url: "ajax_line_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });

                        $(document).on('click', '#edit_label', function () {
                            var element = $(this);
                            var edit_id = element.attr("data-id");
                            $("#label_line_id").val(edit_id);
                        });

                    </script>

                    <script>
                        window.onload = function() {
                            history.replaceState("", "", "<?php echo $scriptName; ?>config_module/line.php");
                        }
                    </script>
                    
                    <script>
                        $("#checkAll").click(function () {
                            $('input:checkbox').not(this).prop('checked', this.checked);
                        });
                    </script>

                    <script>
                        $("input#gbpd").click(function () {
                            var isChecked = $(this)[0].checked;
                            var val = $(this).val();
                            var data_1 = "&gbpd=" + val+ "&isChecked=" + isChecked;
                            $.ajax({
                                type: 'POST',
                                url: "GBPD_backend.php",
                                data: data_1,
                                success: function (response) {

                                }
                            });

                        });

                    </script>
        <script>
            $("input#npd").click(function () {
                var isChecked = $(this)[0].checked;
                var val = $(this).val();
                var data_1 = "&npd=" + val+ "&isChecked=" + isChecked;
                $.ajax({
                    type: 'POST',
                    url: "nprd_backend.php",
                    data: data_1,
                    success: function (response) {

                    }
                });

            });

        </script>
                    <script>
               $("input#p_label").click(function () {
                var isChecked = $(this)[0].checked;
                var val = $(this).val();
                var data_1 = "&p_label=" + val+ "&isChecked=" + isChecked;
                $.ajax({
                    type: 'POST',
                    url: "print_label.php",
                    data: data_1,
                    success: function (response) {

                    }
                });

            });

        </script>
                   <script>
                   $(".print_status").on('click', function () {
                    var element = $(this);
                    var print_id = element.attr("data-id");
                    var info = 'print=' + print_id;
                    $.ajax({
                        type: "POST",
                        url: "print_action.php",
                        data: info,
                        success: function (data) {

                            location.reload();
                        }
                    });

                });
            </script>
        <?php include('../footer.php') ?>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
