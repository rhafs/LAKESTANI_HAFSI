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
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="assets/style.css">
	<link rel="stylesheet" type="text/css" href="assets/about_style.css">
    <title>Blog sur Christopher Nolan</title>
  </head>
 <body>
	<?php 
	
	afficherMenu();
	?>
	<div class="content">
		<div class="left_side">
			<article>
				<h1>Un blog de geekettes !</h1>
				<img width="256" alt="Dessin d&apos;une fille &agrave; lunettes" src="assets/geekette.png"/>
				<p>Nous sommes deux &eacute;tudiantes de l&apos;IUT d&apos;informatique Ann&eacute;e Sp&eacute;ciale de Lyon 1, c&apos;est notre premier site web alors soyez indulgent !</p>
				<p>Nous sommes fans du r&eacute;alisateur Christopher Nolan car il est atypique, il aime beaucoup les d&eacute;tails, utilise la narration non lin&eacute;aire dans ses premiers films, il fait des films tr&egrave;s immersifs.
				Nous le suivons depuis son premier film "The Following" et nous sommes particuli&egrave;rement fans de l&apos;univers de Batman !</p>
				<p>Si vous avez des questions ou des remarques pour am&eacute;liorer notre blog, vous pouvez <a href="mailto:armays.world@gmail.com">nous contacter</a>.</p>
				<p>Merci pour votre attention ! </p>
			</article>
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
