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
        }
    }

    file_put_contents($caminho, implode("", $linhas));

    header("Location: ListarPerg.php");
    exit;
}

if (!$dadosEncontrados) {
    echo "Registro não encontrado";
    exit;
}
?>

<!DOCTYPE html>
<html>
<body>
<h2>Editar</h2>

<form method="POST">
    <input type="hidden" name="id_original" value="<?php echo $dadosEncontrados[0]; ?>">

    <p>ID: <?php echo $dadosEncontrados[0]; ?></p>

    <input type="text" name="PerguntaUnica" value="<?php echo $dadosEncontrados[1]; ?>">
    <input type="text" name="Resposta" value="<?php echo $dadosEncontrados[2]; ?>">

    <button type="submit">Salvar</button>
</form>

</body>
</html>