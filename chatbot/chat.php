<?php
include("../config.php");
 	//print_r($_SESSION['id']);


 $sql1 = "SELECT DISTINCT  `status` FROM sg_chatbox WHERE `sender` ='" . $_SESSION['id'] . "'";
 $result1 = $mysqli->query($sql1);
 while ($row1 = $result1->fetch_assoc()) {
 	$status = $row1['status'];
 	if($status == "Available"){

             $user_color = "green";

		}else if($status  == "Away"){
			 $user_color = "orange";

		}else if($status  == "Busy"){
			 $user_color = "red";
			
		}
//print_r($reciver_color);
 }



$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
if(isset($_POST['status'])){
  $sql1 = "UPDATE `sg_chatbox` SET status='" . $_POST['status'] . "' where sender = '" . $_SESSION['id'] . "'";
    if (!mysqli_query($db, $sql1)) {
// die('Unable to Connect');
        echo "Invalid Data";
    } else {
    	
        $temp = $_POST['status'];
         exit(json_encode($temp));
    }

}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Chatbot</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/support_chat_layouts.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
        <style>
            .sidebar-default .navigation li>a{color:#f5f5f5};

            #dLabel:hover {
                background-color: #20a9cc;
            }
            .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
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
						 color: white;
						

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
            .dropdown-menu>li>a {
                font-size: 1.2rem !important;
                color: black!important;

            }

            .sidebar-secondary {
                z-index: 0;
            }

        </style>
    </head>

        <!-- Main navbar -->
        <?php
        $cam_page_header = "Chat Box";
        include("../header.php");
        include("../admin_menu.php");
        ?>
    <body class="alt-menu sidebar-noneoverflow">
            <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">

			<div class="sidebar sidebar-secondary sidebar-default">
				<div class="sidebar-content">
					<!-- Search messages -->
					<div class="sidebar-category">
						<div class="category-title">
							<span>Search </span>
							<ul class="icons-list">
								<li><a href="#" data-action="collapse"></a></li>
							</ul>
						</div>

						<div class="category-content">
                         <form action="" id="update-form2" method="post" class="form-horizontal">
								<div class="has-feedback has-feedback-left">
									<select name="user_id" id="user_id" class="select" data-style="bg-slate" >
                                                                <option value="" selected disabled>--- Select Users ---</option>
                                                                <?php
                                                                $sql1 = "SELECT * FROM `cam_users` WHERE `users_id` != '1' order BY `firstname`";
                                                                $result1 = $mysqli->query($sql1);
                                                                //                                            $entry = 'selected';
                                                                while ($row1 = $result1->fetch_assoc()) {
                                                $full = $row1['firstname'] . " " . $row1['lastname'];
                                                                    echo "<option value='" . $row1['users_id'] . "' data-fullnm = '$full' data-id='" . $row1['users_id'] . "'>$full</option>";
                                                                                    }
                                                                ?>
                                                            </select>
															
<br/><br/>
<button type="button" class="btn btn-rounded btn-block btn-xs" onclick="submitForm2('chat_div.php')"  style="background-color:#1e73be;color:white;">Start Chat</button>

	                       


								</div>
							</form>
						</div>
					</div>
					<!-- /search messages -->
					<!-- Online users -->
					<div class="sidebar-category">
						<div class="category-title">
							<span>Users</span>
							<ul class="icons-list">
								<li><a href="#" data-action="collapse"></a></li>
							</ul>
						</div>
                                        <?php
										$loginid = $_SESSION["id"];
										$sidebar_user_id = $_SESSION['session_user'];
                                        $query10 = sprintf("SELECT DISTINCT value FROM(SELECT DISTINCT `sender` AS value FROM sg_chatbox where sender = '$loginid' OR receiver = '$loginid' UNION SELECT DISTINCT `receiver` AS value FROM sg_chatbox where sender = '$loginid' OR receiver = '$loginid') as a ");
