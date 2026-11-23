// Contador de caracteres e validação simples do formulário.
const mensagem = document.getElementById("mensagem");
const contador = document.getElementById("contador");
const formulario = document.getElementById("form-inscricao");
const erroOficinas = document.getElementById("erro-oficinas");

mensagem.addEventListener("input", function () {
  const restantes = 200 - mensagem.value.length;
  contador.textContent = `Restam ${restantes} caracteres`;
});

formulario.addEventListener("submit", function (event) {
  const oficinasMarcadas = document.querySelectorAll('input[name="oficinas[]"]:checked');

  if (oficinasMarcadas.length === 0) {
    event.preventDefault();
    erroOficinas.textContent = "Selecione pelo menos uma oficina.";
  } else {
    erroOficinas.textContent = "";
  }
});
