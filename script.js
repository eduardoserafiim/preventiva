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
  const form = e.target
  const editingId = form.dataset.editingId

  if (editingId) {
    // Atualiza computador existente
    const computerIndex = computers.findIndex((c) => c.id == editingId)
    if (computerIndex > -1) {
      computers[computerIndex] = {
        ...computers[computerIndex],
        semestre: formData.get("semestre"),
        ano: formData.get("ano"),
        unidade: formData.get("unidade"),
        setor: formData.get("setor"),
        nome: formData.get("nome"),
        modelo: formData.get("modelo"),
        monitor: formData.get("monitor"),
        so: formData.get("so"),
        office: formData.get("office"),
        processador: formData.get("processador"),
        memoria: formData.get("memoria"),
        disco: formData.get("disco"),
        ip: formData.get('ip'),
        lacre: formData.get('lacre'),
        status: formData.get("status"),
        dataCadastro: new Date().toLocaleDateString("pt-BR"),
      }

      localStorage.setItem("computers", JSON.stringify(computers))
      showToast("Computador atualizado com sucesso!")

      delete form.dataset.editingId
    }
  } else {
    // Cria novo computador
    const computer = {
      id: Date.now(),
      semestre: formData.get("semestre"),
      ano: formData.get("ano"),
      unidade: formData.get("unidade"),
      setor: formData.get("setor"),
      nome: formData.get("nome"),
      modelo: formData.get("modelo"),
      monitor: formData.get("monitor"),
      so: formData.get("so"),
      office: formData.get("office"),
      processador: formData.get("processador"),
      memoria: formData.get("memoria"),
      disco: formData.get("disco"),
      ip: formData.get('ip'),
      lacre: formData.get('lacre'),
      status: formData.get("status"),
      dataCadastro: new Date().toLocaleDateString("pt-BR"),
    }

    computers.push(computer)
    localStorage.setItem("computers", JSON.stringify(computers))
    showToast("Computador cadastrado com sucesso!")
  }

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

