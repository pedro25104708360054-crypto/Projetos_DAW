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


var tabelaSistema = '';
var campos = [];
var lista = [];
var form = document.getElementById('formCadastro');
var tabela = document.getElementById('tabela');
var mensagem = document.getElementById('mensagem');

function mostrarMensagem(texto, tipo) {
    mensagem.innerHTML = '<div class="alert ' + (tipo || 'success') + '">' + texto + '</div>';
}

function carregarLista() {
    fetch('api/cadastros.php?tabela=' + tabelaSistema + '&acao=listar&_=' + Date.now(), {cache: 'no-store'})
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        if (!dados.ok) {
            mostrarMensagem(dados.mensagem || 'Erro ao carregar.', 'error');
            return;
        }

        lista = dados.dados;
        montarTabela();
    });
}

function editar(id) {
    var item = null;

    for (var i = 0; i < lista.length; i++) {
        if (Number(lista[i].id) == Number(id)) {
            item = lista[i];
        }
    }

    if (item == null) {
        return;
    }

    for (var j = 0; j < campos.length; j++) {
        var campo = campos[j];
        var elemento = document.getElementById(campo);

        if (elemento) {
            elemento.value = item[campo] || '';
        }
    }
}

function excluir(id) {
    if (!confirm('Excluir registro?')) {
        return;
    }

    var dados = new FormData();
    dados.append('tabela', tabelaSistema);
    dados.append('acao', 'excluir');
    dados.append('id', id);

    fetch('api/cadastros.php', {
        method: 'POST',
        body: dados
    })
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function() {
        carregarLista();
    });
}

form.addEventListener('submit', function(event) {
    event.preventDefault();

    var dados = new FormData(form);
    dados.append('acao', 'salvar');

    fetch('api/cadastros.php', {
        method: 'POST',
        body: dados
    })
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        if (dados.ok) {
            form.reset();
            document.getElementById('id').value = '';
            mostrarMensagem('Registro salvo.');
            carregarLista();
        } else {
            mostrarMensagem(dados.mensagem || 'Erro ao salvar.', 'error');
        }
    });
});

document.getElementById('limpar').addEventListener('click', function() {
    form.reset();
    document.getElementById('id').value = '';
});

tabelaSistema = 'servicos';
campos = ['id', 'nome', 'preco', 'duracao_min', 'status'];

function montarTabela() {
    tabela.innerHTML = '';

    for (var i = 0; i < lista.length; i++) {
        var item = lista[i];
        tabela.innerHTML += '<tr>' +
            '<td>' + item.nome + '</td>' +
            '<td>R$ ' + item.preco + '</td>' +
            '<td>' + item.duracao_min + ' min</td>' +
            '<td>' + item.status + '</td>' +
            '<td>' +
                '<button class="link" onclick="editar(' + item.id + ')">Editar</button>' +
                '<button class="link danger" onclick="excluir(' + item.id + ')">Excluir</button>' +
            '</td>' +
            '</tr>';
    }

    if (lista.length == 0) {
        tabela.innerHTML = '<tr><td colspan="5">Nenhum serviço encontrado.</td></tr>';
    }
}

carregarLista();
