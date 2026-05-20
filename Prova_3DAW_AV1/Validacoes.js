document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[type="text"]');
            
            // 1. Validação Universal: Impedir o uso de ";" (ponto e vírgula)
            // Como seu PHP usa explode(";", ...), um ";" no texto corromperia o arquivo.
            for (let input of inputs) {
                if (input.value.includes(';')) {
                    alert(`O caractere ";" não é permitido no campo: ${input.previousElementSibling.innerText}`);
                    e.preventDefault();
                    return;
                }
            }
          
        });
    });
});
