<?php
include("conexao.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo "Erro: nenhum dado recebido.";
    exit;
}

$sql = "INSERT INTO perguntas_multiplas (id, pergunta, a, b, c, d, correta)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro no prepare: " . $conn->error;
    exit;
}

$stmt->bind_param(
    "issssss",
    $data["id"],
    $data["pergunta"],
    $data["a"],
    $data["b"],
    $data["c"],
    $data["d"],
    $data["correta"]
);

if ($stmt->execute()) {
    echo "Salvo com sucesso";
} else {
    echo "Erro ao salvar: " . $stmt->error;
}
?>