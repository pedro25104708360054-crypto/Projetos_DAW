<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = floatval($_POST["a"]);
    $b = floatval($_POST["b"]);
    $resultado = null;

    if (isset($_POST["somar"])) {
        $resultado = $a + $b;
    }

    if (isset($_POST["subtrair"])) {
        $resultado = $a - $b;
    }

    if (isset($_POST["multiplicar"])){
        $resultado = $a * $b;
    }

    if (isset($_POST["dividir"])) {
        if ($b != 0) {
            $resultado = $a / $b;
        } else {
            $resultado = "Erro: divisão por zero!";
        }
    }

    // --- Novas Funcionalidades ---
    
    if (isset($_POST["potencia"])) {
        // Calcula 'a' elevado a 'b'
        $resultado = pow($a, $b);
    }

    if (isset($_POST["raiz"])) {
        // Calcula a raiz quadrada de 'a' (ignora o 'b')
        if ($a >= 0) {
            $resultado = sqrt($a);
        } else {
            $resultado = "Erro: Raiz de número negativo!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Calculadora PHP</title>
</head>
<body>

<h1>Minha Calculadora!</h1>

<form method='POST' action=''>
    Valor A: <input type="text" name="a" value="<?php echo isset($a) ? $a : ''; ?>"><br>
    Valor B: <input type="text" name="b" value="<?php echo isset($b) ? $b : ''; ?>"><br><br>

    <input type="submit" name="somar" value="Somar">
    <input type="submit" name="subtrair" value="Subtrair">
    <input type="submit" name="multiplicar" value="Multiplicar">
    <input type="submit" name="dividir" value="Dividir">
    
    <input type="submit" name="potencia" value="A elevado a B">
    <input type="submit" name="raiz" value="Raiz Quadrada de A">

    <br><br>

    <?php
    // Corrigido de 'issent' para 'isset'
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($resultado)) {
        echo "<strong>Resultado: </strong>" . $resultado;
    }
    ?>

</form>

</body>
</html>