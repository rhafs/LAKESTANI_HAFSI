<?php
require_once "bdd.php";
require_once "menu.php";


if (isset($_SESSION['user_id'])) {
	session_destroy();
	session_start();
}

if (isset($_POST) && count($_POST) > 0) {
	
	if (isset($_POST['login']) && trim($_POST['login']) != "") {
		
		if (isset($_POST['pass']) && trim($_POST['pass']) != "") {
			
			$bdd = Connect_db();
			
			$test = array();
			
			$query=$bdd->prepare('SELECT id,nom,type
                       			FROM user
                       			WHERE login = ? and password = ?
                       ');
			$query->execute(array($_POST['login'],$_POST['pass']));
			
			while($data = $query->fetch()) { // lecture par ligne
				//crochets pour ajouter chaque ligne de data ds test
				$test = $data;
			
			}
			
			//print_r($test);
			
			//connection ok
			if (isset($test['nom'])) {
				$login = 0;
				
				//fixé les varaibles de session
				$_SESSION['login'] = $_POST['login'];
				$_SESSION['user_id'] = $test['id'];
				$_SESSION['user_nom'] = $test['nom'];
				$_SESSION['user_type'] = $test['type'];
				
			} else {
				//connection ko
				$login = 1;
			}
		
		} else {
			$login = 2;
		}
	} else {
		$login = 2;
	}
	
} else {
	$login = 2;
}

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
		if ($login == 0 || isset($_SESSION['login'])) {

			echo "<section class='left_side'>" ;
			echo "Bienvenue ".$_SESSION['user_nom']."!";
			echo "</section>";
			
		} else {
		
		?>
		<section class="left_side">
		</section>
		<?php 
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
