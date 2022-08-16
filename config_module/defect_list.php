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
        <title><?php echo $sitename; ?> | Defect List</title>
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
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
        <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
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


            @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
                .form-horizontal {
                    width: 100%;
                }
                .select2-selection--multiple .select2-search--inline .select2-search__field{
                    padding: 8px 52px!important;
                }
                .select2-selection--multiple:not([class*=bg-]) .select2-search--inline:first-child .select2-search__field {
                    margin-left: -45px!important;
                }
            }




        </style>
    </head>
    <body>
        <!-- Main navbar -->
<?php $cust_cam_page_header = "Defect List";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
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

                                            <form action="" id="create_form" class="form-horizontal" method="post">
                                                <div class="row">
                                                <div class="col-md-5" style="margin-bottom:20px;">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Defect Name" required>
                                                </div>
                                                </div>
                                                <div class="row">
                                                <div class="col-md-8" style="margin-bottom:20px;">
                                                    <div class="form-group">
<!--                                                        <label class="col-lg-4 control-label">Account Type * : </label>-->
                                                        <div class="col-lg-8">

                                                            <select class="select-border-color select-access-multiple-open" data-placeholder="Select Part(s)..."  name="part_number[]" id="part_number" multiple="multiple"  >

<!--                                                            <select required name="part_number[]" id="part_number" data-placeholder="Select Part(s)" class="select-border-color select-access-multiple-open"-->
<!--                                                                    multiple="multiple">-->
<!--                                                                <option value="" selected disabled>--- Select Part Number ---</option>-->
																<?php
