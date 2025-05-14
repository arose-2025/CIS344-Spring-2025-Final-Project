<?php
class PharmacyDatabase {
    private $host = "localhost";
    private $port = "3307";
    private $database = "pharmacy_portal_db";
    private $user = "root";
    private $password = "";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $this->port
        );

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    public function addUser($userName, $contactInfo, $userType) {
        $stmt = $this->connection->prepare(
            "INSERT INTO Users (userName, contactInfo, userType) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $userName, $contactInfo, $userType);
    
        if ($stmt->execute()) {
            echo "User added successfully";
        } else {
            echo "Failed to add user: " . $stmt->error;
        }
        $stmt->close();
    }
    

    public function getUserByUsernameAndType($username, $userType) {
        $stmt = $this->connection->prepare("SELECT userId, userName, contactInfo, userType FROM Users WHERE userName = ? AND userType = ?");
        $stmt->bind_param("ss", $username, $userType);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
    
    
    public function getAllUsers() {
        $query = "SELECT userId, userName, contactInfo, userType FROM Users";
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity) {
        $stmt = $this->connection->prepare(
            "SELECT userId FROM Users WHERE userName = ? AND userType = 'patient'"
        );
        $stmt->bind_param("s", $patientUserName);
        $stmt->execute();
        $stmt->bind_result($patientId);
        $stmt->fetch();
        $stmt->close();

        if ($patientId) {
            $stmt = $this->connection->prepare(
                "INSERT INTO prescriptions (userId, medicationId, dosageInstructions, quantity) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("iisi", $patientId, $medicationId, $dosageInstructions, $quantity);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function getPrescriptionsByUserId($userId) {
        $stmt = $this->connection->prepare("
            SELECT 
                p.prescriptionId,
                p.userId,
                p.medicationId,
                m.medicationName,
                p.dosageInstructions,
                p.quantity
            FROM prescriptions p
            JOIN medications m ON p.medicationId = m.medicationId
            WHERE p.userId = ?
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function getAllPrescriptions() {
        $query = "
            SELECT 
                p.prescriptionId,
                p.userId,
                p.medicationId,
                m.medicationName,
                p.dosageInstructions,
                p.quantity
            FROM 
                prescriptions p
            JOIN 
                medications m ON p.medicationId = m.medicationId
        ";
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addMedication($name, $dosage, $manufacturer) {
        $stmt = $this->connection->prepare(
            "INSERT INTO Medications (medicationName, dosage, manufacturer) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $name, $dosage, $manufacturer);
        $stmt->execute();
        $stmt->close();
    }

    public function MedicationInventory() {
        $query = "SELECT medicationId, medicationName, stockLevel FROM Medications";
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    

    public function getUserDetails($userId) {
        $stmt = $this->connection->prepare(
            "SELECT userId, userName, contactInfo, userType FROM Users WHERE userId = ?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $user = $userResult->fetch_assoc();
        $stmt->close();

        if (!$user) return null;

        $stmt = $this->connection->prepare(
            "SELECT p.prescriptionId, m.medicationName, p.prescribedDate, p.dosageInstructions, p.quantity, p.refillCount
             FROM Prescriptions p
             JOIN Medications m ON p.medicationId = m.medicationId
             WHERE p.userId = ?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $prescriptionsResult = $stmt->get_result();
        $prescriptions = $prescriptionsResult->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $user['prescriptions'] = $prescriptions;
        return $user;
    }
}
