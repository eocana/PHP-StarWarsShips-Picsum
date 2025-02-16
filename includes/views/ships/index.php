<?php $title = 'Lista de naves'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de naves</h2>
    <a href="/ships/add" class="btn btn-success">
        <i class="fas fa-plus"></i> Añadir nave
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Modelo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ships as $ship): ?>
                <tr>
                    <td><?= htmlspecialchars($ship['name']) ?></td>
                    <td><?= htmlspecialchars($ship['model']) ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="/ships/show/<?= $ship['id'] ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/ships/edit/<?= $ship['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/ships/delete/<?= $ship['id'] ?>" method="POST" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('¿Estás seguro de eliminar esta nave?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>