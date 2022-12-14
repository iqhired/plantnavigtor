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
$def_ch = $_POST['def_ch'];
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
$p_line_name = $rowcnumber['line_name'];
$individualenabled = $rowcnumber['indivisual_label'];

$idddd = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
	, $_SERVER["HTTP_USER_AGENT"]);

$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
$resultnumber = $mysqli->query($sqlnumber);
$rowcnumber = $resultnumber->fetch_assoc();
$pm_part_number = $rowcnumber['part_number'];
$pm_part_name = $rowcnumber['part_name'];
$pm_npr= $rowcnumber['npr'];
if(empty($pm_npr))
{
	$npr = 0;
	$pm_npr = 0;
}else{
	$npr = $pm_npr;
}
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

$sql2 = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where sg_station_event.line_id = '$p_line_id' and sg_station_event.event_status = 1" ;
$result2 = mysqli_query($db,$sql2);
$total_time = 0;
$row2=$result2->fetch_assoc();
$total_gp =  $row2['good_pieces'] + $row2['rework'];

$sql3 = "SELECT * FROM `sg_station_event_log` where 1 and event_status = 1 and station_event_id = '$station_event_id' and event_cat_id in (SELECT events_cat_id FROM `events_category` where npr = 1)" ;
$result3 = mysqli_query($db,$sql3);
$ttot = null;
$tt = null;
while ($row3 = $result3->fetch_assoc()) {
	$ct = $row3['created_on'];
	$tot = $row3['total_time'];
	if(!empty($row3['total_time'])){
		$ttot = explode(':' , $row3['total_time']);
		$i = 0;
		foreach($ttot as $t_time) {
			if($i == 0){
				$total_time += ( $t_time * 60 * 60 );
			}else if( $i == 1){
				$total_time += ( $t_time * 60 );
			}else{
				$total_time += $t_time;
			}
			$i++;
		}
	}else{
		$total_time +=  strtotime($chicagotime) - strtotime($ct);
	}
}
$total_time = (($total_time/60)/60);
$b = round($total_time);
$target_eff = round($pm_npr * $b);
$actual_eff = $total_gp;
if( $actual_eff ===0 || $target_eff === 0 || $target_eff === 0.0){
	$eff = 0;
}else{
	$eff = round(100 * ($actual_eff/$target_eff));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> </title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-data-adapter.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pareto.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-circular-gauge.min.js"></script>
    <link href="https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/8.11.0/fonts/css/anychart-font.min.css" type="text/css"
          rel="stylesheet">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="/js/jquery/jquery-1.3.2.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<script>
    $('#eff_container').load('../gbp_dashboard.php #eff_container');
</script>
<script>

</script>
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

    .red {
        color: red;
        display: none;
    }
    .graph_media{
        width: 47%;
        border: 1px solid gray;
        margin: 2% 0% 2% 2%;
        height: 380px;
    }
    .img-circle {
        border-radius: 50%;
        height: 36vh;
        width: 68vh;
        background-color: #fff;
    }
    .media_details{
        margin-top: -40px;
    }
    .media-left, .media>.pull-left {
        padding-right: 0px;
    }
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 80px;
            margin-top: 200px;
        }
        .graph_media{
            width: 96%;
            border: 1px solid gray;
            margin: 2% 0% 2% 2%;
            height: 442px;
        }
        .img-circle {
            border-radius: 50%;
            height: 58vh;
            width: 78vh;
            background-color: #fff;
        }
    }
    @media only screen and (max-width: 914px), (min-device-width: 412px) and (max-device-width: 1024px) {
        .img-circle {
            border-radius: 50%;
            height: 20vh;
            width: 34vh;
            background-color: #fff;
        }
    }
    body.alt-menu.sidebar-noneoverflow.pace-done {
        background-color: #ccc !important;
    }

    .anychart-credits {
        display: none !important;
    }

    .datatable-scroll {
        width: 100%;
        overflow-x: scroll;
    }

    .container {
        margin: 0 auto;
    }
    .content_img {
        width: 113px;
        float: left;
        margin-right: 5px;
        border: 1px solid gray;
        border-radius: 3px;
        padding: 5px;
        margin-top: 10px;
    }

    /* Delete */
    .content_img span {
        border: 2px solid red;
        display: inline-block;
        width: 99%;
        text-align: center;
        color: red;
    }

    .content_img span:hover {
        cursor: pointer;
    }
    input[type="file"] {
        display: block;
    }
    .imageThumb {
        max-height: 100px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }
    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }
    .remove {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }
    .remove:hover {
        background: white;
        color: black;
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
        <!--<div class="col-lg-3 col-md-8"></div>-->
        <div class="col-lg-6 col-md-8 graph_media">
            <!--							<div class="panel panel-body">-->
            <div class="media">
                <h5 style="font-size: xx-large;background-color: #009688; color: #ffffff;padding : 5px; text-align: center;" class="text-semibold no-margin"><?php if($cus_name != ""){ echo $cus_name; }else{ echo "Customer Name";} ?> </h5>

                <div class="media-left">
                    <!--                                    <a target="_blank" href="../supplier_logo/--><?php //if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?><!--" data-popup="lightbox">-->
                    <img src="../supplier_logo/<?php if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?>" style=" height: 20vh;width:20vh;margin : 15px 25px 5px 5px;background-color: #ffffff;" class="img-circle" alt="">
                    <!--                                    </a>-->
                </div>
                <div class="media-body">
                    <small style="font-size: 22px; margin-top: 15px;" class="display-block"><b>Part Family :-</b> <?php echo $pm_part_family_name; ?></small>
                    <small style="font-size: 22px;" class="display-block"><b>Part Number :-</b> <?php echo $pm_part_number; ?></small>
                    <small style="font-size: 22px;" class="display-block"><b>Part Name :-</b> <?php echo $pm_part_name; ?></small>

                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-8 graph_media">
            <div class="media">
                <h5 style="font-size: xx-large;background-color: #009688; color: #ffffff;padding : 5px; text-align: center;" class="text-semibold no-margin">Current Staff Efficiency</h5>

                <div class="media-left">

                    <div id="eff_container" class="img-circle"></div>
                </div>
            </div>
            <div class="media_details">
                <div class="media-body">
                    <small style="font-size: 22px ;margin-top: 15px;padding-left: 14px;"><b>Target Pieces :-</b> <?php echo $target_eff; ?></small>
                    <small style="font-size: 22px;padding-left: 17px;" ><b>Actual Pieces :-</b> <?php echo $actual_eff; ?></small>
                    <small style="font-size: 22px;padding-left: 17px;"><b>Efficiency :-</b> <?php echo $eff; ?>%</small>

                </div>

            </div>
        </div>
    </div>
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
<div class="panel panel-flat">
	<?php
	$sql = "select SUM(good_pieces) as good_pieces,SUM(bad_pieces) AS bad_pieces,SUM(rework) as rework from good_bad_pieces_details where station_event_id ='$station_event_id' ";
	$result1 = mysqli_query($db, $sql);
	$rowc = mysqli_fetch_array($result1);
	$gp = $rowc['good_pieces'];
	if(empty($gp)){
		$g = 0;
	}else{
		$g = $gp;
	}
	$bp = $rowc['bad_pieces'];
	if(empty($bp)){
		$b = 0;
	}else{
		$b = $bp;
	}
	$rwp = $rowc['rework'];
	if(empty($rwp)){
		$r = 0;
	}else{
		$r = $rwp;
	}
	$tp = $gp + $bp+ $rwp;
	if(empty($tp)){
		$t = 0;
	}else{
		$t = $tp;
	}
	?>
    <div class="row" style="background-color: #f3f3f3;margin: 0px">
        <div class="col-md-3" style="height: 10vh; padding-top: 3vh; font-size: x-large; text-align: center;">
            <span>Total Pieces : <?php echo $t ?></span>
        </div>
        <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#a8d8a8;">
            <span>Total Good Pieces : <?php echo $g ?></span>
        </div>
        <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#eca9a9;">
            <span>Total Bad Pieces : <?php echo $b ?></span>
        </div>
        <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#b1cdff;">
            <span>Rework : <?php echo $r ?></span>
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
        </br>
        <div class="row">
            <div class="col-md-12">
				<?php if(($idddd != 0) && ($printenabled == 1)){?>
                    <iframe height="100" id="resultFrame" style="display: none;" src="./pp.php"></iframe>
				<?php }?>
                <a href="<?php echo $siteURL; ?>events_module/add_good_piece.php?station_event_id=<?php echo $station_event_id; ?>"  class="btn btn-primary" style="background-color:#177b09 !important;margin-top: 10px;width: 100%;height: 10vh; padding-top: 3vh; font-size: large; text-align: center;"> IN-SPEC</a>
            </div>
        </div>
        <div class="row"  >
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
                <div class="col-md-3" style="padding-top: 10px;">
                    <a  href="<?php echo $siteURL; ?>events_module/add_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>&defect_list_id=<?php echo $row1['defect_list_id']; ?>" class="btn btn-primary view_gpbp"  data-buttonid="<?php echo $row1['defect_list_id']; ?>"
                        data-defect_name="<?php echo $row1['defect_list_name']; ?>" style="white-space: normal;background-color:#BE0E31 !important;height: 8vh; width:98% ; padding-top: 2vh; font-size: medium; text-align: center;">
						<?php echo $row1['defect_list_name']; ?></a>

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
				$bad_pieces_id = $rowc['bad_pieces_id'];
				$good_pieces = $rowc['good_pieces'];
				$bad_pieces = $rowc['bad_pieces'];
				$rework = $rowc['rework'];
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

					<?php
					$qur04 = mysqli_query($db, "SELECT * FROM good_bad_pieces_details where station_event_id= '$station_event_id' ORDER BY `bad_pieces_id` DESC LIMIT 1");
					$rowc04 = mysqli_fetch_array($qur04);
					$bad_trace_id = $rowc04["bad_pieces_id"];

					$query1 = sprintf("SELECT bad_piece_id,good_image_name FROM  good_piece_images where bad_piece_id = '$bad_trace_id'");
					$qur1 = mysqli_query($db, $query1);
					$rowc1 = mysqli_fetch_array($qur1);
					$item_id = $rowc1['bad_piece_id'];
					$image_name = $rowc1['good_image_name'];

					?>
                    <td>
						<?php   if($rowc['good_pieces'] != ""){ ?>
                            <a  href="<?php echo $siteURL; ?>events_module/edit_good_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id;?>" data-id="<?php echo $rowc['good_bad_pieces_id']; ?>" data-gbid="<?php echo $rowc['bad_pieces_id']; ?>" data-seid="<?php echo $station_event_id; ?>" data-good_pieces="<?php echo $rowc['good_pieces']; ?>"
                                data-defect_name="<?php echo $rowc['defect_name']; ?>" data-bad_pieces="<?php echo $rowc['bad_pieces']; ?>" data-re_work="<?php echo $rowc['rework']; ?>" data-image="<?php echo $item_id; ?>"
                                data-image_name="<?php echo $image_name; ?>" class="btn btn-info btn-xs" id="edit"><i class="fa fa-edit"></i>
                            </a> <?php } elseif($rowc['bad_pieces'] != ""){?>
                            <a href="<?php echo $siteURL; ?>events_module/edit_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id;?>" data-id="<?php echo $rowc['good_bad_pieces_id']; ?>" data-gbid="<?php echo $rowc['bad_pieces_id']; ?>" data-seid="<?php echo $station_event_id; ?>" data-good_pieces="<?php echo $rowc['good_pieces']; ?>"
                               data-defect_name="<?php echo $rowc['defect_name']; ?>" data-bad_pieces="<?php echo $rowc['bad_pieces']; ?>" data-re_work="<?php echo $rowc['rework']; ?>" data-image="<?php echo $item_id; ?>"
                               data-image_name="<?php echo $image_name; ?>" class="btn btn-info btn-xs" id="edit"><i class="fa fa-edit"></i>
                            </a>
                            <?php if($rowc['bad_pieces'] != "")  { ?>
                                <a href="<?php echo $siteURL; ?>events_module/view_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id;?>" data-id="<?php echo $rowc['good_bad_pieces_id']; ?>" data-gbid="<?php echo $rowc['bad_pieces_id']; ?>" data-seid="<?php echo $station_event_id; ?>" data-good_pieces="<?php echo $rowc['good_pieces']; ?>"
                                   data-defect_name="<?php echo $rowc['defect_name']; ?>" data-bad_pieces="<?php echo $rowc['bad_pieces']; ?>" data-re_work="<?php echo $rowc['rework']; ?>" data-image="<?php echo $item_id; ?>" class="btn btn-info btn-xs" id="edit"><i class="fa fa-eye" aria-hidden="true"></i>
                                </a> <?php }else{ echo $line; } ?>
						<?php } else{ ?>
                            <a href="<?php echo $siteURL; ?>events_module/rework_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id;?>" data-id="<?php echo $rowc['good_bad_pieces_id']; ?>" data-gbid="<?php echo $rowc['bad_pieces_id']; ?>" data-seid="<?php echo $station_event_id; ?>" data-good_pieces="<?php echo $rowc['good_pieces']; ?>"
                               data-defect_name="<?php echo $rowc['defect_name']; ?>" data-bad_pieces="<?php echo $rowc['bad_pieces']; ?>" data-re_work="<?php echo $rowc['rework']; ?>" data-image="<?php echo $item_id; ?>"
                               data-image_name="<?php echo $image_name; ?>" class="btn btn-info btn-xs" id="edit"><i class="fa fa-edit"></i>
                            </a>
						<?php } ?>
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
                <input type="hidden" name="time" value="<?php echo time(); ?>">
                <input type="hidden" name="line_name" value="<?php echo $p_line_name; ?>">
                <input type="hidden" name="ipe" value="<?php echo $individualenabled; ?>">
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
                <input type="hidden" name="time" value="<?php echo time(); ?>">
                <input type="hidden" name="line_name" value="<?php echo $p_line_name; ?>">
                <input type="hidden" name="ipe" id="ipe" value="<?php echo $individualenabled; ?>">

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


                    <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $good_trace_id; ?>">
                    <input type="hidden" name="edit_gbid" id="edit_gbid" >
                    <input type="hidden" name="edit_seid" id="edit_seid" >
                    <input type="hidden" name="good_bad_piece_id" id="good_bad_piece_id" value="<?php echo $good_trace_id; ?>">
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
<script>
    //Efficiency
    anychart.onDocumentReady(function () {
        var data = this.window.location.href.split('?')[1];
        $.ajax({
            type: 'POST',
            url: 'gbp_eff.php',
            // dataType: 'good_bad_piece_fa.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var target_eff = data.posts.map(function (elem) {
                    return elem.target_eff;
                });
                // console.log(goodpiece);
                // var avg_npr = data.posts.map(function (elem) {
                //     return elem.avg_npr;
                // });
                var actual_eff = data.posts.map(function (elem) {
                    return elem.actual_eff;
                });

                var eff = data.posts.map(function (elem) {
                    return elem.eff;
                });
                // var range1 = avg_npr;
                var range1 = actual_eff;
                var range2 = target_eff;
                var range3 = eff;

                var fill3 = '#009900 0.8';
                var fill2 = '#B31B1B 0.8';
                var fill1 = '#B31B1B 0.8';

                var maxr3 =  parseFloat(range2) + parseFloat(range2 * .2)


                if((actual_eff >= target_eff)){
                    range1 = target_eff;
                    // range2 = avg_npr;
                    range2 = actual_eff;
                    fill1 = '#009900 0.8';
                    fill2 = '#009900 0.8';
                    fill3 = '#B31B1B 0.8';
                    maxr3 =  parseFloat(target_eff) + parseFloat(target_eff * .2)
                }

                var gauge = anychart.gauges.circular();
                gauge
                    .fill('#fff')
                    .stroke(null)
                    .padding(50)
                    .margin(0)
                    .startAngle(270)
                    .sweepAngle(180);

                gauge
                    .axis()
                    .labels()
                    .padding(5)
                    .fontSize(15)
                    .position('outside')
                    .format('{%Value}');

                gauge.data([actual_eff]);
                gauge
                    .axis()
                    .scale()
                    .minimum(0)
                    .maximum(maxr3)
                    .ticks({ interval: 1 })
                    .minorTicks({ interval: 1 });

                gauge
                    .axis()
                    .fill('#545f69')
                    .width(1)
                    .ticks({ type: 'line', fill: 'white', length: 2 });

                gauge.title(
                    /* '<div style=\'color:#333; font-size: 20px;\'> <span style="color:#009900; font-size: 22px;"><strong> ' +target_eff+' </strong><l/span></div>' +
					 '<br/><br/><div style=\'color:#333; font-size: 20px;\'> <span style="color:#009900; font-size: 22px;"><strong> ' +actual_eff+' </strong></span></div><br/><br/>' +
					 '<div style=\'color:#333; font-size: 20px;\'> <span style="color:#009900; font-size: 22px;"><strong> ' +eff+' </strong>%</span></div><br/><br/>'*/
                );

                gauge
                    .title()
                    .useHtml(true)
                    .padding(0)
                    .fontColor('#212121')
                    .hAlign('center')
                    .margin([0, 0, 10, 0]);

                gauge
                    .needle()
                    .stroke('2 #545f69')
                    .startRadius('5%')
                    .endRadius('90%')
                    .startWidth('0.1%')
                    .endWidth('0.1%')
                    .middleWidth('0.1%');

                gauge.cap().radius('3%').enabled(true).fill('#545f69');

                gauge.range(0, {
                    from: 0,
                    to: range1,
                    position: 'inside',
                    fill: fill1,
                    startSize: 50,
                    endSize: 50,
                    radius: 98
                });

                gauge.range(1, {
                    from: range1,
                    to: range2,
                    position: 'inside',
                    fill: fill2,
                    startSize: 50,
                    endSize: 50,
                    radius: 98
                });

                gauge.range(2, {
                    from: range2,
                    to: (maxr3),
                    position: 'inside',
                    fill: '#009900 0.8',
                    startSize: 50,
                    endSize: 50,
                    radius: 98

                });

                gauge
                    .label(1)
                    .text('')
                    .fontColor('#212121')
                    .fontSize(20)
                    .offsetY('68%')
                    .offsetX(25)
                    .anchor('center');
                gauge
                    .label(2)
                    .text('')
                    .fontColor('#212121')
                    .fontSize(20)
                    .offsetY('68%')
                    .offsetX(90)
                    .anchor('center');

                gauge
                    .label(3)
                    .text('')
                    .fontColor('#212121')
                    .fontSize(20)
                    .offsetY('68%')
                    .offsetX(155)
                    .anchor('center');


                // set container id for the chart
                gauge.container('eff_container');
                // initiate chart drawing
                gauge.draw();
            }
        });
    });
