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
$i = $_SESSION["role_id"];
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
<script type="text/javascript" src="../assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="../assets/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="../assets/js/pages/components_dropdowns.js"></script>
<script>
    function openNav() {
        document.getElementById("myNav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("myNav").style.width = "0%";
    }
</script>
<style type="text/css">
         #home:hover {
                background-color: white;
            } 
                
          .avilable, .logout, .away ,.dot{
            height: 16px;
            width: 16px;
            border-radius: 50%;
            display: inline-block;
            float: right;
            margin-top: -27px;

            }
            .avilable{ background-color: green;}
            .dot{ 
                
                float: right;
                margin-top: 5px;    
                margin-right: 0px;}
            
            .logout{ background-color: red;}
            .away{ background-color: orange;}
            .card{
                    width: 19rem;
                    float: right;
                    margin-top: 0px;
                    background: white;
                    border-radius: 9px;
                    height: 132px;
                    font-size: 15px;
                    float: right;
                    display: none;
                    border: 2px solid #1b67ab;
                }
                #status{
                    width: auto;
                    border-radius: 10px;
                    margin-right: 10px;
                    background: #1e73be;
                }
                 .head{
                    font-size: 17px;
                    font-weight: 500;
                    color: black;
                    background: #bdbcbc;
                    font-style: oblique;
                    }  
                    a, #noHover{
                         color: black;
                        

                    }

            /* CSS used here will be applied after bootstrap.css */

                    .dropdown {
                        display:inline-block;
                        margin-left:20px;
                        padding:0px;
                      }


                    .glyphicon-bell {
                        font-size: 19px;
                        margin-top: 17px;
                    }

                    .notifications {
                       min-width:420px; 
                      }
                     .notifications1 {
                       min-width:162px; 
                      }
                      .dropdown-menu:not([class*=border-]) {
                        /* border-width: 0px; */
                        margin-right: 21px;
                    }
                      .notifications-wrapper {
                         overflow:auto;
                          max-height:250px;
                        }
                       .notifications1-wrapper {
                         overflow:auto;
                          max-height:250px;
                        }
                        
                     .menu-title {
                         color:#ff7788;
                         font-size:1.5rem;
                          display:inline-block;
                          }
                     
                    .glyphicon-circle-arrow-right {
                          margin-left:10px;     
                       }
                      
                       
                     .notification-heading, .notification-footer  {
                        padding:2px 10px;
                           }
                          
                            
                    .dropdown-menu.divider {
                      margin:5px 0;          
                      }

                    .item-title {
                      
                     font-size:1.3rem;
                     color:#000;
                        
                    }

                    .notifications a.content1 {
                     text-decoration:none;
                     background:#ccc;

                     }
                        
                    .notification-item {
                     padding:10px;
                     margin:5px;
                     background:#ccc;
                     border-radius:4px;
                     }
                     .noHover{
                            pointer-events: none;
                        }
         @media
         only screen and (max-width: 760px),
         (min-device-width: 768px) and (max-device-width: 1024px){


             .overlay {
                 height: 100%;
                 width: 0;
                 position: fixed;
                 z-index: 1;
                 top: 62px;
                 left: 0;
                 background-color: rgb(0, 0, 0);
                 background-color: rgba(0, 0, 0, 0.9);
                 overflow-x: hidden;
                 transition: 0.5s;

             }


             .overlay a {
                 padding: 8px;
                 text-decoration: none;
                 font-size: 36px;
                 color: #818181;
                 display: block;
                 transition: 0.3s;
             }

             .overlay a:hover, .overlay a:focus {
                 color: #f1f1f1;
             }


             .sidebar-default .navigation li > a {
                 color: #f5f5f5;
                 font-size: large;
             }
         }
         (min-device-width: 820px) and (max-device-width: 1180px){
         .overlay {
             height: 100%;
             width: 0;
             position: fixed;
             z-index: 1;
             top: 42px;
             left: 0;
             background-color: rgb(0, 0, 0);
             background-color: rgba(0, 0, 0, 0.9);
             overflow-x: hidden;
             transition: 0.5s;

         }
         .sidebar {

             width: 0px;
         }


         .overlay a {
             padding: 8px;
             text-decoration: none;
             font-size: 36px;
             color: #818181;
             display: block;
             transition: 0.3s;
         }

         .overlay a:hover, .overlay a:focus {
             color: #f1f1f1;
         }


         .sidebar-default .navigation li > a {
             color: #f5f5f5;
             font-size: large;
         }
         .sidebar {

             width: 100%;
         }
         }


