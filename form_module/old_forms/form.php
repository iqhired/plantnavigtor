<?php
include("../config.php");
if(!empty($_POST)){
//echo "<pre>";print_r($_POST);


  $name = $_POST['name'];
  $messurment_schema = $_POST['messurment_schema'];
  $chanel = $_POST['chanel'];
  $part = $_POST['part'];
  $security_zone = $_POST['security_zone'];
  $user_defined_qst = $_POST['user_defined_qst'];
  $always_needs_approval = $_POST['always_needs_approval'];
  $out_of_tolerance_mailing_list = $_POST['out_of_tolerance_mailing_list'];
  $out_of_control_limit_mailing_list = $_POST['out_of_control_limit_mailing_list'];
  $notes = $_POST['notes'];
  $valid_from = $_POST['valid_from'];
  
  $valid_to = $_POST['valid_to'];
  $assigned_data_collection_points = $_POST['assigned_data_collection_points']; 
  $measurement_items = implode(', ', $_POST['measurement_items']);
  $measurement__shedule_items = implode(', ', $_POST['measurement__shedule_items']);
  $approval_by = $_POST['approval_by'];
  $created_on = $_POST['created_on'];
  $created_by = $_POST['created_by'];
  $modified_on = $_POST['modified_on'];
  $modified_by = $_POST['modified_by'];

 //single image file inputs

 $validator = $_FILES['image']['name'];
        if ($validator != "") {
            if (isset($_FILES['image'])) {
                $errors = array();
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp =  $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $file_ext = strtolower(end(explode('.', $file_name)));
                $extensions = array("jpeg", "jpg", "png", "pdf");
                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Extension not allowed, please choose a JPEG or PNG file.';
                }
                if ($file_size > 2097152) {
                    $errors[] = 'File size must be excately 2 MB';
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: File size must be excately 2 MB';
                }
                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, "schema2_images/" . $file_name);
                  }
              }
            }


//dynamic upload files

// Count # of uploaded files in array
$total = count($_FILES['uploads']['name']);

// Loop through each file

for( $i=0 ; $i < $total ; $i++ ) {

     $tmpFilePath = $_FILES['uploads']['tmp_name'][$i];

 
     if ($tmpFilePath != ""){
  
    $newFilePath = "schema2_uploads/" . $_FILES['uploads']['name'][$i];

 
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {

     

    }
  }
}
  $uploads = implode(', ', $_FILES['uploads']['name']);
$insertQ1 = "INSERT INTO `measurement_ex2_mach_e03998`( `name`, `messurment_schema`, `chanel`, `part`, `security_zone`, `user_defined_qst`, `always_needs_approval`, `out_of_tolerance_mailing_list`, `out_of_control_limit_mailing_list`, `notes`, `valid_from`, `valid_to`, `assigned_data_collection_points`, `measurement_items`, `measurement__shedule_items`, `approval_by`, `created_on`, `modified_on`, `created_by`, `modified_by`, `image`, `uploads`) VALUES ('$name','$messurment_schema','$chanel','$part','$security_zone','$user_defined_qst','$always_needs_approval','$out_of_tolerance_mailing_list','$out_of_control_limit_mailing_list','$notes','$valid_from','$valid_to','$assigned_data_collection_points','$measurement_items','$measurement__shedule_items','$approval_by','$created_on','$modified_on','$created_by','$modified_by','$file_name','$uploads')";
$result1 = mysqli_query($db, $insertQ1);

//$msg = '';
if($result1 == 1){
   $msg = true;

}else{
   $msg = false;
}
//echo "<pre>";print_r(json_encode($msg));
exit(json_encode($msg));


}




