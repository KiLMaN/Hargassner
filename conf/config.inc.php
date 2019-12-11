<?php
//****vos parametres **************************************************** 	
$IPchaudiere = "192.168.1.108"; // indiquez l'IP de votre chaudiere
$firmware= "14j" ; // valeur possible voir dans stockBDD.php , si votre firmware est plus recent utilisez le dernier dispo

$port = 23; //port telnet, ne pas modifier
$mode_conn = 'telnet'; // mode de connexion : telnet pour chaudiere recente ou serial pour les anciennes 
						// en mode serial la page d'acceuil ne fonctionne plus en temps reel mais utilise la BDD
$taille_silo = 3000; // en kg , il s'agit de la capacité max du silo

$refresh = 10; //rafraichissement en sec de l'etat de la chaudiere , ne pas descendre sous les 2 car le telnet de la chaudiere n'arrive plus a repondre assez vite
$histo_temps = 30; //historique du graphique de la page d'accueil en mn

// MySQL config
$hostname = "127.0.0.1:3306"; //127.0.0.1 si la BDD est sur la meme machine que le serveur web , sinon IP . 3306 MySQL 5 , 3307 MySQL 10
$database = "hargassner"; // nom de la BDD
$username = "hargassner"; // utilisateur mysql
$password = "password";

//*****couleurs (code couleur HTML)************************************************	
$color_TdepD = '#781BE1'; 
$color_TdepE = '#EA7C01';
$color_Tchaud = '#E662CC';
$color_Tchauddoit = '#6F3263';
$color_Text = '#11C4F0';
$color_TextM = '#1930F0'; 
$color_Tint = '#19AF09';
$color_etat = '#01AEE3';
$color_puiss = 'red';
$color_fum = 'black';
$color_O2 = '#01DF01';
$color_O2doit = '#0C750C';
$color_gran = '#108BE0';
$color_aspi = '#1F4AEA';
$color_extrac = '#04E9A4';
$color_varF = '#1F4AEA';
$color_varK = '#E900BB';
$color_regul = '#0040A8';
$color_bois = '#E97E04';
$color_decend = '#AAFFAC';
$color_legend = '#DBEDFF'; 
$color_ECS_T = '#b7950b';
$color_ECS_etat = '#B4EDFE';

//*****ne pas modifier ci dessous************************************************	
$histo_live_shift = $histo_temps * 60 / $refresh; // nombre de valeur avant de shift
$histo_live_X = $histo_temps * 60; // init longueur axe X du graphe live 

//Chart localization
$months = "['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre']";
$weekdays = "['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']";
$shortMonths = "['Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin',  'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec']";
$thousandsSep = "''"; // thousands separator 

// ************* connection to MySQL, **********************************************
function connectMaBase($hostname, $database, $username, $password){
    $Conn = mysqli_connect ($hostname, $username, $password,$database);  
    return $Conn;
}
?>
