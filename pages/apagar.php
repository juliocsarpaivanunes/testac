<?php session_start();

if(!isset($_SESSION["usuario"])){
	header("location: home");
	exit;
}

include("includes/php/conexao.php");

	$acao = trim(strip_tags($_GET['acao']));
	$id = trim(strip_tags($_GET['id']));
	$id_usuarios = $_SESSION["usuario"];
	if($acao == "apagar-categoria"){
		$dAC = "DELETE FROM categoria WHERE id = $id AND id_usuarios = '$id_usuarios'";
		try {
			$rAC = $conexao->prepare($dAC);
			$rAC->execute();
			header("location: catalogar");
			exit;
		}catch(PDOException $e){
			echo $e;
		}
	}

	if($acao == "apagar-produto"){
		$dProd = "DELETE FROM produtos WHERE id = $id AND id_usuarios = '$id_usuarios'";
		try{
			$rProd = $conexao->prepare($dProd);
			$rProd->execute();
			header("location: catalogar");
			exit;
		}catch(PDOException $e){
			echo $e;
		}
	}
?>