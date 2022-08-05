<?php include("php/conexao.php");?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/formulario.css">
	<link rel="stylesheet" type="text/css" href="style/css/header.css">
	<link rel="stylesheet" type="text/css" href="style/css/geral.css">
	<link rel="stylesheet" type="text/css" href="style/css/footer.css">
</head>
<body>
	<?php include("../includes/php/header.php");?>
	<!-- FORMULARIO -->
	<div class="box formulario">
		<!-- CATEGORIA -->
		<form method="post" enctype="multipart/form-data">
			<span>Cadastre categoria:</span>
			<input type="text" name="categoria">
			<input type="submit" name="cadCategoria" value="Cadastrar">
			<?php include("php/cadCategoria.php");?>
		</form>

		<!-- PRODUTO -->
		<form method="post" enctype="multipart/form-data">
			<span>Cadastre o produto:</span>
			<input type="text" name="nome_prod" placeholder="Nome do produto">
			<input type="text" name="ref_prod" placeholder="Refêrencia">
			<select name="cat_prod">
				<?php
					$sCat = "SELECT * FROM categoria";
					try {
						$reCat = $conexao->prepare($sCat);
						$reCat->execute();
						while ($lis = $reCat->fetch(PDO::FETCH_ASSOC)) {
							$categ = $lis["categoria"];
				?>
				<option value="<?php echo $categ;?>"><?php echo $categ;?></option>
				<?php
						}
					}catch(PDOException $e){
						echo $e;
					}
				?>
			</select>
			<p>Imagem do produto:</p>
			<input type="file" name="img_prod[]">
			<input type="text" name="desc_prod" placeholder="Descrição">
			<input type="submit" name="cadProd" value="Cadastrar produto">
			<?php include("php/cadProduto.php");?>
		</form>

		<!-- Configuração -->
		<form method="post" enctype="multipart/form-data">
			<span>Configure o catálogo:</span>
			<input type="color" name="cor_cat">
			<p>Logotipo catálogo:</p>
			<input type="file" name="img_cat[]">
			<input type="submit" name="conf_cat" value="Configurar catálogo">
			<?php include("php/confCatalogo.php");?>
		</form>

		<!-- LIMPAR TUDO -->
		<form class="finalizar" method="post" enctype="multipart/form-data">
			<input onclick="return confirm('Deseja apagar as configurações?');" type="submit" style="background-color: red" value="Apagar configurações" name="apagar">
			<input type="submit" name="acabar" value="Finalizar">
			<?php include("php/apagarConf.php");?>
		</form>
	</div>

	<!-- PRODUTOS -->
	<div class="box produtos">
		<?php
			$select = "SELECT * FROM produtos ORDER BY id desc";
			try {
				$result = $conexao->prepare($select);
				$result->execute();
				while ($lista = $result->fetch(PDO::FETCH_ASSOC)) {
					$id = $lista["id"];
					$nome = $lista["nome_prod"];
					$referencia = $lista["ref_prod"];
					$categoria = $lista["cat_prod"];
					$descricao = $lista["desc_prod"];
					$imagem = $lista["imagem"];
		?>
		<div class="produto">
			<a onclick="return confirm('Realmente deseja apagar o produto?');"href="apagar.php?id=<?php echo $id; ?>">X</a>
			<img src="imagens/<?php echo $imagem;?>">
			<h1><?php echo $nome;?></h1>
			<p><?php echo $descricao;?></p><br>
			<p><?php echo $categoria;?></p>
			<p><b>Ref: </b><?php echo $referencia;?></p>
		</div>
		<?php
				}
			}catch(PDOException $e){
				echo $e;
			}
		?>
	</div>
</body>
</html>