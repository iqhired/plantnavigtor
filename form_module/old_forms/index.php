
<!DOCTYPE html>
<html lang="en">
<head>
  <title>jQuery FormBuilder Tutorial</title>
  
  <!-- JQuery Script-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <!-- Form Builder Script -->
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script> 
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
        <!-- <script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script> -->
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
                          <h5 class="panel-title">New Form</h5>
                          <br>
                           <div class="col-sm-3">
                            <input type="text" class="form-control" name="form" id="form"  autocomplete="off" placeholder="Enter Form Name" required>
                          </div>
                          <br>
                          <hr/>
  <!-- Builder Wrap-->
  <form method="post" action="/post_form_data.php"  id="my-form" >

          <div id="build-wrap"></div>
          <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
        <!--  <button id="appendField" class="addFieldBtn" data-label="Appended Field" type="button">Append Field</button> --> 
          </div>
                     </form>
                      <!--  <div class="mb-3 pull-right">

               <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
             </div> -->

        </div>
      </div>
  </div>
  </div>
  </div>
  </div>

  <?php include ('../footer.php') ?>
</body>
</html>
