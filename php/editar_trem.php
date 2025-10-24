<?php

require_once('conexao.php');

session_start();

if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] != true) {
    header("Location: index.php");
    exit;
}

$codigo = $_GET['codigo'];

$stmt = $conexao->prepare("SELECT * FROM trem WHERE pk_trem = ?");
$stmt->bind_param("i", $codigo);
$stmt->execute();
$resultado = $stmt->get_resultado();

if ($resultado->num_rows === 0) {
    echo "Trem não encontrado.";
    exit;
}

$turma = $resultado->fetch_assoc();

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
    <h3>
        Seja Bem-Vindo,
        <?php

        echo $_SESSION["nome_trem"];

        ?>
    </h3>

    <a href="sair.php">
        <input type="button" value="sair" event="sair.php">
    </a>

    <br>
    <br>

    <h2>Editar Trem</h2>

    <br>

    <form action="alterar_trem.php" method="POST" onsubmit="return confirm('Deseja realmente salvar as alterações?')">
        <input type="hidden" name="editarTrem" value="<?php echo $trem['pk_trem']; ?>">

        <label>Nome:</label>
        <input type="text" name="nomeTrem" value="<?php echo htmlspecialchars($trem['nome_trem']); ?>">

        <input type="submit" value="Salvar">
        <a href="trem.php"><input type="button" value="Cancelar"></a>
    </form>
</body>

</html>