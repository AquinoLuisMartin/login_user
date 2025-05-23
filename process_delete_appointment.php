<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if appointment ID is provided
if (!isset($_POST['appointment_id']) || empty($_POST['appointment_id'])) {
    $_SESSION['error_message'] = 'Invalid appointment ID';
    header('Location: check_appointment.php');
    exit();
}

// Database connection
$mysqli = new mysqli("localhost", "root", "", "user_db");

// Check connection
if ($mysqli->connect_error) {
    $_SESSION['error_message'] = "Connection failed: " . $mysqli->connect_error;
    header('Location: check_appointment.php');
    exit();
}

$appointment_id = $_POST['appointment_id'];
$user_id = $_SESSION['user_id'];

// Check if the appointment exists and belongs to the current user
$check_query = "SELECT appointment_date FROM appointments WHERE id = ? AND user_id = ?";
$stmt = $mysqli->prepare($check_query);
$stmt->bind_param("ii", $appointment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = 'Appointment not found or unauthorized access';
    header('Location: check_appointment.php');
    exit();
}

// Check if appointment is in the past
$appointment = $result->fetch_assoc();
if (strtotime($appointment['appointment_date']) < strtotime(date('Y-m-d'))) {
    $_SESSION['error_message'] = 'Cannot delete past appointments';
    header('Location: check_appointment.php');
    exit();
}

// Delete the appointment
$delete_query = "DELETE FROM appointments WHERE id = ? AND user_id = ?";
$stmt = $mysqli->prepare($delete_query);
$stmt->bind_param("ii", $appointment_id, $user_id);

if ($stmt->execute()) {
    $_SESSION['success_message'] = 'Appointment deleted successfully';
} else {
    $_SESSION['error_message'] = 'Error deleting appointment';
}

$stmt->close();
$mysqli->close();
header('Location: check_appointment.php');
exit();
?>