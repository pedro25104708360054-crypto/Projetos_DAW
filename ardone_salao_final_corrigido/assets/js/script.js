document.addEventListener('DOMContentLoaded', () => {
    const phoneInputs = document.querySelectorAll('input[name="telefone"]');

    phoneInputs.forEach((input) => {
        input.addEventListener('input', () => {
            const numbers = input.value.replace(/\D/g, '').slice(0, 11);
            const ddd = numbers.slice(0, 2);
            const first = numbers.length > 10 ? numbers.slice(2, 7) : numbers.slice(2, 6);
            const second = numbers.length > 10 ? numbers.slice(7, 11) : numbers.slice(6, 10);

            input.value = numbers.length > 6
                ? `(${ddd}) ${first}-${second}`
                : numbers.length > 2
                    ? `(${ddd}) ${first}`
                    : numbers;
        });
    });

    const funcionario = document.getElementById('usuarioFuncionario');
    const data = document.getElementById('usuarioData');
    const hora = document.getElementById('usuarioHora');

    async function carregarHorarios() {
        if (!funcionario || !data || !hora) {
            return;
        }

        hora.innerHTML = '<option value="">Carregando...</option>';

        if (!funcionario.value || !data.value) {
            hora.innerHTML = '<option value="">Selecione funcionário e data</option>';
            return;
        }

        try {
            const params = new URLSearchParams({
                funcionario_id: funcionario.value,
                data: data.value,
            });
            const response = await fetch(`api/horarios_disponiveis.php?${params.toString()}`);
            const horarios = await response.json();

            hora.innerHTML = '<option value="">Selecione</option>';

            if (!horarios.length) {
                hora.innerHTML = '<option value="">Nenhum horário disponível</option>';
                return;
            }

            horarios.forEach((item) => {
                const option = document.createElement('option');
                option.value = item.value;
                option.textContent = item.label;
                hora.appendChild(option);
            });
        } catch (error) {
            hora.innerHTML = '<option value="">Erro ao carregar horários</option>';
        }
    }

    funcionario?.addEventListener('change', carregarHorarios);
    data?.addEventListener('change', carregarHorarios);
    carregarHorarios();
});
