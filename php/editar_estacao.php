<?php

require_once('db.php');

session_start();

if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] != true) {
    header("Location: ../html/stations.html");
    exit;
}

$codigo = $_GET['codigo'];

$stmt = $conexao->prepare("SELECT * FROM estacao WHERE id_estacao = ?");
$stmt->bind_param("i", $codigo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Estação não encontrada.";
    exit;
}

$estacao = $resultado->fetch_assoc();

$stmt->close();
$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>

<body>

    <a href="sair.php">
        <input type="button" value="sair" event="sair.php">
    </a>

    <br>
    <br>

    <h2>Editar Estação</h2>

    <br>

    <form action="alterar_estacao.php" method="POST" onsubmit="return confirm('Deseja realmente salvar as alterações?')">
        <input type="hidden" name="pkEstacao" value="<?php echo $estacao['pk_estacao']; ?>">

        <label>Nome:</label>
        <input type="text" name="nomeEstacao" value="<?php echo htmlspecialchars($estacao['nome_estacao']); ?>">

        <input type="submit" value="Salvar">
        <a href="estacoes.php"><input type="button" value="Cancelar"></a>
    </form>
</body>

</html>