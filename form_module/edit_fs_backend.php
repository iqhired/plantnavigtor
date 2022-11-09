<?php

include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);
//echo "<pre>";print_r($drag_drop_res);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

if(count($_POST)>0) {
	$hidden_id = $_POST['hidden_id'];
	$name = $_POST['name'];
	$form_classification = $_POST['form_classification'];
	$form_type = $_POST['form_type'];
	$station = $_POST['station'];
	$part_family = $_POST['part_family'];
	$part_number = $_POST['part_number'];
	$po_number = $_POST['po_number'];
	$da_number = $_POST['da_number'];
	$out_of_tolerance_mail_list1 = $_POST['out_of_tolerance_mail_list'];
	$out_of_control_list1 = $_POST['out_of_control_list'];
	$notification_list1 = $_POST['notification_list'];
	$form_create_notes = $_POST['form_create_notes'];

    $need_approval1 = $_POST['need_approval'];

    if($need_approval1 == ""){
        $need_approval = 'no';
    }else{
        $need_approval = 'yes';
    }
    $approve_list1 = $_POST['approval_list'];

    if($approve_list1 == ""){
        $approve_list = 'no';
    }else{
        $approve_list = 'yes';
    }

	$approval_by1 = $_POST['approval_by'];
	$valid_from = $_POST['valid_from'];
	$valid_till = $_POST['valid_till'];
	$duration_hh = $_POST['duration_hh'];
	$duration_mm = $_POST['duration_mm'];
	$frequency = $duration_hh . ":" . $duration_mm;
	$created_by = date("Y-m-d H:i:s");
	$updated_by = date("Y-m-d H:i:s");
	$unit_of_measurement = $_POST['unit_of_measurement'];



	foreach ($out_of_tolerance_mail_list1 as $out_of_tolerance_mail_list) {
		$array_out_of_tolerance_mail_list .= $out_of_tolerance_mail_list . ",";
	}
	foreach ($out_of_control_list1 as $out_of_control_list) {
		$array_out_of_control_list .= $out_of_control_list . ",";
	}
	foreach ($notification_list1 as $notification_list) {
		$array_notification_list .= $notification_list . ",";
	}
	foreach ($approval_by1 as $approval_by) {
		$array_approval_by .= $approval_by . ",";
	}




	$sql0 = "UPDATE `form_create` SET `name`='$name',`form_classification`='$form_classification',`form_type`='$form_type',`station`='$station',`part_family`='$part_family',`part_number`='$part_number',`po_number`='$po_number',`da_number`='$da_number',`out_of_tolerance_mail_list`='$array_out_of_tolerance_mail_list',`out_of_control_list`='$array_out_of_control_list',`notification_list`='$array_notification_list',`form_create_notes`='$form_create_notes',`need_approval`='$need_approval',`approval_list`='$approve_list',`approval_by`='$array_approval_by',`valid_from`='$valid_from',`valid_till`='$valid_till',`frequency`='$frequency',`updated_by`='$updated_by' WHERE `form_create_id` = '$hidden_id'";
	$result0 = mysqli_query($db, $sql0);
	if ($result0) {
		$_SESSION['message_stauts_class'] = 'alert-success';
		$_SESSION['import_status_message'] = 'Form Updated Sucessfully.';
	} else {
		$_SESSION['message_stauts_class'] = 'alert-danger';
		$_SESSION['import_status_message'] = 'Please retry';
	}


	$qur04 = mysqli_query($db, "SELECT * FROM  form_create where name= '$name' ORDER BY `form_create_id` DESC ");
	$rowc04 = mysqli_fetch_array($qur04);
	$form_create_id = $rowc04["form_create_id"];

//multiple image
	if (isset($_FILES['image'])) {

		foreach($_FILES['image']['name'] as $key=>$val ){
			$errors = array();
			$file_name = $_FILES['image']['name'][$key];
			$file_size = $_FILES['image']['size'][$key];
			$file_tmp = $_FILES['image']['tmp_name'][$key];
			$file_type = $_FILES['image']['type'][$key];
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
				move_uploaded_file($file_tmp, "../form_images/" . $file_name);

				$sql = "INSERT INTO `form_images`(`image_name`,`form_create_id`,`created_at`) VALUES ('$file_name' , '$form_create_id' , '$created_by' )";

				$result1 = mysqli_query($db, $sql);
				if ($result1) {
					$message_stauts_class = 'alert-success';
					$import_status_message = 'Image Added Successfully.';
				} else {
					$message_stauts_class = 'alert-danger';
					$import_status_message = 'Error: Please Try Again.';
				}
			}

		}
	}


