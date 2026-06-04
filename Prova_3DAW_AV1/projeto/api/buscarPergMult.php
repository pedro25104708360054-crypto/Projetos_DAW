<?php
header("Content-Type: application/json; charset=utf-8");

include("conexao.php");

$id = $_GET["id"] ?? null;

if (!$id) {
    echo json_encode([
        "erro" => "ID não informado."
    ]);
    exit;
}

$sql = "SELECT id, pergunta, a, b, c, d, correta 
        FROM perguntas_multiplas 
        WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "erro" => "Erro no prepare: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo json_encode([
        "erro" => "Pergunta múltipla não encontrada."
    ]);
    exit;
}

$dados = $resultado->fetch_assoc();

echo json_encode($dados, JSON_UNESCAPED_UNICODE);
?>