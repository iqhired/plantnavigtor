<?php include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$station = $_POST['station'];
$def_ch = $_POST['def_ch'];
$sql1 = "SELECT * FROM `cam_line` WHERE line_id = '$station'";
$result1 = mysqli_query($db,$sql1);
while ($cam1 = mysqli_fetch_array($result1)){
    $station1 = $cam1['line_id'];
    $station2 = $cam1['line_name'];
}
$sqlmain = "SELECT * FROM `sg_station_event` where `line_id` = '$station1' and event_status = 1";
$resultmain = mysqli_query($db,$sqlmain);
if(!empty($resultmain)){
    $rowcmain = $resultmain->fetch_assoc();
    if(!empty($rowcmain)){
        $part_family = $rowcmain['part_family_id'];
        $part_number = $rowcmain['part_number_id'];
        $station_event_id = $rowcmain['station_event_id'];
    }

    if(!empty($part_number)){
        $sqlpnum= "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
        $resultpnum = mysqli_query($db,$sqlpnum);
        $rowcpnum = $resultpnum->fetch_assoc();
        $pm_npr= $rowcpnum['npr'];
        if(empty($pm_npr))
        {
            $npr = 0;
        }else{
            $npr = $pm_npr;
        }

        $sql2 = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where sg_station_event.line_id = '$station1' and sg_station_event.event_status = 1" ;
        $result2 = mysqli_query($db,$sql2);
        $total_time = 0;
        $row2=$result2->fetch_assoc();
        $total_gp =  $row2['good_pieces'] + $row2['rework'];

        $sql3 = "SELECT * FROM `sg_station_event_log` where 1 and event_status = 1 and station_event_id = '$station_event_id' and event_cat_id in (SELECT events_cat_id FROM `events_category` where npr = 1)" ;
        $result3 = mysqli_query($db,$sql3);
        $ttot = null;
        $tt = null;
        while ($row3 = $result3->fetch_assoc()) {
            $ct = $row3['created_on'];
            $tot = $row3['total_time'];
            if(!empty($row3['total_time'])){
                $ttot = explode(':' , $row3['total_time']);
                $i = 0;
                foreach($ttot as $t_time) {
                    if($i == 0){
                        $total_time += ( $t_time * 60 * 60 );
                    }else if( $i == 1){
                        $total_time += ( $t_time * 60 );
                    }else{
                        $total_time += $t_time;
                    }
                    $i++;
                }
            }else{
                $total_time +=  strtotime($chicagotime) - strtotime($ct);
            }
        }
        $total_time = (($total_time/60)/60);
        $b = round($total_time);
        $target_eff = round($npr * $b);
        $actual_eff = $total_gp;
        if( $actual_eff ===0 || $target_eff === 0 || $target_eff === 0.0){
            $eff = 0;
        }else{
            $eff = round(100 * ($actual_eff/$target_eff));
        }
        // $pm_avg_npr = (($target_npr + 2) > 0)? ($target_npr + 2) : $target_npr;
        $posts[] = array( 'target_eff'=> $target_eff,  'actual_eff'=> $actual_eff, 'eff'=> $eff,);

    }
    $response['posts'] = $posts;
    echo json_encode($response);

}
