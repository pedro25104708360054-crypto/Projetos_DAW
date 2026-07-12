var form = document.getElementById('formAgendamento');
var tabela = document.getElementById('tabela');
var mensagem = document.getElementById('mensagem');
var forma = document.getElementById('forma_pagamento');
var dadosCartao = document.getElementById('dadosCartao');
var areaPix = document.getElementById('areaPix');
var qrPix = document.getElementById('qrPix');
var chavePix = document.getElementById('chavePix');

function mostrarMensagem(texto, tipo) {
    mensagem.innerHTML = '<div class="alert ' + (tipo || 'success') + '">' + texto + '</div>';
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

function sair() {
    fetch('api/sair.php').then(function() {
        window.location.href = 'cliente_login.html';
    });
}

function carregarServicos() {
    fetch('api/opcoes.php?_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        var servico = document.getElementById('servico_id');
        servico.innerHTML = '<option value="">Selecione</option>';

        for (var i = 0; i < dados.servicos.length; i++) {
            var item = dados.servicos[i];
            servico.innerHTML += '<option value="' + item.id + '">' + item.nome + ' - R$ ' + item.preco + '</option>';
        }
    });
}

function carregarFuncionarios(servicoId) {
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
        funcionario.innerHTML = '<option value="">Selecione</option>';

        for (var i = 0; i < dados.funcionarios.length; i++) {
            var item = dados.funcionarios[i];
            funcionario.innerHTML += '<option value="' + item.id + '">' + item.nome + '</option>';
        }
    });
}

function montarPix() {
    var servico = document.getElementById('servico_id');
    var textoServico = servico.options[servico.selectedIndex] ? servico.options[servico.selectedIndex].text : '';
    var valor = textoServico.indexOf('R$') > -1 ? textoServico.split('R$')[1].trim() : '';
    var dadosPix = 'Ardone Salão - Chave Pix: ' + chavePix.value;

    if (valor !== '') {
        dadosPix += ' - Valor: R$ ' + valor;
    }

    qrPix.src = 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=' + encodeURIComponent(dadosPix);
}

function verificarFormaPagamento() {
    var usarCartao = forma.value == 'Cartão de débito' || forma.value == 'Cartão de crédito';
    var usarPix = forma.value == 'Pix';

    dadosCartao.style.display = usarCartao ? 'contents' : 'none';
    document.getElementById('nome_cartao').required = usarCartao;
    document.getElementById('numero_cartao').required = usarCartao;
    document.getElementById('validade_cartao').required = usarCartao;
    document.getElementById('cvv_cartao').required = usarCartao;

    areaPix.style.display = usarPix ? 'block' : 'none';

    if (usarPix) {
        montarPix();
    }
}

function listarAgendamentos() {
    fetch('api/agendamentos.php?acao=listar&origem=cliente&_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        if (!dados.ok) {
            mostrarMensagem(dados.mensagem || 'Erro ao carregar agendamentos.', 'error');
            return;
        }

        tabela.innerHTML = '';

        for (var i = 0; i < dados.dados.length; i++) {
            var item = dados.dados[i];
            tabela.innerHTML += '<tr>' +
                '<td>' + item.servico + '</td>' +
                '<td>' + item.funcionario + '</td>' +
                '<td>' + item.data_agendamento + '</td>' +
                '<td>' + item.hora_agendamento.substring(0, 5) + '</td>' +
                '<td>' + item.status + '</td>' +
                '</tr>';
        }

        if (dados.dados.length == 0) {
            tabela.innerHTML = '<tr><td colspan="5">Nenhum agendamento encontrado.</td></tr>';
        }
    });
}

document.getElementById('sair').addEventListener('click', function(event) {
    event.preventDefault();
    sair();
});

document.getElementById('servico_id').addEventListener('change', function() {
    carregarFuncionarios(this.value);

    if (forma.value == 'Pix') {
        montarPix();
    }
});

forma.addEventListener('change', verificarFormaPagamento);

document.getElementById('copiarPix').addEventListener('click', function() {
    chavePix.select();
    navigator.clipboard.writeText(chavePix.value).then(function() {
        mostrarMensagem('Chave Pix copiada.');
    });
});

document.getElementById('numero_cartao').addEventListener('input', function() {
    var valor = this.value.replace(/\D/g, '').slice(0, 16);
    this.value = valor.replace(/(\d{4})(?=\d)/g, '$1 ');
});

document.getElementById('validade_cartao').addEventListener('input', function() {
    var valor = this.value.replace(/\D/g, '').slice(0, 6);
    this.value = valor.length > 2 ? valor.slice(0, 2) + '/' + valor.slice(2) : valor;
});

document.getElementById('cvv_cartao').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 4);
});

form.addEventListener('submit', function(event) {
    event.preventDefault();

    var dados = new FormData(form);
    dados.append('acao', 'salvar');
    dados.append('origem', 'cliente');

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
            verificarFormaPagamento();
            document.getElementById('funcionario_id').innerHTML = '<option value="">Escolha o serviço</option>';
            mostrarMensagem('Agendamento e pagamento salvos.');
            listarAgendamentos();
        } else {
            mostrarMensagem(dados.mensagem || 'Erro ao agendar.', 'error');
        }
    });
});

verificarLogin();
verificarFormaPagamento();
carregarServicos();
listarAgendamentos();
