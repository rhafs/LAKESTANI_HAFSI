<?php
/* Le fichier bdd.php est inclus au début de chaque page, donc il est mieux de faire commencer la session ici
pour qu'elle reste active sur chaque page et que l'on puisse se resservir des variables de session entre toutes les pages. */
session_start();


 
function Connect_db() {
	$host="localhost"; // ou sql.hebergeur.com
	$user="root";      // ou login
	$password="";      // ou xxxxxx
	$dbname="sitenolan";
	
	/* Par défaut ATTR_ERRMODE est en mode silent, de cette façon on aura des alertes et des exceptions au moment de la connection à la base de données.
	Il faut faire attention à placer le setAttribute au moment du try catch. */
	
	try {
		$bdd=new PDO('mysql:host='.$host.';dbname='.$dbname.
				';charset=utf8',$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		return $bdd;
	} catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}
}


function addArticle($titre,$resume,$contenu,$file) {
	
	$bdd = Connect_db();
	
	//pour differencier les images uploadées par deux users différents mais les images ont le même nom
	// La fonction explode sépare la variable $file en deux sous variables:file_t[0]contient le nom du fichier et file_t[1] contient l'extension
	$file_t = explode(".", $file);
	$filename = "data/".$file_t[0]."_".date("YmdHis").".".$file_t[1];
	
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
	$filename = "data/".$file_t[0]."_".date("YmdHis").".".$file_t[1];

	rename("data\\".$file, $filename);

	$query=$bdd->prepare('update article set titre = ?, resume = ?, contenu = ?, image = ?,derniere_date = ? '.
							' where id = ?');
	// La fonction date affiche la date du jour au format YmdHis séparée par des - et des :
	$query->execute(array($titre,$resume,$contenu,$filename,date("Y-m-d H:i:s"),$id));
	
	$query->closeCursor();

}

function addCommentaire($id_article,$comm) {

	$bdd = Connect_db();

	$query=$bdd->prepare('insert into commentaire(user_id,article_id,contenu) values (?,?,?)');
	//On a fixé la variable $_SESSION['user_id'] dans le fichier login.php.
	$query->execute(array($_SESSION['user_id'],$id_article,$comm));

	$query->closeCursor();
}

function getArticle($id) {

	$bdd = Connect_db();

	//tableau de retour
	$retour = array();

	$sql = "SELECT * FROM article WHERE id = :id";
	$query=$bdd->prepare($sql);
	$query->execute(array(':id' => $id));

	//on récupère un enregistrement qui est mis dans data
	if($data = $query->fetch()) { // lecture par ligne
		$retour = $data;
	}
	
	$query->closeCursor();

	return $retour;

}

// Fonction qui permet de récupérer tous les articles de la base pour la page recherche.php
function getAllArticles($search) {
	
	$bdd = Connect_db();
	
	//tableau de retour
	$retour = array();
	
	if ($search != "") {
		$sql = "SELECT id,titre,derniere_date FROM article WHERE titre LIKE :titre order by derniere_date asc";
		$query=$bdd->prepare($sql);
		// On peut faire une recherche avec la recherche incluse dans le titre d'un article
		$query->execute(array(':titre' => '%' . $search . '%'));
		
	} else {
		// Si on est arrivé sur la page recherche.php sans être passé par le bouton de recherche
		$sql = "SELECT id,titre,derniere_date FROM article order by derniere_date asc";
		$query=$bdd->prepare($sql);
		$query->execute();
	}
	
	//dans la boucle on récupère un enregistrement qui est mis dans data
	while($data = $query->fetch()) { // lecture par ligne
		//crochets pour ajouter chaque ligne de data ds $retour
		$retour[] = $data;
	}
	
	$query->closeCursor();
	
	return $retour;
	
}

function getMonth($numero) {
// Cette fonction convertit les numéros de mois en noms de mois
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
	
	//on caste pour le cas où on ait 03 au lieu de 3 par exemple
	return $array[(int)$numero];
}

function convertDate($input) {
	
	//format sql : yyyy-mm-dd hh:mm:ss
	//format affiché : jj mois annee 'heure'h'minutes'
	
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