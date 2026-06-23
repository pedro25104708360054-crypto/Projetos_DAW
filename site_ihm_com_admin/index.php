<?php
session_start();
$usuarioLogado = isset($_SESSION['usuario_id']);
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Beauty - Página Inicial</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div class="brand"><span class="brand-icon">✿</span></div>
        <nav class="menu">
            <a href="#inicio">Início</a>
            <a href="#servicos">Serviços</a>
            <a href="#equipe">Nossa equipe</a>
            <a href="cadastro.php">Cadastro</a>
            <a href="admin_login.php">Admin</a>
        </nav>
        <div class="auth-area">
            <?php if ($usuarioLogado): ?>
                <div class="user-card">
                    <span class="avatar-small">👤</span>
                    <div>
                        <strong><?= htmlspecialchars($nomeUsuario) ?></strong>
                        <a href="logout.php">Sair</a>
                    </div>
                </div>
            <?php else: ?>
                <a class="btn-login" href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <section id="inicio" class="hero section-light">
            <button class="slider-arrow left">‹</button>
            <div class="hero-image image-placeholder salon"></div>
            <article class="hero-text">
                <h1>Beleza, cuidado e bem-estar em um só lugar</h1>
                <p>Nosso espaço foi pensado para oferecer conforto, atendimento de qualidade e serviços especializados para valorizar a beleza de cada cliente.</p>
                <p>Trabalhamos com profissionais preparados, ambiente acolhedor e técnicas modernas para cabelos, estética e cuidados pessoais.</p>
            </article>
            <button class="slider-arrow right">›</button>
        </section>

        <section id="servicos" class="title-strip"><h2>Serviços</h2></section>
        <section class="services section-light">
            <div class="service-intro">
                <div class="service-avatar image-placeholder face"></div>
                <div>
                    <h3>Cabeleireiro</h3>
                    <p>Serviços de corte, hidratação, escova, coloração e tratamentos capilares, sempre com atenção ao estilo e à necessidade de cada cliente.</p>
                </div>
            </div>
            <div class="service-grid">
                <article class="service-card"><div class="service-photo image-placeholder nails"></div><p>Manicure e cuidados com unhas, com acabamento delicado e foco em higiene, beleza e durabilidade.</p></article>
                <article class="service-card"><div class="service-photo image-placeholder hair"></div><p>Tratamentos para cabelo, escova e finalização para diferentes ocasiões, mantendo brilho e aparência natural.</p></article>
            </div>
            <div class="carousel-dots"><span class="active"></span><span></span><span></span></div>
        </section>

        <section id="equipe" class="title-strip"><h2>Nossa Equipe</h2></section>
        <section class="team section-light">
            <button class="slider-arrow left">‹</button>
            <div class="team-photo image-placeholder professional"></div>
            <article class="team-text"><p>A equipe é formada por profissionais capacitados para oferecer atendimento cuidadoso, respeitoso e personalizado.</p></article>
        </section>
    </main>

    <footer class="footer">
        <div><strong>Contato</strong><span>studio@exemplo.com</span></div>
        <div><strong>Telefone</strong><span>(21) 99999-9999</span></div>
        <div><strong>Endereço</strong><span>Nilópolis - RJ</span></div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>
