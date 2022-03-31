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
if(!empty($result1)) {
	while ($row1 = $result1->fetch_assoc()) {
		$tm_task_id = $row1['tm_task_id'];
	}
}
?>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_dropdowns.js"></script>
<style>
    .header {
        overflow: hidden;
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
        margin-top: 5.5px;
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
    <a href="<?php echo $path?>" class="logo">
        <img class = "logo_img" src="<?php echo $siteURL; ?>assets/img/SGG_logo.png" alt="logo">
    </a>

    <div class="header-right">
        <div class="dropdown">
            <button onclick="myFunction()"  class="dropbtn">
                <?php echo $_SESSION['fullname']; ?> <svg xmlns="http://www.w3.org/2000/svg" class="arrow dropbtn" viewBox="0 0 20 20">
                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                </svg></button>
            <img class="dropbtn_img" src="<?php echo $siteURL; ?>user_images/<?php echo $_SESSION["uu_img"]; ?>">
            <div id="myDropdown" class="dropdown-content">

                <a>

                        <div class="user-profile-section">
                            <div class="media mx-auto slack">
                                <?php  if ($is_cust_dash == 0) {
                                    $select = "";
                                } else {
                                    $select = "checked='checked'";
                                }
                                if (isset($line_cust_dash)) { ?>
                                    <div class="media-body">
                                        <label class="checkbox-switchery switchery-xs">
                                            <input type="checkbox"  class="switchery custom_switch_db" <?php echo $select; ?> style="margin-left: -4px;">
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
                </a>

                <a href="<?php echo $siteURL; ?>profile.php">  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="arrow_desktop" style="display: inline">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>Profile</a>
                <a href="<?php echo $siteURL; ?>change_pass.php">  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="arrow_desktop" style="display: inline">
                      <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                      <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>Change Password</a>
                <?php if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){ ?>
                    <a href="<?php echo $siteURL; ?>tab_logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="arrow_desktop" style="display: inline">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>Log Out</a>
                <?php } else {?>
                    <a href="<?php echo $siteURL; ?>logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="arrow_desktop" style="display: inline">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>Log Out</a>
                <?php }?>
            </div>
        </div>



    </div>
</div>
<script>
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }


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

</script>

