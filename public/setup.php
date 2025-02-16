<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de la Base de Datos</title>
    <style>
        .status { margin: 20px 0; padding: 10px; border-radius: 4px; }
        .warning { background: #fff3cd; border: 1px solid #ffeeba; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; }
        button { margin: 10px 0; padding: 8px 16px; }
    </style>
</head>
<body>
    <h2>Estado de la base de datos</h2>
    
    <?php if (!$dbExists): ?>
        <div class="status warning">
            La base de datos no existe.
        </div>
        <form method="POST">
            <input type="hidden" name="action" value="create_db">
            <button type="submit">Crear base de datos</button>
        </form>
    <?php elseif (!$hasData): ?>
        <div class="status warning">
            La base de datos existe pero está vacía.
        </div>
        <form method="POST">
            <input type="hidden" name="action" value="import_data">
            <button type="submit">Importar datos</button>
        </form>
    <?php else: ?>
        <div class="status success">
            La base de datos está inicializada y contiene datos.
        </div>
        <a href="/ships">Ir a la aplicación</a>
    <?php endif; ?>
</body>
</html>