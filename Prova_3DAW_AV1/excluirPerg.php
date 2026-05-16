<?php
$idExcluir = $_GET['IDunico'] ?? null;
$caminho = "Pergunta.txt";

if ($idExcluir && file_exists($caminho)) {
    $linhas = file($caminho);
    $novasLinhas = [];
    foreach ($linhas as $linha) {
        $dados = explode(";", trim($linha));
        if ($dados[0] !== $idExcluir) {
            $novasLinhas[] = $linha;
        }
    }
    file_put_contents($caminho, implode("", $novasLinhas));
}

header("Location: ListarPerg.php");
exit;