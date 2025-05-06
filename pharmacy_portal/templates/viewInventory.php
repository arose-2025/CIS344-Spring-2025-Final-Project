<!DOCTYPE html>
<html>
<head>
    <title>Medication Inventory</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Medication Inventory</h1>

<?php if (empty($inventory)): ?>
    <p class="no-data">No inventory data found.</p>
<?php else: ?>
    <table>
    <thead>
        <tr>
            <th>Medication ID</th>
            <th>Medication Name</th>
            <th>Stock Level</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventory as $med): ?>
            <tr>
                <td><?= htmlspecialchars($med['medicationId']) ?></td>
                <td><?= htmlspecialchars($med['medicationName']) ?></td>
                <td><?= htmlspecialchars($med['stockLevel']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<br>
<a href="?action=home">← Back to Home</a>

</body>
</html>
