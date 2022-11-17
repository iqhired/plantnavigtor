<?php include("../config.php");
$chicagotime = date("Y-m-d");
$time = date("H");
$station = $_GET['id'];
$sql1 = "SELECT * FROM `cam_line` WHERE line_id = '$station'";
$result1 = mysqli_query($db, $sql1);
while ($cam1 = mysqli_fetch_array($result1)) {
	$station1 = $cam1['line_id'];
	$station2 = $cam1['line_name'];
}

/*$sad ="\\U1F60C";*/
$text = "\\u1F603";
$text1 = "\\U1F61E";
$text2 = "\\U1F634";
$html = preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;", $text1);
$html1 = preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;", $text);
$html2 = preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;", $text2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="5" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $sitename; ?> | NPR Dashboard</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/media/fancybox.min.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_select2.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/gallery.js"></script>
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
	<style>
		.table table-sm1{
			text-align:center;
			font-size: large;
			height: 100%;
			width: 100%;
		}
		.table table-sm{
			text-align:center;
			font-size: large;
			height: 100%;
			width: 100%;
		}
		@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
			.com-mobile-version {
				width: 100%;
			}
		}
		.table>tbody>tr>td{
			text-align: center;
			padding: 7px 20px 7px 20px;
			border: 1px solid lightgrey;
			border-collapse: collapse;
		}

	</style>
