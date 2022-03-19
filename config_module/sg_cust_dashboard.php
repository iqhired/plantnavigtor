<?php include("../config.php");
$sg_cust_group_id = $_GET['id'];
$query_sg = "select * from sg_cust_dashboard where sg_cust_group_id = " . $sg_cust_group_id;
$qur = mysqli_query($db, $query_sg);
$row_sg = mysqli_fetch_array($qur);
$line_cust_dash = $row_sg['stations'];
$line_cust_dash_name = $row_sg['sg_cust_dash_name'];
$line_cust_dash_arr = explode(',', $line_cust_dash);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $sitename; ?> | Custom Dashboard</title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
		  type="text/css">
	<link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
	<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-data-adapter.min.js"></script>
	<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
	<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js"></script>
	<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pareto.min.js"></script>
	<link href="https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
	<link href="https://cdn.anychart.com/releases/8.11.0/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
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
	<script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>

	<script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
	<script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>

	<style>
		.anychart-credits{
			display: none !important;
		}
		.datatable-scroll {
			width: 100%;
			overflow-x: scroll;
		}
	</style>
	<style type="text/css">

		.line_head{
			font-size: 16px !important;
			margin: 30px !important;
		}

		@media screen and (min-width:1440px)  {
			.line_head{
				font-size: x-large !important;
				margin: 30px !important;
			}

		}
		@media screen and (min-width:2560px)  {
			.line_head{
				font-size: xx-large !important;
				margin: 30px !important;
			}

		}



	</style>
    <style>
        .open>.dropdown-menu{
            min-width: 200px !important;
        }
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border-top: 2px solid #999;
        }
        table{
            height: 100px;
        }
        #t01{
            height: 120px !important;
        }
        tr{
            background-color: inherit !important;
        }
        .col-container {
            display: table; /* Make the container element behave like a table */
            width: 100%; /* Set full-width to expand the whole page */
        }

        .col {
            display: table-cell; /* Make elements inside the container behave like table cells */
        }
        td{
            width:50% !important;
        }
        .heading-elements {
            background-color: transparent;
        }

        .line_card{
            background-color: #181d50;
        }
        .bg-blue-400 {
            background-color: #181d50;
        }

        .bg-orange-400 {
            background-color: #dc6805;
        }

        .bg-teal-400 {
            background-color: #218838;
        }

        .bg-pink-400 {
            background-color: #c9302c;
        }
        .text_white{
            color: #fff;
        }
        .dashboard_line_heading {
            text-align: center;
            padding-top: 5px;
            font-size: 22px !important;
            /*color: #191e3a;*/
        }

        @media screen and (min-width: 2560px) {
            .dashboard_line_heading {
                font-size: 22px !important;
                padding-top: 5px;
            }
        }

        .thumb img:not(.media-preview) {
            height: 150px !important;
        }
        .cell_bg{
            background-color: #fff;
            color: #333;
        }
        .page-container{
            background-color: #eee;
        }
    </style>


</head>


<!-- Main navbar -->
<?php
$cam_page_header = "Custom Dashboard - " . $line_cust_dash_name;
include("../hp_header.php");
?>

<body class="alt-menu sidebar-noneoverflow">
<div class="page-container">
<!-- Content area -->
<div class="content">
<?php
$line_rr = '';
$i =0 ;
foreach ($line_cust_dash_arr as $line_cust_dash_item){
	if($i == 0){
		$line_rr = "SELECT * FROM  cam_line where enabled = 1 and line_id IN (" ;
		$i++;
		if(isset($line_cust_dash_item) && $line_cust_dash_item != ''){
			$line_rr .= "'" . $line_cust_dash_item. "'";
		}
	}else{
		if(isset($line_cust_dash_item) && $line_cust_dash_item != ''){
			$line_rr .= ",'" . $line_cust_dash_item. "'";
		}
	}
}
$line_rr .= ")";
$query = $line_rr;
$qur = mysqli_query($db, $query);
$countervariable = 0;

