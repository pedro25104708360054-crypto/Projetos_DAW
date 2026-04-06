<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sigla = $_POST['sigla'];
    $nome      = $_POST['nome'];
    $carga     = $_POST['carga'];

    $linha = $sigla . ";" . $nome . ";" . $carga . PHP_EOL;
    $arquivo = fopen("disciplina.txt", "a");
    
    if (fwrite($arquivo, $linha)) {
        fclose($arquivo);
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao salvar os dados.";
        fclose($arquivo);
    }
}
?>