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
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <title>Blog sur Christopher Nolan</title>
  </head>
 <body>
	
	<?php 
	//affichager d'header de la page
	afficherMenu();
	?>
	
	<div class="content">
		<div class="left_side">
			<article>
			<?php 
			$bdd = Connect_db();
			
			/*
			$query=$bdd->prepare('SELECT resume
                       FROM article
                       WHERE id = ?
                       ');
			$query->execute(array(1));
			**/
			
			$query=$bdd->prepare('SELECT id,titre,resume,image
                       FROM article
                       WHERE date = (select max(date) from article)
                       ');
			$query->execute();
			
			//initialise un tableau pour récupérer indice + contenu
			//$test = array();
			
			$test = "";
			
			//dans la boucle on récupère un enregistrement qui est mis dans data
			while($data = $query->fetch()) { // lecture par ligne
				//crochets pour ajouter chaque ligne de data ds test
				$test = $data;
				
			} // fin des données
			
			//affichage du contenu de test
// 			echo "<pre>";
// 				print_r($test);
// 				echo "</pre>";
			
			$query->closeCursor();
			
			echo "<h1>";
			echo $test['titre'];
			echo "</h1>";
			
			echo $test['resume'];
			echo "<img src='".$test['image']."'>";
			
			?>
			<br><br>
			<!-- href avant =bibliographie, fait le lien entre le résumé de la page d'accueil et lire la suite -->
			<a href="contenu.php?id=<?=$test['id']?>">Lire la suite</a>
				
			</article>
			
			<?php 
			
			$data = "";
			$query=$bdd->prepare('SELECT user.nom,commentaire.date,commentaire.contenu
                       FROM commentaire inner join user on user.id = commentaire.user_id
                       WHERE commentaire.date = (select max(date) from commentaire where article_id = ?) '.
						'and commentaire.article_id = ?');
			$query->execute(array($test['id'],$test['id']));
			$data = $query->fetch();
			
			//print_r($test);
			
			?>
			
			<div class="comments">
				<section class="comment_header">
					<h2>Dernier commentaire :</h2>
				</section>
				<?php
				if (is_array($data)) {
					afficherCommentaire($data['nom'], $data['date'], $data['contenu']);
				}
				?>
			</div>
			
		</div>
		<?php 
		afficherZone();
		?>
	</div>
	<footer>
		<img alt="logo de Lyon 1" src="assets/IUTLyon1.png"/>
		<p>HAFSI Rachida LAKESTANI Diane</p>
	</footer>
 </body>
</html>
