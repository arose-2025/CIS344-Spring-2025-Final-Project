<?php

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 40px;
        }
    </style>
</head>
<body>

<h1>Pharmacy Portal</h1>

<?php if (isset($_SESSION['userName']) && isset($_SESSION['userType'])): ?>
    <p>Welcome, <?= htmlspecialchars($_SESSION['userName']) ?> (<?= htmlspecialchars($_SESSION['userType']) ?>)</p>
    <a href="logout.php" class="button logout-btn">Logout</a>

    <br><br>

    <?php if ($_SESSION['userType'] === 'pharmacist'): ?>
       
        <a href="?action=viewPrescriptions" class="button">View Prescriptions</a>
        <a href="?action=viewInventory" class="button">View Inventory</a>
        <a href="?action=viewUsers" class="button">View All Users</a>
        <a href="?action=addMedication" class="button">Add Medication</a>
    <?php elseif ($_SESSION['userType'] === 'patient'): ?>
        <a href="?action=viewPrescriptions" class="button">View Prescriptions</a>
    <?php endif; ?>

<?php else: ?>
    <p>You are not logged in.</p>
    <a href="PharmacyServer.php?action=login">Login</a>

<?php endif; ?>

</body>
</html>
