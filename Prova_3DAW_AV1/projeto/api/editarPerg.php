<?php
include("conexao.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo "Erro: nenhum dado recebido.";
    exit;
}

$sql = "UPDATE perguntas 
        SET pergunta = ?, resposta = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro no prepare: " . $conn->error;
    exit;
}

$stmt->bind_param(
    "ssi",
    $data["pergunta"],
    $data["resposta"],
    $data["id"]
);

if ($stmt->execute()) {
    echo "Atualizado com sucesso";
} else {
    echo "Erro ao atualizar: " . $stmt->error;
}
?>