while ($rowc = mysqli_fetch_array($qur)) {
	$event_status = '';
	$line_status_text = '';
	$buttonclass = '#000';
	$p_num = '';
	$p_name = '';
	$pf_name = '';
	$time = '';
	$countervariable++;
	$line = $rowc["line_id"];
	//$qur01 = mysqli_query($db, "SELECT created_on as start_time , modified_on as updated_time FROM  sg_station_event where line_id = '$line' and event_status = 1 order BY created_on DESC LIMIT 1");
	$qur01 = mysqli_query($db, "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$line' ORDER by sg_events.created_on DESC LIMIT 1");
	$rowc01 = mysqli_fetch_array($qur01);
	if($rowc01 != null){
		$time = $rowc01['updated_time'];
		$station_event_id = $rowc01['station_event_id'];
		$line_status_text = $rowc01['e_name'];
		$event_status = $rowc01['event_status'];
		$p_num = $rowc01["p_num"];;
		$p_name = $rowc01["p_name"];;
		$pf_name = $rowc01["pf_name"];;
		$buttonclass = $rowc01["color_code"];
		if($event_status == 1){
		    $card_color= "#728C00";
        }else{
			$card_color= "#000000";
        }
		$buttonclass = $rowc01["color_code"];
	}

	if ($countervariable % 4 == 0) {
		?>
        <div class="col-lg-3">
            <div class="panel cell_bg">
                <div class="panel-body" style="background-color:<?php echo $card_color; ?> !important;">
                    <div class="heading-elements"></div>
                    <h3 class="no-margin dashboard_line_heading" style="font-size:xx-large !important;"><?php echo $rowc["line_name"]; ?></h3>
                    <hr/>
                    <div style="font-size:xx-large !important;color: #fff;text-align: center;">
                        <div style="margin-top: 30px;"><?php echo $p_num;$p_num = ''; ?></div>
                        <div style="margin-top: 30px;"><?php echo $pf_name;$pf_name = ''; ?> </div>
                        <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $time; ?>">
                        <div style="margin-top: 30px;"><span><?php echo $p_name;$p_name = ''; ?></span></div>
                    </div>
                </div>
                <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
				<?php
				$variable123 = $time;
				if ($variable123 != "") {
					?>
                    <script>

                        // Set the date we're counting down to
                        var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                        console.log(iddd<?php echo $countervariable; ?>);
                        var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                        // Update the count down every 1 second
                        var x = setInterval(function () {
                            // Get today's date and time
                            var now = getCurrentTime();
                            //new Date().getTime();
                            // Find the distance between now and the count down date
                            var distance = now - countDownDate<?php echo $countervariable; ?>;
                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
                            //console.log("------------------------");
                            // Output the result in an element with id="demo"
                            document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = days + "d " + hours + "h "
                                + minutes + "m " + seconds + "s ";
                            // If the count down is over, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = "EXPIRED";
                            }
                        }, 1000);
                    </script>
				<?php } ?>
                <div style="height: 100%;">
                    <h4 class="text_white" style="font-size:xx-large !important;height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;">
                        <div style="padding: 10px 0px 5px 0px;"><?php echo $line_status_text; ?> - <span
                                    style="padding: 0px 0px 10px 0px;"
                                    id="demo<?php echo $countervariable; ?>">&nbsp;</span><span
                                    id="server-load"></span></div>
                        <!--                                        <div style="padding: 0px 0px 10px 0px;" id="demo-->
						<?php //echo $countervariable;
						?><!--" >&nbsp;</div>-->
                    </h4>
                </div>
            </div>
        </div>
        <?php
	} else {
		?>
        <div class="col-lg-3">
        <div class="panel cell_bg">
            <div class="panel-body" style="background-color:<?php echo $card_color; ?> !important;">
                <div class="heading-elements"></div>
                <h3 class="no-margin dashboard_line_heading" style="font-size:xx-large !important;"><?php echo $rowc["line_name"]; ?></h3>
                <hr/>
                <div style="font-size:xx-large !important;color: #fff;text-align: center;">
                    <div style="margin-top: 30px;"><?php echo $p_num;$p_num = ''; ?></div>
                    <div style="margin-top: 30px;"><?php echo $pf_name;$pf_name = ''; ?> </div>
                    <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $time; ?>">
                    <div style="margin-top: 30px;"><span><?php echo $p_name;$p_name = ''; ?></span></div>
                </div>
            </div>
            <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
			<?php
			$variable123 = $time;
			if ($variable123 != "") {
				?>
                <script>

                    // Set the date we're counting down to
                    var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                    console.log(iddd<?php echo $countervariable; ?>);
                    var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                    // Update the count down every 1 second
                    var x = setInterval(function () {
                        // Get today's date and time
                        var now = getCurrentTime();
                        //new Date().getTime();
                        // Find the distance between now and the count down date
                        var distance = now - countDownDate<?php echo $countervariable; ?>;
                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
                        //console.log("------------------------");
                        // Output the result in an element with id="demo"
                        document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = days + "d " + hours + "h "
                            + minutes + "m " + seconds + "s ";
                        // If the count down is over, write some text
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = "EXPIRED";
                        }
                    }, 1000);
                </script>
			<?php } ?>
            <div style="height: 100%">
                <h4 class="text_white" style="font-size:xx-large !important;height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;">
                    <div style="padding: 10px 0px 5px 0px;"><?php echo $line_status_text; ?> - <span
                                style="padding: 0px 0px 10px 0px;"
                                id="demo<?php echo $countervariable; ?>">&nbsp;</span><span
                                id="server-load"></span></div>
                    <!--                                        <div style="padding: 0px 0px 10px 0px;" id="demo-->
					<?php //echo $countervariable;
					?><!--" >&nbsp;</div>-->
                </h4>
            </div>


        </div>
        </div><?php
	}
}
?>
</div>
<!-- /main content -->
</div>
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/app.js"></script>
</body>
</html>