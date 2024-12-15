<?php
include_once "sessao.php";

// Verificar Conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Inicialize as variáveis
$dataSelecionada = $_POST['data'] ?? null;
$idAluno = $_POST['idAluno'] ?? null;

// Consulta SQL base
$sql = "SELECT dtRegistro, hrRegistro, idAluno FROM registros";

// Adiciona filtros para data e/ou idAluno
$conditions = [];
if ($dataSelecionada) {
    $conditions[] = "dtRegistro = ?";
}
if ($idAluno) {
    $conditions[] = "idAluno = ?";
}

// Adiciona os filtros na consulta
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Consulta para contar as chegadas atrasadas
$sqlCount = "SELECT COUNT(*) as total FROM registros";

// Adiciona filtros na contagem
if (count($conditions) > 0) {
    $sqlCount .= " WHERE " . implode(" AND ", $conditions);
}

// Prepare e execute a consulta de contagem
$stmtCount = $conn->prepare($sqlCount);
if ($dataSelecionada && $idAluno) {
    $stmtCount->bind_param("ss", $dataSelecionada, $idAluno);
} elseif ($dataSelecionada) {
    $stmtCount->bind_param("s", $dataSelecionada);
} elseif ($idAluno) {
    $stmtCount->bind_param("s", $idAluno);
}

$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$rowCount = $resultCount->fetch_assoc();
$totalAtrasos = $rowCount['total'];

// Prepare a consulta de registros
$stmt = $conn->prepare($sql);
if ($dataSelecionada && $idAluno) {
    $stmt->bind_param("ss", $dataSelecionada, $idAluno);
} elseif ($dataSelecionada) {
    $stmt->bind_param("s", $dataSelecionada);
} elseif ($idAluno) {
    $stmt->bind_param("s", $idAluno);
}

// Execute a consulta de registros
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Alunos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('img/fundoinstituto.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            border-bottom: 2px solid #ccc;
            background-color: #f9f9f9;
        }

        .tabs {
            display: flex;
        }

        .tab-button {
            background: none;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            transition: background-color 0.3s, transform 0.3s;
            font-weight: bold;
        }

        .tab-button.active {
            border-bottom: 2px solid #000;
        }

        .tab-button:hover {
            background-color: #e0e0e0;
            transform: scale(1.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .filter-container {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .filter-container input, .filter-container button {
            padding: 10px;
            font-size: 16px;
            margin: 5px;
            border-radius: 8px;
        }

        .filter-container button {
            background-color: #5144ff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-container button:hover {
            background-color: #3d3bff;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .logo img {
            height: 80px;
            margin-left: 475px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">
            <img src="img/institutologo.png" alt="Instituto Logo">
        </div>
    </div>

    <div class="tabs">
        <a href="graficos.html"><button class="tab-button">Tabela de Gráficos</button></a>
        <button class="tab-button active">Chegadas atrasadas</button>
        <a href="index.php"><button class="tab-button">Voltar</button></a>
    </div>

    <div class="filter-container">
        <form method="POST" action="">
            <label for="data">Selecione uma data:</label>
            <input type="date" id="data" name="data" value="<?= htmlspecialchars($dataSelecionada) ?>">

            <label for="idAluno">ID do Aluno:</label>
            <input type="text" id="idAluno" name="idAluno" value="<?= htmlspecialchars($idAluno) ?>">

            <button type="submit">Buscar Faltas</button>
        </form>
    </div>

    <h3>Total de Chegadas Atrasadas: <?= $totalAtrasos ?></h3>

    <table>
        <thead>
            <tr>
                <th>Dia do Registro</th>
                <th>Hora do Registro</th>
                <th>ID do Aluno</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['dtRegistro']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['hrRegistro']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['idAluno']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Nenhuma falta encontrada para os critérios selecionados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
// Fechar Conexão
$conn->close();
?>
