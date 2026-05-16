<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = trim($_POST['matricula'] ?? ''); ;
    $nome      = trim($_POST['nome'] ?? ''); ;
    $email     = trim($_POST['email'] ?? ''); ;

    $erros = [];
    
    if(empty ($matricula)) 
    {
        $erros[] = "A matrícula é obrigatória.";
    }
    elseif (!ctype_digit($matricula)) 
    {
        $erros[] = "A matrícula deve conter apenas números.";
    }

    
    if (empty($nome)) {
            $erros[] = "O nome é obrigatório.";
    } 
    elseif (strlen($nome) < 3) 
    {
            $erros[] = "O nome deve ter pelo menos 3 caracteres.";
    }

    if(empty($email)) 
    {
        $erros[] = "O email é obrigatório.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $erros[] = "O email deve ser válido.";
    }

    $arquivo  = "alunos.txt";

    if (file_exists($arquivo)) {
        $dados = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($dados as $linha) {
            list($matriculaExistente) = explode(";", $linha);
            if ($matriculaExistente === $matricula) {
                $erros[] = "A matrícula já existe.";
                break;
            }
        }
    }

    
    if (!empty($erros)) {
            echo "<h2>Erro ao cadastrar aluno</h2>";

            foreach ($erros as $erro) {
                echo "<p style='color:red;'>$erro</p>";
            }

            echo "<a href='cadastro.html'>Voltar</a>";
            exit;
        }

    
    $linha = $matricula . ";" . $nome . ";" . $email . PHP_EOL;

        $abrirArquivo = fopen($arquivo, "a");

        if ($abrirArquivo) {
            fwrite($abrirArquivo, $linha);
            fclose($abrirArquivo);

            header("Location: listar.php");
            exit;
        } else {
            echo "Erro ao abrir o arquivo para salvar os dados.";
        }

}
?>