<?php include("config.php");
$temp = "";
$assign_line = htmlspecialchars($_GET["station"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Station Status Overview</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style_main.css" rel="stylesheet" type="text/css">
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css">
<!--    <link href="--><?php //echo $siteURL; ?><!--assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />-->

    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="assets/js/core/app.js"></script>
    <script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="assets/js/time_display.js"></script>
    <script>
        $(document).ready(function () {

            $('.e_progress .circle').removeClass().addClass('circle');
            $('.e_progress .bar').removeClass().addClass('bar');
            $(".circle").first().addClass("active");

            var timer = setInterval(increment, 1000);

            function increment() {
                $(".circle:not(.done)").first().removeClass("active").addClass("done").children(":first-child").html("&#10003;");
                $(".circle:not(.done)").first().addClass("active");
                $(".circle.done").next().addClass("done");
                if ($(".active").find(".title").text() == $("tr:last-child").find("span").text()) {
                    clearInterval(timer);
                }
            }
        });
    </script>
    <style type="text/css">


        @media screen and (min-width: 1440px) and (max-width: 1899px){
            .line_head {
                font-size: 18px !important;
                /*margin-top: 30px !important;*/
            }

        }
        /* CSS Display for TV */
        @media screen and (max-width:1899px) {
            .line_head {
                font-size: large !important;
                /*margin-top: 30px !important;*/
            }

        }
        /* CSS Display for TV */
        @media screen and (min-width:1900px) {
            .navbar-collapse .col-md-3 {
                /*width: 25%;*/
            }
            .line_head {
                font-size: xx-large !important;
                /*margin-top: 30px !important;*/
            }

            .e_progress .circle .title {
                color: #333333 !important;
                font-size: 30px !important;
                line-height: 30px;
                margin: 10px;
                padding: 30px 10px 30px 10px;
                position: absolute;
            }
            .event-timer , .event-timer-val{
                font-size: 100px !important;
                padding: 10px;
                height: 20%;
                text-align: center;
                font-family: inherit;
            }

            #screen_header{
                font-size:  2em;
                margin-top: 0px !important;
                /*color:#286090;*/
                color: #f7f7f7;
                /*margin-top: 15px !important;*/
                /*float:left;*/
            }
            #site_logo{
                width: 250px;
                padding: 5px 15px;
                height: 70px;
                margin-top: 10px;
            }
            .sidebar{
                width: 250px !important;
                font-size: medium;
            }
            #dash_view_name{
                font-size: 2.5em;
                letter-spacing: 1px;
            }
            #dash_view_position{
                color: white;
                text-transform: uppercase;
                font-size: 1.8em;
            }

            #dash_view_rtype{
                color: white;
                /*text-transform: uppercase;*/
                font-size: 2em;
            }
            .dash_view_timer{
                font-size:1.4em;
                background-color: black;
            }
            .dash_timer_counter{
                font-size: 1.5em;
            }
            .thumb-rounded-cust {
                margin: 10px auto 10px;
                min-height: 250px !important;
                max-height: 250px !important;
                overflow: hidden;
                min-width: 250px !important;
                max-width: 250px !important;
            }

            .event-status-heading-end{
                /*background-color: #94241c;*/
                color: #ffffff;
                font-size: 60px !important;
                padding: 20px;
                height: 20%;
                text-align: center;
                font-family: inherit;
            }

            .event-status-heading{
                /*background-color: #27882b;*/
                color: #ffffff;
                font-size: 60px !important;
                padding: 20px;
                height: 20%;
                text-align: center;
                font-family: inherit;
            }

            .event-pf-heading{
                background-color: #f9f9f9;
                font-size: 60px !important;
                padding: 20px;
                text-align: center;
                height: 20%;
                font-family: inherit;
            }

            .event-pn-heading{
                font-size: 50px !important;
                padding: 20px;
                text-align: center;
                height: 20%;
                font-family: inherit;
            }

            .event-timer , .event-timer-val{
                font-size: 120px !important;
                padding: 20px;
                height: 40%;
                text-align: center;
                font-family: inherit;
            }
            .e_progress .circle .label {
                display: inline-block;
                width: 100px !important;
                height: 100px !important;
                border-radius: 80px !important;
                color: #b5b5ba;
                font-size: 60px !important;
            }

        }



    </style>
    <style>
        .header {
            overflow: initial;
            background-color: #060818;
            padding: 18px 25px;
        }

        .header a {
            /*float: left;*/
            color: #fff5f5;
            /*text-align: center;*/
            padding: 2px;
            text-decoration: none;
            font-size: 14px;
            line-height: 25px;
            border-radius: 4px;
        }

        .header a.logo {
            font-size: 25px;
            font-weight: bold;
        }

        /*.header a:hover {*/
        /*    background-color: #ddd;*/
        /*    color: black;*/
        /*}*/

        .header a.active {
            background-color: dodgerblue;
            color: white;
        }

        .header-right {
            float: right;
        }

        @media screen and (max-width: 500px) {
            .header a {
                float: none;
                display: block;
                text-align: left;
            }

            .header-right {
                float: right;
                margin-top: -28px;
            }
            .logo_img {
                height: auto;
                width: 80px!important;
            }
            img.dropbtn_img {
                height: auto;
                width: 25px!important;
                border-radius: 4px;

            }
            .dropbtn{
                font-size: 12px!important;
            }
            svg.arrow.dropbtn {
                margin-left: 94px!important;
                margin-top: -18px!important;
            }

        }
        .dropbtn {
            background-color: #060818;
            color: white;
            /*padding: 16px;*/
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        /*.dropbtn:hover, .dropbtn:focus {*/
        /*    background-color: #2980B9;*/
        /*}*/

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: fixed;
            background-color: #191e3a;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 9999;
            border-radius: 6px;
        }

        .dropdown-content a {
            color: #fff5f5;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #524d4d;
        }
        .logo_img{
            height: auto;
            width: 150px;
        }
        img.dropbtn_img {
            height: auto;
            width: 28px!important;
            border-radius: 4px;
        }
        #screen_header {
            color: #f7f7f7;
            margin-top: -38px;
            /* font-size: 1em; */
            /* margin-top: 30px !important; */
        }
        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {
            .logo_img{
                height: auto;
                width: 120px;
                margin-top: -12px;
            }
            .content_noheader {
                padding: 50px 30px !important;
            }
            #screen_header{
                margin-top: -32px;
            }

        }


        /*.dropdown a:hover {background-color: #ddd;}*/

        .show {display: block;}
    </style>
