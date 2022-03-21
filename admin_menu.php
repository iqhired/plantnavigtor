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
<head>

    <link href="<?php echo $siteURL; ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
    <style>
        .navbar-brand>img {
            margin-top: 14px!important;
            height: 40px!important;
        }
        .navbar-nav>li {
            margin-left: 20px!important;
            float: left;
        }
        .show {
            display: grid!important;
        }
        /*.navbar{*/
        /*    z-index: 0!important;*/
        /*}*/
    </style>
</head>
<body>
<?php
					$msg = $_SESSION["side_menu"];
					$msg = explode(',', $msg); ?>
<!-- Mobile navigation -->
<nav class="d-block d-sm-none position-sticky top-0 z-index">
    <div class="w-100 bg-white shadow-sm text-light">
        <div class="btn-group d-flex justify-content-between p-2" role="group">
            <div>
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>
            </div>


        </div>

    </div>
</nav>
<!-- Mobile navigation ends -->

<!-- Mobile navigation offcanvas menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-body">
        <?php  if (in_array('67', $msg)) { ?>
            <div class="mobile-toggle">
                <a data-bs-toggle="collapse" href="#collapseInteractive" role="button" aria-expanded="false" aria-controls="collapseInteractive">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="
                        float: left;">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></span><span class="ms-2 fw-light mobile">Boards</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>
                <?php if (in_array('67', $msg)) { ?>
                    <div class="collapse my-2" id="collapseInteractive">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a data-bs-toggle="collapse" href="#collapseInteractive1" role="button" aria-expanded="false" aria-controls="collapseInteractive1">
                                  Dashboard
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>
                                <?php if (in_array('68', $msg)) { ?>
                                    <div class="collapse my-2" id="collapseInteractive1">
                                        <div class="ms-4">
                                            <div class="mt-3">
                                                <a href="<?php echo $siteURL; ?>line_status_grp_dashboard.php" class="text-muted mobile">
                                                    Cell Overview
                                                </a>
                                            </div>
                                            <div class="mt-3">
                                                <a href="<?php echo $siteURL; ?>dashboard.php" class="text-muted mobile" >
                                                    Crew status Overview
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                <?php } ?>
                <?php if (in_array('69', $msg)) { ?>
                    <div class="collapse my-2" id="collapseInteractive">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a data-bs-toggle="collapse" href="#collapseInteractive2" role="button" aria-expanded="false" aria-controls="collapseInteractive2">
                                    GBP Dashboard
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>
                                <?php if (in_array('68', $msg)) { ?>
                                    <div class="collapse my-2" id="collapseInteractive2">
                                        <div class="ms-4">
                                            <?php
                                            $sql1 = "SELECT * FROM `cam_line` WHERE gbd_id = '1'";
                                            $result1 = $mysqli->query($sql1);

                                            while ($row1 = mysqli_fetch_array($result1)) {

                                                $gbd_id = $row1['gbd_id'];
                                                $line_name = $row1['line_name'];
                                                $line_id = $row1['line_id'];
                                                if ($gbd_id == 1) { ?>
                                                    <div class="mt-3">
                                                        <a target="_blank" href="<?php echo $siteURL; ?>config_module/gbp_dashboard.php?id=<?php echo $line_id ?>" class="text-muted mobile">
                                                            <?php echo $line_name ?>
                                                        </a>
                                                    </div>
                                                <?php } }  ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                <?php } ?>
                <?php if (in_array('70', $msg)) { ?>
                    <div class="collapse my-2" id="collapseInteractive">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a data-bs-toggle="collapse" href="#collapseInteractive3" role="button" aria-expanded="false" aria-controls="collapseInteractive3">
                                   Custom Dashboard
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>
                                <?php if (in_array('68', $msg)) { ?>
                                    <div class="collapse my-2" id="collapseInteractive3">
                                        <div class="ms-4">
                                            <?php  $query = sprintf("SELECT * FROM sg_cust_dashboard where enabled = 1");
                                            $qur = mysqli_query($db, $query);

                                            while ($rowc = mysqli_fetch_array($qur)) {
                                                $c_id = $rowc["sg_cust_group_id"];
                                                $c_name = $rowc["sg_cust_dash_name"];
                                                $enabled = $rowc["enabled"];

                                                if ($enabled == 1) { ?>
                                                    <div class="mt-3">
                                                        <a target="_blank"  href="<?php echo $siteURL; ?>config_module/sg_cust_dashboard.php?id=<?php echo $c_id ?>" class="text-muted mobile">
                                                            <?php echo $c_name ?>
                                                        </a>
                                                    </div>
                                                <?php } } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                <?php } ?>
                <?php if (in_array('4', $msg)) { ?>
                    <div class="collapse my-2" id="collapseInteractive">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a data-bs-toggle="collapse" href="#collapseInteractive4" role="button" aria-expanded="false" aria-controls="collapseInteractive4">
                                   Taskboard
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>
                                <?php if (in_array('68', $msg)) { ?>
                                    <div class="collapse my-2" id="collapseInteractive4">
                                        <div class="ms-4">
                                            <?php if (in_array('42', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>form_module/form_settings.php" class="text-muted mobile">
                                                        Add/Create Form
                                                    </a>
                                                </div>
                                            <?php } if (in_array('50', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>form_module/edit_form_options.php" class="text-muted mobile">
                                                        Edit Form
                                                    </a>
                                                </div>
                                            <?php } if (in_array('38', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>form_module/options.php" class="text-muted mobile">
                                                        Submit Form
                                                    </a>
                                                </div>
                                            <?php } if (in_array('44', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>form_module/form_search.php" class="text-muted mobile">
                                                        View Form
                                                    </a>
                                                </div>
                                            <?php } if (in_array('60', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>form_module/forms_recycle_bin.php" class="text-muted mobile">
                                                        Restore Form
                                                    </a>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
<!--      --><?php // if (in_array('67', $msg)) { ?>
<!--        <div class="mobile-toggle">-->
<!--            <a data-bs-toggle="collapse" href="#collapseInteractive" role="button" aria-expanded="false" aria-controls="collapseInteractive">-->
<!--                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="-->
<!--                        float: left;">-->
<!--                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
<!--                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
<!--                                </svg></span><span class="ms-2 fw-light mobile">Dashboard</span>-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
<!--                     class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>-->
<!--                </svg>-->
<!--            </a>-->
<!--            --><?php //if (in_array('68', $msg)) { ?>
<!--            <div class="collapse my-2" id="collapseInteractive">-->
<!--                <div class="ms-4">-->
<!--                    <div class="mt-3">-->
<!--                        <a href="--><?php //echo $siteURL; ?><!--line_status_grp_dashboard.php" class="text-muted mobile">-->
<!--                           Cell Overview-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="mt-3">-->
<!--                        <a href="--><?php //echo $siteURL; ?><!--dashboard.php" class="text-muted mobile" >-->
<!--                           Crew status Overview-->
<!--                        </a>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--            --><?php //} ?>
<!--        </div>-->
<!--      --><?php //} ?>
<!--        --><?php //if (in_array('69', $msg)) { ?>
<!--        <div class="mobile-toggle">-->
<!--            <a data-bs-toggle="collapse" href="#collapseInteractive1" role="button" aria-expanded="false" aria-controls="collapseInteractive1">-->
<!---->
<!--                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="-->
<!--    float: left;">-->
<!--                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
<!--                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
<!--                                </svg></span><span class="ms-2 fw-light">GBP Dashboard</span>-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
<!--                     class="arrow">   <polyline points="6 9 12 15 18 9"></polyline>-->
<!--                </svg>-->
<!--            </a>-->
<!--            <div class="collapse my-2" id="collapseInteractive1">-->
<!--                <div class="ms-4">-->
<!--                    --><?php
//                    $sql1 = "SELECT * FROM `cam_line` WHERE gbd_id = '1'";
//                    $result1 = $mysqli->query($sql1);
//
//                    while ($row1 = mysqli_fetch_array($result1)) {
//
//                        $gbd_id = $row1['gbd_id'];
//                        $line_name = $row1['line_name'];
//                        $line_id = $row1['line_id'];
//                    if ($gbd_id == 1) { ?>
<!--                    <div class="mt-3">-->
<!--                        <a target="_blank" href="--><?php //echo $siteURL; ?><!--config_module/gbp_dashboard.php?id=--><?php //echo $line_id ?><!--" class="text-muted mobile">-->
<!--                        --><?php //echo $line_name ?>
<!--                        </a>-->
<!--                    </div>-->
<!--                --><?php //} }  ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //} ?>
<!--        --><?php //if (in_array('70', $msg)) { ?>
<!--        <div class="mobile-toggle">-->
<!--            <a data-bs-toggle="collapse" href="#collapseInteractive2" role="button" aria-expanded="false" aria-controls="collapseInteractive2">-->
<!--                 <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="-->
<!--    float: left;">-->
<!--                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
<!--                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
<!--                                </svg></span><span class="ms-2 fw-light">Custom Dashboard</span>-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
<!--                     class="arrow">   <polyline points="6 9 12 15 18 9"></polyline>-->
<!--                </svg>-->
<!--            </a>-->
<!--            <div class="collapse my-2" id="collapseInteractive2">-->
<!--                <div class="ms-4">-->
<!--                    --><?php // $query = sprintf("SELECT * FROM sg_cust_dashboard where enabled = 1");
//                    $qur = mysqli_query($db, $query);
//
//                    while ($rowc = mysqli_fetch_array($qur)) {
//                    $c_id = $rowc["sg_cust_group_id"];
//                    $c_name = $rowc["sg_cust_dash_name"];
//                    $enabled = $rowc["enabled"];
//
//                    if ($enabled == 1) { ?>
<!--                    <div class="mt-3">-->
<!--                        <a target="_blank"  href="--><?php //echo $siteURL; ?><!--config_module/sg_cust_dashboard.php?id=--><?php //echo $c_id ?><!--" class="text-muted mobile">-->
<!--                            --><?php //echo $c_name ?>
<!--                        </a>-->
<!--                    </div>-->
<!--                    --><?php //} } ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //} ?>
<!--        --><?php //if (in_array('4', $msg)) { ?>
<!--        <div class="mobile-toggle">-->
<!--            <a data-bs-toggle="collapse" href="#collapseInteractive3" role="button" aria-expanded="false" aria-controls="collapseInteractive3">-->
<!---->
<!--                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="-->
<!--    float: left;">-->
<!--                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
<!--                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
<!--                                </svg></span><span class="ms-2 fw-light">Taskboard</span>-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
<!--                     class="arrow">   <polyline points="6 9 12 15 18 9"></polyline>-->
<!--                </svg>-->
<!--            </a>-->
<!--            <div class="collapse my-2" id="collapseInteractive3">-->
<!--                --><?php //if (in_array('9', $msg)) { ?>
<!--                <div class="ms-4">-->
<!--                    <div class="mt-3">-->
<!--                        <a href="--><?php //echo $siteURL; ?><!--taskboard_module/taskboard.php" class="text-muted mobile">-->
<!--                           Taskboard-->
<!--                        </a>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--                --><?php //}	if (in_array('11', $msg)) { ?>
<!--                <div class="ms-4">-->
<!--                    <div class="mt-3">-->
<!--                        <a href="--><?php //echo $siteURL; ?><!--taskboard_module/create_taskboard.php" class="text-muted mobile">-->
<!--                           Create Taskboard-->
<!--                        </a>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--                --><?php //} if (in_array('12', $msg)) { ?>
<!--                <div class="ms-4">-->
<!--                    <div class="mt-3">-->
<!--                        <a href="--><?php //echo $siteURL; ?><!--taskboard_module/create_task.php" class="text-muted mobile">-->
<!--                           Create/Edit Taskboard-->
<!--                        </a>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--                --><?php //} ?>
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //}  ?>
        <?php if (in_array('23', $msg)) { ?>
        <div class="mobile-toggle">
            <a data-bs-toggle="collapse" href="#collapseC" role="button" aria-expanded="false" aria-controls="collapseC">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="float: left;">
                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                        <polyline points="13 2 13 9 20 9"></polyline>
                                    </svg></span><span class="ms-2 fw-light">Forms</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="arrow">   <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </a>
            <div class="collapse my-2" id="collapseC">
                <div class="ms-4">
                    <?php if (in_array('42', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>form_module/form_settings.php" class="text-muted mobile">
                           Add/Create Form
                        </a>
                    </div>
                    <?php } if (in_array('50', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>form_module/edit_form_options.php" class="text-muted mobile">
                           Edit Form
                        </a>
                    </div>
                    <?php } if (in_array('38', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>form_module/options.php" class="text-muted mobile">
                            Submit Form
                        </a>
                    </div>
                    <?php } if (in_array('44', $msg)) { ?>
                        <div class="mt-3">
                            <a href="<?php echo $siteURL; ?>form_module/form_search.php" class="text-muted mobile">
                            View Form
                        </a>
                    </div>
                    <?php } if (in_array('60', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>form_module/forms_recycle_bin.php" class="text-muted mobile">
                            Restore Form
                        </a>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <?php }  ?>
        <?php if (in_array('45', $msg)) { ?>
        <div class="mobile-toggle">
            <a data-bs-toggle="collapse" href="#collapseCpp" role="button" aria-expanded="false" aria-controls="collapseCpp">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="float: left;">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="3" y1="9" x2="21" y2="9"></line>
                                        <line x1="9" y1="21" x2="9" y2="9"></line>
                                    </svg></span><span class="ms-2 fw-light">Station Events</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="arrow">   <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </a>
            <div class="collapse my-2" id="collapseCpp">
                <div class="ms-4">
                    <?php if (in_array('46', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>events_module/station_events.php" class="text-muted mobile">
                           Add/update Events
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if (in_array('7', $msg)) { ?>
        <div class="mobile-toggle">
            <a href="<?php echo $siteURL; ?>assignment_module/assign_crew.php" role="button">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="float: left;">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg></span><span class="ms-2 ">Crew Assignment</span>

            </a>

        </div>
        <?php } ?>
        <?php if (in_array('65', $msg)) { ?>
        <div class="mobile-toggle">
            <a data-bs-toggle="collapse" href="#collapsePython" role="button" aria-expanded="false" aria-controls="collapsePython">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="float: left;">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                    </svg></span><span class="ms-2 fw-light">Communicator</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="arrow">   <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </a>
            <div class="collapse my-2" id="collapsePython">
                <div class="ms-4">
                    <?php if (in_array('5', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>group_mail_module.php" class="text-muted mobile">
                           Mail
                        </a>
                    </div>
                    <?php } if (in_array('6', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>chatbot/chat.php" class="text-muted mobile" >
                          Chat
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php  if (in_array('66', $msg)) { ?>
            <div class="mobile-toggle">
                <a data-bs-toggle="collapse" href="#collapseJava" role="button" aria-expanded="false" aria-controls="collapseJava">
                   <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="float: left;">
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
                                    </svg></span><span class="ms-2 ">Admin Config</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="arrow">   <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>
                <?php if (in_array('18', $msg)) { ?>
                    <div class="collapse my-2" id="collapseJava">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a data-bs-toggle="collapse" href="#collapseJava1" role="button" aria-expanded="false" aria-controls="collapseJava1">
                                    Config
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>

                                    <div class="collapse my-2" id="collapseJava1">
                                        <div class="ms-4">
                                            <?php if (in_array('29', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/create_assets.php" class="text-muted mobile">
                                                        Assets Config
                                                    </a>
                                                </div>
                                            <?php } if (in_array('62', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/dashboard_config.php" class="text-muted mobile">
                                                        Cell Dashboard Config
                                                    </a>
                                                </div>
                                            <?php } if (in_array('71', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/create_cust_dashboard.php" class="text-muted mobile">
                                                        Create Custom Dashboard
                                                    </a>
                                                </div>
                                            <?php } if (in_array('56', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/accounts.php" class="text-muted mobile">
                                                        Customer Accounts
                                                    </a>
                                                </div>
                                            <?php } if (in_array('63', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/defect_group.php" class="text-muted mobile" >
                                                        Defect Group
                                                    </a>
                                                </div>
                                            <?php } if (in_array('55', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/defect_list.php" class="text-muted mobile">
                                                        Defect List
                                                    </a>
                                                </div>
                                            <?php } if (in_array('52', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/event_category.php" class="text-muted mobile">
                                                        Event category
                                                    </a>
                                                </div>
                                            <?php } if (in_array('47', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/event_type.php" class="text-muted mobile">
                                                        Event Type
                                                    </a>
                                                </div>
                                            <?php } if (in_array('43', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/form_type.php" class="text-muted mobile">
                                                        Form Type
                                                    </a>
                                                </div>
                                            <?php } if (in_array('26', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/job_title.php" class="text-muted mobile">
                                                        Job Title
                                                    </a>
                                                </div>
                                            <?php } if (in_array('53', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/form_measurement_unit.php" class="text-muted mobile">
                                                        Measurement Unit
                                                    </a>
                                                </div>
                                            <?php } if (in_array('27', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/shift_location.php" class="text-muted mobile">
                                                        Shift Location
                                                    </a>
                                                </div>
                                            <?php } if (in_array('24', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/line.php" class="text-muted mobile">
                                                        Station
                                                    </a>
                                                </div>
                                            <?php } if (in_array('28', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/station_pos_rel.php" class="text-muted mobile">
                                                        Station Position Config
                                                    </a>
                                                </div>
                                            <?php } if (in_array('25', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/position.php" class="text-muted mobile">
                                                        Position
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                            </div>

                        </div>
                    </div>
                <?php } ?>
                <?php if (in_array('20', $msg)) { ?>
                    <div class="collapse my-2" id="collapseJava">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a data-bs-toggle="collapse" href="#collapseJava2" role="button" aria-expanded="false" aria-controls="collapseJava2">
                                   Parts
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>
                                    <div class="collapse my-2" id="collapseJava2">
                                        <div class="ms-4">
                                            <?php if (in_array('34', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>part_module/part_number.php" class="text-muted mobile" >
                                                        Part Number </a>
                                                </div>
                                            <?php } if (in_array('35', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>part_module/part_family.php" class="text-muted mobile">
                                                        Part Family
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                            </div>

                        </div>
                    </div>
                <?php } ?>
                <?php if (in_array('19', $msg)) { ?>
                    <div class="collapse my-2" id="collapseJava">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a data-bs-toggle="collapse" href="#collapseJava3" role="button" aria-expanded="false" aria-controls="collapseJava3">
                                    Report Config
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>

                                    <div class="collapse my-2" id="collapseJava3">
                                        <div class="ms-4">
                                            <?php if (in_array('32', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>report_config_module/assignment_log_config.php" class="text-muted mobile">
                                                        Assignment Mail Config
                                                    </a>
                                                </div>
                                            <?php } if (in_array('31', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>report_config_module/communicator_config.php" class="text-muted mobile" >
                                                        Communicator Config
                                                    </a>
                                                </div>
                                            <?php } if (in_array('33', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>report_config_module/task_log_config.php" class="text-muted mobile" >
                                                        Task Log Config
                                                    </a>
                                                </div>
                                            <?php } if (in_array('64', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>cronjobs/training_mail_config.php" class="text-muted mobile" >
                                                        Training Completion Mail Config
                                                    </a>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>

                            </div>

                        </div>
                    </div>
                <?php } ?>

                <?php if (in_array('8', $msg)) { ?>
                    <div class="collapse my-2" id="collapseJava">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a data-bs-toggle="collapse" href="#collapseJava4" role="button" aria-expanded="false" aria-controls="collapseJava4">
                                   User Config
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="arrow" >   <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>

                                    <div class="collapse my-2" id="collapseJava4">
                                        <div class="ms-4">
                                            <?php if (in_array('13', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>user_module/users_list.php" class="text-muted mobile">
                                                        Add/Update User
                                                    </a>
                                                </div>
                                            <?php } if (in_array('14', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>user_module/role_list.php" class="text-muted mobile">
                                                        Add User Role(s)
                                                    </a>
                                                </div>
                                            <?php } if (in_array('61', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>user_module/user_custom_dashboard.php" class="text-muted mobile">
                                                        Custom Dashboard
                                                    </a>
                                                </div>
                                            <?php } if (in_array('15', $msg)) { ?>
                                                <div class="mt-3">
                                                    <a href="<?php echo $siteURL; ?>user_module/user_ratings.php" class="text-muted mobile">
                                                        User Station-Pos Ratings
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                            </div>

                        </div>
                    </div>
                <?php } ?>
                <?php if (in_array('16', $msg)) { ?>
                    <div class="collapse my-2" id="collapseJava">
                        <div class="ms-4">
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>group.php" data-bs-toggle="collapse" href="#collapseJava2" role="button" aria-expanded="false" aria-controls="collapseJava2">
                                   User Group(s)
                                </a>

                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (in_array('22', $msg)) { ?>
        <div class="mobile-toggle">
            <a data-bs-toggle="collapse" href="#collapseMore" role="button" aria-expanded="false" aria-controls="collapseMore">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lazyload blur-up mobile" style="float: left;">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg></span>
                <span class="ms-2 ">Logs</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="arrow">   <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </a>
            <div class="collapse my-2" id="collapseMore">
                <div class="ms-4">
                    <?php if (in_array('36', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>log_module/assign_crew_log.php" class="text-muted mobile">
                            <span class="ms-2 ">Crew Assignment Log</span>
                        </a>
                    </div>
                    <?php } if (in_array('40', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>log_module/task_crew_log.php" class="text-muted mobile">
                            <span class="ms-2 ">Task Crew Log</span>
                        </a>
                    </div>
                    <?php } if (in_array('51', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>log_module/station_events_log.php" class="text-muted mobile">
                            <span class="ms-2 ">Station Events Log</span>
                        </a>
                    </div>
                    <?php } if (in_array('59', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>log_module/good_bad_pieces_log.php" class="text-muted mobile">
                            <span class="ms-2 ">Good Bad Pieces Log</span>
                        </a>
                    </div>
                    <?php } if (in_array('21', $msg)) { ?>
                    <div class="mt-3">
                        <a href="<?php echo $siteURL; ?>table.php" class="text-muted mobile">
                            <span class="ms-2 ">Training Matrix</span>
                        </a>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <?php } ?>
    </div>

</div>
<!-- Mobile navigation offcanvas menu ends -->

<!-- Desktop navigation -->
<nav class="d-none d-sm-block navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               <?php if (in_array('67', $msg)) { ?>
                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link" role="button" id="learnId">
                        Boards<svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20" style="margin-left: 62px;">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </a>
                    <!-- start mega menu -->
                    <div class="menu container">
                        <div id="mainDropdown" style="position: absolute;width: 80%;margin: 12px 70px;z-index: 1000;">
                            <?php if (in_array('68', $msg)) { ?>
                            <div class='tutorial_section'>

                                <div class="toggle" id="toggle-1" >
                                   <span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                    <span class="ms-2 fw-light">Dashboard</span></a>
                                    <span class="float-end" id="toggle-1-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16" style="margin-left: 54px;">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </span>
                                </div>
                                <div class="slidenew active" id="slide-1">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="p-3">
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>line_status_grp_dashboard.php" class="mega-link"><h3 class="text-muted fs-6">Cell Overview</h3></a>
                                                </div>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>dashboard.php"  class="mega-link"><h3 class="text-muted fs-6">Crew Status Overview</h3></a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if (in_array('69', $msg)) { ?>
                            <div class='tutorial_section'>
                                <div class="toggle" id="toggle-2">

                                                            <span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                        <span class="ms-2 fw-light">GBP Dashboard</span>
                                        <span class="float-end" id="toggle-2-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16"  style="margin-left: 54px;" >
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </span>

                                </div>

                                <div class="slidenew" id="slide-2">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="p-3">
                                                <?php
                                                $sql1 = "SELECT * FROM `cam_line` WHERE gbd_id = '1'";
                                                $result1 = $mysqli->query($sql1);

                                                while ($row1 = mysqli_fetch_array($result1)) {

                                                $gbd_id = $row1['gbd_id'];
                                                $line_name = $row1['line_name'];
                                                $line_id = $row1['line_id'];
                                                if ($gbd_id == 1) { ?>
                                                <div class="mb-3">
                                                    <a target="_blank" href="<?php echo $siteURL; ?>config_module/gbp_dashboard.php?id=<?php echo $line_id ?>" class="mega-link"><h3 class="text-muted fs-6"><?php echo $line_name ?></h3></a>
                                                </div>
                                                <?php } else {

                                                }
                                                } ?>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <?php } ?>
                            <?php if (in_array('70', $msg)) { ?>
                            <div class='tutorial_section'>
                                <div class="toggle" id="toggle-3">

                                                            <span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                        <span class="ms-2 fw-light">Custom Dashboard</span>
                                        <span class="float-end" id="toggle-3-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </span>

                                </div>

                                <div class="slidenew" id="slide-3">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="p-3">
                                                <?php  $query = sprintf("SELECT * FROM sg_cust_dashboard where enabled = 1");
                                                $qur = mysqli_query($db, $query);

                                                while ($rowc = mysqli_fetch_array($qur)) {
                                                $c_id = $rowc["sg_cust_group_id"];
                                                $c_name = $rowc["sg_cust_dash_name"];
                                                $enabled = $rowc["enabled"];

                                                if ($enabled == 1) { ?>
                                                <div class="mb-3">
                                                    <a target="_blank"
                                                       href="<?php echo $siteURL; ?>config_module/sg_cust_dashboard.php?id=<?php echo $c_id ?>" class="mega-link"><h3 class="text-muted fs-6"> <?php echo $c_name ?></h3></a>
                                                </div>
                                                <?php }
                                                } ?>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <?php } ?>
                            <?php if (in_array('4', $msg)) { ?>
                            <div class='tutorial_section'>
                                <div class="toggle" id="toggle-4">

                                                            <span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                        <span class="ms-2 fw-light">Taskboard</span>
                                        <span class="float-end" id="toggle-4-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16"  style="margin-left: 54px;">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </span>

                                </div>
                                <div class="slidenew" id="slide-4">

                                    <div class="row">
                                        <div class="col-md-6 mt-1">
                                            <div class="p-3">
                                                <?php if (in_array('9', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>taskboard_module/taskboard.php" class="mega-link"><h3 class="text-muted fs-6">Taskboard</h3></a>
                                                </div>
                                                <?php }	if (in_array('11', $msg)) { ?>
                                                    <div class="mb-3">
                                                        <a href="<?php echo $siteURL; ?>taskboard_module/create_taskboard.php" class="mega-link"><h3 class="text-muted fs-6">Create Taskboard</h3></a>
                                                    </div>
                                                <?php } if (in_array('12', $msg)) { ?>
                                                    <div class="mb-3">
                                                        <a href="<?php echo $siteURL; ?>taskboard_module/create_task.php" class="mega-link">
                                                            <h3 class="text-muted fs-6">
                                                                Create/Edit Task
                                                            </h3>
                                                        </a>
                                                    </div>
                                                <?php } ?>


                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <?php }
                            ?>

                        </div>

                    </div>
                    <!-- end mega nav bar-->
                </li>
               <?php } ?>
                <!-- Forms Menu -->
                <?php if (in_array('23', $msg)) { ?>
                <li class="nav-item" id="ic">
                    <a class="nav-link" >Forms <svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20"  style="margin-left: 54px;">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg></a>
                    <div class="menu ">
                        <ul>
                            <?php if (in_array('42', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>form_module/form_settings.php">Add/Create Form</a></li>
                            <?php } if (in_array('50', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>form_module/edit_form_options.php">Edit Form</a></li>
                            <?php } if (in_array('38', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>form_module/options.php">Submit Form</a></li>
                            <?php } if (in_array('44', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>form_module/form_search.php">View Form</a></li>
                            <?php } if (in_array('60', $msg)) { ?>
                            <li> <a href="<?php echo $siteURL; ?>form_module/forms_recycle_bin.php">Restore Form</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
                <?php } ?>
                <?php if (in_array('7', $msg)) { ?>
                <li class="nav-item">
                    <a href="<?php echo $siteURL; ?>assignment_module/assign_crew.php" class="nav-link">Crew Assignment</a>
                </li>
                <?php } ?>
                <?php if (in_array('45', $msg)) { ?>
                <li class="nav-item" id="ic">
                    <a class="nav-link" href="#" >Station Events <svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20"  style="margin-left: 112px;">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg></a>
                    <div class="menu ">
                        <ul>
                            <?php if (in_array('46', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>events_module/station_events.php">Add/Update Events</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
                <?php } ?>
                <?php if (in_array('65', $msg)) { ?>
                <li class="nav-item" id="ic">
                    <a class="nav-link">Communicator <svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20"  style="margin-left: 115px;">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg></a>
                    <div class="menu ">
                        <ul>
                            <?php if (in_array('5', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>group_mail_module.php">Mail</a></li>
                            <?php } if (in_array('6', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>chatbot/chat.php">Chat</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
                <?php } ?>
                <?php if (in_array('66', $msg)) { ?>
                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link" role="button" id="learnId">
                       Admin Config<svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20"  style="margin-left: 106px;">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </a>
                    <!-- start mega menu -->
                    <div class="menu container">
                        <div id="mainDropdown" style="position: relative;width: 80%;margin: 12px auto;height: 400px;">
                            <?php if (in_array('18', $msg)) { ?>
                            <div class='tutorial_section'>
                                <div class="toggle" id="toggle-1" >
  <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
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
                                    </span>                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                        <span class="ms-2 fw-light">Config</span></a>
                                    <span class="float-end" id="toggle-1-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16" >
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </span>
                                </div>
                                <div class="slidenew active" id="slide-1">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="p-3">
                                                <?php if (in_array('29', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/create_assets.php" class="mega-link"><h3 class="text-muted fs-6">Assets Config</h3></a>
                                                </div>
                                                <?php } if (in_array('62', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/dashboard_config.php" class="mega-link"><h3 class="text-muted fs-6">Cell Dashboard Config</h3></a>
                                                </div>
                                                <?php } if (in_array('71', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/create_cust_dashboard.php" class="mega-link"><h3 class="text-muted fs-6">Create Custom Dashboard</h3></a>
                                                </div>
                                                <?php } if (in_array('56', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/accounts.php" class="mega-link"><h3 class="text-muted fs-6">Customer Accounts</h3></a>
                                                </div>
                                                <?php } if (in_array('63', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/defect_group.php" class="mega-link"><h3 class="text-muted fs-6">Defect Group</h3></a>
                                                </div>
                                                <?php } if (in_array('55', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/defect_list.php" class="mega-link"><h3 class="text-muted fs-6">Defect List</h3></a>
                                                </div>
                                                <?php } if (in_array('52', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/event_category.php" class="mega-link"><h3 class="text-muted fs-6">Event Category</h3></a>
                                                </div>
                                                <?php } if (in_array('47', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/event_type.php" class="mega-link"><h3 class="text-muted fs-6">Event Type</h3></a>
                                                </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="p-3">
                                                <?php } if (in_array('43', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/form_type.php" class="mega-link"><h3 class="text-muted fs-6">Form Type</h3></a>
                                                </div>
                                                <?php } if (in_array('26', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/job_title.php" class="mega-link"><h3 class="text-muted fs-6">Job Title</h3></a>
                                                </div>
                                                <?php } if (in_array('53', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/form_measurement_unit.php" class="mega-link"><h3 class="text-muted fs-6">Measurement Unit</h3></a>
                                                </div>
                                                <?php } if (in_array('27', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/shift_location.php" class="mega-link"><h3 class="text-muted fs-6">Shift Location</h3></a>
                                                </div>
                                                <?php } if (in_array('24', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/line.php" class="mega-link"><h3 class="text-muted fs-6">Station</h3></a>
                                                </div>
                                                <?php } if (in_array('28', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/station_pos_rel.php" class="mega-link"><h3 class="text-muted fs-6">Station position Config</h3></a>
                                                </div>
                                                <?php } if (in_array('25', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>config_module/position.php" class="mega-link"><h3 class="text-muted fs-6">Position</h3></a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if (in_array('20', $msg)) { ?>
                            <div class='tutorial_section'>
                                <div class="toggle" id="toggle-2">

  <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
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
                                    </span>                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                        <span class="ms-2 fw-light">Parts</span>
                                        <span class="float-end" id="toggle-2-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </span>

                                </div>
                                <div class="slidenew" id="slide-2">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="p-3">
                                                <?php if (in_array('34', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>part_module/part_number.php" class="mega-link"><h3 class="text-muted fs-6">Part Number</h3></a>
                                                </div>
                                                <?php } if (in_array('35', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>part_module/part_family.php" class="mega-link"><h3 class="text-muted fs-6">Part Family</h3></a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <?php } ?>
                            <?php if (in_array('19', $msg)) { ?>
                            <div class='tutorial_section'>
                                <div class="toggle" id="toggle-3">

  <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
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
                                    </span>                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                        <span class="ms-2 fw-light">Report Config</span>
                                        <span class="float-end" id="toggle-3-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16"  style="margin-left: 54px;">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </span>

                                </div>
                                <div class="slidenew" id="slide-3">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <div class="p-3">
                                                <?php if (in_array('32', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>report_config_module/assignment_log_config.php" class="mega-link"><h3 class="text-muted fs-6">Assignment Mail Config</h3></a>
                                                </div>
                                                <?php } if (in_array('31', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>report_config_module/communicator_config.php" class="mega-link"><h3 class="text-muted fs-6">Communicator Config</h3></a>
                                                </div>
                                                <?php } if (in_array('33', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>report_config_module/task_log_config.php" class="mega-link"><h3 class="text-muted fs-6">Task Log Config</h3></a>
                                                </div>
                                                <?php } if (in_array('64', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>cronjobs/training_mail_config.php" class="mega-link"><h3 class="text-muted fs-6">Training Completion Mail Config</h3></a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <?php } ?>
                            <?php if (in_array('8', $msg)) { ?>
                            <div class='tutorial_section'>
                                <div class="toggle" id="toggle-4">

  <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
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
                                    </span> <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                        <span class="ms-2 fw-light">User Config</span>
                                        <span class="float-end" id="toggle-4-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16"  style="margin-left: 54px;">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </span>

                                </div>
                                <div class="slidenew" id="slide-4">

                                    <div class="row">
                                        <div class="col-md-6 mt-1">
                                            <div class="p-3">
                                                <?php if (in_array('13', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>user_module/users_list.php" class="mega-link"><h3 class="text-muted fs-6">Add/Update User</h3></a>
                                                </div>
                                                <?php } if (in_array('14', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>user_module/role_list.php" class="mega-link"><h3 class="text-muted fs-6">Add User Role(s)</h3></a>
                                                </div>
                                                <?php } if (in_array('61', $msg)) { ?>
                                                <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>user_module/user_custom_dashboard.php" class="mega-link"><h3 class="text-muted fs-6">Custom dashboard</h3></a>
                                                </div>
                                                <?php } if (in_array('15', $msg)) { ?>
                                                    <div class="mb-3">
                                                    <a href="<?php echo $siteURL; ?>user_module/user_ratings.php" class="mega-link"><h3 class="text-muted fs-6">user Station-Pos ratings</h3></a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <?php } ?>
                            <?php if (in_array('16', $msg)) { ?>
                                <div class='tutorial_section'>
                                    <div class="toggle" id="toggle-2">
                                        <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="desktop_arrow">
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
                                    </span>
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> </span>
                                        <span class="ms-2 fw-light">User Group(s)</span>
                                        <span class="float-end" id="toggle-2-arrow">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-danger" viewBox="0 0 16 16"  style="margin-left: 54px;" >
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                    </svg>
                                </span>

                                    </div>

                                    <div class="slidenew" id="slide-2">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <div class="p-3">

                                                    <div class="mb-3">
                                                        <a href="<?php echo $siteURL; ?>group.php" class="mega-link"><h3 class="text-muted fs-6">User Group</h3></a>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                    <!-- end mega nav bar-->
                </li>


                <?php if (in_array('22', $msg)) { ?>
                <li class="nav-item" id="ic">
                    <a class="nav-link" >Logs <svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20"  style="margin-left: 42px;">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg></a>
                    <div class="menu ">
                        <ul>
                            <?php if (in_array('36', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>log_module/assign_crew_log.php">Crew Assignment Log</a></li>
                            <?php } if (in_array('40', $msg)) { ?>
                            <li> <a href="<?php echo $siteURL; ?>log_module/task_crew_log.php">Task Crew Log</a></li>
                            <?php } if (in_array('51', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>log_module/station_events_log.php">Station Events Log</a></li>
                            <?php } if (in_array('59', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>log_module/good_bad_pieces_log.php">Good Bad Pieces Log</a></li>
                            <?php } if (in_array('21', $msg)) { ?>
                            <li><a href="<?php echo $siteURL; ?>table.php"> Training Matrix</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
                <?php } ?>
            </ul>

        </div>
    </div>
</nav>
<script>
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

<script>
    $(document).ready(function() {
        App.init();
    });
</script>

</body>
</html>