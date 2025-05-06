<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Registered Users</h1>

<?php if (empty($users)): ?>
    <p class="no-data">No users found.</p>
<?php else: ?>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Contact Info</th>
            <th>User Type</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['userId']) ?></td>
                <td><?= htmlspecialchars($user['userName']) ?></td>
                <td><?= htmlspecialchars($user['contactInfo']) ?></td>
                <td><?= htmlspecialchars($user['userType']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<br>
<a href="?action=home">← Back to Home</a>

</body>
</html>
