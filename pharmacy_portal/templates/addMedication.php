<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Medication</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Add New Medication</h1>

<form method="POST" action="?action=addMedication">
    <label for="medication_name">Medication Name:</label><br>
    <input type="text" id="medication_name" name="medication_name" required><br><br>

    <label for="dosage">Dosage:</label><br>
    <input type="text" id="dosage" name="dosage" required><br><br>

    <label for="manufacturer">Manufacturer:</label><br>
    <input type="text" id="manufacturer" name="manufacturer" required><br><br>

    <button type="submit">Save Medication</button>
</form>

<br>
<a href="?action=home">← Back to Home</a>

</body>
</html>
