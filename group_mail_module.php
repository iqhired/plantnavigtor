<?php
include("config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
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
	header($redirect_logout_path);
//	header('location: ../logout.php');
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;

$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
    header('location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Plantnavigator Communicator</title>
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
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_select2.js"></script>

        <style>
            .sidebar-default .navigation li>a{color:#f5f5f5};
            a:hover {
                background-color: #20a9cc;
            }
            .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
            }
            .form-control:focus {
                border-color: transparent transparent #1e73be !important;
                -webkit-box-shadow: 0 1px 0 #1e73be;
                box-shadow: 0 1px 0 #1e73be !important;
            }
            .form-control {
                border-color: transparent transparent #1e73be;
                border-radius: 0;
                -webkit-box-shadow: none;
                box-shadow: none;
            }
            @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
                .col-lg-2{
                    width: 35%!important;
                    float: left;
                }

                .col-md-6 {
                    width: 60%;
                    float: left;
                }
                .col-md-1 {
                    width: 5%;
                    float: right;

                }
                .col-md-4 {
                    width: 65%;
                    float: right;
                }


            }
        </style>
    </head>

        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Plantnavigator Communicator";
        include("header.php");

        include("admin_menu.php");
        include("heading_banner.php");
        ?>
        <body class="alt-menu sidebar-noneoverflow">
        <div class="page-container">
                    <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Plantnavigator Communicator</h5>
                                <?php if ($temp == "one") { ?>
                                    <br/><div class="alert alert-success no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold">Group</span> Created Successfully.
                                    </div>
                                <?php } ?>
                                <?php if ($temp == "two") { ?>
                                    <br/><div class="alert alert-success no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold">Group</span> Updated Successfully.
                                    </div>
                                <?php } ?>
                                <?php
                                if (!empty($import_status_message)) {
                                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                                }
                                ?>
                                <?php
                                if (!empty($_SESSION['import_status_message'])) {
                                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                    $_SESSION['message_stauts_class'] = '';
                                    $_SESSION['import_status_message'] = '';
                                }
                                ?>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="smtp_email.php" id="user_form" enctype="multipart/form-data"  class="form-horizontal" method="post">
                                            <div class="row">
                                                <label class="col-lg-2 control-label">To Teams : </label>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="select-border-color" data-placeholder="Add Teams..." name="group[]" id="group" multiple="multiple"  >
                                                            <?php
                                                            $sql1 = "SELECT DISTINCT(`group_id`) FROM `sg_user_group`";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                $station1 = $row1['group_id'];
                                                                $qurtemp = mysqli_query($db, "SELECT * FROM  sg_group where group_id = '$station1' ");
                                                                $rowctemp = mysqli_fetch_array($qurtemp);
                                                                $groupname = $rowctemp["group_name"];
                                                                echo "<option value='" . $row1['group_id'] . "'>" . $groupname . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>	
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="group1()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-2 control-label">To Users : </label>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="select-border-color" data-placeholder="Add Users ..." name="user[]" id="user"  multiple="multiple" >
                                                            <?php
                                                            $sql1 = "SELECT * FROM `cam_users` WHERE `assigned2` = '0'  and `users_id` != '1' order BY `firstname` ";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                echo "<option value='" . $row1['users_id'] . "' >" . $row1['firstname'] . "&nbsp;" . $row1['lastname'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>	
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-primary" style="background-color:#1e73be;" onclick="user1()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-lg-2 control-label" >Subject : </label>
                                                <div class="col-md-6">
                                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject" required>
                                                </div>
                                            </div><br/>
                                            <div class="row">
                                                <!--<div class="col-md-4">-->
                                                <label class="col-lg-2 control-label">Message : </label>
                                                <div class="col-md-6">
                                                    <textarea id="message" name="message" rows="4" placeholder="Enter Message..." class="form-control" ></textarea>
                                                </div>
                                            </div><br/>
                                            <div class="row">
                                                <label class="col-lg-2 control-label">Attachment : </label>
                                                <div class="col-md-4">
                                                    <input type="file" id="image" name="image" class="form-control" >
                                                </div>
                                                <!--<input type="number" name="priority_order" id="priority_order" class="form-control" placeholder="Enter Priority Order" required>-->
                                                <!--</div>-->
                                            </div><br/>
                                            <div class="row">
                                                <label class="col-lg-2 control-label">Signature : </label>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="select-border-color" name="signature" id="signature"  >
                                                            <option value="1" disabled selected>Select Users ...</option> 
                                                            <?php
                                                            $sql1 = "SELECT * FROM `cam_users` WHERE `assigned2` = '0'  and `users_id` != '1' order BY `firstname` ";
                                                            $result1 = $mysqli->query($sql1);
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                $fir = $row1['firstname'];
                                                                $las = $row1['lastname'];
                                                                $ful = $fir . " " . $las;
                                                                echo "<option value='" . $ful . "' >" . $row1['firstname'] . "&nbsp;" . $row1['lastname'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>	
                                                </div>
                                            </div>
                                            <br/>
                                        <div class="panel-footer p_footer">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <form action="delete_sent_mail.php" method="post" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button>
                                </div>
                            </div>						
                            <br/>	
                            <div class="panel panel-flat">
                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" ></th>
                                            <th>S.No</th>
                                            <th>User</th>
                                            <th>Subject</th>
                                            <th>Message / Signature</th>
                                                                             <!--   <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = $_SESSION["role_id"];
                                        if ($i == "super") {
                                            $query = sprintf("SELECT * FROM `sg_sent_mail` ORDER BY `mail_sent_time` DESC");
                                        } else {
                                            $query = sprintf("SELECT * FROM  sg_sent_mail where user_id != '1' and user_id = '$iid' ORDER BY `mail_sent_time` DESC");
                                        }
                                        $qur = mysqli_query($db, $query);
                                        while ($rowc = mysqli_fetch_array($qur)) {
                                            ?> 
                                            <tr>
                                                <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["sg_sent_mail_id"]; ?>"></td>
                                                <td><?php echo ++$counter; ?></td>
                                                <?php
                                                $un = $rowc['user_id'];
                                                $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                                                while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                    $first = $rowc04["firstname"];
                                                    $last = $rowc04["lastname"];
                                                }
                                                ?>
                                                <td><?php echo $first; ?>&nbsp;<?php echo $last; ?></td>
                                                <td><?php echo $rowc['subject']; ?></td>
                                                <td><?php echo $rowc['message']; ?></td>
    <!--                                         <td>
                                       <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['group_id']; ?>" data-name="<?php echo $rowc['name']; ?>"  data-toggle="modal" style="background-color:#1e73be;" data-target="#edit_modal_theme_primary11">Edit </button>
                                       &nbsp; 
                                       <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['role_id']; ?>">Delete </button>
                                       
                                       </td>  -->
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                        </form>

                    <!-- /basic datatable -->
                    <!-- /main charts -->
                    <!-- edit modal -->
                    <div id="edit_modal_theme_primary" class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title">Update Group</h6>
                                </div>
                                <form action="" id="user_form" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Group:*</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="edit_name" id="edit_name" class="form-control" required>
                                                        <input type="hidden" name="edit_id" id="edit_id" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Dashboard content -->
                    <!-- /dashboard content -->
                    <script> $(document).on('click', '#delete', function () {
                            var element = $(this);
                            var del_id = element.attr("data-id");
                            var info = 'id=' + del_id;
                            $.ajax({type: "POST", url: "ajax_role_delete.php", data: info, success: function (data) { }});
                            $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                        });</script>
                    <script>
                        jQuery(document).ready(function ($) {
                            $(document).on('click', '#edit', function () {
                                var element = $(this);
                                var edit_id = element.attr("data-id");
                                var name = $(this).data("name");
                                $("#edit_name").val(name);
                                $("#edit_id").val(edit_id);
                                //alert(role);
                            });
                        });
                    </script>
                    </div>
                </div>
                <!-- /content area -->


    <script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $scriptName; ?>group_mail_module.php");
        }
    </script>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        function group1() {
            $("#group").select2("open");
        }
        function user1() {
            $("#user").select2("open");
        }
    </script>

        <?php include ('footer.php') ?>
     <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>
