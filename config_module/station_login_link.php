<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");


if (count($_POST) > 0) {
	$name = $_POST['name'];
//create
	if ($name != "") {
		$name = $_POST['name'];
		$priority_order = $_POST['priority_order'];
		$enabled = $_POST['enabled'];
		$sql0 = "INSERT INTO `cam_line`(`line_name`,`priority_order` , `enabled` , `created_at`) VALUES ('$name' , '$priority_order' , '$enabled', '$chicagotime')";
		$result0 = mysqli_query($db, $sql0);
		if ($result0) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Station created successfully.';
		} else {
			$message_stauts_class = 'alert-danger';
			$import_status_message = 'Error: Please Insert valid data';
		}
	}
//edit
	$edit_name = $_POST['edit_name'];
	if ($edit_name != "") {
		$id = $_POST['edit_id'];
		$sql = "update cam_line set line_name='$_POST[edit_name]', priority_order='$_POST[edit_priority_order]' , enabled='$_POST[edit_enabled]'  where line_id='$id'";
		$result1 = mysqli_query($db, $sql);
		if ($result1) {
			$message_stauts_class = 'alert-success';
			$import_status_message = 'Station Updated successfully.';
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
	}
</style>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Station Login Link";
include("../header.php");

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


			<br/>
			<div class="panel panel-flat">
				<table class="table datatable-basic">
					<thead>
					<tr>
						<th><input type="checkbox" id="checkAll" ></th>
						<th>S.No</th>
						<th>Station</th>
						<th>Login Link</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$query = sprintf("SELECT * FROM  cam_line");
					$qur = mysqli_query($db, $query);
					while ($rowc = mysqli_fetch_array($qur)) {
						?>
						<tr>
							<td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["line_id"]; ?>"></td>
							<td><?php echo ++$counter; ?></td>
							<td><?php echo $rowc["line_name"]; ?></td>
							<td><?php echo $siteURL . "tab_login.php?s_id=".$rowc["line_id"]; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
	</div>
	<!-- /basic datatable -->
	<!-- /main charts -->

	<!-- Dashboard content -->
	<!-- /dashboard content -->


	<script>
        window.onload = function() {
            history.replaceState("", "", "<?php echo $scriptName; ?>config_module/station_login_link.php");
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

</div>
<!-- /content area -->

</div>
<!-- /page container -->
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
