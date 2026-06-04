<?php
header("Content-Type: text/plain; charset=utf-8");

include("conexao.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo "Erro: nenhum dado recebido.";
    exit;
}

if (
    !isset($data["id"]) ||
    !isset($data["pergunta"]) ||
    !isset($data["a"]) ||
    !isset($data["b"]) ||
    !isset($data["c"]) ||
    !isset($data["d"]) ||
    !isset($data["correta"])
) {
    echo "Erro: dados incompletos.";
    exit;
}

$id = intval($data["id"]);
$pergunta = trim($data["pergunta"]);
$a = trim($data["a"]);
$b = trim($data["b"]);
$c = trim($data["c"]);
$d = trim($data["d"]);
$correta = trim($data["correta"]);

$sql = "UPDATE perguntas_multiplas
        SET pergunta = ?, a = ?, b = ?, c = ?, d = ?, correta = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro no prepare: " . $conn->error;
    exit;
}

$stmt->bind_param(
    "ssssssi",
    $pergunta,
    $a,
    $b,
    $c,
    $d,
    $correta,
    $id
);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Atualizado com sucesso";
    } else {
        echo "Nenhum registro foi alterado. Verifique se o ID existe ou se os dados são iguais aos atuais.";
    }
} else {
    echo "Erro ao atualizar: " . $stmt->error;
}
?>
``