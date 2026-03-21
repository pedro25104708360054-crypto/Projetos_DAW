<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula_antiga = $_POST['matricula_antiga'];
    $nova_matricula = $_POST['matricula'];
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];

    $linhas = file("alunos.txt"); 
    $conteudo_final = "";

    foreach ($linhas as $linha) {
        $linha_limpa = trim($linha);
        if (empty($linha_limpa)) continue;

        $dados = explode(";", $linha_limpa);
        
        if ($dados[0] == $matricula_antiga) {
            
            $conteudo_final .= "$nova_matricula;$novo_nome;$novo_email" . PHP_EOL;
        } else {
            
            $conteudo_final .= $linha_limpa . PHP_EOL;
        }
    }

    if (file_put_contents("alunos.txt", $conteudo_final)) {
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao atualizar arquivo.";
    }
}
?>