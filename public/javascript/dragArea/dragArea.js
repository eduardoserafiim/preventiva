const dropArea = document.getElementById("formulario-imagem-receber");
const fileInput = document.getElementById("input-imagem");
const preview = document.getElementById("preview");

if (preview.src && preview.src !== window.location.href) {
  preview.style.display = "block";
}

dropArea.addEventListener("click", () => fileInput.click());

dropArea.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropArea.classList.add("dragover");
});

dropArea.addEventListener("dragleave", () => {
  dropArea.classList.remove("dragover");
});

dropArea.addEventListener("drop", (e) => {
  e.preventDefault();
  dropArea.classList.remove("dragover");
  handleFile(e.dataTransfer.files[0]);
});

fileInput.addEventListener("change", () => {
  handleFile(fileInput.files[0]);
});

function handleFile(file) {
  if (!file || !file.type.startsWith("image/")) {
    alert("Por favor, envie uma imagem");
    return;
  }

  const reader = new FileReader();
  reader.onload = () => {
    preview.src = reader.result;
    preview.style.display = "block";
  };
  reader.readAsDataURL(file);
}