<?php 
				if(isset($_POST['conf_cat']) && isset($_POST['cor_cat'])){
					$cor_cat = $_POST['cor_cat'];
					//INFO IMAGEM
					$file 		= $_FILES['img_cat'];
					$numFile	= count(array_filter($file['name']));
					
					//PASTA
					$folder		= 'logotipo/';
					
					//REQUISITOS
					$permite 	= array('image/jpeg', 'image/png');
					$maxSize	= 1024 * 1024 * 5;
					
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


					$iC = "INSERT INTO conf_catalogo (cor_cat,imagem) VALUES (:cor_cat,:imagem)";

					try {
						$rCat = $conexao->prepare($iC);
						$rCat->bindParam(':cor_cat', $cor_cat, PDO::PARAM_STR);
						$rCat->bindParam(':imagem', $novoNome, PDO::PARAM_STR);
						$rCat->execute();

						$cCat= $rCat->rowCount();

						if($cCat > 0){
							echo '<p>Catalogo configurado!</p>';
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