<?php
$caminho = "PerguntasMultiplas.txt";
$idEditar = $_GET['IDmultiplo'] ?? null;
$dadosEncontrados = null;

if ($idEditar && file_exists($caminho)) {
    foreach (file($caminho) as $linha) {
        $dados = explode(";", trim($linha));

        if ($dados[0] == $idEditar) {
            $dadosEncontrados = $dados;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id_original'];
    $p = $_POST['PerguntaMultipla'];
    $a = $_POST['A'];
    $b = $_POST['B'];
    $c = $_POST['C'];
    $d = $_POST['D'];
    $correta = $_POST['correta'];

    $linhas = file($caminho);

    foreach ($linhas as $i => $linha) {
        $dados = explode(";", trim($linha));

        if ($dados[0] == $id) {
            $linhas[$i] = "$id;$p;$a;$b;$c;$d;$correta\n";
        }
    }

    file_put_contents($caminho, implode("", $linhas));

    header("Location: ListarPergMult.php");
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

<h2>Editar Múltipla</h2>

<form method="POST">
    <input type="hidden" name="id_original" value="<?php echo $dadosEncontrados[0]; ?>">

    <p>ID: <?php echo $dadosEncontrados[0]; ?></p>

    <input type="text" name="PerguntaMultipla" value="<?php echo $dadosEncontrados[1]; ?>"><br>
    <input type="text" name="A" value="<?php echo $dadosEncontrados[2]; ?>"><br>
    <input type="text" name="B" value="<?php echo $dadosEncontrados[3]; ?>"><br>
    <input type="text" name="C" value="<?php echo $dadosEncontrados[4]; ?>"><br>
    <input type="text" name="D" value="<?php echo $dadosEncontrados[5]; ?>"><br>
    <input type="text" name="correta" value="<?php echo $dadosEncontrados[6]; ?>"><br>

    <button type="submit">Salvar</button>
</form>

</body>
</html>