</head>
<body>
<?php
$path = '';
if(!empty($is_cell_login) && $is_cell_login == 1){
    $path = $siteURL. "cell_line_dashboard.php";
}else{
    if(!empty($i) && ($is_tab_login != null)){
        $path = "../line_tab_dashboard.php";
    }else{
        $path = $siteURL . "line_status_grp_dashboard.php";
    }
}


$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$assign_line' ");
while ($rowctemp = mysqli_fetch_array($qurtemp)) {
    $linename = $rowctemp["line_name"];
}


$cam_page_header = $linename . "- Status Overview";
?>
<div class="header">

    <a class="logo">
        <img class = "logo_img" src="<?php $siteURL ?>assets/img/SGG_logo.png" alt="logo">
    </a>

    <h3 class="navbar-center" id="screen_header" style=""><span class="text-semibold"><?php echo $cam_page_header; ?></span></h3>


</div>


<!--  END NAVBAR  -->
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>
    </div>
    <!-- END MAIN CONTAINER -->
    <!--  BEGIN CONTENT PART  -->
    <!--    <div id="content" class="main-content">-->
    <!--        <div class="layout-px-spacing">-->
    <!--            <div class="page-header">-->
    <!--                <nav class="breadcrumb-one" aria-label="breadcrumb">-->
    <!--                    <ol class="breadcrumb">-->
    <!--                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboad</a></li>-->
    <!--                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Analytics</a></li>-->
    <!--                    </ol>-->
    <!--                </nav>-->
    <!--                <div class="dropdown filter custom-dropdown-icon">-->
    <!--                    <a class="dropdown-toggle btn" href="#" role="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text"><span>Show</span> : Daily Analytics</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>-->
    <!---->
    <!--                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">-->
    <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Daily Analytics" href="javascript:void(0);">Daily Analytics</a>-->
    <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Weekly Analytics" href="javascript:void(0);">Weekly Analytics</a>-->
    <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Monthly Analytics" href="javascript:void(0);">Monthly Analytics</a>-->
    <!--                        <a class="dropdown-item" data-value="Download All" href="javascript:void(0);">Download All</a>-->
    <!--                        <a class="dropdown-item" data-value="Share Statistics" href="javascript:void(0);">Share Statistics</a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
