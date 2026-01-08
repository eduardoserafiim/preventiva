function abrirLegenda() {
  document.getElementById("overlay").classList.add("ativo");
  document.getElementById("legenda").classList.add("ativo");
}

function fecharLegenda() {
  document.getElementById("overlay").classList.remove("ativo");
  document.getElementById("legenda").classList.remove("ativo");
}