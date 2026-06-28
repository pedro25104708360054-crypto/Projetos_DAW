<section class="panel form-panel">
    <h2>Marcar horário disponível</h2>

    <form method="POST" action="actions/cliente/marcar.php" class="form-grid">
        <label>Funcionário</label>
        <select name="funcionario_id" id="usuarioFuncionario" required>
            <option value="">Selecione</option>
            <?php foreach ($funcionarios as $funcionario): ?>
                <option value="<?= $funcionario['id'] ?>"><?= e($funcionario['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Serviço</label>
        <select name="servico_id" required>
            <option value="">Selecione</option>
            <?php foreach ($servicos as $servico): ?>
                <option value="<?= $servico['id'] ?>">
                    <?= e($servico['nome']) ?> - <?= money($servico['preco']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Data</label>
        <input type="date" name="data_agendamento" id="usuarioData" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required>

        <label>Horário disponível</label>
        <select name="hora_agendamento" id="usuarioHora" required>
            <option value="">Selecione funcionário e data</option>
        </select>

        <label>Observação</label>
        <textarea name="observacao"></textarea>

        <div class="form-actions">
            <button class="btn primary">Marcar horário</button>
        </div>
    </form>
</section>

<section class="panel">
    <h2>Meus agendamentos</h2>

    <table>
        <thead>
            <tr>
                <th>Funcionário</th>
                <th>Serviço</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meusAgendamentos as $item): ?>
                <tr>
                    <td><?= e($item['funcionario']) ?></td>
                    <td><?= e($item['servico']) ?></td>
                    <td><?= brDate($item['data_agendamento']) ?></td>
                    <td><?= e(substr($item['hora_agendamento'], 0, 5)) ?></td>
                    <td><span class="status"><?= e($item['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>

            <?php if (!$meusAgendamentos): ?>
                <tr><td colspan="5">Você ainda não possui agendamentos.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
