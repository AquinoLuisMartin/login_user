<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


$mysqli = new mysqli("localhost", "root", "", "user_db");


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


if (isset($_POST['delete_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    $user_id = $_SESSION['user_id'];
    
    
    $stmt = $mysqli->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $appointment_id, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Appointment deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Error deleting appointment.";
    }
    
    header('Location: check_appointment.php');
    exit;
}


if (isset($_POST['update_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    $user_id = $_SESSION['user_id'];
    $owner_name = $mysqli->real_escape_string($_POST['owner_name']);
    $pet_name = $mysqli->real_escape_string($_POST['pet_name']);
    $species = $mysqli->real_escape_string($_POST['species']);
    $breed = $mysqli->real_escape_string($_POST['breed']);
    $age = (int)$_POST['age'];
    $date = $mysqli->real_escape_string($_POST['date']);
    $time = $mysqli->real_escape_string($_POST['time']);
    $treatment = $mysqli->real_escape_string($_POST['treatment']);

    
    $stmt = $mysqli->prepare("UPDATE appointments SET 
        owner_name = ?, 
        pet_name = ?, 
        species = ?, 
        breed = ?, 
        age = ?, 
        appointment_date = ?, 
        appointment_time = ?, 
        treatment = ? 
        WHERE id = ? AND user_id = ?");
    
    $stmt->bind_param("ssssisssii", 
        $owner_name, 
        $pet_name, 
        $species, 
        $breed, 
        $age, 
        $date, 
        $time, 
        $treatment, 
        $appointment_id, 
        $user_id
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Appointment updated successfully!";
        header('Location: check_appointment.php');
    } else {
        $_SESSION['error_message'] = "Error updating appointment: " . $stmt->error;
        header('Location: edit_appointment.php?id=' . $appointment_id);
    }
    exit;
}

$mysqli->close();
?>