//remove records
	$form_create_id = $hidden_id;


	// $sqlremove = "DELETE FROM `form_item` WHERE form_create_id = '$form_create_id'";

//	$resultremove = mysqli_query($db, "DELETE FROM `form_item` WHERE `form_create_id` = '$form_create_id'");
//
//	if ($resultremove) {
//	} else {
//	}

//remove records over


//multi image over
	$total_count =  $_POST['collapse_id'];
	if($total_count > 0){
		$total_count = $total_count - 1;
	}
	$click_id = $_POST['click_id'];
	$notclick = $_POST['not_click_id'];

	if($click_id == "")
	{
		$click_id = $_POST['not_click_id'];
	}

	//echo "click id".$click_id;

	$item_desc_array = $_POST['query_text'];
	$bansi_row_click = $_POST['bansi_row_click'];
	$bansi_row_click1 = $_POST['bansi_row_click1'];
	$j = 1;
	$z=0;
	foreach ($bansi_row_click as $rd) {
		$exp = explode("-",$rd);
		$cc = sizeof($exp);
		$actual_row = $j;
		$bansi_row = $exp[1];
		if(empty($bansi_row)){
			$bansi_row = $exp[0];
		}
		$itemarray = $_POST['item_' . $bansi_row];
		$item = $itemarray[0];
		$notes_array = $_POST['form_item_notes'];
		$disc_array = $_POST['form_item_disc'];

		$opt = $_POST['optional_' . $bansi_row];
		if($cc == 2){
			$index = $actual_row;
			$item_desc = $item_desc_array[($z)];
			$notes = $notes_array[($z)];
			$disc = $disc_array[($z)];
			$checked = 0;
			if ($opt != null && isset($opt) && isset($opt[0])) {
				$checked = 1;
			}
			$item_desc = $mysqli->real_escape_string($item_desc);
			if ($item == "numeric") {
				$normal_array = $_POST['normal'];
				$normal = $normal_array[($z)];

				echo "normal :- " . $normal;

				$lower_tolerance_array = $_POST['lower_tolerance'];
				$lower_tolerance = $lower_tolerance_array[($j-1)];

				echo "lower_tolerance :- " . $lower_tolerance;


				$upper_tolerance_array = $_POST['upper_tolerance'];
				$upper_tolerance = $upper_tolerance_array[($z)];

				echo "upper_tolerance :- " . $upper_tolerance;
				$unit = $unit_of_measurement[($z)];

                $graph_numeric_array = $_POST['numeric_graph_' . $bansi_row];
                $graph_numeric = $graph_numeric_array[0];


//update `form_item` SET `form_item_seq` = '$j',`unit_of_measurement` = '$unit',`optional` = '$checked',`form_create_id` = '$form_create_id',
//`item_desc` = '$item_desc',`item_val` = '$item',`numeric_normal` = '$normal',`numeric_lower_tol` = '$lower_tolerance',`numeric_upper_tol` = '$upper_tolerance',
//`notes` = '$notes' ,`discription` = '$disc',`created_at` = '$created_by' , `updated_at` = '$updated_by'
				$sql1 = "update `form_item` SET `form_item_seq` = '$index',`unit_of_measurement` = '$unit',`optional` = '$checked',`form_create_id` = '$form_create_id',
`item_desc` = '$item_desc',`item_val` = '$item',`numeric_normal` = '$normal',`numeric_lower_tol` = '$lower_tolerance',`numeric_upper_tol` = '$upper_tolerance',`numeric_graph` = '1',
`notes` = '$notes' ,`discription` = '$disc',`created_at` = '$created_by' , `updated_at` = '$updated_by' where form_item_id = '$exp[0]'";
				$result1 = mysqli_query($mysqli, $sql1);
				if ($result1) {
					$message_stauts_class = 'alert-success';
					$import_status_message = 'Form Item updated successfully.';
				} else {
					$message_stauts_class = 'alert-danger';
					$import_status_message = 'Error: Please Insert valid data';
				}

			} else if ($item == "binary") {
				$default_binary_array = $_POST['default_binary_' . $bansi_row];
				$default_binary = $default_binary_array[0];

				$normal_binary_array = $_POST['normal_binary_' . $bansi_row];
				$normal_binary = $normal_binary_array[0];

                $graph_binary_array = $_POST['normal_graph_' . $bansi_row];
                $graph_binary = $graph_binary_array[0];


				$yes_alias_array = $_POST['yes_alias'];
				$yes_alias = $yes_alias_array[($z)];

				$no_alias_array = $_POST['no_alias'];
				$no_alias = $no_alias_array[($z)];

				$sql1 = "update `form_item` SET `form_item_seq` = '$index',`form_create_id` = '$form_create_id',`optional` = '$checked',`item_desc` = '$item_desc',`item_val` = '$item',
`binary_default` = '$default_binary',`binary_normal` = '$normal_binary',`binary_yes_alias` = '$yes_alias',`binary_no_alias` = '$no_alias',`binary_graph` = '1' ,`notes` = '$notes' ,
`discription` = '$disc',`created_at`='$created_by' , `updated_at` = '$updated_by' where form_item_id = '$exp[0]'";
				$result1 = mysqli_query($db, $sql1);
				if ($result1) {
					$message_stauts_class = 'alert-success';
					$import_status_message = 'Form Item updated successfully.';
				} else {
					$message_stauts_class = 'alert-danger';
					$import_status_message = 'Error: Please Insert valid data';
				}

			} else if($item == "list")
            {
                $default_list_array = $_POST['default_list_'.$bansi_row];
                $default_list = $default_list_array[0];


                $list_enabled_array = $_POST['list_enabled_'.$bansi_row];
                $list_enabled = $list_enabled_array[0];

                $radio_enabled_array1 = $_POST['radio_list_extra_'.$bansi_row];
                $radio_enabled_array = implode (", ", $radio_enabled_array1);

                if($list_enabled == ""){
                    $list_enabled = '0';
                }else{
                    $list_enabled = '1';
                }

                $none_alias_array = $_POST['radio_list_none_'.$bansi_row];
                $none_alias = $none_alias_array[0];

                $yes_alias_array = $_POST['radio_list_yes'];
                $yes_alias = $yes_alias_array[($z)];

                $no_alias_array = $_POST['radio_list_no'];
                $no_alias = $no_alias_array[($z)];


                $sql1 = "update `form_item` SET `form_item_seq` = '$index',`form_create_id` = '$form_create_id',`optional` = '$checked',`item_desc` = '$item_desc',`item_val` = '$item',
`list_normal` = '$default_list',`list_name1` = '$none_alias',`list_name2` = '$yes_alias',`list_name3` = '$no_alias',`list_enabled` = '$list_enabled',`list_name_extra` = '$radio_enabled_array' ,`notes` = '$notes' ,
`discription` = '$disc',`created_at`='$created_by' , `updated_at` = '$updated_by' where form_item_id = '$exp[0]'";

                $result1 = mysqli_query($db, $sql1);
                if ($result1) {
                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Form Item created successfully.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Insert valid data';
                }

            }
            else if ($item != "") {

				$sql1 = "update `form_item` SET `form_item_seq` = '$index',`form_create_id` = '$form_create_id',`optional` = '$checked',`item_desc` = '$item_desc',`item_val` = '$item',
`notes` = '$notes' ,`discription` = '$disc',`created_at` = '$created_by', `updated_at` = '$updated_by'  where form_item_id = '$exp[0]'";
				$result1 = mysqli_query($db, $sql1);
				if ($result1) {
					$message_stauts_class = 'alert-success';
					$import_status_message = 'Form Item updated successfully.';
				} else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Insert valid data';
                }
			}

//			$sql0 = "UPDATE `form_item` SET `form_item_seq`='$j' where form_item_id = '$exp[0]'";
//			$result0 = mysqli_query($db, $sql0);

		}else {
			$item_desc = $item_desc_array[($j-1)];
			$notes = $notes_array[($j-1)];
			$disc = $disc_array[($j-1)];
			$checked = 0;
			$bansi_row = $exp[0];
			$itemarray = $_POST['item_' . $bansi_row];
			$item = $itemarray[0];
			$opt = $_POST['optional_' . $bansi_row];
			$item_desc = $mysqli->real_escape_string($item_desc);
			if ($opt != null && isset($opt) && isset($opt[0])) {
				$checked = 1;
			}

			if ($item == "numeric") {
				$normal_array = $_POST['normal'];
				$normal = $normal_array[($j-1)];

				echo "normal :- " . $normal;

				$lower_tolerance_array = $_POST['lower_tolerance'];
				$lower_tolerance = $lower_tolerance_array[($j-1)];

				echo "lower_tolerance :- " . $lower_tolerance;


				$upper_tolerance_array = $_POST['upper_tolerance'];
				$upper_tolerance = $upper_tolerance_array[($j-1)];

				echo "upper_tolerance :- " . $upper_tolerance;
				$unit = $unit_of_measurement[($j-1)];

                $graph_numeric_array = $_POST['graph_numeric_' . $bansi_row];
                $graph_numeric = $graph_numeric_array[0];


				$sql1 = "INSERT INTO `form_item`(`form_item_seq`,`unit_of_measurement`,`optional`,`form_create_id`,`item_desc`,`item_val`,`numeric_normal`,`numeric_lower_tol`,`numeric_upper_tol`,`numeric_graph`,`notes` ,`discription`,`created_at` , `updated_at`) VALUES
		('$j','$unit'  , '$checked' , '$form_create_id', '$item_desc' , '$item' , '$normal' , '$lower_tolerance' , '$upper_tolerance' ,'1', '$notes' ,'$disc' , '$created_by' , '$updated_by')";
				$result1 = mysqli_query($db, $sql1);
				if ($result1) {
					$message_stauts_class = 'alert-success';
					$import_status_message = 'Form Item created successfully.';
				} else {
					$message_stauts_class = 'alert-danger';
					$import_status_message = 'Error: Please Insert valid data';
				}

			} else if ($item == "binary") {
				$default_binary_array = $_POST['default_binary_' . $bansi_row];
				$default_binary = $default_binary_array[0];

				$normal_binary_array = $_POST['normal_binary_' . $bansi_row];
				$normal_binary = $normal_binary_array[0];

                $graph_binary_array = $_POST['graph_binary_' . $bansi_row];
                $graph_binary = $graph_binary_array[0];

				$yes_alias_array = $_POST['yes_alias'];
				$yes_alias = $yes_alias_array[($j-1)];

				$no_alias_array = $_POST['no_alias'];
				$no_alias = $no_alias_array[($j-1)];

				$sql1 = "INSERT INTO `form_item`(`form_item_seq`,`form_create_id`,`optional`,`item_desc`,`item_val`,`binary_default`,`binary_normal`,`binary_yes_alias`,`binary_no_alias`,`binary_graph`,`notes` ,`discription`,`created_at` , `updated_at`) VALUES
		('$j','$form_create_id' , '$checked', '$item_desc' , '$item' , '$default_binary' , '$normal_binary' , '$yes_alias' , '$no_alias' ,'1', '$notes' ,'$disc' , '$created_by' , '$updated_by')";
				$result1 = mysqli_query($db, $sql1);
				if ($result1) {
					$message_stauts_class = 'alert-success';
					$import_status_message = 'Form Item created successfully.';
				} else {
					$message_stauts_class = 'alert-danger';
					$import_status_message = 'Error: Please Insert valid data';
				}

			} else if ($item == "list") {
                $default_list_array = $_POST['default_list_' . $bansi_row];
                $default_list = $default_list_array[0];

                $list_enabled_array = $_POST['list_enabled_'.$bansi_row];
                $list_enabled = $list_enabled_array[0];

                $radio_enabled_array1 = $_POST['radio_list_extra_'.$bansi_row];
                $radio_enabled_array = implode (", ", $radio_enabled_array1);

                if($list_enabled == ""){
                    $list_enabled = '0';
                }else{
                    $list_enabled = '1';
                }


				$none_alias_array = $_POST['radio_list_none_'.$bansi_row];
                $none_alias = $none_alias_array[0];

                $yes_alias_array = $_POST['radio_list_yes'];
                $yes_alias = $yes_alias_array[($j-1)];


                $no_alias_array = $_POST['radio_list_no'];
                $no_alias = $no_alias_array[($j-1)];

                $sql1 = "INSERT INTO `form_item`(`form_item_seq`,`form_create_id`,`optional`,`item_desc`,`item_val`,`list_normal`,`list_name1`,`list_name2`,`list_name3`,`list_enabled`,`list_name_extra`,`notes` ,`discription`,`created_at` , `updated_at`) VALUES
		('$j','$form_create_id' , '$checked', '$item_desc' , '$item' , '$default_list' , '$none_alias' , '$yes_alias' , '$no_alias' , '$list_enabled','$radio_enabled_array','$notes' ,'$disc' , '$created_by' , '$updated_by')";
                $result1 = mysqli_query($db, $sql1);
                if ($result1) {
                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Form Item created successfully.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Insert valid data';
                }

            }else if ($item != "") {

				$sql1 = "INSERT INTO `form_item`(`form_item_seq`,`form_create_id`,`optional`,`item_desc`,`item_val`,`notes` ,`discription`,`created_at` , `updated_at`) VALUES
		('$j','$form_create_id' , '$checked', '$item_desc' , '$item' , '$notes' ,'$disc' , '$created_by' , '$updated_by')";
				$result1 = mysqli_query($db, $sql1);
				if ($result1) {
					$message_stauts_class = 'alert-success';
					$import_status_message = 'Form Item created successfully.';
				} else {
					$message_stauts_class = 'alert-danger';
					$import_status_message = 'Error: Please Insert valid data';
				}
			}
		}
		$z++;
		$j++;
	}
