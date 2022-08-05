<?php session_start();
	
	if(!isset($_SESSION["usuario"])){
		header("login");
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
				<div class="foto">
					<img src="imgs/profile-achasim-icon.png">
					<center>
						<a href=""><i class="fa-solid fa-pen-to-square"></i></a>
						<a href=""><p>Remover foto</p></a>
					</center>
				</div>
					<?php
						$id = $_SESSION["usuario"];
						$select = $conexao->prepare("SELECT * FROM usuarios WHERE id_usuarios = '$id' LIMIT 1");
						$select->execute();
						$result = $select->fetch(PDO::FETCH_ASSOC);
						$nome = $result["nome"];
						$email = $result["email"];
					?>
					<form class="infos" method="post" enctype="multipart/form-data">

						<ul>
						<?php
							$editar = $_GET["editar"];
							if($editar == "nome"){
								echo '<input type="text" name="nnome" value="'.$nome.'">';
							}else{
								echo '<li><h2>Júlio César <a href="editar?editar=nome"><i class="fa-solid fa-pen-to-square"></i></a></h2></li>';
							}

							echo '<li><h2>'.$email.'</h2></li>';

							if($editar == "senha"){
								echo '<input type="text" name="senha" value="" placeholder="Confirme sua senha">';
								echo '<input type="text" name="nsenha" value="" placeholder="Digite sua nova senha">';
								echo '<input type="text" name="csenha" value="" placeholder="Confirme sua nova senha"';
							}else{
								echo '<p>********<a href="editar?editar=senha"><i class="fa-solid fa-pen-to-square"></i></a></p>';
							}
						?>
						<center>	
							<button name="alterar"><i class="fa-solid fa-check"></i></button>
						</center>
						<?php

							if(isset($_POST["alterar"])){
								if($editar == "nome"){
									$nnome = trim($_POST["nnome"]);
									if(!empty($nnome)){
										$updateNome = $conexao->prepare("UPDATE usuarios SET nome = '$nnome' WHERE id_usuarios = $id
										");
										$updateNome->execute();
										header('Location: profile');
									}
								}

								if($editar == "senha"){
									$senha = trim(strip_tags($_POST["senha"]));
									$nsenha = trim(strip_tags($_POST["nsenha"]));
									$csenha = trim(strip_tags($_POST["csenha"]));

									$select1 = $conexao->prepare("SELECT * FROM usuarios WHERE id_usuarios = '$id' LIMIT 1");
									$select1->execute();
									$result1 = $select1->fetch(PDO::FETCH_ASSOC);
									if(!empty($senha) AND !empty($nsenha) AND !empty($csenha)){
										if($nsenha == $csenha){ 
											if(password_verify($senha, $result1["senha"])){
					    						$nsenha = password_hash($nsenha, PASSWORD_DEFAULT);
					    						$updateSenha = $conexao->prepare("UPDATE usuarios SET senha = '$nsenha' WHERE id_usuarios = '$id'");
												$updateSenha->execute();
												echo '<div class="message sucess">
														<p>Senha atualizada com sucesso!</p>
													</div>';
					    					}else {
					    						echo '<div class="message error">
														<p>Senha incorreta!</p>
													</div>';
					    					}
					    				}else {
					    					echo '<div class="message error">
													<p>Senhas não compatíveis!</p>
												</div>';
					    				}
				    				}else {
				    					echo '<div class="message error">
												<p>Preencha todos os campos!</p>
											 </div>';
				    				}
								}
							}
								

						?>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php include("includes/php/footer.php");?>
</body>
</html>