<?php
include_once 'bdd.php';
require_once "menu.php";

//ajout d'un commentaire. On v�rifie qu'une variable a �t� pass�e en post et que le tableau $_POST n'est pas vide.
if (isset($_POST) && count($_POST) > 0) {
	
	// $_POST['comm'] contient le champ correspondant au textarea du formulaire d'ajout de commentaire plus bas
	$comm = $_POST['comm'];
	
	/* La fonction trim permet d'enlever tous les espaces, �a permet d'�viter d'afficher les commentaires form�s seulement d'espaces.
	On v�rifie qu'un utilisateur est connect�, il est impossible d'ajouter un commentaire sans �tre connect�.*/
	if (trim($comm) != "" && isset($_SESSION['user_id'])) {
		// $_GET['id'] correspond � l'id de l'article, et $comm au texte du commentaire.
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
	//affichager du menu et du bandeau sup�rieur de la page
	afficherMenu();
	?>
	
	<div class="content">
		<div class="left_side">
			<article>
			<?php 
			
			$bdd = Connect_db();
			
			$query=$bdd->prepare('SELECT titre,contenu,image
                       FROM article
                       WHERE id = ?
                       ');
			$query->execute(array($_GET['id']));
			
			$data = $query->fetch();
			
			// SI l'utilisateur est administrateur il peut modifier un article
			if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
			// On conserve en Get la valeur d�j� pass�e en Get gr�ce au href
			echo "<a href='ajout.php?id=".$_GET['id']."'>Modififier article</a>";
			}
			
			echo "<h1>";
			echo $data['titre'];
			echo "</h1>";
			
			// Le champ image de la base de donn�es contient le chemin vers le fichier image correspondant � l'article
			echo "<figure><img src='".$data['image']."'></figure>";
			echo $data['contenu'];
			
			$commentaires = array();
			/* On s�lectionne tous les commentaires de l'article correspondant � l'id pass� en Get. On fait une jointure avec
			l'utilisateur pour r�cup�rer le nom. On classe les articles par ordre croissant de date */
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
			
			?>
			</article>
			<div class="comments">
				<section class="comment_header">
					<h2><?=count($commentaires)?> commentaires sur "Biographie de Christopher Nolan :"</h2>
				</section>
				
				<?php 
				
				foreach ($commentaires as $comment) {
					afficherCommentaire($comment['nom'], $comment['date'], $comment['contenu']);
				}

				if (isset($_SESSION['user_id'])) {
					?>
					<div class="comment_add">
						<p>LAISSER UN COMMENTAIRE</p>
						<!-- Il faut garder en GET l'id de l'article qui avait d�j� pass� en get gr�ce au href dans index.php ou recherche.php-->
						<form action="contenu.php?id=<?=$_GET['id']?>" method='post' class="formulary">
							<label>
							<textarea placeholder="tapez votre commentaire" name="comm"></textarea></label>
							<button>Laisser un commentaire</button>
						</form>
					</div>
					<?php 
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
