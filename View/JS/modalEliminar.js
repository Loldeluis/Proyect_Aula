// Función para abrir el modal
function abrirModalEliminar() {
    const modal = document.getElementById('modalEliminarCuenta');
    if (modal) modal.style.display = 'flex';
}

// Función para cerrar el modal
function cerrarModalEliminar() {
    const modal = document.getElementById('modalEliminarCuenta');
    if (modal) modal.style.display = 'none';
}

// Cerrar el modal haciendo clic fuera 
window.addEventListener('click', function(event) {
    const modal = document.getElementById('modalEliminarCuenta');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});