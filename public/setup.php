<?php $title = 'Configuración de la base de datos'; ?>
<?php require __DIR__ . '/../includes/views/layouts/header.php'; ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-database"></i> Estado de la base de datos</h2>
        </div>
        
        <div class="card-body">
            <?php if (!$dbExists): ?>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> La base de datos no existe.
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="create_db">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Crear base de datos
                    </button>
                </form>
            <?php elseif (!$hasData): ?>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> La base de datos existe pero está vacía.
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="import_data">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-download"></i> Importar datos
                    </button>
                </form>
            <?php else: ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i> La base de datos está inicializada y contiene datos.
                </div>
                <a href="/ships" class="btn btn-success">
                    <i class="fas fa-rocket"></i> Ir a la aplicación
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/views/layouts/footer.php'; ?>