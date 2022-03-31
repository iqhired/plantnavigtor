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
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_dropdowns.js"></script>
<style>
    .header {
        overflow: initial;
        background-color: #060818;
        padding: 8px 25px;
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
        margin-top: -36px;
        /* font-size: 1em; */
        /* margin-top: 30px !important; */
    }


    /*.dropdown a:hover {background-color: #ddd;}*/

    .show {display: block;}
</style>

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
?>
<div class="header">

    <a href="#" class="logo">
        <img src="<?php echo $siteURL; ?>/assets/images/SGG_logo.png"  class = "logo_img" alt="logo">
    </a>

        <h3 class="navbar-center" id="screen_header" style=""><span class="text-semibold"><?php echo $cam_page_header; ?></span></h3>


</div>

