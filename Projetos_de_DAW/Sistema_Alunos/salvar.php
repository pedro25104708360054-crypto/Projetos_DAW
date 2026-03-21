<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'];
    $nome      = $_POST['nome'];
    $email     = $_POST['email'];

    $linha = $matricula . ";" . $nome . ";" . $email . PHP_EOL;
    $arquivo = fopen("alunos.txt", "a");
    
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