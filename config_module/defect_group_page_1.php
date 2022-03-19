<?php include("../config.php");
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
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Update Defect Group</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
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
    <!--        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>-->
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <!--        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>-->
    <!--	<script type="text/javascript" src="assets/js/pages/form_select2.js"></script>
            -->
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <style>
        th.sno{
            width: 5%
        }
        th.action {
            width: 15%
        }
        th.p_name {
            width: 60%; /* Not necessary, since only 70% width remains */
        }
        th.d_name{
            width: 20%
        }

        .select2-container{
            outline: 0;
            position: relative;
            display: inline-block;
            text-align: left;
            font-size: 12px;
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php $cam_page_header = "Defect Group";
include("../header.php");
include("../admin_menu.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">

            <!-- Content area -->

            <div class="content">
                <!-- Main charts -->
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <!--							<h5 class="panel-title">Job-Title List</h5>-->
                        <!--							<hr/>-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php
                                    $id = $_GET['id'];
//                                    $defect_group_name = $_GET['d_group_name'];
//                                    $description = $_GET['description'];
                                    ?>
                                    <form action="" id="edit_form" class="form-horizontal" method="post">
                                        <div class="modal-body">
                                            <div class="row">
                                                <?php
                                                $query = sprintf("SELECT * FROM  sg_defect_group where d_group_id = '$id'");
                                                $qur = mysqli_query($db, $query);
                                                $rowc = mysqli_fetch_array($qur);


                                                ?>
                                                <div class="col-md-12">
                                                    <div class="form-group" >
                                                        <label class="col-md-2 control-label">Defect group Name:*</label>
                                                        <div class="col-md-10">

                                                            <input type="text" name="edit_grp_name" id="edit_name" class="form-control" value="<?php echo $rowc['d_group_name']; ?>" required>
                                                            <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $id; ?>">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="form-group" >
                                                        <label class="col-md-2 control-label">Description:*</label>
                                                        <div class="col-md-10">

                                                            <input type="text" name="edit_disc" id="edit_disc" class="form-control" value="<?php echo $rowc['description']; ?>" required>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                 <div class="col-md-12">
                                                    <div class="form-group" >
                                                        <label class="col-md-2 control-label">Defect:*</label>
                                                        <div class="col-md-10">
                                                            <select required name="edit_defects[]" id="edit_defects"  class="select-border-color"
                                                                    multiple="multiple">
                                                                <?php
                                                                $arrteam = explode(',', $rowc["part_number_id"]);
                                                                $sql1 = "SELECT defect_list_id, defect_list_name FROM defect_list order by defect_list_name ASC";
                                                                $result1 = $mysqli->query($sql1);
                                                                $selected = "";

                                                                while ($row1 = $result1->fetch_assoc()) {
                                                                    if (in_array($row1['part_number_id'], $arrteam)) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                    echo "<option id='" . $row1['defect_list_id'] . "' value='" . $row1['defect_list_id'] . "' $selected>" . $row1['defect_list_name'] . "</option>";
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <!--  <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
                                            <button type="submit" onclick="submitForm_edit('edit_defect_group.php')" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /basic datatable -->
                            <!-- /main charts -->


                            <!-- Dashboard content -->
                            <!-- /dashboard content -->


                        </div>
                        <!-- /content area -->

                    </div>

</div>
<script>


    function submitForm_edit(url) {

        $(':input[type="button"]').prop('disabled', true);
        var data = $("#edit_form").serialize();
        var main_url = "<?php echo $url; ?>";
        $.ajax({
            type: 'POST',
            //url: main_url+url,
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();

            }
        });
    }
</script>
            <!-- /page container -->
            <?php include ('../footer.php') ?>
</body>
</html>
