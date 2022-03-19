<?php
include("../config.php");
if(!empty($_POST)){
 
//echo "<pre>";print_r($_POST);
  $notes = $_POST['notes'];
  $date_of_measurement = $_POST['date_of_measurement'];
  $part = $_POST['part'];
  $messurment_schema = $_POST['messurment_schema'];
  $work_order_or_lot = $_POST['work_order_or_lot'];
  $length_part_1 = $_POST['length_part_1'];
  $length_part_2 = $_POST['length_part_2'];
  $length_part_3 = $_POST['length_part_3'];
  $length_part_4 = $_POST['length_part_4'];
  $length_part_5 = $_POST['length_part_5'];
  $avg_all_4_parts_length = $_POST['avg_all_4_parts_length'];
  $range_of_4_parts_S8mm = $_POST['range_of_4_parts_S8mm'];
  $raw_materials = $_POST['raw_materials'];
  $mylar_specifications = $_POST['mylar_specifications'];
  $paramete_notes = $_POST['paramete_notes'];
  $part_id = $_POST['part_id'];
  $vent_holes = $_POST['vent_holes'];

  $insertQ1 = "INSERT INTO `messurment_ex1_faa_release_table_input`( `notes`, `date_of_measurement`, `part`, `messurment_schema`, `work_order_or_lot`, `length_part_1`, `length_part_2`, `length_part_3`, `length_part_4`, `length_part_5`, `avg_all_4_parts_length`, `range_of_4_parts_S8mm`, `raw_materials`, `mylar_specifications`, `paramete_notes`, `part_id`, `vent_holes`) VALUES  ('$notes','$date_of_measurement','$part','$messurment_schema','$work_order_or_lot','$length_part_1','$length_part_2','$length_part_3','$length_part_4','$length_part_5','$avg_all_4_parts_length','$range_of_4_parts_S8mm','$raw_materials','$mylar_specifications','$paramete_notes','$part_id','$vent_holes')";

$result1 = mysqli_query($db, $insertQ1);

$msg = '';
if($result1 == 1){
   $msg = "success";

}else{
   $msg = "failed";
}

exit(json_encode($msg));
//echo "<pre>";print_r($insertQ1);

}


