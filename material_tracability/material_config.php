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
        $serial = $_POST['serial_status'];
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
                     if($serial == ""){
					$sql = "INSERT INTO `material_config`(`teams`,`users`,`material_type`,`serial_num_required`,`created_at`) VALUES
    ('$array_team','$array_user','$m_type[$i]','0','$chicagotime')";
                         }else{
                         $sql = "INSERT INTO `material_config`(`teams`,`users`,`material_type`,`serial_num_required`,`created_at`) VALUES
    ('$array_team','$array_user','$m_type[$i]','1','$chicagotime')";
                     }
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
            if($serial == ""){
			$sql = "INSERT INTO `material_config`(`teams`,`users`,`material_type`,`serial_num_required`,`created_at`) VALUES
    ('$array_team','$array_user','$m_type[0]','0','$chicagotime')";
            }else{
                $sql = "INSERT INTO `material_config`(`teams`,`users`,`material_type`,`serial_num_required`,`created_at`) VALUES
    ('$array_team','$array_user','$m_type[0]','1','$chicagotime')";
            }
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
<!--    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>-->
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
        .checkbox-control {
            height: 15px;
            width: 15px;
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
<!--                --><?php
//                if (!empty($import_status_message)) {
//                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
//                }
//                ?>
<!--                --><?php
//                if (!empty($_SESSION[import_status_message])) {
//                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
//                    $_SESSION['message_stauts_class'] = '';
//                    $_SESSION['import_status_message'] = '';
//                }
//                ?>
                <hr/>

                <form action="" id="user_form" enctype="multipart/form-data"  class="form-horizontal" method="post">
                    <div class="row">
                        <div class="col-md-12">

                                <div class="row">
                                    <label class="col-lg-2 control-label">To Teams : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="select-border-color" data-placeholder="Add Teams..." name="teams[]" id="teams" multiple="multiple"  >
                                                <?php
                                                $sql1 = "SELECT DISTINCT(`group_id`) FROM `sg_user_group`";
                                                $result1 = $mysqli->query($sql1);
                                                while ($row1 = $result1->fetch_assoc()) {

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
                                                $sql1 = "SELECT * FROM `cam_users` WHERE `users_id` != '1' order BY `firstname` ";
                                                $result1 = $mysqli->query($sql1);
                                                while ($row1 = $result1->fetch_assoc()) {

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
                                        <button id="addRow" type="button" class="btn btn-primary" style="background-color: #1e73be;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Is Serial Number Required:*</label>
                                            <div class="col-md-6">
                                                <input type="checkbox" class="checkbox-control" name="serial_status" id="serial_status">
                                            </div>
                                </div>
                                <br/>



                                <br/>

                        </div>
                    </div>


            <div class="panel-footer p_footer">
                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Save</button>
            </div>

            </form>
        </div>

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
                        <th>Serial No Required</th>
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
                                $material = $rowc['teams'];
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
                            $nnm = $rowc["users"];
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
                           <td>  <input type='checkbox' id="serial_number" value="<?php echo $rowc["serial_num_required"] ?>" <?php if( $rowc["serial_num_required"] == 1) {echo "checked";}?> style="pointer-events: none !important;"></td>
                            <td>
                                <a href="edit_material_config.php?id=<?php echo $rowc['material_id']; ?>" class="btn btn-primary" data-material_teams="<?php echo  $material; ?>" style="background-color:#1e73be;">Edit</a>

                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

             </form>
    </div>

</div>


<script> $(document).on('click', '#delete', function () {
        var element = $(this);
        var del_id = element.attr("data-id");
        var info = 'id=' + del_id;
        $.ajax({type: "POST", url: "ajax_job_title_delete.php", data: info, success: function (data) { }});
        $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
    });</script>
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
<script type="text/javascript">
    // add row
    $("#addRow2").click(function () {
        var html = '';
        html += '<div id="inputFormRow2">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="material_type[]" class="form-control m-input" placeholder="Enter Material Type" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow2" type="button" class="btn btn-danger"><i class="fa fa-minus" aria-hidden="true"></i></button>';
        html += '</div>';
        html += '</div>';

        $('#newRow1').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow2', function () {
        $(this).closest('#inputFormRow2').remove();
    });
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

<?php include('../footer.php') ?>
</body>
</html>
