var form = document.getElementById('formCadastro');
var telefone = document.getElementById('telefone');
var mensagem = document.getElementById('mensagem');

telefone.addEventListener('input', function() {
    var valor = telefone.value.replace(/\D/g, '').slice(0, 11);

    if (valor.length > 6) {
        telefone.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 7) + '-' + valor.slice(7);
    } else if (valor.length > 2) {
        telefone.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2);
    } else {
        telefone.value = valor;
    }
});

form.addEventListener('submit', function(event) {
    event.preventDefault();

    fetch('api/login_cliente.php', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(function(resposta) {
        return resposta.json();
    })
    .then(function(dados) {
        if (dados.ok) {
            alert('Cadastro realizado. Faça login.');
            window.location.href = 'cliente_login.html';
        } else {
            mensagem.innerHTML = '<div class="alert error">' + dados.mensagem + '</div>';
        }
    });
});
