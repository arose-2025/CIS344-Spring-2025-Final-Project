<?php

require_once __DIR__ . '/../includes/PharmacyDatabase.php';



$db = new PharmacyDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $userType = $_POST['user_type'];
    // no password needed $password = $_POST['password'];

    // ✅ Use the public method to get user info
    $user = $db->getUserByUsernameAndType($username, $userType);

    if ($user) {
        $_SESSION['userId'] = $user['userId'];
        $_SESSION['userName'] = $user['userName'];
        $_SESSION['userType'] = $user['userType'];
        header("Location: ../pharmacy_portal/PharmacyServer.php");
        ;
        exit;
    } else {
        $error = "Invalid credentials.";
    }
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Login</h1>

<?php if (isset($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>

  

    <label for="user_type">User Type:</label><br>
    <select id="user_type" name="user_type" required>
        <option value="patient">Patient</option>
        <option value="pharmacist">Pharmacist</option>
    </select><br><br>

    <button type="submit">Login</button>
</form>
<br>
<a href="/pharmacy_portal/templates/addUser.php?from=login">Add New User</a>




</body>
</html>
