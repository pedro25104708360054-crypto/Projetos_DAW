var form = document.getElementById('formLogin');
var mensagem = document.getElementById('mensagem');

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
            window.location.href = 'cliente_area.html';
        } else {
            mensagem.innerHTML = '<div class="alert error">' + dados.mensagem + '</div>';
        }
    });
});
