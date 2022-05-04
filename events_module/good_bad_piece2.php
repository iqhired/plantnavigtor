<?php include("../config.php");
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
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
	header('location: ../line_status_overview_dashboard.php');
}
$user_id = $_SESSION["id"];
$chicagotime = date("Y-m-d H:i:s");
//$line = "<b>-</b>";
$line = "";
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


$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
$resultnumber = $mysqli->query($sqlnumber);
$rowcnumber = $resultnumber->fetch_assoc();
$pm_part_number = $rowcnumber['part_number'];
$pm_part_name = $rowcnumber['part_name'];

$sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
$resultfamily = $mysqli->query($sqlfamily);
$rowcfamily = $resultfamily->fetch_assoc();
$pm_part_family_name = $rowcfamily['part_family_name'];

$sqlaccount = "SELECT * FROM `part_family_account_relation` where `part_family_id` = '$part_family'";
$resultaccount = $mysqli->query($sqlaccount);
$rowcaccount = $resultaccount->fetch_assoc();
$account_id = $rowcaccount['account_id'];

$sqlcus = "SELECT * FROM `cus_account` where `c_id` = '$account_id'";
$resultcus = $mysqli->query($sqlcus);
$rowccus = $resultcus->fetch_assoc();
$cus_name = $rowccus['c_name'];
$logo = $rowccus['logo'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?>
        | Good & Bad Pieces</title>
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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"> </script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"> </script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <style> .sidebar-default .navigation li > a {
            color: #f5f5f5
        }

        ;
        a:hover {
            background-color: #20a9cc;
        }

        .sidebar-default .navigation li > a:focus, .sidebar-default .navigation li > a:hover {
            background-color: #20a9cc;
        }

        .content-wrapper {
            display: block !important;
            vertical-align: top;
            padding: 20px !important;
        }



        .bg-primary {
            background-color: #606060!important;
        }
    </style>
    <style>
        .red {
            color: red;
            display: none;
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cam_page_header = "Good & Bad Pieces";
include("../header_folder.php");
if ($is_tab_login || ($_SESSION["role_id"] == "pn_user")) {
	include("../tab_menu.php");
} else {
	include("../admin_menu.php");
}

?>
<!-- Content area -->
<div class="content">
    <!--			<div style="background-color: #fff;" class="row">-->
    <div style="background-color: #fff;padding-bottom: 50px; margin-left:0px !important; margin-right: 0px !important;" class="row">
        <div class="col-lg-3 col-md-8"></div>
        <div class="col-lg-6 col-md-12">
            <!--							<div class="panel panel-body">-->
            <div class="media" style="padding-top:50px;">
                <div class="media-left">
                    <!--                                    <a target="_blank" href="../supplier_logo/--><?php //if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?><!--" data-popup="lightbox">-->
                    <img src="../supplier_logo/<?php if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?>" style=" height: 20vh;width:20vh;margin : 15px 25px 5px 5px;background-color: #ffffff;" class="img-circle" alt="">
                    <!--                                    </a>-->
                </div>

                <div class="media-body">
                    <h5 style="font-size: xx-large;background-color: #009688; color: #ffffff;padding : 5px; text-align: center;" class="text-semibold no-margin"><?php if($cus_name != ""){ echo $cus_name; }else{ echo "Customer Name";} ?> </h5>
                    <small style="font-size: x-large;margin-top: 15px;" class="display-block"><b>Part Family :-</b> <?php echo $pm_part_family_name; ?></small>
                    <small style="font-size: x-large;" class="display-block"><b>Part Number :-</b> <?php echo $pm_part_number; ?></small>
                    <small style="font-size: x-large;" class="display-block"><b>Part Name :-</b> <?php echo $pm_part_name; ?></small>

                </div>
            </div>
            <!--							</div>-->
        </div>
		<?php
		if (!empty($import_status_message)) {
			echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
		}
		?>
		<?php
		if (!empty($_SESSION[import_status_message])) {
			echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
			$_SESSION['message_stauts_class'] = '';
			$_SESSION['import_status_message'] = '';
		}
		?>
    </div>
    <div class="panel panel-flat">
		<?php
		$sql = "select SUM(good_pieces) as good_pieces,SUM(bad_pieces) AS bad_pieces,SUM(rework) as rework from good_bad_pieces where station_event_id ='$station_event_id' ";
		$result1 = mysqli_query($db, $sql);
		$rowc = mysqli_fetch_array($result1);
		$gp = $rowc['good_pieces'];
		$bp = $rowc['bad_pieces'];
		$rwp = $rowc['rework'];
		$tp = $gp + $bp+ $rwp;
		?>
        <div class="row" style="background-color: #f3f3f3;margin: 0px">
            <div class="col-md-3" style="height: 10vh; padding-top: 3vh; font-size: x-large; text-align: center;">
                <span>Total Pieces : <?php echo $tp ?></span>
            </div>
            <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#a8d8a8;">
                <span>Total Good Pieces : <?php echo $gp ?></span>
            </div>
            <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#eca9a9;">
                <span>Total Bad Pieces : <?php echo $bp ?></span>
            </div>
            <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#b1cdff;">
                <span>Rework : <?php echo $rwp ?></span>
            </div>
        </div>
        <div class="panel-heading" style="padding: 50px;">
            <div class="row">
                <div class="search_container"  style="margin-right:10px;">
                    <input id="search" class="search__input"  type="text" placeholder="Search Defect" style="margin-left: 15px;padding: 12px 24px;background-color: transparent;transition: transform 250ms ease-in-out;line-height: 18px;color: #000000;font-size: 18px;background-color: transparent; background-repeat: no-repeat;
        background-size: 18px 18px;
        background-position: 95% center;
        border-radius: 50px;
        border: 1px solid #575756;
        transition: all 250ms ease-in-out;
        backface-visibility: hidden;
        transform-style: preserve-3d;
        " >
                </div>
            </div>
            <!--                            </br>-->
            </br>
            <div class="row">
                <div class="col-md-12">.
                    <iframe height="100" id="resultFrame" style="display: none;" src="./pp.php"></iframe>



                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#view_good_modal_theme_primary" style="background-color:#177b09 !important;margin-top: 10px;width: 100%;height: 10vh; padding-top: 1vh; font-size: large; text-align: center;">IN-SPEC</button>
                </div>
            </div>
            <div class="row">
				<?php
				$i = 1;
				$def_list_arr = array();
				$sql1 = "SELECT * FROM `defect_list` ORDER BY `defect_list_name` ASC";
				$result1 = $mysqli->query($sql1);
				while ($row1 = $result1->fetch_assoc()) {
					$pnums = $row1['part_number_id'];
					$arr_pnums = explode(',', $pnums);
					if (in_array($part_number, $arr_pnums)) {
						array_push($def_list_arr, $row1['defect_list_id']);
					}
				}

				$sql1 = "SELECT sdd.defect_list_id as dl_id FROM sg_defect_group as sdg inner join sg_def_defgroup as sdd on sdg.d_group_id = sdd.d_group_id WHERE FIND_IN_SET('$part_number',sdg.part_number_id) > 0";
				$result1 = $mysqli->query($sql1);
				while ($row1 = $result1->fetch_assoc()) {
					array_push($def_list_arr, $row1['dl_id']);
				}
				$def_list_arr = array_unique($def_list_arr);
				$def_lists = implode("', '", $def_list_arr);
				$sql1 = "SELECT * FROM `defect_list` where  defect_list_id IN ('$def_lists') ORDER BY `defect_list_name` ASC";
				$result1 = $mysqli->query($sql1);
				while ($row1 = $result1->fetch_assoc()) {
					?>
                    <div class="col-md-3">
                        <button type="button" id="view" class="btn btn-primary view_gpbp"  data-buttonid="<?php echo $row1['defect_list_id']; ?>" data-toggle="modal"
                                data-target="#view_modal_theme_primary"  data-defect_name="<?php echo $row1['defect_list_name']; ?>" style="white-space: normal;background-color:#BE0E31 !important;height: 10vh; width:98% ; padding-top: 1vh; font-size: medium; text-align: center;"><?php echo $row1['defect_list_name']; ?></button>

                    </div>
					<?php
					if($i == 4)
					{
						echo "<br/>";
						echo "<br/>";
						echo "<br/>";
						$i = 0;
					}

					$i++;
				}
				?>

            </div>
        </div>

    </div>
    <!-- Basic datatable -->


    <form action="delete_good_bad_piece.php" method="post" class="form-horizontal">
        <input type="hidden" name="station_event_id" value="<?php echo $_GET['station_event_id']; ?>">

        <div class="row">
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button>
            </div>
        </div>
        <br/>
        <!-- Content area -->
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <!--						<div class="panel-heading">
															</div>
			-->
            <table class="table datatable-basic">
                <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll" ></th>
                    <th>S.No</th>
                    <th>Good Pieces</th>
                    <th>Defect Name</th>
                    <th>Bad Pieces</th>
                    <th>Re-Work</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php
				$station_event_id = $_GET['station_event_id'];
				$query = sprintf("SELECT gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces_details as gbpd where gbpd.station_event_id  = '$station_event_id' order by gbpd.bad_pieces_id DESC");
				$qur = mysqli_query($db, $query);
				while ($rowc = mysqli_fetch_array($qur)) {
					$style = "";
					if($rowc['good_pieces'] != ""){
						$style = "style='background-color:#a8d8a8;'";
					}
					if($rowc['bad_pieces'] != ""){
						$style = "style='background-color:#eca9a9;'";
					}
					if($rowc['rework'] != ""){
						$style = "style='background-color:#b1cdff;'";
					}
					?>
                    <tr <?php echo $style; ?>>
                        <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["bad_pieces_id"]; ?>"></td>
                        <td><?php echo ++$counter; ?></td>
                        <td><?php if($rowc['good_pieces'] != ""){echo $rowc['good_pieces']; }else{ echo $line; } ?></td>
                        <td><?php $un = $rowc['defect_name']; if($un != ""){ echo $un; }else{ echo $line; } ?></td>
                        <td><?php if($rowc['bad_pieces'] != ""){echo $rowc['bad_pieces'];}else{ echo $line; } ?></td>
                        <td><?php if($rowc['rework'] != ""){echo $rowc['rework']; }else{ echo $line; } ?></td>
                        <td>
                            <button type="button" id="edit" class="btn btn-info btn-xs"
                                    data-id="<?php echo $rowc['good_bad_pieces_id']; ?>"
                                    data-gbid="<?php echo $rowc['bad_pieces_id']; ?>"
                                    data-seid="<?php echo $station_event_id; ?>"
                                    data-good_pieces="<?php echo $rowc['good_pieces']; ?>"
                                    data-defect_name="<?php echo $rowc['defect_name']; ?>"
                                    data-bad_pieces="<?php echo $rowc['bad_pieces']; ?>"
                                    data-re_work="<?php echo $rowc['rework']; ?>"
                                    data-toggle="modal" style="background-color:#1e73be;"
                                    data-target="#edit_modal_theme_primary">Edit </button>
                            <!--									&nbsp;
                                                                                                                                <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['user_rating_id']; ?>">Delete </button>
                                                        -->
                        </td>
                    </tr>
				<?php } ?>
                </tbody>
            </table>
    </form>

    <!-- /basic datatable -->
    <div id="view_modal_theme_primary" class="modal ">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">
                        Add Bad Piece
                    </h6>
                </div>
                <form action="" id="bad_form" enctype="multipart/form-data" class="form-horizontal"
                      method="post">
                    <input type="hidden" name="station_event_id" value="<?php echo $_GET['station_event_id']; ?>">
                    <input type="hidden" name="line_id" value="<?php echo $p_line_id; ?>">
                    <input type="hidden" name="pe" value="<?php echo $printenabled; ?>">
                    <div class="modal-body">
                        <!--Part Number-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Select Type * : </label>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="bad_type" value="bad_piece" class="styled" checked="checked">
                                                Bad Piece
                                            </label>

                                            <label class="radio-inline">
                                                <input type="radio" name="bad_type" value="rework" class="styled">
                                                Re-Work
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Defect Name * : </label>
                                    <div class="col-lg-8">
                                        <input type="text" name="add_defect_name" id="add_defect_name" class="form-control" readonly
                                               required >
                                        <!--                                                <select  name="add_defect_name" id="add_defect_name"-->
                                        <!--                                                        class="form-control">-->
                                        <!--                                                    <option value="" selected disabled>--- Select Defect Name ----->
                                        <!--                                                    </option>-->
                                        <!--													-->
                                        <!--													--><?php
										//                                                                $sql1 = "SELECT * FROM `defect_list` where part_family_id = '$part_family' ORDER BY `defect_list_name` ASC";
										//                                                                $result1 = $mysqli->query($sql1);
										//                                                                while ($row1 = $result1->fetch_assoc()) {
										//                                                                    echo "<option value='" . $row1['defect_list_id'] . "'>" . $row1['defect_list_name'] . "</option>";
										//                                                                }
										//                                                    ?>
                                        <!--                                                </select>-->

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">No of Pieces * : </label>
                                    <div class="col-lg-8">
                                        <input type="number" name="good_bad_piece_name" id="good_bad_piece_name" class="form-control" placeholder="Enter Pieces..." value="1" required>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submitForm_bad"  style="background-color:#1e73be;">Save</button>

                        </div>
                    </div>
            </div>

            </form>
        </div>
    </div>

    <!-- /IN-SPEC Modal -->

    <div id="view_good_modal_theme_primary" class="modal ">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">
                        Add Good Piece
                    </h6>
                </div>
                <form action="" id="good_form" enctype="multipart/form-data" class="form-horizontal"
                      method="post">
                    <input type="hidden" name="station_event_id" value="<?php echo $_GET['station_event_id']; ?>">
                    <input type="hidden" name="line_id" value="<?php echo $p_line_id; ?>">
                    <input type="hidden" name="pe" value="<?php echo $printenabled; ?>">

                    <div class="modal-body">
                        <!--Part Number-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">No of Pieces * : </label>
                                    <div class="col-lg-8">
                                        <input type="number" name="good_name" id="good_name" class="form-control" placeholder="Enter Pieces..." value="1" required>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            <!--                            <button type="submit" class="btn btn-primary" onclick="submitForm_good('create_good_bad_piece.php')"  style="background-color:#1e73be;">Save</button>-->
                            <button type="submit" class="btn btn-primary" id="submitForm_good"  style="background-color:#1e73be;">Save</button>
                        </div>
                    </div>
            </div>

            </form>
        </div>
    </div>
    <!-- /main charts -->
    <!-- edit modal -->
    <div id="edit_modal_theme_primary" class="modal ">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">Update Good & Bad Pieces</h6>
                </div>
                <form action="" id="edit_form" class="form-horizontal" method="post">
                    <div class="modal-body">

                        <div class="row" id="goodpiece">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Good Pieces * : </label>
                                    <div class="col-lg-8">
                                        <input type="number" name="editgood_name" min="1" id="editgood_name" class="form-control" placeholder="Enter Pieces..." value="1" required>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="badpiece">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Defect Name * : </label>
                                    <div class="col-lg-8">
                                        <input type="text" name="editdefect_name" id="editdefect_name" class="form-control"  required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="badpiece1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Bad Pieces * : </label>
                                    <div class="col-lg-8">
                                        <input type="number" name="editbad_name" min="1" id="editbad_name" class="form-control" placeholder="Enter Pieces..." value="1" >

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="badpiece2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Re-Work * : </label>
                                    <div class="col-lg-8">
                                        <input type="number" name="editre_work" min="1" id="editre_work" class="form-control" placeholder="Enter Pieces..." value="1" >

                                    </div>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="edit_id" id="edit_id" >
                        <input type="hidden" name="edit_gbid" id="edit_gbid" >
                        <input type="hidden" name="edit_seid" id="edit_seid" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="submitForm_edit('create_good_bad_piece.php')"  style="background-color:#1e73be;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->

<script>
    $("#submitForm_good").click(function (e) {

        // function submitForm_good(url) {

        $(':input[type="button"]').prop('disabled', true);
        var data = $("#good_form").serialize();
        //var main_url = "<?php //echo $url; ?>//";
        $.ajax({
            type: 'POST',
            url: 'create_good_bad_piece.php',
            data: data,
            // dataType: "json",
            // context: this,
            async: false,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                // $(':input[type="button"]').prop('disabled', false);
                var line_id = this.data.split('&')[1].split("=")[1];
                var pe = this.data.split('&')[2].split("=")[1];
                var file = '../assets/label_files/' + line_id +'/g_label';
                if(pe == '1'){
                    document.getElementById("resultFrame").contentWindow.ss(file);
                }
                // location.reload();
            }
        });

    });

    $("#submitForm_bad").click(function (e) {

        // function submitForm_good(url) {

        $(':input[type="button"]').prop('disabled', true);
        var data = $("#bad_form").serialize();
        //var main_url = "<?php //echo $url; ?>//";
        $.ajax({
            type: 'POST',
            url: 'create_good_bad_piece.php',
            data: data,
            // dataType: "json",
            // context: this,
            async: false,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                // $(':input[type="button"]').prop('disabled', false);
                var line_id = this.data.split('&')[1].split("=")[1];
                var pe = this.data.split('&')[2].split("=")[1];
                var file = '../assets/label_files/' + line_id +'/b_label';
                if(pe == '1'){
                    document.getElementById("resultFrame").contentWindow.ss(file);
                }
                // location.reload();
            }
        });

    });

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".view_gpbp").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

