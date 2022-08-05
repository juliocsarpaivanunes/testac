<header id="header">
	<a href="home" class="logo"><img src="imgs/logotipo-achasim.png" alt="Logotipo AchaSim" title="Logotipo Acha Sim"></a>
	<nav id="nav">
		<button id="btn-mobile" aria-label="Abrir Menu"
		aria-haspopup="true" aria-controls="menu" aria-expanded="false"><p>Menu</p> 
			<span id="hamburguer"></span>
		</button>
		<ul id="menu">
			<li><a href="home">HOME</a></li>
			<li><a class="anunciar" href="catalogar">CATALOGAR</a></li>
			<?php if(isset($_SESSION['usuario'])){
				echo '<li><a alt="Perfil" title="Perfil" href="profile"><i class="fa-solid fa-user"></i></a>';
				echo '<li><a alt="Sair" title="Sair" onclick="return confirm(\'Realmente deseja sair?\')" href="sair">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>';
			}else {
				echo '<li><a alt="Realizar Login" title="Realizar Login" href="login"><i class="fa-solid fa-right-to-bracket"></i></a>';
			}
			?>
		</ul>
	</nav>
</header>
<script src="includes/js/menu-mobile.js"></script>