?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Form Module</title>
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
        $cam_page_header = "Form Module";
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
                                <h5 class="panel-title">Create Form  </h5>
                                <hr/>

                             <form name="add_name" id="messurment2" enctype="multipart/form-data" action="" method="post">
           
          
           
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
                    <select name="messurment_schema" id="messurment_schema_type" class="form-control">
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
                  <label for="inputPassword" class="col-sm-6 col-form-label">Channel</label>
                  <div class="col-sm-6">
                   <select name="chanel" id="chanel" class="form-control">
                    <option value="" >--- Select Channel ---</option> 
                    <?php
                    $sql1 = "SELECT * FROM `cam_line` where enabled = '1'";
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
<!--                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Security Zone</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="security_zone" id="security_zone"  autocomplete="off">
                  </div>

                </div>
   -->          
                <br> 
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">User-defined Question</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="user_defined_qst" id="user_defined_qst"  autocomplete="off">
                  </div>

                </div>
             
                <br>
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Image</label>
                  <div class="col-sm-6">
                   <input type="file" name="image" id="image" class="form-control" multiple>
                  </div>

                </div>
             
                <br> 
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Always Needs Approval</label>
                  <div class="col-sm-6">
                   <select name="always_needs_approval" id="always_needs_approval" class="form-control">
                    <option value="" >--- Select Option ---</option> 
                    <option value="Yes">YES</option> 
                    <option value="No"> NO </option> 
                   
                  </select>
                  </div>

                </div>
                 </br> 
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Out-Of-Tolerance Mailing List </label>
                  <div class="col-sm-6">
                   <input type="text" class="form-control" name="out_of_tolerance_mailing_list" id="out_of_tolerance_mailing_list"  autocomplete="off">
                  </div>

                </div>
                 </br>
                  <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Out-Of-Control-Limit Mailing List</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="out_of_control_limit_mailing_list" id="out_of_control_limit_mailing_list"  autocomplete="off">
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
              <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Assigned Data Collection Points</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="assigned_data_collection_points" id="assigned_data_collection_points"  autocomplete="off">
                  </div>

                </div>
             
                <br> 

                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Measurement Schema Items</label>
                  <div class="col-sm-6">
                    <div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field_1"> 
                               
                                    <tr>  
                                         <td width="85%"><input type="text" name="measurement_items[]" placeholder="Enter Items" class="form-control values"  autocomplete="off"/></td>
                                         <td width="10%"><button type="button" name="add" class="btn btn-success add-options" id="add_measurement_items">Add </button></td>  
                                    </tr>  
                               </table>  
                             
                          </div>
                  </div>

                </div>
             
                <br> 
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Measurement Uploads</label>
                  <div class="col-sm-6">
                    <div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field_2"> 
                               
                                    <tr>  
                                         <td width="85%"><input type="file" name="uploads[]" id="uploads" class="form-control"></td>
                                         <td width="10%"><button type="button" name="add" class="btn btn-success add-options" id="add_measurement_uploads">Add </button></td>  
                                    </tr>  
                               </table>  
                             
                          </div>
                  </div>

                </div>
             
                <br>

                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Measurement Schedule Items</label>
                  <div class="col-sm-6">
                    <div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field_3"> 
                               
                                    <tr>  
                                         <td width="85%"><input type="text" name="measurement__shedule_items[]" placeholder="Enter shedule Items" class="form-control values"  autocomplete="off"/></td>
                                         <td width="10%"><button type="button" name="add" class="btn btn-success add-options" id="add_measurement__shedule_items">Add </button></td>  
                                    </tr>  
                               </table>  
                             
                          </div>
                  </div>

                </div>
                <br>
              <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Approval by</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="approval_by" id="approval_by"  autocomplete="off">
                  </div>

                </div>
             
                <br> 
                <br> 
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label" >Created on</label>
                  <div class="col-sm-6">
                   <input type="date" name="created_on" id="created_on" class="form-control" required>
                  </div>
                </div>
              </br> 
              <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label" >Modified on</label>
                  <div class="col-sm-6">
                   <input type="date" name="modified_on" id="modified_on" class="form-control" required>
                  </div>
                </div>
              </br>
              <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Created by</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="created_by" id="created_by"  autocomplete="off">
                  </div>

                </div>
             
                <br>
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-6 col-form-label">Modified by</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="modified_by" id="modified_by"  autocomplete="off">
                  </div>

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
        <?php include ('../footer.php') ?>

      <script>  
 $(document).ready(function(){ 





               var i=1;  
         
              $('#add_measurement_items').click(function(){  
                   i++;  
                  
                   $('#dynamic_field_1').append('<tr id="row1'+i+'"><td width="85%"><input type="text" name="measurement_items[]" placeholder="Enter Items" class="form-control values" autocomplete="off"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger measurement_items_remove">X</button></td></tr>');  
              });  
              $(document).on('click', '.measurement_items_remove', function(){  
                   var button_id = $(this).attr("id");   
                   $('#row1'+button_id+'').remove();  
              }); 

                var j=1;  
         
              $('#add_measurement_uploads').click(function(){  
                   j++;  
                  
                   $('#dynamic_field_2').append('<tr id="row2'+j+'"><td width="85%"><input type="file" name="uploads[]" id="uploads" class="form-control"></td><td><button type="button" name="remove" id="'+j+'" class="btn btn-danger measurement_uploads_remove">X</button></td></tr>');  
              });  
              $(document).on('click', '.measurement_uploads_remove', function(){  
                   var button_id = $(this).attr("id");   
                   $('#row2'+button_id+'').remove();  
              }); 

                var k=1;  
               $('#add_measurement__shedule_items').click(function(){  
                   k++;  
                  
                   $('#dynamic_field_3').append('<tr id="row3'+k+'"><td width="85%"><input type="text" name="measurement__shedule_items[]" placeholder="Enter shedule Item" class="form-control values" autocomplete="off"/></td><td><button type="button" name="remove" id="'+k+'" class="btn btn-danger measurement__shedule_items_remove">X</button></td></tr>');  
              });  
              $(document).on('click', '.measurement__shedule_items_remove', function(){  
                   var button_id = $(this).attr("id");   
                   $('#row3'+button_id+'').remove();  
              }); 

    $(document).on('click', '#submit', function(){ 
   
   
            //var data = $('#messurment2').serialize(); 
            var form_data = new FormData($('form')[0]);
          
             $.ajax({
              type: 'POST',
              url: 'schema2.php',
              data: form_data,
              processData: false,
              contentType: false,
              success: function(res) {
                //alert(res);
                if(res == 'true'){
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
    </body>
</html>
