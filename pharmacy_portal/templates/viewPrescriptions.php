<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Prescriptions</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h1>All Prescriptions</h1>

    <?php if (empty($prescriptions)): ?>
        <p class="no-data">No prescriptions found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Prescription ID</th>
                    <th>User ID</th>
                    <th>Medication ID</th>
                    <th>Medication Name</th>
                    <th>Dosage Instructions</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prescriptions as $prescription): ?>
                    <tr>
                        <td><?= htmlspecialchars($prescription['prescriptionId']) ?></td>
                        <td><?= htmlspecialchars($prescription['userId']) ?></td>
                        <td><?= htmlspecialchars($prescription['medicationId']) ?></td>
                        <td><?= htmlspecialchars($prescription['medicationName']) ?></td>
                        <td><?= htmlspecialchars($prescription['dosageInstructions']) ?></td>
                        <td><?= htmlspecialchars($prescription['quantity']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <br>
    <a href="?action=home">← Back to Home</a>

</body>
</html>
