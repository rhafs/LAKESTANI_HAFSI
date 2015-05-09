<?php

include_once "..\BaseDon.php";

$nom_fichier = $_FILES['fileToUpload']['name'];
$tmpName     = $_FILES['fileToUpload']['tmp_name'];

$path = str_replace("/", '\\\\', $_SESSION['Eboost']['server_path']);
$path = $path."data\\logo\\".strtolower($_SESSION['DOMAINE'])."\\";

if ($nom_fichier == 'logolde.jpg') {
	echo "erreur;";
	exit;
}

if(move_uploaded_file ($tmpName,$path.$nom_fichier)) {
	echo "Fichier OK;";
} else {
	echo "erreur;";
}

?>
