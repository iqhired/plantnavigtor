<?php include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: ../logout.php');
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
    header('location: ../dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Update Defect List</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
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
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <style>
        th.sno{
            width: 5%
        }
        th.action {
            width: 15%
        }
        th.p_name {
            width: 60%; /* Not necessary, since only 70% width remains */
        }
        th.d_name{
            width: 20%
        }
        .select2-container{
            outline: 0;
            position: relative;
            display: inline-block;
            text-align: left;
            font-size: 12px;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-md-10{
                width: 72%;
                float: right;
            }
            .col-md-2 control-label{
                width: 26%!important;
            }
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php $cust_cam_page_header = "Defect List";
include("../header_folder.php");
include("../admin_menu.php");
?>

<div class="page-container">

    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <?php
                            $station_event_id = $_GET['station_event_id'];
                            ?>
                            <form action="" id="edit_form_grp" class="form-horizontal" method="post">
                                <div class="modal-body">
                                    <div class="row">
                                        <?php
                                        $query = sprintf("SELECT * FROM  good_bad_pieces where station_event_id = '$station_event_id'");
                                        $qur = mysqli_query($db, $query);
                                        $rowc = mysqli_fetch_array($qur);
                                        ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Defect Name:*</label>
                                                <div class="col-md-10">
                                                    <input type="text" name="edit_grp_name" id="edit_grp_name" class="form-control" value = "<?php echo $rowc['d_group_name']; ?>" required>
                                                    <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $station_event_id; ?>">
                                                    <input type="hidden" name="edit_type" id="edit_type" value="grp">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Part Name:*</label>

                                                <div class="col-md-10">
                                                    <?php
                                                    $query = sprintf("SELECT * FROM `sg_defect_group` where d_group_id = '$id'");
                                                    $qur = mysqli_query($db, $query);
                                                    $rowc = mysqli_fetch_array($qur);
                                                    ?>
                                                    <select required name="edit_part_number[]" id="edit_part_number"  class="select-border-color"
                                                            multiple="multiple">
                                                        <!--                                                        <select name="edit_part_number[]" id="edit_part_number" class="form-control" multiple>-->
                                                        <?php
                                                        $arrteam = explode(',', $rowc["part_number_id"]);
                                                        //                                                            $sql1 = "SELECT * FROM `pm_part_number` order by part_name ASC";
                                                        $sql1 = "SELECT pm_part_number_id ,part_number, part_name , pm_part_family.part_family_name as part_family_name FROM `pm_part_number` inner join pm_part_family on pm_part_number.part_family = pm_part_family.pm_part_family_id order by part_name ASC";
                                                        $result1 = $mysqli->query($sql1);
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if (in_array($row1['pm_part_number_id'], $arrteam)) {
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                            echo "<option id='" . $row1['pm_part_number_id'] . "'  value='" . $row1['pm_part_number_id'] . "' $selected>" . $row1['part_number'] . "  -  " . $row1['part_name'] . "  -  " . $row1['part_family_name'] . "</option>";
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">

                                    <button type="submit" onclick="submitForm_edit_grp('edit_defect_group.php')" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /basic datatable -->
                    <!-- /main charts -->


                    <!-- Dashboard content -->

                    <script>

                        $(document).on('click', '#edit_grp', function () {
                            var element = $(this);
                            var edit_id = element.attr("data-id");
                            var name = $(this).data("name");
                            var type = $(this).data("type");
                            var part_number = $(this).data("part_number");
                            $("#edit_grp_name").val(name);
                            $("#edit_id").val(edit_id);
                            $("#edit_type").val(type);

                            const sb = document.querySelector('#part_number');
                            const sb1 = document.querySelector('#edit_part_number');
                            // create a new option
                            var pnums = part_number.split(',');
                            var options = sb.options;
                            var options1 = sb1.options;
                            // $("#edit_part_number").val(options);
                            $('#edit_modal_theme_primary_grp .select2 .selection .select2-selection--multiple .select2-selection__choice').remove();
                            $('select2-search select2-search--inline').remove();

                            for (var i = 0; i < options1.length; i++) {
                                if(pnums.includes(options1[i].value)){ // EDITED THIS LINE
                                    options1[i].selected="selected";
                                    options1[i].className = ("select2-results__option--highlighted");
                                    var opt = document.getElementById(options1[i].value).outerHTML.split(">");
                                    //  $('#edit_part_number').prop('selectedIndex',i);
                                    $('#select2-results .select2-results__option').prop('selectedIndex',i);
                                    var gg = '<li class="select2-selection__choice" title="' + opt[1].replace('</option','') + '"><span class="select2-selection__choice__remove" role="presentation">×</span>' + opt[1].replace('</option','') + '</li>';
                                    $('#edit_modal_theme_primary_grp .select2-selection__rendered').append(gg);
                                    // $('.select2-search__field').style.visibility='hidden';
                                }
                            }


                            //alert(role);
                        });


                        function submitForm_edit_grp(url) {

                            $(':input[type="button"]').prop('disabled', true);
                            var data = $("#edit_form_grp").serialize();
                            var main_url = "<?php echo $url; ?>";
                            $.ajax({
                                type: 'POST',
                                //url: main_url+url,
                                url: url,
                                data: data,
                                success: function (data) {
                                    // window.location.href = window.location.href + "?aa=Line 1";
                                    $(':input[type="button"]').prop('disabled', false);
                                    location.reload();
                                }
                            });
                        }


                        $('#choose').on('change', function () {
                            var selected_val = this.value;
                            if (selected_val == 1 || selected_val == 2) {
                                $(".group_div").show();
                            } else {
                                $(".group_div").hide();
                            }
                            if (selected_val == 5 ) {
                                $('#delete_form').submit();
                            }
                        });
                    </script>
                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->
    </div>
</div>
<!-- /page container -->
<?php include ('../footer.php') ?>
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>events_module/good_bad_piece.php");
    }
</script>
</body>
</html>

