// ======================================
// Examen Parcial LP3 - Francisco Savaje
// Archivo JS para las funciones básicas
// ======================================

// Mensaje en consola al cargar la página
console.log("Examen Parcial LP3 cargado correctamente.");

// Botón que muestra un alert al hacer clic
document.getElementById("alertBtn").addEventListener("click", function() {
    alert("Atencion deseas continuar?");
});

// Botón que escribe algo en la consola
document.getElementById("logBtn").addEventListener("click", function() {
    console.log("Botón de consola presionado correctamente");
});

// Mostrar el año actual en el footer
let anioActual = new Date().getFullYear();
document.getElementById("year").textContent = anioActual;
