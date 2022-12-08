<?php
include("../config.php");
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
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" ) {
    header('location: ../dashboard.php');
}
?>
<form action="good_bad_piece_schedular.php" id="form_settings" enctype="multipart/form-data" class="form-horizontal" method="post">

    <div class="row">

        <div class="col-md-6 mobile">

            <label class="col-lg-3 control-label">Page From :</label>
            <div class="col-lg-8">
                <input type="text" name="id_from" id="id_from" class="form-control" placeholder="Enter Page" required="">
            </div>

        </div>

        <div class="col-md-6 mobile">
            <label class="col-lg-3 control-label">Page To : &nbsp;&nbsp;</label>

            <div class="col-lg-8">
                <input type="text" name="id_to" id="id_to" class="form-control" placeholder="Enter Page" required="">

            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Search</button>

    </div>
</form>