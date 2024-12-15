<?php
include_once "sessao.php";

$carteirinha = $_POST['carteirinha'];
$nome = $_POST['nome'];

$sql = "insert into alunos (idaluno,nameAluno) ".
		"values ($carteirinha,'$nome')";
$result = mysqli_query($conn, $sql);

if (! $result) {
	echo "<script>alert('Erro ao salvar o registro!');</script>";
}
else {
	echo "<script>alert('Registro salvo com sucesso!');</script>";
}

mysqli_close($conn);

header('Location: index.php');
?>