
<?php
include("conexao.php");

$data = json_decode(file_get_contents("php://input"), true);

$sql = "INSERT INTO perguntas (id, pergunta, resposta) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $data["id"], $data["pergunta"], $data["resposta"]);

if ($stmt->execute()) {
    echo "Salvo com sucesso";
} else {
    echo "Erro ao salvar";
}
?>
