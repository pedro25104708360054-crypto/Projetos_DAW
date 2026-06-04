// ===============================
// FUNÇÕES DE VALIDAÇÃO
// ===============================

function campoVazio(valor) {
    return valor.trim() === "";
}

function contemPontoEVirgula(valor) {
    return valor.includes(";");
}

function validarTextoBasico(valor, nomeCampo, minimo = 2) {
    if (campoVazio(valor)) {
        alert(`${nomeCampo} não pode ficar vazio.`);
        return false;
    }

    if (valor.trim().length < minimo) {
        alert(`${nomeCampo} precisa ter pelo menos ${minimo} caracteres.`);
        return false;
    }

    if (contemPontoEVirgula(valor)) {
        alert(`${nomeCampo} não pode conter ponto e vírgula (;).`);
        return false;
    }

    return true;
}

function validarId(id, nomeCampo) {
    if (campoVazio(id)) {
        alert(`${nomeCampo} não pode ficar vazio.`);
        return false;
    }

    if (isNaN(id)) {
        alert(`${nomeCampo} deve ser um número.`);
        return false;
    }

    if (parseInt(id) <= 0) {
        alert(`${nomeCampo} deve ser maior que zero.`);
        return false;
    }

    return true;
}

function existemRespostasRepetidas(respostas) {
    const respostasNormalizadas = respostas.map(r => r.trim().toLowerCase());
    const conjunto = new Set(respostasNormalizadas);

    return conjunto.size !== respostasNormalizadas.length;
}


// ===============================
// PERGUNTA ÚNICA
// ===============================

const form = document.getElementById("form");

if (form) {
    form.addEventListener("submit", async function(e) {
        e.preventDefault();

        const dados = {
            id: form.IDunico.value.trim(),
            pergunta: form.PerguntaUnica.value.trim(),
            resposta: form.Resposta.value.trim()
        };

        if (!validarId(dados.id, "ID")) {
            return;
        }

        if (!validarTextoBasico(dados.pergunta, "Pergunta", 5)) {
            return;
        }

        if (!validarTextoBasico(dados.resposta, "Resposta", 1)) {
            return;
        }

        try {
            const res = await fetch("api/salvarPerg.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(dados)
            });

            const resposta = await res.text();
            alert(resposta);

            if (resposta.includes("sucesso")) {
                form.reset();
            }

        } catch (erro) {
            alert("Erro ao salvar pergunta única.");
            console.error(erro);
        }
    });
}


// ===============================
// PERGUNTA MÚLTIPLA
// ===============================

const formMult = document.getElementById("formMult");

if (formMult) {
    formMult.addEventListener("submit", async function(e) {
        e.preventDefault();

        const dados = {
            id: formMult.IDmultiplo.value.trim(),
            pergunta: formMult.PerguntaMultipla.value.trim(),
            a: formMult.A.value.trim(),
            b: formMult.B.value.trim(),
            c: formMult.C.value.trim(),
            d: formMult.D.value.trim(),
            correta: formMult.correta.value.trim()
        };

        if (!validarId(dados.id, "ID múltiplo")) {
            return;
        }

        if (!validarTextoBasico(dados.pergunta, "Pergunta", 5)) {
            return;
        }

        if (!validarTextoBasico(dados.a, "Resposta A", 1)) {
            return;
        }

        if (!validarTextoBasico(dados.b, "Resposta B", 1)) {
            return;
        }

        if (!validarTextoBasico(dados.c, "Resposta C", 1)) {
            return;
        }

        if (!validarTextoBasico(dados.d, "Resposta D", 1)) {
            return;
        }

        if (!validarTextoBasico(dados.correta, "Resposta correta", 1)) {
            return;
        }

        const opcoes = [
            dados.a,
            dados.b,
            dados.c,
            dados.d
        ];

        if (existemRespostasRepetidas(opcoes)) {
            alert("As alternativas A, B, C e D não podem ser iguais.");
            return;
        }

        if (!opcoes.includes(dados.correta)) {
            alert("A resposta correta deve ser exatamente igual a uma das alternativas A, B, C ou D.");
            return;
        }

        try {
            const res = await fetch("api/salvarPergMult.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(dados)
            });

            const resposta = await res.text();
            alert(resposta);

            if (resposta.includes("sucesso")) {
                formMult.reset();
            }

        } catch (erro) {
            alert("Erro ao salvar pergunta múltipla.");
            console.error(erro);
        }
    });
}