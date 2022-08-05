<?php session_start();
include("includes/php/conexao.php"); 
$id = $_GET['id'];
if(!$id){
		header("location: home");
		echo'Falta';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="<?php echo $urlRaiz;?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,400;1,700;1,900&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/61bc9881dd.js" crossorigin="anonymous"></script>
	<?php include("includes/php/head.php"); ?>
	<link rel="stylesheet" type="text/css" href="style/css/pagina.css">
</head>
<body>
	<!-- MENU -->
	<?php include("includes/php/header.php");?>
	<!-- FIM MENU -->
	<?php
		try {
			$sUser = $conexao->prepare("SELECT * FROM usuarios WHERE id_usuarios = $id");
			$sUser->execute();
			$cUser = $sUser->rowCount();
			if($cUser > 0){
				$getUser = $sUser->fetch(PDO::FETCH_ASSOC);
				$nome = $getUser["nome"];
				$email = $getUser["email"];

				/* SELECT conf_catalogo */
				$sConf = $conexao->prepare("SELECT * FROM conf_catalogo WHERE id_usuarios = $id");
				$sConf->execute();
				$cConf = $sConf->rowCount();
				if($cConf>0){
					$getConf = $sConf->fetch(PDO::FETCH_ASSOC);
					if($getConf["imagem"] == null){
						$imagem = '0';
					}else { 
						$imagem = $getConf["imagem"];
					}
					$endereco = $getConf["endereco"];
					$site = $getConf["site"];
				}
			}else{
				header("location: home");
				exit;
			}
		}catch (PDOException $e) {
			echo $e;
		}
	?>
	<div class="box">
		<div class="box-son">
			<div class="post">
				<div class="imagem">
					<img alt="" title="" src="imagens-catalogos/imagem-default.png">
				</div>
				<div class="infos">
					<div class="descricao">
						<h1><?php echo $nome;?></h1>
					</div>
					<div class="info">
						<h3> Meios de contato: </h3>
						<ul>
							<li><i class="fab fa-instagram"></i> <a href=""><?php echo $site;?></a></li>
							<li><i class="fas fa-envelope-open"></i> <?php echo $email;?></li>
						</ul>
					</div>
					<div class="whats">
						<a class="botao-whats" target="_blank" href="https://api.whatsapp.com/send?phone=&text=Ol%C3%A1%2C%20vi%20sua%20postagem%20sobre%20%20no%20AchaSim."> <i class="fab fa-whatsapp"></i> <p>Fale com o vendedor</p></a>
					</div>
				</div>
				<div class="chamada">
					<span class="tag"></span><p> Veja mais</p>
				</div>
				<?php

						$sProd = "SELECT * FROM produtos WHERE id_usuarios = $id  ORDER BY id DESC";

						try {
							$rProd = $conexao->prepare($sProd);
							$rProd->execute();

							while ($lProd = $rProd->fetch(PDO::FETCH_ASSOC)) {
								$id_prod = $lProd["id"];
								$nome_prod = $lProd["nome_prod"];
								$ref_prod = $lProd["ref_prod"];
								$desc_prod = $lProd["desc_prod"];
								$cat_prod = $lProd["cat_prod"];
								$img_prod = $lProd["imagem"];
								if($img_prod == '0'){
									$img_prod = "imagem-default.svg";
								}

					?>
				<div class="exemplos">
					<div class="foto">
						<img src="imagens-catalogos/<?php echo $img_prod;?>">
					</div>
					<?php
							}

						}catch(PDOException $e){
							echo $e;
						}

					?>
				</div>
			</div>
		</div>
	</div>
	<!-- FOOTER -->
	<?php include("includes/php/footer.php");?>
	<!-- FIM FOOTER -->
</body>
</html>