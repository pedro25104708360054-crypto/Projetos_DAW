<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST['IDmultiplo'];
    $pergunta = $_POST['PerguntaMultipla'];
    $respostaA     = $_POST['respostaA'];
    $respostaB     = $_POST['respostaB'];
    $respostaC     = $_POST['respostaC'];
    $respostaD     = $_POST['respostaD'];
    $respostaCerta   = $_POST['respostaCerta'];

    $linha = $ID . ";" . $pergunta . ";" . $respostaA . ";" . $respostaB . ";" . $respostaC . ";" . $respostaD . ";" . $respostaCerta . PHP_EOL;
    $arquivo = fopen("PerguntasMultiplas.txt", "a");
    
    if (fwrite($arquivo, $linha)) {
        fclose($arquivo);
        header("Location: ListarPergMult.php");
        exit;
    } else {
        echo "Erro ao salvar os dados.";
        fclose($arquivo);
    }
}
?>