<?php
// appelé par ajax, renvoi les series de data pour la saison en cours

require_once("conf/config.inc.php");
 

	header("Content-type: text/json");

    if (date('n') == 9 ){// formule permettant de commencer en septembre
		$limit = 1;
	}
	else {
		$limit = abs(date('n') +4); 
	}
    $query = "SELECT YEAR(dateB), MONTH(dateB),SUM(conso),FORMAT(AVG(Tmoy),1) FROM consommation 
            GROUP BY YEAR(dateB), MONTH(dateB)
            ORDER BY dateB DESC LIMIT " . $limit;
              
	$conn =	connectMaBase($hostname, $database, $username, $password);
    $req = mysqli_query($conn,$query) ;
	mysqli_close($conn);

//pre-remplissage avec des null en cas d'année incomplete
$cons = [null,null,null,null,null,null,null,null,null,null,null,null]; 
$Tmoy = [null,null,null,null,null,null,null,null,null,null,null,null]; 

// decalage des mois pour debut saison en septembre    
$mois = ['9' => 0, '10' => 1, '11' => 2, '12' => 3, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8, '6' => 9, '7' => 10, '8' => 11];

    while($data = mysqli_fetch_row($req)){
        $annee = $data[0];
        $cons[$mois[$data[1]]] = $data[2];        
        $Tmoy[$mois[$data[1]]] = $data[3];        
    }
    $saison = $annee." / ".($annee + 1);
    $tableau = [$cons, $Tmoy, $saison];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
