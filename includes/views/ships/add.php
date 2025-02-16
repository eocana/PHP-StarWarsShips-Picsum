<?php $title = 'Añadir nueva nave'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-plus-circle"></i> Añadir nueva nave</h2>
        </div>
        
        <form action="/ships/add" method="POST">
            <div class="card-body">
                <div class="mb-4">
                    <h3 class="text-primary"><i class="fas fa-info-circle"></i> Información Básica</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Modelo:</label>
                            <input type="text" class="form-control" name="model" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fabricante:</label>
                            <select class="form-select" name="manufacturer_id" id="manufacturer_select">
                                <option value="">Seleccionar fabricante</option>
                                <?php foreach ($manufacturers as $manufacturer): ?>
                                    <option value="<?= $manufacturer['id'] ?>"><?= htmlspecialchars($manufacturer['name']) ?></option>
                                <?php endforeach; ?>
                                <option value="new">+ Añadir nuevo fabricante</option>
                            </select>
                            <div id="new_manufacturer" class="mt-2" style="display:none;">
                                <input type="text" class="form-control" name="new_manufacturer" placeholder="Nombre del nuevo fabricante">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Clase:</label>
                            <select class="form-select" name="starship_class_id" id="class_select">
                                <option value="">Seleccionar clase</option>
                                <?php foreach ($starship_classes as $class): ?>
                                    <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                                <?php endforeach; ?>
                                <option value="new">+ Añadir nueva clase</option>
                            </select>
                            <div id="new_class" class="mt-2" style="display:none;">
                                <input type="text" class="form-control" name="new_class" placeholder="Nombre de la nueva clase">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="text-primary"><i class="fas fa-cogs"></i> Especificaciones técnicas</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Coste (créditos):</label>
                            <input type="number" class="form-control" name="cost_in_credits">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitud (metros):</label>
                            <input type="number" step="0.01" class="form-control" name="length">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Velocidad máxima:</label>
                            <input type="number" class="form-control" name="max_speed">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tripulación:</label>
                            <input type="text" class="form-control" name="crew">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pasajeros:</label>
                            <input type="number" class="form-control" name="passengers">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Capacidad de carga:</label>
                            <input type="number" class="form-control" name="cargo_capacity">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Consumibles:</label>
                            <input type="text" class="form-control" name="consumables">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rating Hiperimpulsor:</label>
                            <input type="number" step="0.1" class="form-control" name="hyperdrive_rating">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">MGLT:</label>
                            <input type="number" class="form-control" name="mglt">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar nave
                </button>
                <a href="/ships" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
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

<?php require __DIR__ . '/../layouts/footer.php'; ?>