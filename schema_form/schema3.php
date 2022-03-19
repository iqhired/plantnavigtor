<?php
include("../config.php");
if(!empty($_POST)){
 
//echo "<pre>";print_r($_POST);
 $name = $_POST['name'];
 $messurment_schema = $_POST['messurment_schema'];
 $chanel = $_POST['chanel'];
 $user_defined_qst = $_POST['user_defined_qst'];
 $image = $_POST['image'];
 $always_needs_approval = $_POST['opt'];
 $out_of_tolerance_mailing_list = $_POST['out_of_tolerance_mailing_list'];
 $out_of_control_limit_mailing_list = $_POST['out_of_control_limit_mailing_list'];
 $notes = $_POST['notes'];
 $valid_from = $_POST['valid_from'];
 $valid_to = $_POST['valid_to'];
 $name = $_POST['name'];


 $insertQ1 = "INSERT INTO `messurment_schema_new`( `name`, `messurment_schema`, `chanel`, `part`, `user_defined_qst`, `image`, `always_needs_approval`, `out_of_tolerance_mailing_list`, `out_of_control_limit_mailing_list`, `notes`, `valid_from`, `valid_to`) VALUES ('$name','$messurment_schema','$chanel','$part','$user_defined_qst','$image','$always_needs_approval','$out_of_tolerance_mailing_list','$out_of_control_limit_mailing_list','$notes','$valid_from','$valid_from')";
 

$result1 = mysqli_query($db, $insertQ1);

$msg = '';
if($result1 == 1){
   $msg = "success";

}else{
   $msg = "failed";
}

exit(json_encode($msg));


}


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
       
        <?php
        $cam_page_header = "CREATE SCHEMA";
        include("../header_folder.php");
        ?>

        <div class="page-container">
          
            <div class="page-content">
               
                <?php include("../admin_menu.php"); ?>

                <div class="content-wrapper">
                    <div class="content">
                        
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">New Measurment Schema</h5>
                                <hr/>

                             <form name="add_name" id="messurment" action="" method="post">
           
          
           
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Name</label>
                  <div class="col-sm-6">
                   <input type="text" class="form-control" name="name" id="name"  autocomplete="off">
                  </div>

                </div>
                 </br> 

                  
                 
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Measurement Schema Type</label>
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
                  <label for="inputPassword" class="col-sm-6 col-form-label">Chanel</label>
                  <div class="col-sm-6">
                   <select name="chanel" id="chanel" class="form-control">
                    <option value="" >--- Select Chanel ---</option> 
                     <?php
                    $sql1 = "SELECT * FROM `cam_line`";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        echo "<option value='" . $row1['line_name'] . "'>" . $row1['line_name'] . "</option>";
                    }
                    ?>
                  </select>
                  </div>

                </div>
                 </br> 
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Part</label>
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
                  <label for="inputPassword" class="col-sm-6 col-form-label">User-defined Question</label>
                  <div class="col-sm-6">
                    <select name="user_defined_qst" id="user_defined_qst" class="form-control">
                    <option value="" >--- Select Qstion ---</option> 
                    <?php
                    $sql1 = "SELECT * FROM `measurement_ex2_mach_e03998`";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        echo "<option value='" . $row1['user_defined_qst'] . "'>" . $row1['user_defined_qst'] . "</option>";
                    }
                    ?>
                  </select>
                  </div>

                </div>
             
                <br>
                   <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Image</label>
                  <div class="col-sm-6">
                       <input class="form-check-input yes" type="radio" name="image" id="image" value="none">
                      <label class="form-check-label" for="inlineRadio1">None</label>&nbsp;

                       <input class="form-check-input no" type="radio" name="image" id="image" value="upload_file">
                      <label class="form-check-label" for="inlineRadio1">Upload File</label>&nbsp;
                  </div>

                </div>
             
                <br> 
                  <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-6 col-form-label">Always Needs Approval</label>
                    <div class="col-sm-6">
                       <input class="form-check-input" name="always_needs_approval" type="checkbox" id="always_needs_approval" value="" >
                    </div>

                  </div>
             
                <br> 
                
               
              
                 </br> 
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Out-Of-Tolerance Mailing List </label>
                  <div class="col-sm-6">
                   <select name="out_of_tolerance_mailing_list" id="out_of_tolerance_mailing_list" class="form-control">
                    <option value="" >--- Select Option ---</option> 
                    <?php
                    $sql1 = "SELECT * FROM `measurement_ex2_mach_e03998`";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        echo "<option value='" . $row1['out_of_tolerance_mailing_list'] . "'>" . $row1['out_of_tolerance_mailing_list'] . "</option>";
                    }
                    ?>
                  </select>
                  </div>

                </div>
                 </br>
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label"> Out-Of-Control-Limit Mailing List</label>
               
                     <div class="col-sm-6">
                   <select name="out_of_control_limit_mailing_list" id="out_of_control_limit_mailing_list" class="form-control">
                    <option value="" >--- Select Option ---</option> 
                    <?php
                    $sql1 = "SELECT * FROM `measurement_ex2_mach_e03998`";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        echo "<option value='" . $row1['out_of_control_limit_mailing_list'] . "'>" . $row1['out_of_control_limit_mailing_list'] . "</option>";
                    }
                    ?>
                  </select>
                  </div>
               

                </div>
             
                <br> 
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Notes</label>
                  <div class="col-sm-6">
                    <textarea class="form-control" aria-label="With textarea" id="notes"name="notes"  autocomplete="off"></textarea>
                  </div>
                </div>  
                 <br>
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label" >Valid From</label>
                  <div class="col-sm-6">
                   <input type="date" name="valid_from" id="valid_from" class="form-control" required>
                  </div>
                </div>
              </br> 
              <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label" >Valid Till</label>
                  <div class="col-sm-6">
                   <input type="date" name="valid_to" id="valid_to" class="form-control" required>
                  </div>
                </div>
              </br>
                
             
               
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


    $(document).on('click', '#submit', function(){ 
     if($('#always_needs_approval').prop("checked") == true){
                opt = 1;
               
            }
            else if($('#optional').prop("checked") == false){
                opt = 0;
               
            }else{
              opt = '';
            }
   
            var data = $('#messurment').serialize(); 
            //var form_data = new FormData($('form')[0]);
          
                $.ajax({  
                url:"schema3.php",  
                method:"POST",  
                dataType : 'json',
                encode   : true,
                data:data + "&opt=" + opt,
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
  
     

});


 });  
 </script>
        <?php include ('../footer.php') ?>
    </body>
</html>
