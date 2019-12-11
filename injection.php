<?php
// cette page permet d'injecter manuellement les temperatures interieures dans la BDD
// les données proviennent d'un thermo peanut
//format du fichier csv :
//utc,local,celsius
//2017-10-18T14:10:15+00:00,2017-10-18T15:10:15+01:00,20.2
//2017-10-18T14:40:22+00:00,2017-10-18T15:40:22+01:00,20.2

$frequence = 30; // frequence des enregistrements en minutes

require_once("conf/config.inc.php");

//variable provenant de php
$fichier_ori = $_FILES['data']['name'] ; // nom du fichier d'origine
$fichier_tmp = $_FILES['data']['tmp_name']; //chemin et nom du fichier temporaire
$error = $_FILES['data']['error']; // code retour de l'upload

//verification extension du fichier
$extension = strrchr($fichier_ori, '.');
if ( $extension != '.csv') {
	die('extension du fichier non valide');
}
//verification code retour
if ( $error != 0) {
	die("erreur lors de l'upload");
}
	
$data = file($fichier_tmp);// ecrit les données du fichier dans un tableau
// verification contenu du fichier
if ( rtrim($data[0]) != 'utc,local,celsius') { // verification format du csv
	die("contenu du fichier incorrect");
}

// traitement 
$conn = connectMaBase($hostname, $database, $username, $password);

for ($i = 1; $i < count($data); $i++){ // pour chaque ligne du tableau
	list($UTC, $GMT, $temp) = explode(",",$data[$i]);//separe les champs

	$GMT = str_replace('T',' ',$GMT); // supprime le T
	$GMT = substr($GMT, 0, -9); // supprime les 9 caracteres de la fin( secondes et l'heure gmt)
	$temp = round($temp,1); // arrondi la temperature a 1 chiffre apres la virgule

	//recherche l'id correspondant  a la date
	$reqid = "select id from data WHERE dateB LIKE '$GMT:__'";
	$result = mysqli_query($conn,$reqid);
	$id = mysqli_fetch_row($result);
	
	$id_fin = $id[0] + $frequence ;
	// utilise l'id pour updater
	// $requete = "UPDATE data SET c138 = '$temp' WHERE id = $id[0]";
	$requete = "UPDATE data SET c138 = '$temp' WHERE id BETWEEN $id[0] AND $id_fin";
				
	echo "<br>" . $requete;
	//injection dans la BDD
	if (mysqli_query($conn,$requete)) {
		echo " => record updated successfully";
	} else {
		echo " => Erreur " ;
	}
}
mysqli_close($conn);
?>
