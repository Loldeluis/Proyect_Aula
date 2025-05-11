<div class="dashboard">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h2>
    <p>Panel de control administrativo</p>
    
    <div class="stats">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <h3>Estudiantes</h3>
            <p id="count-estudiantes">Cargando...</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-chalkboard-teacher"></i>
            <h3>Docentes</h3>
            <p id="count-docentes">Cargando...</p>
        </div>
    </div>
</div>

<script>
// Cargar estadísticas al abrir la página
$(document).ready(function() {
    $.get('acciones/obtener_estadisticas.php', function(data) {
        $('#count-estudiantes').text(data.estudiantes);
        $('#count-docentes').text(data.docentes);
    }, 'json');
});
</script>