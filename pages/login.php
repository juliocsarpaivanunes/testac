<?php session_start();
	
	if(isset($_SESSION["usuario"])){
		header("location: profile");
		exit;
	}

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
	<link rel="stylesheet" type="text/css" href="style/css/login.css">
</head>
<body>
	<?php include("includes/php/header.php");?>
	<div class="box">	
		<div class="box-son">
			<div class="show">
				<h3>Faça o login</h3>
			</div>
			<form class="login" method="post" enctype="multipart/form-data">
				<input type="text" name="email" placeholder="Usuário">
				<input type="password" name="senha" placeholder="********">
				<input type="submit" name="login" value="Login">
				<div class="message">
					<p>Não é cadastrado ainda? <a href="cadastrar">Cadastre-se!</a></p>
				</div>
				<div class="message">
					<p>Esqueceu a senha? <a href="cadastrar">Recuperar!</a></p>
				</div>
				<?php
					if(isset($_POST["login"])){
						$email = trim(strip_tags($_POST["email"]));
						$senha = trim(strip_tags($_POST["senha"]));

						if(!empty($email) AND !empty($senha)){
							$select = "SELECT * FROM usuarios WHERE email = '$email'";
							try {
								$rLogin = $conexao->prepare($select);
								$rLogin->execute();
								$rCount = $rLogin->rowCount();
								if($rCount >0){
									$rFetch = $rLogin->fetch(PDO::FETCH_ASSOC);
									if(isset($rFetch["senha"])){
										if(password_verify($senha, $rFetch["senha"])){
				    						$_SESSION["usuario"] = $rFetch["id_usuarios"];
				    						if(isset($acao)){
				    							if($acao == "anunciar-contato"){
				    								header("location: anunciar-contato");
				    							}elseif($acao == "anunciar-estabelecimento"){
				    								header("location: anunciar-estabelecimento");
				    							}elseif($acao == "anunciar-informacoes"){
				    								header("location: anunciar-informacoes");
				    							}elseif($acao == "anunciar-produtos"){
				    								header("location: anunciar-produtos");
				    							}
				    						}else {
				    							header("location: profile");
				    						}
				    					}else {
				    						echo '<div class="message error">
											<p>Usuário ou senha inválida!</p>
										</div>';
				    					}
									}
								}else {
									echo '<div class="message error">
											<p>Usuário ou senha inválida!</p>
										</div>';
								}
								
							}catch(PDOException $e){
								echo $e;
							}
						}else {
							echo '<div class="message error">
									<p>Preencha todos os campos!</p>
								</div>';
						}
					}
				?>
			</form>
		</div>
	</div>
	<?php include("includes/php/footer.php");?>
</body>
</html>