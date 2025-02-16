<?php $title = 'Página no encontrada'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container text-center py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h1 class="display-1 text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </h1>
                    <h2 class="mb-4">404 - Página no encontrada</h2>
                    <p class="text-muted mb-4">
                        La página que estás buscando parece haber sido movida, eliminada o no existe.
                    </p>
                    <a href="/ships" class="btn btn-primary">
                        <i class="fas fa-home"></i> Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>