<?php
	include 'config.php';
?>
<header class="w3-container head w3-text-white w3-padding-24">
	<h1 class="w3-center">Jeferson</h1>
	<div class="w3-bar menu">
		<div class="w3-bar-item w3-hover-blue" onclick="w3.toggleShow('#perfil'); startAnim('Left');">Perfil</div>
		<div class="w3-bar-item w3-hover-red" onclick="w3.toggleShow('#sobre')"><?php echo "<a href='$sobre'>Sobre</a>"; ?></div>
		<div class="w3-bar-item w3-hover-blue">Formação</div>
		<div class="w3-bar-item w3-hover-orange">Competências</div>
		<div class="w3-bar-item w3-hover-green"><a href="<?php echo $certificacoes; ?>">Certificados</a></div>
	</div>
</header>