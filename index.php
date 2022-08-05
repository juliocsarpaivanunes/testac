<?php
	if(isset($_GET['url'])){
		$url = explode('/', $_GET['url']);
		require_once 'pages/'.$url[0].'.php';
	}else {
		require_once 'pages/home.php';
	}
?>