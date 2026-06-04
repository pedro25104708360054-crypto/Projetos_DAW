<?php
include("conexao.php");

$id = $_GET["id"] ?? null;

if (!$id) {
    echo "ID não informado.";
    exit;
}

$sql = "DELETE FROM perguntas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Excluído com sucesso";
} else {
    echo "Erro ao excluir: " . $stmt->error;
}
?>