<?php $title = 'Picsum Download'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-images"></i> Descargar datos de Picsum</h2>
        </div>
        <div class="card-body">
            <p>Seleccione el número de imágenes a descargar (máximo 100):</p>
            <form method="POST" action="/picsum/download">
                <div class="mb-3">
                    <label for="limit" class="form-label">Número de imágenes:</label>
                    <input type="number" class="form-control" id="limit" name="limit" 
                           min="1" max="100" value="75" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-download"></i> Descargar datos
                </button>
            </form>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-circle"></i> Error: <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>