//echo "<pre>";print_r($insertQ1);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | CREATE SCHEMA</title>
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
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
       <!--  <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script> -->
        <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
        <style type="text/css">
          .form-control {
    /* padding-left: 0; */
    /* padding-right: 0; */
    border-width: 1px 0;
    border-color: transparent transparent #0e0e0e;
    border-radius: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.row-head{
  background:#bbb6b6;
}
        </style>
    </head>
    <body>
        <!-- Main navbar -->
        <?php
        $cam_page_header = "CREATE SCHEMA";
        include("../header_folder.php");
        ?>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main navigation -->
                <?php include("../admin_menu.php"); ?>
                <!-- /main navigation -->
                <!-- Main content -->
                <div class="content-wrapper">
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">EX1 FAA Release - Table Input - X </h5>
                                <hr/>

                             <form name="add_name" id="messurment" action="" method="post">
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Notes</label>
                  <div class="col-sm-6">
                    <textarea class="form-control" aria-label="With textarea" id="notes"name="notes"  autocomplete="off"></textarea>
                  </div>
                </div>  
                 <br>
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label" >Date of Measurement*</label>
                  <div class="col-sm-6">
                   <input type="date" name="date_of_measurement" id="date_of_measurement" class="form-control" required>
                  </div>
                </div>
              </br>
          
           
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Part*</label>
                  <div class="col-sm-6">
                   <select name="part" id="part" class="form-control">
                    <option value="" >--- Select Part ---</option> 
                    <?php
                    $sql1 = "SELECT * FROM `pm_part_number`";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        echo "<option value='" . $row1['part_number'] . "'>" . $row1['part_number'] . "</option>";
                    }
                    ?>
                  </select>
                  </div>

                </div>
                 </br>
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Measurement Schema*</label>
                  <div class="col-sm-6">
                    <select name="messurment_schema" id="messurment_schema" class="form-control">
                    <option value="" >--- Select Measurement Schema ---</option>
                  <?php
                    $sql1 = "SELECT * FROM `messurment_schema`";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        echo "<option value='" . $row1['messurment_schema_name'] . "'>" . $row1['messurment_schema_name'] . "</option>";
                    }
                    ?>
                  </select>
                  </div>

                </div>
             
                <br> 
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Work Order/Lot*</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="work_order_or_lot" id="work_order_or_lot"  autocomplete="off">
                  </div>

                </div>
             
                <br> 

                <div class="mb-10 row-head">
                  <h5> Overall Length' (Measure and record (4) parts for overall length at First Piece and (1) part every 2 hours after that. At Startup: Measure 4 parts and calculate the average. If the range of the 4 parts is 58rnm and the average is within ±3mm of the nominal, the parts are acceptable. If not, saw should be adjusted and process begins again. Write average. G05/07 TV (Front) 3657±10mm</h5>
                  

                </div>
             
                <br>
             
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label"> Length for Part 1: *</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="length_part_1" id="length_part_1"  autocomplete="off">
                  </div>mm

                </div>
             
                <br> 
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label"> Length for Part 2: *</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="length_part_2" id="length_part_2"  autocomplete="off">
                  </div>mm

                </div>
             
                <br> 
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label"> Length for Part 3: *</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="length_part_3" id="length_part_3"  autocomplete="off">
                  </div>mm

                </div>
             
                <br> 
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label"> Length for Part 4: *</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="length_part_4" id="length_part_4"  autocomplete="off">
                  </div>mm

                </div>
             
                <br> 
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label"> Length for Part 5: *</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="length_part_5" id="length_part_5"  autocomplete="off">
                  </div>mm

                </div>
             
                <br> 
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label"> Average for all 4 part lengths:*</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="avg_all_4_parts_length" id="avg_all_4_parts_length"  autocomplete="off">
                  </div>mm

                </div>
             
                <br> 
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Range of 4 parts is S8mm and the average is within ±3mm of the nominal?*</label>
                  <div class="col-sm-6">
                     <input class="form-check-input yes" type="radio" name="range_of_4_parts_S8mm" id="range_of_4_parts_S8mm" value="pass">
                <label class="form-check-label" for="inlineRadio1">Pass</label>&nbsp;

                 <input class="form-check-input no" type="radio" name="range_of_4_parts_S8mm" id="range_of_4_parts_S8mm" value="fail">
                <label class="form-check-label" for="inlineRadio1">Fail</label>&nbsp;
                  </div>

                </div>
             
                <br> 
                  <div class="mb-10 row-head">
                  <h5> Raw Materials</h5>
                  

                </div>
             
                <br>
                   <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Bill of Materials*</label>
                  <div class="col-sm-6">
                     <input class="form-check-input yes" type="radio" name="raw_materials" id="raw_materials" value="pass">
                <label class="form-check-label" for="inlineRadio1">Pass</label>&nbsp;

                 <input class="form-check-input no" type="radio" name="raw_materials" id="raw_materials" value="fail">
                <label class="form-check-label" for="inlineRadio1">Fail</label>&nbsp;
                  </div>

                </div>
             
                <br> 
                <div class="mb-10 row-head">
                  <h5> Section meets mylar specifications</h5>
                </div>
             
                <br>
                  <div class="mb-10 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">A points referenced on mylar (10x) E06568.P *</label>
                  <div class="col-sm-6">
                     <input class="form-check-input yes" type="radio" name="mylar_specifications" id="mylar_specifications" value="pass">
                <label class="form-check-label" for="inlineRadio1">Pass</label>&nbsp;

                 <input class="form-check-input no" type="radio" name="mylar_specifications" id="mylar_specifications" value="fail">
                <label class="form-check-label" for="inlineRadio1">Fail</label>&nbsp;
                  </div>

                </div>
             
                <br> 
                 <div class="mb-10 row-head">
                  <h5> Process Parameters</h5>
                </div>
             
                <br>
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Parameter Sheet: Type Pass or Fail below *</label>
                  <div class="col-sm-6">
                    <textarea class="form-control" aria-label="With textarea" id="paramete_notes"name="paramete_notes"  autocomplete="off"></textarea>
                  </div>
                </div>  
                 <br>
                   <div class="mb-10 row-head">
                  <h5> Part ID</h5>
                </div>
             
                <br>
                  <div class="mb-10 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">A points referenced on mylar (10x) E06568.P *</label>
                  <div class="col-sm-6">
                     <input class="form-check-input yes" type="radio" name="part_id" id="part_id" value="pass">
                <label class="form-check-label" for="inlineRadio1">Pass</label>&nbsp;

                 <input class="form-check-input no" type="radio" name="part_id" id="part_id" value="fail">
                <label class="form-check-label" for="inlineRadio1">Fail</label>&nbsp;
                  </div>

                </div>
             
                <br> 
                  <div class="mb-10 row-head">
                  <h5> Vent Holes</h5>
                </div>
             
                <br>
                  <div class="mb-10 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">(G05/07 - Front Door) BMW 7428678-07 >EPD•+Afu USPL DD.MNLYY / HH.N1M DA11805.S Nlinimum 2x per part* </label>
                  <div class="col-sm-6">
                     <input class="form-check-input yes" type="radio" name="vent_holes" id="vent_holes_pass" value="pass">
                <label class="form-check-label" for="inlineRadio1">Pass</label>&nbsp;

                 <input class="form-check-input no" type="radio" name="vent_holes" id="vent_holes_fail" value="fail">
                <label class="form-check-label" for="inlineRadio1">Fail</label>&nbsp;
                  </div>

                </div>
             
                <br> 
                  <div class="mb-10 row-head">
                  <h5> Pull Cord</h5>
                </div>
             
                <br>
              <div class="mb-3 pull-right"> 
                
              <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />  
                </div>
             </form>
                                <br/>
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
 $(document).ready(function(){ 


    $('#submit').click(function(){
   
         var data = $('#messurment').serialize(); 

   

if($('#notes').val() ==  '' || $('#date_of_measurement').val() ==  '' ||$('#part').val() ==  '' ||$('#messurment_schema').val() ==  '' ||$('#work_order_or_lot').val() ==  '' ||$('#length_part_1').val() ==  '' ||$('#length_part_2').val() ==  '' ||$('#length_part_3').val() ==  '' ||$('#length_part_4').val() ==  '' ||$('#length_part_5').val() ==  '' ||$('#avg_all_4_parts_length').val() ==  '' ||$('#paramete_notes').val() ==  ''){
  alert("Please Check All Input Field ");

}else if (!$("input[name='vent_holes']:checked").val() ||!$("input[name='part_id']:checked").val() ||!$("input[name='mylar_specifications']:checked").val() ||!$("input[name='raw_materials']:checked").val() ||!$("input[name='range_of_4_parts_S8mm']:checked").val() ) {
       alert('Please Check All Radio Buttons');
        return false;
    }
else{

   $.ajax({  
                url:"schema1.php",  
                method:"POST",  
                data:data,
                dataType : 'json',
                encode   : true,
                success:function(res)  

                { 
                  if(res == 'success'){
                    alert('Successfully Created...');
                     window.setTimeout(function(){
                       location.reload();

                      }, 2000);
                  }else{
                    alert('Something went wrong!...');
                  }
                                   
                }  
           }); 

}
     

});


 });  
 </script>
        <?php include ('../footer.php') ?>
    </body>
</html>