</div>
<?php
$countervariable = 0;
$qurtemp = mysqli_query($db, "SELECT max(e_log.station_event_id) as s_e_id FROM sg_station_event_log as e_log , sg_station_event as sg_events  where sg_events.event_status = 1 and sg_events.line_id = '$assign_line' group by sg_events.line_id");
$seq = ($qurtemp->fetch_assoc())['s_e_id'];
/* If the Event for the station is up and running*/
if ($seq != "") {
	$query = "SELECT sg_events.reason as reason , pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,pf.pm_part_family_id as pf_id, et.event_type_name as e_name , et.color_code as color_code , e_log.created_on as e_start_time FROM sg_station_event_log as e_log Inner Join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id inner join event_type as et on e_log.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where e_log.event_status=1 and sg_events.line_id= '$assign_line' ORDER by e_log.station_event_log_id DESC LIMIT 1";
	$qurtemp = mysqli_query($db, $query);
	$e_name = '';
	$p_num = '';
	$p_name = '';
	$pf_name = '';
	$reason = '';
	$time = '';
	$status_color = '';
	while ($resultado = mysqli_fetch_array($qurtemp)) {
		$reason = $resultado["reason"];;
		$e_name = $resultado["e_name"];;
		$p_num = $resultado["p_num"];;
		$p_name = $resultado["p_name"];;
		$pf_name = $resultado["pf_name"];;
		$pf_id = $resultado["pf_id"];;
		$time = $resultado["e_start_time"];;
		$status_color = $resultado["color_code"];;
	}

	$qurtemp_mq = mysqli_query($db, "SELECT * FROM sg_station_event_log as e_log Inner Join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id inner join event_type as et on e_log.event_type_id=et.event_type_id where e_log.event_status=1 and sg_events.station_event_id='$seq' ORDER by e_log.station_event_log_id ASC");
	$sql = "select logo from part_family_account_relation as pfar inner join cus_account as ca on pfar.account_id=ca.c_id where pfar.part_family_id ='$pf_id'";
	$qurtemp_c_logo = mysqli_query($db, $sql);
	$sql = "select part_images from pm_part_number as pimgs  where pimgs.part_number ='$p_num' and pimgs.part_name = '$p_name' and pimgs.part_family = '$pf_id' and is_deleted = 0 ";
	$qurtemp1 = mysqli_query($db, $sql);
	$logo_path = $siteURL . 'supplier_logo/';
	$pimage_path = $siteURL . 'assets/images/part_images/';

	?>
    <!-- Page container if the Line Events are Active and up -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            <!-- Main content -->
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Page header
				</page header -->
                <!-- Content area -->
                <div class="content_noheader">
                    <div class="row h-80">
<!--                        <div class="col-lg-4 cell1">-->
<!--                            <table class="table" align="center" id="tblMain" hidden>-->
<!--                                <tr>-->
<!---->
<!--                                    <td><span name="current" class="label label-success"-->
<!--                                              data-value=" --><?php //echo $e_name; ?><!--"><b>--><?php //echo $e_name; ?><!--<b></span>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </table>-->
<!--                            <div class="e_progress">-->
<!--                                <div class="circle">-->
<!--                                    <span class="label">0</span>-->
<!--                                    <span class="title">Start</span>-->
<!--                                </div>-->
<!--                                <span class="bar"></span>-->
<!--								--><?php
//								$count = 0;
//								while ($resultado = mysqli_fetch_array($qurtemp)) {
//									$count = $count + 1;
//									$event_type_name = $resultado["event_type_name"];
//									?>
<!--                                    <div class="circle">-->
<!--                                        <span class="label">--><?php //echo $count; ?><!--</span>-->
<!--                                        <span class="title">--><?php //echo $event_type_name; ?><!--</span>-->
<!--                                    </div>-->
<!--                                    <span class="bar"></span>-->
<!--									--><?php
//								}
//								?>
<!---->
<!--                                <div class="circle">-->
<!--                                    <span class="label">--><?php //echo $count + 1; ?><!--</span>-->
<!--                                    <span class="title">End</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col-lg-4 cell1">
                            <table class="table" align="center" id="tblMain" >
                                <tr style="background-color: #8BC34A">
                                    <td style="text-align: center; font-size: large"><span><b>Customer</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id = "cust_eve_status">
											<?php
											$resultado = mysqli_fetch_array($qurtemp_c_logo);
											if((null != $resultado) && ('' != $resultado)){
												$logo_name = $resultado["logo"];
												$logo_p = $logo_path . $logo_name;
												?>
                                                <img src = "<?php echo $logo_p?>" />
												<?php
											}else{
												?>
                                                <img src = "<?php echo $siteURL . 'assets/images/No_Img_available.png'?>" />
												<?php
                                            }

											?>

                                        </div>
                                    </td>
                                </tr>
                                <tr style="background-color: #8BC34A">
                                    <td style="text-align: center; font-size: large"><span><b>Part Image(s)</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id = "eve_part_img">

<!--                                                <div>-->
<!--                                                    Part Image(s)-->
<!--                                                </div>-->

												<?php
												$resultado1 = mysqli_fetch_array($qurtemp1)['part_images'];
												if(isset($resultado1)){
													$resultado2 = preg_split ("/,/", $resultado1);
													if(sizeof($resultado2) > 1){
													    ?>
                                                        <div id="slideshow">
                                                        <?php
														foreach ($resultado2 as $img_path){
															$pimg_path = $pimage_path.$img_path;
															?>
                                                            <div><img src = "<?php echo htmlspecialchars($pimg_path)?>" /></div>
															<?php
														}
														?>
                                                            </div>
                                                        <?php
                                                    }else{
														$pimg_path = $pimage_path.$resultado2[0];
														?>
                                                        <img src = "<?php echo $pimg_path?>" />
														<?php
                                                    }

                                                }else{
													?>
                                                    <img src = "<?php echo $siteURL . 'assets/images/No_Img_available.png'?>" />
													<?php
                                                }
												?>
                                                <!--                                                <img src = "--><?php //echo $logo_path?><!--" />-->
                                                <!--                                                <div>-->
                                                <!--                                                    <img src="//farm6.static.flickr.com/5224/5658667829_2bb7d42a9c_m.jpg">-->
                                                <!--                                                </div>-->
                                                <!--                                                <div>-->
                                                <!--                                                    <img src="//farm6.static.flickr.com/5230/5638093881_a791e4f819_m.jpg">-->
                                                <!--                                                </div>-->

                                        </div>
                                    </td>
                                </tr>
                            </table>


                        </div>
                        <div class="col-lg-8 cell2" style="background-color: #fff; padding: 0px;">
                            <div class="event-status-heading ver_align" style="background-color:<?php echo $status_color; ?>;"><?php echo $e_name ?></div>
                            <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $time; ?>">
<!--                            <div class="event-reason ver_align">--><?php //echo $reason ?><!--</div>-->
<!--                            <div class="event-timer ver_align">-->
							<?php if(!empty($reason)) { ?>
                                    <div class="event-reason ver_align"><?php echo $reason ?></div>
                                    <div class="event-timer ver_align">
								<?php }else{ ?>
                                    <div class="event-timer ver_align" style="height: 40% !important;">
								<?php } ?>

                                <h4 style="text-align: center;">
                                    <div class="event-timer-val" id="demo<?php echo $countervariable; ?>">&nbsp;</div>
                                </h4>
								<?php
								$variable123 = $time;
								if ($variable123 != "") {
                                    //include the timing configuration file
                                    include("timings_config.php");
									?>


								<?php } ?>
                                <div id="server-load"></div>
                            </div>
                            <div class="event-pf-heading ver_align"><?php echo $pf_name ?></div>
                            <div class="event-pn-heading ver_align"><?php echo $p_num . ' - ' . $p_name ?></div>
                        </div>
                    </div>
                    <div class="row h-20" style="background-color: rgba(4,55,139,0.92); font-size: xx-large; color: #ffffff ;padding: 15px 0px 20px 0px; margin-top:10px;">
						<?php
						$count = 0;
						$mq_text = "Step 0 : Start  ";
						while ($resultado = mysqli_fetch_array($qurtemp_mq)) {
							$count = $count + 1;
							$event_type_name = $resultado["event_type_name"];
							$mq_text .= "   -->    Step " . $count . " : " . $event_type_name . "  ";
						}?>

                        <marquee behavior="scroll" direction="left" scrollamount="10"><?php echo  $mq_text?></marquee>
                    </div>

                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
    <!-- /page container -->
<?php } else {
	/*End of Production Logic Start*/
	$countervariable = 0;
	$qurtemp = mysqli_query($db, "SELECT max(e_log.station_event_id) as s_e_id FROM sg_station_event_log as e_log inner join sg_station_event as sg_events on e_log.station_event_id=sg_events.station_event_id  where sg_events.event_status = 0 and sg_events.line_id = '$assign_line' group by sg_events.line_id");
	$seq = ($qurtemp->fetch_assoc())['s_e_id'];
	if ($seq != "") {
		$query = "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name, et.event_type_name as e_name ,et.color_code as color_code , e_log.created_on as e_start_time FROM sg_station_event_log as e_log Inner Join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id inner join event_type as et on e_log.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where e_log.event_status=0 and e_log.station_event_id= '$seq' ORDER by e_log.station_event_log_id DESC LIMIT 1";
		$qurtemp = mysqli_query($db, $query);
		$e_name = '';
		$p_num = '';
		$p_name = '';
		$pf_name = '';
		$status_color = '';
		$time = '';
		while ($resultado = mysqli_fetch_array($qurtemp)) {
			$e_name = $resultado["e_name"];
			$p_num = $resultado["p_num"];
			$p_name = $resultado["p_name"];
			$pf_name = $resultado["pf_name"];
			$time = $resultado["e_start_time"];
			$status_color = $resultado["color_code"];
		}
		?>
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Page header
					</page header -->
                    <!-- Content area -->
                    <div class="content_noheader" >
                        <div class="row h-100">
                            <div class="event-status-heading-end ver_align" style="background-color:<?php echo $status_color; ?>;"><?php echo $e_name ?></div>
                            <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $time; ?>">
                            <div class="event-timer ver_align">
                                <h4 style="text-align: center;">
                                    <div class="event-timer-val" id="demo<?php echo $countervariable; ?>">&nbsp;</div>
                                </h4>
								<?php
								$variable123 = $time;
								if ($variable123 != "") {
                                    //include the timing configuration file
                                    include("timings_config.php");
									?>
                                 <!--   <script>

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
                                <div id="server-load"></div>
                            </div>
                            <div class="event-pf-heading ver_align"><?php echo $pf_name ?></div>
                            <div class="event-pn-heading ver_align"><?php echo $p_num . ' - ' . $p_name ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
		<?php
	} else {
		/* No Record Found Logic*/
		?>
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Page header
					</page header -->
                    <!-- Content area -->
                    <div class="content_noheader" >
                        <div class="row h-100">
                            <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $time; ?>">
                            <div class="event-timer ver_align">
                                <h4 style="text-align: center;">
                                    <div class="event-timer-val" id="demo<?php echo $countervariable; ?>">No Records
                                        Found
                                    </div>
                                </h4>
                                <div id="server-load"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /main content -->
                <!--        <div class="panel panel-flat panel-full-height padding_top_50px">-->
                <!--            <div class="panel-heading">-->
                <!---->
                <!--                -->
                <!--            </div>-->
                <!--        </div>-->
            </div>
            <!-- /page content -->
        </div>

		<?php
	}

} ?>

<script>
    $("#slideshow > div:gt(0)").hide();

    setInterval(function() {
        $('#slideshow > div:first')
            .fadeOut(3000)
            .next()
            .fadeIn(3000)
            .end()
            .appendTo('#slideshow');
    }, 5000);

    setTimeout(function () {
        //alert("reload");
        location.reload();
    }, 20000);
</script>
      <?php  include("footer.php"); ?> <!-- /page container -->
</body>
</html>