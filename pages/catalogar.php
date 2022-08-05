<?php session_start();
	
	if(!isset($_SESSION["usuario"])){
		header("location: login");
		exit;
	}
include("includes/php/conexao.php");

?>
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
	<link rel="stylesheet" type="text/css" href="style/css/catalogar.css">
</head>
<body>
	<?php include("includes/php/header.php");?>
	<div class="box">	
		<?php
		$id_usuarios = $_SESSION["usuario"]; 
		
		$sel = $conexao->prepare("SELECT * FROM produtos WHERE id_usuarios = $id_usuarios");
		$sel->execute();
		$csel = $sel->rowCount();
		if($csel == 0){
			$del = $conexao->prepare("DELETE FROM conf_catalogo WHERE id_usuarios = $id_usuarios");
			$del->execute();
		}
		?>
		<div class="box-son">
			<div class="catalogar">
				<div class="formulario">
					<!-- CATEGORIA -->
					<form method="post" enctype="multipart/form-data">
						<span>Cadastre categoria:</span>
						<input type="text" placeholder="Categoria" name="categoria_produto">
						<input type="submit" name="cadCategoria_produto" value="Cadastrar Categoria">
						<?php
							if(isset($_POST["cadCategoria_produto"]) AND !empty($_POST["categoria_produto"])){
								$categoria = trim(strip_tags($_POST["categoria_produto"]));
								$iCat = "INSERT INTO categoria (categoria,id_usuarios) VALUES (:categoria, :id_usuarios)";
								try {
									$rCat = $conexao->prepare($iCat);
									$rCat->bindParam(':categoria', $categoria, PDO::PARAM_STR);
									$rCat->bindParam(':id_usuarios', $id_usuarios, PDO::PARAM_STR);
									$rCat->execute();
									header("refresh: 0");
								}catch(PDOException $e){
									echo $e;
								}
							}
						?>
						<div class="cats">
							<ul>
								<?php
									$sCat = $conexao->prepare("SELECT * FROM categoria WHERE id_usuarios = $id_usuarios");
									$sCat->execute();

									while ($lCat = $sCat->fetch(PDO::FETCH_ASSOC)) {
										$id = $lCat['id'];
										$categoria = $lCat['categoria'];

								?>
								<li><?php echo $id;?> - <?php echo $categoria;?> <a onclick="return confirm('Deseja apagar?')"; href="apagar?acao=apagar-categoria&id=<?php echo $id?>"><i class="fa-solid fa-xmark"></i></a></li>
								<?php
									}

								?>
								
							</ul>
						</div>
					</form>
					<!-- PRODUTO -->
					<form method="post" enctype="multipart/form-data">
						<span>Cadastre os produtos:</span>
						<input type="text" placeholder="Nome" name="nome_prod">
						<input type="text" placeholder="Referência" name="ref_prod">
						<input type="text" placeholder="Descrição" name="desc_prod">
						<select name="cat_prod">
							<?php
							$sCat = $conexao->prepare("SELECT * FROM categoria WHERE id_usuarios = $id_usuarios");
							$sCat->execute();

							while ($lCat = $sCat->fetch(PDO::FETCH_ASSOC)) {
								$categoria = $lCat['categoria'];
							?>
							<option value="<?php echo $categoria;?>"><?php echo $categoria;?></option>
							<?php
								}

							?>
						</select>
						<input type="file" name="pic">
						<input type="submit" name="cadProduto" value="Cadastrar Produto">
						<?php
						  	if(isset($_POST['cadProduto'])){
						  		$nome_prod = trim(strip_tags($_POST['nome_prod']));
						  		$ref_prod = trim(strip_tags($_POST['ref_prod']));
						  		$desc_prod = trim(strip_tags($_POST['desc_prod']));
						  		$cat_prod = trim(strip_tags($_POST['cat_prod']));

						  		$ext = strtolower(substr($_FILES['pic']['name'],-4)); //Pegando extensão do arquivo
    							$imagem = date("Y.m.d-H.i.s").$ext; //Definindo um novo nome para o arquivo
    							$dir = 'imagens-catalogos/'; //Diretório para uploads 
    							move_uploaded_file($_FILES['pic']['tmp_name'], $dir.$imagem); //Fazer upload do arquivo


    							if ($_FILES['pic']['size'] == 0){
    								$imagem = '0';
    								$ext = '0';
    							}
	    							$iProd = "INSERT INTO produtos (nome_prod,ref_prod,desc_prod,cat_prod,imagem,id_usuarios) VALUES (:nome_prod,:ref_prod,:desc_prod,:cat_prod,:imagem,:id_usuarios)";

									try {
										$rProd = $conexao->prepare($iProd);
										$rProd->bindParam(':nome_prod', $nome_prod, PDO::PARAM_STR);
										$rProd->bindParam(':ref_prod', $ref_prod, PDO::PARAM_STR);
										$rProd->bindParam(':desc_prod', $desc_prod, PDO::PARAM_STR);
										$rProd->bindParam(':cat_prod', $cat_prod, PDO::PARAM_STR);
										$rProd->bindParam(':imagem', $imagem, PDO::PARAM_STR);
										$rProd->bindParam(':id_usuarios', $id_usuarios, PDO::PARAM_STR);
										$rProd->execute();

										$cProd= $rProd->rowCount();

										if($cProd > 0){
											echo '<p>'.$nome_prod.' cadastrado!</p>';
										}else {
											echo '<p style="color:red">Houve um erro!</p>';
										}

									}catch(PDOException $e){
										echo $e;
									}
						  	}
						?>
					</form>
					<!-- CONFIGURAÇÃO -->
					<form method="post" enctype="multipart/form-data">
						<span>Configure o catálogo:</span>
						<input type="color" name="cor_cat">
						<span>Logotipo:</span>
						<input type="file" name="pic_cat">
						<input type="text" placeholder="Endereço" name="endereco_cat">
						<input type="text" placeholder="Site" name="site">
						<span> Deseja divulgar em nosso site?</span>
						<input type="checkbox" value="1" name="divulgar">
						<input type="submit" name="confCat" value="Configurar">
						<?php

							if(isset($_POST["confCat"])){
								$cor_cat = trim(strip_tags($_POST["cor_cat"]));
								$endereco_cat = trim(strip_tags($_POST["endereco_cat"]));
								$site = trim(strip_tags($_POST["site"]));
								if(empty($_POST["divulgar"])){
									$divulgar = '0';
								}else {
									$divulgar = '1';
								}
								$ext = strtolower(substr($_FILES['pic_cat']['name'],-4)); //Pegando extensão do arquivo
    							$imagema = date("Y.m.d-H.i.s").$ext; //Definindo um novo nome para o arquivo
    							$dir = 'logo-catalogos/'; //Diretório para uploads 
    							move_uploaded_file($_FILES['pic_cat']['tmp_name'], $dir.$imagema); //Fazer upload do arquivo

    							if ($_FILES['pic_cat']['size'] == 0){
    								$imagema = '';
    								$ext = '';
    							}

    							$iConfCat = "INSERT INTO conf_catalogo (cor_cat,imagem,endereco, site, id_usuarios, divulgar) VALUES (:cor_cat, :imagema, :endereco_cat,:site,:id_usuarios, :divulgar)";

    							try {

    								$rConfCat = $conexao->prepare($iConfCat);
    								$rConfCat->bindParam(':cor_cat', $cor_cat, PDO::PARAM_STR);
    								$rConfCat->bindParam(':imagema', $imagema, PDO::PARAM_STR);
    								$rConfCat->bindParam(':endereco_cat', $endereco_cat, PDO::PARAM_STR);
    								$rConfCat->bindParam(':site', $site, PDO::PARAM_STR);
    								$rConfCat->bindParam(':id_usuarios', $id_usuarios, PDO::PARAM_STR);
    								$rConfCat->bindParam(':divulgar', $divulgar, PDO::PARAM_STR);
    								$rConfCat->execute();

    							}catch(PDOException $e){
    								echo $e;
    							}
							}

						?>
					</form>
					<form method="post" enctype="multipart/form-data">
						<input type="submit" name="finalizarCat" value="Finalizar">
						<?php
							if(isset($_POST["finalizarCat"])){
								header("location: catalogo");
							}
						?>
					</form>
				</div>
				<div class="produtos">
					<?php

						$sProd = "SELECT * FROM produtos WHERE id_usuarios = $id_usuarios  ORDER BY id DESC";

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
					<div class="produto">
						<div class="imagem">
							<img src="imagens-catalogos/<?php echo $img_prod;?>">
						</div>
						<div class="infos">
							<h1><?php echo $nome_prod;?></h1>
							<p><?php echo $desc_prod;?></p>
							<li><?php echo $ref_prod; ?></li>
							<li><?php echo $cat_prod;?></li>
						</div>
						<div class="c">
							<p>
								<a onclick="return confirm('Deseja apagar?')"; href="apagar?acao=apagar-produto&id=<?php echo $id_prod;?>"><i class="fa-solid fa-xmark"></i></a>
							</p>
						</div>
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
	<?php include("includes/php/footer.php");?>
</body>
</html>