</script>
<script> $(document).on('click', '#add_gp', function () {
        var element = $(this);
        var del_id = element.attr("data-id");
        var info = 'station_event_id=' + <?php echo $station_event_id; ?>;
        var url = window.location.origin + "/events_module/add_good_piece.php?" + info;
        window.close();
        window.open(url,"_blank");

    });</script>

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
                var ff1 = this.data.split('&')[3].split("=")[1];
                var file1 = '../assets/label_files/' + line_id +'/g_'+ff1;
                var file = '../assets/label_files/' + line_id +'/g_'+ff1;;
                var ipe = document.getElementById("ipe").value;
                if(pe == '1'){
                    if(ipe == '1'){
                        var i;
                        var nogp = document.getElementById("good_name").value;
                        //alert('no of good pieces are' +nogp);
                        //for(var i = 1; i <= nogp; i++) {
                        document.getElementById("resultFrame").contentWindow.ss(file1);
                        // alert('no of good pieces are' +nogp);
                        //}
                        // document.getElementById("resultFrame").contentWindow.ss(file , nogp);
                    }else{
                        document.getElementById("resultFrame").contentWindow.ss(file1);
                    }
                }
                //var ipe = this.data.split('&')[2].split("=")[1];
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
                var ff2 = this.data.split('&')[3].split("=")[1];
                var deftype = this.data.split('&')[6].split("=")[1];
                var file2 = '../assets/label_files/' + line_id +'/b_'+ff2;
                if((pe == '1') && (deftype != 'bad_piece')){
                    document.getElementById("resultFrame").contentWindow.ss(file2);
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
        var edit_image = $(this).data("data-image");
        $("#editgood_name").val(editgood_name);
        $("#editdefect_name").val(editdefect_name);
        $("#editbad_name").val(editbad_name);
        $("#editre_work").val(editre_work);
        $("#editimage").val(edit_image);
        $("#edit_id").val(edit_id);
        $("#edit_gbid").val(edit_gbid);
        $("#edit_seid").val(edit_seid);

        if(editgood_name != "")
        {
            // $("#badpiece").hide();
            // $("#badpiece1").hide();
            // $("#badpiece2").hide();
            // $("#goodpiece").show();

            window.location = "<?php echo $siteURL; ?>events_module/edit_good_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id;?>";


        }else if(editbad_name != ""){
            // $("#badpiece").show();
            // $("#badpiece1").show();
            // $("#badpiece2").hide();
            // $("#goodpiece").hide();
            window.location = "<?php echo $siteURL; ?>events_module/edit_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>";

        }
        //else if(editre_work != "")
        //{
        //    // $("#badpiece").show();
        //    // $("#badpiece1").hide();
        //    // $("#badpiece2").show();
        //    //
        //    // $("#goodpiece").hide();
        //    window.location = "<?php //echo $siteURL; ?>//events_module/add_bad_piece.php?station_event_id=<?php //echo $station_event_id; ?>//";
        //
        //}
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
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>");
    }
