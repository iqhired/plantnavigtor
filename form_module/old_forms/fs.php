<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	header('location: ../logout.php');
}
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
    <title>
		<?php echo $sitename; ?> | Create Form</title>
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <style>
        .sidebar-default .navigation li>a {
            color: #f5f5f5
        }

        ;
        a:hover {
            background-color: #20a9cc;
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
        }

        span.select2-selection.select2-selection--multiple {
            border-bottom: 1px solid #1e73be !important;
        }



        .contextMenu{ position:absolute;  width:min-content; left: -18px; background:#e5e5e5; z-index:999;}


        .arrow {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
        }

        .right {
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
        }

        .left {
            transform: rotate(135deg);
            -webkit-transform: rotate(135deg);
        }

        .up {
            transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
        }

        .down {
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
        }
    </style>
</head>

<body>
<!-- Main navbar -->
<?php
$cam_page_header = "Create Form";
include("../header_folder.php");
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main sidebar -->
        <!-- User menu -->
        <!-- /user menu -->
        <!-- Main navigation -->
		<?php include("../admin_menu.php"); ?>
        <!-- /main navigation -->
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Page header -->
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Main charts -->
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Create Form</h5>
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
						if (!empty($_SESSION[import_status_message])) {
							echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
							$_SESSION['message_stauts_class'] = '';
							$_SESSION['import_status_message'] = '';
						}
						?>
                        <hr/>
                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $rowc['sg_communicator_config_id']; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="fs_backend.php" id="form_settings" enctype="multipart/form-data" class="form-horizontal" method="post">
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Name : </label>
                                        <div class="col-md-6">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Form Name" required> </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Form Type : </label>
                                        <div class="col-md-6">
                                            <select name="form_type" id="form_type" class="select" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Form Type ---</option>
												<?php
												$sql1 = "SELECT * FROM `form_type` ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['form_type_id'] . "'  >" . $row1['form_type_name'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Station : </label>
                                        <div class="col-md-6">
                                            <select name="station" id="station" class="select" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Station ---</option>
												<?php
												$sql1 = "SELECT * FROM `cam_line` ORDER BY `line_name` ASC";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Part Family : </label>
                                        <div class="col-md-6">
                                            <select name="part_family" id="part_family" class="select" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Family ---</option>
												<?php
												$sql1 = "SELECT * FROM `pm_part_family` ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['pm_part_family_id'] . "'  >" . $row1['part_family_name'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Part Number : </label>
                                        <div class="col-md-6">
                                            <select name="part_number" id="part_number" class="select" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Number ---</option>
												<?php
												$sql1 = "SELECT * FROM `pm_part_number` ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													echo "<option value='" . $row1['pm_part_number_id'] . "'  >" . $row1['part_number'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Image : </label>
                                        <div class="col-md-6">
                                            <input type="file" name="image" id="image" class="form-control" multiple> </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">PO Number : </label>
                                        <div class="col-md-6">
                                            <input type="text" name="po_number" id="po_number" class="form-control"> </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">DA Number : </label>
                                        <div class="col-md-6">
                                            <input type="text" name="da_number" id="da_number" class="form-control"> </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Out of tolerance Mail List : </label>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="select-border-color" data-placeholder="Tolerance Mail List..." value="<?php echo $rowc[" teams "]; ?>" name="out_of_tolerance_mail_list[]" id="out_of_tolerance_mail_list" multiple="multiple">
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
                                        <div>
                                            <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group1()">Add More</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Out of Control List : </label>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="select-border-color select-access-multiple-open" data-placeholder="Out of Control List ..." name="out_of_control_list[]" id="out_of_control_list" multiple="multiple">
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
                                        <div>
                                            <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group2()">Add More</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Notification List : </label>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="select-border-color select-access-multiple-open" data-placeholder="Notification List ..." name="notification_list[]" id="notification_list" multiple="multiple">
													<?php
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
                                        <div>
                                            <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group2()">Add More</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-8 control-label">*form is not filled within 30 min of the time then Notification List will get mail</label>
                                    </div>
                                    <div class="row">
                                        <!--<div class="col-md-4">-->
                                        <label class="col-lg-2 control-label">Notes : </label>
                                        <div class="col-md-6">
											<textarea id="notes" name="form_create_notes" rows="4" placeholder="Enter Notes..." class="form-control">
											</textarea>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Needs Approval : </label>
                                        <div class="col-md-6">
                                            <select name="need_approval" id="need_approval" class="select" data-style="bg-slate">
                                                <!--  <option value="" selected disabled>--- Select Options ---</option> -->
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <label class="col-lg-2 control-label">Approval By : </label>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="select-border-color select-access-multiple-open" data-placeholder="Approval By ..." name="approval_by[]" id="approval_by" multiple="multiple">
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
                                        <div>
                                            <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group2()">Add More</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--<div class="col-md-4">-->
                                        <label class="col-lg-2 control-label">Valid From : </label>
                                        <div class="col-md-6">
                                            <input type="date" name="valid_from" id="valid_from" class="form-control"> </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <!--<div class="col-md-4">-->
                                        <label class="col-lg-2 control-label">Valid Till : </label>
                                        <div class="col-md-6">
                                            <input type="date" name="valid_till" id="valid_till" class="form-control"> </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <!--<div class="col-md-4">-->
                                        <label class="col-lg-2 control-label">Frequency : </label>
                                        <div class="col-md-3">
                                            <select name="duration_hh" id="duration_hh" class="form-control">
                                                <option value="" disabled selected>--- Select Hours ---</option>
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="duration_mm" id="duration_mm" class="form-control">
                                                <option value="" disabled selected>--- Select Minutes ---</option>
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                                <option value="32">32</option>
                                                <option value="33">33</option>
                                                <option value="34">34</option>
                                                <option value="35">35</option>
                                                <option value="36">36</option>
                                                <option value="37">37</option>
                                                <option value="38">38</option>
                                                <option value="39">39</option>
                                                <option value="40">40</option>
                                                <option value="41">41</option>
                                                <option value="42">42</option>
                                                <option value="43">43</option>
                                                <option value="44">44</option>
                                                <option value="45">45</option>
                                                <option value="46">46</option>
                                                <option value="47">47</option>
                                                <option value="48">48</option>
                                                <option value="49">49</option>
                                                <option value="50">50</option>
                                                <option value="51">51</option>
                                                <option value="52">52</option>
                                                <option value="53">53</option>
                                                <option value="54">54</option>
                                                <option value="55">55</option>
                                                <option value="56">56</option>
                                                <option value="57">57</option>
                                                <option value="58">58</option>
                                                <option value="59">59</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <br/>
                                    <hr/>

                                    <button type="button" name="add_more" id="add_more" class="btn btn-primary legitRipple" style="background-color:#1e73be;">Add More Form Items</button>

                                    <input type="hidden" id="collapse_id" value="1">
                                    <div class="query_rows">

                                    </div>
                                    <br/>

                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Submit</button>
                                        </div>
                                    </div>
                                    <br/> </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /main charts -->
                <!-- edit modal -->
                <!-- Dashboard content -->
                <!-- /dashboard content -->
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->
<?php include ('../footer.php') ?>
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>form_module/fs.php");
    }
