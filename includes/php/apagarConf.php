<?php 
	if(isset($_POST['apagar'])){
		$delete = "DELETE FROM conf_catalogo";
		try{
			$rDel = $conexao->prepare($delete);
			$rDel->execute();
		}catch(PDOException $e){
			echo $e;
		}

		$deletei = "DELETE FROM categoria";
		try {
			$cDel = $conexao->prepare($deletei);
			$cDel->execute();
			header("Refresh: 0");
		}catch(PDOException $e){
			echo $e;
		}

	}

	if(isset($_POST['acabar'])){
		header("Refresh: 0; url=catalogo.php");
	}
?>