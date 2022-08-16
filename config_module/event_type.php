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
	$name = $_POST['name'];
	$stations1 = $_POST['stations'];
	foreach ($stations1 as $stations) {
		$array_stations .= $stations . ",";
	}
//create
	if ($name != "") {
		$name = $_POST['name'];
		$color_code = $_POST['color_code'];
		$event_cat = $_POST['event_cat'];
		$sql = "select (MAX(so) + 1) as next_seq_num from event_type";
		$res = mysqli_query($db, $sql);
		$seq = ($res ->fetch_assoc())['next_seq_num'];
//		$next_seq = ‌‌$seq['next_seq_num'];
		$sqlquery = "INSERT INTO `event_type`(`event_type_name`,`stations`,`event_cat_id`,`so`,`color_code`,`created_at`,`updated_at`) VALUES ('$name','$array_stations','$event_cat','$seq','$color_code','$chicagotime','$chicagotime')";
		if (!mysqli_query($db, $sqlquery)) {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Event Type with this Name Already Exists';
		} else {
			$temp = "one";
		}
	}
//edit
	$edit_name = $_POST['edit_name'];
	if ($edit_name != "") {
		$id = $_POST['edit_id'];
		$actual_so = $_POST['act_so'];
		$edit_so = $_POST['edit_so'];
		$edit_stations1 = $_POST['edit_stations'];
		foreach ($edit_stations1 as $edit_stations) {
			$array_stations .= $edit_stations . ",";
		}
		$edit_color_code = $_POST['edit_color_code'];
		$edit_event_cat = $_POST['edit_event_cat'];
		$set = '';
		$where = '';
        if( $edit_so != $actual_so){

            if( $actual_so < $edit_so ){
				$set = 'so = so - 1';
				$where = 'so > ' . $actual_so . ' and so <= ' . $edit_so;
			}else{
				$set = 'so = so + 1';
				$where = 'so < ' . $actual_so . ' and so >= ' . $edit_so;
            }
        }
        if($set != '' && $where != ''){
			$sql = 'update event_type set ' .  $set . ' where ' . $where;
			$result1 = mysqli_query($db, $sql);
        }
		$sql = "update event_type set stations = '$array_stations', so = '$edit_so' , event_cat_id='$edit_event_cat' ,event_type_name='$_POST[edit_name]',color_code='$_POST[edit_color_code]',updated_at='$chicagotime' where event_type_id ='$id'";
		$result1 = mysqli_query($db, $sql);
		if ($result1) {
			$temp = "two";
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Event Type with this Name Already Exists';
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
    <title><?php echo $sitename; ?> | Event Type</title>
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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
</head>
<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
        .col-lg-6 {
            float: right;
            width: 60% !important;
        }


        label.col-lg-4.control-label {
            width: 40%;
        }
    }
</style>

<!-- Main navbar -->
<?php $cust_cam_page_header = "Event Type";
include("../header_folder.php");
include("../admin_menu.php");
include("../heading_banner.php");?>

<body class="alt-menu sidebar-noneoverflow">
<!-- Page container -->
<div class="page-container">
            <!-- Content area -->
            <div class="content">
                <!-- Main charts -->
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                <form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Event Type * : </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" name="name" id="name" class="form-control"
                                                               placeholder="Enter Event Type" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label">Select Event Category : </label>
                                                    <div class="col-lg-6">
                                                        <select name="event_cat" id="event_cat" class="select-border-color select-access-multiple-open" required>
                                                            <option value="" selected disabled>--- Select Event Category ---</option>
															<?php
															$sql1 = "SELECT * FROM `events_category` where is_deleted != 1";
															$result1 = $mysqli->query($sql1);
															while ($row1 = $result1->fetch_assoc()) {
																echo "<option value='" . $row1['events_cat_id'] . "'$entry>" . $row1['events_cat_name'] . "</option>";
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
                                                    <label class="col-lg-4 control-label">Select Color Code * : </label>
                                                    <div class="col-lg-6">
                                                        <input type="color" id="color_code" name="color_code" value="#ff0000"  required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                            <label class="col-lg-4 control-label">Select Station(s) : </label>
                                            <div class="col-lg-6">
                                                <div class="form-group">
													<?php
//													$query = sprintf("SELECT * FROM  event_type");
//													$qur = mysqli_query($db, $query);
//													 $rowc = mysqli_fetch_array($qur);
													?>
                                                    <select class="select select-border-color select-access-multiple-open" data-placeholder="Add Stations..." value="<?php echo $rowc["stations"]; ?>" name="stations[]" id="stations" multiple="multiple"  >
<!--														--><?php
////														$arrteam = explode(',', $rowc["stations"]);
//														$sql1 = "SELECT DISTINCT(`line_id`) , line_name FROM `cam_line` where enabled = 1 order by line_name";
//														$result1 = $mysqli->query($sql1);
//														while ($row1 = $result1->fetch_assoc()) {
//															if (in_array($row1['line_id'], $arrteam)) {
//																$selected = "selected";
//															} else {
//																$selected = "";
//															}
////
//															echo "<option value='" . $row1['line_id'] . "' $selected>" . $row1['line_name'] . "</option>";
//														}
//														?>
<!--                                                        <option value="" selected disabled>--- Select Station ---</option>-->
														<?php
														$sql1 = "SELECT * FROM `cam_line` where enabled = 1 order by line_name";
														$result1 = $mysqli->query($sql1);
														while ($row1 = $result1->fetch_assoc()) {
															echo "<option value='" . $row1['line_id'] . "'$entry>" . $row1['line_name'] . "</option>";
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="stations_open()">Add More</button>
                                            </div>
                                                </div>
                                            </div>
                                        </div>

						<?php if ($temp == "one") { ?>
                            <div class="alert alert-success no-border">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                            class="sr-only">Close</span></button>
                                <span class="text-semibold">Event Type</span> Created Successfully.
                            </div>
						<?php } ?>
						<?php if ($temp == "two") { ?>
                            <div class="alert alert-success no-border">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                            class="sr-only">Close</span></button>
                                <span class="text-semibold">Event Type</span> Updated Successfully.
                            </div>
						<?php } ?>
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

                    <div class="panel-footer p_footer">
                      <button type="submit" class="btn btn-primary"style="background-color:#1e73be;">Create Event Type
                      </button>
               </div>
                </form>

                </div>
                </div>

                <form action="delete_event_type.php" method="post" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Delete
                            </button>
                        </div>
                    </div>
                    <br/>
                    <div class="panel panel-flat">
                        <table class="table datatable-basic">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>S.No</th>
                                <th>Event Category</th>
                                <th>Event Type</th>
                                <th>Color Code</th>
                                <th>Event Sequence</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  event_type as et inner join events_category as ec on et.event_cat_id = ec.events_cat_id where et.is_deleted!='1' order by so ASC");
							$qur = mysqli_query($db, $query);
							$total_rows = $qur->num_rows;
							while ($rowc = mysqli_fetch_array($qur)) {
							    $so = $rowc['so'];
								?>
                                <tr>
                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]"
                                               value="<?php echo $rowc["event_type_id"] . '_' . $so ; ?>">
                                        <input type="hidden"  id="del_check" name="del_check" value="<?php echo $so; ?>">
<!--                                    <input type="hidden" hidden name="del_sq[]" id="del_sq[]" value="--><?php //echo $so; ?><!--">-->
                                    </td>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php echo $rowc["events_cat_name"]; ?></td>
                                    <td><?php echo $rowc["event_type_name"]; ?></td>
                                    <td><input type="color" id="color_code" name="color_code" value="<?php echo $rowc["color_code"]; ?>"  disabled></td>
                                    <td><?php echo $so; ?></td>
                                    <!--                                        <td>-->
									<?php //echo $rowc['updated_at']; ?><!--</td>-->
                                    <td>
<!--                                        <button type="button" id="edit" class="btn btn-info btn-xs"-->
<!--                                                data-id="--><?php //echo $rowc['event_type_id']; ?><!--"-->
<!--                                                data-name="--><?php //echo $rowc['event_type_name']; ?><!--"-->
<!--                                                data-event-cat="--><?php //echo $rowc['events_cat_id']; ?><!--"-->
<!--                                                data-color_code="--><?php //echo $rowc['color_code']; ?><!--"-->
<!--                                                data-so="--><?php //echo $rowc['so']; ?><!--"-->
<!--                                                data-stations="--><?php //echo $rowc['stations']; ?><!--"-->
<!--                                                data-count="--><?php //echo $total_rows; ?><!--" data-toggle="modal"-->
<!--                                                style="background-color:#1e73be;"-->
<!--                                                data-target="#edit_modal_theme_primary">Edit-->
<!--                                        </button>-->
                                        <a href="event_type_page.php?id=<?php echo  $rowc['event_type_id']; ?>" class="btn btn-primary" data-id="<?php echo $rowc['event_type_name']; ?>"  style="background-color:#1e73be;">Edit</a>

                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                </form>

            <!-- edit modal -->
<!--            <div id="edit_modal_theme_primary" class="modal" role="dialog">-->
<!--                <div class="modal-dialog">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header bg-primary">-->
<!--                            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                            <h6 class="modal-title">Update Event Type</h6>-->
<!--                        </div>-->
<!--                        <form action="" id="user_form" class="form-horizontal" method="post">-->
<!--                            <div class="modal-body">-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <div class="form-group">-->
<!--                                            <label class="col-lg-5 control-label" style="color: #ffff;">Event Category * : </label>-->
<!--                                            <div class="col-lg-7">-->
<!--                                                <select name="edit_event_cat" id="edit_event_cat" class="select-border-color select-access-multiple-open">-->
<!--                                                    <option value="" disabled>--- Select Event Category ---</option>-->
<!--													--><?php
//													$sql1 = "SELECT * FROM `events_category`";
//													$result1 = $mysqli->query($sql1);
//													while ($row1 = $result1->fetch_assoc()) {
//														echo "<option value='" . $row1['events_cat_id'] . "'$entry>" . $row1['events_cat_name'] . "</option>";
//													}
//													?>
<!--                                                </select>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <div class="form-group">-->
<!--                                            <label class="col-lg-5 control-label" style="color: #ffff;">Event Type * :</label>-->
<!--                                            <div class="col-lg-7">-->
<!--                                                <input type="text" name="edit_name" id="edit_name" class="form-control"-->
<!--                                                       required>-->
<!--                                                <input type="hidden" name="edit_id" id="edit_id">-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <div class="form-group">-->
<!--                                            <label class="col-lg-5 control-label" style="color: #ffff;">Select Station(s) : </label>-->
<!--                                            <div class="col-lg-7">-->
<!--                                                <div class="form-group">-->
<!--													--><?php
//													$query = sprintf("SELECT * FROM  event_type");
//													$qur = mysqli_query($db, $query);
//													$rowc = mysqli_fetch_array($qur);
//													?>
<!--                                                    <select required class="select-border-color" data-placeholder=""  name="edit_stations[]" id="edit_stations" multiple="multiple"  >-->
<!--<!--														-->--><?php
//														$arrteam = explode(',', $rowc["stations"]);
//														$sql1 = "SELECT DISTINCT(`line_id`) , line_name FROM `cam_line` where enabled = 1 order by line_name";
//														$result1 = $mysqli->query($sql1);
//														while ($row1 = $result1->fetch_assoc()) {
////															if (in_array($row1['line_id'], $arrteam)) {
////																$selected = "selected";
////															} else {
////																$selected = "";
////															}
////
//															echo "<option id='" . $row1['line_id'] . "' value='" . $row1['line_id'] . "' $selected>" . $row1['line_name'] . "</option>";
//														}
////														?>
<!--                                                    </select>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div>-->
<!--                                                <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="edit_stations_open()">Add More</button>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <div class="form-group">-->
<!--                                            <label class="col-lg-5 control-label" style="color: #ffff;">Event Sequence * : </label>-->
<!--                                            <div class="col-lg-7">-->
<!--                                                <select name="edit_so" id="edit_so" class="select-border-color select-access-multiple-open">-->
<!--													--><?php
//													$r_count = 0;
//													while ($r_count < $total_rows) {
//														$r_count = $r_count + 1;
//														echo "<option value='" . $r_count . "'>" . $r_count . "</option>";
//													}
//													?>
<!--                                                </select>-->
<!--                                                <input type="hidden" name="act_so" id="act_so">-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <div class="form-group">-->
<!--                                            <label class="col-lg-5 control-label" style="color: #ffff;">Color Code * : </label>-->
<!--                                            <div class="col-lg-7">-->
<!--                                                <input type="color" id="edit_color_code" name="edit_color_code" value="#ff0000">-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="modal-footer">-->
<!--                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
<!--                                <button type="submit" class="btn btn-primary">Save</button>-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <!-- Dashboard content -->
            <!-- /dashboard content -->
<!--            <script> $(document).on('click', '#delete', function () {-->
<!--                    var element = $(this);-->
<!--                    var del_id = element.attr("data-id");-->
<!--                    var info = 'id=' + del_id;-->
<!--                    $.ajax({-->
<!--                        type: "POST", url: "ajax_job_title_delete.php", data: info, success: function (data) {-->
<!--                        }-->
<!--                    });-->
<!--                    $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");-->
<!--                });-->
<!--            </script>-->
<!--            <script>-->
<!--                $(document).on('click', '#edit', function () {-->
<!--                    var element = $(this);-->
<!--                    var edit_id = element.attr("data-id");-->
<!--                    var name = $(this).data("name");-->
<!--                    var event_cat = $(this).data("event-cat");-->
<!--                    var so = $(this).data("so");-->
<!--                    var stations = $(this).data("stations");-->
<!--                    var color_code = $(this).data("color_code");-->
<!--                    var total_row = $(this).data("count");-->
<!--                    const sb = document.querySelector('#edit_stations');-->
<!--                    // create a new option-->
<!--                    var stations1 = $(this).data("stations").split(",");-->
<!--                    var options = sb.options;-->
<!--                    // $("#select2Input").select2({ dropdownParent: "#modal-content" });-->
<!--                    $('#edit_modal_theme_primary .select2 .selection .select2-selection--multiple .select2-selection__choice').remove();-->
<!---->
<!--                    for (var i = 0; i < options.length; i++) {-->
<!--                          if(stations1.includes(options[i].value)){ // EDITED THIS LINE-->
<!--                              options[i].selected="selected";-->
<!--                              options[i].className = ("select2-results__option--highlighted");-->
<!--                             var opt = document.getElementById(options[i].value).outerHTML.split(">");-->
<!--                              $('#select2-results .select2-results__option').prop('selectedIndex',i);-->
<!--                             var gg = '<li class="select2-selection__choice" title="' + opt[1].replace('</option','') + '"><span class="select2-selection__choice__remove" role="presentation">×</span>' + opt[1].replace('</option','') + '</li>';-->
<!--                            $('#edit_modal_theme_primary ul.select2-selection__rendered').append(gg);-->
<!---->
<!--                            // $('.select2-search__field').style.visibility='hidden';-->
<!--                        }-->
<!--                    }-->
<!---->
<!--            </script>-->
        </div>
        <!-- /content area -->
</div>
    <!-- /main content -->



<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>config_module/event_type.php");
    }
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    function stations_open()
    {
        $("#stations").select2("open");
    }
    function edit_stations_open()
    {
        // $('.select2-search__field').style.visibility='show';
        // $("#edit_stations").select2("open");
        // $('.select2-container select2-container--default select2-container--open .select2-results .select2-results__option').addClass("select2-results__option--highlighted");

    }
</script>
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js">
</body>
</html>