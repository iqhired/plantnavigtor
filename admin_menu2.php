<?php
include("../config.php");
$available_var = $_SESSION['available'];
$taskvar = $_SESSION['taskavailable'];
$is_cust_dash = $_SESSION['is_cust_dash'];
$line_cust_dash = $_SESSION['line_cust_dash'];
$tab_line = $_SESSION['tab_station'];
$is_tab_login = $_SESSION['is_tab_user'];
$tm_task_id = "";
$iid = $_SESSION["id"];

$cell_id = $_SESSION['cell_id'];
$is_cell_login = $_SESSION['is_cell_login'];
if (isset($cell_id) && '' != $cell_id) {
	$sql1 = "SELECT stations FROM `cell_grp` where c_id = '$cell_id'";
	$result1 = $mysqli->query($sql1);
	while ($row1 = $result1->fetch_assoc()) {
		$c_login_stations = $row1['stations'];
	}
	if (isset($c_login_stations) && '' != $c_login_stations) {
		$c_login_stations_arr = array_filter(explode(',', $c_login_stations));
	}
}

$sql1 = "SELECT * FROM `tm_task` where assign_to = '$iid' and status='1'";
$result1 = $mysqli->query($sql1);
while ($row1 = $result1->fetch_assoc()) {
	$tm_task_id = $row1['tm_task_id'];
}
?>

<?php
$path = '';
if (!empty($is_cell_login) && $is_cell_login == 1) {
	$path = $siteURL . "cell_line_dashboard.php";
} else {
	if (!empty($i) && ($is_tab_login != null)) {
		$path = "../line_tab_dashboard.php";
	} else {
		$path = $siteURL . "line_status_grp_dashboard.php";
	}
}
?>
<!---->
<!--  END NAVBAR  -->
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN NAVBAR  -->
    <div class="header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="#" class="sidebarCollapse" data-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>

            <div class="nav-logo align-self-center">
                <a class="navbar-brand" href="<?php echo $path ?>">
                    <img alt="logo" src="<?php echo $siteURL; ?>assets/img/SGG_logo.png">
                </a>
            </div>