</script>
<script>
    // Upload

    $("#file").on("change", function () {
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file', files);
        fd.append('request', 1);

        // AJAX request
        $.ajax({
            url: 'add_delete_good_bad_piece_image.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response != 0) {
                    var count = $('.container .content_img').length;
                    count = Number(count) + 1;

                    // Show image preview with Delete button
                    $('.container').append("<div class='content_img' id='content_img_" + count + "' ><img src='" + response + "' width='100' height='100'><span class='delete' id='delete_" + count + "'>Delete</span></div>");
                }
            }
        });
    });


    // Remove file
    $('.container').on('click', '.content_img .delete', function () {

        var id = this.id;
        var split_id = id.split('_');
        var num = split_id[1];
        // Get image source
        var imgElement_src = $('#content_img_' + num)[0].children[0].src;
        //var deleteFile = confirm("Do you really want to Delete?");
        var succ = false;
        // AJAX request
        $.ajax({
            url: 'add_delete_good_bad_piece_image.php',
            type: 'post',
            data: {path: imgElement_src, request: 2},
            async: false,
            success: function (response) {
                // Remove <div >
                if (response == 1) {
                    succ = true;
                }
            }, complete: function (data) {
                if (succ) {
                    var id = 'content_img_' + num;
                    // $('#content_img_'+num)[0].remove();
                    var elem = document.getElementById(id);
                    document.getElementById(id).style.display = 'none';
                    var nodes = $(".container")[2].childNodes;
                    for (var i = 0; i < nodes.length; i++) {
                        var node = nodes[i];
                        if (node.id == id) {
                            node.style.display = 'none';
                        }
                    }
                }
            }
        });
    });

</script>
<script>

    $("#file-input").on("change", function(e) {
        var files = e.target.files,
            filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
                var file = e.target;
                $("<span class=\"pip\">" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "<br/><span class=\"remove\">Remove image</span>" +
                    "</span>").insertAfter("#file-input");
                $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                });

            });
            fileReader.readAsDataURL(f);
        }
    });

    function previewImages() {
        $("#preview").html(" ");
        var preview = document.querySelector('#preview');

        if (this.files) {
            [].forEach.call(this.files, readAndPreview);
        }

        function readAndPreview(file) {

            // Make sure `file.name` matches our extensions criteria
            if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                return alert(file.name + " is not an image");
            } // else...

            var reader = new FileReader();

            reader.addEventListener("load", function() {
                var image = new Image();
                image.height = 100;
                image.title  = file.name;
                image.src    = this.result;
                preview.appendChild(image);
            });

            reader.readAsDataURL(file);

        }

    }

    document.querySelector('#file-input').addEventListener("change", previewImages);
</script>

<?php include('../footer.php') ?>
<!--<script type="text/javascript" src="../assets/js/core/app.js">-->
</body>
</html>