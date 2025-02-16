<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nave</title>
    <style>
        .form-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-group { margin: 15px 0; }
        .form-section { border: 1px solid #ddd; padding: 15px; margin: 15px 0; }
        label { display: inline-block; width: 200px; }
        input, select { width: 300px; padding: 5px; }
        .new-entry { margin-top: 5px; display: none; }
        button { padding: 10px 20px; margin: 5px; }
    </style>
</head>
<body>
<script>
        document.getElementById('manufacturer_select').addEventListener('change', function() {
            document.getElementById('new_manufacturer').style.display = 
                this.value === 'new' ? 'block' : 'none';
        });

        document.getElementById('class_select').addEventListener('change', function() {
            document.getElementById('new_class').style.display = 
                this.value === 'new' ? 'block' : 'none';
        });
</script>
    <div class="form-container">
        <h2>Añadir Nueva Nave</h2>
        
        <form action="/ships/add" method="POST">
            <div class="form-section">
                <h3>Información Básica</h3>
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Modelo:</label>
                    <input type="text" name="model" required>
                </div>
                <div class="form-group">
                    <label>Fabricante:</label>
                    <select name="manufacturer_id" id="manufacturer_select">
                        <option value="">Seleccionar fabricante</option>
                        <?php foreach ($manufacturers as $manufacturer): ?>
                            <option value="<?= $manufacturer['id'] ?>"><?= htmlspecialchars($manufacturer['name']) ?></option>
                        <?php endforeach; ?>
                        <option value="new">+ Añadir nuevo fabricante</option>
                    </select>
                    <div id="new_manufacturer" class="new-entry">
                        <input type="text" name="new_manufacturer" placeholder="Nombre del nuevo fabricante">
                    </div>
                </div>
                <div class="form-group">
                    <label>Clase:</label>
                    <select name="starship_class_id" id="class_select">
                        <option value="">Seleccionar clase</option>
                        <?php foreach ($starship_classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                        <?php endforeach; ?>
                        <option value="new">+ Añadir nueva clase</option>
                    </select>
                    <div id="new_class" class="new-entry">
                        <input type="text" name="new_class" placeholder="Nombre de la nueva clase">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Especificaciones Técnicas</h3>
                <div class="form-group">
                    <label>Coste (créditos):</label>
                    <input type="number" name="cost_in_credits">
                </div>
                <div class="form-group">
                    <label>Longitud (metros):</label>
                    <input type="number" step="0.01" name="length">
                </div>
                <div class="form-group">
                    <label>Velocidad Máxima:</label>
                    <input type="number" name="max_speed">
                </div>
                <div class="form-group">
                    <label>Tripulación:</label>
                    <input type="text" name="crew">
                </div>
                <div class="form-group">
                    <label>Pasajeros:</label>
                    <input type="number" name="passengers">
                </div>
                <div class="form-group">
                    <label>Capacidad de Carga:</label>
                    <input type="number" name="cargo_capacity">
                </div>
                <div class="form-group">
                    <label>Consumibles:</label>
                    <input type="text" name="consumables">
                </div>
                <div class="form-group">
                    <label>Rating Hiperimpulsor:</label>
                    <input type="number" step="0.1" name="hyperdrive_rating">
                </div>
                <div class="form-group">
                    <label>MGLT:</label>
                    <input type="number" name="mglt">
                </div>
            </div>

            <div class="form-group">
                <button type="submit">Guardar Nave</button>
                <a href="/ships">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('manufacturer_select').addEventListener('change', function() {
            document.getElementById('new_manufacturer').style.display = 
                this.value === 'new' ? 'block' : 'none';
        });

        document.getElementById('class_select').addEventListener('change', function() {
            document.getElementById('new_class').style.display = 
                this.value === 'new' ? 'block' : 'none';
        });
    </script>
</body>
</html>