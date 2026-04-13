<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista Respostas Unicas</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 10px; }
        th { background-color: #eee; }
        .btn-add { display: inline-block; margin-bottom: 15px; text-decoration: none; color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Listar Resposta</h1>
    <a href="cadastroPerg.html" class="btn-add">+ Adicionar Nova Resposta</a>

    <table>
        <tr><th>ID</th><th>Pergunta</th><th>Resposta</th><th>Ações</th></tr>
        <?php
        $caminho = "Pergunta.txt";
        if (file_exists($caminho)) {
            $arqPerg = fopen($caminho, "r");
            while(!feof($arqPerg)) {
                $linha = trim(fgets($arqPerg));
                if (!empty($linha)) {
                    $colunaDados = explode(";", $linha);

                    if (count($colunaDados) >= 2) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($colunaDados[0]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[1]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[2]) . "</td>";
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
            fclose($arqPerg);
        }
        ?>
    </table>
</body>
</html>
