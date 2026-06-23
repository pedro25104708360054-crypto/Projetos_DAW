<?php
function admin_header($title) {
    $nomeAdmin = $_SESSION['admin_nome'] ?? 'Admin';
    echo '<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>'.htmlspecialchars($title).'</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="admin-body">';
    echo '<aside class="sidebar"><h2>Studio</h2><a href="admin_dashboard.php">Visão geral</a><a href="admin_agendamentos.php">Agendamentos</a><a href="admin_funcionarios.php">Funcionários</a><a href="admin_servicos.php">Serviços</a><a href="admin_novo_cliente.php">Novo cliente</a><a href="admin_novo_funcionario.php">Novo funcionário</a><a href="admin_novo_servico.php">Novo serviço</a><a href="admin_logout.php">Sair</a></aside>';
    echo '<main class="admin-main"><header class="admin-top"><span>'.htmlspecialchars($title).'</span><strong>'.htmlspecialchars($nomeAdmin).'</strong></header>';
}
function admin_footer() { echo '</main><script src="assets/js/script.js"></script></body></html>'; }
?>
