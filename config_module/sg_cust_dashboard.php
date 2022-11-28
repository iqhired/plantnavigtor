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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    <title>Bootstrap Carousel with Captions</title>-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/menu.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- /global stylesheets -->

    <style>
        /* Custom style to prevent carousel from being distorted
           if for some reason image doesn't load */
        .carousel-item {
            min-height: 280px;
        }

        .page-container {
            background-color: #eee;
        }

        .carousel-indicators .active {
            margin: 1px;
            width: 30px;
            height: 3px;
            background-color: #fff;
        }
    </style>
</head>
<!-- Main navbar -->
<?php
$cam_page_header = "Custom Dashboard - " . $line_cust_dash_name;
include("../hp_header.php");
?>

<body>
<div class="page-container">
    <div class="content" style="background-color:#333">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">


			<?php
			$line_rr = '';
			$i = 0;
			foreach ($line_cust_dash_arr as $line_cust_dash_item) {
				if ($i == 0) {
					$line_rr = "SELECT * FROM  cam_line where enabled = 1 and line_id IN (";
					$i++;
					if (isset($line_cust_dash_item) && $line_cust_dash_item != '') {
						$line_rr .= "'" . $line_cust_dash_item . "'";
					}
				} else {
					if (isset($line_cust_dash_item) && $line_cust_dash_item != '') {
						$line_rr .= ",'" . $line_cust_dash_item . "'";
					}
				}
			}
			$line_rr .= ")";
			$query = $line_rr;
			$qur = mysqli_query($db, $query);
			$num_rows = ($qur->num_rows);
			$row_count_val = $num_rows / 8;
			$countervariable = 0;
			$slide_card_variable = 0;

			$row_count = ceil($row_count_val);
			?>
            <!-- Carousel indicators -->
            <!--            <ol class="carousel-indicators">-->
            <!--				--><?php //for ($x = 0; $x < $row_count; $x++) {
			//					if ($x == 0) { ?>
            <!--                        <li data-bs-target="#myCarousel" data-bs-wrap="true"  data-bs-slide-to="--><?php //echo $x  ?><!--" class="active"></li>-->
            <!--					--><?php //}else {
			//						?>
            <!--                        <li data-bs-target="#myCarousel" data-bs-wrap="true"  data-bs-slide-to="--><?php //echo $x ?><!--"></li>-->
            <!--						--><?php
			//					}
			//				} ?>
            <!--            </ol>-->
            <!-- Wrapper for carousel items -->
            <div class="carousel-inner">

				<?php
				//		while ($rowc = mysqli_fetch_array($qur)) {
				for ($slide_card_variable = 0;
				$slide_card_variable < $num_rows;
				$slide_card_variable++) {
				if ($slide_card_variable == 0){ ?>
                <div class="carousel-item active">
					<?php }else if (($slide_card_variable % 8) == 0){
					?>
                    <div class="carousel-item">
						<?php
						}
						?>

						<?php
						$rowc = mysqli_fetch_array($qur);
						$event_status = '';
						$line_status_text = '';
						$buttonclass = '#000';
						$p_num = '';
						$p_name = '';
						$pf_name = '';
						$time = '';
						//			$slide_card_variable++;
						$countervariable++;
						$line = $rowc["line_id"];
						//$qur01 = mysqli_query($db, "SELECT created_on as start_time , modified_on as updated_time FROM  sg_station_event where line_id = '$line' and event_status = 1 order BY created_on DESC LIMIT 1");
						$qur01 = mysqli_query($db, "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$line' ORDER by sg_events.created_on DESC LIMIT 1");
						$rowc01 = mysqli_fetch_array($qur01);
						if ($rowc01 != null) {
							$time = $rowc01['updated_time'];
							$station_event_id = $rowc01['station_event_id'];
							$line_status_text = $rowc01['e_name'];
							$event_status = $rowc01['event_status'];
							$p_num = $rowc01["p_num"];;
							$p_name = $rowc01["p_name"];;
							$pf_name = $rowc01["pf_name"];;
							$buttonclass = $rowc01["color_code"];
							if ($event_status == 1) {
								$card_color = "#728C00";
							} else {
								$card_color = "#000000";
							}
							$buttonclass = $rowc01["color_code"];
						}

						if ($countervariable % 4 == 0) {
							?>
                            <div class="col-lg-3">
                                <div class="panel cell_bg">
                                    <div class="panel-body"
                                         style="background-color:<?php echo $card_color; ?> !important;">
                                        <div class="heading-elements"></div>
                                        <h3 class="no-margin dashboard_line_heading"
                                            style="font-size:x-large !important;color: #fff;"><?php echo $rowc["line_name"]; ?></h3>
                                        <hr/>
                                        <div style="font-size:x-large !important;color: #fff;text-align: center;height: 180px;">
                                            <div style="margin-top: 10px;"><?php echo $p_num;
												$p_num = ''; ?></div>
                                            <div style="margin-top: 10px;"><?php echo $pf_name;
												$pf_name = ''; ?> </div>
                                            <input type="hidden" id="id<?php echo $countervariable; ?>"
                                                   value="<?php echo $time; ?>">
                                            <div style="margin-top: 10px;"><span><?php echo $p_name;
													$p_name = ''; ?></span></div>
                                        </div>
                                    </div>
                                    <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
									<?php
									$variable123 = $time;
									if ($variable123 != "") {
                                        //include the timing configuration file
                                        include("../timings_config.php");
										?>
                                      <!--  <script>

                                            // Set the date we're counting down to
                                            var iddd<?php /*echo $countervariable; */?> = $("#id<?php /*echo $countervariable; */?>").val();
                                            console.log(iddd<?php /*echo $countervariable; */?>);
                                            var countDownDate<?php /*echo $countervariable; */?> = new Date(iddd<?php /*echo $countervariable; */?>).getTime();
                                            // Update the count down every 1 second
                                            var x = setInterval(function () {
                                                // Get today's date and time
                                                var now = getCurrentTime();
                                                //new Date().getTime();
                                                // Find the distance between now and the count down date
                                                var distance = now - countDownDate<?php /*echo $countervariable; */?>;
                                                // Time calculations for days, hours, minutes and seconds
                                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
                                                //console.log("------------------------");
                                                // Output the result in an element with id="demo"
                                                document.getElementById("demo<?php /*echo $countervariable; */?>").innerHTML = days + "d " + hours + "h "
                                                    + minutes + "m " + seconds + "s ";
                                                // If the count down is over, write some text
                                                if (distance < 0) {
                                                    clearInterval(x);
                                                    document.getElementById("demo<?php /*echo $countervariable; */?>").innerHTML = "EXPIRED";
                                                }
                                            }, 1000);
                                        </script>-->
									<?php } ?>
                                    <div style="height: 100%;">
                                        <h4 class="text_white"
                                            style="font-size:large !important;color: #fff;height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;">
                                            <div style="padding: 10px 0px 5px 0px;"><?php echo $line_status_text; ?> -
                                                <span
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
                                    <h3 class="no-margin dashboard_line_heading"
                                        style="font-size:x-large !important; color: #fff;"><?php echo $rowc["line_name"]; ?></h3>
                                    <hr/>
                                    <div style="font-size:x-large !important;color: #fff;text-align: center;height: 180px;">
                                        <div style="margin-top: 10px;"><?php echo $p_num;
											$p_num = ''; ?></div>
                                        <div style="margin-top: 10px;"><?php echo $pf_name;
											$pf_name = ''; ?> </div>
                                        <input type="hidden" id="id<?php echo $countervariable; ?>"
                                               value="<?php echo $time; ?>">
                                        <div style="margin-top: 10px;"><span><?php echo $p_name;
												$p_name = ''; ?></span></div>
                                    </div>
                                </div>
                                <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
								<?php
								$variable123 = $time;
								if ($variable123 != "") {
                                    //include the timing configuration file
                                    include("../timings_config.php");
									?>
                                    <!--<script>

                                        // Set the date we're counting down to
                                        var iddd<?php /*echo $countervariable; */?> = $("#id<?php /*echo $countervariable; */?>").val();
                                        console.log(iddd<?php /*echo $countervariable; */?>);
                                        var countDownDate<?php /*echo $countervariable; */?> = new Date(iddd<?php /*echo $countervariable; */?>).getTime();
                                        // Update the count down every 1 second
                                        var x = setInterval(function () {
                                            // Get today's date and time
                                            var now = getCurrentTime();
                                            //new Date().getTime();
                                            // Find the distance between now and the count down date
                                            var distance = now - countDownDate<?php /*echo $countervariable; */?>;
                                            // Time calculations for days, hours, minutes and seconds
                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                            //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
                                            //console.log("------------------------");
                                            // Output the result in an element with id="demo"
                                            document.getElementById("demo<?php /*echo $countervariable; */?>").innerHTML = days + "d " + hours + "h "
                                                + minutes + "m " + seconds + "s ";
                                            // If the count down is over, write some text
                                            if (distance < 0) {
                                                clearInterval(x);
                                                document.getElementById("demo<?php /*echo $countervariable; */?>").innerHTML = "EXPIRED";
                                            }
                                        }, 1000);
                                    </script>-->
								<?php } ?>
                                <div style="height: 100%">
                                    <h4 class="text_white"
                                        style="font-size:large !important;color: #fff;height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;">
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
						if (($slide_card_variable == $num_rows) || (($slide_card_variable % 8) == 7)){
						?>
                    </div>
				<?php
				}

				}
				?>


                </div>

            </div>

        </div>
    </div>
</div>
<script>
    var myCarousel = document.querySelector('#myCarousel')
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 8000,
        wrap: true
    })
</script>
<?php include("../footer.php"); ?>	<!-- /page container -->
</body>

</html>