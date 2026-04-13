<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST['IDunico'];
    $pergunta = $_POST['PerguntaUnica'];
    $resposta      = $_POST['Resposta'];

    $linha = $ID. ";" . $pergunta . ";" . $resposta . PHP_EOL;
    $arquivo = fopen("Pergunta.txt", "a");
    
    if (fwrite($arquivo, $linha)) {
        fclose($arquivo);
        header("Location: ListarPerg.php");
        exit;
    } else {
        echo "Erro ao salvar os dados.";
        fclose($arquivo);
    }
}
?>