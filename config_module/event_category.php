<?php
include("../config.php");
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

$user_id = $_SESSION["id"];
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
	$events_cat_name = $_POST['events_cat_name'];
	$events_npr = $_POST['npr'];

//create
	if ($events_cat_name != "") {

		//	$npr = ($events_npr == 'yes')?1:0;
		if($events_npr =='1') {
			$sql0 = "INSERT INTO `events_category`(`events_cat_name`,`npr`,`created_by` , `created_on`) VALUES ('$events_cat_name' , '1','$user_id' ,  '$chicagotime')";
		}else{
			$sql0 = "INSERT INTO `events_category`(`events_cat_name`,`npr`,`created_by` , `created_on`) VALUES ('$events_cat_name' , '0','$user_id' ,  '$chicagotime')";
		}
		$result0 = mysqli_query($db, $sql0);
		if ($result0) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Event Category created successfully.';
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Please Insert valid data';
		}
	}
//edit
	$edit_events_cat_name = $_POST['edit_events_cat_name'];
	$edit_npr = $_POST['edit_npr'];
	$npr = ($edit_npr == 'yes')?1:0;
	if ($edit_events_cat_name != "") {
		$id = $_POST['edit_id'];
		$sql = "update events_category set events_cat_name='$_POST[edit_events_cat_name]',npr='$npr'  where events_cat_id ='$id'";
		$result1 = mysqli_query($db, $sql);
		if ($result1) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Event Category  Updated successfully.';
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Please Insert valid data';
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
    <title><?php echo $sitename; ?> | Station</title>
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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
</head>

<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
        .form-horizontal {
            width: 100%;
        }
        .col-lg-7{
            width: 60%!important;
            float: left!important;
        }
        .col-md-4 {
            float: left;
        }
        .col-lg-5{
            width: 40%!important;
            float: right!important;
        }
        .form_col_option{
            width: 60%!important;
            float: right;
        }
        .form-horizontal .control-label:not(.text-right){
            text-align: left;
            width: 40%!important;
        }
    }
    .form-check.form-check-inline.form_col_option {
        width: 20%;
        float: left;
        padding-top: 15px!important;
    }
    label.control-label {
        float: left;
    }
