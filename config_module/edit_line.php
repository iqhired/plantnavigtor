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

//edit
    $edit_name = $_POST['edit_name'];
    $id = $_POST['edit_id'];
    $good_file = $_POST['edit_good_file'];
    $bad_file = $_POST['edit_bad_file'];
    $good_size = $_POST['edit_good_file']['size'];
    $bad_size = $_POST['edit_bad_file']['size'];
    $good_tmp = $_POST['edit_good_file']['tmp_name'];
    $bad_tmp = $_POST['edit_bad_file']['tmp_name'];
    $good_type = $_POST['edit_good_file']['type'];
    $bad_type = $_POST['edit_bad_file']['type'];


    $dir_path = "../assets/label_files/" . $id;

    $files = glob("$dir_path/*"); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file)) {
            unlink($file); // delete file
        }
    }
         if(!file_exists($dir_path)) {
           //    rmdir("../assets/label_files/" . $id);
//               unlink("../assets/label_files/" . $id .'/'. 'f1'); //delete file
//               unlink("../assets/label_files/" . $id .'/'. 'f2');
             move_uploaded_file($good_tmp, $dir_path . '/' . 'g' . "_" . 'label');
             copy($dir_path . '/' . 'g' . "_" . 'label', $dir_path . '/' . 'f1');
             move_uploaded_file($bad_tmp, $dir_path . '/' . 'b' . "_" . 'label');
             copy($dir_path . '/' . 'b' . "_" . 'label', $dir_path . '/' . 'f2');
         }

    //     mkdir($dir_path, 0777, true);


        $sql = "update cam_line set line_name='$_POST[edit_name]', priority_order='$_POST[edit_priority_order]' , enabled='$_POST[edit_enabled]'  where line_id='$id'";

        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Station Updated successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Insert valid data';
        }
        header('location: line.php');

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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
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
</style>

<!-- Main navbar -->
<?php
$cust_cam_page_header = " Edit Station Configuration Management";
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

        <div class="panel panel-flat">
            <div class="panel-heading">
                <form action="" id="user_form" class="form-horizontal" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <?php
                            $edit_id = $_GET['id'];
                            ?>
                            <?php
                            $sql1 = "SELECT * FROM `cam_line` where line_id = '$edit_id' ";
                            $result1 = $mysqli->query($sql1);
                            while ($row1 = $result1->fetch_assoc()) {
                                $line_name = $row1['line_name'];
                                $p_order = $row1['priority_order'];
                                $enabled = $row1['enabled'];
                            }
                            ?>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Station:*</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="edit_name" id="edit_name" class="form-control" value="<?php echo $line_name; ?>" required>
                                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Priority Order:*</label>
                                    <div class="col-lg-7">
                                        <input type="number" name="edit_priority_order" id="edit_priority_order" class="form-control"
                                               value="<?php echo $p_order; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Enabled:*</label>
                                    <div class="col-lg-7">
                                        <input type="hidden" name="edit_e" id="edit_e" >
                                        <select  name="edit_enabled" id="edit_enabled" class="select form-control" data-style="bg-slate" style="float: left;
                                                                 width: initial;">
                                            <?php if($enabled == 1){
                                                $selected = "selected";
                                             echo "<option value =' 1'  $selected>Yes</option>
                                                   <option value=' 0'>No</option>";
                                                }
                                            elseif($enabled == 0){
                                                $selected = "selected";
                                                echo "<option value =' 1 '>Yes</option>
                                                      <option value= '0 '$selected>No</option>";
                                            }
                                              ?>
                                         </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Good Piece File : </label>
                                    <div class="col-lg-7">
                                        <input type="file" name="edit_good_file" id="edit_good_file"
                                               class="form-control">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Bad Piece File : </label>
                                    <div class="col-lg-7">
                                        <input type="file" name="edit_bad_file" id="edit_bad_file"
                                               class="form-control">
                                        <!-- <div id="preview"></div>-->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
<!--                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<!-- /page container -->

<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>config_module/edit_line.php?id=<?php echo $edit_id;?>");
    }
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
    $(".print_status").on('click', function () {
        var element = $(this);
        var print_id = element.attr("data-id");
        var info = 'id=' + print_id;
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