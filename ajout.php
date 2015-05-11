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
		//Si un utilisateur est connecté en tant qu'administrateur
		if (isset($_SESSION['user_type']) && $_SESSION['user_type']== 1 ) {
		?>
			<section class="left_side">
			
			<?php 
			
			// flag qui dira si on peut ajouter un article ou pas
			$faireAjout = false;
			
			//ajout d'un article
			//On vérifiera si quelque chose a été passé en post et que ce ne soit pas vide
			if (isset($_POST) && count($_POST) > 0) {
				//recup info sur article à partir des valeurs passées en post
				$titre = htmlspecialchars($_POST['titre']);
				$resume = htmlspecialchars($_POST['resume']);
				$contenu = htmlspecialchars($_POST['contenu']);
				/* Si on a cliqué sur modifier l'article et qu'on a soumis le formulaire, $id contiendra l'id de l'article.
				En effet, quand on clique sur modifier, on passe en get l'id de l'article, et quand on soumet le formulaire, on passe en hidden et en post ce même id */
				$id = $_POST['id'];
			
				$faireAjout = true;
				// On vérifie que chaque champ du formulaire est rempli
				if (trim($titre) == "") {
			
					echo "Titre est vide <br>";
					//le flag devient false si un ou plusieurs champ n'est pas rempli
					$faireAjout = false;
				}
				
				if ($_POST['id'] == "") {
					// Si $_POST['id'] est vide ça veut dire qu'on est en mode ajout, sinon on est en mode modif
					$bdd = Connect_db();
					
					$sql = "SELECT count(1) as nb FROM article WHERE titre = :titre";
					$query=$bdd->prepare($sql);
					$query->execute(array(':titre' => $titre));
					
					$data = $query->fetch();
					
					// On vérifie s'il y a dans la base des articles portant déjà ce titre
					if ($data['nb'] > 0) {
						echo "Ce titre existe déjà<br>";
						// S'il existe un article portant ce titre, on met le drapeau à false comme ça on n'entre pas dans l'ajout ou la modification
						$faireAjout = false;
					}
					
					$query->closeCursor();
					
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
				
				
				//validation de fichier
				if (isset($_FILES['image']) && 
					$_FILES['image']['error'] == 0 && 
					$_FILES['image']['size'] <= 2097152) // 2MO
				{
					$infosfichier = pathinfo($_FILES['image']['name']);
					$ext_upload = $infosfichier['extension'];
					$ext_autorisees = array('jpg', 'jpeg', 'png');
						
					if (!in_array($ext_upload, $ext_autorisees)) {
						
						echo "Extension incorrecte";
						$faireAjout = false;
					}
					
				} else if($_FILES['image']['size'] > 2097152){
					echo "Fichier trop grand ";
					$faireAjout = false;
				}
				
				// Si faireAjout est vrai alors tous les champs sont remplis, on peut ajouter ou modifier un article
				if ($faireAjout) {
						
					//recup image
					$nom_fichier = $_FILES['image']['name'];
					//On déplace l'image du fichier temporaire au dossier data du site
					move_uploaded_file($_FILES['image']['tmp_name'], "data\\".$nom_fichier);
					
					// Si $_POST['id'] n'est pas vide c'est que le formulaire a été rempli et qu'on est dans la modification
					if ($_POST['id'] != "") {
						// les valeurs passées en paramètres aux deux fonctions correspondent aux valeurs récupérées en post par le formulaire
						//-------- MODIFICATION -------------------
						majArticle($titre,$resume,$contenu,$nom_fichier,$_POST['id']);
						$id_article = $_POST['id'];
						$libelle = "modifié";
					} else {
					//-------- AJOUT -------------------
						$id_article = addArticle($titre,$resume,$contenu,$nom_fichier);
						$libelle = "ajouté";
					}
						
					echo "Votre article a bien été $libelle.";
					echo "<a href='contenu.php?id=".$id_article."'>Lien vers l'article </a>";
						
				}
			
			} else {
				$titre = "";
				$resume = "";
				$contenu = "";
				/* $id est vide si on accède à la page ajout.php sans avoir rempli le formulaire (au premier passage)
				 * $id est aussi vide si on n'a pas rempli un des champs.
				 */
				$id = "";
			}
			
			?>
			<?php 
			
			if (!$faireAjout) {

				if (isset($_GET['id']) && $_GET['id'] != "") {

					$article = getArticle($_GET['id']);
					
					//print_r($article);
					
					$titre = $article['titre'];
					$resume = $article['resume'];
					$contenu = $article['contenu'];
					$id = $article['id'];
				}

			?>
				<h1>Vous pouvez ajouter un nouvel article</h1>
				<form action="ajout.php" method="post" enctype="multipart/form-data" class="formulary">
					<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
					<!-- On met un hidden afin de conserver en post la valeur de l'id passée en get -->
					<input type="hidden" name="id" value='<?=$id?>'></label>
					<label>Titre de l&apos;article : 
					<input type="text" name="titre" value='<?=$titre?>'></label>
					<label>R&eacute;sum&eacute; de l&apos;article : 
					<textarea name="resume" rows=2><?=$resume?></textarea></label>
					<label>Contenu de l&apos;article : 
					<textarea name="contenu"><?=$contenu?></textarea></label>
					<label>Choisissez l&apos;image &agrave; associer &agrave; l&apos;article :*
					<input type="file" name="image"></label>
					<button>Soumettre l&apos;article</button>
					* L'image doit être inférieure à 2 Mo et de format jpg, jpeg ou png
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
	
	<?php
	afficherFooter()
	?>
 </body>
</html>
