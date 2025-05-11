<div class="form-container">
  <h2>Registrar Nuevo Usuario</h2>
  <form id="formRegistro" method="POST">
    <div class="form-group">
      <label>Nombre:</label>
      <input type="text" name="nombre" required>
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-group">
      <label>Contraseña:</label>
      <input type="password" name="password" required>
    </div>
    <div class="form-group">
      <label>Rol:</label>
      <select name="rol" required>
        <option value="estudiante">Estudiante</option>
        <option value="docente">Docente</option>
        <option value="admin">Administrador</option>
      </select>
    </div>
    <button type="submit">Registrar</button>
  </form>
  <div id="resultado"></div>
</div>

<script>
$('#formRegistro').submit(function(e) {
  e.preventDefault();
  $.ajax({
    url: '../acciones/registrar_usuario.php',
    type: 'POST',
    data: $(this).serialize(),
    success: function(response) {
      $('#resultado').html(response);
      $('#formRegistro')[0].reset();
    }
  });
});
</script>