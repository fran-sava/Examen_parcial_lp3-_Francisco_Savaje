// Examen LP3 - Formulario de Contacto
// Cumple ambos flujos sin tocar el HTML:
// 1) Valida y muestra "Bienvenido (Nombre y Apellido)"
// 2) Guarda en BD en segundo plano (fetch a procesar.php?action=agregar)

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formContacto");
  if (!form) return;

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const nombre = document.getElementById("nombre").value.trim();
    const mensaje = document.getElementById("mensaje").value.trim();
    const telefono = document.getElementById("telefono").value.trim();

    // Validaciones del examen
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    const soloNumeros = /^[0-9]+$/;

    if (!soloLetras.test(nombre)) {
      alert("El nombre solo debe contener letras y espacios.");
      return;
    }
    if (!soloNumeros.test(telefono)) {
      alert("El número de contacto solo debe contener números.");
      return;
    }
    if (mensaje === "") {
      alert("El mensaje no puede estar vacío.");
      return;
    }

    // 1) Guardar en BD en segundo plano
    try {
      const formData = new FormData();
      formData.append("nombre", nombre);
      formData.append("mensaje", mensaje);
      formData.append("telefono", telefono);

      await fetch("procesar.php?action=agregar", {
        method: "POST",
        body: formData,
      });
      // Ignoramos la respuesta: el backend igual inserta y listo.
    } catch (err) {
      // Si falla la BD, igual seguimos mostrando la bienvenida (la consigna lo exige)
      console.warn("No se pudo guardar en BD:", err);
    }

    // 2) Redirigir a la pantalla de bienvenida
    window.location.href = `bienvenida.html?nombre=${encodeURIComponent(nombre)}`;
  });

  // Año en el footer (si existe)
  const y = document.getElementById("year");
  if (y) y.textContent = new Date().getFullYear();
});
