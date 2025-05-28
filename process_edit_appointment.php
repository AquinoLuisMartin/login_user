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
    $owner_name = $_POST['owner_name'];
    $pet_name = $_POST['pet_name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = (int)$_POST['age'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $treatment = $_POST['treatment'];

    $sql = "UPDATE `appointments` SET `owner_name`='$owner_name', `pet_name`='$pet_name', `species`='$species', `breed`='$breed', `age`=$age, `appointment_date`='$appointment_date', `appointment_time`='$appointment_time', `treatment`='$treatment' WHERE id = $appointment_id";

    $result = $mysqli->query($sql);

    if ($result) {
        $_SESSION['success_message'] = "Appointment updated successfully!";
        header("Location: check_appointment.php");
    } else {
        $_SESSION['error_message'] = "Failed: " . $mysqli->error;
        header("Location: edit_appointment.php?id=$appointment_id");
    }
    exit;
}

$mysqli->close();
?>
