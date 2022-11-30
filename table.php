<?php
include("config.php");
$temp = "";
if(!isset($_SESSION['user'])){
    header('location: logout.php');
}

$ln = $_POST['radio'];
if($ln == "")
{
//    $ln = "General / Annual";
    $ln = "1";
}

if($_GET['line'])
{
    $ln = $_GET['line'];
    if($ln == "")
    {
//        $ln = "General / Annual";
    $ln = "1";

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Table</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->


    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>

    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>



</head>
<style>
    .content {
        padding: 100px 30px !important;
    }
    @media
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {
        .col-md-3.btn_mob {
            margin-top: 15px;
        }


    }
</style>
<?php  $cust_cam_page_header = "Training Matrix";
include("header.php");
include("admin_menu.php");
include("heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

<!---->
<!--						<h3>	   --><?php
//            $query = sprintf("SELECT DISTINCT `line_id` FROM `cam_user_rating`");
//
//            $qur =  mysqli_query($db,$query);
//            while($rowc = mysqli_fetch_array($qur)){
//
//                ?>
<!--                        <form action="" class="form-validate" method="post">-->
<!--					<input type="radio"  id="radio" name="radio" value="--><?php //echo $rowc['line_name']; ?><!--" required>	--><?php //echo $rowc['line_name']; ?><!--&nbsp;-->
<!---->
<!--	--><?php //} ?>
<!--                            <br/><button type="submit">submit</button></form></h3>-->


<!--<br/> -->
<!--            <div class="panel panel-flat">-->
<!--                <div class="panel-heading text_center">-->
<!--                    <h5>-->
<!--					-->
<!--	<span class="text-semibold">Position </span> - Management				-->
<!---->
<!--                    </h5>	</div>-->
<!--            </div>-->
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-heading">
<div class="row">
<div class="col-md-2">
					<?php
                        $pageno = "";
                        if (isset($_GET['pageno'])) {
                            $pageno = $_GET['pageno'];
                        }
						if($pageno == "") {
                            $pageno = 1;
                        }
                        if (isset($_POST['page'])) {
                            $pageno = $_POST['page'];
                        }
                        $no_of_records_per_page = 1;
                        $offset = ($pageno-1) * $no_of_records_per_page;
                        $total_pages_sql = "SELECT COUNT(DISTINCT `line_id`) as dest FROM `cam_user_rating`";
                        $result = mysqli_query($db,$total_pages_sql);
                        $total_rows = mysqli_fetch_array($result)[0];
                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                        $sql = "SELECT DISTINCT `line_id` FROM cam_user_rating ORDER BY `line_name` LIMIT $offset, $no_of_records_per_page";
                        $res_data = mysqli_query($db,$sql);
                        while($row = mysqli_fetch_array($res_data)){ 
//                      $message = $row['line_name'];
//                      echo "<script type='text/javascript'>alert('$message');</script>";
                        $ln = $row['line_id'];
                        $p = $_POST['radio'];
                        if($p != "")
                        {
	                     $ln = $p;
                        }
						?>
						
                        <form action="" class="form-validate" method="post">
                            <select  name="radio" id="radio" class="select form-control" data-style="bg-slate"  style="float: left;width: initial;" >
                                <option value="" selected disabled>--- Select Station ---</option>
                                <?php
                                $sql1 = "SELECT DISTINCT `line_id` FROM cam_user_rating where is_deleted != 1 ORDER BY `line_name`";
                                $result1 = $mysqli->query($sql1);
                                //                                            $entry = 'selected';
                                $m = 1;
                                while($row1 = $result1->fetch_assoc()){
                                    $lin = $row1['line_id'];
                                    if($lin == $ln)
                                    {
                                        $pageno = $m;
                                        $entry = 'selected';
                                    }
                                    else
                                    {
                                        $entry = '';
                                    }
                                    $station1 = $row1['line_id'];
                                    $qurtemp =  mysqli_query($db,"SELECT * FROM  cam_line where line_id = '$station1' and is_deleted != 1");
                                    $rowctemp = mysqli_fetch_array($qurtemp);
                                    $station = $rowctemp["line_name"];


                                    echo "<option value='".$row1['line_id']."' $entry >".$station."</option>";
                                    $m = $m + 1;
                                }
                                ?>

                            </select>

<!--                            <input type="radio"  id="radio" name="radio" value="<?php echo $row['line_name']; ?>" <?php echo $selected; ?>>	<?php echo $row['line_name']; ?>&nbsp; -->
                            <input type="hidden" name="page" value="<?php echo $pageno; ?>">
                            <?php        }
                            ?> <br/><button type="submit" id="submit" style="display:none;">submit</button>
	</form>
</div>
<!--    <form action="" id="upload_csv" method="post" enctype="multipart/form-data" id="import_form">-->
<!--        <div class="col-md-3 btn_mob">-->
<!--            <input type="file" name="file" />-->
<!--        </div>-->
<!--        <div class="col-md-3 btn_mob">-->
<!--            <input type="submit" class="btn btn-primary" style="background-color:#1e73be;" name="import_data" value="IMPORT">-->
<!--            <a href="export.php" class="btn btn-primary" style="background-color:#1e73be;"><i class="fa fa-download" aria-hidden="true"></i> Export</a>-->
<!--        </div>-->
<!---->
<!--    </form>-->
<div class="col-md-6 btn_mob">
    <form action="" id="upload_csv" method="post" enctype="multipart/form-data" id="import_form">
        <div class="col-md-4">
            <input type="file" name="file" required/>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-primary" style="background-color:#1e73be;" name="import_data" value="IMPORT">
        </div>
    </form>

    <form action="export_table.php" method="post" name="export_excel">
<input type="hidden" name="li" value="<?php echo $ln; ?>">
<button type="submit" class="btn btn-primary " style="background-color:#1e73be;" id="export" name="export"   data-loading-text="Loading...">Export Data</button>
</form>
</div>
<!--
<div class="col-md-2">
<form action="export_all_table.php" method="post" name="export_excel">
<input type="hidden" name="li" value="<?php echo $ln; ?>">
<button type="submit" class="btn btn-primary" style="background-color:#1e73be;" id="export" name="export"   data-loading-text="Loading...">Export All Data</button>
										</form>
</div>
-->

<div class="col-md-4 btn_mob" style="text-align: right;">
                            <ul class="pagination">
                            <li ><a href="?pageno=1" class="btn btn-default btn-raised" style="color: black!important;">&nbsp; First &nbsp;</a></li>
                            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a class="btn btn-default btn-raised" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" style="color: black!important;">&nbsp; Prev &nbsp;</a>
                            </li>
                            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a class="btn btn-default btn-raised" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>" style="color: black!important;">&nbsp; Next &nbsp;</a>
                            </li>
                            <li><a class="btn btn-default btn-raised" href="?pageno=<?php echo $total_pages; ?>" style="color: black!important;">&nbsp; Last &nbsp;</a></li>
                        </ul>
                    </div>
                  </div>
               </div>
            </div>
                   <?php
                  $query = sprintf("SELECT COUNT(DISTINCT `position_id`) as cnt FROM `cam_user_rating` WHERE `line_id` = '$ln'");
                      $qur =  mysqli_query($db,$query);
                      while($rowc = mysqli_fetch_array($qur)){
                       $possitioncnt = $rowc['cnt'];
                  }
                 ?>
            <!-- Content area -->

                <div class="panel panel-flat">
                    <table class="table datatable-basic table-bordered">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Emp Name</th>
                            <th>Hire Date</th>
                            <th>Total Days</th>
                            <th>Job Title</th>
                            <th>Shift</th>
                            <th>Status</th>
                            <?php
                          $qurtemp =  mysqli_query($db,"SELECT * FROM  cam_line where line_id = '$ln' ");
	                      while($rowctemp = mysqli_fetch_array($qurtemp)){
	                    	$station = $rowctemp["line_name"];
			                        }
                           ?>
                            <th colspan="<?php echo $possitioncnt; ?>" style="text-align:center;"><?php echo $station; ?></th>

                        </tr>
                        <tr>
                            <th colspan="7"></th>
                            <?php
                            $query = sprintf("SELECT DISTINCT `position_id` FROM `cam_user_rating` WHERE `line_id` = '$ln'");

                            $qur =  mysqli_query($db,$query);
                            while($rowc = mysqli_fetch_array($qur)){
                                $position1 = $rowc['position_id'];
                                $qurtemp1 =  mysqli_query($db,"SELECT * FROM  cam_position where position_id = '$position1' ");
	                            $rowctemp1 = mysqli_fetch_array($qurtemp1);
		                        $position = $rowctemp1["position_name"];
	                                ?>
                                <th><?php echo $position;
                                    $possarr[] = $rowc['position_id'];
                                    ?></th>

                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = sprintf("SELECT DISTINCT `user_id` FROM `cam_user_rating` WHERE `line_id` = '$ln'");

                        $qur =  mysqli_query($db,$query);
                        while($rowc = mysqli_fetch_array($qur)){

                            ?>

                            <tr>
                                <td><?php echo ++$counter;?></td>
                                <?php
                                $nnm = $rowc["user_id"];
                                $query12 = sprintf("SELECT * FROM  cam_users where users_id = '$nnm'");

                                $qur12 =  mysqli_query($db,$query12);
                                while($rowc12 = mysqli_fetch_array($qur12)){
                                    $hirin_date = $rowc12["hiring_date"];
                                    $totdays = $rowc12["total_days"];
                                    $jobtitledisc = $rowc12["job_title_description"];
                                    $shiftlocation = $rowc12["shift_location"];
									$firstnm = $rowc12["firstname"];
									$lastnm = $rowc12["lastname"];
									$fulllname = $firstnm." ".$lastnm;

                                }
                              $now = time(); // or your date as well
                              $your_date = strtotime($hirin_date);
                              $datediff = $now - $your_date;

								
                                ?>
								<td><?php echo $fulllname;?></td>
                                
                                <td><?php echo  dateReadFormat($hirin_date);?></td>
                                <td><?php echo round($datediff / (60 * 60 * 24));?></td>
                                
                                <td><?php echo $jobtitledisc;?></td>
                                
                                <td><?php echo $shiftlocation;?></td>
                                <td>Active</td>
                                <?php
                                for($i = 0; $i < $possitioncnt;)
                                {
                                    $pn = $possarr[$i];
                                    $query55 = sprintf("SELECT * FROM `cam_user_rating` WHERE `position_id` = '$pn' AND `user_id` = '$nnm' AND `line_id` = '$ln'  ");
                                    $qur55 =  mysqli_query($db,$query55);
                                    while($rowc55 = mysqli_fetch_array($qur55)){
                                        $rrting = $rowc55["ratings"];
                                    }
									if($rrting == ""){ $rrting = "-"; }
                                    ?>
                                    <td><?php echo $rrting;
                                        $rrting = "";
                                        ?></td>

                                    <?php $i++; } ?>

                            </tr>
                        <?php }?>

                        </tbody>
                    </table>
                </div>


        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

<!-- /page container -->
<script>
    $(document).ready(function (){
        $('#upload_csv').on('submit',function (e){
            e.preventDefault();
            $.ajax({
                url:"import_training_matrix.php",
                method:"POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success:function (data){
                    // console.log(data);
                    alert('done');
                    location.reload();

                }
            });
        });
    });
</script>
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>table.php");
    }
//    var $selectAll = $( "input:radio[name=radio]" );
    $('#radio').on( "change", function() {

        console.log( "selectAll: " + $(this).val() );
        // or
        //alert( "selectAll: " + $(this).val() );
        $("#submit").trigger("click");
    });
</script>
    <?php include('../footer.php') ?>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>