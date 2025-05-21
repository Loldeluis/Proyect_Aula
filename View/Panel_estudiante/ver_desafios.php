<?php
if (!isset($desafios)) {
    echo "No has accedido correctamente al controlador.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Desafíos</title>
    <link rel="stylesheet" href="../../View/CSS/aprendizaje.css">
    <style>
        .desafio-box {
            border-left: 8px solid #6f42c1;
            padding: 15px;
            margin-bottom: 15px;
            background:rgb(189, 13, 13);
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .btn-entrega {
            background: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-entrega:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <header>
        <h2>Desafíos Asignados</h2>
    </header>

    <div class="container">
        <?php if (empty($desafios)): ?>
            <p>No tienes desafíos asignados por el momento.</p>
        <?php else: ?>
            <?php foreach ($desafios as $desafio): ?>
                <div class="language-box" style="border-left: 8px solid #6f42c1;">
                    <h3><?= htmlspecialchars($desafio['titulo']) ?></h3>
                    <p><strong>Curso:</strong> <?= htmlspecialchars($desafio['nombre_curso']) ?></p>
                    <p><?= nl2br(htmlspecialchars($desafio['descripcion'])) ?></p>
                    <p><strong>Fecha límite:</strong> <?= htmlspecialchars($desafio['fecha_limite']) ?></p>

                    <?php if ($desafio['entregado']): ?>
                        <p style="color: green;"><strong>Estado:</strong> Entregado</p>
                        <button class="btn" disabled>Ya entregado</button>
                    <?php else: ?>
                        <form action="../../View/Panel_estudiante/entregar_desafio.php" method="POST">
                            <input type="hidden" name="id_desafio" value="<?= $desafio['id_desafio'] ?>">
                            <button type="submit" class="btn">Entregar Desafío</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <button class="btn-back" onclick="window.location.href='../../View/Panel_estudiante/aprendizaje.php'">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>
</body>
</html>
