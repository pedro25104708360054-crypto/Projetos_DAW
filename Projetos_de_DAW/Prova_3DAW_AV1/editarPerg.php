<?php
$caminho = "Pergunta.txt";
$idEditar = $_GET['IDunico'] ?? null;
$dadosEncontrados = null;

if ($idEditar && file_exists($caminho)) {
    $linhas = file($caminho);
    foreach ($linhas as $linha) {
        $dados = explode(";", trim($linha));
        if ($dados[0] == $idEditar) {
            $dadosEncontrados = $dados;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idOriginal = $_POST['id_original'];
    $novaPergunta = $_POST['PerguntaUnica'];
    $novaResposta = $_POST['Resposta'];
    
    $linhas = file($caminho);
    foreach ($linhas as $i => $linha) {
        $dados = explode(";", trim($linha));
        if ($dados[0] == $idOriginal) {
            $linhas[$i] = $idOriginal . ";" . $novaPergunta . ";" . $novaResposta . PHP_EOL;
            break;
        }
    }
    file_put_contents($caminho, implode("", $linhas));
    header("Location: ListarPerg.php");
    exit;
}

if (!$dadosEncontrados) { echo "Registro não encontrado."; exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Editar</title></head>
<body>
    <h2>Editar Registro</h2>
    <form method="POST">
        <input type="hidden" name="id_original" value="<?php echo $dadosEncontrados[0]; ?>">
        <label>ID: <?php echo $dadosEncontrados[0]; ?></label><br><br>
        <label>Pergunta:</label><br>
        <input type="text" name="PerguntaUnica" value="<?php echo $dadosEncontrados[1]; ?>" required><br><br>
        <label>Resposta:</label><br>
        <input type="text" name="Resposta" value="<?php echo $dadosEncontrados[2]; ?>"><br><br>
        <button type="submit">Salvar Alterações</button>
        <a href="ListarPerg.php">Cancelar</a>
    </form>
</body>
</html>