function abrirModal() {
    document.getElementById("modalPassword").style.display = "flex";
  }

  function cerrarModal() {
    document.getElementById("modalPassword").style.display = "none";
  }

  window.onclick = function(event) {
    const modal = document.getElementById("modalPassword");
    if (event.target === modal) {
      cerrarModal();
    }
  };