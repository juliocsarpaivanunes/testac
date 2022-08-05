<?php session_start();
	
	if(!isset($_SESSION["usuario"])){
		header("location: login");
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
	<link rel="stylesheet" type="text/css" href="style/css/perfil.css">
</head>
<body>
	<?php include("includes/php/header.php");?>
	<div class="box">	
		<div class="box-son">
			<div class="perfil">
				<?php
					$id = $_SESSION["usuario"];
					$selectUser = "SELECT * FROM usuarios WHERE id_usuarios = '$id' LIMIT 1";
					try{
						$rUser = $conexao->prepare($selectUser);
						$rUser->execute();
						$cUser = $rUser->rowCount();
						if($cUser > 0){
							$fUser = $rUser->fetch(PDO::FETCH_ASSOC);
							$nome = $fUser["nome"];
							$email = $fUser["email"];
				?>
				<div class="foto">
					<img src="imgs/profile-achasim-icon.png">
					<center>
						<a href=""><i class="fa-solid fa-pen-to-square"></i></a>
						<a href=""><p>Remover foto</p></a>
					</center>
				</div>
				<div class="infos">
					<ul>
						<li><h2><?php echo $nome;?> <a href="editar?editar=nome"><i class="fa-solid fa-pen-to-square"></i></a></h2></li>
						<li><h2><?php echo $email;?></h2></li>
						<li><h2>******** <a href="editar?editar=senha"><i class="fa-solid fa-pen-to-square"></i></a></h2></li>
					</ul>
					<div class="progress-bar incompleta"></div>
					<center><p><a href="">Complete o seu perfil.</a></p></center>
				</div>
				<?php
						}else {
							header("location: home");
						}
					}catch(PDOException $e){
						echo $e;
					}
				?>
			</div>
		</div>
	</div>
	<?php include("includes/php/footer.php");?>
</body>
</html>