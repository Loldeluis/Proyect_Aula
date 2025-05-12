<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <button class="back-button" onclick="window.history.back()">
        <i class="fas fa-arrow-left"></i>
        Volver
    </button>

    <div class="profile-container">
        <div class="profile-card">
            <h1>Perfil de Usuario</h1>
            
            <div class="avatar-upload">
                <img src="https://via.placeholder.com/120" alt="Avatar" class="profile-avatar" id="profile-avatar">
                <label for="avatar-input">
                    <i class="fas fa-camera"></i>
                    Cambiar foto
                </label>
                <input type="file" id="avatar-input" accept="image/*">
            </div>

            <form action="perfil.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ingresa tu nombre completo">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Ingresa tu correo electrónico">
                </div>

                <div class="form-group">
                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" required placeholder="Ingresa tu número de documento">
                </div>

                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select id="rol" name="rol" required>
                        <option value="" disabled selected>Selecciona tu rol</option>
                        <option value="admin">Administrador</option>
                        <option value="user">Usuario</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i>
                    Actualizar Perfil
                </button>
            </form>
        </div>
    </div>

    <script>
        // Función para previsualizar la imagen de avatar
        document.getElementById('avatar-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profile-avatar').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Simular datos de usuario (en un caso real estos vendrían de una base de datos)
        window.addEventListener('DOMContentLoaded', () => {
            // Esto es solo para demostración - en producción usarías datos reales
            document.getElementById('nombre').value = 'Juan Pérez';
            document.getElementById('email').value = 'juan.perez@ejemplo.com';
            document.getElementById('cedula').value = '1234567890';
            document.getElementById('rol').value = 'user';
        });
    </script>
</body>
</body>
</html>