<?php
$matricula_alvo = $_GET['matricula'] ?? '';
$aluno_encontrado = null;

if (!empty($matricula_alvo)) {
    $arq = fopen("alunos.txt", "r");
    while (!feof($arq)) {
        $linha = trim(fgets($arq));
        if ($linha) {
            $dados = explode(";", $linha);
            if ($dados[0] == $matricula_alvo) {
                $aluno_encontrado = $dados;
                break;
            }
        }
    }
    fclose($arq);
}

if (!$aluno_encontrado) {
    die("Aluno não encontrado! <a href='listar.php'>Voltar</a>");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head><title>Editar Aluno</title></head>
<body>
    <h2>Editar Aluno</h2>
    <form action="atualizar.php" method="POST">
        <input type="hidden" name="matricula_antiga" value="<?= htmlspecialchars($aluno_encontrado[0]) ?>">
        
        <label>Matrícula:</label><br>
        <input type="text" name="matricula" value="<?= htmlspecialchars($aluno_encontrado[0]) ?>" required><br><br>

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($aluno_encontrado[1]) ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($aluno_encontrado[2]) ?>" required><br><br>

        <button type="submit">Salvar Alterações</button>
        <a href="listar.php">Cancelar</a>
    </form>
</body>
</html>