<section class="stats">
    <?php foreach ($totais as $label => $valor): ?>
        <article>
            <strong><?= (int) $valor ?></strong>
            <span><?= e($label) ?></span>
        </article>
    <?php endforeach; ?>
</section>

<section class="panel">
    <div class="panel-header">
        <h2>Agendamentos recentes</h2>
        <a href="agendamentos.php" class="btn small">Ver todos</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Funcionário</th>
                <th>Serviço</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $agendamento): ?>
                <tr>
                    <td><?= e($agendamento['cliente']) ?></td>
                    <td><?= e($agendamento['funcionario']) ?></td>
                    <td><?= e($agendamento['servico']) ?></td>
                    <td><?= brDate($agendamento['data_agendamento']) ?></td>
                    <td><?= e(substr($agendamento['hora_agendamento'], 0, 5)) ?></td>
                    <td><span class="status"><?= e($agendamento['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>

            <?php if (!$agendamentos): ?>
                <tr><td colspan="6">Nenhum agendamento encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
