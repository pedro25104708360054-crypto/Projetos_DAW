<section class="panel form-panel">
    <h2><?= $funcionario['id'] ? 'Editar funcionário' : 'Novo funcionário' ?></h2>

    <form method="POST" action="actions/admin/salvar_funcionario.php" class="form-grid">
        <input type="hidden" name="id" value="<?= e((string) $funcionario['id']) ?>">

        <label>Nome</label>
        <input name="nome" value="<?= e($funcionario['nome']) ?>" required>

        <label>E-mail</label>
        <input type="email" name="email" value="<?= e($funcionario['email']) ?>">

        <label>Telefone</label>
        <input name="telefone" value="<?= e($funcionario['telefone']) ?>">

        <label>Função</label>
        <input name="funcao" value="<?= e($funcionario['funcao']) ?>" required>

        <label>Status</label>
        <select name="status">
            <option value="Ativo" <?= $funcionario['status'] === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
            <option value="Inativo" <?= $funcionario['status'] === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
        </select>

        <div class="form-actions">
            <a href="funcionarios.php">Limpar</a>
            <button class="btn primary">Salvar</button>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Funcionários</h2>

    <form class="filters">
        <input name="q" placeholder="Filtrar funcionário" value="<?= e($q) ?>">
        <select name="status">
            <option value="">Todos</option>
            <option value="Ativo" <?= $status === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
            <option value="Inativo" <?= $status === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
        </select>
        <button class="btn small">Filtrar</button>
        <a href="funcionarios.php">Limpar</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Função</th>
                <th>Telefone</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios as $item): ?>
                <tr>
                    <td><?= e($item['nome']) ?></td>
                    <td><?= e($item['funcao']) ?></td>
                    <td><?= e($item['telefone']) ?></td>
                    <td><span class="status"><?= e($item['status']) ?></span></td>
                    <td>
                        <a href="funcionarios.php?editar=<?= $item['id'] ?>">Editar</a>
                        <a href="actions/admin/excluir_funcionario.php?id=<?= $item['id'] ?>" class="danger" onclick="return confirm('Excluir funcionário?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (!$funcionarios): ?>
                <tr><td colspan="5">Nenhum funcionário encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
