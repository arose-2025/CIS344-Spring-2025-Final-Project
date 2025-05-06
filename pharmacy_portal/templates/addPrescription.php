<!DOCTYPE html>
<html>
<head>
    <title>Add Prescription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add Prescription</h1>

    <form method="POST" action="?action=addPrescription">
        Patient Username: <input type="text" name="patient_username" required /><br>
        Medication ID: <input type="number" name="medication_id" required /><br>
        Dosage Instructions: <textarea name="dosage_instructions" required></textarea><br>
        Quantity: <input type="number" name="quantity" required /><br>
        <button type="submit">Save</button>
    </form>

    <a href="?action=home">Back to Home</a>
</body>
</html>