//	$item_desc_array = $_POST['query_text'];
//
//	 $fetch_form_item_q = "select * FROM `form_item` WHERE form_create_id = '$form_create_id' order by form_item_seq+0 ASC";
//	 $result_ft = mysqli_query($db,$fetch_form_item_q);
//	 $j = 0;
//	 while ($rowc_ft_item = mysqli_fetch_array($result_ft)) {
//	 	 $fit = $rowc_ft_item['form_item_id'];
//		 $sql0 = "UPDATE `form_item` SET `form_item_seq`='$bansi_row_click[$j]' where form_item_id = '$fit'";
//		 $result0 = mysqli_query($db, $sql0);
//		 $j++;
//	 }

//	$resultremove = mysqli_query($db, "DELETE FROM `form_item` WHERE `form_create_id` = '$form_create_id'");


//	$j = 0;
//	for($i = 1; $i < $total_count; )
//	{
//		$bansi_row = $bansi_row_click[$j];
//		$itemarray = $_POST['item_'.$bansi_row];
//		$item = $itemarray[0];
//		$item_desc = $item_desc_array[$j];
//		$notes_array = $_POST['form_item_notes'];
//		$disc_array = $_POST['form_item_disc'];
//		$notes = $notes_array[$j];
//		$disc = $disc_array[$j];
//		$opt = $_POST['optional_'.$bansi_row];
//		$checked = 0;
//		if($opt != null && isset($opt) && isset($opt[0])){
//			$checked = 1;
//		}
//
//		if($item == "numeric")
//		{
//			$normal_array = $_POST['normal'];
//			$normal = $normal_array[$j];
//
//			echo "normal :- ".$normal;
//
//			$lower_tolerance_array = $_POST['lower_tolerance'];
//			$lower_tolerance = $lower_tolerance_array[$j];
//
//			echo "lower_tolerance :- ".$lower_tolerance;
//
//
//			$upper_tolerance_array = $_POST['upper_tolerance'];
//			$upper_tolerance = $upper_tolerance_array[$j];
//
//			echo "upper_tolerance :- ".$upper_tolerance;
//			$unit = $unit_of_measurement[$j];
//
//			$sql1 = "INSERT INTO `form_item`(`unit_of_measurement`,`optional`,`form_create_id`,`item_desc`,`item_val`,`numeric_normal`,`numeric_lower_tol`,`numeric_upper_tol`,`notes` ,`discription`,`created_at` , `updated_at`) VALUES
//		('$unit'  , '$checked' , '$form_create_id', '$item_desc' , '$item' , '$normal' , '$lower_tolerance' , '$upper_tolerance' , '$notes' ,'$disc' , '$created_by' , '$updated_by')";
//			$result1 = mysqli_query($db, $sql1);
//			if ($result1) {
//				$message_stauts_class = 'alert-success';
//				$import_status_message = 'Form Item created successfully.';
//			} else {
//				$message_stauts_class = 'alert-danger';
//				$import_status_message = 'Error: Please Insert valid data';
//			}
//
//		}
//		else if($item == "binary")
//		{
//			$default_binary_array = $_POST['default_binary_'.$bansi_row];
//			$default_binary = $default_binary_array[0];
//
//			$normal_binary_array = $_POST['normal_binary_'.$bansi_row];
//			$normal_binary = $normal_binary_array[0];
//
//			$yes_alias_array = $_POST['yes_alias'];
//			$yes_alias = $yes_alias_array[$j];
//
//			$no_alias_array = $_POST['no_alias'];
//			$no_alias = $no_alias_array[$j];
//
//			$sql1 = "INSERT INTO `form_item`(`form_create_id`,`optional`,`item_desc`,`item_val`,`binary_default`,`binary_normal`,`binary_yes_alias`,`binary_no_alias`,`notes` ,`discription`,`created_at` , `updated_at`) VALUES
//		('$form_create_id' , '$checked', '$item_desc' , '$item' , '$default_binary' , '$normal_binary' , '$yes_alias' , '$no_alias' , '$notes' ,'$disc' , '$created_by' , '$updated_by')";
//			$result1 = mysqli_query($db, $sql1);
//			if ($result1) {
//				$message_stauts_class = 'alert-success';
//				$import_status_message = 'Form Item created successfully.';
//			} else {
//				$message_stauts_class = 'alert-danger';
//				$import_status_message = 'Error: Please Insert valid data';
//			}
//
//		}
//
//		else if($item != "")
//		{
//
//			$sql1 = "INSERT INTO `form_item`(`form_create_id`,`optional`,`item_desc`,`item_val`,`notes` ,`discription`,`created_at` , `updated_at`) VALUES
//		('$form_create_id' , '$checked', '$item_desc' , '$item' , '$notes' ,'$disc' , '$created_by' , '$updated_by')";
//			$result1 = mysqli_query($db, $sql1);
//			if ($result1) {
//				$message_stauts_class = 'alert-success';
//				$import_status_message = 'Form Item created successfully.';
//			} else {
//				$message_stauts_class = 'alert-danger';
//				$import_status_message = 'Error: Please Insert valid data';
//			}
//
//		}
//
//
//
//		$i++;
//		$j++;
//	}


}
//header("Location:form_edit.php?id=$hidden_id");
//$finalid=urlencode( base64_encode($hidden_id));
$page = "form_edit.php?id=$hidden_id";
header('Location: '.$page, true, 303);
exit;

?>