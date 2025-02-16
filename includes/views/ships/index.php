<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Naves</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .actions a, .actions form { display: inline-block; margin-right: 10px; }
        .add-button {
        float: right;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 4px;
    }
    </style>
</head>
<body>
    <h2>Lista de naves</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Modelo</th>
                <th><a href="/ships/add" class="add-button">Añadir nave</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ships as $ship): ?>
                <tr>
                    <td><?= htmlspecialchars($ship['name']) ?></td>
                    <td><?= htmlspecialchars($ship['model']) ?></td>
                    <td class="actions">
                        <a href="/ships/show/<?= $ship['id'] ?>">Ver</a>
                        <a href="/ships/edit/<?= $ship['id'] ?>">Editar</a>
                        <form action="/ships/delete/<?= $ship['id'] ?>" method="POST" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta nave?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>