</style>
<div class="navbar navbar-inverse " style="background-color:#1a4a73;">
    <div class="navbar-header" style="background-color:#f7f7f7;">
        <?php
        $path = '';
		if(!empty($is_cell_login) && $is_cell_login == 1){
		    $path = "../cell_line_dashboard.php";
		}else{
            if(!empty($i) && ($is_tab_login != null)){
                $path = "../line_tab_dashboard.php";
            }else{
                $path = "../line_status_grp_dashboard.php";
            }
        }
        ?>
        <a href=<?php echo $path?> id="home"><img src="../assets/images/SGG_logo.png" alt="" id="site_logo"/></a>
        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li onclick="openNav()"><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>
    <div class="navbar-collapse collapse" id="navbar-mobile">
        <!--			collaps code-->
        <!--			<ul class="nav navbar-nav nav-collapse">-->
        <!--				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>-->
        <!--			</ul>-->
        <div class="col-md-3"></div>
        <div class="navbar-center col-md-3">
            <h3 id="screen_header"><span class="text-semibold"><?php echo $cam_page_header; ?></span></h3>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <div class="dropdown pull-right" id="drop">
                            <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" style=" background-color: unset !important;">
                            <span class="glyphicon glyphicon-bell noHover"id="bell_icon" ></span>  
                          </a>
                          <span class="badge badge-secondary"id="bell_count"></span>
                          
                          <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">
                            
                            <div class="notification-heading"><h4 class="menu-title">Notifications</h4><!-- <h4 class="menu-title pull-right">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4> -->
                            </div>
                            <li class="divider"></li>
                           <div class="notifications-wrapper">
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
                              
                               <div class="notification-item">

                                <h4 class="item-title"><?php echo $name; ?> · <?php echo $date; ?>day ago</h4>
                               
                                <p class="item-info no_namelist"><?php echo $msg; ?> 
                                 <input type="hidden" id="not_id" name="id" value="<?php echo $id; ?>"> 
                                  <input type="hidden" id="login_id" name="login_id" value="<?php echo $loginid; ?>"> 
                               </p>
                              </div>
                               
                            </a>
                                        <?php } ?>                      
                            
                            

                           </div>
                            <li class="divider"></li>
                            <!-- <div class="notification-footer"><h4 class="menu-title">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></div> -->
                          </ul>
  
                       </div> 
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="../user_images/<?php echo $_SESSION["uu_img"]; ?>" alt="">
                        <span><?php echo $_SESSION['fullname']; ?></span>
                        <i class="caret"></i>
                    </a>
                    <?php
                    if ($available_var == "0") {
                        $select = "";
                    } else {
                        $select = "checked='checked'";
                    }
                    ?>
                    <ul class="dropdown-menu dropdown-menu-right">
						<?php
						if ($is_cust_dash == 0) {
							$select = "";
						} else {
							$select = "checked='checked'";
						}
						if (isset($line_cust_dash)) { ?>
                            <li> <label class="checkbox-switchery switchery-xs " style="margin-left:12px;">
                                    <input type="checkbox"  class="switchery custom_switch" <?php echo $select; ?> >Custom Dashboard</label></li>
						<?php }
						//                        else { ?>
                        <!--                            <li> <label class="checkbox-switchery switchery-xs " style="margin-left:12px;">-->
                        <!--                            <input type="checkbox"  class="switchery custom_switch" --><?php //echo $select; ?><!-- disabled >Custom Dashboard</label></li>-->
                        <!--                            --><?php
						//                        }
						if ($available_var == "0") {
							$select = "";
						} else {
							$select = "checked='checked'";
						}
                        if ($taskvar != "") { ?>
                            <li> <label class="checkbox-switchery switchery-xs " style="margin-left:12px;">
                                    <?php if ($tm_task_id == "") { ?>
                                        <input type="checkbox"  class="switchery custom_switch" <?php echo $select; ?> >Available</label></li>
                            <?php } else { ?>
                                <input type="checkbox"  class="switchery custom_switch" <?php echo $select; ?> disabled >Available</label></li>
                                <?php
                            }
                        }
                        ?>
                        <li><a href="../profile.php"><i class="icon-user-plus"></i> My profile</a></li>
                        <li><a href="../change_pass.php"><i class="icon-cog5"></i> Change Password</a></li>
						<?php if($_SESSION['is_tab_user']){ ?>
                            <li><a href="../tab_logout.php"><i class="icon-switch2"></i> Logout</a></li>
						<?php } else {?>
                            <li><a href="../logout.php"><i class="icon-switch2"></i> Logout</a></li>
						<?php }?>
                    </ul>
                </li>
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
                    ?>					</ul>
        </div>
    </div>
</div>