//																$sql1 = "SELECT * FROM `pm_part_number` order by part_name ASC";
																$sql1 = "SELECT pm_part_number_id ,part_number, part_name , pm_part_family.part_family_name as part_family_name FROM `pm_part_number` inner join pm_part_family on pm_part_number.part_family = pm_part_family.pm_part_family_id where pm_part_number.is_deleted = 0 order by part_name ASC";
																$result1 = $mysqli->query($sql1);
																//                                            $entry = 'selected';
																while ($row1 = $result1->fetch_assoc()) {
																	echo "<option id='" . $row1['pm_part_number_id'] . "'  value='" . $row1['pm_part_number_id'] . "'  >" . $row1['part_number'] . "  -  " . $row1['part_name'] . "  -  " . $row1['part_family_name'] . "</option>";
																}
																?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                </div>
                               <?php if ($temp == "one") { ?>
                                    <div class="alert alert-success no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold">Job</span> Created Successfully.
                                    </div>
                                <?php } ?>
                                <?php if ($temp == "two") { ?>
                                    <div class="alert alert-success no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold">Job</span> Updated Successfully.
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
                            </div>
                            <div class="panel-footer p_footer">
                             <button type="submit" class="btn btn-primary" onclick="submitForm_create('create_defect_list.php')" style="background-color:#1e73be;">Create Defect List</button>
                             </div>
                            </form>
                        </div>
                        <form action="" id="delete_form" method="post" class="form-horizontal">
                            <div class="row">
                               
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary" onclick="submitForm('delete_defect_list.php')"
                                                style="background-color:#1e73be;">Delete
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="choose" id="choose"  required>
                                            <option value="" disabled selected>Select Action </option>
                                            <option value="1" >Add to Defect Group </option>
                                            <option value="2" >Remove from Defect Group </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 group_div" style="display:none">
                                        <select class="form-control" name="group_id" id="group_id"   required>
                                            <option value="" disabled selected>Select Defect Group </option>
											<?php
											$sql1 = "SELECT * FROM `sg_defect_group`";
											$result1 = $mysqli->query($sql1);
											while ($row1 = $result1->fetch_assoc()) {
												echo "<option value='" . $row1['d_group_id'] . "'>" . $row1['d_group_name'] . "</option>";
											}
											?>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-primary" onclick="submitForm11('../defect_list_option_backend.php')"  style="background-color:#1e73be;">Go</button>
                                    </div>
                            </div>
                            <br/>
                            <div class="panel panel-flat">
                                <table class="table datatable-basic" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" ></th>
                                            <th class="sno">S.No</th>
                                            <th class="d_name">Defect Name / Group</th>
                                            <th class="p_name">Part Name(s)</th>
<!--                                      <th>Created At</th>-->
<!--                                      <th>Updated At</th>-->
                                            <th class="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$query = sprintf("SELECT * FROM  sg_defect_group ");
									$qur = mysqli_query($db, $query);
									while ($rowc = mysqli_fetch_array($qur)) {
										?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="delete_check[]" name="delete_check[]" disabled value="<?php echo $rowc["d_group_id"]; ?>">
                                            </td>
                                            <td><?php echo ++$counter; ?></td>
                                            <td><?php echo $rowc["d_group_name"]; ?></td>
											<?php
											$part_fam_nm = '';
											$pm_part_number_id = $rowc['part_number_id'];
											$arr_pm_part_number_ids = null;
											$arr_pm_part_number_ids = explode(',', $pm_part_number_id);
											array_pop($arr_pm_part_number_ids);
											$i=0;
											$count = sizeof($arr_pm_part_number_ids);
											$array_pnum = null;
											foreach ($arr_pm_part_number_ids as $arr_pm_part_number_id) {
												if($i==0){
													$array_pnum .= "'" .$arr_pm_part_number_id . "'";
												}else{
													$array_pnum .= "," . "'" .$arr_pm_part_number_id . "'";
												}
												$i++;

											}
											$sql22 = "SELECT * FROM  pm_part_number where pm_part_number_id in ($array_pnum) order by part_name ASC";
											//                                                $qurtemp = $mysqli->query($sql22);
											$qurtemp = mysqli_query($db,$sql22);
											$i=0;
											$part_nm=null;
											while ($rowctemp = mysqli_fetch_array($qurtemp)) {
												$part_nm .= $rowctemp["part_name"] . ' ,  ';
											}
											$part_nm = rtrim($part_nm,' ,  ');
											?>
                                            <td><?php echo $part_nm; ?></td>
                                            <!--                                         <td>--><?php //echo $rowc['created_at']; ?><!--</td>-->
                                            <!--                                        <td>--><?php //echo $rowc['updated_at']; ?><!--</td>-->
                                            <td>
<!--                                                <button type="button" id="edit_grp" class="btn btn-info btn-xs" data-id="--><?php //echo $rowc['d_group_id']; ?><!--" data-type="grp" data-name="--><?php //echo $rowc['d_group_name']; ?><!--" data-part_number="--><?php //echo $rowc['part_number_id']; ?><!--"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary_group">Edit </button>-->
                                                <!--									&nbsp;
                                                                             <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['job_title_id']; ?>">Delete </button>
                                                    -->
                                                <a href="defect_group_page.php?id=<?php echo $rowc['d_group_id'];; ?>" class="btn btn-primary" style="background-color:#1e73be;">Edit</a>

                                            </td>
                                        </tr>
									<?php } ?>
                                    <?php
                                    $query = sprintf("SELECT * FROM  defect_list ");
                                    $qur = mysqli_query($db, $query);
                                    while ($rowc = mysqli_fetch_array($qur)) {
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["defect_list_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $rowc["defect_list_name"]; ?></td>
												<?php
												$part_fam_nm = '';
                                                $pm_part_number_id = $rowc['part_number_id'];
												$arr_pm_part_number_ids = null;
												$arr_pm_part_number_ids = explode(',', $pm_part_number_id);
												array_pop($arr_pm_part_number_ids);
												$i=0;
												$count = sizeof($arr_pm_part_number_ids);
												$array_pnum = null;
												foreach ($arr_pm_part_number_ids as $arr_pm_part_number_id) {
													if($i==0){
														$array_pnum .= "'" .$arr_pm_part_number_id . "'";
													}else{
														$array_pnum .= "," . "'" .$arr_pm_part_number_id . "'";
													}
												    $i++;

												}
												$sql22 = "SELECT * FROM  pm_part_number where pm_part_number_id in ($array_pnum) order by part_name ASC";
//                                                $qurtemp = $mysqli->query($sql22);
												$qurtemp = mysqli_query($db,$sql22);
                                                $i=0;
												$part_nm=null;
                                                while ($rowctemp = mysqli_fetch_array($qurtemp)) {
                                                    $part_nm .= $rowctemp["part_name"] . ' ,  ';
                                                }
												$part_nm = rtrim($part_nm,' ,  ');
                                                ?>
                                                <td><?php echo $part_nm; ?></td>
      <!--                                         <td>--><?php //echo $rowc['created_at']; ?><!--</td>-->
      <!--                                        <td>--><?php //echo $rowc['updated_at']; ?><!--</td>-->
                                                <td>
<!--                                                    <button type="button" id="
" class="btn btn-info btn-xs" data-id="--><?php //echo $rowc['defect_list_id']; ?><!--" data-type="def" data-name="--><?php //echo $rowc['defect_list_name']; ?><!--" data-part_number="--><?php //echo $rowc['part_number_id']; ?><!--"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary">Edit </button>-->
                                                    <!--									&nbsp;
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['job_title_id']; ?>">Delete </button>
                                                    -->
                                                    <a href="defect_list_page.php?id=<?php echo  $rowc['defect_list_id']; ?>" class="btn btn-primary" data-id="<?php echo $rowc['defect_list_id']; ?>"  style="background-color:#1e73be;">Edit</a>

                                                </td>
                                            </tr>
                             <?php } ?>
                                    </tbody>
                                </table>
                        </form>					</div>
                    <!-- /basic datatable -->
                    <!-- /main charts -->

                    <!-- /dashboard content -->
                    <script>
                        // $("#edit_part_number").select2({
                        //     dropdownParent: $("#edit_modal_theme_primary")
                        // });
                        $(document).on('click', '#delete', function () {
                            var element = $(this);
                            var del_id = element.attr("data-id");
                            var info = 'id=' + del_id;
                            $.ajax({type: "POST", url: "ajax_job_title_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });</script>
                    <script>

                        $("#checkAll").click(function () {
                            $('input:checkbox').not(this).prop('checked', this.checked);
                        });
                        $(".select").select2();
                        $(document).on('select2:open', () => {
                            document.querySelector('.select2-search__field').focus();
                        });
                        function submitForm(url) {

                            $(':input[type="button"]').prop('disabled', true);
                            var data = $("#delete_form").serialize();
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

                        function submitForm11(url) {
                            $(':input[type="button"]').prop('disabled', true);
                            var data = $("#delete_form").serialize();
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



                        function submitForm_create(url) {

                            $(':input[type="button"]').prop('disabled', true);
                            var data = $("#create_form").serialize();
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

                        $('#choose').on('change', function () {
                            var selected_val = this.value;
                            if (selected_val == 1 || selected_val == 2) {
                                $(".group_div").show();
                            } else {
                                $(".group_div").hide();
                            }
                            if (selected_val == 5 ) {
                                $('#delete_form').submit();
                            }
                        });
                    </script>
                </div>
                <!-- /content area -->

    </div>
    <!-- /page container -->
    <?php include ('../footer.php') ?>
<script>
window.onload = function() {
    history.replaceState("", "", "<?php echo $scriptName; ?>config_module/defect_list.php");
}
</script>
</body>
</html>
