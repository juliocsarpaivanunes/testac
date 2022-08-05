<?php
			if(isset($_POST['cadProd']) && isset($_POST['nome_prod'])){
				$nome_prod = trim(strip_tags($_POST['nome_prod']));
				$ref_prod = trim(strip_tags($_POST['ref_prod']));
				$cat_prod = trim(strip_tags($_POST['cat_prod']));
				$desc_prod = trim(strip_tags($_POST['desc_prod']));

				//INFO IMAGEM
				$file 		= $_FILES['img_prod'];
				$numFile	= count(array_filter($file['name']));
				
				//PASTA
				$folder		= 'imagens-catalogos/';
				
				//REQUISITOS
				$permite 	= array('image/jpeg', 'image/png');
				$maxSize	= 1024 * 1024 * 10;
				
				//MENSAGENS
				$msg		= array();
				$errorMsg	= array(
					1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
					2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
					3 => 'o upload do arquivo foi feito parcialmente',
					4 => 'Não foi feito o upload do arquivo'
				);
				
				if($numFile <= 0){
					echo '<div class="error">
								Selecione uma imagem e tente novamente!
							</div>';
				}
				else if($numFile >=2){
					echo '<div class="error">
								Você ultrapassou o limite de upload. Selecione apenas uma foto e tente novamente!
							</div>';
				}else{
				for($i = 0; $i < $numFile; $i++){
					$name 	= $file['name'][$i];
					$type	= $file['type'][$i];
					$size	= $file['size'][$i];
					$error	= $file['error'][$i];
					$tmp	= $file['tmp_name'][$i];
					
					$extensao = @end(explode('.', $name));
					$novoNome = rand().".$extensao";
					
					if($error != 0)
						echo $msg[] = "<b>$name :</b> ".$errorMsg[$error];
					else if(!in_array($type, $permite))
						echo $msg[] = "<b>$name :</b> Erro imagem não suportada!";
					else if($size > $maxSize)
						echo $msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 5MB";
					else{
			
				if(move_uploaded_file($tmp, $folder.'/'.$novoNome)){
				//$msg[] = "<b>$name :</b> Upload Realizado com Sucesso!";


				$iProd = "INSERT INTO produtos (nome_prod,ref_prod,cat_prod,desc_prod,imagem) VALUES (:nome_prod,:ref_prod,:cat_prod,:desc_prod,:imagem)";

				try {
					$rProd = $conexao->prepare($iProd);
					$rProd->bindParam(':nome_prod', $nome_prod, PDO::PARAM_STR);
					$rProd->bindParam(':ref_prod', $ref_prod, PDO::PARAM_STR);
					$rProd->bindParam(':cat_prod', $cat_prod, PDO::PARAM_STR);
					$rProd->bindParam(':desc_prod', $desc_prod, PDO::PARAM_STR);
					$rProd->bindParam(':imagem', $novoNome, PDO::PARAM_STR);
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
				}else
				$msg[] = "<b>$name :</b> Desculpe! Ocorreu um erro...";
		
		}
		
		foreach($msg as $pop)
		echo '';
			//echo $pop.'<br>';
	}
}
	

	
}
				?>