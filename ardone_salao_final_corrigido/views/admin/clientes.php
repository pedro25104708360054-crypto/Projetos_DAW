<section class="panel form-panel">
    <h2><?= $cliente['id'] ? 'Editar cliente' : 'Novo cliente' ?></h2>

    <form method="POST" action="actions/admin/salvar_cliente.php" class="form-grid">
        <input type="hidden" name="id" value="<?= e((string) $cliente['id']) ?>">

        <label>Nome</label>
        <input name="nome" value="<?= e($cliente['nome']) ?>" required>

        <label>E-mail</label>
        <input type="email" name="email" value="<?= e($cliente['email']) ?>" required>

        <label>Telefone</label>
        <input name="telefone" value="<?= e($cliente['telefone']) ?>" required>

        <label>Observação</label>
        <textarea name="observacao"><?= e($cliente['observacao']) ?></textarea>

        <div class="form-actions">
            <a href="clientes.php">Limpar</a>
            <button class="btn primary">Salvar</button>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Clientes</h2>

    <form class="filters">
        <input name="q" placeholder="Filtrar cliente" value="<?= e($q) ?>">
        <button class="btn small">Filtrar</button>
        <a href="clientes.php">Limpar</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $item): ?>
                <tr>
                    <td><?= e($item['nome']) ?></td>
                    <td><?= e($item['email']) ?></td>
                    <td><?= e($item['telefone']) ?></td>
                    <td>
                        <a href="clientes.php?editar=<?= $item['id'] ?>">Editar</a>
                        <a href="actions/admin/excluir_cliente.php?id=<?= $item['id'] ?>" class="danger" onclick="return confirm('Excluir cliente?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (!$clientes): ?>
                <tr><td colspan="4">Nenhum cliente encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
