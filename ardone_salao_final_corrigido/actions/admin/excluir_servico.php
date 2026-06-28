<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';

requireAdmin();

$pdo = connection();
$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM servicos WHERE id = ?');
    $stmt->execute([$id]);
    flash('success', 'Serviço excluído com sucesso.');
}

redirect('../../servicos.php');
