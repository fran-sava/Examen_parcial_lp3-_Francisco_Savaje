// Examen LP3 - JS de la página de Inicio

// Mensaje al cargar
console.log("Examen Parcial LP3 cargado correctamente.");

// Alert (si existe el botón en esta página)
const alertBtn = document.getElementById("alertBtn");
if (alertBtn) {
  alertBtn.addEventListener("click", function () {
    alert("Atención: ¿deseas continuar?");
  });
}

// Console.log (si existe el botón)
const logBtn = document.getElementById("logBtn");
if (logBtn) {
  logBtn.addEventListener("click", function () {
    console.log("Botón de consola presionado correctamente");
  });
}

// Año en el footer
const y = document.getElementById("year");
if (y) y.textContent = new Date().getFullYear();
