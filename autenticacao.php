<?php
	// conexão
	session_start();

	include_once "conexao.php";

	$conn = mysqli_connect($localhost, $user, $password, $banco);

	if (!$conn) {
		echo "<script>alert('Erro ao se conectar com o banco de dados!');</script>";
		header('Location: index.html');
	}

	$user = $_POST['usuario'];
	$password = $_POST['senha'];
	
	$sql = "SELECT idUsuario FROM usuarios ".
			"WHERE (email='$user') AND (senha='$password')";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_num_rows($result);
	
	if ($row > 0) {
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$idusuario = $row[0];
		}

		// cria sessão
		$_SESSION['idusuario'] = $idusuario;
		$_SESSION['usuario'] = $user;
		$_SESSION['senha'] = $password;

		header('Location: index.php');
	}
	else {
		echo  "<script>alert('Usuario ou Senha invalidos!');</script>";
		header('Location: error-403.html');
	}
?>