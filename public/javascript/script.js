document.addEventListener("DOMContentLoaded", () => {
  const menuItems = document.querySelectorAll(".menu-item")
  const pages = document.querySelectorAll(".page")

  menuItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault()

      // Remove active class from all menu items and pages
      menuItems.forEach((mi) => mi.classList.remove("active"))
      pages.forEach((page) => page.classList.remove("active"))

      // Add active class to clicked item
      this.classList.add("active")

      // Show corresponding page
      const targetPage = this.getAttribute("data-page")
      document.getElementById(targetPage).classList.add("active")
    })
  })
})

function showToast(message) {
  const toast = document.getElementById("toast")
  toast.textContent = message
  toast.classList.add("show")
  
  setTimeout(() => {
    const formPC = document.getElementById("formularioComputadores");
    formPC.reset();
    toast.classList.remove("show");
  }, 3000)
}

document.getElementById("formularioComputadores").addEventListener("submit", function(e){
  e.preventDefault();

  const formData = new FormData(this);

  fetch("../controllers/computadoresCriar.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    console.log("Resposta do PHP:", data);
    try {
      const json = JSON.parse(data);
      showToast(json.message);
    } catch(e) {
      showToast("Erro no retorno do PHP!");
      console.error("JSON inválido:", e);
    }
  })
  .catch(error => {
    showToast("Erro ao cadastrar computador!");
    console.error(error);
  });
});