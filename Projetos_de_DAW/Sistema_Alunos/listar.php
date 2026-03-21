<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alunos</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 10px; }
        th { background-color: #eee; }
        .btn-add { display: inline-block; margin-bottom: 15px; text-decoration: none; color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Listar Alunos</h1>
    <a href="cadastro.html" class="btn-add">+ Adicionar Novo Aluno</a>

    <table>
        <tr><th>Matrícula</th><th>Nome</th><th>Email</th><th>Ações</th></tr>
        <?php
        $caminho = "alunos.txt";
        if (file_exists($caminho)) {
            $arqAluno = fopen($caminho, "r");
            while(!feof($arqAluno)) {
                $linha = trim(fgets($arqAluno));
                if (!empty($linha)) {
                    $colunaDados = explode(";", $linha);

                    if (count($colunaDados) >= 3) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($colunaDados[0]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[1]) . "</td>";
                        echo "<td>" . htmlspecialchars($colunaDados[2]) . "</td>";
                        echo "<td>
                                <a href='editar.php?matricula=" . urlencode($colunaDados[0]) . "'>Editar</a>
                              </td>";
                        echo "</tr>";
                    }
                }
            }
            fclose($arqAluno);
        }
        ?>
    </table>
</body>
</html>