//										$query10 = sprintf("SELECT DISTINCT sg_chatbox.`receiver`,cam_users.`user_name`,cam_users.`firstname`,cam_users.`lastname`,cam_users.`users_id`,cam_users.`profile_pic` FROM sg_chatbox INNER JOIN cam_users ON sg_chatbox.`receiver`= cam_users.`users_id` WHERE `sender` =$loginid or `receiver` =$loginid ");
										$qur10 = mysqli_query($db, $query10);

										//$qur10 = mysqli_fetch_array($query10);
										
                                        while ($rowc10 = mysqli_fetch_array($qur10)) {
										$sen = $rowc10["value"];
										//$res = $rowc10["value"];
										if($loginid != $sen)
										{
											
										$query20 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$sen' ");
											
										
 								$rowc20 = mysqli_fetch_array($query20);			
								$image1 = $rowc20["profile_pic"];
								$fullnm = $rowc20["firstname"]." ".$rowc20["lastname"];
								$uid = $rowc20["users_id"];


										
//do not touch										
//									    $uid = $rowc10["users_id"];
									    	//echo "<pre>";print_r($uid);
									    $q = sprintf("SELECT DISTINCT status FROM sg_chatbox  WHERE `sender` =$uid GROUP by sender DESC");
									    $q10 = mysqli_query($db, $q);
									     while ($rowc1 = mysqli_fetch_array($q10)) {
									     	$status = $rowc1["status"];
									     
										 if($status == "Available"){

								             $reciver_color = "green";

										}else if($status  == "Away"){
											 $reciver_color = "orange";

										}else if($status  == "Busy"){
											 $reciver_color = "red";
											
										}
									}
//										$image1 = $rowc10["profile_pic"];
//till herre
										 								
								$image = $rowc20["profile_pic"];
								$fullnm = $rowc20["firstname"]." ".$rowc20["lastname"];
								$uid = $rowc20["users_id"];

								if($image == "")
								{
									$image = "user.png";
								}
								//SELECT DISTINCT sg_chatbox.status,sg_chatbox.sender,cam_users.user_name FROM sg_chatbox INNER JOIN cam_users ON sg_chatbox.sender=cam_users.users_id WHERE `sender` !=18
									?>									
						<div class="category-content no-padding">
							<ul class="media-list media-list-linked" id="status_fuction">
								<li class="media-link">
										<div class="media-left"><img src="../user_images/<?php echo $image; ?>" class="img-circle" alt=""></div>
										<div class="media-body">
								<a href="#james" data-toggle="tab" data-id="<?php echo $uid; ?>" class="user_namelist" >
											<span class="media-heading text-semibold"><?php echo $fullnm; ?></span>
								</a>
<!--											<span class="text-size-small text-muted display-block">Developer</span> -->
										</div>
							            <div class="media-right media-middle">

											<!-- <span class="status-mark bg-success"></span> -->
												<span class="dot" style="background: <?php echo $reciver_color; ?>;margin-top: -10px;width:10px;height: 10px;"></span>
											
										</div> 
								</li>
							</ul>
						</div>
										<?php } } ?>						
						
					</div>
					<!-- /online users -->
				</div>
			</div>
                <div class="content-wrapper">
                   <div class="content">
                     <div class="dropdown pull-right" id="drop">
                     	<span class="dot" style="background: <?php echo $user_color; ?>"></span>
                            <a id="dLabel" role="button" data-toggle="dropdown" data-target="#"  class="btn btn-primary btn-lg active pull-right" href="/page.html"><?php echo $_SESSION['fullname']; ?>
                            
                    	   
                          </a>
                        
                          
                          <ul class="dropdown-menu notifications1" role="menu" aria-labelledby="dLabel">
                            
                           <li class="list-group-item" onclick="getPaging(this.id)" id="1"><a href="#">Available </a><span class="avilable"></span></li>
							    <li class="list-group-item" onclick="getPaging(this.id)" id="2"><a href="#">Away </a><span class="away"></span></li>
							    <li class="list-group-item" onclick="getPaging(this.id)" id="3"><a href="#">Busy </a><span class="logout"></span></li>
                           
                          </ul>
  
                       </div> 

				<div class="tabbable tab-content-bordered content-group-lg">
				
						<ul class="nav nav-tabs nav-lg chat-list1 nav-tabs-highlight">
                            <?php
										$loginid = $_SESSION["id"];
										$sidebar_user_id = $_SESSION['session_user'];
										
                               $query92 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$sidebar_user_id' ");
 								$rowc92 = mysqli_fetch_array($query92);			
								$image = $rowc92["profile_pic"];
								$fullnam = $rowc92["firstname"]." ".$rowc92["lastname"];
								if($image == "")
								{
									$image = "user.png";
								}
                               ?>
							 <li class="active">
								<a href="#james" data-toggle="tab">
									<img src="../user_images/<?php echo $image; ?>" alt="" class="img-circle tab-img position-left"> <?php echo $fullnam; ?>
								</a>

							</li>
	

						</ul>		

					<div class="tab-content">
							<div class="tab-pane fade in active has-padding" id="james">
								<ul class="media-list chat-list content-group">
							
                                        <?php
										$loginid = $_SESSION["id"];
										$sidebar_user_id = $_SESSION['session_user'];
										
                                        $query1 = sprintf("SELECT * FROM  sg_chatbox where sender = '$loginid' AND receiver = '$sidebar_user_id' OR sender = '$sidebar_user_id' AND receiver = '$loginid' ORDER BY createdat asc ;  ");
										$qur1 = mysqli_query($db, $query1);
                                        while ($rowc1 = mysqli_fetch_array($qur1)) {
										$sender1 = $rowc1["sender"];
										$date = $rowc1["createdat"];
										$date1=date_create($date);
										
                               $query2 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$sender1' ");
 								$rowc2 = mysqli_fetch_array($query2);			
								$image = $rowc2["profile_pic"];
								if($image == "")
								{
									$image = "user.png";
								}
									if($sender1 != $loginid){	
									$receiverloginid = $sender1;
									?>									
										
									<li class="media">
										<div class="media-left">
												<img src="../user_images/<?php echo $image; ?>" alt="" class="img-circle" >
										</div>

										<div class="media-body">
											<div class="media-content"><?php echo $rowc1["message"]; ?></div>
											<span class="media-annotation display-block mt-10"><?php echo date_format($date1,"Y/m/d, D, H:i a");?> </span>
										</div>
									</li>
									<?php }else{ ?>
									<li class="media reversed">
										<div class="media-body">
											<div class="media-content"><?php echo $rowc1["message"]; ?></div>
											<span class="media-annotation display-block mt-10"><?php echo date_format($date1,"Y/m/d, D, H:i a"); ?></span>
										</div>

										<div class="media-right">
												<img src="../user_images/<?php echo $image; ?>" alt="" class="img-circle" >
										</div>
									</li>
									<?php } } ?>									
								</ul>