</head>
<body>
<!-- Main navbar -->
<?php
$cam_page_header = "NPR Dashboard - " . $station2;
include("../hp_header1.php");
?>
<div class="page-container" style="width: 100%;">
	<!-- Content area -->
	<div class="content">
		<div class="col-md-12" style="background-color: #eee;">
			<div class="col-md-6 com-mobile-version">
				<div class="panel panel-flat ab" style="margin-top: 10px;">
					<form>
						<table class="table table-sm1">
							<thead>
							<tr>
								<th style="text-align:center;border: 1px solid lightgray;">Hours<br>(AM)</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Goodpiece</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Badpiece</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Target NPR</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Actual NPR</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Efficiency</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Status</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$i1 = 00;
							$sql2 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 00";
							$res2 = mysqli_query($db, $sql2);
							$r2 = $res2->fetch_assoc();
							$tp2 = $r2['t'];
							if($tp2 == null){
								$r = 111;
							}else{
								$r = $tp2;
							}
							$p2 = 00;
							if($r == $p2){
								$randomcolor1 = "#FF3131";
							}else if($i1 == $time){
								$randomcolor1 = "#dadada";
							}else{
								$randomcolor1 = "#FFFFFF";
							}
							?>
							<tr style="background-color: <?php echo $randomcolor1 ?>;">
								<?php
								$pm_npr= 30;
								$qur04 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1' and ( npr_h = '00' or npr_h = '0') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result333 = mysqli_query($db,$qur04);
								$rowc04 = $result333->fetch_assoc();
								$h = 1;
								//npr
								$npr_h = $rowc04["npr_h"];
								$npr_gr = $rowc04["npr_gr"];
								$npr_b = $rowc04["npr_b"];
								if(empty($npr_b)){
									$n1 = '0';
								}else{
									$n1 = $npr_b;
								}
								$target_npr = $pm_npr;
								$actual_npr = round($npr_gr/$h,2);
								if($actual_npr < $target_npr){
									$s = $html;
								}else{
									$s = $html1;
									$randomcolor1 = "#90EE90";
								}
								if($time < '00'){
									$s = $html2;
								}
								//effieciency
								$target_eff = round($pm_npr * $h);
								$actual_eff = $npr_gr;
								$eff = round(100 * ($actual_eff/$target_eff));
								if($npr_h == '00'){
									?>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo '00-01'; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo $npr_gr; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo $n1; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo $target_npr; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo $actual_npr; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo $eff; ?>%</td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo '<span style="font-size: 22pt">' . $s . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo '00-01'; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo $target_npr; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor1 ?>;"><?php echo '<span style="font-size: 22pt">' . $s . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i = 01;
							$sql21 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t1 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 1";
							$res21 = mysqli_query($db, $sql21);
							$r21 = $res21->fetch_assoc();
							$tp21 = $r21['t1'];
							$p21 = 1;
							if($tp21 == $p21){
								$randomcolor = "#FF3131";
							}else if($i == $time){
								$randomcolor = "#dadada";
							}else{
								$randomcolor = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor ?>;">
								<?php
								$pm_npr2= 30;
								$qur042 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and ( npr_h = '01' or npr_h = '1') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result332 = mysqli_query($db,$qur042);
								$rowc042 = $result332->fetch_assoc();
								$h2 = 1;
								//npr
								$npr_h2 = $rowc042["npr_h"];
								$npr_gr2 = $rowc042["npr_gr"];
								$npr_b2 = $rowc042["npr_b"];
								if(empty($npr_b2)){
									$n2 = '0';
								}else{
									$n2 = $npr_b2;
								}
								$target_npr2 = $pm_npr2;
								$actual_npr2 = round($npr_gr2/$h2,2);
								if($actual_npr2 < $target_npr2){
									$s2 = $html;
								}else{
									$s2 = $html1;
									$randomcolor = "#90EE90";
								}
								if($time < '01'){
									$s2 = $html2;
								}
								//effieciency
								$target_eff2 = round($pm_npr2 * $h2);
								$actual_eff2 = $npr_gr2;
								$eff2 = round(100 * ($actual_eff2/$target_eff2));
								if($npr_h2 == '01'){
									?>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo '01-02'; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo $npr_gr2; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo $n2; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo $target_npr2; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo $actual_npr2; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo $eff2; ?>%</td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo '<span style="font-size: 22pt">' . $s2 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo '01-02'; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo $target_npr2; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor ?>;"><?php echo '<span style="font-size: 22pt">' . $s2 . '</span>'; ?></td>
								<?php }?>
							</tr>

							<?php
							$i2 = 02;
							$sql22 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t2 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 2";
							$res22 = mysqli_query($db, $sql22);
							$r22 = $res22->fetch_assoc();
							$tp22 = $r22['t2'];
							$p22 = 2;
							if($tp22 == $p22){
								$randomcolor2 = "#FF3131";
							}else if($i2 == $time){
								$randomcolor2 = "#dadada";
							}else{
								$randomcolor2 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor2 ?>;">
								<?php
								$pm_npr311= 30;
								$qur043 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'   and ( npr_h = '02' or npr_h = '2') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result33 = mysqli_query($db,$qur043);
								$rowc043 = $result33->fetch_assoc();
								$h3 = 1;
								//npr
								$npr_h3 = $rowc043["npr_h"];
								$npr_gr33 = $rowc043["npr_gr"];
								$npr_b33 = $rowc043["npr_b"];
								if(empty($npr_b33)){
									$n3 = '0';
								}else{
									$n3 = $npr_b33;
								}
								$target_npr33 = $pm_npr311;
								$actual_npr33 = round($npr_gr33/$h3,2);
								if($actual_npr33 < $target_npr33){
									$s33 = $html;
								}else{
									$s33 = $html1;
									$randomcolor2 = "#90EE90";
								}
								if($time < '02'){
									$s33 = $html2;
								}
								//effieciency
								$target_eff33 = round($pm_npr311 * $h3);
								$actual_eff33 = $npr_gr33;
								$eff3 = round(100 * ($actual_eff33/$target_eff33));
								if($npr_h3 == '02'){
									?>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo '02-03'; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo $npr_gr33; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo $n3; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo $target_npr33; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo $actual_npr33; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo $eff3; ?>%</td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo '<span style="font-size: 22pt">' . $s33 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo '02-03'; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo $target_npr33; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor2 ?>;"><?php echo '<span style="font-size: 22pt">' . $s33 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i3 = 03;
							$sql32 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t3 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 3";
							$res32 = mysqli_query($db, $sql32);
							$r32 = $res32->fetch_assoc();
							$tp32 = $r32['t3'];
							$p32 = 3;
							if($tp32 == $p32){
								$randomcolor3 = "#FF3131";
							}else if($i3 == $time){
								$randomcolor3 = "#dadada";
							}else{
								$randomcolor3 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor3 ?>;">
								<?php
								$pm_npr4= 30;
								$qur31 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'   and ( npr_h = '03' or npr_h = '3') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result34 = mysqli_query($db,$qur31);
								$rowc044 = $result34->fetch_assoc();
								$h4 = 1;
								//npr
								$npr_h4 = $rowc044["npr_h"];
								$npr_gr4 = $rowc044["npr_gr"];
								$npr_b4 = $rowc044["npr_b"];
								if(empty($npr_b4)){
									$n4 = '0';
								}else{
									$n4 = $npr_b4;
								}
								$target_npr4 = $pm_npr4;
								$actual_npr4 = round($npr_gr4/$h4,2);
								if($actual_npr4 < $target_npr4){
									$s4 = $html;
								}else{
									$s4 = $html1;
									$randomcolor3 = "#90EE90";
								}
								if($time < '03'){
									$s4 = $html2;
								}
								//effieciency
								$target_eff4 = round($pm_npr4 * $h4);
								$actual_eff4 = $npr_gr4;
								$eff4 = round(100 * ($actual_eff4/$target_eff4));

								if($npr_h3 == '03'){
									?>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo '03-04'; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo $npr_gr4; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo $n4; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo $target_npr4; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo $actual_npr4; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo $eff4; ?>%</td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo '<span style="font-size: 22pt">' . $s4 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo '03-04'; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo $target_npr4; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor3 ?>;"><?php echo '<span style="font-size: 22pt">' . $s4 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i4 = 04;
							$sql42 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t4 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 4";
							$res42 = mysqli_query($db, $sql42);
							$r42 = $res42->fetch_assoc();
							$tp42 = $r42['t4'];
							$p42 = 4;
							if($tp42 == $p42){
								$randomcolor4 = "#FF3131";
							}else if($i4 == $time){
								$randomcolor4 = "#dadada";
							}else{
								$randomcolor4 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor4 ?>;">
								<?php
								$pm_npr55= 30;
								$qur55 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'   and ( npr_h = '04' or npr_h = '4') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result55 = mysqli_query($db,$qur55);
								$row55 = $result55->fetch_assoc();
								$h55 = 1;
								//npr
								$npr_h55 = $row55["npr_h"];
								$npr_gr55 = $row55["npr_gr"];
								$npr_b55 = $row55["npr_b"];
								if(empty($npr_b55)){
									$n5 = '0';
								}else{
									$n5 = $npr_b55;
								}
								$target_npr55 = $pm_npr55;
								$actual_npr55 = round($npr_gr55/$h55,2);
								if($actual_npr55 < $target_npr55){
									$s55 = $html;
								}else{
									$s55 = $html1;
									$randomcolor4 = "#90EE90";
								}
								if($time < '04'){
									$s55 = $html2;
								}
								//effieciency
								$target_eff55 = round($pm_npr55 * $h55);
								$actual_eff55 = $npr_gr55;
								$eff55 = round(100 * ($actual_eff55/$target_eff55));
								if($npr_h55 == '04'){
									?>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo '04-05'; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo $npr_gr55; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo $n5; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo $target_npr55; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo $actual_npr55; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo $eff55; ?>%</td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo '<span style="font-size: 22pt">' . $s55 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo '04-05'; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo $target_npr55; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"<?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor4 ?>;"><?php echo '<span style="font-size: 22pt">' . $s55 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i5 = 05;
							$sql52 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t5 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 5";
							$res52 = mysqli_query($db, $sql52);
							$r52 = $res52->fetch_assoc();
							$tp52 = $r52['t5'];
							$p52 = 5;
							if($tp52 == $p52){
								$randomcolor5 = "#FF3131";
							}else if($i5 == $time){
								$randomcolor5 = "#dadada";
							}else{
								$randomcolor5 = "#FFFFFF";
							}
							?>
							<tr style="background-color: <?php echo $randomcolor5 ?>;">
								<?php
								$pm_npr2= 30;
								$qur21 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'   and ( npr_h = '05' or npr_h = '5') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result211 = mysqli_query($db,$qur21);
								$row211 = $result211->fetch_assoc();
								$h2 = 1;
								//npr
								$npr_h2 = $row211["npr_h"];
								$npr_gr2 = $row211["npr_gr"];
								$npr_b2 = $row211["npr_b"];
								if(empty($npr_b2)){
									$n6 = '0';
								}else{
									$n6 = $npr_b2;
								}
								$target_npr2 = $pm_npr2;
								$actual_npr2 = round($npr_gr2/$h2,2);
								if($actual_npr2 < $target_npr2){
									$s2 = $html;
								}else{
									$s2 = $html1;
									$randomcolor5 = "#90EE90";
								}
								if($time < '05'){
									$s2 = $html2;
								}
								//effieciency
								$target_eff2 = round($pm_npr2 * $h2);
								$actual_eff2 = $npr_gr2;
								$eff2 = round(100 * ($actual_eff2/$target_eff2));
								if($npr_h2 == '05'){
									?>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo '05-06'; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo $npr_gr2; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo $n6; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo $target_npr2; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo $actual_npr2; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo $eff2; ?>%</td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo '<span style="font-size: 22pt">' . $s2 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo '05-06'; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo $target_npr2; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor5 ?>;"><?php echo '<span style="font-size: 22pt">' . $s2 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i6 = 06;
							$sql62 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t6 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 6";
							$res62 = mysqli_query($db, $sql62);
							$r62 = $res62->fetch_assoc();
							$tp62 = $r62['t6'];
							$p62 = 6;
							if($tp62 == $p62){
								$randomcolor6 = "#FF3131";
							}else if($i6 == $time){
								$randomcolor6 = "#dadada";
							}else{
								$randomcolor6 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor6 ?>;">
								<?php
								$pm_npr3= 30;
								$qur31 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'   and ( npr_h = '06' or npr_h = '6') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result311 = mysqli_query($db,$qur31);
								$row311 = $result311->fetch_assoc();
								$h3 = 1;
								//npr
								$npr_h3 = $row311["npr_h"];
								$npr_gr3 = $row311["npr_gr"];
								$npr_b3 = $row311["npr_b"];
								if(empty($npr_b3)){
									$n7 = '0';
								}else{
									$n7 = $npr_b3;
								}
								$target_npr3 = $pm_npr3;
								$actual_npr3 = round($npr_gr3/$h3,2);
								if($actual_npr3 < $target_npr3){
									$s3 = $html;
								}else{
									$s3 = $html1;
									$randomcolor6 = "#90EE90";
								}
								if($time < '06'){
									$s3 = $html2;
								}
								//effieciency
								$target_eff3 = round($pm_npr3 * $h3);
								$actual_eff3 = $npr_gr3;
								$eff3 = round(100 * ($actual_eff3/$target_eff3));
								if($npr_h3 == '06'){
									?>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo '06-07'; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo $npr_gr3; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo $n7; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo $target_npr3; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo $actual_npr3; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo $eff3; ?>%</td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo '<span style="font-size: 22pt">' . $s3 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo '06-07'; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo $target_npr3; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor6 ?>;"><?php echo '<span style="font-size: 22pt">' . $s3 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i7 = 07;
							$sql72 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t7 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 7";
							$res72 = mysqli_query($db, $sql72);
							$r72 = $res72->fetch_assoc();
							$tp72 = $r72['t7'];
							$p72 = 7;
							if($tp72 == $p72){
								$randomcolor7 = "#FF3131";
							}else if($i7 == $time){
								$randomcolor7 = "#dadada";
							}else{
								$randomcolor7 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor7 ?>;">
								<?php
								$pm_npr41= 30;
								$qur41 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'   and ( npr_h = '07' or npr_h = '7') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result411 = mysqli_query($db,$qur41);
								$row411 = $result411->fetch_assoc();
								$h41 = 1;
								//npr
								$npr_h41 = $row411["npr_h"];
								$npr_gr41 = $row411["npr_gr"];
								$npr_b41 = $row411["npr_b"];
								if(empty($npr_b41)){
									$n8 = '0';
								}else{
									$n8 = $npr_b41;
								}
								$target_npr41 = $pm_npr41;
								$actual_npr41 = round($npr_gr41/$h41,2);
								if($actual_npr41 < $target_npr41){
									$s41 = $html;
								}else{
									$s41 = $html1;
									$randomcolor7 = "#90EE90";
								}
								if($time < '07'){
									$s41 = $html2;
								}
								//effieciency
								$target_eff41 = round($pm_npr41 * $h41);
								$actual_eff41 = $npr_gr41;
								$eff41 = round(100 * ($actual_eff41/$target_eff41));
								if($npr_h41 == '07'){
									?>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo '07-08'; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo $npr_gr41; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo $n8; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo $target_npr41; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo $actual_npr41; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo $eff41; ?>%</td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo '<span style="font-size: 22pt">' . $s41 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo '07-08'; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo $target_npr41; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor7 ?>;"><?php echo '<span style="font-size: 22pt">' . $s41 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i8 = 8;
							$sql82 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t8 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 8";
							$res82 = mysqli_query($db, $sql82);
							$r82 = $res82->fetch_assoc();
							$tp82 = $r82['t8'];
							$p82 = 8;
							if($tp82 == $p82){
								$randomcolor8 = "#FF3131";
							}else if($i8 == $time){
								$randomcolor8 = "#dadada";
							}else{
								$randomcolor8 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor8 ?>;">
								<?php
								$pm_npr51= 30;
								$qur51 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'   and ( npr_h = '08' or npr_h = '8') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result511 = mysqli_query($db,$qur51);
								$row511 = $result511->fetch_assoc();
								$h51 = 1;
								//npr
								$npr_h51 = $row511["npr_h"];
								$npr_gr51 = $row511["npr_gr"];
								$npr_b51 = $row511["npr_b"];
								if(empty($npr_b51)){
									$n9 = '0';
								}else{
									$n9 = $npr_b51;
								}
								$target_npr51 = $pm_npr51;
								$actual_npr51 = round($npr_gr51/$h51,2);
								if($actual_npr51 < $target_npr51){
									$s51 = $html;
								}else{
									$s51 = $html1;
									$randomcolor8 = "#90EE90";
								}
								if($time < '08'){
									$s51 = $html2;
								}
								//effieciency
								$target_eff51 = round($pm_npr51 * $h51);
								$actual_eff51 = $npr_gr51;
								$eff51 = round(100 * ($actual_eff51/$target_eff51));
								if($npr_h51 == '08'){
									?>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo '08-09'; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo $npr_gr51; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo $n9; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo $target_npr51; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo $actual_npr51; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo $eff51; ?>%</td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo '<span style="font-size: 22pt">' . $s51 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo '08-09'; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo $target_npr41; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor8 ?>;"><?php echo '<span style="font-size: 22pt">' . $s51 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i9 = 9;
							$sql92 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t9 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 9";
							$res92 = mysqli_query($db, $sql92);
							$r92 = $res92->fetch_assoc();
							$tp92 = $r92['t9'];
							$p92 = 9;
							if($tp92 == $p92){
								$randomcolor9 = "#FF3131";
							}else if($i9 == $time){
								$randomcolor9 = "#dadada";
							}else{
								$randomcolor9 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor9 ?>;">
								<?php
								$pm_npr61= 30;
								$qur61 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'   and ( npr_h = '09' or npr_h = '9') and date(`created_on`) = '$chicagotime' group by npr_h";
								$result611 = mysqli_query($db,$qur61);
								$row611 = $result611->fetch_assoc();
								$h61 = 1;
								//npr
								$npr_h61 = $row611["npr_h"];
								$npr_gr61 = $row611["npr_gr"];
								$npr_b61 = $row611["npr_b"];
								if(empty($npr_b61)){
									$n = '0';
								}else{
									$n = $npr_b61;
								}
								$target_npr61 = $pm_npr61;
								$actual_npr61 = round($npr_gr61/$h61,2);
								if($actual_npr61 < $target_npr61){
									$s61 = $html;
								}else{
									$s61 = $html1;
									$randomcolor9 = "#90EE90";
								}
								if($time < '09'){
									$s61 = $html2;
								}
								//effieciency
								$target_eff61 = round($pm_npr61 * $h61);
								$actual_eff61 = $npr_gr61;
								$eff61 = round(100 * ($actual_eff61/$target_eff61));
								if($npr_h61 == '09'){
									?>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo '09-10'; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo $npr_gr61; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo $n; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo $target_npr61; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo $actual_npr61; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo $eff61; ?>%</td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo '<span style="font-size: 22pt">' . $s61 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo '09-10'; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo $target_npr61; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor9 ?>;"><?php echo '<span style="font-size: 22pt">' . $s61 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i10 = 10;
							$sql102 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t10 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 10";
							$res102 = mysqli_query($db, $sql102);
							$r102 = $res102->fetch_assoc();
							$tp102 = $r102['t10'];
							$p102 = 10;
							if($tp102 == $p102){
								$randomcolor10 = "#FF3131";
							}else if($i10 == $time){
								$randomcolor10 = "#dadada";
							}else{
								$randomcolor10 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor10 ?>;">
								<?php
								$pm_npr71= 30;
								$qur71 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '10' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result711 = mysqli_query($db,$qur71);
								$row711 = $result711->fetch_assoc();
								$h71 = 1;
								//npr
								$npr_h71 = $row711["npr_h"];
								$npr_gr71 = $row711["npr_gr"];
								$npr_b71 = $row711["npr_b"];
								if(empty($npr_b71)){
									$n10 = '0';
								}else{
									$n10 = $npr_b71;
								}
								$target_npr71 = $pm_npr71;
								$actual_npr71 = round($npr_gr71/$h71,2);
								if($actual_npr71 < $target_npr71){
									$s71 = $html;
								}else{
									$s71 = $html1;
									$randomcolor10 = "#90EE90";
								}
								if($time < '10'){
									$s71 = $html2;
								}
								//effieciency
								$target_eff71 = round($pm_npr71 * $h71);
								$actual_eff71 = $npr_gr71;
								$eff71 = round(100 * ($actual_eff71/$target_eff71));
								if($npr_h71 == '10'){
									?>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo '10-11'; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo $npr_gr71; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo $n10; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo $target_npr71; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo $actual_npr71; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo $eff71; ?>%</td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo '<span style="font-size: 22pt">' . $s71 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo '10-11'; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo $target_npr71; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor10 ?>;"><?php echo '<span style="font-size: 22pt">' . $s71 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i11 = 11;
							$sql112 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t11 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 11";
							$res112 = mysqli_query($db, $sql112);
							$r112 = $res112->fetch_assoc();
							$tp112 = $r112['t11'];
							$p112 = 11;
							if($tp112 == $p112){
								$randomcolor11 = "#FF3131";
							}else if($i11 == $time){
								$randomcolor11 = "#dadada";
							}else{
								$randomcolor11 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor11 ?>;">
								<?php
								$pm_npr81= 30;
								$qur81 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '11' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result811 = mysqli_query($db,$qur81);
								$row811 = $result811->fetch_assoc();
								$h81 = 1;
								//npr
								$npr_h81 = $row811["npr_h"];
								$npr_gr81 = $row811["npr_gr"];
								$npr_b81 = $row811["npr_b"];
								if(empty($npr_b81)){
									$n11 = '0';
								}else{
									$n11 = $npr_b81;
								}
								$target_npr81 = $pm_npr81;
								$actual_npr81 = round($npr_gr81/$h81,2);
								if($actual_npr81 < $target_npr81){
									$s81 = $html;
								}else{
									$s81 = $html1;
									$randomcolor11 = "#90EE90";
								}
								if($time < '11'){
									$s81 = $html2;
								}
								//effieciency
								$target_eff81 = round($pm_npr81 * $h81);
								$actual_eff81 = $npr_gr81;
								$eff81 = round(100 * ($actual_eff81/$target_eff81));
								if($npr_h81 == '11'){
									?>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo '11-12'; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo $npr_gr81; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo $n11; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo $target_npr81; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo $actual_npr81; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo $eff81; ?>%</td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo '<span style="font-size: 22pt">' . $s81 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo '11-12'; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo $target_npr81; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor11 ?>;"><?php echo '<span style="font-size: 22pt">' . $s81 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>

			<div class="col-md-6 com-mobile-version">
				<div class="panel panel-flat cd" style="margin-top: 10px;">
					<!--<div class="panel-heading">-->
					<form>
						<table class="table table-sm">
							<thead>
							<tr>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Hours<br>(PM)</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Goodpiece</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Badpiece</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Target NPR</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Actual NPR</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Effieciency</th>
								<th style="text-align:center;border: 1px solid lightgray;border-collapse: collapse;">Status</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$i12 = 12;
							$sql122 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t12 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 12";
							$res122 = mysqli_query($db, $sql122);
							$r122 = $res122->fetch_assoc();
							$tp122 = $r122['t12'];
							$p122 = 12;
							if($tp122 == $p122){
								$randomcolor12 = "#FF3131";
							}else if($i12 == $time){
								$randomcolor12 = "#dadada";
							}else{
								$randomcolor12 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor12 ?>;">
								<?php
								$pm_npr91= 30;
								$qur91 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '12' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result911 = mysqli_query($db,$qur91);
								$row911 = $result911->fetch_assoc();
								$h91 = 1;
								//npr
								$npr_h91 = $row911["npr_h"];
								$npr_gr91 = $row911["npr_gr"];
								$npr_b91 = $row911["npr_b"];
								if(empty($npr_b91)){
									$n12 = '0';
								}else{
									$n12 = $npr_b91;
								}
								$target_npr91 = $pm_npr91;
								$actual_npr91 = round($npr_gr91/$h91,2);
								if($actual_npr91 < $target_npr91){
									$s91 = $html;
								}else{
									$s91 = $html1;
									$randomcolor12 = "#90EE90";
								}
								if($time < '12'){
									$s91 = $html2;
								}
								//effieciency
								$target_eff91 = round($pm_npr91 * $h91);
								$actual_eff91 = $npr_gr91;
								$eff91 = round(100 * ($actual_eff91/$target_eff91));
								if($npr_h91 == '12'){
									?>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo '00-01'; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo $npr_gr91; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo $n12; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo $target_npr91; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo $actual_npr91; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo $eff91; ?>%</td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo '<span style="font-size: 22pt">' . $s91 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo '00-01'; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo $target_npr91; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor12 ?>;"><?php echo '<span style="font-size: 22pt">' . $s91 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i13 = 13;
							$sql132 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t13 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 13";
							$res132 = mysqli_query($db, $sql132);
							$r132 = $res132->fetch_assoc();
							$tp132 = $r132['t13'];
							$p132 = 13;
							if($tp132 == $p132){
								$randomcolor13 = "#FF3131";
							}else if($i13 == $time){
								$randomcolor13 = "#dadada";
							}else{
								$randomcolor13 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;">
								<?php
								$pm_npr911= 30;
								$qur911 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '13' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9111 = mysqli_query($db,$qur911);
								$row9111 = $result911->fetch_assoc();
								$h911 = 1;
								//npr
								$npr_h911 = $row9111["npr_h"];
								$npr_gr911 = $row9111["npr_gr"];
								$npr_b911 = $row9111["npr_b"];
								if(empty($npr_b911)){
									$n13 = '0';
								}else{
									$n13 = $npr_b911;
								}
								$target_npr911 = $pm_npr911;
								$actual_npr911 = round($npr_gr911/$h911,2);
								if($actual_npr911 < $target_npr911){
									$s911 = $html;
								}else{
									$s911 = $html1;
									$randomcolor13 = "#90EE90";
								}
								if($time < '13'){
									$s911 = $html2;
								}
								//effieciency
								$target_eff911 = round($pm_npr911 * $h911);
								$actual_eff911 = $npr_gr911;
								$eff911 = round(100 * ($actual_eff911/$target_eff911));
								if($npr_h911 == '13'){
									?>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo '01-02'; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo $npr_gr911; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo $n13; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo $target_npr911; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo $actual_npr911; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo $eff911; ?>%</td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo '<span style="font-size: 22pt">' . $s911 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo '01-02'; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo $target_npr911; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor13 ?>;height: fit-content;"><?php echo '<span style="font-size: 22pt">' . $s911 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i14 = 14;
							$sql142 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t14 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 14";
							$res142 = mysqli_query($db, $sql142);
							$r142 = $res142->fetch_assoc();
							$tp142 = $r142['t14'];
							$p142 = 14;
							if($tp142 == $p142){
								$randomcolor14 = "#FF3131";
							}else if($i14 == $time){
								$randomcolor14 = "#dadada";
							}else{
								$randomcolor14 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor14 ?>;">
								<?php
								$pm_npr921= 30;
								$qur921 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '14' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9211 = mysqli_query($db,$qur921);
								$row9211 = $result9211->fetch_assoc();
								$h921 = 1;
								//npr
								$npr_h921 = $row9211["npr_h"];
								$npr_gr921 = $row9211["npr_gr"];
								$npr_b921 = $row9211["npr_b"];
								if(empty($npr_b921)){
									$n14 = '0';
								}else{
									$n14 = $npr_b921;
								}
								$target_npr921 = $pm_npr921;
								$actual_npr921 = round($npr_gr921/$h921,2);
								if($actual_npr921 < $target_npr921){
									$s921 = $html;
								}else{
									$s921 = $html1;
									$randomcolor14 = "#90EE90";
								}
								if($time < '14'){
									$s921 = $html2;
								}
								//effieciency
								$target_eff921 = round($pm_npr921 * $h921);
								$actual_eff921 = $npr_gr921;
								$eff921 = round(100 * ($actual_eff921/$target_eff921));
								if($npr_h921 == '14'){
									?>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo '02-03'; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo $npr_gr921; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo $n14; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo $target_npr921; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo $actual_npr921; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo $eff921; ?>%</td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo '<span style="font-size: 22pt">' . $s921 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo '02-03'; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo $target_npr921; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor14 ?>;"><?php echo '<span style="font-size: 22pt">' . $s921 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i15 = 15;
							$sql152 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t15 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 15";
							$res152 = mysqli_query($db, $sql152);
							$r152 = $res152->fetch_assoc();
							$tp152 = $r152['t15'];
							$p152 = 15;
							if($tp152 == $p152){
								$randomcolor15 = "#FF3131";
							}else if($i15 == $time){
								$randomcolor15 = "#dadada";
							}else{
								$randomcolor15 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor15 ?>;">
								<?php
								$pm_npr931= 30;
								$qur931 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '15' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9311 = mysqli_query($db,$qur931);
								$row9311 = $result9311->fetch_assoc();
								$h931 = 1;
								//npr
								$npr_h931 = $row9311["npr_h"];
								$npr_gr931 = $row9311["npr_gr"];
								$npr_b931 = $row9311["npr_b"];
								if(empty($npr_b931)){
									$n15 = '0';
								}else{
									$n15 = $npr_b931;
								}
								$target_npr931 = $pm_npr931;
								$actual_npr931 = round($npr_gr931/$h931,2);
								if($actual_npr931 < $target_npr931){
									$s931 = $html;
								}else{
									$s931 = $html1;
									$randomcolor15 = "#90EE90";
								}
								if($time < '15'){
									$s931 = $html2;
								}
								//effieciency
								$target_eff931 = round($pm_npr931 * $h931);
								$actual_eff931 = $npr_gr931;
								$eff931 = round(100 * ($actual_eff931/$target_eff931));
								if($npr_h931 == '15'){
									?>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo '03-04'; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo $npr_gr931; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo $n15; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo $target_npr931; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo $actual_npr931; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo $eff931; ?>%</td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo '<span style="font-size: 22pt">' . $s931 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo '03-04'; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo $target_npr931; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor15 ?>;"><?php echo '<span style="font-size: 22pt">' . $s931 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i16 = 16;
							$sql162 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t16 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 16";
							$res162 = mysqli_query($db, $sql162);
							$r162 = $res162->fetch_assoc();
							$tp162 = $r162['t16'];
							$p162 = 16;
							if($tp162 == $p162){
								$randomcolor16 = "#FF3131";
							}else if($i16 == $time){
								$randomcolor16 = "#dadada";
							}else{
								$randomcolor16 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor16 ?>;">
								<?php
								$pm_npr941= 30;
								$qur941 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '16' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9411 = mysqli_query($db,$qur941);
								$row9411 = $result9411->fetch_assoc();
								$h941 = 1;
								//npr
								$npr_h941 = $row9411["npr_h"];
								$npr_gr941 = $row9411["npr_gr"];
								$npr_b941 = $row9411["npr_b"];
								if(empty($npr_b941)){
									$n16 = '0';
								}else{
									$n16 = $npr_b941;
								}
								$target_npr941 = $pm_npr941;
								$actual_npr941 = round($npr_gr941/$h941,2);
								if($actual_npr941 < $target_npr941){
									$s941 = $html;
								}else{
									$s941 = $html1;
									$randomcolor16 = "#90EE90";
								}
								if($time < '16'){
									$s941 = $html2;
								}

								//effieciency
								$target_eff941 = round($pm_npr941 * $h941);
								$actual_eff941 = $npr_gr941;
								$eff941 = round(100 * ($actual_eff941/$target_eff941));
								if($npr_h941 == '16'){
									?>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo '04-05'; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo $npr_gr941; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo $n16; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo $target_npr941; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo $actual_npr941; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo $eff941; ?>%</td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo '<span style="font-size: 22pt">' . $s941 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo '04-05'; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo $target_npr941; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor16 ?>;"><?php echo '<span style="font-size: 22pt">' . $s941 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i17 = 17;
							$sql172 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t17 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 17";
							$res172 = mysqli_query($db, $sql172);
							$r172 = $res172->fetch_assoc();
							$tp172 = $r172['t16'];
							$p172 = 17;
							if($tp172 == $p172){
								$randomcolor17 = "#FF3131";
							}else if($i17 == $time){
								$randomcolor17 = "#dadada";
							}else{
								$randomcolor17 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor17 ?>;">
								<?php
								$pm_npr951= 30;
								$qur951 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '17' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9511 = mysqli_query($db,$qur951);
								$row9511 = $result9511->fetch_assoc();
								$h951 = 1;
								//npr
								$npr_h951 = $row9511["npr_h"];
								$npr_gr951 = $row9511["npr_gr"];
								$npr_b951 = $row9511["npr_b"];
								if(empty($npr_b951)){
									$n17 = '0';
								}else{
									$n17 = $npr_b951;
								}
								$target_npr951 = $pm_npr951;
								$actual_npr951 = round($npr_gr951/$h951,2);
								if($actual_npr951 < $target_npr951){
									$s951 = $html;
								}else{
									$s951 = $html1;
									$randomcolor17 = "#90EE90";
								}
								if($time < '17'){
									$s951 = $html2;
								}
								//effieciency
								$target_eff951 = round($pm_npr951 * $h951);
								$actual_eff951 = $npr_gr951;
								$eff951 = round(100 * ($actual_eff951/$target_eff951));
								if($npr_h951 == '17'){
									?>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo '05-06'; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo $npr_gr951; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo $n17; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo $target_npr951; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo $actual_npr951; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo $eff951; ?>%</td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo '<span style="font-size: 22pt">' . $s951 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo '05-06'; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo $target_npr951; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor17 ?>;"><?php echo '<span style="font-size: 22pt">' . $s951 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i18 = 18;
							$sql182 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t18 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 18";
							$res182 = mysqli_query($db, $sql182);
							$r182 = $res182->fetch_assoc();
							$tp182 = $r182['t18'];
							$p182 = 18;
							if($tp182 == $p182){
								$randomcolor18 = "#FF3131";
							}else if($i18 == $time){
								$randomcolor18 = "#dadada";
							}else{
								$randomcolor18 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor18 ?>;">
								<?php
								$pm_npr961= 30;
								$qur961 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '18' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9611 = mysqli_query($db,$qur961);
								$row9611 = $result9611->fetch_assoc();
								$h961 = 1;
								//npr
								$npr_h961 = $row9611["npr_h"];
								$npr_gr961 = $row9611["npr_gr"];
								$npr_b961 = $row9611["npr_b"];
								if(empty($npr_b961)){
									$n18 = '0';
								}else{
									$n18 = $npr_b961;
								}
								$target_npr961 = $pm_npr961;
								$actual_npr961 = round($npr_gr961/$h961,2);
								if($actual_npr961 < $target_npr961){
									$s961 = $html;
								}else{
									$s961 = $html1;
									$randomcolor18 = "#90EE90";
								}
								if($time < '18'){
									$s961 = $html2;
								}
								//effieciency
								$target_eff961 = round($pm_npr961 * $h961);
								$actual_eff961 = $npr_gr961;
								$eff961 = round(100 * ($actual_eff961/$target_eff961));
								if($npr_h961 == '18'){
									?>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo '06-07'; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo $npr_gr961; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo $n18; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo $target_npr961; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo $actual_npr961; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo $eff961; ?>%</td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo '<span style="font-size: 22pt">' . $s961 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo '06-07'; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo $target_npr961; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor18 ?>;"><?php echo '<span style="font-size: 22pt">' . $s961 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i19 = 19;
							$sql192 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t19 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 19";
							$res192 = mysqli_query($db, $sql192);
							$r192 = $res192->fetch_assoc();
							$tp192 = $r192['t19'];
							$p192 = 19;
							if($tp192 == $p192){
								$randomcolor19 = "#FF3131";
							}else if($i19 == $time){
								$randomcolor19 = "#dadada";
							}else{
								$randomcolor19 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor19 ?>;">
								<?php
								$pm_npr971= 30;
								$qur971 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '19' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9711 = mysqli_query($db,$qur971);
								$row9711 = $result9711->fetch_assoc();
								$h971 = 1;
								//npr
								$npr_h971 = $row9711["npr_h"];
								$npr_gr971 = $row9711["npr_gr"];
								$npr_b971 = $row9711["npr_b"];
								if(empty($npr_b971)){
									$n19 = '0';
								}else{
									$n19 = $npr_b971;
								}
								$target_npr971 = $pm_npr971;
								$actual_npr971 = round($npr_gr971/$h971,2);
								if($actual_npr971 < $target_npr971){
									$s971 = $html;
								}else{
									$s971 = $html1;
									$randomcolor19 = "#90EE90";
								}
								if($time < '19'){
									$s971 = $html2;
								}
								//effieciency
								$target_eff971 = round($pm_npr971 * $h971);
								$actual_eff971 = $npr_gr971;
								$eff971 = round(100 * ($actual_eff971/$target_eff971));
								if($npr_h971 == '19'){
									?>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo '07-08'; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo $npr_gr971; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo $n19; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo $target_npr971; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo $actual_npr971; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo $eff971; ?>%</td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo '<span style="font-size: 22pt">' . $s971 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo '07-08'; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo $target_npr971; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor19 ?>;"><?php echo '<span style="font-size: 22pt">' . $s971 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i20 = 20;
							$sql202 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t20 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 20";
							$res202 = mysqli_query($db, $sql202);
							$r202 = $res202->fetch_assoc();
							$tp202 = $r202['t20'];
							$p202 = 20;
							if($tp202 == $p202){
								$randomcolor20 = "#FF3131";
							}else if($i20 == $time){
								$randomcolor20 = "#dadada";
							}else{
								$randomcolor20 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor20 ?>;">
								<?php
								$pm_npr981= 30;
								$qur981 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '20' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9811 = mysqli_query($db,$qur981);
								$row9811 = $result9811->fetch_assoc();
								$h981 = 1;
								//npr
								$npr_h981 = $row9811["npr_h"];
								$npr_gr981 = $row9811["npr_gr"];
								$npr_b981 = $row9811["npr_b"];
								if(empty($npr_b981)){
									$n20 = '0';
								}else{
									$n20 = $npr_b981;
								}
								$target_npr981 = $pm_npr981;
								$actual_npr981 = round($npr_gr981/$h981,2);
								if($actual_npr981 < $target_npr981){
									$s981 = $html;
								}else{
									$s981 = $html1;
									$randomcolor20 = "#90EE90";
								}
								if($time < '20'){
									$s981 = $html2;
								}
								//effieciency
								$target_eff981 = round($pm_npr981 * $h981);
								$actual_eff981 = $npr_gr981;
								$eff981 = round(100 * ($actual_eff981/$target_eff981));
								if($npr_h981 == '20'){
									?>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo '08-09'; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo $npr_gr981; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo $n20; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo $target_npr981; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo $actual_npr981; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo $eff981; ?>%</td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo '<span style="font-size: 22pt">' . $s981 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo '08-09'; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo $target_npr981; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor20 ?>;"><?php echo '<span style="font-size: 22pt">' . $s981 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i21 = 21;
							$sql212 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t21 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 21";
							$res212 = mysqli_query($db, $sql212);
							$r212 = $res212->fetch_assoc();
							$tp212 = $r212['t21'];
							$p212 = 21;
							if($tp212 == $p212){
								$randomcolor21 = "#FF3131";
							}else if($i21 == $time){
								$randomcolor21 = "#dadada";
							}else{
								$randomcolor21 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor21 ?>;">
								<?php
								$pm_npr991= 30;
								$qur991 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '21' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result9911 = mysqli_query($db,$qur991);
								$row9911 = $result9911->fetch_assoc();
								$h991 = 1;
								//npr
								$npr_h991 = $row9911["npr_h"];
								$npr_gr991 = $row9911["npr_gr"];
								$npr_b991 = $row9911["npr_b"];
								if(empty($npr_b991)){
									$n21 = '0';
								}else{
									$n21 = $npr_b991;
								}
								$target_npr991 = $pm_npr991;
								$actual_npr991 = round($npr_gr991/$h991,2);
								if($actual_npr991 < $target_npr991){
									$s991 = $html;
								}else{
									$s991 = $html1;
									$randomcolor21 = "#90EE90";
								}
								if($time < '21'){
									$s991 = $html2;
								}
								//effieciency
								$target_eff991 = round($pm_npr991 * $h991);
								$actual_eff991 = $npr_gr991;
								$eff991 = round(100 * ($actual_eff991/$target_eff991));
								if($npr_h991 == '21'){
									?>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo '09-10'; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo $npr_gr991; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo $n21; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo $target_npr991; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo $actual_npr991; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo $eff991; ?>%</td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo '<span style="font-size: 22pt">' . $s991 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo '09-10'; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo $target_npr991; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor21 ?>;"><?php echo '<span style="font-size: 22pt">' . $s991 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i22 = 22;
							$sql222 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t22 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 22";
							$res222 = mysqli_query($db, $sql222);
							$r222 = $res222->fetch_assoc();
							$tp222 = $r222['t22'];
							$p222 = 22;
							if($tp222 == $p222){
								$randomcolor22 = "#FF3131";
							}else if($i22 == $time){
								$randomcolor22 = "#dadada";
							}else{
								$randomcolor22 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor22 ?>;">
								<?php
								$pm_npr191= 30;
								$qur191 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '22' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result1911 = mysqli_query($db,$qur191);
								$row1911 = $result1911->fetch_assoc();
								$h191 = 1;
								//npr
								$npr_h191 = $row1911["npr_h"];
								$npr_gr191 = $row1911["npr_gr"];
								$npr_b191 = $row1911["npr_b"];
								if(empty($npr_b191)){
									$n22 = '0';
								}else{
									$n22 = $npr_b191;
								}
								$target_npr191 = $pm_npr191;
								$actual_npr191 = round($npr_gr191/$h191,2);
								if($actual_npr191 < $target_npr191){
									$s191 = $html;
								}else{
									$s191 = $html1;
									$randomcolor22 = "#90EE90";
								}
								if($time < '22'){
									$s191 = $html2;
								}
								//effieciency
								$target_eff191 = round($pm_npr191 * $h191);
								$actual_eff191 = $npr_gr191;
								$eff191 = round(100 * ($actual_eff191/$target_eff191));
								if($npr_h191 == '22'){
									?>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo '10-11'; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo $npr_gr191; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo $n22; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo $target_npr191; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo $actual_npr191; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo $eff191; ?>%</td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo '<span style="font-size: 22pt">' . $s191 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo '10-11'; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo $target_npr191; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor22 ?>;"><?php echo '<span style="font-size: 22pt">' . $s191 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							<?php
							$i23 = 23;
							$sql232 = "SELECT sg_station_event.station_event_id,sg_station_event_log.event_cat_id,sg_station_event.line_id,sg_station_event_log.`created_on`,hour(sg_station_event_log.`created_on`) as t23 FROM `sg_station_event` 
                                      INNER JOIN sg_station_event_log ON sg_station_event.station_event_id = sg_station_event_log.station_event_id 
                                      WHERE sg_station_event.line_id = '$station' and date(sg_station_event_log.`created_on`) = '$chicagotime' and date(sg_station_event.`modified_on`) = '$chicagotime' and sg_station_event_log.event_cat_id = 4 
                                      and hour(sg_station_event_log.`created_on`) = 23";
							$res232 = mysqli_query($db, $sql232);
							$r232 = $res232->fetch_assoc();
							$tp232 = $r232['t23'];
							$p232 = 23;
							if($tp232 == $p232){
								$randomcolor23 = "#FF3131";
							}else if($i23 == $time){
								$randomcolor23 = "#dadada";
							}else{
								$randomcolor23 = "#FFFFFF";
							}

							?>
							<tr style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;">
								<?php
								$pm_npr291= 30;
								$qur291 = "SELECT  npr_h,(`npr_b`) as npr_b,(`npr_gr`) as npr_gr,created_on FROM `npr_station_data` where line_id = '$station1'  and npr_h = '23' and date(`created_on`) = '$chicagotime' group by npr_h";
								$result2911 = mysqli_query($db,$qur291);
								$row2911 = $result2911->fetch_assoc();
								$h291 = 1;
								//npr
								$npr_h291 = $row2911["npr_h"];
								$npr_gr291 = $row2911["npr_gr"];
								$npr_b291 = $row2911["npr_b"];
								if(empty($npr_b291)){
									$n23 = '0';
								}else{
									$n23 = $npr_b291;
								}
								$target_npr291 = $pm_npr291;
								$actual_npr291 = round($npr_gr291/$h291,2);
								if($actual_npr291 < $target_npr291){
									$s291 = $html;
								}else{
									$s291 = $html1;
									$randomcolor23 = "#90EE90";
								}
								if($time < '23'){
									$s291 = $html2;
								}
								//effieciency
								$target_eff291 = round($pm_npr191 * $h291);
								$actual_eff291 = $npr_gr291;
								$eff291 = round(100 * ($actual_eff291/$target_eff291));
								//
								if($npr_h291 == '23'){
									?>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo '11-12'; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo $npr_gr291; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo $n23; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo $target_npr291; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo $actual_npr291; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo $eff291; ?>%</td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo '<span style="font-size: 22pt">' . $s291 . '</span>'; ?></td>
								<?php }else{ ?>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo '11-12'; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo $target_npr291; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo '0'; ?></td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo '0'; ?>%</td>
									<td style="background-color: <?php echo $randomcolor23 ?>;padding-top: 0px;"><?php echo '<span style="font-size: 22pt">' . $s291 . '</span>'; ?></td>
								<?php } ?>
							</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
