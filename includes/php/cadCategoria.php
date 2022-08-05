<?php
	if(isset($_POST['cadCategoria']) && !empty($_POST['categoria'])){
		$categoria = trim(strip_tags($_POST['categoria']));

		$iCat = "INSERT into categoria (categoria) VALUES (:categoria)";
		try {
			$rCat = $conexao->prepare($iCat);
			$rCat->bindParam(':categoria', $categoria, PDO::PARAM_STR);
			$rCat->execute();
			$cCat = $rCat->rowCount();
			if($cCat>0){
				echo '<p>'.$categoria.' cadastrada!</p>';
			}else {
				echo '<p style="color:red">Houve um erro!</p>';
			}
		}catch(PDOException $e){
			echo $e;
		}
	}
?>