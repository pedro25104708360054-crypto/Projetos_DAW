<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['CPF'];
    $nome      = $_POST['nome'];

    $linha = $cpf . ";" . $nome . PHP_EOL;
    $arquivo = fopen("Usuario.txt", "a");
    
    if (fwrite($arquivo, $linha)) {
        fclose($arquivo);
        header("Location: MenuPrincipal.html");
        exit;
    } else {
        echo "Erro ao salvar os dados.";
        fclose($arquivo);
    }
}
?>
