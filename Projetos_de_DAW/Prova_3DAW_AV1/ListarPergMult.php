<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista Respostas Multiplas</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 10px; }
        th { background-color: #eee; }
        .btn-add { display: inline-block; margin-bottom: 15px; text-decoration: none; color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Listar Resposta</h1>
    <a href="cadastroPergMult.html" class="btn-add">+ Adicionar Nova Resposta</a>

    <table>
        <tr><th>ID</th><th>Pergunta</th><th>Resposta A</th><th>Resposta B</th><th>Resposta C</th><th>Resposta D</th><th>Resposta CERTA</th><th>Ações</th></tr>
        <?php
        $caminho = "PerguntasMultiplas.txt";
        if (file_exists($caminho)) {
            $arqPergMult = fopen($caminho, "r");
            while(!feof($arqPergMult)) {
                $linha = trim(fgets($arqPergMult));
                if (!empty($linha)) {
                    $colunaDados = explode(";", $linha);

                    if (count($colunaDados) >= 5) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($colunaDados[0]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[1]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[2]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[3]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[4]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[5]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[6]) . "</td>";
                        echo "<td>
                                <a href='editarPerg.php?IDunico=" . urlencode($colunaDados[0]) . "'>Editar</a>
                                <a href='excluirPerg.php?IDunico=" . urlencode($colunaDados[0]) . "' 
           onclick=\"return confirm('Tem certeza que deseja excluir este aluno?')\" 
           style='color:red;'>Excluir</a>
                              </td>";
                        echo "</tr>";
                    }
                }
            }
            fclose($arqPergMult);
        }
        ?>
    </table>
</body>
</html>