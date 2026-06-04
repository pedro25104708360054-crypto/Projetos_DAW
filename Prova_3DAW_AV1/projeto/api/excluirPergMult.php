<?php
$idExcluir = $_GET['IDmultiplo'] ?? null;
$caminho = "PerguntasMultiplas.txt";

if ($idExcluir && file_exists($caminho)) {

    $linhas = file($caminho);
    $novo = [];

    foreach ($linhas as $linha) {
        $dados = explode(";", trim($linha));

        if ($dados[0] != $idExcluir) {
            $novo[] = $linha;
        }
    }

    file_put_contents($caminho, implode("", $novo));
}

header("Location: ListarPergMult.php");
exit;
?>
