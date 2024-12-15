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
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="img/institutologo.png" alt="Instituto Logo">
            </div>
        </div>
        <h2>Cadastro de Aluno(a)</h2>
        
        <form id="login-form" action="salvar_aluno.php" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="carteirinha">Número da carteirinha:</label>
                <input type="number" id="carteirinha" name="carteirinha" value="" required>
            </div>

            <div class="form-group">
                <label for="nome">Nome do(a) Aluno(a):</label>
                <input type="text" id="nome" name="nome" value="" required>
            </div>

            <div class="error-message" id="error-message">
                <?php
                // Exibe a mensagem de erro (se existir)
                if (!empty($error_message)) {
                    echo $error_message;
                }
                ?>
            </div>
            <button type="submit">Cadastrar</button>
        </form>
        
        <div class="registration-message">
            Já está cadastrado? <a class="registration-link" href="index.php">Clique aqui para voltar!</a>
        </div>
    </div>

    <script>
        function atualizarHora() {
            var agora = new Date();
            var horas = agora.getHours().toString().padStart(2, '0');
            var minutos = agora.getMinutes().toString().padStart(2, '0');
            var segundos = agora.getSeconds().toString().padStart(2, '0');
            document.getElementById('current-time').innerText = `Horário Atual: ${horas}:${minutos}:${segundos}`;
        }

        setInterval(atualizarHora, 1000);
        atualizarHora();
    </script>
</body>
</html>