<hr>
<form action="" id="update-form" method="post" class="form-horizontal">
<input type="hidden" id="sender" name="sender" value="<?php echo $loginid; ?>"> 
<input type="hidden" id="receiver" name="receiver" value="<?php echo $receiverloginid; ?>"> 
<input type="hidden" id="flag" name="flag" value="<?php echo $receiverloginid; ?>"> 
                         
		                    	<textarea name="enter-message" class="form-control content-group enter-message" rows="3" cols="1" placeholder="Enter your message..."></textarea>

		                    	<div class="row">
		                    		<div class="col-xs-6">
<!--			                        <ul class="icons-list icons-list-extended mt-10">
			                                <li><a href="#" data-popup="tooltip" title="Send photo" data-container="body"><i class="icon-file-picture"></i></a></li>
			                            	<li><a href="#" data-popup="tooltip" title="Send video" data-container="body"><i class="icon-file-video"></i></a></li>
			                                <li><a href="#" data-popup="tooltip" title="Send file" data-container="body"><i class="icon-file-plus"></i></a></li>
			                            </ul>
-->		                    		</div>

		                    		<div class="col-xs-6 text-right">
                                    <button type="button" class="btn btn-primary" onclick="submitForm('chat_backend.php')"  style="background-color:#1e73be;">Send</button>
		                    		</div>
		                    	</div>