</script>
<script>
    $(document).on('click', '#view', function () {
        var element = $(this);
        //var edit_id = element.attr("data-id");
        var buttonid = $(this).data("buttonid");
        $("#add_defect_name").val($(this).data("defect_name"));
    });
    $(document).on('click', '#edit', function () {
        var element = $(this);
        var edit_id = element.attr("data-id");
        var edit_gbid = element.attr("data-gbid");
        var edit_seid = element.attr("data-seid");
        var editgood_name = $(this).data("good_pieces");
        var editdefect_name = $(this).data("defect_name");
        var editbad_name = $(this).data("bad_pieces");
        var editre_work = $(this).data("re_work");
        $("#editgood_name").val(editgood_name);
        $("#editdefect_name").val(editdefect_name);
        $("#editbad_name").val(editbad_name);
        $("#editre_work").val(editre_work);
        $("#edit_id").val(edit_id);
        $("#edit_gbid").val(edit_gbid);
        $("#edit_seid").val(edit_seid);

        if(editgood_name != "")
        {
            $("#badpiece").hide();
            $("#badpiece1").hide();
            $("#badpiece2").hide();
            $("#goodpiece").show();
        }else if(editbad_name != ""){
            $("#badpiece").show();
            $("#badpiece1").show();
            $("#badpiece2").hide();
            $("#goodpiece").hide();
        }
        else if(editre_work != "")
        {
            $("#badpiece").show();
            $("#badpiece1").hide();
            $("#badpiece2").show();

            $("#goodpiece").hide();
        }
    });
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('#generate').click(function () {
        let r = Math.random().toString(36).substring(7);
        $('#newpass').val(r);
    })

    $('#choose').on('change', function () {
        var selected_val = this.value;
        if (selected_val == 1 || selected_val == 2) {
            $(".group_div").show();
        } else {
            $(".group_div").hide();
        }
    });


</script>
<script>
    function submitForm_good(url) {

        $(':input[type="button"]').prop('disabled', true);
        var data = $("#good_form").serialize();
        var main_url = "<?php echo $url; ?>";
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }
    function submitForm_bad(url) {

        $(':input[type="button"]').prop('disabled', true);
        var data = $("#bad_form").serialize();
        var main_url = "<?php echo $url; ?>";
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                var line_id = this.data.split('&')[1].split("=")[1];
                var pe = this.data.split('&')[2].split("=")[1];
                var file = '../assets/label_files/' + line_id +'/g_label';
                if(pe == '1'){
                    document.getElementById("resultFrame").contentWindow.ss(file);
                }
            }
        });
    }
    function submitForm_edit(url) {

        $(':input[type="button"]').prop('disabled', true);
        var data = $("#edit_form").serialize();
        var main_url = "<?php echo $url; ?>";
        $.ajax({
            type: 'POST',
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
<?php include('../footer.php') ?>
</body>
</html>