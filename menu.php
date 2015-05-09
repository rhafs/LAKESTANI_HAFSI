<?php

function afficherMenu() {
	?>
	<header>
		<div id="bg">
			<p><span id="title">Bienvenue dans notre Blog sur Christopher Nolan</span><p>
		</div>
		
		<div id="bg2">
			<p><span id="title2">Bienvenue dans notre Blog sur Christopher Nolan</span><p>
		</div>
		
		<nav>
			<ul>
				<li><a href="index.php">Accueil</a></li>
				
				<?php 
				if (isset($_SESSION['user_type']) && $_SESSION['user_type']== 1 ) {
					?>
					<li><a href="ajout.php">Ajouter un article</a></li>
					<?php 
				}
				?>
				
				<li><a href="recherche.php">Rechercher un article</a></li>
				<li><a href="propos.php">A propos</a></li>
			</ul>
		</nav>
	</header>
	<?php
}

function afficherZone() {

	$bdd = Connect_db();

	?>
	<aside>
		<h2>Zone de recherche</h2>
		<form method="get" action="recherche.php">
			<input type="search" placeholder="Entrez un mot-clef" name="the_search">
		</form>
		
		<?php 
		
		if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") {

			//récuperation de date d'inscrpition
			$query=$bdd->prepare('SELECT date_inscription FROM user WHERE id = ?');
			$query->execute(array($_SESSION['user_id']));
			$data = $query->fetch();
			
			$date_inscription = $data['date_inscription'];
			
			//récuperation de nombre d'articles écrit
			$query=$bdd->prepare('SELECT count(1) as nb FROM article WHERE user_id = ?');
			$query->execute(array($_SESSION['user_id']));
			$data = $query->fetch();
			
			$nb_articles = $data['nb'];
			
			//récuperation de nombre de commantaires écrit
			$query=$bdd->prepare('SELECT count(1) as nb FROM commentaire WHERE user_id = ?');
			$query->execute(array($_SESSION['user_id']));
			$data = $query->fetch();
				
			$nb_commentaires = $data['nb'];

			echo "connecté en tant que : ".$_SESSION['user_nom']."<br>";
			echo "inscrit le : ".$date_inscription."<br>";
			
			if ($_SESSION['user_type'] == 1) {
				echo "nb articles: ".$nb_articles."<br>";
			}
			
			echo "nb commenatires : ".$nb_commentaires."<br>";
			
			echo "<a href='login.php'>Déconnecter</a>";
		
		} else {
			
			?>
			<h3>Zone de connection</h3>
			<form method="post" action="login.php">
				Login : <input type="text" name="login"><br>
				Mot de passe: <input type="password" name="pass">
				<button>Connecter</button>
			</form>
			<?php 
		}
		?>
	</aside>
	<?php 
	
}

function afficherCommentaire($nom,$date,$contenu) {
?>
	<div class="comment_content">
		<p><?=$nom?></p> <p><?=convertDate($date)?></p>
		<p><?=$contenu?></p>
	</div>
<?php 

}

?>