<?php
include("../config.php");
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
//$message = $_SESSION['myVar'];
//echo "<script type='text/javascript'>alert('$message');</script>";

//if($_SESSION['user'] != "admin"){
//	header('location: dashboard.php');
//}
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}
if (count($_POST) > 0) {
    $edit_id = $_POST['edit_id'];

    if ($edit_id == "") {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $side_menu1 = $_POST['menu_value'];
        foreach ($side_menu1 as $side_menu) {
            $array_side_menu .= $side_menu . ",";
        }
        $sqlquery = "INSERT INTO `cam_role`(`role_name`,`type`,`side_menu`,`created_at`,`updated_at`) VALUES ('$name','$type','$array_side_menu','$chicagotime','$chicagotime')";
        if (!mysqli_query($db, $sqlquery)) {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Role with this Name Already Exists';
        } else {
            $temp = "one";
        }
    }
    else{
        $id = $_POST['edit_id'];
        $old_value = $_POST['old_value'];
        $side_menu1 = $_POST['menu_value'];
        //$array_side_menu = $old_value;



        $array_side_menu = '';
        foreach ($side_menu1 as $side_menu) {
            $array_side_menu .= $side_menu . ",";
        }
//		$array_side_menu = $old_value.$array_side_menu;
        $sql = "update cam_role set role_name='$_POST[name]',type='$_POST[type]',side_menu='$array_side_menu',updated_at='$chicagotime' where role_id='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $temp = "two";
        } else {
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Role with this Name Already Exists';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Role</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <!-- Core JS files -->
        <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
        <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <style>
            .sidebar-default .navigation li>a{color:#f5f5f5};
            a:hover {
                background-color: #20a9cc;
            }
            .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
                background-color: #20a9cc;
            }
			.red{
				color:red;
			}
            .panel-title {
                margin-top: 25px;
                font-size: 15px;
            }
            @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
                .col-lg-4{
                    width: 45%!important;
                }
                .col-lg-8{
                    width: 55%!important;
                }
                .col-md-4 {
                    width: 25%;
                    margin-top: 58px;
                }

            }
            .row {
                margin-top: 15px;
            }
        </style>
    </head>
    <body>
        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Add/Update User Role(s)";
        include("../header_folder.php");
        include("../admin_menu.php");
        include("../heading_banner.php");
        ?>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">

                    <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Role List</h5>
                                <hr/>
                               <form action="" id="user_form" class="form-horizontal" method="post">

                                    <div class="col-md-12">

                                                <div class="col-md-3">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Role">
                                                        <input type="hidden" name="edit_id" id="edit_id" >
                                                       <input type="hidden" name="old_value" id="old_value" >
						        	<div id="error2" class="red" style="display:none">Please Enter Role</div>

                                        </div>
                                        <!--<div class="col-md-4">-->
                                        <div class="col-md-2">
                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">Type : </label>
                                            <select  name="type" id="type" class="form-control" style="float: left; width: initial;" >
                                                <!--        <option value="" selected disabled>--- Select Ratings ---</option>-->
                                                <option value="user" >User</option>
                                                <option value="pn_user" >PN User</option>
                                                <option value="admin" >Admin</option>
                                            </select>
                                        </div><!--<input type="number" name="priority_order" id="priority_order" class="form-control" placeholder="Enter Priority Order" required>-->
                                        <!--</div>-->
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary create" style="background-color:#1e73be;">Create Role</button>
                                            <button type="submit" class="btn btn-primary update" style="background-color:#1e73be;display:none;" >Update Role</button>
                                        </div>

                                    </div>


                        <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5 class="panel-title">Select Modules for Access & Permission</h5>
<!--                                        <div id="error1" class="red" style="display:none;color:red;">Please select Module</div>-->



                                        <div class="row">
                                            <div id="error1" class="red" style="display:none;color:red;">Please select Module</div>
                                            <?php
                                            $query12 = sprintf("SELECT * FROM  side_menu where side_menu_id != '1' and parent_id = '0' and enabled = '1'  order by menu_name ASC");
                                            $qur12 = mysqli_query($db, $query12);
                                            while ($rowc12 = mysqli_fetch_array($qur12)) {
                                                $parentid = $rowc12["side_menu_id"];

                                                ?>
                                                <div class="col-md-2 rmchk">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="control-primary chk_menu" name="menu_value[]" id="<?php echo $parentid; ?>" value="<?php echo $rowc12["side_menu_id"]; ?>" >
                                                            <?php echo $rowc12["menu_name"]; ?>
                                                        </label>
                                                    </div>
                                                </div>

                                                <?php
                                                $query121 = sprintf("SELECT * FROM  side_menu where parent_id = '$parentid' and enabled = '1'  order by menu_name ASC");
                                                $qur121 = mysqli_query($db, $query121);
                                                while ($rowc121 = mysqli_fetch_array($qur121)) {
                                                    ?>
                                                    <div class="col-md-2 cl<?php echo $parentid; ?> rmchk" id="<?php echo $parentid; ?>" style="display:none;">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="control-danger chk_menu " name="menu_value[]" id="<?php echo $rowc121["side_menu_id"]; ?>" value="<?php echo $rowc121["side_menu_id"]; ?>" >
                                                                <?php echo $rowc121["menu_name"]; ?>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <?php


                                                }

                                                ?>
                                                <?php
                                            }
                                            ?>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>


                        <?php if ($temp == "one") { ?>
                            <br/>					<div class="alert alert-success no-border">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                <span class="text-semibold">Role</span> Created Successfully.
                            </div>
                        <?php } ?>
                        <?php if ($temp == "two") { ?>
                            <br/>					<div class="alert alert-success no-border">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                <span class="text-semibold">Role</span> Updated Successfully.
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
                    </div>
                </div>
                <form action="delete_role_list.php" method="post" class="form-horizontal">
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
                                <th>Role</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = sprintf("SELECT * FROM  cam_role where role_id != '1' AND is_deleted !='1'");
                            $qur = mysqli_query($db, $query);
                            while ($rowc = mysqli_fetch_array($qur)) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["role_id"]; ?>"></td>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php echo $rowc["role_name"]; ?></td>
                                    <td><?php echo $rowc['type']; ?></td>
                                    <td>
                                        <button type="button" id="edit" class="btn btn-info btn-xs" data-id="<?php echo $rowc['role_id']; ?>" data-side_menu="<?php echo $rowc['side_menu']; ?>" data-name="<?php echo $rowc['role_name']; ?>" data-type="<?php echo $rowc['type']; ?>"   style="background-color:#1e73be;" >Edit </button>
                                        <!--									&nbsp;
                                                                                                                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['role_id']; ?>">Delete </button>
                                                    -->
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                </form>
            </div>
            <!-- /basic datatable -->
            <!-- /main charts -->
            <div id="modal_theme_primary1" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">Create Role</h6>
                        </div>
                        <form action="" id="user_form" class="form-horizontal" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Role:*</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="name" id="name" class="form-control">
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
            <!-- edit modal -->
            <div id="edit_modal_theme_primary" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">Update Role</h6>
                        </div>
                        <form action="" id="user_form" class="form-horizontal" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Role:*</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="edit_name" id="edit_name" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php


                                $sql1 = "SELECT * FROM `side_menu` where side_menu_id !='1' and enabled = '1' order by menu_name ASC";
                                $result1 = $mysqli->query($sql1);


                                ?>
                                <div class="row">
                                    <label class="col-lg-3 control-label">Side Menu : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="select-border-color" data-placeholder="Select Side Menu..."  name="edit_side_menu" id="edit_side_menu" multiple="multiple"  >
                                                <?php
                                                //$bansi = "hello";
                                                //$arrteam = explode(',', );
                                                $sql1 = "SELECT * FROM `side_menu` where side_menu_id !='1' and enabled = '1' order by menu_name ASC";
                                                $result1 = $mysqli->query($sql1);

                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if (in_array($row1['side_menu_id'], $arrteam)) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    echo "<option value='" . $row1['side_menu_id'] . "' $selected>" . $row1['menu_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
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
                        $('input:checkbox').removeAttr('checked');
                        var rmchk = "rmchk span";
                        //		console.log(abc);
                        //$(".cl"+value_c).hide();
                        //     $(".cl"+value_c).find('input:checkbox:first').prop('checked', false);
                        //  $(".cl"+value_c).prop('checked', false);
                        $('.'+ rmchk).removeClass();
                        var element = $(this);
                        var edit_id = element.attr("data-id");
                        var name = $(this).data("name");
                        var type = $(this).data("type");
                        var side_menu = $(this).data("side_menu");
                        $("#name").val(name);
                        $("#type").val(type);
                        $("#edit_id").val(edit_id);
                        $("#old_value").val(side_menu);
                        //$("#edit_side_menu").val(side_menu);
                        $(".create").hide();
                        $(".update").show();

                        var arrval = side_menu.split(',');
                        //alert(arrval[0]);
                        //alert(arrval.length);
                        var length = arrval.length;
                        for (var i = 0; i <= length; i++)
                        {
                            var value_c = arrval[i];
                            $(".cl"+value_c).show();
                            $('#'+value_c).trigger('click');

                            $('#'+value_c).attr('checked', 'checked');
                            $('#'+value_c).parent('span').addClass("checked");
                        }
                    });
                });
            </script>

        </div>
        <!-- /content area -->
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->
</div>
<!-- /page container -->
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
                    $('input:checkbox').removeAttr('checked');
                    var rmchk = "rmchk span";
                    //		console.log(abc);
                    //$(".cl"+value_c).hide();
                    //     $(".cl"+value_c).find('input:checkbox:first').prop('checked', false);
                    //  $(".cl"+value_c).prop('checked', false);
                    $('.'+ rmchk).removeClass();
                    var element = $(this);
                    var edit_id = element.attr("data-id");
                    var name = $(this).data("name");
                    var type = $(this).data("type");
                    var side_menu = $(this).data("side_menu");
                    $("#name").val(name);
                    $("#type").val(type);
                    $("#edit_id").val(edit_id);
                    $("#old_value").val(side_menu);
                    //$("#edit_side_menu").val(side_menu);
                    $(".create").hide();
                    $(".update").show();

                    var arrval = side_menu.split(',');
                    //alert(arrval[0]);
                    //alert(arrval.length);
                    var length = arrval.length;
                    for (var i = 0; i <= length; i++)
                    {
                        var value_c = arrval[i];
                        $(".cl"+value_c).show();
                        $('#'+value_c).trigger('click');

                        $('#'+value_c).attr('checked', 'checked');
                        $('#'+value_c).parent('span').addClass("checked");
                    }
                });
            });
        </script>

        </div>
        <!-- /content area -->
        </div>
        <!-- /main content -->
        </div>
        <!-- /page content -->
        </div>
        <!-- /page container -->
        <script>
            window.onload = function() {
                $(".control-primary").uniform({
                    radioClass: 'choice',
                    wrapperClass: 'border-primary-600 text-primary-800'
                });
                $(".control-danger").uniform({
                    radioClass: 'choice',
                    wrapperClass: 'border-danger-600 text-danger-800'
                });
                history.replaceState("", "", "<?php echo $scriptName; ?>user_module/role_list.php");
            }
        </script>
        <script>
            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });


        </script>
        <script>
            $('button[type="submit"]').on('click', function() {
                var flag = 0;
                if($("#name").val().length > 0){

                    $("#error2").hide();

                }else{
                    var flag = 1;
                    $("#error2").show();


                }
                // skipping validation part mentioned above
                //if($('.chk_menu:checkbox:checked').length > 0){
                if($('.checked').length > 0){

                    $("#error1").hide();
                }else{
                    var flag = 1;
                    $("#error1").show();
                }

                if(flag == 0){
                    return true;
                }
                else{
                    return false;
                }

            });
            $(".chk_menu").click(function() {
                var value_c =   $(this).val();
                if($(this).prop("checked") == true){

                    $(".cl"+value_c).show();

                } else {
                    var abc = "cl" +value_c+" span";
                    //		console.log(abc);
                    $(".cl"+value_c).hide();
                    $(".cl"+value_c).find('input:checkbox:first').prop('checked', false);
                    //  $(".cl"+value_c).prop('checked', false);
                    $('.'+ abc).removeClass();

                }
            });


        </script>

<?php include ('../footer.php') ?>
</body>
</html>
