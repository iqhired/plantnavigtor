<?php
include("../config.php");

if(isset($_POST['form_id'])){


      
       $sql1 = "SELECT *  FROM drag_form WHERE `form_id` = '".$_POST['form_id']."'";
 $result1 = $mysqli->query($sql1);
 $form = '<form method="post" action="" name="update_form" id="my-form" class="form"> 
 <input type="hidden"  id="form"  value="">
      <br>
      <br>';
     while ($row1 = $result1->fetch_assoc()) {
   
    if($row1['field_type'] == 'text'){

      $form.= '<div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">'.$row1['field_label'].'</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="'.$row1["field_name"].'" id="'.$row1["field_name"].'"  autocomplete="off" value="">
                <input type="hidden" name="'.$row1["field_name"].'" id="hidden_'.$row1["field_name"].'"  autocomplete="off" value="'.$row1["field_value"].'">
              </div>

            </div><br><br>';


    } 

    if($row1['field_type'] == 'textarea'){

      $form.= '<div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">'.$row1['field_label'].'</label>
              <div class="col-sm-3">
                <input type="textarea" class="form-control" name="'.$row1["field_name"].'" id="'.$row1["field_name"].'"  autocomplete="off" value="">
                  <input type="hidden" name="'.$row1["field_name"].'" id="hidden_'.$row1["field_name"].'"  autocomplete="off" value="'.$row1["field_value"].'">
              </div>

            </div><br><br>';


    }
     if($row1['field_type'] == 'checkbox-group'){
      if($row1["field_value"] == 1){
        $checked = 'checked';
        $val = 1;

      }
      else if($row1["field_value"] == 0){
        $checked = '';
        $val = 0;

      }

      $form.='<div class="mb-3 row">
              <label for="inputPassword" class="col-sm-2 col-form-label">'.$row1['field_label'].'</label>
              <div class="col-sm-3">
                <input class="form-check-input"  type="checkbox"  name="'.$row1["field_name"].'" id="optional" value="" >
              </div>
              <input type="hidden" name="'.$row1["field_name"].'" id="hidden_'.$row1["field_name"].'"  autocomplete="off" value="'.$row1["field_value"].'">

            </div><br><br>';


    } 
         
    if($row1['field_type'] == 'radio-group'){

      $opt =$row1["field_option"];
         $form.= '<div class="mb-3 row"><label for="inputPassword" class="col-sm-2 col-form-label">'.$row1['field_label'].'</label> <br>
          <div class="col-sm-4">
       <div class="form-check form-check-inline">';
      $opt_arr = explode(",",$opt);
      foreach ($opt_arr as $key => $value) {
         if($row1["field_value"] == $value){
        $checked = 'checked';

      }
      else {
        $checked = '';

      }
        
             
     $form.= '<input class="form-check-input" type="radio" name="'.$row1["field_name"].'" id="'.$value.'" value="'.$value.'">
    <label class="form-check-label" for="inlineRadio1" >'.$value.'</label>&nbsp;';
      }
         $form.='</div> </div></div><br><br>';
        

    }

}
 $form.=' <input type="button" name="update" id="update" class="btn btn-info" value="UPDATE" />';
exit(json_encode($form));
//echo "<pre>";print_r($sql1);
}

if(isset($_POST['evalutation_id'])){

 $sql11 = "SELECT *  FROM drag_form WHERE `form_id` = '".$_POST['evalutation_id']."'";
 $result11 = $mysqli->query($sql11);
 $res = array();
    while ($row11 = $result11->fetch_assoc()) {

    $res[] = array(
      'name' =>$row11['field_name'],
      'value'=> $row11['field_value']
    );

}
exit(json_encode($res));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>jQuery FormBuilder Tutorial</title>
  
  <!-- JQuery Script-->
   <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> -->
    <!-- Form Builder Script -->
   <!--  <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>  -->
    <!-- <script src="gravity_form/js/form-builder.min.js"></script> -->
    <!-- Custom Script -->
    <script src="gravity_form/js/script.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="gravity_form/css/style.css" type="text/css" />   

            <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Form Module</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
      <!--   <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css"> -->
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
        $cam_page_header = "Form Module";
      include("../header_folder.php")
        ?>

  <div class="page-container">
    
      <div class="page-content">
         
          <?php include("../admin_menu.php"); ?>

          <div class="content-wrapper">
              <div class="content">
                  
                  <div class="panel panel-flat">
                      <div class="panel-heading">
                          <h5 class="panel-title">Select Form</h5>
                          <br>
                           <div class="col-sm-3">
                             <div class="col-sm-6">
                    <select name="form_evl" id="form_evl" class="form-control">
                    <option value="" >--- Select Measurement Form ---</option>
                  <?php
                    $sql1 = "SELECT DISTINCT form_name,form_id FROM `drag_form`";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        echo "<option value='" . $row1['form_id'] . "'>" . $row1['form_name'] . "</option>";
                    }
                    ?>
                  </select>
                  </div>
                          </div>
 
                          <br>
                          <hr/>
                <!-- Builder Wrap-->
                <div id="u-form">
                  

                </div>
          </div>
          
                    

        </div>
      </div>
  </div>
  </div>
  </div>
  </div>

  <?php include ('../footer.php') ?>
</body>
</html>
<script type="text/javascript">
	
 $(document).on('change', '#form_evl', function(){ 
 	 var form_id = $(this).val(); 
   $('#my-form').empty();

 	       $.ajax({  
                //:"user_e.php",  
                method:"POST",  
                dataType : 'json',
                encode   : true,
                data:{form_id:form_id},              
                success:function(res)  

                { 
                   $('#u-form').append(res);
                   if(res != ''){
                       $.ajax({  
                              //:"user_e.php",  
                              method:"POST",  
                              dataType : 'json',
                              encode   : true,
                              data:{evalutation_id:form_id},              
                              success:function(data)  

                              { 

                                 for (var i=0; i<data.length; i++) { 
                                      //$('#hidden_'+data[i].name+'').val(data[i].value);
                                      //console.log(data[i].name);
                                      //console.log(data[i].value);
                                      var name  = data[i].name;
                                     //// var val = data[i].value;

                                   //$('#'+name+'').remove();  
                                $('#'+name+'').keyup(function() { 
                                      
                                       var val = $(this).val();
                                       var id = $(this).attr('id');
                                       var hidden_val =   $('#hidden_'+id+'').val();  
                                       //alert( $(this).attr('id'));
                                       if(val=== hidden_val){
                                        //alert('ok');
                                          $('#'+id+'').css('background-color','green');

                                        }else{
                                           //alert('wrong');
                                           $('#'+id+'').css('background-color','red');
                                        }



                                     
                                     /*     if($('#'+name+'').prop("checked") == true){

                                          if(val=== hidden_val){
                                             $('#'+id+'').css('background-color','green');
                                          }else{
                                          
                                           $('#'+id+'').css('background-color','red');
                                          }
                                         
                                          }


                                          if($('#'+name+'').prop("checked") == false){

                                          if(val=== hidden_val){
                                             $('#'+id+'').css('background-color','green');
                                          }else{
                                           
                                           $('#'+id+'').css('background-color','red');
                                          }
                                         
                                          
                                          }  */                         

                                        });
                                        
                                                                            
                                  }
                              }  
                         });


                   }
                }  
           });

 });	


</script> 
