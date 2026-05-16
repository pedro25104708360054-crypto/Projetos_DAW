<?php
$caminho = "PerguntasMultiplas.txt";
$idEditar = $_GET['IDmultiplo'] ?? null;
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
    $pergunta = $_POST['PerguntaMultipla'];
    $rA = $_POST['respostaA']; $rB = $_POST['respostaB'];
    $rC = $_POST['respostaC']; $rD = $_POST['respostaD'];
    $rCerta = $_POST['respostaCerta'];
    
    $linhas = file($caminho);
    foreach ($linhas as $i => $linha) {
        $dados = explode(";", trim($linha));
        if ($dados[0] == $idOriginal) {
            $linhas[$i] = "$idOriginal;$pergunta;$rA;$rB;$rC;$rD;$rCerta" . PHP_EOL;
            break;
        }
    }
    file_put_contents($caminho, implode("", $linhas));
    header("Location: ListarPergMult.php");
    exit;
}
if (!$dadosEncontrados) { echo "Registro não encontrado."; exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Editar Múltipla</title></head>
<body>
    <h2>Editar Pergunta Múltipla</h2>
    <form method="POST">
        <input type="hidden" name="id_original" value="<?php echo $dadosEncontrados[0]; ?>">
        <label>ID: <?php echo $dadosEncontrados[0]; ?></label><br><br>
        <label>Pergunta:</label><br>
        <input type="text" name="PerguntaMultipla" value="<?php echo $dadosEncontrados[1]; ?>" required><br><br>
        <label>A:</label> <input type="text" name="respostaA" value="<?php echo $dadosEncontrados[2]; ?>" required><br>
        <label>B:</label> <input type="text" name="respostaB" value="<?php echo $dadosEncontrados[3]; ?>" required><br>
        <label>C:</label> <input type="text" name="respostaC" value="<?php echo $dadosEncontrados[4]; ?>" required><br>
        <label>D:</label> <input type="text" name="respostaD" value="<?php echo $dadosEncontrados[5]; ?>" required><br><br>
        <label>Correta:</label> <input type="text" name="respostaCerta" value="<?php echo $dadosEncontrados[6]; ?>" required><br><br>
        <button type="submit">Salvar Alterações</button>
        <a href="ListarPergMult.php">Cancelar</a>
    </form>
</body>
</html>