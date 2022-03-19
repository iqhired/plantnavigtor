<?php
include("config.php");
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
if(isset($cell_id) && '' != $cell_id){
    $sql1 = "SELECT stations FROM `cell_grp` where c_id = '$cell_id'";
    $result1 = $mysqli->query($sql1);
    while ($row1 = $result1->fetch_assoc()) {
        $c_login_stations = $row1['stations'];
    }
    if(isset($c_login_stations) && '' != $c_login_stations){
        $c_login_stations_arr = array_filter(explode(',', $c_login_stations));
    }
}

$sql1 = "SELECT * FROM `tm_task` where assign_to = '$iid' and status='1'";
$result1 = $mysqli->query($sql1);
while ($row1 = $result1->fetch_assoc()) {
    $tm_task_id = $row1['tm_task_id'];
}
?>
<!--  BEGIN NAVBAR  -->
<!--chart -->
<link rel="icon" type="image/x-icon" href="<?php echo $siteURL; ?>assets/img/favicon.ico"/>
<link href="<?php echo $siteURL; ?>assets/css/loader.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $siteURL; ?>assets/js/loader.js"></script>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="<?php echo $siteURL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $siteURL; ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<link href="<?php echo $siteURL; ?>assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_dropdowns.js"></script>

<div class="header-container">
    <header class="header navbar navbar-expand-sm">

        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

        <div class="nav-logo align-self-center">
            <a class="navbar-brand" href="#"><img alt="logo" src="<?php echo $siteURL; ?>assets/img/SGG_logo.png"></a>
        </div>

        <!--  <ul class="navbar-item flex-row mr-auto">
            <li class="nav-item align-self-center search-animated">
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                    </div>
                </form>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </li>
        </ul> -->


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
                    <li class="nav-item theme-logo" >
                            <img src="<?php echo $siteURL; ?>assets/img/SGG_logo.png" class="navbar-logo" alt="logo">

                    </li>

                </ul>
            </nav>

            <li class="nav-item dropdown notification-dropdown" style=" width: 832px;">

                <span><h2 style="width: max-content;" class="line_head"><?php echo $cam_page_header; ?></h2></span>

            </li>

        </ul>
    </header>
</div>
<!--  END NAVBAR  -->
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
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
