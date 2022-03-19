<?php
include("../config.php");
if(!empty($_POST)){
  //echo "<pre>";print_r($_POST);
  $v_key = $_POST['values'];
  $d_key = $_POST['default'];
  $t_key = $_POST['target'];
//v_key
//default check box
  $default_array_new = [];
   
  foreach(array_keys($v_key) as $key)
  { 
      if(array_key_exists($key, $d_key))
      {
          $default_array_new[] = 1;
         
      }else{
          $default_array_new[] = 0;
      }
      
  }
//target check box
  $target_array_new = [];
   
  foreach(array_keys($v_key) as $key)
  { 
       if(array_key_exists($key, $t_key))
      {
          $target_array_new[] = 1;
         
      }else{
          $target_array_new[] = 0;
      }
      
  }
 
//numeric
  $messurment_schema_name = $_POST['messurment_schema_name'];
  $header = $_POST['header'];
  $alias = $_POST['alias'];
  $position = $_POST['position'];
  $spc = $_POST['spc'];
  $opt = $_POST['opt'];
  $normal = $_POST['normal'];
  $lower_tolerance = $_POST['lower_tolerance'];
  $upper_tolerance = $_POST['upper_tolerance'];
  $lower_tolerance_ctrl_limit = $_POST['lower_tolerance_ctrl_limit'];
  $upper_tolerance_ctrl_limit = $_POST['upper_tolerance_ctrl_limit'];
//binary
  $default_binary = $_POST['default_binary'];
  $normal_binary = $_POST['normal_binary'];
  $yes_alias = $_POST['yes_alias'];
  $no_alias = $_POST['no_alias'];
  $dimentions = $_POST['dimentions'];
  $default_b = $_POST['default_b'];
  $normal_b = $_POST['normal_b'];
  $notes = $_POST['notes'];
//list
  $values = implode(', ', $_POST['values']);
  $texts = implode(', ', $_POST['texts']);
  $colors = implode(', ', $_POST['colors']);
  $default = implode(', ', $default_array_new);
  $target = implode(', ', $target_array_new);



if($_POST['form'] == 'numeric'){

   $insertQ1 = "INSERT INTO `messurment_schema`( `header`, `alias`, `position`, `spc`, `opt`, `normal`, `lower_tolerance`, `upper_tolerance`, `lower_tolerance_ctrl_limit`, `upper_tolerance_ctrl_limit`,`dimentions`, `notes`,`messurment_schema_name`) VALUES ('$header','$alias','$position','$spc','$opt','$normal','$lower_tolerance','$upper_tolerance','$lower_tolerance_ctrl_limit','$upper_tolerance_ctrl_limit','$dimentions','$notes','$messurment_schema_name')";

 
}
else if($_POST['form'] == 'binary'){

 $insertQ1 = "INSERT INTO `messurment_schema`( `header`, `alias`, `position`,`default_binary`, `normal_binary`, `yes_alias`, `no_alias`,`notes`,`messurment_schema_name`) VALUES ('$header','$alias','$position','$default_b', '$normal_b', '$yes_alias', '$no_alias','$notes','$messurment_schema_name')";
}
else if($_POST['form'] == 'list'){
  $insertQ1 = "INSERT INTO `messurment_schema`( `header`, `alias`, `position`, `opt`,`value`,`texts`,`colors`,`defaults`,`targets`,`notes`,`messurment_schema_name`) VALUES ('$header','$alias','$position','$opt','$values','$texts','$colors','$default','$target','$notes','$messurment_schema_name')";

 
}
else if($_POST['form'] == 'text'){
  $insertQ1 = "INSERT INTO `messurment_schema`( `header`, `alias`, `position`, `opt`,`notes`,`messurment_schema_name`) VALUES ('$header','$alias','$position','$opt','$notes','$messurment_schema_name')";

 
}
else if($_POST['form'] == 'header'){
   $insertQ1 = "INSERT INTO `messurment_schema`( `header`, `alias`, `spc`, `opt`,`notes`,`messurment_schema_name`) VALUES ('$header','$alias','$spc','$opt','$notes','$messurment_schema_name')";

 
}
$result1 = mysqli_query($db, $insertQ1);
//$msg = '';
if($result1 == 1){
   $msg = "success";

}else{
   $msg = "failed";
}
exit(json_encode($msg));
//echo "<pre>";print_r($msg);

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
                                <h5 class="panel-title">Add Schema</h5>
                                <hr/>

                             <form name="add_name" id="messurment" action="import_csv.php" method="post">  
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Schema Name</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="messurment_schema_name" id="messurment_schema_name" autocomplete="off">
                  </div>
                </div>
              </br>
              <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Header</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="header" id="header" autocomplete="off">
                  </div>
                </div>
              </br>
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Alias</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="alias"id="alias"  autocomplete="off">
                  </div>

                </div>
                 </br>
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Position</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="position" id="position"  autocomplete="off">
                  </div>

                </div>
                 </br>
              <div class="mb-3 row" id ="radio">
                 <label for="inputPassword" class="col-sm-2 col-form-label">ITEM CLASS</label>
                   <div class="col-sm-4">
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" checked="checked" name="item" id="itemn" value="numeric">
                <label class="form-check-label" for="inlineRadio1">Numeric</label>&nbsp;

                 <input class="form-check-input" type="radio" name="item" id="item" value="binary">
                <label class="form-check-label" for="inlineRadio1">Binary</label>&nbsp;

                 <input class="form-check-input" type="radio" name="item" id="item" value="text">
                <label class="form-check-label" for="inlineRadio1">Text</label>&nbsp;

                 <input class="form-check-input" type="radio" name="item" id="item" value="list">
                <label class="form-check-label" for="inlineRadio1">List</label>&nbsp;

                 <input class="form-check-input" type="radio" name="item" id="item" value="header">
                <label class="form-check-label" for="inlineRadio1">Header</label>&nbsp;
                </div>
              </div>
              </div>
              <br><br>

             
                 <div class="mb-3 row">
                  <label for="optional" class="col-sm-2 col-form-label">Optional</label>
                   <div class="col-sm-6">
                    <input class="form-check-input" name="" type="checkbox" id="optional" value="" >
                  </div>

                
                 </div>
                  <div id="numeric">
                 </br>
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">SPC</label>
                   <div class="col-sm-5">
                    <input type="text" class="form-control" name="spc" id="spc"  autocomplete="off">
                  </div>
                 
                 </div>
                 </br>
               <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Normal</label>
                   <div class="col-sm-3">
                    <input type="text" class="form-control" name="normal" id="normal"  autocomplete="off">
                  </div>
                 
                 </div>
                 </br>
               <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">LowerTolerance</label>
                   <div class="col-sm-3">
                    <input type="text" class="form-control" name="lower_tolerance" id="lower_tolerance"  autocomplete="off">
                  </div>
                 
                 </div>
                 </br>
               <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">UpperTolerance</label>
                   <div class="col-sm-3">
                    <input type="text" class="form-control" name="upper_tolerance" id="upper_tolerance"  autocomplete="off">
                  </div>
                 
                 </div>
                 </br>
                 <div class="mb-3 row">
                  <label for="text" class="col-sm-2 col-form-label">Lower Control Limit</label>
                   <div class="col-sm-3">
                    <input type="text" class="form-control" name="lower_tolerance_ctrl_limit" id="lower_tolerance_ctrl_limit"  autocomplete="off">
                  </div>
                 
                 </div>
                 </br>
                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Upper Control Limit</label>
                   <div class="col-sm-3">
                    <input type="text" class="form-control" name="upper_tolerance_ctrl_limit" id="upper_tolerance_ctrl_limit"  autocomplete="off">
                  </div>
                 
                 </div>
                 </br>

                 <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Dimentions</label>
                   <div class="col-sm-4">
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="X">
                <label class="form-check-label" for="inlineRadio1">X</label>&nbsp;
                  
                 <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="Y">

                <label class="form-check-label" for="inlineRadio1">Y</label>&nbsp;
                  
                 <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="Z">
                <label class="form-check-label" for="inlineRadio1">Z</label>&nbsp;
                

                 <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="N">
                <label class="form-check-label" for="inlineRadio1">N</label>&nbsp;

                 <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="D">
                <label class="form-check-label" for="inlineRadio1">D</label>&nbsp;
                 <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="A">
                <label class="form-check-label" for="inlineRadio1">A</label>&nbsp;
                 <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="L">
                <label class="form-check-label" for="inlineRadio1">L</label>&nbsp;
                 <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="L2">
                <label class="form-check-label" for="inlineRadio1">L2</label>&nbsp;
                 <input class="form-check-input" type="radio" name="dimentions" id="dimentions" value="Array">
                <label class="form-check-label" for="inlineRadio1">Array</label>&nbsp;
                </div>
                  </div>
                 
                 </div>

              </div>
              <br>
        <div id="binary">
                 <div class="mb-3 row">
                   <label for="inputPassword" class="col-sm-2 col-form-label">Default</label>
                    <div class="col-sm-4">
                <div class="form-check form-check-inline">

            <input class="form-check-input none" type="radio" name="default_binary" id="default_binary" value="none">
                <label class="form-check-label" for="inlineRadio1">None</label>&nbsp;

            <input class="form-check-input yes" type="radio" name="default_binary" id="default_binary" value="yes">
            <label class="form-check-label" for="inlineRadio1">Yes</label>&nbsp;

            <input class="form-check-input no" type="radio" name="default_binary" id="default_binary" value="no">
            <label class="form-check-label" for="inlineRadio1">No</label>&nbsp;

          
                </div>
              </div>
                 </div>
                 <br>
                  <div class="mb-3 row">
                   <label for="inputPassword" class="col-sm-2 col-form-label">Normal</label>
                        <div class="col-sm-4">
                <div class="form-check form-check-inline">
               

                  <input class="form-check-input yes" type="radio" name="normal_binary" id="normal_binary" value="YES">
                <label class="form-check-label" for="inlineRadio1">Yes</label>&nbsp;

                 <input class="form-check-input no" type="radio" name="normal_binary" id="normal_binary" value="NO">
                <label class="form-check-label" for="inlineRadio1">No</label>&nbsp;

                
                </div>
              </div>
                 </div>
                 <br>
                   <div class="mb-3 row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">Yes Alias</label>
                      <div class="col-sm-6">
                    <input type="text" class="form-control" name="yes_alias"id="yes_alias"  autocomplete="off">
                  </div>
                   </div>
                   <br>
                   <div class="mb-3 row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">No Alias</label>
                      <div class="col-sm-6">
                    <input type="text" class="form-control"  name="no_alias"id="no_alias"  autocomplete="off">
                  </div>
                   </div>
            
            </div>
              </br>
                      <div id="list_view">

                  <div class="mb-3 row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">List Elements</label>
                      <div class="col-md-12">
                     <div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field"> 
                               <th>VALUE</th> 
                               <th>TEXT</th> 
                               <th>COLOR</th> 
                               <th>DEFAULT</th> 
                               <th>TARGET</th> 
                               <th>ACTION</th> 
                                    <tr>  
                                         <td width="5%"><input type="text" name="values[]" placeholder="Enter Value" class="form-control values"  autocomplete="off"/></td>

                                         <td width="55%"><input type="text" name="texts[]" placeholder="Enter Text" class="form-control texts"  autocomplete="off"/></td> 

                                         <td width="10%"><input type="text" name="colors[]" placeholder="Enter Color" class="form-control colors"  autocomplete="off"/></td> 

                                         <td width="10%"> <input class="form-check-input default_check" name="default[]" type="checkbox" id="default_check1" value="">  <label>DEFAULT</label></td>  

                                         <td width="10%"> <input class="form-check-input target_check" name="target[]" type="checkbox" id="target_check1" value=""> <label>TARGET</label></td>  

                                         <td width="10%"><button type="button" name="add" class="btn btn-success add-options" id="add">Add </button></td>  
                                    </tr>  
                               </table>  
                             
                          </div>
                  </div>
                   </div>

                        
                        </div>
                          <br>
                <div class="mb-3 row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Notes</label>
                  <div class="col-sm-6">
                    <textarea class="form-control" aria-label="With textarea" id="notes"name="notes"  autocomplete="off"></textarea>
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


      <script>  
 $(document).ready(function(){ 
$("#itemn").prop("checked", true);
$('#binary').hide();
$('#list_view').hide();

 var form = 'numeric';
 var default_val =0;
 var target_val = 0;
 $("input[name='item']").click(function(){
    //alert('You clicked radio!');
    if($('input:radio[name=item]:checked').val() == "numeric"){
       $('#numeric').show();
       $('#binary').hide();
       $('#list_view').hide();
       $('#optional').show();
       $('#header,#alias,#position,#optional,#spc,#normal,#lower_tolerance,#lower_tolerance_ctrl_limit,#upper_tolerance,#upper_tolerance_ctrl_limit,#dimentions,#default_binary,#normal_binary,#no_alias,#yes_alias,#notes').val('')
       $("#optional,#dimentions,#default_binary,#normal_binary").prop('checked',false);
    form = "numeric";
      
    }
    else if($('input:radio[name=item]:checked').val() == "binary"){
     //location.reload();
        $('#binary').show();
        $('label[for="optional"]').hide();
        $('#numeric').hide();
        $('#list_view').hide();
        $('#optional').hide();
       
        $('#header,#alias,#position,#optional,#spc,#normal,#lower_tolerance,#lower_tolerance_ctrl_limit,#upper_tolerance,#upper_tolerance_ctrl_limit,#dimentions,#default_binary,#normal_binary,#no_alias,#yes_alias,#notes').val('');
        $("#optional,#dimentions,#default_binary,#normal_binary").prop('checked',false);
        form = "binary";
    }
    else if($('input:radio[name=item]:checked').val() == "text"){
       $('#numeric').hide();
       $('#binary').hide();
       $('#list_view').hide();
       $('label[for="optional"]').show();

       $('#optional').show();
       $('#header,#alias,#position,#optional,#spc,#normal,#lower_tolerance,#lower_tolerance_ctrl_limit,#upper_tolerance,#upper_tolerance_ctrl_limit,#dimentions,#default_binary,#normal_binary,#no_alias,#yes_alias,#notes').val('');
       $("#optional,#dimentions,#default_binary,#normal_binary").prop('checked',false);
        form = "text";
        
    }
    else if($('input:radio[name=item]:checked').val() == "list"){
       $('#numeric').hide();
       $('label[for="optional"]').show();
       $('#binary').hide();
       $('#list_view').show();
       $('#optional').show();
       $('#header,#alias,#position,#optional,#spc,#normal,#lower_tolerance,#lower_tolerance_ctrl_limit,#upper_tolerance,#upper_tolerance_ctrl_limit,#dimentions,#default_binary,#normal_binary,#no_alias,#yes_alias,#notes').val('');
       $("#optional,#dimentions,#default_binary,#normal_binary").prop('checked',false);


          var i=1;  
         
              $('#add').click(function(){  
                   i++;  
                   default_val++;
                   target_val++;
                   $('#dynamic_field').append('<tr id="row'+i+'"><td width="5%"><input type="text" name="values[]" placeholder="Enter Value" class="form-control values" autocomplete="off"/></td><td width="55%"><input type="text" name="texts[]" placeholder="Enter Text" class="form-control texts" autocomplete="off"/></td>  <td width="10%"><input type="text" name="colors[]" placeholder="Enter your Name" class="form-control colors" autocomplete="off"/></td> <td width="10%"> <input class="form-check-input default_check" name="default['+default_val+']" type="checkbox" id="default_check'+i+'" value=""><label>DEFAULT</label></td><td width="10%"> <input class="form-check-input target_check" name="target['+target_val+']" type="checkbox" id="target_check'+i+'" value=""> <label>TARGET</label></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
              });  
              $(document).on('click', '.btn_remove', function(){  
                   var button_id = $(this).attr("id");   
                   $('#row'+button_id+'').remove();  
              });  
              $( '#default_check'+i+'' ).each(function(index) {
               
                   if ($(this).prop("checked",false)) {
                      var default_val =  0;
                     
                  }else if ($(this).prop("checked",true)) {
                      var default_val =  1;
                     
                  }
                         
               
              });
             $('#target_check'+i+'' ).each(function(index) {
             
                  if ($(this).prop("checked",false)) {
                  
                        var target_val =  0;
                    
                    }else if ($(this).prop("checked",true)) {
                        var target_val =  1;
                      
                    }

             });
              form = "list";

    }
    else if($('input:radio[name=item]:checked').val() == "header"){
       $('#numeric').hide();
       $('label[for="optional"]').hide();
       $('#binary').hide();
       $('#list_view').hide();
       $('#optional').hide();
       $('#header,#alias,#position,#optional,#spc,#normal,#lower_tolerance,#lower_tolerance_ctrl_limit,#upper_tolerance,#upper_tolerance_ctrl_limit,#dimentions,#default_binary,#normal_binary,#no_alias,#yes_alias,#notes').val('');
       $("#optional,#dimentions,#default_binary,#normal_binary").prop('checked',false);
        form = "header";
       
    }
});
           
    

    $('#submit').click(function(){

     
            var data = $('#messurment').serialize();  
            var opt = '';

            if($('#optional').prop("checked") == true){
                opt = 1;
               
            }
            else if($('#optional').prop("checked") == false){
                opt = 0;
               
            }else{
              opt = '';
            }

   var default_binary = $('input:radio[id=default_binary]:checked').attr('class');//get class name
   var normal_binary = $('input:radio[id=normal_binary]:checked').attr('class');//get class name
   var dimentions = $('input:radio[id=dimentions]:checked').val();//get normal value

    // default radio button for binary
   if(default_binary == 'form-check-input yes'){
    var default_b = 'YES';

   }else if(default_binary == 'form-check-input none'){
    default_b = 'NONE';

   }else if(default_binary == 'form-check-input no'){
    default_b = 'NO';

   }


    // normal radio button for binary
  if(normal_binary == 'form-check-input yes'){
    var normal_b = 'YES';

   }else if(normal_binary == 'form-check-input no'){
    normal_b = 'NO';

   }

   if($('#notes').val() != ''){


      $.ajax({  
                url:"schema.php",  
                method:"POST",  
                dataType : 'json',
                encode   : true,
                data:data + "&opt=" + opt + "&form=" + form + "&default_b=" + default_b + "&normal_b=" + normal_b + "&dimentions=" + dimentions,
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
      else{
        alert("please fill all fied");
      }
    });


 });  
 </script>
        <?php include ('../footer.php') ?>s
    </body>
</html>
