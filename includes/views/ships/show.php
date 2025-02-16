<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Nave</title>
    <style>
        .ship-details { max-width: 800px; margin: 0 auto; }
        .detail-group { margin: 20px 0; }
        .detail-label { font-weight: bold; }
        .actions { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="ship-details">
        <h2>Detalles de <?= htmlspecialchars($ship['name']) ?></h2>
        
        <div class="detail-group">
            <h3>Información General</h3>
            <p><span class="detail-label">Nombre:</span> <?= htmlspecialchars($ship['name']) ?></p>
            <p><span class="detail-label">Modelo:</span> <?= htmlspecialchars($ship['model']) ?></p>
            <p><span class="detail-label">Fabricante:</span> <?= htmlspecialchars($ship['manufacturer_name']) ?></p>
            <p><span class="detail-label">Clase:</span> <?= htmlspecialchars($ship['starship_class']) ?></p>
        </div>

        <div class="detail-group">
            <h3>Especificaciones Técnicas</h3>
            <p><span class="detail-label">Coste (créditos):</span> <?= number_format($ship['cost_in_credits']) ?></p>
            <p><span class="detail-label">Longitud:</span> <?= $ship['length'] ?> metros</p>
            <p><span class="detail-label">Velocidad Máxima:</span> <?= $ship['max_speed'] ?></p>
            <p><span class="detail-label">Tripulación:</span> <?= htmlspecialchars($ship['crew']) ?></p>
            <p><span class="detail-label">Pasajeros:</span> <?= number_format($ship['passengers']) ?></p>
            <p><span class="detail-label">Capacidad de Carga:</span> <?= number_format($ship['cargo_capacity']) ?></p>
            <p><span class="detail-label">Consumibles:</span> <?= htmlspecialchars($ship['consumables']) ?></p>
            <p><span class="detail-label">Rating Hiperimpulsor:</span> <?= $ship['hyperdrive_rating'] ?></p>
            <p><span class="detail-label">MGLT:</span> <?= $ship['mglt'] ?></p>
        </div>

        <div class="detail-group">
            <h3>Metadatos</h3>
            <p><span class="detail-label">Creado:</span> <?= htmlspecialchars($ship['created_at']) ?></p>
            <p><span class="detail-label">Editado:</span> <?= htmlspecialchars($ship['edited_at']) ?></p>
            <p><span class="detail-label">URL API:</span> <?= htmlspecialchars($ship['api_url']) ?></p>
        </div>

        <div class="actions">
            <a href="/ships">Volver</a> |
            <a href="/ships/edit/<?= $ship['id'] ?>">Editar</a>
        </div>
    </div>
</body>
</html>