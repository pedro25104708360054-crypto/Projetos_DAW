<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';

requireAdmin();

$pdo = connection();
$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM funcionarios WHERE id = ?');
    $stmt->execute([$id]);
    flash('success', 'Funcionário excluído com sucesso.');
}

redirect('../../funcionarios.php');
