<?php
include_once "sessao.php";

$data = date("Y/m/d");
$hora = date("H:m:s");
$aluno = $_POST['aluno'];
$turma = $_POST['turma'];

$sql = "insert into registros (dtRegistro,hrRegistro,idAluno,idTurma) ".
		"values ('$data','$hora',$aluno,$turma)";
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