<?php
// Show all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once 'includes/PharmacyDatabase.php';

class PharmacyPortal {
    private $db;

    public function __construct() {
        $this->db = new PharmacyDatabase();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            case 'addPrescription':
                $this->requireRole('pharmacist');
                $this->addPrescription();
                break;
            case 'viewPrescriptions':
                $this->viewPrescriptions();
                break;
            case 'viewInventory':
                $this->requireRole('pharmacist');
                $this->viewInventory();
                break;
            case 'addUser':
                $this->addUser();
                break;
            case 'login':
                $this->login();
                break;
            case 'viewUsers':
                $this->requireRole('pharmacist');
                $this->viewUsers();
                break;
            case 'addMedication':
                $this->requireRole('pharmacist');
                $this->addMedication();
                break;
            default:
                $this->home();
        }
    }

    private function requireRole($role) {
        if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== $role) {
            echo "<p style='color:red;'>Access denied. $role only.</p>";
            exit;
        }
    }

    private function home() {
        include 'templates/home.php';
    }

    private function addPrescription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientUserName = $_POST['patient_username'];
            $medicationId = $_POST['medication_id'];
            $dosageInstructions = $_POST['dosage_instructions'];
            $quantity = $_POST['quantity'];

            $this->db->addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity);
            header("Location:?action=viewPrescriptions&message=Prescription+Added");
        } else {
            include 'templates/addPrescription.php';
        }
    }

    private function viewPrescriptions() {
        $prescriptions = $this->db->getAllPrescriptions();
        include 'templates/viewPrescriptions.php';
    }

    private function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $contact = $_POST['contact_info'];
            $userType = $_POST['user_type'];
            $password = $_POST['password'];

            $this->db->addUser($username, $contact, $userType, $password);
            header("Location: ?action=home&message=User+Added");
            exit;
        } else {
            include 'templates/addUser.php';
        }
    }

    private function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $userType = $_POST['user_type'];

            $user = $this->db->getUserByUsernameAndType($username, $userType);

            if ($user) {
                $_SESSION['userId'] = $user['userId'];
                $_SESSION['userName'] = $user['userName'];
                $_SESSION['userType'] = $user['userType'];
                header("Location: PharmacyServer.php");
                exit();
            } else {
                echo "<p style='color:red;'>Login failed. Invalid username or user type.</p>";
            }
        }
        include 'templates/login.php';
    }

    private function viewUsers() {
        $users = $this->db->getAllUsers();
        include 'templates/viewUsers.php';
    }

    private function viewInventory() {
        if ($_SESSION['userType'] !== 'pharmacist') {
            echo "<p style='color:red;'>Access denied: Only pharmacists can view inventory.</p>";
            return;
        }
    
        $inventory = $this->db->MedicationInventory();
        include 'templates/viewInventory.php';
    }
    

    private function addMedication() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['medication_name'];
            $dosage = $_POST['dosage'];
            $manufacturer = $_POST['manufacturer'];

            $this->db->addMedication($name, $dosage, $manufacturer);
            header("Location: ?action=home&message=Medication+Added");
            exit;
        } else {
            include 'templates/addMedication.php';
        }
    }
}

$portal = new PharmacyPortal();
$portal->handleRequest();
