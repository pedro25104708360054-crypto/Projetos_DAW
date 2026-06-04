<?php
include("conexao.php");

$result = $conn->query("SELECT * FROM perguntas_multiplas");

$dados = [];

while($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

echo json_encode($dados);
?>