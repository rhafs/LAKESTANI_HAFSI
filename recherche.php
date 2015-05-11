<?php 
//ini_set("display_errors", "on");
//error_reporting(-1);

require_once "bdd.php";
require_once "menu.php";

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
    <link rel="stylesheet" type="text/css" href="assets/search_style.css">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Blog sur Christopher Nolan</title>
  </head>
 <body>
	<?php 
	
	afficherMenu();
	?>
	<div class="content">
	
		<section class="left_side">
			<?php 
			
			//ZONE DE RECHERCHE - LOGIQUE
			// On initialise $search à vide pour le cas où on arrive sur la page recherche.php sans être passé par le bouton recherche
			$search = "";
			$requete = true;
			// Si on a passé qqc en Get et que ce n'est pas vide
			if (isset($_GET) && count($_GET) > 0) {
				//Si on a passé la clé the_search et qu'elle n'est pas vide.
				if (trim($_GET['the_search']) != "") {
					$search = $_GET['the_search'];
				} else {
					$requete = false;
				}
			}
			
			//AFFICHAGE DES ARTICLES
			if ($requete)
				$tabArticle = getAllArticles($search);
			else
				$tabArticle = array();
			
			if (empty($tabArticle))
			{
				// Si la recherche n'est pas vide
				if ($search != "") {
					echo "Pas de résultat pour la recherche : ".$search;
				} else {
					//Si on arrive sur la page recherche.php sans passer par le bouton de recherche
					echo "Vous n'avez pas saisi de recherche ou la base de données est vide.";
				}
				
				
			} else {
				?>
				<h1>Liste des articles</h1>
				<table>
				<tr>
					<th>Titre</th>
					<th>Date de publication</th>
				</tr>
				<?php 
				/*
				echo "<pre>";
				print_r($tabArticle);
				echo "</pre>";
				*/
				
				foreach ($tabArticle as $head => $data) {
					echo "<tr>";
					
					// La fonction convertDate permet de convertir une date au format sql à une date à un format lisible
					echo "<td><a href='contenu.php?id=".$data['id']."'>".$data['titre']."</a></td>".
							"<td>".convertDate($data['derniere_date'])."</td>";
					
					echo "</tr>";
				}
				?></table>
				<?php
			}

			?>

		</section>
		<?php 
		afficherZone();
		?>
	</div>
	<?php
	afficherFooter()
	?>
 </body>
</html>
