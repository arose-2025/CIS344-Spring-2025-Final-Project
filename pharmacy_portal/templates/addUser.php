<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if accessed from login page
$isFromLogin = isset($_GET['from']) && $_GET['from'] === 'login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Add User</h1>

<form method="POST" action="?action=addUser">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="contact_info">Contact Info (Email or Phone):</label><br>
    <input type="text" id="contact_info" name="contact_info" required><br><br>

    <?php if ($isFromLogin): ?>
        <input type="hidden" name="user_type" value="patient">
        <p>User Type: <strong>Patient</strong></p>
    <?php else: ?>
        <label for="user_type">User Type:</label><br>
        <select id="user_type" name="user_type" required>
            <option value="patient">Patient</option>
            <option value="pharmacist">Pharmacist</option>
        </select><br><br>
    <?php endif; ?>

    <button type="submit">Save User</button>
</form>

<br>
<a href="/pharmacy_portal/PharmacyServer.php?action=login">← Back to Login</a>





</body>
</html>
