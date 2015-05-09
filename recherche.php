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
			$search = "";
			$requet = true;
			if (isset($_GET) && count($_GET) > 0) {
				if (trim($_GET['the_search']) != "") {
					$search = $_GET['the_search'];
				} else {
					$requet = false;
				}
			}
			
			//AFFICHAGE DES ARTICLES
			if ($requet)
				$tabArticle = getAllArticles($search);
			else
				$tabArticle = array();
			
			if (empty($tabArticle)) {

				if ($search != "") {
					echo "Pas de résultat pour la recherche : ".$search;
				} else {
					echo "Vous n'avez pas saisi de recherche";
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
			
				foreach ($tabArticle as $head => $data) {
					echo "<tr>";
					
					echo "<td><a href='contenu.php?id=".$data['id']."'>".$data['titre']."</a></td>".
							"<td>".convertDate($data['date'])."</td>";
					
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
	<footer>
		<img alt="logo de Lyon 1" src="assets/IUTLyon1.png"/>
		<p>HAFSI Rachida LAKESTANI Diane</p>
	</footer>
 </body>
</html>
