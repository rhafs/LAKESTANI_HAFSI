<?php
include_once 'bdd.php';
require_once "menu.php";

//print_r($_POST);


// if (isset($_GET['id'])) {
// 	$id_article = $_GET['id'];
// } else if (isset($_POST['id'])) {
// 	$id_article = $_POST['id'];
// }

// $_GET['id'] = $id_article;

//ajout d'un commentaire
if (isset($_POST) && count($_POST) > 0) {
	//recup info sur article
	$comm = $_POST['comm'];

	if (trim($comm) != "" && isset($_SESSION['user_id'])) {
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
	//affichager d'header de la page
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
			
			//$query->closeCursor();
			
			echo "<h1>";
			echo $data['titre'];
			echo "</h1>";
			
			echo "<figure><img src='".$data['image']."'></figure>";
			echo $data['contenu'];
			
			$commentaires = array();
			$query=$bdd->prepare('SELECT user.nom,commentaire.date,commentaire.contenu
                       FROM commentaire inner join user on user.id = commentaire.user_id
                       WHERE commentaire.article_id = ? order by date asc');
			$query->execute(array($_GET['id']));
			
			$data = "";
			while($data = $query->fetch()) { // lecture par ligne
				//crochets pour ajouter chaque ligne de data ds test
				$commentaires[] = $data;
			
			}
			
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
	<footer>
		<img alt="logo de Lyon 1" src="assets/IUTLyon1.png"/>
		<p>HAFSI Rachida LAKESTANI Diane</p>
	</footer>
 </body>
</html>
