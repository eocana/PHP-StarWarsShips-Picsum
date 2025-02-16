<?php $title = 'Detalles de la nave'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Detalles de <?= htmlspecialchars($ship['name']) ?></h2>
        </div>
        
        <div class="card-body">
            <div class="detail-group mb-4">
                <h3 class="text-primary"><i class="fas fa-info-circle"></i> Información general</h3>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> <?= htmlspecialchars($ship['name']) ?></p>
                        <p><strong>Modelo:</strong> <?= htmlspecialchars($ship['model']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Fabricante:</strong> <?= htmlspecialchars($ship['manufacturer_name']) ?></p>
                        <p><strong>Clase:</strong> <?= htmlspecialchars($ship['starship_class']) ?></p>
                    </div>
                </div>
            </div>

            <div class="detail-group mb-4">
                <h3 class="text-primary"><i class="fas fa-cogs"></i> Especificaciones técnicas</h3>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Coste (créditos):</strong> <?= $ship['cost_in_credits'] ? number_format($ship['cost_in_credits']) : 'unknown' ?></p>
                        <p><strong>Longitud:</strong> <?= $ship['length'] ?> metros</p>
                        <p><strong>Velocidad máxima:</strong> <?= $ship['max_speed'] ? number_format($ship['max_speed']) : 'n/a' ?></p>
                        <p><strong>Tripulación:</strong> <?= htmlspecialchars($ship['crew']) ?></p>
                        <p><strong>Pasajeros:</strong> <?= $ship['passengers'] ? number_format($ship['passengers']) : 'n/a' ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Capacidad de carga:</strong> <?= number_format($ship['cargo_capacity']) ?></p>
                        <p><strong>Consumibles:</strong> <?= htmlspecialchars($ship['consumables']) ?></p>
                        <p><strong>Rating Hiperimpulsor:</strong> <?= $ship['hyperdrive_rating'] ?></p>
                        <p><strong>MGLT:</strong> <?= $ship['mglt'] ?></p>
                    </div>
                </div>
            </div>

            <div class="detail-group mb-4">
                <h3 class="text-primary"><i class="fas fa-database"></i> Metadatos</h3>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Creado:</strong> <?= htmlspecialchars($ship['created_at']) ?></p>
                        <p><strong>Editado:</strong> <?= htmlspecialchars($ship['edited_at']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>URL API:</strong> <?= htmlspecialchars($ship['api_url']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="btn-group">
                <a href="/ships" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="/ships/edit/<?= $ship['id'] ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <form action="/ships/delete/<?= $ship['id'] ?>" method="POST" class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('¿Estás seguro de eliminar esta nave?')">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>