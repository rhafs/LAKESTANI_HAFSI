<?php 
// Toutes les fonctions d'affichage sont dans menu.php, et les autres fonctions sont dans bdd.php
require_once "bdd.php";
require_once "menu.php";

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <title>Blog sur Christopher Nolan</title>
  </head>
 <body>
	
	<?php 
	//affichage du menu et du bandeau supérieur de la page
	afficherMenu();
	?>
	
	<div class="content">
		<section class="left_side">
			<article>
			<?php 
			$bdd = Connect_db();
			
			//récupération de l'article ajouté en dernier
			$query=$bdd->prepare('SELECT id,titre,resume,image
                       FROM article
                       WHERE date = (select max(date) from article)
                       ');
			$query->execute();
			
			/* On initialise $dernier_article pour traiter le cas où il n'y a aucun article dans la base de données.
			Au cas où on ne passe pas dans le if, la variable dernier_article n'existerait pas, et on ne peut pas tester l'existence d'une variable en php.*/
			$dernier_article = "";
			
			/*Dans la boucle on récupère un enregistrement qui est mis dans data. Il n'y a qu'un seul résultat, donc on met un if et non un while.
			On veut réutiliser le tableau retourné par la requête plus tard donc on le conserve dans une variable.*/
			if($data = $query->fetch()) { // lecture par ligne
				$dernier_article = $data;
			} // fin des données
			
			//affichage du contenu de dernier_article
			// echo "<pre>";
			// print_r($dernier_article);
			// echo "</pre>";
			
			$query->closeCursor();
			
			if ($dernier_article != "") {
			
				echo "<h1>";
				echo $dernier_article['titre'];
				echo "</h1>";
				
				echo $dernier_article['resume'];
				// $dernier_article['image'] contient le chemin vers l'image dans le dossier data du site
				echo "<img src='".$dernier_article['image']."'>";
				
				?>
				<br><br>
				<!-- href fait le lien entre le résumé de la page d'accueil et lire la suite. On passe en Get l'id du dernier article. -->
				<a href="contenu.php?id=<?=$dernier_article['id']?>">Lire la suite</a>
					
				</article>
				
				<?php 
				/* Récupération du dernier commentaire de l'article. On traite le cas où deux utilisateurs différents ajoutent 
				 * deux commentaires pour deux articles différents exactement en même temps. En effet, le dernier commentaire ajouté
				 * ne correspond pas forcément à celui du dernier article.
				 On fait une jointure entre les tables user et commentaire car on veut récupérer le nom de l'utilisateur.
				 */
				$query=$bdd->prepare('SELECT user.nom,commentaire.date,commentaire.contenu
	                       FROM commentaire inner join user on user.id = commentaire.user_id
	                       WHERE commentaire.date = (select max(date) from commentaire where article_id = ?) 
							and commentaire.article_id = ?'
									);
				$query->execute(array($dernier_article['id'],$dernier_article['id']));
				$dernier_commentaire = $query->fetch();
				$query->closeCursor();
				
				//print_r($dernier_article);
				
				if ($dernier_commentaire) {
				?>
				<div class="comments">
					<section class="comment_header">
						<h2>Dernier commentaire :</h2>
					</section>
					<?php
					// On envoie en paramètres de la fonction les données récupérées, c'est-à-dire les données du dernier commentaire du dernier article
					afficherCommentaire($dernier_commentaire['nom'], $dernier_commentaire['date'], $dernier_commentaire['contenu']);
					?>
				</div>
				<?php
				} else {
					echo "Cet article n'a aucun commentaire, vous pouvez en ajouter un en cliquant sur Lire la suite."; 
				}	
		
			} else {
				echo "Il n'y a aucun article dans la base de données.";
			}
			
			?>
			</section>
			<?php 
			// Cette fonction permet d'afficher la barre latérale.
			afficherZone();
			?>
	</div>
	<?php
	// Cette fonction affiche le pied de page.
	afficherFooter()
	?>
 </body>
</html>
