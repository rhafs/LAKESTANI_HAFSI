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
	<link rel="stylesheet" type="text/css" href="assets/add_style.css">
    <title>Blog sur Christopher Nolan</title>
  </head>
 <body>
	<?php 
	afficherMenu();
	?>
	
	<div class="content">
	
		<?php 
		if (isset($_SESSION['user_type']) && $_SESSION['user_type']== 1 ) {
		?>
			<section class="left_side">
			
			<?php 
			
			$faireAjout = false;
			
			//ajout d'un article
			if (isset($_POST) && count($_POST) > 0) {
				//recup info sur article
				$titre = $_POST['titre'];
				$resume = $_POST['resume'];
				$contenu = $_POST['contenu'];
			
				$faireAjout = true;
			
				if (trim($titre) == "") {
			
					echo "Titre est vide <br>";
					$faireAjout = false;
				}
			
				if (trim($resume) == "") {
						
					echo "Résume est vide <br>";
					$faireAjout = false;
				}
			
				if (trim($contenu) == "") {
						
					echo "Contenu est vide <br>";
					$faireAjout = false;
				}
			
				if (isset($_FILES) && $_FILES['image']['error'] == 4) {
					echo "Image est vide";
					$faireAjout = false;
				}
			
				if ($faireAjout) {
						
					//recup image (blob)
					$nom_fichier = $_FILES['image']['name'];
					move_uploaded_file($_FILES['image']['tmp_name'], "data\\".$nom_fichier);
						
					$id = addArticle($titre,$resume,$contenu,$nom_fichier);
					
					/*
					//récup de dernier id saisi
					$query=$bdd->prepare('SELECT id
                       FROM article
                       WHERE date = (select max(date) from article)
                       ');
					$query->execute();
			
					//$tabArticle = getAllArticles("");
					 * */
					
					echo "Votre article a bien été ajouté.";
					echo "<a href='contenu.php?id=".$id."'>Lien vers article </a>";
						
				}
			
			} else {
				$titre = "";
				$resume = "";
				$contenu = "";
			}
			
			?>
			<?php 
			
			if (!$faireAjout) {
			?>
				<h1>Vous pouvez ajouter un nouvel article</h1>
				<form action="ajout.php" method="post" enctype="multipart/form-data" class="formulary">
					<label>Titre de l&apos;article : 
					<input type="text" name="titre" value='<?=$titre?>'></label>
					<label>R&eacute;sum&eacute; de l&apos;article : 
					<textarea name="resume" rows=2><?=$resume?></textarea></label>
					<label>Contenu de l&apos;article : 
					<textarea name="contenu"><?=$contenu?></textarea></label>
					<label>Choisissez l&apos;image &agrave; associer &agrave; l&apos;article : 
					<input type="file" name="image"></label>
					<button>Soumettre l&apos;article</button>
				</form>
			<?php
			}
			
			?>
			</section>
			<?php
			
		} else {

			echo ("<section class='left_side'><h1>Accès interdit</h1></section>");
		}
		
		afficherZone();
		
		?>
		
	</div>
	
	<footer>
		<img alt="logo de Lyon 1" src="assets/IUTLyon1.png"/>
		<p>HAFSI Rachida LAKESTANI Diane</p>
		
	</footer>
 </body>
</html>
