<section class="panel form-panel">
    <h2><?= $servico['id'] ? 'Editar serviço' : 'Novo serviço' ?></h2>

    <form method="POST" action="actions/admin/salvar_servico.php" class="form-grid">
        <input type="hidden" name="id" value="<?= e((string) $servico['id']) ?>">

        <label>Nome</label>
        <input name="nome" value="<?= e($servico['nome']) ?>" required>

        <label>Preço</label>
        <input name="preco" value="<?= e((string) $servico['preco']) ?>" required>

        <label>Duração</label>
        <input type="number" name="duracao_min" value="<?= e((string) $servico['duracao_min']) ?>" min="15" required>

        <label>Status</label>
        <select name="status">
            <option value="Ativo" <?= $servico['status'] === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
            <option value="Inativo" <?= $servico['status'] === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
        </select>

        <div class="form-actions">
            <a href="servicos.php">Limpar</a>
            <button class="btn primary">Salvar</button>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Serviços</h2>

    <form class="filters">
        <input name="q" placeholder="Filtrar serviço" value="<?= e($q) ?>">
        <select name="status">
            <option value="">Todos</option>
            <option value="Ativo" <?= $status === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
            <option value="Inativo" <?= $status === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
        </select>
        <button class="btn small">Filtrar</button>
        <a href="servicos.php">Limpar</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Duração</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($servicos as $item): ?>
                <tr>
                    <td><?= e($item['nome']) ?></td>
                    <td><?= money($item['preco']) ?></td>
                    <td><?= (int) $item['duracao_min'] ?> min</td>
                    <td><span class="status"><?= e($item['status']) ?></span></td>
                    <td>
                        <a href="servicos.php?editar=<?= $item['id'] ?>">Editar</a>
                        <a href="actions/admin/excluir_servico.php?id=<?= $item['id'] ?>" class="danger" onclick="return confirm('Excluir serviço?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (!$servicos): ?>
                <tr><td colspan="5">Nenhum serviço encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
