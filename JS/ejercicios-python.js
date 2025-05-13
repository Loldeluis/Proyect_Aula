document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor-ejercicios");
  const modal = document.getElementById("modal");
  const descripcion = document.getElementById("descripcion-ejercicio");
  const cerrarModal = document.getElementById("cerrarModal");
  const inputNumeroEjercicio = document.getElementById("numero-ejercicio");
  const formSubida = document.getElementById("form-subida");

  const resultado = document.createElement("div");
  resultado.id = "resultado-evaluacion";
  resultado.style.marginTop = "10px";
  formSubida.appendChild(resultado);

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
    resultado.innerHTML = ""; // Limpiar mensaje anterior
    formSubida.reset(); // Limpiar formulario
  });

  // Carga el archivo JSON del ejercicio
  function cargarEjercicio(numero) {
    const ruta = `http://localhost/Proyect_Aula-main/controler/python-json/ejercicio_${numero}.json`;

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
        inputNumeroEjercicio.value = numero;
      })
      .catch((error) => {
        console.error("Error al cargar JSON:", error);
        descripcion.textContent = "No se pudo cargar el ejercicio.";
        modal.classList.remove("oculto");
      });
  }

  // Enviar el formulario por AJAX
  formSubida.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(formSubida);
    resultado.innerHTML = "Evaluando...";

    fetch(formSubida.action, {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((data) => {
        resultado.innerHTML = data;
      })
      .catch((error) => {
        resultado.innerHTML =
          "❌ Error al subir el archivo. Intenta nuevamente.";
        console.error("Error al subir archivo:", error);
      });
  });
});