function editarComputador(id) {
  const computer = computers.find(c => c.id === id)
  if (!computer) return

  const card = document.getElementById(`computer-${id}`)
  const nomeSpan = card.querySelector(`#nome-${id}`)

  nomeSpan.outerHTML = `<input type="text" id="edit-nome-${id}" value="${computer.nome}" name="nome" required>`;
  card.querySelector(`#semestre-${id}`).innerHTML = `
  <div class="form-group">
    <select id="edit-semestre-${id}" name="semestre" required>
      <option value="" disabled>Selecione...</option>
      <option value="1° Semestre" ${computer.semestre === "1° Semestre" ? "selected" : ""}>1° Semestre</option>
      <option value="2° Semestre" ${computer.semestre === "2° Semestre" ? "selected" : ""}>2° Semestre</option>
    </select>
  </div>
  `;

  card.querySelector(`#ano-${id}`).innerHTML = `
    <div class="form-group">
      <select id="edit-ano-${id}" name="ano" required>
        <option value="" disabled>Selecione...</option>
        <option value="2022" ${computer.ano === "2022" ? "selected" : ""}>2022</option>
        <option value="2023" ${computer.ano === "2023" ? "selected" : ""}>2023</option>
        <option value="2024" ${computer.ano === "2024" ? "selected" : ""}>2024</option>
        <option value="2025" ${computer.ano === "2025" ? "selected" : ""}>2025</option>
      </select>
    </div>
  `;

  card.querySelector(`#unidade-${id}`).innerHTML = `
    <div class="form-group">
      <select id="edit-unidade-${id}" name="unidade" required>
        <option value="" disabled>Selecione...</option>
        <option value="HAP - UNIDADE MATRIZ" ${computer.unidade === "HAP - UNIDADE MATRIZ" ? "selected" : ""}>HAP - Matriz</option>
        <option value="HAP - UNIDADE CENTRO" ${computer.unidade === "HAP - UNIDADE CENTRO" ? "selected" : ""}>HAP - Centro</option>
      </select>
    </div>
  `;

  card.querySelector(`#setor-${id}`).innerHTML = `
    <div class="form-group">
      <select id="edit-setor-${id}" name="setor" required>
        <option value="" disabled>Selecione...</option>
        <option value="${computer.setor}" selected>${computer.setor}</option>
      </select>
    </div>
  `;

  card.querySelector(`#modelo-${id}`).innerHTML = `
    <div class="form-group">
      <input type="text" id="edit-modelo-${id}" value="${computer.modelo}" name="modelo" required>
    </div>
  `;

  card.querySelector(`#monitor-${id}`).innerHTML = `
    <div class="form-group">
      <input type="text" id="edit-monitor-${id}" value="${computer.monitor}" name="monitor" required>
    </div>
  `;

  card.querySelector(`#so-${id}`).innerHTML = `
    <div class="form-group">
      <select id="edit-so-${id}" name="so" required>
        <option value="Windows 10 Pro" ${computer.so === "Windows 10 Pro" ? "selected" : ""}>Windows 10 Pro</option>
        <option value="Windows 10 Home" ${computer.so === "Windows 10 Home" ? "selected" : ""}>Windows 10 Home</option>
        <option value="Windows 11 Pro" ${computer.so === "Windows 11 Pro" ? "selected" : ""}>Windows 11 Pro</option>
        <option value="Windows 11 Home" ${computer.so === "Windows 11 Home" ? "selected" : ""}>Windows 11 Home</option>
        <option value="Ubuntu" ${computer.so === "Ubuntu" ? "selected" : ""}>Ubuntu</option>
      </select>
    </div>
  `;

  card.querySelector(`#office-${id}`).innerHTML = `
    <div class="form-group">
      <select id="edit-office-${id}" name="office" required>
        <option value="Office" ${computer.office === "Office" ? "selected" : ""}>Office</option>
        <option value="Libre Office" ${computer.office === "Libre Office" ? "selected" : ""}>Libre Office</option>
        <option value="WPS" ${computer.office === "WPS" ? "selected" : ""}>WPS</option>
      </select>
    </div>
  `;

  card.querySelector(`#processador-${id}`).innerHTML = `
    <div class="form-group">
      <input type="text" id="edit-processador-${id}" value="${computer.processador}" name="processador" required>
    </div>
  `;

  card.querySelector(`#memoria-${id}`).innerHTML = `
    <div class="form-group">
      <select id="edit-memoria-${id}" name="memoria" required>
        <option value="4GB" ${computer.memoria === "4GB" ? "selected" : ""}>4GB</option>
        <option value="8GB" ${computer.memoria === "8GB" ? "selected" : ""}>8GB</option>
        <option value="16GB" ${computer.memoria === "16GB" ? "selected" : ""}>16GB</option>
        <option value="32GB" ${computer.memoria === "32GB" ? "selected" : ""}>32GB</option>
        <option value="64GB" ${computer.memoria === "64GB" ? "selected" : ""}>64GB</option>
      </select>
    </div>
  `;

  card.querySelector(`#disco-${id}`).innerHTML = `
    <div class="form-group">
      <select id="edit-disco-${id}" name="disco" required>
        <option value="HDD" ${computer.disco === "HDD" ? "selected" : ""}>HD</option>
        <option value="SSD" ${computer.disco === "SSD" ? "selected" : ""}>SSD</option>
        <option value="SSD NVME" ${computer.disco === "SSD NVME" ? "selected" : ""}>SSD NVME</option>
      </select>
    </div>
  `;

  card.querySelector(`#ip-${id}`).innerHTML = `
    <div class="form-group">
      <input type="text" id="edit-ip-${id}" value="${computer.ip}" name="ip" required>
    </div>
  `;

  card.querySelector(`#lacre-${id}`).innerHTML = `
    <div class="form-group">
      <input type="text" id="edit-lacre-${id}" value="${computer.lacre}" name="lacre">
    </div>
  `;

  card.querySelector(`#status-${id}`).innerHTML = `
    <div class="form-group">
      <select id="edit-status-${id}" name="status" required>
        <option value="Ativo" ${computer.status === "Ativo" ? "selected" : ""}>Ativo</option>
        <option value="Inativo" ${computer.status === "Inativo" ? "selected" : ""}>Inativo</option>
        <option value="Manutenção" ${computer.status === "Manutenção" ? "selected" : ""}>Manutenção</option>
      </select>
    </div>
  `;

  // Botões de ação
  const actions = card.querySelector(".form-actions")
  actions.innerHTML = `
    <button class="botao botao-primario" onclick="salvarEdicaoComputador(${id})">Salvar</button>
    <button class="botao botao-cancelar" onclick="updatePreventivePage()">Cancelar</button>
  `
}

