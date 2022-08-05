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
	<link rel="stylesheet" type="text/css" href="style/css/login.css">
</head>
<body>
	<?php include("includes/php/header.php");?>
	<div class="box">	
		<div class="box-son">
			<div class="show">
				<h3>Faça o seu cadastro</h3>
			</div>
			<form class="login" method="post" enctype="multipart/form-data">
				<input type="text" name="nome" placeholder="Nome">
				<input type="text" name="email" placeholder="Email">
				<input type="password" name="senha" placeholder="********">
				<input type="submit" name="cadastrar" value="Cadastrar">
				<?php
					if(!isset($_POST["cadastrar"])){
						echo'<div class="message sucess">
							<p>Já é cadastrado? <a href="login">Faça login!</a></p>
						</div>';
					}
				?>
				<?php

					if(isset($_POST["cadastrar"])){
						$nome = trim(strip_tags($_POST["nome"]));
						$email = strtolower(trim(strip_tags($_POST["email"])));
						$senha = trim(strip_tags($_POST["senha"]));
						if(!empty($nome) XOR !empty($email) XOR !empty($senha)){

							$select = $conexao->prepare("SELECT * FROM usuarios WHERE email LIKE '%$email%'");
							$select->execute();
							$count = $select->rowCount();
							if($count > 0){
								echo '<div class="message error">
									<p>Email já cadastrado!</p>
								</div>';
							}else {
								$senha = password_hash($senha, PASSWORD_DEFAULT);
								$insert = "INSERT into usuarios (nome,email,senha) VALUES (:nome,:email,:senha)";
								try{
									$result = $conexao->prepare($insert);
									$result->bindParam(":nome", $nome,PDO::PARAM_STR);
									$result->bindParam(":email", $email,PDO::PARAM_STR);
									$result->bindParam(":senha", $senha,PDO::PARAM_STR);
									$result->execute();
									$countInsert = $result->rowCount();
									if($countInsert > 0){
										echo '<div class="message sucess">
												<p>Cadastrado com sucesso! <a href="login">Faça login!</a></p>
											</div>';
									}else {
										echo '<div class="message error">
												<p>Houve um erro! Tente mais tarde!</p>
											</div>';
									}
								}catch(PDOExcpetion $e){
									echo $e;
								}
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