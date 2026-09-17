const dropArea = document.getElementById("formulario-imagem-receber");
const fileInput = document.getElementById("input-imagem");
const preview = document.getElementById("preview");
const previewsContainer = document.getElementById("previews-imagens");

if (dropArea && fileInput && (preview || previewsContainer)) {
  if (preview && preview.src && preview.src !== window.location.href) {
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
    handleFiles(e.dataTransfer.files);
  });

  fileInput.addEventListener("change", () => {
    handleFiles(fileInput.files);
  });
}

function handleFiles(files) {
  if (previewsContainer) {
    previewsContainer.innerHTML = "";
    Array.from(files).forEach((file) => handleFile(file, previewsContainer));
    return;
  }

  handleFile(files[0], preview);
}

function handleFile(file, destino) {
  if (!destino) {
    return;
  }

  if (!file || !file.type.startsWith("image/")) {
    alert("Por favor, envie uma imagem");
    return;
  }

  const elemento = destino === previewsContainer ? document.createElement("img") : destino;
  if (destino === previewsContainer) {
    elemento.className = "preview-imagem";
    elemento.alt = "Nova imagem do computador";
    destino.appendChild(elemento);
  }

  const reader = new FileReader();
  reader.onload = () => {
    elemento.src = reader.result;
    elemento.style.display = "block";
  };
  reader.readAsDataURL(file);
}
