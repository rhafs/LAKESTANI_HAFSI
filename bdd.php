<?php
session_start();


function Connect_db(){
	$host="localhost"; // ou sql.hebergeur.com
	$user="root";      // ou login
	$password="";      // ou xxxxxx
	$dbname="sitenolan";
	try {
		$bdd=new PDO('mysql:host='.$host.';dbname='.$dbname.
				';charset=utf8',$user,$password);
		return $bdd;
	} catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}
	
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
}


function addArticle($titre,$resume,$contenu,$file) {
	
	$bdd = Connect_db();
	
	//pour differencier les images uploadées par deux users divférents qui ont le même nom
	
	$file_t = explode(".", $file);
	$filename = "data\\".$file_t[0]."_".date("YmdHis").".".$file_t[1];
	
	rename("data\\".$file, $filename);
	
	$query=$bdd->prepare('insert into article(user_id,titre,resume,contenu,image) values (?,?,?,?,?)');
	$query->execute(array($_SESSION['user_id'],$titre,$resume,$contenu,$filename));
	
	//print_r($query);
// 	print_r($bdd->errorInfo());
	
// 	if (!$query) {
// 		echo "\nPDO::errorInfo():\n";
// 		print_r($bdd->errorInfo());
// 	}

	return $bdd->lastInsertId();
	
}

function addCommentaire($id_article,$comm) {

	$bdd = Connect_db();

	$query=$bdd->prepare('insert into commentaire(user_id,article_id,contenu) values (?,?,?)');
	$query->execute(array($_SESSION['user_id'],$id_article,addslashes($comm)));

	//print_r($query);
	//print_r($bdd->errorInfo());

// 	if (!$query) {
// 		echo "\nPDO::errorInfo():\n";
// 		print_r($bdd->errorInfo());
// 	}

}

function getAllArticles($search) {
	
	$bdd = Connect_db();
	
	//tableau de retour
	$ret = array();
	
	if ($search != "") {
		$sql = "SELECT id,titre,date FROM article WHERE titre LIKE :titre order by date asc";
		$query=$bdd->prepare($sql);
		$query->execute(array(':titre' => '%' . $search . '%'));
		
	} else {
		
		$sql = "SELECT id,titre,date FROM article order by date asc";
		$query=$bdd->prepare($sql);
		$query->execute();
	}
	
	//dans la boucle on récupère un enregistrement qui est mis dans data
	while($data = $query->fetch()) { // lecture par ligne
		//crochets pour ajouter chaque ligne de data ds test
		$ret[] = $data;
	
	}
	
	return $ret;
	
}

function getMonth($numero) {
	
	$array = array(
		0 => "00",
		1 => "Janvier",
		2 => "Février",
		3 => "Mars",
		4 => "Avril",
		5 => "Mai",
		6 => "Janvier",
		7 => "Janvier",
		8 => "Janvier",
		9 => "Janvier",
		10 => "Janvier",
		11 => "Janvier",
		12 => "Janvier"
	);
	
	return $array[(int)$numero];
}

function convertDate($input) {
	
	//2015-05-09 14:51:46
	//22 mars 2015 15h23
	
	$date = explode(" ", $input);
	$date_1 = explode("-", $date[0]);	
	$time = explode(":", $date[1]);
	
	$date = $date_1[2]." ".getMonth($date_1[1])." ".$date_1[0]." ".$time[0]."h".$time[1];
	
	return $date;	
}


?>