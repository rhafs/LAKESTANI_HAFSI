<?php
require_once "bdd.php";
require_once "menu.php";

// Le lien de déconnection ramène vers le fichier login.php, il faut donc détruire la session et en recommencer une nouvelle, et détruire le cookie contenant l'id de l'utilisateur.
if (isset($_SESSION["user_id"])) {
	session_destroy();
	session_start();
	setcookie("user_id", '', -1);
	// On crée une variable superglobale qui va servir à afficher la barre latérale normalement. En effet, la valeur du cookie n'est effective qu'après un raffraichissement de la page.
	$_SESSION["deconnection"]=true;
}

// Si le formulaire est envoyé
if (isset($_POST) && count($_POST)>0) {
	
	//Si le login est rempli et envoyé et pas vide, ou constitué uniquement d'espaces
	if (isset($_POST['login']) && trim($_POST['login']) != "") {
		
		// Si le mot de passe est rempli et envoyé et pas vide, ou constitué uniquement d'espaces
		if (isset($_POST['pass']) && trim($_POST['pass']) != "") {
			
			$bdd = Connect_db();
			
			$utilisateur = array();
			
			$query=$bdd->prepare('SELECT id,nom,type
                       			FROM user
                       			WHERE login = ? and password = ?
                       ');
			$query->execute(array($_POST['login'],$_POST['pass']));
			
			// Si l'utilisateur est enregistré et qu'il a tapé le bon mot de passe
			if($data = $query->fetch()) {
				$utilisateur = $data;
			}
			
			$query->closeCursor();
			
			//print_r($utilisateur);
			
			//connection ok
			if (isset($utilisateur['nom'])) {
				$login = 0;
				
				//fixer les variables de session
				$_SESSION['login'] = $_POST['login'];
				$_SESSION["user_id"] = $utilisateur['id'];
				$_SESSION['user_nom'] = $utilisateur['nom'];
				$_SESSION['user_type'] = $utilisateur['type'];
				
				//Crée un cookie qui expire dans 30 jours et qui contient l'id de l'utilisateur
				setcookie("user_id", $_SESSION["user_id"], time() + 30 * 24 * 3600);
				
			} else {
				//Si l'utilisateur n'est pas enregistré ou que le mot de passe est incorrect
				$login = 1;
			}
			
		} else {
			// si seulement le mot de passe est manquant
			$login = 4;
		}
	} else {
		
		if ((isset($_POST['pass']) && trim($_POST['pass']) == "")) {
			//si le login et le mot de passe sont manquants
			$login = 5;
		} else {
			//login manquant
			$login = 3;
		}
	}
	
} else {
	// Dans le cas de la déconnexion, il n'y a pas de variables passées en post
	$login = 2;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="assets/style.css">
	<link rel="stylesheet" type="text/css" href="assets/add_style.css">
    <title>Blog sur Christopher Nolan</title>
  </head>
 <body>
	<?php 
	afficherMenu();
	?>
	<div class="content">
		<?php 
		if ($login == 0 || isset($_SESSION['login'])) {

			echo "<section class='left_side'>" ;
			echo "Bienvenue ".$_SESSION['user_nom']."!";
			echo "</section>";
			
		} else {
		
			?>
			<section class="left_side">
				<?php 
				if ($login == 1) {
					echo "L'utilisateur n'existe pas dans la base ou le mot de passe est incorrect.";
				}
				if ($login == 2) {
					echo "Vous avez été déconnecté.";
				}
				if ($login == 3) {
					echo "Le login est manquant.";
				}
				if ($login == 4) {
					echo "Le mot de passe est manquant.";
				}
				if ($login == 5) {
					echo "Le login et le mot de passe sont manquants.";
				}
				?>
			</section>
			<?php 
		}
		afficherZone();
		?>
		
	</div>
	<?php
	afficherFooter()
	?>
 </body>
</html>
