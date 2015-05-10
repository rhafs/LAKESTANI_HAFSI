<?php
// menu.php contient toutes les fonctions d'affichage.
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
				/* Si l'utilisateur est administrateur, il pourra ajouter un article. On vérifie d'abord que la variable existe, et si elle existe on vérifie qu'elle ait une certaine
				valeur, si elle existait pas et qu'on vérifiait que $_SESSION['user_type']== 1 seulement, ça retournerait une erreur. */
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

// Cette fonction affiche la barre latérale
function afficherZone() {

	$bdd = Connect_db();

	?>
	<aside>
		<h2>Zone de recherche</h2>
		<form method="get" action="recherche.php">
			<input type="search" placeholder="Entrez un mot-clef" name="the_search">
		</form>
		
		<?php
		
		//On vérifie dans le cookie si l'utilisateur était déjà connecté, et on restaure les variables de session si c'est le cas
		if (isset($_COOKIE['user_id']))
		{
			$_SESSION['user_id'] = $_COOKIE['user_id'];
					
			$userInfo = array();
			
			$query=$bdd->prepare('SELECT nom,type,login
								FROM user
								WHERE id = ? 
					   ');
			$query->execute(array($_SESSION['user_id']));

			//1 seul utilisateur avec cet ID donc une seule ligne à lire
			if ($data = $query->fetch())
			{ 
				$userInfo = $data;
				//On a déjà l'ID, on recopie le reste des infos
				$_SESSION['login'] = $userInfo['login'];
				$_SESSION['user_nom'] = $userInfo['nom'];
				$_SESSION['user_type'] = $userInfo['type'];
			}
			
			$query->closeCursor();
		}
		
		// Si un utilisateur est connecté, on affiche son nom, sa date d'inscription, le nombre d'articles écrits si c'est l'adminiustrateur, le nombre de commentaires écrits
		if (isset($_SESSION['user_id'])) {

			//récuperation de la date d'inscription
			$query=$bdd->prepare('SELECT date_inscription FROM user WHERE id = ?');
			$query->execute(array($_SESSION['user_id']));
			$data = $query->fetch();
			
			$date_inscription = $data['date_inscription'];
			$query->closeCursor();
			
			//récuperation du nombre d'articles écrits si on est connecté en tant qu'administrateur
			if ($_SESSION['user_type'] == 1)
			{
				$query=$bdd->prepare('SELECT count(*) as nb FROM article WHERE user_id = ?');
				$query->execute(array($_SESSION['user_id']));
				$data = $query->fetch();
				
				$nb_articles = $data['nb'];
				$query->closeCursor();
			}
			
			//récuperation du nombre de commentaires écrits si on est connecté en tant qu'administrateur
			$query=$bdd->prepare('SELECT count(*) as nb FROM commentaire WHERE user_id = ?');
			$query->execute(array($_SESSION['user_id']));
			$data = $query->fetch();
			
			$nb_commentaires = $data['nb'];
			
			$query->closeCursor();
			
			echo "connecté en tant que : ".$_SESSION['user_nom']."<br>";
			echo "inscrit le : ".$date_inscription."<br>";
			
			// Si on est connecté en tant qu'administrateur, on affiche le nombre d'articles écrits
			if ($_SESSION['user_type'] == 1) {
				echo "nb articles: ".$nb_articles."<br>";
			}
			
			echo "nb commentaires : ".$nb_commentaires."<br>";
			
			echo "<a href='login.php'>Déconnecter</a>";
		
		} else {
			//Affichage de la zone de connection si aucun utilisateur n'est connecté
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

/**
 * 
 *  $nom correspond au nom de l'tilisateur ayant ajouté le commentaire
 *  $date correspond à la date à laquelle l'utilisateur a ajouté le commentaire
 *  $contenu correspond au contenu du commentaire ajouté
 */
function afficherCommentaire($nom,$date,$contenu) {
?>
	<div class="comment_content">
		<!-- La fonction convertDate permet de convertir une date du format sql au format français -->
		<p><?=$nom?></p> <p><?=convertDate($date)?></p>
		<p><?=$contenu?></p>
	</div>
<?php 

}

function afficherFooter() {
?>
	<footer>
	<img alt="logo de Lyon 1" src="assets/IUTLyon1.png"/>
	<p>HAFSI Rachida LAKESTANI Diane</p>
	</footer>
<?php
}

?>