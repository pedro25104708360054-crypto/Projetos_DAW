<?php
header("Content-Type: application/json; charset=utf-8");

include("conexao.php");

$sql = "SELECT id, pergunta, a, b, c, d, correta FROM perguntas_multiplas ORDER BY id ASC";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "erro" => "Erro na consulta: " . $conn->error
    ]);
    exit;
}

$dados = [];

while ($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

echo json_encode($dados, JSON_UNESCAPED_UNICODE);
?>