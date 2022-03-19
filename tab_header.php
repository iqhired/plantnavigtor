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
$c_login_stations_arr = '';
$cell_id = $_SESSION['cell_id'];
$is_cell_login = $_SESSION['is_cell_login'];
if(isset($cell_id) && '' != $cell_id){
    $sql1 = "SELECT stations FROM `cell_grp` where c_id = '$cell_id'";
    $result1 = mysqli_query($db,$sql1);
    while ($row1 = mysqli_fetch_array($result1)) {
        $c_login_stations = $row1['stations'];
    }
    if(isset($c_login_stations) && '' != $c_login_stations){
        $c_login_stations_arr = array_filter(explode(',', $c_login_stations));
    }
}

$sql1 = "SELECT * FROM `tm_task` where assign_to = '$iid' and status='1'";
$result1 = mysqli_query($db, $sql1);
if( null != $result1 ){
    while ($row1 = mysqli_fetch_array($result1)) {
        $tm_task_id = $row1['tm_task_id'];
    }
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
<?php
$path = '';
if(!empty($is_cell_login) && $is_cell_login == 1){
	$path = "../cell_line_dashboard.php";
}else{
	$path = "../line_tab_dashboard.php";
}
?>
<div class="header-container">
    <header class="header navbar navbar-expand-sm">

        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

        <div class="nav-logo align-self-center">
            <a class="navbar-brand" href="<?php echo $path?>"><img alt="logo" src="<?php echo $siteURL; ?>assets/img/SGG_logo.png"></a>
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
                    <li class="nav-item theme-logo">
                        <a href="<?php echo $path?>">
                            <img src="<?php echo $siteURL; ?>assets/img/SGG_logo.png" class="navbar-logo" alt="logo">
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



            <li class="nav-item dropdown notification-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                </a>
                <?php
                while ($rowc_not = mysqli_fetch_array($qur_not)) {
                    $name = $rowc_not["user_name"];
                    $us_id = $rowc_not["users_id"];
                    $se_id = $rowc_not["sender"];
                    $id = $rowc_not["sg_chatbox_id"];
                    $msg = $rowc_not["message"];
                    $date = $rowc_not["createdat"];    ?>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="notification-scroll">
                            <div class="dropdown-item">
                                <div class="media server-log">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>
                                    <div class="media-body">
                                        <div class="data-info">
                                            <?php
                                            $loginid = $_SESSION["id"];
                                            $sidebar_user_id = $_SESSION['session_user'];
                                            /*$query10 = sprintf("SELECT DISTINCT `sender`,`receiver` FROM sg_chatbox where sender = '$loginid' OR receiver = '$sidebar_user_id' ORDER BY createdat DESC ;  ");*/
                                            $query_not = sprintf("SELECT DISTINCT sg_chatbox.`sg_chatbox_id`,sg_chatbox.`message`,sg_chatbox.`createdat`,sg_chatbox.`sender`,cam_users.`user_name`,cam_users.`users_id`,cam_users.`profile_pic` FROM sg_chatbox INNER JOIN cam_users ON sg_chatbox.`sender`= cam_users.`users_id` WHERE `sender` !=$loginid AND `flag`=$loginid ");
                                            $qur_not = mysqli_query($db, $query_not);

                                            while ($rowc_not = mysqli_fetch_array($qur_not)) {
                                            $name = $rowc_not["user_name"];
                                            $us_id = $rowc_not["users_id"];
                                            $se_id = $rowc_not["sender"];
                                            $id = $rowc_not["sg_chatbox_id"];
                                            $msg = $rowc_not["message"];
                                            $date = $rowc_not["createdat"];


                                            ?>
                                            <a href="#james" data-toggle="tab" data-id="<?php echo $se_id; ?>" value="<?php echo $id; ?>" class="use1_namelist" >
                                                <h6 class=""><?php echo $name; ?> · <?php echo $date; ?>day ago</h6>
                                                <p class=""><?php echo $msg; ?></p>
                                                <input type="hidden" id="not_id" name="id" value="<?php echo $id; ?>">
                                                <input type="hidden" id="login_id" name="login_id" value="<?php echo $loginid; ?>">
                                                <?php } ?>
                                        </div>

                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </li>

            <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="user-profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <!--                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slack"><path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"></path><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"></path><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"></path><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"></path><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"></path><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"></path><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"></path></svg>-->
                            <?php  if ($is_cust_dash == 0) {
                                $select = "";
                            } else {
                                $select = "checked='checked'";
                            }
                            if (isset($line_cust_dash)) { ?>
                                <div class="media-body">
                                    <label class="checkbox-switchery switchery-xs">
                                        <input type="checkbox"  class="switchery custom_switch_db" <?php echo $select; ?> style="margin-left: -4px;">
                                        <h5 style="width: 136px;margin-left: -11px;">Custom Dashboard</h5></label>

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
                                            <input type="checkbox"  class="switchery custom_switch" <?php echo $select; ?> style="margin-left: -4px;">
                                            <h5 style="width: 136px;margin-left: -11px;">Available</h5></label>
                                    <?php } else { ?>
                                        <label class="checkbox-switchery switchery-xs ">
                                            <input type="checkbox"  class="switchery custom_switch" <?php echo $select; ?> disabled >
                                            <h5 style="width: 136px;margin-left: -11px;">Available</h5></label>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                    </div>

                    <div class="dropdown-item">
                        <a href="profile.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user" style="display: inline"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" ></path><circle cx="12" cy="7" r="4"></circle></svg> <span> Profile</span>
                        </a>
                    </div>

                    <div class="dropdown-item">
                        <a href="change_pass.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock" style="display: inline"><rect x="3" y="11" width="18" height="11" rx="2" ry="2" ></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Change Password</span>
                        </a>
                    </div>
                    <?php if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){ ?>
                        <div class="dropdown-item">
                            <a href="tab_logout.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out" style="display: inline"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                            </a>
                        </div>
                    <?php } else {?>
                        <div class="dropdown-item">
                            <a href="logout.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out" style="display: inline"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" ></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                            </a>
                        </div>
                    <?php }?>
                </div>
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
<script>
    $(document).on("click", ".custom_switch", function () {
        var available_var = '<?php echo $available_var; ?>';
        $.ajax({
            url: "available.php",
            type: "post",
            data: {available_var: available_var},
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



</script>
<?php
if ($taskvar != "") {
    $ses = $_SESSION['available'];
    if ($ses == "0") {
        ?>
        <p class="navbar-text" style="margin-left:-20px;"><span class="status-mark bg-orange"></span></p>
    <?php } else {
        ?>
        <p class="navbar-text" style="margin-left:-20px;"><span class="status-mark bg-success"></span></p>
        <?php
    }
}
?>