</form>								
							</div>

						</div>


				</div>			

                   </div>
                    <!-- /content area -->
            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->
    </div>

    <!-- /page container -->
	<script>

  $(document).on('click', "#status", function() {
	
	$(".card").show();
	 window.setTimeout(function(){
    $(".card").hide();
     }, 3000);
});


   function getPaging(str) {
   	if(str == 1){
     var status = "Available";
   	}else if(str == 2){
     status = "Away";

   	}else if(str == 3){
     status = "Busy";
   	}
    $.ajax({
		type: 'post',
		dataType : 'json',
		encode   : true,
		cache:false,
		data: {status},
		success: function(response){
		//alert(response);
		var sen = response.sen;
		var rec = response.rec;
        /*$(".dot1").css('background-color','sen');
        $(".dot").css('background-color','rec');*/
		window.setTimeout(function(){
		window.location.href = "chat.php";

		}, 10);



		}
		});
}


	function startTimer() {
     $(".chat-list").load("chat.php .chat-list > *", function(){
          //repeats itself after 1 seconds
          setTimeout(startTimer, 1000);
     });
}
	function startTimer1() {
     $(".chat-list1").load("chat.php .chat-list1 > *", function(){
          //repeats itself after 1 seconds
          setTimeout(startTimer1, 1000);
     });
}
startTimer();
startTimer1();

        function submitForm(url) {
  //          $(':input[type="button"]').prop('disabled', true);
            var data = $("#update-form").serialize();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (data) {
					
					 $("#textarea").val("")
                    // window.location.href = window.location.href + "?aa=Line 1";
 //                   $(':input[type="button"]').prop('disabled', false);
 //                   location.reload();
 $(".enter-message").val("");
                }
            });
        }

        function submitForm2(url) {
  //          $(':input[type="button"]').prop('disabled', true);
            var data = $("#update-form2").serialize();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (data) {
					
//					 $("#textarea").val("")
                    // window.location.href = window.location.href + "?aa=Line 1";
 //                   $(':input[type="button"]').prop('disabled', false);
 //                   location.reload();
 $(".enter-message").val("");
                }
            });
        }
	
	</script>
	<script>
$( ".user_namelist" ).click(function( event ) {
	$(".chat-list").html(" ");
var user_id = $(this).data("id");
//alert(user_id);
$.ajax({
    type : 'POST',
    url : 'chat_div.php',
    data : {
        user_id : user_id
    },
    success : function(data) {
     }
});
});

$( ".use1_namelist" ).click(function( event ) {
	$(".chat-list").html(" ");
var user_id = $(this).data("id");
var chat_id = $(this).attr("value");
//alert(chat_id);
$.ajax({
    type : 'POST',
    url : 'chat_div.php',
    data : {
        user_id : user_id,
        chat_id : chat_id,
    },
    success : function(data) {
    	window.setTimeout(function(){
		window.location.href = "chat.php";

		}, 10);

     }
});
});
 //notification status checking 
                            var data_interval = setInterval(function() {
                                var id =  1;
                                //alert(id);
                                    $.ajax({  
                                        url:"status_count.php",
                                        method:"POST",  
                                        data:{id:id},
                                        dataType : 'json',
                                        encode   : true,
                                        success:function(res) 

                                        { 
                                          /* window.setTimeout(function(){
											window.location.href = "chat.php";

											}, 10);*/
                                          if(res > 0){
                                          	//$("#drop").load("chat.php");
                                            //alert(res.count);
                                             $("#bell_icon").css('color','red');
                                             //$("#bell_icon").css('margin-top','0px');
                                             $("#bell_count").text(res);
                                           
                                          }else{
                                           
                                          }
                                                           
                                        }  
                                   });
                                    }, 1000);

</script>
     <?php include ('../footer.php') ?>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>