<!--             <ul class="navbar-item flex-row mr-auto">-->
<!--                <li class="nav-item align-self-center search-animated">-->
<!--                    <form class="form-inline search-full form-inline search" role="search">-->
<!--                        <div class="search-bar">-->
<!--                            <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">-->
<!--                        </div>-->
<!--                    </form>-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>-->
<!--                </li>-->
<!--            </ul>-->


            <ul class="navbar-item flex-row nav-dropdowns">


                <!--                <li class="nav-item dropdown message-dropdown">-->
                <!---->
                <!--                    <div class="dropdown-menu p-0 position-absolute" aria-labelledby="messageDropdown">-->
                <!--                        <div class="">-->
                <!--                            <a class="dropdown-item">-->
                <!--                                <div class="">-->
                <!---->
                <!--                                    <div class="media">-->
                <!--                                        <div class="user-img">-->
                <!--                                            <div class="avatar avatar-xl">-->
                <!--                                                <span class="avatar-title rounded-circle">KY</span>-->
                <!--                                            </div>-->
                <!--                                        </div>-->
                <!--                                        <div class="media-body">-->
                <!--                                            <div class="">-->
                <!--                                                <h5 class="usr-name">Kara Young</h5>-->
                <!--                                                <p class="msg-title">ACCOUNT UPDATE</p>-->
                <!--                                            </div>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!---->
                <!--                                </div>-->
                <!--                            </a>-->
                <!--                            <a class="dropdown-item">-->
                <!--                                <div class="">-->
                <!--                                    <div class="media">-->
                <!--                                        <div class="user-img">-->
                <!--                                            <div class="avatar avatar-xl">-->
                <!--                                                <span class="avatar-title rounded-circle">DA</span>-->
                <!--                                            </div>-->
                <!--                                        </div>-->
                <!--                                        <div class="media-body">-->
                <!--                                            <div class="">-->
                <!--                                                <h5 class="usr-name">Daisy Anderson</h5>-->
                <!--                                                <p class="msg-title">ACCOUNT UPDATE</p>-->
                <!--                                            </div>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </a>-->
                <!--                            <a class="dropdown-item">-->
                <!--                                <div class="">-->
                <!---->
                <!--                                    <div class="media">-->
                <!--                                        <div class="user-img">-->
                <!--                                            <div class="avatar avatar-xl">-->
                <!--                                                <span class="avatar-title rounded-circle">OG</span>-->
                <!--                                            </div>-->
                <!--                                        </div>-->
                <!--                                        <div class="media-body">-->
                <!--                                            <div class="">-->
                <!--                                                <h5 class="usr-name">Oscar Garner</h5>-->
                <!--                                                <p class="msg-title">ACCOUNT UPDATE</p>-->
                <!--                                            </div>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!---->
                <!--                                </div>-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </li>-->

                <nav id="topbar">
                    <ul class="navbar-nav theme-brand flex-row  text-center">
                        <li class="nav-item theme-logo">
                            <a href="<?php echo $path ?>">
                                <img src="<?php echo $siteURL; ?>assets/img/SGG_logo.png" class="navbar-logo"
                                     alt="logo">
                            </a>
                        </li>

                    </ul>
                </nav>

                <li class="nav-item dropdown notification-dropdown">

                    <span><h2 style="width: max-content;"><?php echo $cam_page_header; ?></h2></span>

                </li>

				<?php
				$loginid = $_SESSION["id"];
				$sidebar_user_id = $_SESSION['session_user'];
				/*$query10 = sprintf("SELECT DISTINCT `sender`,`receiver` FROM sg_chatbox where sender = '$loginid' OR receiver = '$sidebar_user_id' ORDER BY createdat DESC ;  ");*/
				$query_not = sprintf("SELECT DISTINCT sg_chatbox.`sg_chatbox_id`,sg_chatbox.`message`,sg_chatbox.`createdat`,sg_chatbox.`sender`,cam_users.`user_name`,cam_users.`users_id`,cam_users.`profile_pic` FROM sg_chatbox INNER JOIN cam_users ON sg_chatbox.`sender`= cam_users.`users_id` WHERE `sender` !=$loginid AND `flag`=$loginid ");
				$qur_not = mysqli_query($db, $query_not); ?>


                <li class="nav-item dropdown notification-dropdown mobile">
                    <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </a>
					<?php
					while ($rowc_not = mysqli_fetch_array($qur_not)) {
						$name = $rowc_not["user_name"];
						$us_id = $rowc_not["users_id"];
						$se_id = $rowc_not["sender"];
						$id = $rowc_not["sg_chatbox_id"];
						$msg = $rowc_not["message"];
						$date = $rowc_not["createdat"]; ?>
                        <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                            <div class="notification-scroll">
                                <div class="dropdown-item">
                                    <div class="media server-log">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-server">
                                            <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                            <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                            <line x1="6" y1="6" x2="6" y2="6"></line>
                                            <line x1="6" y1="18" x2="6" y2="18"></line>
                                        </svg>
                                        <div class="media-body">
                                            <div class="data-info">
                                                <a href="#" data-toggle="tab" data-id="<?php echo $se_id; ?>"
                                                   value="<?php echo $id; ?>" class="use1_namelist">
                                                    <h6 class=""><?php echo $name; ?> · <?php echo $date; ?>day ago</h6>
                                                    <p class=""><?php echo $msg; ?></p>
                                                    <input type="hidden" id="not_id" name="id"
                                                           value="<?php echo $id; ?>">
                                                    <input type="hidden" id="login_id" name="login_id"
                                                           value="<?php echo $loginid; ?>">
                                            </div>

                                            <div class="icon-status">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-x">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php } ?>
                </li>

                <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                    <a href="#" class="nav-link dropdown-toggle user" id="user-profile-dropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-body align-self-center">
                                <h6><?php echo $_SESSION['fullname']; ?></h6>
                                <!--   <p>Manager</p> -->
                            </div>
                            <img src="<?php echo $siteURL; ?>user_images/<?php echo $_SESSION["uu_img"]; ?>" alt="">

                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto slack">
                                <!--    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slack"><path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"></path><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"></path><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"></path><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"></path><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"></path><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"></path><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"></path></svg>-->
								<?php if ($is_cust_dash == 0) {
									$select = "";
								} else {
									$select = "checked='checked'";
								}
								if (isset($line_cust_dash)) { ?>
                                    <div class="media-body">
                                        <label class="checkbox-switchery switchery-xs">
                                            <input type="checkbox"
                                                   class="switchery custom_switch_db" <?php echo $select; ?>
                                                   style="margin-left: -4px;">
                                            <h5 style="width: 136px;">Custom Dashboard</h5></label>

                                    </div>
								<?php }
								if ($available_var == "0") {
									$select = "";
								} else {
									$select = "checked='checked'";
								}
								if ($taskvar != "") { ?>
                                    <div class="media-body">
										<?php if ($tm_task_id == "") { ?>
                                            <label class="checkbox-switchery switchery-xs ">
                                                <input type="checkbox"
                                                       class="switchery custom_switch" <?php echo $select; ?>
                                                       style="margin-left: -4px;">
                                                <h5 style="width: 136px;margin-left: -11px;">Available</h5></label>
										<?php } else { ?>
                                            <label class="checkbox-switchery switchery-xs ">
                                                <input type="checkbox"
                                                       class="switchery custom_switch" <?php echo $select; ?> disabled>
                                                <h5 style="width: 136px;margin-left: -11px;">Available</h5></label>
										<?php } ?>
                                    </div>
								<?php } ?>
                            </div>

                        </div>

                        <div class="dropdown-item">
                            <a href="<?php echo $siteURL; ?>profile.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-user" style="display: inline">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span> Profile</span>
                            </a>
                        </div>

                        <div class="dropdown-item">
                            <a href="<?php echo $siteURL; ?>change_pass.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-lock" style="display: inline">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span>Change Password</span>
                            </a>
                        </div>
						<?php if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) { ?>
                            <div class="dropdown-item">
                                <a href="<?php echo $siteURL; ?>tab_logout.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-log-out"
                                         style="display: inline">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    <span>Log Out</span>
                                </a>
                            </div>
						<?php } else { ?>
                            <div class="dropdown-item">
                                <a href="<?php echo $siteURL; ?>logout.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-log-out"
                                         style="display: inline">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    <span>Log Out</span>
                                </a>
                            </div>
						<?php } ?>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN TOPBAR  -->
        <div class="topbar-nav header navbar" role="banner">
            <nav id="topbar">
                <ul class="navbar-nav theme-brand flex-row  text-center">
                    <li class="nav-item theme-logo">
                        <a href="<?php echo $path ?>">
                            <img src="<?php echo $siteURL; ?>assets/img/SGG_logo.png" class="navbar-logo" alt="logo">
                        </a>
                    </li>

                </ul>
                <ul class="list-unstyled menu-categories " id="topAccordion">
                    <li class="menu single-menu mobile">
                        <a href="#" class="nav-link dropdown-toggle user" id="user-profile-dropdown"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media">
                                <img src="<?php echo $siteURL; ?>user_images/<?php echo $_SESSION["uu_img"]; ?>" alt="">
                                <div class="media-body align-self-center">
                                    <h6 class="tab"><?php echo $_SESSION['fullname']; ?></h6>
                                    <!--   <p>Manager</p> -->
                                </div>


                            </div>
                        </a>

                    </li>
					<?php
					$msg = $_SESSION["side_menu"];
					$msg = explode(',', $msg);
                    if (in_array('67', $msg)) { ?>
                    <li class="menu single-menu active">
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="true"
                           class="dropdown-toggle autodroprown">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <!--                                Boards-->
                                <span>Boards</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="dashboard" data-parent="#topAccordion">
                            <li class="active">
								<?php if (in_array('68', $msg)) { ?>
                            <li class="sub-sub-submenu-list">
                                <a href="#appInvoice" data-toggle="collapse" aria-expanded="false"
                                   class="dropdown-toggle"> Dashboard
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                                <ul class="collapse list-unstyled sub-submenu" id="appInvoice" data-parent="#app">
                                    <li>
                                        <a href="<?php echo $siteURL; ?>line_status_grp_dashboard.php"> Cell
                                            Overview </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>dashboard.php"> Crew Status Overview </a>
                                    </li>
                                </ul>
                            </li>
							<?php } ?>
                            </li>
							<?php if (in_array('69', $msg)) { ?>
                            <li class="sub-sub-submenu-list">
                                <a href="#appInvoice1" data-toggle="collapse" aria-expanded="false"
                                   class="dropdown-toggle"> GBP Dashboard
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                                <ul class="collapse list-unstyled sub-submenu" id="appInvoice1" data-parent="#app">
									<?php
									$sql1 = "SELECT * FROM `cam_line` WHERE gbd_id = '1'";
									$result1 = $mysqli->query($sql1);

									while ($row1 = mysqli_fetch_array($result1)) {

										$gbd_id = $row1['gbd_id'];
										$line_name = $row1['line_name'];
										$line_id = $row1['line_id'];
										if ($gbd_id == 1) { ?>
                                            <li>
                                                <a target="_blank"
                                                   href="<?php echo $siteURL; ?>config_module/gbp_dashboard.php?id=<?php echo $line_id ?>"
                                                   target="_blank"> <?php echo $line_name ?> </a>
                                            </li>

										<?php } else {

										}
									} ?>

                                </ul>
                            </li>
							<?php } ?>
							<?php if (in_array('70', $msg)) { ?>
                                <li class="sub-sub-submenu-list">
                                    <a href="#appInvoice2" data-toggle="collapse" aria-expanded="false"
                                       class="dropdown-toggle"> Custom Dashboard
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round" class="feather feather-chevron-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </a>
                                    <ul class="collapse list-unstyled sub-submenu" id="appInvoice2" data-parent="#app">
                                      <?php  $query = sprintf("SELECT * FROM sg_cust_dashboard where enabled = 1");
                                        $qur = mysqli_query($db, $query);

                                        while ($rowc = mysqli_fetch_array($qur)) {
                                        $c_id = $rowc["sg_cust_group_id"];
                                        $c_name = $rowc["sg_cust_dash_name"];
                                        $enabled = $rowc["enabled"];

											if ($enabled == 1) { ?>
                                                <li>
                                                    <a target="_blank"
                                                       href="<?php echo $siteURL; ?>config_module/sg_cust_dashboard.php?id=<?php echo $c_id ?>"
                                                       target="_blank"> <?php echo $c_name ?> </a>
                                                </li>

											<?php }
										} ?>

                                    </ul>
                                </li>
							<?php } ?>
							<?php if (in_array('4', $msg)) { ?>
                                <li class="sub-sub-submenu-list">
                                    <a href="#appInvoice3" data-toggle="collapse" aria-expanded="false"
                                       class="dropdown-toggle"> Taskboard
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round" class="feather feather-chevron-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </a>
                                    <ul class="collapse list-unstyled sub-submenu" id="appInvoice3" data-parent="#app">
										<?php
										if (in_array('9', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>taskboard_module/taskboard.php">
                                                    Taskboard </a>
                                            </li>
										<?php }
										if (in_array('11', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>taskboard_module/create_taskboard.php">
                                                    Create Taskboard </a>
                                            </li>
										<?php }
										if (in_array('12', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>taskboard_module/create_task.php">
                                                    Create/Edit Task </a>
                                            </li>
										<?php }
										?>

                                    </ul>
                                </li>
							<?php }
							?>
                        </ul>
                    </li>
					<?php } ?>
                    <!-- Forms Menu -->
					<?php if (in_array('23', $msg)) {
						?>
                        <li class="menu single-menu">
                            <a href="#app" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-cpu">
                                        <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                                        <rect x="9" y="9" width="6" height="6"></rect>
                                        <line x1="9" y1="1" x2="9" y2="4"></line>
                                        <line x1="15" y1="1" x2="15" y2="4"></line>
                                        <line x1="9" y1="20" x2="9" y2="23"></line>
                                        <line x1="15" y1="20" x2="15" y2="23"></line>
                                        <line x1="20" y1="9" x2="23" y2="9"></line>
                                        <line x1="20" y1="14" x2="23" y2="14"></line>
                                        <line x1="1" y1="9" x2="4" y2="9"></line>
                                        <line x1="1" y1="14" x2="4" y2="14"></line>
                                    </svg>
                                    <span>Forms</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="app" data-parent="#topAccordion">
								<?php if (in_array('42', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/form_settings.php"> Add/Create
                                            Form </a>
                                    </li>
								<?php }
								if (in_array('50', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/edit_form_options.php"> Edit
                                            Form </a>
                                    </li>
								<?php }
								if (in_array('38', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/options.php"> Submit Form </a>
                                    </li>
								<?php }
								if (in_array('44', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/form_search.php">View Form</a>
                                    </li>
								<?php }
								if (in_array('60', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/forms_recycle_bin.php">Restore
                                            Form</a>
                                    </li>
								<?php } ?>
                            </ul>
                        </li>
					<?php } ?>
                    <!-- Station Events-->
					<?php if (in_array('45', $msg)) { ?>
                        <li class="menu single-menu">
                            <a href="#tables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-layout">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="3" y1="9" x2="21" y2="9"></line>
                                        <line x1="9" y1="21" x2="9" y2="9"></line>
                                    </svg>
                                    <span>Station Events</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>

                            <ul class="collapse submenu list-unstyled" id="tables" data-parent="#topAccordion">
								<?php if (in_array('46', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>events_module/station_events.php"> Add/Update
                                            Events </a>
                                    </li>
								<?php } ?>

                            </ul>
                        </li>
					<?php } ?>
                    <!-- Crew Assignment -->
					<?php if (in_array('7', $msg)) { ?>
                        <li class="menu single-menu">
                            <a href="<?php echo $siteURL; ?>assignment_module/assign_crew.php">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-box">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                    <span>Crew Assignment</span>
                                </div>
                            </a>
                        </li>
					<?php } ?>

                    <!-- Communicator -->
					<?php if (in_array('65', $msg)) { ?>
                        <li class="menu single-menu">
                            <a href="#uiKit" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-zap">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                    </svg>
                                    <span>Communicator</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="uiKit" data-parent="#topAccordion">
								<?php if (in_array('5', $msg)) { ?>
                                    <li><a href="<?php echo $siteURL; ?>group_mail_module.php"> Mail </a></li>
								<?php }
								if (in_array('6', $msg)) { ?>
                                    <li><a href="<?php echo $siteURL; ?>chatbot/chat.php"> Chat </a></li>
								<?php } ?>

                            </ul>
                        </li>
					<?php } ?>
                    <!--
                                        <li class="menu single-menu">
                                            <a href="#forms" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                                    <span>Order</span>
                                                </div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </a>
                                            <ul class="collapse submenu list-unstyled" id="forms"  data-parent="#topAccordion">
                                                <li>
                                                    <a href="form_bootstrap_basic.html"> Create Order </a>
                                                </li>
                                                <li>
                                                    <a href="form_input_group_basic.html"> Historical Order </a>
                                                </li>

                                            </ul>
                                        </li> -->
                    <!-- Admin Config -->
					<?php if (in_array('66', $msg)) { ?>
                        <li class="menu single-menu">
                            <a href="#page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-file">
                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                        <polyline points="13 2 13 9 20 9"></polyline>
                                    </svg>
                                    <span>Admin Config</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="page" data-parent="#topAccordion">

									<?php if (in_array('18', $msg)) { ?>
                                <li class="sub-sub-submenu-list">
                                    <a href="#user-register" data-toggle="collapse" aria-expanded="false"
                                       class="dropdown-toggle">Config
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round" class="feather feather-chevron-right">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </a>

                                    <ul class="collapse list-unstyled sub-submenu" id="user-register"
                                        data-parent="#page">
										<?php if (in_array('29', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/create_assets.php"> Assets
                                                    Config </a>
                                            </li>
										<?php }
										if (in_array('62', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/dashboard_config.php">
                                                    Cell Dashboard Config </a>
                                            </li>
										<?php }
										if (in_array('71', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/create_cust_dashboard.php">
                                                    Create Custom Dashboard </a>
                                            </li>
										<?php }
										if (in_array('56', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/accounts.php"> Customer
                                                    Accounts </a>
                                            </li>
										<?php }
										if (in_array('63', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/defect_group.php"> Defect
                                                    Group </a>
                                            </li>
										<?php }
										if (in_array('55', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/defect_list.php"> Defect
                                                    List </a>
                                            </li>
										<?php }
										if (in_array('52', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/event_category.php"> Event
                                                    category </a>
                                            </li>
										<?php }
										if (in_array('47', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/event_type.php"> Event
                                                    Type </a>
                                            </li>
										<?php }
										if (in_array('43', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/form_type.php"> Form
                                                    Type </a>
                                            </li>
										<?php }
										if (in_array('26', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/job_title.php"> Job
                                                    Title </a>
                                            </li>
										<?php }
										if (in_array('53', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/form_measurement_unit.php">
                                                    Measurement Unit </a>
                                            </li>
										<?php }
										if (in_array('27', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/shift_location.php">
                                                    Shift/Location </a>
                                            </li>
										<?php }
										if (in_array('24', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/line.php"> Station </a>
                                            </li>
										<?php }
										if (in_array('28', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/station_pos_rel.php">
                                                    Station Position Config</a>
                                            </li>
										<?php }
										if (in_array('25', $msg)) { ?>
                                            <li>
                                                <a href="<?php echo $siteURL; ?>config_module/position.php">
                                                    Position </a>
                                            </li>
										<?php } ?>

                                    </ul>
                                </li>
								<?php } ?>
                                <!-- Parts Config -->
								<?php if (in_array('20', $msg)) { ?>
                                    <li class="sub-sub-submenu-list">
                                        <a href="#user-passRecovery" data-toggle="collapse" aria-expanded="false"
                                           class="dropdown-toggle">Parts
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </a>
                                        <ul class="collapse list-unstyled sub-submenu" id="user-passRecovery"
                                            data-parent="#page">
											<?php if (in_array('34', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>part_module/part_number.php"><span>Part Number</span></a>
                                                </li>
											<?php }
											if (in_array('35', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>part_module/part_family.php"><span>Part Family</span></a>
                                                </li>
											<?php } ?>
                                        </ul>
                                    </li>
								<?php } ?>
                                <!-- Report Config -->
								<?php if (in_array('19', $msg)) { ?>
                                    <li class="sub-sub-submenu-list">
                                        <a href="#user-register" data-toggle="collapse" aria-expanded="false"
                                           class="dropdown-toggle"> Report Config
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </a>
                                        <ul class="collapse list-unstyled sub-submenu" id="user-register"
                                            data-parent="#page">
											<?php if (in_array('32', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>report_config_module/assignment_log_config.php">
                                                        Assignment Mail Config </a>
                                                </li>
											<?php }
											if (in_array('31', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>report_config_module/communicator_config.php">
                                                        Communicator Config </a>
                                                </li>
											<?php }
											if (in_array('33', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>report_config_module/task_log_config.php">
                                                        Task Log Config </a>
                                                </li>
											<?php }
											if (in_array('64', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>cronjobs/training_mail_config.php">
                                                        Training Completion Mail Config </a>
                                                </li>
											<?php } ?>

                                        </ul>

                                    </li>
								<?php } ?>
                                <!-- User Group Config-->
								<?php if (in_array('16', $msg)) { ?>
                                    <li class="sub-sub-submenu-list">
                                        <a href="<?php echo $siteURL; ?>group.php"> User Group(s) </a>
                                    </li>
								<?php } ?>
                                <!-- User Config-->
								<?php if (in_array('8', $msg)) { ?>
                                    <li class="sub-sub-submenu-list">
                                        <a href="#pages-error" data-toggle="collapse" aria-expanded="false"
                                           class="dropdown-toggle"> User Config
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </a>

                                        <ul class="collapse list-unstyled sub-submenu" id="pages-error"
                                            data-parent="#more">
											<?php if (in_array('13', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>user_module/users_list.php">
                                                        Add/Update
                                                        User </a>
                                                </li>
											<?php }
											if (in_array('14', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>user_module/role_list.php"> Add User
                                                        Role(s) </a>
                                                </li>
											<?php }
											if (in_array('61', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>user_module/user_custom_dashboard.php">
                                                        Custom Dashboard </a>
                                                </li>
											<?php }
											if (in_array('15', $msg)) { ?>
                                                <li>
                                                    <a href="<?php echo $siteURL; ?>user_module/user_ratings.php"> User
                                                        Station-Pos Ratings </a>
                                                </li>
											<?php } ?>
                                        </ul>

                                    </li>
								<?php } ?>

                            </ul>
                        </li>
					<?php } ?>
                    <!-- Logs -->
					<?php if (in_array('22', $msg)) { ?>
                        <li class="menu single-menu">
                            <a href="#more" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-plus-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                    <span>Logs</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>

                            <ul class="collapse submenu list-unstyled" id="more" data-parent="#topAccordion">
								<?php if (in_array('36', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>log_module/assign_crew_log.php"> Crew Assignment
                                            Log</a>
                                    </li>
								<?php }
//								if (in_array('37', $msg)) { ?>
<!--                                    <li>-->
<!--                                        <a href="--><?php //echo $siteURL; ?><!--log_module/chat_log.php"> Chat Log </a>-->
<!--                                    </li>-->
<!--								--><?php //}
								if (in_array('40', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>log_module/task_crew_log.php"> Task Crew Log</a>
                                    </li>
								<?php }
								if (in_array('51', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>log_module/station_events_log.php"> Station
                                            Events Log </a>
                                    </li>
								<?php }
								if (in_array('59', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>log_module/good_bad_pieces_log.php"> Good Bad
                                            Pieces Log </a>
                                    </li>
								<?php }
								if (in_array('21', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>table.php"> Training Matrix </a>
                                    </li>
								<?php } ?>
                            </ul>



                        </li>
					<?php } ?>

                    <!---- Profile ------>

                        <li class="menu single-menu mobile">
                            <a href="#profile" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <div class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-plus-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                    <span>Profile</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>

                            <ul class="collapse submenu list-unstyled mobile" id="profile" data-parent="#topAccordion">

                                    <li>
                                        <a href="<?php echo $siteURL; ?>profile.php"> Profile</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo $siteURL; ?>change_pass.php"> Change Password </a>
                                    </li>

                                    <li>
                                        <a href="<?php echo $siteURL; ?>logout.php">Log Out</a>
                                    </li>


                            </ul>



                        </li>

                </ul>
            </nav>
        </div>
        <!--  END TOPBAR  -->

        <!--  BEGIN CONTENT PART  -->
        <!--    <div id="content" class="main-content">-->
        <!--        <div class="layout-px-spacing">-->
        <!--            <div class="page-header">-->
        <!--                <nav class="breadcrumb-one" aria-label="breadcrumb">-->
        <!--                    <ol class="breadcrumb">-->
        <!--                        <li class="breadcrumb-item"><a href="#">Dashboad</a></li>-->
        <!--                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Analytics</a></li>-->
        <!--                    </ol>-->
        <!--                </nav>-->
        <!--                <div class="dropdown filter custom-dropdown-icon">-->
        <!--                    <a class="dropdown-toggle btn" href="#" role="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text"><span>Show</span> : Daily Analytics</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>-->
        <!---->
        <!--                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">-->
        <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Daily Analytics" href="#">Daily Analytics</a>-->
        <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Weekly Analytics" href="#">Weekly Analytics</a>-->
        <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Monthly Analytics" href="#">Monthly Analytics</a>-->
        <!--                        <a class="dropdown-item" data-value="Download All" href="#">Download All</a>-->
        <!--                        <a class="dropdown-item" data-value="Share Statistics" href="#">Share Statistics</a>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!---->
        <!--        </div>-->
        <!--    </div>-->
        <!--  END CONTENT PART  -->

    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script>
        $(document).on("click", ".custom_switch", function () {
            var available_var = '<?php echo $available_var; ?>';
            $.ajax({
                url: "available.php",
                type: "post",
                data: {available_var: available_var},
                success: function (response) {
                    //alert(response);
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });

        $(document).on("click", ".custom_switch_db", function () {
            var is_cust_dash = '<?php echo $is_cust_dash; ?>';
            $.ajax({
                url: "switch_cust_db.php",
                type: "post",
                data: {is_cust_dash: is_cust_dash},
                success: function (response) {
                    //alert(response);
                    console.log(response);
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        //redirect ti chat page

        $( ".use1_namelist" ).click(function( event ) {
            $(".chat-list").html(" ");
            var user_id = $(this).data("id");
            var chat_id = $(this).attr("value");
            //alert(chat_id);
            $.ajax({
                type : 'POST',
                url : 'chatbot/chat_div.php',
                data : {
                    user_id : user_id,
                    chat_id : chat_id,
                },
                success : function(data) {
                    window.setTimeout(function(){
                        window.location.href = "chatbot/chat.php";

                    }, 10);

                }
            });
        });

        //notification status checking
        var data_interval = setInterval(function() {
            var id =  $("#login_id").val();
            //alert(data);
            $.ajax({
                url:"chatbot/status_count.php",
                method:"POST",
                data:{id:id},
                dataType : 'json',
                encode   : true,
                success:function(res)

                {

                    if(res > 0){
                        //alert(res);
                        $("#bell_icon").css('color','red');
                        //$("#bell_icon").css('margin-top','0px');
                        $("#bell_count").text(res);

                    }else{

                    }

                }
            });
        }, 1000);
    </script>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo $siteURL; ?>bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $siteURL; ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $siteURL; ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $siteURL; ?>assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="<?php echo $siteURL; ?>assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo $siteURL; ?>assets/js/dashboard/dash_2.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
