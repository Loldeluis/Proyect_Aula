document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-ejercicios");
  const modal = document.getElementById("modal");
  const descripcion = document.getElementById("descripcion-ejercicio");
  const cerrarModal = document.getElementById("cerrarModal");
  const inputNumeroEjercicio = document.getElementById("numero-ejercicio");
  const formSubida = document.getElementById("form-subida");
  const resultado = document.getElementById("resultado-evaluacion");

  // Verificar que todos los elementos del DOM existen
  if (!contenedor || !modal || !descripcion || !cerrarModal || !inputNumeroEjercicio || !formSubida || !resultado) {
    console.error("❌ Error: Elementos del DOM no encontrados.");
    return;
  }

  // Determinar la página actual y establecer el rango de ejercicios
  const paginaActual = window.location.pathname;
  let inicio, fin;

  if (paginaActual.includes("html-curso1.php")) {
    inicio = 1;
    fin = 10;
  } else if (paginaActual.includes("html-curso2.php")) {
    inicio = 11;
    fin = 20;
  } else if (paginaActual.includes("html-curso3.php")) {
    inicio = 21;
    fin = 30;
  } else {
    console.warn("⚠️ Página no reconocida. No se generarán botones.");
    return;
  }

  // Generar los botones dinámicamente según el rango
  for (let i = inicio; i <= fin; i++) {
    const btn = document.createElement("button");
    btn.textContent = `Nivel ${i}`;
    btn.addEventListener("click", () => cargarEjercicio(i));
    contenedor.appendChild(btn);
  }

  // Función para cargar el JSON del ejercicio y abrir el modal
  function cargarEjercicio(numero) {
    const ruta = `http://localhost/Proyecto_Aula/Proyecto_Aula/Controller/Ejercicio_cargados/html-json/ejercicio_${numero}.json`;
    fetch(ruta)
      .then((res) => {
        if (!res.ok)
          throw new Error(`Archivo ejercicio_${numero}.json no encontrado`);
        return res.json();
      })
      .then((data) => {
        descripcion.textContent = data.descripcion || "Descripción no disponible.";
        modal.classList.add("mostrar");
        inputNumeroEjercicio.value = numero;
      })
      .catch((error) => {
        console.error("❌ Error al cargar JSON:", error);
        descripcion.textContent = "No se pudo cargar el ejercicio.";
        modal.classList.add("mostrar");
      });
  }

  // Manejar el cierre del modal
  cerrarModal.addEventListener("click", () => {
    modal.classList.remove("mostrar");
    resultado.innerHTML = "";
    formSubida.reset();
  });
});