function salvarEdicaoComputador(id) {
  const index = computers.findIndex(c => c.id === id)
  if (index === -1) return
  computers[index].nome = document.getElementById(`edit-nome-${id}`).value
  computers[index].semestre = document.getElementById(`edit-semestre-${id}`).value
  computers[index].ano = document.getElementById(`edit-ano-${id}`).value
  computers[index].unidade = document.getElementById(`edit-unidade-${id}`).value
  computers[index].setor = document.getElementById(`edit-setor-${id}`).value
  computers[index].modelo = document.getElementById(`edit-modelo-${id}`).value
  computers[index].monitor = document.getElementById(`edit-monitor-${id}`).value
  computers[index].so = document.getElementById(`edit-so-${id}`).value
  computers[index].office = document.getElementById(`edit-office-${id}`).value
  computers[index].processador = document.getElementById(`edit-processador-${id}`).value
  computers[index].memoria = document.getElementById(`edit-memoria-${id}`).value
  computers[index].disco = document.getElementById(`edit-disco-${id}`).value
  computers[index].ip = document.getElementById(`edit-ip-${id}`).value
  computers[index].lacre = document.getElementById(`edit-lacre-${id}`).value
  computers[index].status = document.getElementById(`edit-status-${id}`).value

  localStorage.setItem("computers", JSON.stringify(computers))
  showToast("Computador atualizado com sucesso!")
  updatePreventivePage()
}

function deletarComputador(id) {
  const index = computers.findIndex((c) => c.id === id)
  if (index > -1) {
    if (confirm("Tem certeza que deseja apagar este computador?")) {
      computers.splice(index, 1)
      localStorage.setItem("computers", JSON.stringify(computers))
      showToast("Computador apagado com sucesso!")
      updatePreventivePage()
    }
  }
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

  tabButtons.forEach((botao) => botao.classList.remove("active"))
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
        <div class="equipment-card" id="computer-${computer.id}">
            <h3>
              <i class="fas fa-desktop"></i>
              <span id="nome-${computer.id}">${computer.nome}</span>
            </h3>
            <div class="form-actions">
              <button type="button" class="botao botao-primario" onclick="editarComputador(${computer.id})">
                  <i class="fa-solid fa-pencil"></i> Editar
              </button>
              <button type="button" class="botao botao-cancelar" onclick="deletarComputador(${computer.id})">
                  <i class="fas fa-eraser"></i> Apagar
              </button>
            </div>
            <div class="equipment-info">
                <div class="info-row">
                    <span class="info-label">Semestre:</span>
                    <span class="info-value" id="semestre-${computer.id}">${computer.semestre}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ano:</span>
                    <span class="info-value" id="ano-${computer.id}">${computer.ano}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Unidade:</span>
                    <span class="info-value" id="unidade-${computer.id}">${computer.unidade}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Setor:</span>
                    <span class="info-value" id="setor-${computer.id}">${computer.setor}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Modelo:</span>
                    <span class="info-value" id="modelo-${computer.id}">${computer.modelo}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Monitor:</span>
                    <span class="info-value" id="monitor-${computer.id}">${computer.monitor}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sistema Operacional:</span>
                    <span class="info-value" id="so-${computer.id}">${computer.so}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Office:</span>
                    <span class="info-value" id="office-${computer.id}">${computer.office}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Processador:</span>
                    <span class="info-value" id="processador-${computer.id}">${computer.processador}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Memória:</span>
                    <span class="info-value" id="memoria-${computer.id}">${computer.memoria}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Disco:</span>
                    <span class="info-value" id="disco-${computer.id}">${computer.disco}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Endereço IP:</span>
                    <span class="info-value" id="ip-${computer.id}">${computer.ip}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Lacre:</span>
                    <span class="info-value" id="lacre-${computer.id}">${computer.lacre}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value" id="status-${computer.id}">${computer.status}</span>
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