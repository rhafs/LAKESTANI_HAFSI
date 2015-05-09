<?php 

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
			
			$test = "";
			
			//dans la boucle on r�cup�re un enregistrement qui est mis dans data
			while($data = $query->fetch()) { // lecture par ligne
				$test = $data;
			} // fin des donn�es
			
			//affichage du contenu de test
			// echo "<pre>";
			// print_r($test);
			// echo "</pre>";
			
			$query->closeCursor();
			
			if ($test != "") {
			
				echo "<h1>";
				echo $test['titre'];
				echo "</h1>";
				
				echo $test['resume'];
				echo "<img src='".$test['image']."'>";
				
				?>
				<br><br>
				<!-- href fait le lien entre le r�sum� de la page d'accueil et lire la suite -->
				<a href="contenu.php?id=<?=$test['id']?>">Lire la suite</a>
					
				</article>
				
				<?php 
				/* Récupération du dernier commentaire de l'article. On traite le cas où deux utilisateurs différents ajoutent 
				 * deux commentaires pour deux articles différents exactement en même temps. En effet, le dernier commentaire ajouté
				 * ne correspond pas forcément à celui du dernier article.
				 */
				$data = "";
				$query=$bdd->prepare('SELECT user.nom,commentaire.date,commentaire.contenu
	                       FROM commentaire inner join user on user.id = commentaire.user_id
	                       WHERE commentaire.date = (select max(date) from commentaire where article_id = ?) 
							and commentaire.article_id = ?'
									);
				$query->execute(array($test['id'],$test['id']));
				$data = $query->fetch();
				
				//print_r($test);
				
				if ($data != "") {
				?>
				<div class="comments">
					<section class="comment_header">
						<h2>Dernier commentaire :</h2>
					</section>
					<?php
					// On envoie en paramètres de la fonction les données récupérées, c'est-à-dire les données du dernier commentaire du dernier article
					if (is_array($data)) {
						afficherCommentaire($data['nom'], $data['date'], $data['contenu']);
					}
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