</script>
<script>
    function submitFormSettings(url) {
        //          $(':input[type="button"]').prop('disabled', true);
        var data = $("#form_settings").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(data) {
                // $("#textarea").val("")
                // window.location.href = window.location.href + "?aa=Line 1";
                //                   $(':input[type="button"]').prop('disabled', false);
                //                   location.reload();
                //$(".enter-message").val("");
            }
        });
    }
</script>
<script>
    $( document ).ready(function() {

        $(".binary_section").hide();
        $("input[name='item']").click(function(){
            if($('input:radio[name=item]:checked').val() == "numeric"){
                $(".binary_section").hide();
                $(".numeric_section").show();
            }

            if($('input:radio[name=item]:checked').val() == "binary"){
                $(".numeric_section").hide();
                $(".binary_section").show();
            }

            if($('input:radio[name=item]:checked').val() == "text"){
                $(".numeric_section").hide();
                $(".binary_section").hide();
            }

            if($('input:radio[name=item]:checked').val() == "header"){
                $(".numeric_section").hide();
                $(".binary_section").hide();
            }


        })

        $(document).on("click","#add_more",function() {
            //var html_content = '<div class="qry_section"><button type="button" name="add_more" id="add_more" class="btn btn-primary legitRipple" style="background-color:#1e73be">Add More Query</button><div class="row"><div class="col-md-2"><label for="query_text">Query Text :</label></div><div class="col-md-6"><input class="form-control" name="query_text" id="query_text" autocomplete="off" placeholder="Enter Query" required></div></div><br><div class="row"><div class="col-md-2"><label for="item_class">ITEM CLASS:</label></div><div class="col-md-6"><div class="form-check form-check-inline"><input type="radio" id="numeric" name="item" value="numeric" class="form-check-input" checked><label for="numeric" class="item_label">Numeric</label><input type="radio" id="binary" name="item" value="binary" class="form-check-input"><label for="binary" class="item_label">Binary</label><input type="radio" id="text" name="item" value="text" class="form-check-input"><label for="text" class="item_label">Text</label><input type="radio" id="header" name="item" value="header" class="form-check-input"><label for="header" class="item_label">Header</label></div></div></div><br><div class="numeric_section"><div class="row"><div class="col-md-2"><label for="normal">Normal:</label></div><div class="col-md-6"><input class="form-control" name="normal" id="normal" autocomplete="off"></div></div><br><div class="row"><div class="col-md-2"><label for="lower_tolerance">LowerTolerance:</label></div><div class="col-md-6"><input class="form-control" name="lower_tolerance" id="lower_tolerance" autocomplete="off"></div></div><br><div class="row"><div class="col-md-2"><label for="upper_tolerance">UpperTolerance:</label></div><div class="col-md-6"><input class="form-control" name="upper_tolerance" id="upper_tolerance" autocomplete="off"></div></div><br></div><div class="binary_section"><div class="row"><div class="col-md-2"><label for="default">Default:</label></div><div class="col-md-6"><div class="form-check form-check-inline"><input type="radio" id="none" name="default_binary" value="none" class="form-check-input" checked><label for="none" class="item_label">None</label><input type="radio" id="yes" name="default_binary" value="yes" class="form-check-input"><label for="yes" class="item_label">Yes</label><input type="radio" id="no" name="default_binary" value="no" class="form-check-input"><label for="no" class="item_label">No</label></div></div></div><br><div class="row"><div class="col-md-2"><label for="normal">Normal:</label></div><div class="col-md-6"><div class="form-check form-check-inline"><input type="radio" id="yes" name="normal_binary" value="yes" class="form-check-input" checked><label for="yes" class="item_label">Yes</label><input type="radio" id="no" name="normal_binary" value="no" class="form-check-input"><label for="no" class="item_label">No</label></div></div></div><div class="row"><div class="col-md-2"><label for="yes_alias">Yes Alias:</label></div><div class="col-md-6"><input class="form-control" name="yes_alias" id="yes_alias" autocomplete="off"></div></div><div class="row"><div class="col-md-2"><label for="no_alias">No Alias:</label></div><div class="col-md-6"><input class="form-control" name="no_alias" id="no_alias" autocomplete="off"></div></div></div><div class="row"><div class="col-md-2"><label for="notes">Notes:</label></div><div class="col-md-6"><textarea class="form-control" aria-label="With textarea" id="notes" name="notes" autocomplete="off"></textarea></div></div></div>';
            var i = $('#collapse_id').val();
            var collapse_id = "collapse"+i;
            var html_content = '<br/><div><div class="contextMenu"><button type="button" id="moveup" class="btn"><i class="fa fa-angle-up"></i></button><button type="button" id="movedown" class="btn"><i class="fa fa-angle-down"></i></button></div><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#'+collapse_id+'">Form Item ' + i + '</a></h4></div><div id="'+collapse_id+'" class="panel-collapse collapse in"><div class="panel-body"><div class="qry_section"><div class="row"><div class="col-md-2"><label for="query_text">Query Text :</label></div><div class="col-md-6"><input class="form-control" name="query_text[]" id="query_text" autocomplete="off" placeholder="Enter Query" required></div></div><br><div class="row"><div class="col-md-2"><label for="item_class">ITEM CLASS:</label></div><div class="col-md-6"><div class="form-check form-check-inline"><input type="radio" id="numeric" name="item[]" value="numeric" class="form-check-input" checked> <label for="numeric" class="item_label">Numeric</label> <input type="radio" id="binary" name="item[]" value="binary" class="form-check-input"> <label for="binary" class="item_label">Binary</label> <input type="radio" id="text" name="item[]" value="text" class="form-check-input"> <label for="text" class="item_label">Text</label> <input type="radio" id="header" name="item[]" value="header" class="form-check-input"> <label for="header" class="item_label">Header</label></div></div></div><br><div class="numeric_section"><div class="row"><div class="col-md-2"><label for="normal">Normal:</label></div><div class="col-md-6"><input class="form-control" name="normal[]" id="normal" autocomplete="off"></div></div><br><div class="row"><div class="col-md-2"><label for="lower_tolerance">LowerTolerance:</label></div><div class="col-md-6"><input class="form-control" name="lower_tolerance[]" id="lower_tolerance" autocomplete="off"></div></div><br><div class="row"><div class="col-md-2"><label for="upper_tolerance">UpperTolerance:</label></div><div class="col-md-6"><input class="form-control" name="upper_tolerance[]" id="upper_tolerance" autocomplete="off"></div></div><br></div><div class="binary_section"><div class="row"><div class="col-md-2"><label for="default">Default:</label></div><div class="col-md-6"><div class="form-check form-check-inline"><input type="radio" id="none" name="default_binary[]" value="none" class="form-check-input" checked> <label for="none" class="item_label">None</label> <input type="radio" id="yes" name="default_binary[]" value="yes" class="form-check-input"> <label for="yes" class="item_label">Yes</label> <input type="radio" id="no" name="default_binary[]" value="no" class="form-check-input"> <label for="no" class="item_label">No</label></div></div></div><br><div class="row"><div class="col-md-2"><label for="normal">Normal:</label></div><div class="col-md-6"><div class="form-check form-check-inline"><input type="radio" id="yes" name="normal_binary[]" value="yes" class="form-check-input" checked> <label for="yes" class="item_label">Yes</label> <input type="radio" id="no" name="normal_binary[]" value="no" class="form-check-input"> <label for="no" class="item_label">No</label></div></div></div><div class="row"><div class="col-md-2"><label for="yes_alias">Yes Alias:</label></div><div class="col-md-6"><input class="form-control" name="yes_alias[]" id="yes_alias" autocomplete="off"></div></div><div class="row"><div class="col-md-2"><label for="no_alias">No Alias:</label></div><div class="col-md-6"><input class="form-control" name="no_alias[]" id="no_alias" autocomplete="off"></div></div></div><div class="row"><div class="col-md-2"><label for="notes">Notes:</label></div><div class="col-md-6"><textarea class="form-control" aria-label="With textarea" id="notes" name="notes[]" autocomplete="off"></textarea></div></div></div></div></div></div></div>' ;
            $( ".query_rows" ).append( html_content );
            document.getElementById("collapse_id").value = parseInt(i) + 1;
        });

        $(document).on("click","#moveup",function() {
            var parentDiv = $(this).closest('div.contextMenu').parent();
            parentDiv.insertBefore( parentDiv.prev() )
        });

        $(document).on("click","#movedown",function() {
            var parentDiv = $(this).closest('div.contextMenu').parent();
            parentDiv.insertAfter( parentDiv.next() )
        });

    });

</script>
</body>

</html>