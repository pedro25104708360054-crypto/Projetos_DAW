<?php
include("conexao.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = "INSERT INTO perguntas_multiplas (id, pergunta, a, b, c, d, correta)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

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
    echo "Erro ao salvar: " . $conn->error;
}
?>