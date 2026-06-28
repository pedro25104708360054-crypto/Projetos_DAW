<section class="panel form-panel">
    <h2><?= $agendamento['id'] ? 'Editar agendamento' : 'Novo agendamento' ?></h2>

    <form method="POST" action="actions/admin/salvar_agendamento.php" class="form-grid">
        <input type="hidden" name="id" value="<?= e((string) $agendamento['id']) ?>">

        <label>Cliente</label>
        <select name="cliente_id" required>
            <option value="">Selecione</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente['id'] ?>" <?= (int) $agendamento['cliente_id'] === (int) $cliente['id'] ? 'selected' : '' ?>><?= e($cliente['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Funcionário</label>
        <select name="funcionario_id" required>
            <option value="">Selecione</option>
            <?php foreach ($funcionarios as $funcionario): ?>
                <option value="<?= $funcionario['id'] ?>" <?= (int) $agendamento['funcionario_id'] === (int) $funcionario['id'] ? 'selected' : '' ?>><?= e($funcionario['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Serviço</label>
        <select name="servico_id" required>
            <option value="">Selecione</option>
            <?php foreach ($servicos as $servico): ?>
                <option value="<?= $servico['id'] ?>" <?= (int) $agendamento['servico_id'] === (int) $servico['id'] ? 'selected' : '' ?>><?= e($servico['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Data</label>
        <input type="date" name="data_agendamento" value="<?= e($agendamento['data_agendamento']) ?>" min="<?= date('Y-m-d') ?>" required>

        <label>Hora</label>
        <input type="time" name="hora_agendamento" value="<?= e(substr($agendamento['hora_agendamento'], 0, 5)) ?>" required>

        <label>Status</label>
        <select name="status">
            <?php foreach (['Agendado', 'Confirmado', 'Finalizado', 'Cancelado'] as $option): ?>
                <option value="<?= $option ?>" <?= $agendamento['status'] === $option ? 'selected' : '' ?>><?= $option ?></option>
            <?php endforeach; ?>
        </select>

        <label>Observação</label>
        <textarea name="observacao"><?= e($agendamento['observacao']) ?></textarea>

        <div class="form-actions">
            <a href="agendamentos.php">Limpar</a>
            <button class="btn primary">Salvar</button>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Agendamentos</h2>

    <form class="filters">
        <input name="q" placeholder="Cliente, funcionário ou serviço" value="<?= e($q) ?>">
        <input type="date" name="data" value="<?= e($data) ?>">
        <select name="status">
            <option value="">Todos</option>
            <?php foreach (['Agendado', 'Confirmado', 'Finalizado', 'Cancelado'] as $option): ?>
                <option value="<?= $option ?>" <?= $status === $option ? 'selected' : '' ?>><?= $option ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn small">Filtrar</button>
        <a href="agendamentos.php">Limpar</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Funcionário</th>
                <th>Serviço</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $item): ?>
                <tr>
                    <td><?= e($item['cliente']) ?></td>
                    <td><?= e($item['funcionario']) ?></td>
                    <td><?= e($item['servico']) ?></td>
                    <td><?= brDate($item['data_agendamento']) ?></td>
                    <td><?= e(substr($item['hora_agendamento'], 0, 5)) ?></td>
                    <td><span class="status"><?= e($item['status']) ?></span></td>
                    <td>
                        <a href="agendamentos.php?editar=<?= $item['id'] ?>">Editar</a>
                        <a href="actions/admin/excluir_agendamento.php?id=<?= $item['id'] ?>" class="danger" onclick="return confirm('Excluir agendamento?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (!$agendamentos): ?>
                <tr><td colspan="7">Nenhum agendamento encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
