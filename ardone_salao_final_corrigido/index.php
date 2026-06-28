<?php
require_once __DIR__ . '/config/database.php';

connection();

$pageTitle = APP_NAME . ' - Beleza e cuidado';
require_once __DIR__ . '/views/layout/public_header.php';
?>
<main>
    <section class="hero">
        <div class="hero-text">
            <span>Salão profissional</span>
            <h1>Ardone, beleza e cuidado com atendimento organizado.</h1>
            <p>Agende serviços de cabelo, unhas e estética com praticidade e horários disponíveis.</p>

            <a href="usuario_cadastro.php" class="btn primary">Criar conta</a>
            <a href="usuario_login.php" class="btn secondary">Entrar como cliente</a>
        </div>

        <img src="assets/img/salaoardone.png" alt="Salão Ardone">
    </section>

    <section class="section" id="servicos">
        <div class="section-title">
            <span>Serviços</span>
            <h2>Cuidados para diferentes momentos</h2>
        </div>

        <div class="cards-public">
            <article>
                <img src="assets/img/cabeloardone.png" alt="Serviço de cabelo">
                <h3>Cabelo</h3>
                <p>Cortes, escovas e hidratações.</p>
            </article>

            <article>
                <img src="assets/img/unhaardone.png" alt="Serviço de unhas">
                <h3>Unhas</h3>
                <p>Manicure e cuidados com acabamento delicado.</p>
            </article>

            <article>
                <img src="assets/img/esteticaardone.png" alt="Serviço de estética">
                <h3>Estética</h3>
                <p>Atendimentos de estética com agenda organizada.</p>
            </article>
        </div>
    </section>

    <section class="split" id="equipe">
        <img src="assets/img/funcionariosardone.png" alt="Equipe Ardone">

        <div>
            <span>Equipe Ardone</span>
            <h2>Atendimento feito por profissionais cadastrados.</h2>
            <p>Clientes marcam apenas horários disponíveis. Administradores controlam todo o salão.</p>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/views/layout/public_footer.php'; ?>
