function sair() {
    fetch('api/sair.php').then(function() {
        window.location.href = 'admin_login.html';
    });
}

function verificarLogin() {
    fetch('api/sessao.php?_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        if (!dados.admin) {
            window.location.href = 'admin_login.html';
        } else {
            document.getElementById('nomeAdmin').innerText = dados.admin;
        }
    });
}

document.getElementById('sair').addEventListener('click', function(event) {
    event.preventDefault();
    sair();
});

verificarLogin();


fetch('api/dashboard.php?_=' + Date.now(), {cache: 'no-store'})
.then(function(resposta) {
    return resposta.json();
})
.then(function(dados) {
    if (!dados.ok) {
        return;
    }

    document.getElementById('totalClientes').innerText = dados.totais.clientes;
    document.getElementById('totalFuncionarios').innerText = dados.totais.funcionarios;
    document.getElementById('totalServicos').innerText = dados.totais.servicos;
    document.getElementById('totalAgendamentos').innerText = dados.totais.agendamentos;
    document.getElementById('totalPagamentos').innerText = dados.totais.pagamentos;

    var tabela = document.getElementById('tabelaRecentes');
    tabela.innerHTML = '';

    for (var i = 0; i < dados.agendamentos.length; i++) {
        var item = dados.agendamentos[i];
        tabela.innerHTML += '<tr>' +
            '<td>' + item.cliente + '</td>' +
            '<td>' + item.funcionario + '</td>' +
            '<td>' + item.servico + '</td>' +
            '<td>' + item.data_agendamento + '</td>' +
            '<td>' + item.hora_agendamento.substring(0, 5) + '</td>' +
            '<td>' + item.status + '</td>' +
            '</tr>';
    }

    if (dados.agendamentos.length == 0) {
        tabela.innerHTML = '<tr><td colspan="6">Nenhum agendamento encontrado.</td></tr>';
    }
});
