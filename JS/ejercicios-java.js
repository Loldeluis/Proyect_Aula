document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-ejercicios");
  const modal = document.getElementById("modal");
  const descripcion = document.getElementById("descripcion-ejercicio");
  const cerrarModal = document.getElementById("cerrarModal");
  const inputNumeroEjercicio = document.getElementById("numero-ejercicio");
  const formSubida = document.getElementById("form-subida");
  const resultado = document.getElementById("resultado-evaluacion");

  // Verificar que el archivo JavaScript está cargando correctamente
  console.log("✅ Archivo ejercicios-java.js cargado correctamente");

  if (
    !contenedor ||
    !modal ||
    !descripcion ||
    !cerrarModal ||
    !inputNumeroEjercicio ||
    !formSubida ||
    !resultado
  ) {
    console.error("❌ Error: Elementos del DOM no encontrados.");
    return;
  }

  // Detectar en qué página estamos
  const paginaActual = window.location.pathname;
  console.log("Página detectada:", paginaActual); // Para verificar qué página está siendo reconocida

  let inicio, fin;
  if (paginaActual.includes("java-curso1.html")) {
    inicio = 1;
    fin = 10;
  } else if (paginaActual.includes("java-curso2.html")) {
    inicio = 11;
    fin = 20;
  } else if (paginaActual.includes("java-curso3.html")) {
    inicio = 21;
    fin = 30;
  } else {
    console.warn("⚠️ Página no reconocida. No se generarán botones.");
    return;
  }

  console.log(`Generando botones desde ${inicio} hasta ${fin}`);

  // Generar botones dinámicamente
  for (let i = inicio; i <= fin; i++) {
    const btn = document.createElement("button");
    btn.textContent = `Nivel ${i}`;
    btn.addEventListener("click", () => cargarEjercicio(i));
    contenedor.appendChild(btn);
  }

  // Función para cargar JSON y abrir el modal
  function cargarEjercicio(numero) {
    const ruta = `http://localhost/Proyect_Aula-main/controler/Ejercicio_cargados/java-json/ejercicio_${numero}.json`;

    fetch(ruta)
      .then((res) => {
        if (!res.ok)
          throw new Error(`Archivo ejercicio_${numero}.json no encontrado`);
        return res.json();
      })
      .then((data) => {
        descripcion.textContent =
          data.descripcion || "Descripción no disponible.";
        modal.classList.add("mostrar");
        inputNumeroEjercicio.value = numero;
      })
      .catch((error) => {
        console.error("❌ Error al cargar JSON:", error);
        descripcion.textContent = "No se pudo cargar el ejercicio.";
        modal.classList.add("mostrar");
      });
  }

  // Cierra el modal
  cerrarModal.addEventListener("click", () => {
    modal.classList.remove("mostrar");
    resultado.innerHTML = "";
    formSubida.reset();
  });
});
