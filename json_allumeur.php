<?php
//appelé par ajax, 

require_once("conf/config.inc.php");
 

	header("Content-type: text/json");
                // select DATE(dateB), SUM(c0) FROM(
                // select dateB,c0/5 as c0 from data

    $query1 = "
                select DATE(dateB), count(c0) FROM(
                select dateB,c0 from data
                where dateB > DATE_SUB(NOW(), INTERVAL 30 DAY) AND c0 = '5'
                GROUP by DATE(dateB),HOUR(dateB)  
                ) as tmp
                GROUP BY DATE(dateB)";

$conn=    connectMaBase($hostname, $database, $username, $password);
    $req1 = mysqli_query($conn,$query1) ;
	mysqli_close($conn);
    
    while($data = mysqli_fetch_row($req1)){
        $dateD = strtotime($data[0]) * 1000;
        // $dateD = (strtotime($data[0])+ 10000) * 1000;
        $liste1[] = [$dateD, $data[1]];
    }

   echo json_encode($liste1, JSON_NUMERIC_CHECK);
   
    

?>
