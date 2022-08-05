<?php session_start();
include("includes/php/conexao.php");

if(!isset($_SESSION["usuario"])){
	header("location: login");
	exit;
}

$id_usuarios = $_SESSION["usuario"];

$sAll = "SELECT * FROM usuarios WHERE id_usuarios = '$id_usuarios' LIMIT 1";
try {

	$rAll = $conexao->prepare($sAll);
	$rAll->execute();
	$fAll = $rAll->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
	echo $e;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $fAll["nome"];?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,400;1,700;1,900&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/61bc9881dd.js" crossorigin="anonymous"></script>
	<?php include("includes/php/head.php"); ?>
	<link rel="stylesheet" type="text/css" href="style/css/catalogo.css">
</head>
<body>
	<?php
		$confCat = "SELECT * FROM conf_catalogo WHERE id_usuarios = $id_usuarios ORDER BY id DESC";
		$rConfCat = $conexao->prepare($confCat);
		$rConfCat->execute();
		$lcCat = $rConfCat->fetch(PDO::FETCH_ASSOC);
		if(empty($lcCat["cor_cat"])){
			$corcat = 'rgba(0,0,0,0.8)';
		}else {
			$corcat = $lcCat["cor_cat"];
		}
		;
		if(empty($lcCat["imagem"])){
			$imagemcat = '0';
		}else {
			$imagemcat = $lcCat["imagem"];
		}
		if(empty($lcCat["endereco"])){
			$enderecocat = "";
		}else {
			$enderecocat = $lcCat["endereco"];
		}

		if(empty($lcCat["site"])){
			$site = "";
		}else {
			$site = $lcCat["site"];
		}
		$sUser = "SELECT nome FROM usuarios WHERE id_usuarios = $id_usuarios";
		$rUser = $conexao->prepare($sUser);
		$rUser->execute();
		$fUser = $rUser->fetch(PDO::FETCH_ASSOC);
		$nome = $fUser["nome"];
		$sCat = "SELECT * FROM categoria WHERE id_usuarios = $id_usuarios";
		$rCat = $conexao->prepare($sCat);
		$rCat->execute();
		while ($fCat = $rCat->fetch(PDO::FETCH_ASSOC)) {
			$categoria = $fCat["categoria"];
	?>
	<header style="background-color: <?php echo $corcat;?>">
		<div class="cat">
			<span></span><h3><?php echo $categoria; ?></h3>
		</div>
		<div class="logo">
			<?php
				if($imagemcat != '0'){
					echo '<img src="logo-catalogos/'.$imagemcat.'">';
				}else {
					echo '<h1>'.$nome.'</h1>';
				}
			?>
		</div>
		<div class="infos">
			<ul>
				<li><i class="fas fa-map-pin"></i> <?php echo $enderecocat;?></li>
				<li><i class="fa-solid fa-globe"></i> <?php echo $site;?></li>
			</ul>
		</div>
	</header>
	<div class="categoria">
		<div class="categoria-son">
			<div class="posts">
				<?php
					$sProd = "SELECT * FROM produtos WHERE cat_prod = '$categoria' AND id_usuarios = $id_usuarios";
					$rProd = $conexao->prepare($sProd);
					$rProd->execute();
					while ($lProd = $rProd->fetch(PDO::FETCH_ASSOC)) {
						$nome_prod = $lProd["nome_prod"];
						$ref_prod = $lProd["ref_prod"];
						$desc_prod = $lProd["desc_prod"];
						$cat_prod = $lProd["cat_prod"];
						$img_prod = $lProd["imagem"];

						if($img_prod == '0'){
							$img_prod = "imagem-default.svg";
						}
				?>
				<div class="post">
					<div class="img_post">
						<img src="imagens-catalogos/<?php echo $img_prod;?>">
					</div>
					<div class="info">
						<ul>
							<li><h1><?php echo $nome_prod; ?></h1></li>
							<li><p><?php echo $ref_prod; ?></p></li>
						</ul>
					</div>
				</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<?php
		}
	?>
</body>
</html>