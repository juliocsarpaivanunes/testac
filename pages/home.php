<?php session_start();
include("includes/php/conexao.php");?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,400;1,700;1,900&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/61bc9881dd.js" crossorigin="anonymous"></script>
	<?php include("includes/php/head.php"); ?>
	<link rel="stylesheet" type="text/css" href="style/css/home.css">
</head>
<body>
	<?php include("includes/php/header.php");?>
	<div class="box">
		<div class="chamada">
			<span></span><h3>Lojas</h3>
		</div>
		<?php

		$sPost = "SELECT DISTINCT  id_usuarios FROM conf_catalogo WHERE  divulgar = '1' ORDER BY id DESC";
		$rPost = $conexao->prepare($sPost);
		$rPost->execute();
		$countPost = $rPost->rowCount();
		if($countPost >0){

		while ($fPost = $rPost->fetch(PDO::FETCH_ASSOC)) {
			$id_sim = $fPost["id_usuarios"];
			$sUser = "SELECT * FROM usuarios WHERE id_usuarios = $id_sim";
			$rUser = $conexao->prepare($sUser);
			$rUser->execute();
			while ($fUser = $rUser->fetch(PDO::FETCH_ASSOC)) {
				$nome = $fUser["nome"];
				$titulo_limpa = strtolower( preg_replace("/[^a-zA-Z0-9-]/", "-", strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
		?>
		<div class="box-son">
			<div class="posts">
				<div class="chamada">
					<span></span><a href="pagina/<?php echo $titulo_limpa;?>/?id=<?php echo $id_sim;?>"><h3><?php echo $nome;?></h3></a>
				</div>
				<?php

					$sProd = "SELECT * FROM produtos WHERE id_usuarios = $id_sim";
					$rProd = $conexao->prepare($sProd);
					$rProd->execute();
					while ($fProd = $rProd->fetch(PDO::FETCH_ASSOC)) {
						$img = $fProd["imagem"];
						$nome_prod = $fProd["nome_prod"];
						$ref_prod = $fProd["ref_prod"];

				?>
				<div class="post">
					<a href="">
						<div class="img_post">
							<img src="imagens-catalogos/<?php echo $img;?>">
						</div>
						<div class="info">
							<ul>
								<li><h1><?php echo $nome_prod;?></h1></li>
								<li><p><?php echo $ref_prod;?></p></li>
							</ul>
						</div>
					</a>
				</div>
				<?php
					}
				?>
			</div>
		</div>
		<?php
			}
		}
		}else {
			echo '<div class="aviso"><li class="icon"><i class="fa-solid fa-face-sad-tear"></i></li><li><p>Ainda não há anuncios disponíveis. <a href="catalogar">Seja o primeiro</a>, é grátis!</p></li></div>';
		}
		?>
	</div>
	<?php include("includes/php/footer.php");?>
</body>
</html>