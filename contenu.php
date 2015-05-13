<?php
require_once 'bdd.php';
require_once "menu.php";

//ajout d'un commentaire dans la base de données. On vérifie qu'une variable a été passée en post et que le tableau $_POST n'est pas vide.
if (isset($_POST) && count($_POST) > 0) {
	
	// $_POST['comm'] contient le champ correspondant au textarea du formulaire d'ajout de commentaire plus bas
	$comm = utf8_encode(htmlspecialchars($_POST['comm']));
	
	/* La fonction trim permet d'enlever tous les espaces, ça permet d'éviter d'afficher les commentaires formés seulement d'espaces.
	On vérifie qu'un utilisateur est connecté, il est impossible d'ajouter un commentaire sans être connecté.*/
	if (trim($comm) != "" && isset($_SESSION['user_id'])) {
		// $_GET['id'] correspond à l'id de l'article, et $comm au texte du commentaire.
		addCommentaire($_GET['id'],$comm);
	}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="assets/style.css">
	<link rel="stylesheet" type="text/css" href="assets/biography_style.css">
    <title>Blog sur Christopher Nolan</title>
  </head>
 <body>
 
	<?php 
	//affichager du menu et du bandeau supérieur de la page
	afficherMenu();
	?>
	
	<div class="content">
		<div class="left_side">
			<article>
			<?php 
			if(isset($_GET['id']))
			{
				$bdd = Connect_db();
				
				$query=$bdd->prepare('SELECT titre,contenu,image
						   FROM article
						   WHERE id = ?
						   ');
				$query->execute(array($_GET['id']));
				
				$data = $query->fetch();
				$titre=$data['titre'];
				
				// SI l'utilisateur est administrateur il peut modifier un article
				if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
				// On conserve en Get la valeur déjà passée en Get grâce au href
				echo "<a href='ajout.php?id=".$_GET['id']."'>Modifier l'article</a>";
				}
				
				echo "<h1>";
				echo $titre;
				echo "</h1>";
				
				// Le champ image de la base de données contient le chemin vers le fichier image correspondant à l'article
				echo "<figure><img src='".$data['image']."'></figure>";
				// La fonction nl2br permet d'afficher les retours à la ligne.
				echo "<article><p>".nl2br ($data['contenu'])."</p></article>";
				$query->closeCursor();
				
				$commentaires = array();
				/* On sélectionne tous les commentaires de l'article correspondant à l'id passé en Get. On fait une jointure avec
				l'utilisateur pour récupérer le nom. On classe les articles par ordre croissant de date */
				$query=$bdd->prepare('SELECT user.nom,commentaire.date,commentaire.contenu
						   FROM commentaire inner join user on user.id = commentaire.user_id
						   WHERE commentaire.article_id = ? order by date asc');
				$query->execute(array($_GET['id']));
				
				while($data = $query->fetch()) { // lecture par ligne
					/*crochets pour ajouter chaque ligne de $data ds $commentaires. $commentaires est donc un tableau de tableaux.
					Plus tard on utilisera $comment qui sera un tableau associatif contenant le nom, la date et le contenu de chaque commentaire.*/
					$commentaires[] = $data;
				
				}
				
				$query->closeCursor();
			// Cas où on arrive sur la page contenu.php sans avoir rien mis en Get
			} else echo "Il n'y a pas d'article à afficher."
			
			
			?>
			</article>
			<div class="comments">
				<section class="comment_header">
					<h2><?php if(isset($_GET['id'])) echo count($commentaires)." commentaires sur ".$titre; else echo "Il n'y a pas de commentaires à afficher.";?> </h2>
				</section>
				
				<?php 
				
				// On n'exécute pas la suite si on arrive sur la page contenu.php sans avoir rien mis en get
				if(isset($_GET['id']))
				{
					foreach ($commentaires as $comment) {
						afficherCommentaire($comment['nom'], $comment['date'], $comment['contenu']);
					}
					
					// Si un utilisateur est connecté, il peut ajouter un commentaire
					if (isset($_SESSION['user_id'])) {
						?>
						<div class="comment_add">
							<p>LAISSER UN COMMENTAIRE</p>
							<!-- Il faut garder en GET l'id de l'article qui avait déjà passé en get grâce au href dans index.php ou recherche.php-->
							<form action="contenu.php?id=<?php echo $_GET['id']?>" method='post' class="formulary">
								<label>
								<textarea placeholder="tapez votre commentaire" name="comm"></textarea></label>
								<button>Laisser un commentaire</button>
							</form>
						</div>
						<?php 
					}
				}
				
				
				?>
			</div>
		</div>
		<?php 
		afficherZone();
		?>
	</div>
	<?php
	afficherFooter()
	?>
 </body>
</html>
