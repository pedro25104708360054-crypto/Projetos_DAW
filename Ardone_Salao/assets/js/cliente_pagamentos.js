var tabela = document.getElementById('tabela');
var mensagem = document.getElementById('mensagem');

function sair() {
    fetch('api/sair.php').then(function() {
        window.location.href = 'cliente_login.html';
    });
}

function verificarLogin() {
    fetch('api/sessao.php?_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        if (!dados.cliente) {
            window.location.href = 'cliente_login.html';
        }
    });
}

function listarPagamentos() {
    fetch('api/pagamentos.php?acao=listar&origem=cliente&_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        if (!dados.ok) {
            mensagem.innerHTML = '<div class="alert error">' + (dados.mensagem || 'Erro ao carregar pagamentos.') + '</div>';
            return;
        }

        tabela.innerHTML = '';

        for (var i = 0; i < dados.dados.length; i++) {
            var item = dados.dados[i];
            tabela.innerHTML += '<tr>' +
                '<td>' + (item.servico || 'Pagamento avulso') + '</td>' +
                '<td>R$ ' + item.valor + '</td>' +
                '<td>' + item.forma_pagamento + '</td>' +
                '<td>' + item.status + '</td>' +
                '<td>' + item.data_pagamento + '</td>' +
                '</tr>';
        }

        if (dados.dados.length == 0) {
            tabela.innerHTML = '<tr><td colspan="5">Nenhum pagamento encontrado.</td></tr>';
        }
    });
}

document.getElementById('sair').addEventListener('click', function(event) {
    event.preventDefault();
    sair();
});

verificarLogin();
listarPagamentos();
