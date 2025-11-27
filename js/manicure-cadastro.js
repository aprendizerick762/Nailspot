document.addEventListener("DOMContentLoaded", function () {

  console.log("JS RODANDO (versão segura)");

  const form = document.querySelector(".formulario");
  if (!form) {
    console.error("Form (.formulario) não encontrado!");
    return;
  }

  const senha = document.getElementById("senha");
  const confirmar = document.getElementById("confirm_senha");
  const btnSubmit = form.querySelector('button[type="submit"]');

  form.addEventListener("submit", function (evento) {
    // Validações: se falhar, evita submit; se passar, deixa o submit prosseguir normalmente.

    const valor = senha ? senha.value.trim() : "";
    const confirmar_valor = confirmar ? confirmar.value.trim() : "";

    const senhaForte = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@!#$%_\-]).{8,}$/;

    if (!senhaForte.test(valor)) {
      evento.preventDefault();
      alert("A senha não atende aos requisitos.");
      return;
    }

    if (valor !== confirmar_valor) {
      evento.preventDefault();
      alert("As senhas não coincidem!");
      return;
    }

    // Tudo OK -> desabilita botão para evitar duplo clique e permite o envio padrão do formulário.
    if (btnSubmit) {
      btnSubmit.disabled = true;
      // opcional: mudar texto do botão pra feedback
      btnSubmit.dataset.origText = btnSubmit.textContent;
      btnSubmit.textContent = "Enviando...";
    }

    // Não chamamos form.submit() aqui — deixamos o envio padrão acontecer.
    // Assim o PHP roda, faz redirect e o javascript da nova página (toast) não será bloqueado.
  });

});