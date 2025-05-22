document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-ejercicios");
  const modal = document.getElementById("modal");
  const descripcion = document.getElementById("descripcion-ejercicio");
  const cerrarModal = document.getElementById("cerrarModal");
  const inputNumeroEjercicio = document.getElementById("numero-ejercicio");
  const formSubida = document.getElementById("form-subida");
  const resultado = document.getElementById("resultado-evaluacion");

  console.log("✅ Archivo cargado correctamente");

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
  let inicio, fin;

  if (paginaActual.includes("python-curso1.php")) {
    inicio = 1;
    fin = 10;
  } else if (paginaActual.includes("python-curso2.php")) {
    inicio = 11;
    fin = 20;
  } else if (paginaActual.includes("python-curso3.php")) {
    inicio = 21;
    fin = 30;
  } else {
    console.warn("⚠️ Página no reconocida. No se generarán botones.");
    return;
  }

  // Generar botones dinámicamente
  for (let i = inicio; i <= fin; i++) {
    const btn = document.createElement("button");
    btn.textContent = `Nivel ${i}`;
    btn.addEventListener("click", () => cargarEjercicio(i));
    contenedor.appendChild(btn);
  }

  // Función para cargar JSON y abrir el modal
  function cargarEjercicio(numero) {
    const ruta = `http://localhost/ProyectoAula/Controller/Ejercicio_cargados/python-json/ejercicio_${numero}.json`;

    fetch(ruta)
      .then((res) => {
        if (!res.ok) throw new Error(`Archivo ejercicio_${numero}.json no encontrado`);
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

  // Cerrar modal
  cerrarModal.addEventListener("click", () => {
    modal.classList.remove("mostrar");
    resultado.innerHTML = "";
    formSubida.reset();
  });
});
