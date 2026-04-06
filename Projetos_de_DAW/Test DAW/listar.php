<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Disciplina</title>
</head>
<body>
    <h1>Listar Disciplinas</h1>
    <a href="index.html" class="btn-add">+ Adicionar Nova disciplina</a>

    <table>
        <tr><th>Sigla</th><th>Nome</th><th>Carga</th></tr>
        <?php
        $caminho = "disciplina.txt";
        if (file_exists($caminho)) {
            $arqDis = fopen($caminho, "r");
            while(!feof($arqDis)) {
                $linha = trim(fgets($arqDis));
                if (!empty($linha)) {
                    $colunaDados = explode(";", $linha);

                    if (count($colunaDados) >= 3) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($colunaDados[0]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[1]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[2]) . "</td>";
                        echo "</tr>";
                    }
                }
            }
            fclose($arqDis);
        }
        ?>
    </table>
</body>
</html>