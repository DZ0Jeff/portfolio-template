<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php include 'head.php'; ?>
		<link rel="stylesheet" type="text/css" href="../css/galeria.css">
	</head>
	
	<body class="montserrat">
		<?php include 'header.php'; ?>
		
		<div class="main">
			
			<div class="heavy w3-row">
				<?php include 'card.php'; ?>

				<!--Certificados-->
				<div class="w3-container w3-col s9 w3-animate-right">
					<section class="w3-panel w3-leftbar w3-text-white w3-card-4 w3-serif">
						<div class="montserrat w3-center">
							<h3>Certificações</h3>
							<p>Listagem de certificações consegidas, até o momento: </p>
						</div>

						<ul id="album-fotos">
							<li id="foto01"> <span>SoloLearn - Javascript</span> </li>
							<li id="foto02"> <span>SoloLearn - Python</span> </li>
							<li id="foto03"> <span>Curso em Video - Python</span> </li>
							<li id="foto04"> <span>MVC - Aprendendendo a programar</span> </li>
							<li id="foto05"> <span>SoloLearn - PHP</span> </li>
							<li id="foto06"> <span>Microcamp - Inglês</span> </li>
							<li id="foto07"> <span>Microcamp - Games</span> </li>
							<li id="foto08"> <span>Microcamp - Espanhol</span> </li>
							<li id="foto09"> <span>Microcamp - Web Design</span> </li>
						</ul>
					</section>
				</div>
				<!--Fim dos certificados-->
			</div>
		</div>

		<?php include 'footer.php'; ?>

		<script src="../js/script.js"></script>
	</body>
</html>