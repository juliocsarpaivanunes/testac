<?php
session_start();

if(!isset($_SESSION["usuario"])){
	header("location: home");
	exit;
}

session_unset($_SESSION["usuario"]);
session_destroy();
header("location: home");
exit;
?>