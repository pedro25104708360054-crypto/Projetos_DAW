<?php
header("Content-Type: application/json");

$dados = json_decode(file_get_contents("php://input"), true);

if (!$dados) {
    echo json_encode(["erro" => "Dados inválidos"]);
    exit;
}

$a = floatval($dados['a']);
$b = floatval($dados['b']);
$operacao = $dados['operacao'];
$resultado = null;

switch ($operacao) {
    case 'somar':
        $resultado = $a + $b;
        break;
    case 'subtrair':
        $resultado = $a - $b;
        break;
    case 'multiplicar':
        $resultado = $a * $b;
        break;
    case 'dividir':
        $resultado = ($b != 0) ? ($a / $b) : "Erro: divisão por zero!";
        break;
    case 'potencia':
        $resultado = pow($a, $b);
        break;
    case 'raiz':
        $resultado = ($a >= 0) ? sqrt($a) : "Erro: Raiz negativa!";
        break;
    default:
        $resultado = "Operação desconhecida";
}

echo json_encode(["resultado" => $resultado]);