</style>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Add / Edit Events Category";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");?>
<!-- /main navbar -->
<body class="alt-menu sidebar-noneoverflow">
<!-- Page container -->
<div class="page-container">

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
                            <div class="col-md-4">
                                <input type="text" name="events_cat_name" id="events_cat_name"
                                       class="form-control" placeholder="Enter Event Category" required>
                            </div>
                            <div class="col-md-8">

                                <label class="control-label" style=" padding: 15px 10px;"> Is NPR required : </label>

                                <div class="form-check form-check-inline form_col_option">
                                    <input type="checkbox" id="yes" name="npr" value="1">
                                    <!--                                                <input type="radio" id="yes" name="npr" value="1">-->
                                    <!--                                                <label for="yes" class="item_label" id="">Yes</label>-->
                                    <!--                                                <input type="radio" id="no" name="npr" value="0" checked="checked">-->
                                    <!--                                                <label for="no" class="item_label" id="">No</label>-->
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="width: 100%;padding-top: 20px;">
                                <button type="submit" class="btn btn-primary"
                                        style="background-color:#1e73be;">Create Event Category
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
                <br/>
				<?php
				if (!empty($import_status_message)) {
					echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
				}
				?>
				<?php
				if (!empty($_SESSION[$import_status_message])) {
					echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
					$_SESSION['message_stauts_class'] = '';
					$_SESSION['import_status_message'] = '';
				}
				?>
            </div>
        </div>
        <form action="delete_event_category.php" method="post" class="form-horizontal">
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
                        <th>NPR</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					$i = 1;
					$query = sprintf("SELECT * FROM  events_category where is_deleted!='1'");
					$qur = mysqli_query($db, $query);
					while ($rowc = mysqli_fetch_array($qur)) {
						?>
                        <tr id="row<?php echo $i ?>">
                            <td><input type="checkbox" id="delete_check[]" name="delete_check[]"
                                       value="<?php echo $rowc["events_cat_id"]; ?>"></td>
                            <td id = "id_row<?php echo $i;?>" value = "<?php echo $i;?>"><?php echo ++$counter; ?></td>
                            <td id = "name_row<?php echo $i;?>" value="<?php echo $rowc["events_cat_name"]; ?>" ><?php echo $rowc["events_cat_name"]; ?></td>
<!--                            <td id = "npr_row--><?php //echo $i;?><!--" value = "--><?php //echo $rowc["npr"] ?><!--">--><?php //if($rowc["npr"] == 0){
//									$npr = "No";
//								}else{
//									$npr = "Yes";
//								}
//								echo $npr; ?><!--</td>-->

                            <td  id = "npr_row<?php echo $i;?>" value = "<?php echo $rowc["npr"] ?>">
                                <input type='checkbox' id="npr_row<?php echo $i;?>" value="<?php echo $rowc["npr"] ?>" <?php if( $rowc["npr"] == 1) {echo "checked";}?> style="pointer-events: none !important;">
                                <input type='hidden' id="npr_rown<?php echo $i;?>" value="<?php echo $rowc["npr"] ?>">

                            </td>
                            <td>
                                <button type="button" id="edit_button<?php echo $i ?>" class="edit btn btn-primary legitRipple" style="background-color:#1e73be;" onclick="edit_row('<?php echo $i ?>')"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                <button type="button" id="save_button<?php echo $i ?>"  class="save btn btn-primary legitRipple" style="background-color:#1e73be;" onclick="save_row('<?php echo $i ?>')"><i class="fa fa-save"></i></button>
                                <a href="view_material.php?id=75"</a>
                                <!--                                        <button type="button" id="edit" class="btn btn-info btn-xs"-->
                                <!--                                                data-id="--><?php //echo $rowc['events_cat_id']; ?><!--"-->
                                <!--                                                data-npr="--><?php //echo $npr; ?><!--"-->
                                <!--                                                data-events_cat_name="--><?php //echo $rowc['events_cat_name']; ?><!--"-->
                                <!--                                                style="background-color:#1e73be;"-->
                                <!--                                                data-toggle="modal" style="background-color:#1e73be;"-->
                                <!--                                                data-target="#edit_modal_theme_primary">Edit-->
                                <!--                                        </button>-->
                                <!--									&nbsp;
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['line_id']; ?>">Delete </button>
                                                    -->
                            </td>
                        </tr>
						<?php $i++;} ?>
                    </tbody>
                </table>
        </form>
    </div>
    <!-- /basic datatable -->
    <!-- /main charts -->
    <!-- edit modal -->
    <div id="edit_modal_theme_primary" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">Edit Event Category</h6>
                </div>
                <form action="" id="user_form" class="form-horizontal" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-7 control-label" >Event Category:*</label>
                                    <div class="col-lg-5">
                                        <input type="text" name="edit_events_cat_name" id="edit_events_cat_name"
                                               class="form-control" required>
                                        <input type="hidden" name="edit_id" id="edit_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="col-lg-7 control-label">Is NPR required ? *</label>
                                    <div class="col-lg-5">
                                        <div class="form-check form-check-inline form_col_option" style="width: 80%;font-size: 14px;">
                                            <input type="radio" id="edit_yes" name="edit_npr" value="yes">
                                            <label for="yes" class="item_label" id="">Yes</label>
                                            <input type="radio" id="edit_no" name="edit_npr" value="no" checked="checked">
                                            <label for="no" class="item_label" id="">No</label>
                                        </div>
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
    <script>

        function edit_row(no)
        {
            document.getElementById("edit_button"+no).style.display="none";
            document.getElementById("save_button"+no).style.display="block";

            var id=document.getElementById("id_row"+no);
            var name=document.getElementById("name_row"+no);
            var npr=document.getElementById("npr_row"+no);
            var nprn=document.getElementById("npr_rown"+no);

            var id_data=id.innerText;
            var name_data=name.innerText;
            var npr_data=nprn.value;

            id.innerHTML="<input type='text' id='id_text"+no+"' value='"+id_data+"' class='form-control'>";
            name.innerHTML="<input type='text' id='name_text"+no+"' value='"+name_data+"' class='form-control'>";
            if(npr_data == "1"){
                npr.innerHTML="<input type='checkbox' id='npr_text"+no+"' value='"+npr_data+"' checked>";
            }else{
                npr.innerHTML="<input type='checkbox' id='npr_text"+no+"' value='"+npr_data+"'>";
            }

        }
        function save_row(no)
        {
            var info = {
                id: $("#id_text" +no).val(),
                name_val: $("#name_text"+no).val(),
                npr_val: (($("#npr_text"+no)[0].checked) == true)?1:0,
            };
            $.ajax({
                type: "POST",
                url: "edit_event_category.php",
                data: info,
                success: function (data) {
                    document.getElementById("edit_button"+no).style.display="block";
                    document.getElementById("save_button"+no).style.display="none";
                    location.reload();
                }
            });
        }

    </script>
    <!-- Dashboard content -->
    <!-- /dashboard content -->
    <script> $(document).on('click', '#delete', function () {
            var element = $(this);
            var del_id = element.attr("data-id");
            var info = 'id=' + del_id;
            $.ajax({type: "POST", url: "ajax__delete.php", data: info, success: function (data) { }});
            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
        });</script>
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('click', '#edit', function () {
                var element = $(this);
                var edit_id = element.attr("data-id");
                var events_cat_name = $(this).data("events_cat_name");
                var edit_npr = $(this).data("npr");
                if(edit_npr == 'No'){
                    document.getElementById("edit_no").checked = true;
                }else{
                    document.getElementById("edit_yes").checked = true;
                }
                $("#edit_events_cat_name").val(events_cat_name);
                $("#edit_id").val(edit_id);
            });
        });
    </script>

    <script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $scriptName; ?>config_module/event_category.php");
        }
    </script>

    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
</div>
<!-- /content area -->

<!-- /main content -->

<!-- /page container -->
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
