<?php
include_once "sessao.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Controle de atrasos/saídas</title>
	<link rel="icon" href="img/institutoaba.png" type="image/png"> 

	<link rel="stylesheet" href="css/style.css">

	<script>
	function seleciona()
	{
		var carteirinha = formulario.carteirinha.value;
		formulario.aluno.value = carteirinha;
	}
	</script>

</head>
<body>
	<div class="container form-container">
        <div class="header">
            <div class="logo">
                <img src="img/institutologo.png" alt="Instituto Logo">
            </div>
        </div>

        <h2>Identificação do(a) Aluno(a)</h2>
        <div class="time-display" id="current-date"></div>
        <div class="time-display" id="current-time"></div>
        
        <form name="formulario" id="formulario" action="salvar.php" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="carteirinha">ID carteirinha:</label>
                <input type="number" id="carteirinha" name="carteirinha" onChange="seleciona();" autofocus>
            </div>
            <div class="form-group">
                <label for="carteirinha">Aluno(a):<font color="#FF0000">*</font></label>
				<select name="aluno" id="aluno" required>
					<option value="">Selecione...</option>
					<?php 
					// conexão
					$sql3 = "SELECT idAluno,nameAluno FROM alunos ORDER BY nameAluno";
					$resultado3 = mysqli_query($conn, $sql3);
					while ($linha3 = mysqli_fetch_array($resultado3, MYSQLI_NUM))
					{ ?>
						<option value="<?php echo $linha3[0]; ?>"><?php echo $linha3[1]; ?></option>
					<?php
					} ?>
				</select>
            </div>
            <div class="form-group">
                <label for="carteirinha">Turma:<font color="#FF0000">*</font></label>
				<select name="turma" id="turma" required>
					<option value="">Selecione...</option>
					<?php 
					// conexão
					$sql3 = "SELECT idTurma,nameTurma FROM turmas ORDER BY nameTurma";
					$resultado3 = mysqli_query($conn, $sql3);
					while ($linha3 = mysqli_fetch_array($resultado3, MYSQLI_NUM))
					{ ?>
						<option value="<?php echo $linha3[0]; ?>"><?php echo $linha3[1]; ?></option>
					<?php
					} ?>
				</select>
            </div>
            <div class="error-message" id="error-message" aria-live="assertive">
                <?php 
                if (!empty($error_message)) {
                    echo $error_message;
                }?>
            </div>
			<table width="100%">
				<tr>
					<td><button type="submit">Gerar</button></td>
					<td></td>
					<td><a href="logout.php"><button type="button">Sair</button></a></td>
				</tr>
			</table>
        </form>

        <div class="registration-message">
            Aluno não possui cadastro? <a class="registration-link" href="cadastro.php">Clique aqui!</a>
        </div>
        <div class="registration-message">
            Olhar os resultados <a class="registration-link" href="graficos.html">Clique aqui!</a>
        </div>
    </div>
    
    <script>
        function atualizarHora() {
            var agora = new Date();
            var ano = agora.getFullYear();
            var mes = agora.getMonth()+1;
            var dia = agora.getDate();
            var horas = agora.getHours().toString().padStart(2, '0');
            var minutos = agora.getMinutes().toString().padStart(2, '0');
            var segundos = agora.getSeconds().toString().padStart(2, '0');
            document.getElementById('current-date').innerText = `Data Atual: ${dia}/${mes}/${ano}`;
            document.getElementById('current-time').innerText = `Horário Atual: ${horas}:${minutos}:${segundos}`;
        }

        setInterval(atualizarHora, 1000);
        atualizarHora();
    </script>
</body>
</html>
