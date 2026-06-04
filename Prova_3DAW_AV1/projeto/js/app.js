
const form = document.getElementById("form");

if (form) {
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dados = {
            id: form.IDunico.value,
            pergunta: form.PerguntaUnica.value,
            resposta: form.Resposta.value
        };

        const res = await fetch("http://localhost/projeto/api/salvarPerg.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(dados)
        });

        alert(await res.text());
    });
}


const formMult = document.getElementById("formMult");

if (formMult) {
    formMult.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dados = {
            id: formMult.IDmultiplo.value,
            pergunta: formMult.PerguntaMultipla.value,
            a: formMult.A.value,
            b: formMult.B.value,
            c: formMult.C.value,
            d: formMult.D.value,
            correta: formMult.correta.value
        };

        const opcoes = [dados.a, dados.b, dados.c, dados.d];

        if (!opcoes.includes(dados.correta)) {
            alert("A resposta correta precisa ser igual a A, B, C ou D");
            return;
        }

        const res = await fetch("http://localhost/projeto/api/salvarPergMult.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(dados)
        });

        alert(await res.text());
    });
}