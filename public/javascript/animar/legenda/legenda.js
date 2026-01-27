function abrirLegenda() {
  const overlay = document.getElementById("overlay");
  const legenda = document.getElementById("legenda");

  overlay.style.display = "block";
  legenda.style.display = "block";

  setTimeout(() => {
    overlay.classList.add("ativo");
    legenda.classList.add("ativo");
  }, 100);
}

function fecharLegenda() {
  const overlay = document.getElementById("overlay");
  const legenda = document.getElementById("legenda");

  overlay.classList.remove("ativo");
  legenda.classList.remove("ativo");

  setTimeout(() => {
    overlay.style.display = "none";
    legenda.style.display = "none";
  }, 100); 
}
