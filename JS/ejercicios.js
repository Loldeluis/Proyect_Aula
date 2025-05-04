document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-ejercicios");
  const modal = document.getElementById("modal");
  const descripcion = document.getElementById("descripcion-ejercicio");
  const cerrarModal = document.getElementById("cerrarModal");

  // Generar 100 botones
  for (let i = 1; i <= 100; i++) {
    const btn = document.createElement("button");
    btn.textContent = `Ejercicio ${i}`;
    btn.addEventListener("click", () => cargarEjercicio(i));
    contenedor.appendChild(btn);
  }

  // Cierra el modal
  cerrarModal.addEventListener("click", () => {
    modal.classList.add("oculto");
  });

  // Carga el archivo JSON del ejercicio
  function cargarEjercicio(numero) {
    const ruta = `http://localhost/Proyect_Aula-main/controler/java-json/ejercicio_${numero}.json`;

    fetch(ruta)
      .then((res) => {
        if (!res.ok) {
          throw new Error(`Archivo ejercicio_${numero}.json no encontrado`);
        }
        return res.json();
      })
      .then((data) => {
        descripcion.textContent =
          data.descripcion || "Descripción no disponible.";
        modal.classList.remove("oculto");
      })
      .catch((error) => {
        console.error("Error al cargar JSON:", error);
        descripcion.textContent = "No se pudo cargar el ejercicio.";
        modal.classList.remove("oculto");
      });
  }
});
