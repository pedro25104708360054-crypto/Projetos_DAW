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


var form = document.getElementById('formAgendamento');
var tabela = document.getElementById('tabela');
var mensagem = document.getElementById('mensagem');
var lista = [];

function mostrarMensagem(texto, tipo) {
    mensagem.innerHTML = '<div class="alert ' + (tipo || 'success') + '">' + texto + '</div>';
}

function preencherSelect(id, dados) {
    var select = document.getElementById(id);
    select.innerHTML = '<option value="">Selecione</option>';

    for (var i = 0; i < dados.length; i++) {
        select.innerHTML += '<option value="' + dados[i].id + '">' + dados[i].nome + '</option>';
    }
}

function carregarOpcoes() {
    fetch('api/opcoes.php?_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        preencherSelect('cliente_id', dados.clientes);
        preencherSelect('servico_id', dados.servicos);
    });
}

function carregarFuncionarios(servicoId, selecionado) {
    var funcionario = document.getElementById('funcionario_id');

    if (!servicoId) {
        funcionario.innerHTML = '<option value="">Escolha o serviço</option>';
        return;
    }

    fetch('api/opcoes.php?servico_id=' + servicoId + '&_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        preencherSelect('funcionario_id', dados.funcionarios);

        if (selecionado) {
            funcionario.value = selecionado;
        }
    });
}

function listar() {
    fetch('api/agendamentos.php?acao=listar&_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        lista = dados.dados || [];
        tabela.innerHTML = '';

        for (var i = 0; i < lista.length; i++) {
            var item = lista[i];
            tabela.innerHTML += '<tr>' +
                '<td>' + item.cliente + '</td>' +
                '<td>' + item.funcionario + '</td>' +
                '<td>' + item.servico + '</td>' +
                '<td>' + item.data_agendamento + '</td>' +
                '<td>' + item.hora_agendamento.substring(0, 5) + '</td>' +
                '<td>' + item.status + '</td>' +
                '<td>' +
                    '<button class="link" onclick="editar(' + item.id + ')">Editar</button>' +
                    '<button class="link danger" onclick="excluir(' + item.id + ')">Excluir</button>' +
                '</td>' +
                '</tr>';
        }

        if (lista.length == 0) {
            tabela.innerHTML = '<tr><td colspan="7">Nenhum agendamento encontrado.</td></tr>';
        }
    });
}

function editar(id) {
    var item = null;

    for (var i = 0; i < lista.length; i++) {
        if (Number(lista[i].id) == Number(id)) {
            item = lista[i];
        }
    }

    if (!item) {
        return;
    }

    form.id.value = item.id;
    form.cliente_id.value = item.cliente_id;
    form.servico_id.value = item.servico_id;
    form.data_agendamento.value = item.data_agendamento;
    form.hora_agendamento.value = item.hora_agendamento.substring(0, 5);
    form.status.value = item.status;
    form.observacao.value = item.observacao || '';

    carregarFuncionarios(item.servico_id, item.funcionario_id);
}

function excluir(id) {
    if (!confirm('Excluir agendamento?')) {
        return;
    }

    var dados = new FormData();
    dados.append('acao', 'excluir');
    dados.append('id', id);

    fetch('api/agendamentos.php', {
        method: 'POST',
        body: dados
    }).then(function() {
        listar();
    });
}

document.getElementById('servico_id').addEventListener('change', function() {
    carregarFuncionarios(this.value, '');
});

document.getElementById('limpar').addEventListener('click', function() {
    form.reset();
    form.id.value = '';
    document.getElementById('funcionario_id').innerHTML = '<option value="">Escolha o serviço</option>';
});

form.addEventListener('submit', function(event) {
    event.preventDefault();

    var dados = new FormData(form);
    dados.append('acao', 'salvar');

    fetch('api/agendamentos.php', {
        method: 'POST',
        body: dados
    })
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        if (dados.ok) {
            form.reset();
            document.getElementById('funcionario_id').innerHTML = '<option value="">Escolha o serviço</option>';
            mostrarMensagem('Agendamento salvo.');
            listar();
        } else {
            mostrarMensagem(dados.mensagem || 'Erro ao salvar.', 'error');
        }
    });
});

carregarOpcoes();
listar();
