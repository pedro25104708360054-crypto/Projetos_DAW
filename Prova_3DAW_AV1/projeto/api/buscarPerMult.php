<?php
include("conexao.php");

$id = $_GET["id"];

$sql = "SELECT * FROM perguntas_multiplas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();

echo json_encode($dados);
?>