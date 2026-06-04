<?php
include("conexao.php");

$result = $conn->query("SELECT * FROM perguntas");

$dados = [];

while($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

echo json_encode($dados);
?>
