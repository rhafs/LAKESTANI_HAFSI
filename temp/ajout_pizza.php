<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Administration</title>
	</head>
	<body>
	
		<?php
		
			if(isset($_POST) AND count($_POST)>0){
				
				/**
				 *   TODO :
				 *
				 *   - Traiter les données recues
				 *   - Ajouter/Modifier dans la table
				 *	 - Afficher un message à l'utilisteur (en cas de succès ET en cas d'échec).
				 */
				
		?>
			<section id="message">
				
			</section>
		<?php	
			} else {
		?>
		
		<section id="ajout_pizza">
			<h1>Ajouter une nouvelle pizza au menu</h1>
		
			<form action="#" method="post">
				
				<div><label for="nom">Nom</label><input type="text" id="nom" name="nom" placeholder="Le nom de notre futur best-seller"/></div>	
				<div><label for="ingredients">Ingrédients</label><textarea id="ingredients" name="ingredients" placeholder="La liste d'ingrédients secrets" /></textarea></div>
				<div><label for="prix">Prix</label><input type="text" id="prix" name="prix" placeholder="Le prix unitaire en euros"/></div>	
				<div>
					<button type="submit">Enregistrer</button>
				</div>
			</form>
		</section>
		
		<?php
		 
			} //fin else
		
		?>
	</body>
</html>