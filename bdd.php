<?php
/* Le ficehier bdd.php est inclus au début de chaque page, donc il est mieux de faire commencer la session ici
pour qu'elle reste active sur chaque page et que l'on puisse se resservir des variables de session entre toutes les pages. */
session_start();


function Connect_db() {
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
	
	$id = $bdd->lastInsertId();
	
	$query->closeCursor();
	
	// On retourne le dernier id ajouté à la dernière table modifiée de la base
	return $id;
}

function majArticle($titre,$resume,$contenu,$file,$id) {

	$bdd = Connect_db();

	//pour differencier les images uploadées par deux users différents qui ont le même nom, on récupère l'extension du fichier dans file_t[1], le nouveau nom du fichier de l'image aura la date ajoutée

	$file_t = explode(".", $file);
	// La fonction date affiche la date du jour au format YmdHis
	$filename = "data\\".$file_t[0]."_".date("YmdHis").".".$file_t[1];

	rename("data\\".$file, $filename);

	$query=$bdd->prepare('update article set titre = ?, resume = ?, contenu = ?, image = ?,derniere_date = ? '.
							' where id = ?');
	// La fonction date affiche la date du jour au format YmdHis séparés par des - et des :
	$query->execute(array($titre,$resume,$contenu,$filename,date("Y-m-d H:i:s"),$id));
	
	$query->closeCursor();

}

function addCommentaire($id_article,$comm) {

	$bdd = Connect_db();

	$query=$bdd->prepare('insert into commentaire(user_id,article_id,contenu) values (?,?,?)');
	//On a fixé la variable $_SESSION['user_id'] dans le fichier login. La fonction addslashes permet d'échapper les simples quotes.
	$query->execute(array($_SESSION['user_id'],$id_article,addslashes($comm)));

	$query->closeCursor();
}

function getArticle($id) {

	$bdd = Connect_db();

	//tableau de retour
	$ret = array();

	$sql = "SELECT * FROM article WHERE id = :id";
	$query=$bdd->prepare($sql);
	$query->execute(array(':id' => $id));

	//dans la boucle on récupère un enregistrement qui est mis dans data
	while($data = $query->fetch()) { // lecture par ligne
		//crochets pour ajouter chaque ligne de data ds test
		$ret = $data;

	}
	
	$query->closeCursor();

	return $ret;

}

function getAllArticles($search) {
	
	$bdd = Connect_db();
	
	//tableau de retour
	$ret = array();
	
	if ($search != "") {
		$sql = "SELECT id,titre,derniere_date FROM article WHERE titre LIKE :titre order by date asc";
		$query=$bdd->prepare($sql);
		$query->execute(array(':titre' => '%' . $search . '%'));
		
	} else {
		
		$sql = "SELECT id,titre,derniere_date FROM article order by date asc";
		$query=$bdd->prepare($sql);
		$query->execute();
	}
	
	//dans la boucle on récupère un enregistrement qui est mis dans data
	while($data = $query->fetch()) { // lecture par ligne
		//crochets pour ajouter chaque ligne de data ds test
		$ret[] = $data;
	
	}
	
	$query->closeCursor();
	
	return $ret;
	
}

function getMonth($numero) {
// Cette fonction convertit les numéros de mois en nom de mois
	$array = array(
		0 => "00",
		1 => "Janvier",
		2 => "Février",
		3 => "Mars",
		4 => "Avril",
		5 => "Mai",
		6 => "Juin",
		7 => "Juillet",
		8 => "Août",
		9 => "Septembre",
		10 => "Octobre",
		11 => "Novembre",
		12 => "Décembre"
	);
	
	return $array[(int)$numero];
}

function convertDate($input) {
	
	//format sql yyyy-mm-dd hh:mm:ss
	//jj mois annee 'heure'h'minutes'
	
	/* La fonction explode sépare une chaine en sous chaines en spécifiant le séparateur.
	 * $date est un tableau contenant la date et l'heure
	 * $date_1 contient l'année, la date et le jour en tableau
	 * $time est un tableau contenant l'heure
	 */
	$date = explode(" ", $input);
	$date_1 = explode("-", $date[0]);	
	$time = explode(":", $date[1]);
	
	/*$date_1[2] contient le numéro du jour
	 * $date_1[1] contient le numéro du mois
	 * $date_1[0] contient l'année
	 * $time[0] contient l'heure
	 * $time[1] contient les minutes
	 * $time[2] contient les secondes mais on ne les affiche pas
	 */
	$date = $date_1[2]." ".getMonth($date_1[1])." ".$date_1[0]." ".$time[0]."h".$time[1];
	
	return $date;	
}


?>