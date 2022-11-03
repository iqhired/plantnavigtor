<?php include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);
//echo "<pre>";print_r($drag_drop_res);

if($_POST['form_name'] != ''){
	$sql = "SELECT max(form_id) FROM drag_form";
	$result1 = mysqli_query($db, $sql);
	  while ($row1 = $result1->fetch_assoc()) {	
	  	 ///echo "<pre>";print_r($row1['max(form_id)']);
	  	 $form_id = $row1['max(form_id)']+1;

	}

	$val = '';
	$label = '';
	$type = '';
	$name = '';
	$options = '';
    $sql ="INSERT INTO `drag_form`( `form_id`,`form_name`,`field_label`,`field_type`,`field_name`,`field_option`, `field_value`) VALUES ";
   foreach ( $drag_drop_res as $fromtype) {

    $form_name = $_POST['form_name'];
    if($fromtype->type == 'text'){
   		    $label =$fromtype->label;
   		   	$type = $fromtype->type;
   			$val =  $fromtype->value;
   			$name = $fromtype->name;
   			$options =  'NULL';
   		$sql .= "('$form_id','$form_name','$label','$type','$name','$options','$val'),";

   	}
   	if($fromtype->type == 'textarea'){
   		
   		   	$label = $fromtype->label;
   		   	$type = $fromtype->type;
   			$val =  $fromtype->value;
   			$name = $fromtype->name;
   			$options =  'NULL';

   		
   		$sql .= "('$form_id','$form_name','$label','$type','$name','$options','$val'),";

   	}
   	if($fromtype->type == 'checkbox-group'){
   		$label = $fromtype->label;
   		$name = $fromtype->name;
   		$type = $fromtype->type;
   		$options =  'NULL';
   		foreach ($fromtype->values as $check) {

   		
   			$val = $check->selected;
   		}
   	$sql .= "('$form_id','$form_name','$label','$type','$name','$options','$val'),";	

   	}
   	if($fromtype->type == 'radio-group'){
   		$label = $fromtype->label;
   		$name  = $fromtype->name;
   		$type  = $fromtype->type;
   		

   		foreach ($fromtype->values as $radio) {
   			 $new[] = $radio->label;
   			 $options = implode(",",$new);

   			if($radio->selected == 1){
           
   			 $val = $radio->label;
   			
   			}
          
   		}
$sql .= "('$form_id','$form_name','$label','$type','$name','$options','$val'),";
   	}
 
   
    	

}
	$q = substr_replace($sql,"",-1); 
	$result1 = mysqli_query($db, $q);
	$msg = '';
	if($result1 == 1 ){
	   $msg = 1;

	}else{
	   $msg = 0;
	}
exit(json_encode($msg));
}

?>