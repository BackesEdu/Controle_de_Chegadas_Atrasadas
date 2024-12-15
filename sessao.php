<?php
	// conexão
	include_once "conexao.php";

	$conn = mysqli_connect($localhost, $user, $password, $banco);

	if (!$conn) {
		$_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible show fade'>Nao foi possivel conectar ao Banco de Dados. Usuario ou senha invalido!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span></button></div>";
		header('Location: logout.php');
	}			

	// abre sessão
	session_start();
	if ((!isset($_SESSION["usuario"])) || (!isset($_SESSION["senha"]))) {
		header("Location: index.html");
	}
	else {
		$idusuario = $_SESSION['idusuario'];
		$usuario   = $_SESSION["usuario"];
		$senha     = $_SESSION["senha"];
	}
?>