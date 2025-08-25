// Dados armazenados localmente
const computers = JSON.parse(localStorage.getItem("computers")) || []
const printers = JSON.parse(localStorage.getItem("printers")) || []

// Navegação do menu
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

      // Update preventiva page if selected
      if (targetPage === "preventiva") {
        updatePreventivePage()
      }
    })
  })

  // Form submissions
  document.getElementById("computerForm").addEventListener("submit", handleComputerSubmit)
  document.getElementById("printerForm").addEventListener("submit", handlePrinterSubmit)

  // Load initial data
  updatePreventivePage()
})

// Handle computer form submission
function handleComputerSubmit(e) {
  e.preventDefault()

  const formData = new FormData(e.target)
  const computer = {
    id: Date.now(),
    nome: formData.get("nome"),
    modelo: formData.get("modelo"),
    processador: formData.get("processador"),
    memoria: formData.get("memoria"),
    armazenamento: formData.get("armazenamento"),
    so: formData.get("so"),
    serie: formData.get("serie"),
    localizacao: formData.get("localizacao"),
    status: formData.get("status"),
    dataCadastro: new Date().toLocaleDateString("pt-BR"),
  }

  computers.push(computer)
  localStorage.setItem("computers", JSON.stringify(computers))

  showToast("Computador cadastrado com sucesso!")
  clearForm("computerForm")
  updatePreventivePage()
}

// Handle printer form submission
function handlePrinterSubmit(e) {
  e.preventDefault()

  const formData = new FormData(e.target)
  const printer = {
    id: Date.now(),
    nome: formData.get("nome"),
    marca: formData.get("marca"),
    modelo: formData.get("modelo"),
    tipo: formData.get("tipo"),
    ip: formData.get("ip"),
    serie: formData.get("serie"),
    localizacao: formData.get("localizacao"),
    status: formData.get("status"),
    dataCadastro: new Date().toLocaleDateString("pt-BR"),
  }

  printers.push(printer)
  localStorage.setItem("printers", JSON.stringify(printers))

  showToast("Impressora cadastrada com sucesso!")
  clearForm("printerForm")
  updatePreventivePage()
}

// Clear form
function clearForm(formId) {
  document.getElementById(formId).reset()
}

// Show toast notification
function showToast(message) {
  const toast = document.getElementById("toast")
  toast.textContent = message
  toast.classList.add("show")

  setTimeout(() => {
    toast.classList.remove("show")
  }, 3000)
}

// Tab functionality
function showTab(tabId) {
  const tabButtons = document.querySelectorAll(".tab-button")
  const tabContents = document.querySelectorAll(".tab-content")

  tabButtons.forEach((btn) => btn.classList.remove("active"))
  tabContents.forEach((content) => content.classList.remove("active"))

  event.target.classList.add("active")
  document.getElementById(tabId).classList.add("active")
}

// Update preventiva page
function updatePreventivePage() {
  updateComputersGrid()
  updatePrintersGrid()
}

// Update computers grid
function updateComputersGrid() {
  const grid = document.getElementById("computersGrid")

  if (computers.length === 0) {
    grid.innerHTML = '<p class="empty-state">Nenhum computador cadastrado ainda.</p>'
    return
  }

  grid.innerHTML = computers
    .map(
      (computer) => `
        <div class="equipment-card">
            <h3><i class="fas fa-desktop"></i> ${computer.nome}</h3>
            <div class="equipment-info">
                <div class="info-row">
                    <span class="info-label">Modelo:</span>
                    <span class="info-value">${computer.modelo}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Processador:</span>
                    <span class="info-value">${computer.processador}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Memória:</span>
                    <span class="info-value">${computer.memoria}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Armazenamento:</span>
                    <span class="info-value">${computer.armazenamento}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sistema:</span>
                    <span class="info-value">${computer.so}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Série:</span>
                    <span class="info-value">${computer.serie}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Localização:</span>
                    <span class="info-value">${computer.localizacao}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="status-badge status-${computer.status.toLowerCase()}">${computer.status}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Cadastrado:</span>
                    <span class="info-value">${computer.dataCadastro}</span>
                </div>
            </div>
        </div>
    `,
    )
    .join("")
}

// Update printers grid
function updatePrintersGrid() {
  const grid = document.getElementById("printersGrid")

  if (printers.length === 0) {
    grid.innerHTML = '<p class="empty-state">Nenhuma impressora cadastrada ainda.</p>'
    return
  }

  grid.innerHTML = printers
    .map(
      (printer) => `
        <div class="equipment-card">
            <h3><i class="fas fa-print"></i> ${printer.nome}</h3>
            <div class="equipment-info">
                <div class="info-row">
                    <span class="info-label">Marca:</span>
                    <span class="info-value">${printer.marca}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Modelo:</span>
                    <span class="info-value">${printer.modelo}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tipo:</span>
                    <span class="info-value">${printer.tipo}</span>
                </div>
                ${
                  printer.ip
                    ? `
                <div class="info-row">
                    <span class="info-label">IP:</span>
                    <span class="info-value">${printer.ip}</span>
                </div>
                `
                    : ""
                }
                <div class="info-row">
                    <span class="info-label">Série:</span>
                    <span class="info-value">${printer.serie}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Localização:</span>
                    <span class="info-value">${printer.localizacao}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="status-badge status-${printer.status.toLowerCase()}">${printer.status}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Cadastrado:</span>
                    <span class="info-value">${printer.dataCadastro}</span>
                </div>
            </div>
        </div>
    `,
    )
    .join("")
}
