<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Nave</title>
    <style>
        .form-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-group { margin: 10px 0; }
        .form-section { border: 1px solid #ddd; padding: 15px; margin: 15px 0; }
        label { display: inline-block; width: 200px; }
        input, select { width: 300px; padding: 5px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Nave: <?= htmlspecialchars($ship['name']) ?></h2>
        
        <form action="/ships/update/<?= $ship['id'] ?>" method="POST">
            <div class="form-section">
                <h3>Información Básica</h3>
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($ship['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Modelo:</label>
                    <input type="text" name="model" value="<?= htmlspecialchars($ship['model']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Fabricante ID:</label>
                    <input type="number" name="manufacturer_id" value="<?= $ship['manufacturer_id'] ?>">
                </div>
                <div class="form-group">
                    <label>Clase ID:</label>
                    <input type="number" name="starship_class_id" value="<?= $ship['starship_class_id'] ?>">
                </div>
            </div>

            <div class="form-section">
                <h3>Especificaciones Técnicas</h3>
                <div class="form-group">
                    <label>Coste (créditos):</label>
                    <input type="number" name="cost_in_credits" value="<?= $ship['cost_in_credits'] ?>">
                </div>
                <div class="form-group">
                    <label>Longitud (metros):</label>
                    <input type="number" step="0.01" name="length" value="<?= $ship['length'] ?>">
                </div>
                <div class="form-group">
                    <label>Velocidad Máxima:</label>
                    <input type="number" name="max_speed" value="<?= $ship['max_speed'] ?>">
                </div>
                <div class="form-group">
                    <label>Tripulación:</label>
                    <input type="text" name="crew" value="<?= htmlspecialchars($ship['crew']) ?>">
                </div>
                <div class="form-group">
                    <label>Pasajeros:</label>
                    <input type="number" name="passengers" value="<?= $ship['passengers'] ?>">
                </div>
                <div class="form-group">
                    <label>Capacidad de Carga:</label>
                    <input type="number" name="cargo_capacity" value="<?= $ship['cargo_capacity'] ?>">
                </div>
                <div class="form-group">
                    <label>Consumibles:</label>
                    <input type="text" name="consumables" value="<?= htmlspecialchars($ship['consumables']) ?>">
                </div>
                <div class="form-group">
                    <label>Rating Hiperimpulsor:</label>
                    <input type="number" step="0.1" name="hyperdrive_rating" value="<?= $ship['hyperdrive_rating'] ?>">
                </div>
                <div class="form-group">
                    <label>MGLT:</label>
                    <input type="number" name="mglt" value="<?= $ship['mglt'] ?>">
                </div>
            </div>

            <div class="form-section">
                <h3>Metadatos</h3>
                <div class="form-group">
                    <label>URL API:</label>
                    <input type="url" name="api_url" value="<?= htmlspecialchars($ship['api_url']) ?>">
                </div>
            </div>

            <div class="form-group">
                <button type="submit">Guardar Cambios</button>
                <a href="/ships">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>