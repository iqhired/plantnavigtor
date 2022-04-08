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
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}
if (count($_POST) > 0) {
    $teams1 = $_POST['teams'];
    $users1 = $_POST['users'];
    $m_type = $_POST['material_type'];
    $material_type = count($_POST['material_type']);
    foreach ($teams1 as $teams) {
        $array_team .= $teams . ",";
    }
    foreach ($users1 as $users) {
        $array_user .= $users . ",";
    }
    if ($material_type > 1) {
        for ($i = 0; $i < $material_type; $i++) {
            if (trim($_POST['material_type'][$i]) != '') {
                $sql = "INSERT INTO `material_config`(`material_teams`,`material_users`,`material_type`,`created_at`) VALUES
    ('$array_team','$array_user','$m_type[$i]','$chicagotime')";
                $result1 = mysqli_query($db, $sql);
                if ($result1) {
                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Data Saved successfully.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Retry...';
                }
            }
        }
    } else {
        $sql = "INSERT INTO `material_config`(`material_teams`,`material_users`,`material_type`,`created_at`) VALUES
    ('$array_team','$array_user','$m_type','$chicagotime')";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Data Saved successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Retry...';
        }
    }
}

// edit material config
if (count($_POST) > 0) {
    $id = $_POST['edit_id'];
    $edit_teams1 = $_POST['edit_teams'];
    $edit_users1 = $_POST['edit_users'];
    $edit_m_type = $_POST['edit_material_type'];
    $edit_material_type = count($_POST['edit_material_type']);
    foreach ($edit_teams1 as $edit_teams) {
        $array_team .= $edit_teams . ",";
    }
    foreach ($edit_users1 as $edit_users) {
        $array_user .= $edit_users . ",";
    }
    if ($edit_material_type > 1) {
        for ($i = 0; $i < $edit_material_type; $i++) {
            if (trim($_POST['material_type'][$i]) != '') {
                $sql="update `material_config` set material_teams = ' $edit_teams1', material_users = '$edit_users1', material_type = '  $edit_m_type[$i]', created_at = '$chicagotime' where material_id='$id'";

                $result1 = mysqli_query($db, $sql);
                if ($result1) {
                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Data Updated successfully.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Retry...';
                }
            }
        }
    } else {
        $sql="update `material_config` set material_teams = ' $edit_teams1', material_users = '$edit_users1', material_type = '$edit_m_type', created_at = '$chicagotime' where material_id='$id'";

        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Data Updated successfully.';
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Please Retry...';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $siteURL; ?> | material Config</title>
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
        }
        .input-group-append {
            width: 112%;
        }
        .mb-3 {
            margin-bottom: 1rem!important;
            width: 90%;
        }
        #addRow {
            float: right;
            margin-top: -45px;
            margin-right: -66px;
        }
        #removeRow {
            float: right;
        }
        #addRow1 {
            float: right;
            margin-top: -45px;
            margin-right: -66px;
        }
        #removeRow1 {
            float: right;
            margin-left: -25px;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
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
            .input-group-append {
                width: 122%!important;
            }
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Material Tracability Config";
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
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Material Tracability Config</h5>
                <?php if ($temp == "one") { ?>
                    <br/>					<div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">Group</span> Created Successfully.
                    </div>
                <?php } ?>
                <?php if ($temp == "two") { ?>
                    <br/>					<div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
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
                <hr/>


                    <div class="row">
                        <div class="col-md-12">
                            <form action="" id="user_form" enctype="multipart/form-data"  class="form-horizontal" method="post">
                                <div class="row">
                                    <label class="col-lg-2 control-label">To Teams : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="select-border-color" data-placeholder="Add Teams..." name="teams[]" id="teams" multiple="multiple"  >
                                                <?php
                                                $arrteam = explode(',', $rowc["teams"]);
                                                $sql1 = "SELECT DISTINCT(`group_id`) FROM `sg_user_group`";
                                                $result1 = $mysqli->query($sql1);
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if (in_array($row1['group_id'], $arrteam)) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    $station1 = $row1['group_id'];
                                                    $qurtemp = mysqli_query($db, "SELECT * FROM  sg_group where group_id = '$station1' ");
                                                    $rowctemp = mysqli_fetch_array($qurtemp);
                                                    $groupname = $rowctemp["group_name"];
                                                    echo "<option value='" . $row1['group_id'] . "' $selected>" . $groupname . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group1()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-2 control-label">To Users : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="select-border-color" data-placeholder="Add Users ..." name="users[]" id="users"  multiple="multiple" >
                                                <?php
                                                $arrteam1 = explode(',', $rowc["users"]);
                                                $sql1 = "SELECT * FROM `cam_users` WHERE `users_id` != '1' order BY `firstname` ";
                                                $result1 = $mysqli->query($sql1);
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if (in_array($row1['users_id'], $arrteam1)) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    echo "<option value='" . $row1['users_id'] . "' $selected>" . $row1['firstname'] . "&nbsp;" . $row1['lastname'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group2()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-2 control-label" >Material Type : </label>
                                    <div class="col-md-6">
                                        <div id="inputFormRow">
                                            <div class="input-group mb-3">
                                                <input type="text" name="material_type[]" id="material_type" class="form-control m-input" placeholder="Enter Material Type" autocomplete="off">
                                            </div>
                                        </div>
                                        <div id="newRow"></div>
                                        <button id="addRow" type="button" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div><br/>

                                <br/>

                                <br/>

                        </div>
                    </div>

            </div>
            <div class="panel-footer p_footer">
                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Save</button>
            </div>

            </form>
        </div>
        <!-- /main charts -->
             <form action="delete_material.php" method="post" class="form-horizontal">
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
                        <th>Material Teams</th>
                        <th>Material Users</th>
                        <th>Material Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = sprintf("SELECT * FROM  material_config");
                    $qur = mysqli_query($db, $query);
                    while ($rowc = mysqli_fetch_array($qur)) {
                        ?>
                        <tr>
                            <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["material_id"]; ?>"></td>
                            <td><?php echo ++$counter; ?></td>
                            <td>
                                <?php
                                $material = $rowc['material_teams'];
                                $arr_material = explode(',', $material);

                                // glue them together with ', '
                                $materialStr = implode("', '", $arr_material);
                                $sql = "SELECT group_name FROM `sg_group` WHERE group_id IN ('$materialStr')";
                                $result1 = mysqli_query($db, $sql);
                                $line = '';
                                $i = 0;
                                while ($row =  $result1->fetch_assoc()) {
                                    if($i == 0){
                                        $line = $row['group_name'];
                                    }else{
                                        $line .= " , " . $row['group_name'];
                                    }
                                    $i++;
                                }
                                echo $line;
                                ?></td>
                            <?php
                            $nnm = $rowc["material_users"];
                            $arr_nnm = explode(',', $nnm);
                            $materialnnm = implode("', '", $arr_nnm);
                            $query12 = sprintf("SELECT firstname,lastname FROM  cam_users where users_id IN ('$materialnnm')");

                            $qur12 =  mysqli_query($db,$query12);
                            $line1 = '';
                            $j = 0;
                            while($rowc12 =  $qur12->fetch_assoc()){
                            if($j == 0){
                                $firstnm = $rowc12["firstname"];
                                $lastnm = $rowc12["lastname"];
                                $fulllname = $firstnm." ".$lastnm;
                            }else{
                                $firstnm = $rowc12["firstname"];
                                $lastnm = $rowc12["lastname"];
                                $fulllname .= " , " . $firstnm." ".$lastnm;
                            }
                                $j++;
                            }
                            ?>
                            <td><?php echo $fulllname;?></td>

                            <td><?php echo $rowc["material_type"]; ?></td>

                            <td>
                                <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['material_id']; ?>" data-material_teams="<?php echo $line; ?>" data-material_users="<?php echo $fulllname;?>" data-material_type="<?php echo $rowc['material_type']; ?>"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>

                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
        </form>					</div>
    <!-- /basic datatable -->
    <!-- edit modal -->
    <div id="edit_modal_theme_primary" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">Update Material Config</h6>
                </div>
                <form action="" id="user_form" class="form-horizontal" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Material Teams:*</label>
                                    <div class="col-lg-7 mob_modal">

                                        <input type="hidden" name="edit_id" id="edit_id" >
                                        <select class="select-border-color" data-placeholder="Add Teams..." name="edit_teams[]" id="edit_teams" multiple="multiple" >
                                            <?php
                                            $arrteam = explode(',', $rowc["teams"]);
                                            $sql1 = "SELECT DISTINCT(`group_id`) FROM `sg_user_group`";
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if (in_array($row1['group_id'], $arrteam)) {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = "";
                                                }
                                                $station1 = $row1['group_id'];
                                                $qurtemp = mysqli_query($db, "SELECT * FROM  sg_group where group_id = '$station1' ");
                                                $rowctemp = mysqli_fetch_array($qurtemp);
                                                $groupname = $rowctemp["group_name"];
                                                echo "<option value='" . $row1['group_id'] . "' $selected>" . $groupname . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Material Users:*</label>
                                    <div class="col-lg-7 mob_modal">
                                        <select class="select-border-color" data-placeholder="Add Users ..." name="edit_users[]" id="edit_users"  multiple="multiple" >
                                            <?php
                                            $arrteam1 = explode(',', $rowc["users"]);
                                            $sql1 = "SELECT * FROM `cam_users` WHERE `assigned2` = '0'  and `users_id` != '1' order BY `firstname` ";
                                            $result1 = $mysqli->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if (in_array($row1['users_id'], $arrteam1)) {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = "";
                                                }
                                                echo "<option value='" . $row1['users_id'] . "' $selected>" . $row1['firstname'] . "&nbsp;" . $row1['lastname'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $query = sprintf("SELECT * FROM  material_config");
                        $qur = mysqli_query($db, $query);
                        while ($rowc = mysqli_fetch_array($qur)) {
                            $material_type = $rowc['material_type'];
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Material Type:*</label>
                                    <div class="col-lg-7 mob_modal">
                                        <div id="inputFormRow1">
                                            <div class="input-group mb-3">
                                                <input type="text" name="edit_material_type[]" id="edit_material_type" value="<?php echo $material_type ?>" class="form-control m-input" placeholder="Enter Material Type" autocomplete="off">
                                            </div>
                                        </div>
                                        <div id="newRow1"></div>
                                        <button id="addRow1" type="button" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Dashboard content -->
    <!-- /dashboard content -->
    <script> $(document).on('click', '#delete', function () {
            var element = $(this);
            var del_id = element.attr("data-id");
            var info = 'id=' + del_id;
            $.ajax({type: "POST", url: "ajax_job_title_delete.php", data: info, success: function (data) { }});
            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
        });</script>
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('click', '#edit', function () {
                var element = $(this);
                var edit_id = element.attr("data-id");
                var teams = $(this).data("material_teams");
                var users = $(this).data("material_users");
                var type= $(this).data("material_type");
                $("#edit_teams").val(teams);
                $("#edit_users").val(users);
                $("#edit_type").val(type);
                $("#edit_id").val(edit_id);
                //alert(role);
            });
        });
    </script>

    </div>

</div>
<script type="text/javascript">
    // add row
    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="material_type[]" class="form-control m-input" placeholder="Enter Material Type" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="fa fa-minus" aria-hidden="true"></i></button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>
<script type="text/javascript">
    // add row
    $("#addRow1").click(function () {
        var html = '';
        html += '<div id="inputFormRow1">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="material_type[]" class="form-control m-input" placeholder="Enter Material Type" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow1" type="button" class="btn btn-danger"><i class="fa fa-minus" aria-hidden="true"></i></button>';
        html += '</div>';
        html += '</div>';

        $('#newRow1').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow1', function () {
        $(this).closest('#inputFormRow1').remove();
    });
</script>
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>material_tracability/material_config.php");
    }
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    function group1()
    {
        $("#teams").select2("open");
    }
    function group2()
    {
        $("#users").select2("open");
    }
</script>
<!-- /page container -->

<?php include ('../footer.php') ?>
</body>
</html>
