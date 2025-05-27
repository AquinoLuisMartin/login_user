<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

//if (empty($_POST['appointment_id'])) {
  //  $_SESSION['error_message'] = 'Invalid appointment ID';
    //header('Location: check_appointment.php');
    //exit();
//}

$appointment_id = (int) $_POST['appointment_id'];
$user_id = (int) $_SESSION['user_id'];

$mysqli = new mysqli("localhost", "root", "", "user_db");

if ($mysqli->connect_error) {
    $_SESSION['error_message'] = "Connection failed: " . $mysqli->connect_error;
    header('Location: check_appointment.php');
    exit();
}

// Check if the appointment exists and belongs to the user
$stmt = $mysqli->prepare("SELECT appointment_date FROM appointments WHERE appointment_id = ? AND user_id = ?");
$stmt->bind_param("ii", $appointment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

//if (!$row) {
   // $_SESSION['error_message'] = 'Appointment not found or unauthorized';
   // header('Location: check_appointment.php');
   // exit();
//}

// You can delete even past appointments now
$stmt = $mysqli->prepare("DELETE FROM appointments WHERE appointment_id = ? AND user_id = ?");
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
