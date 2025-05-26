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

if (isset($_POST['submit_appointment'])) {    
    $user_id = $_SESSION['user_id'];
    $owner_name = $mysqli->real_escape_string($_POST['owner_name']);
    $pet_name = $mysqli->real_escape_string($_POST['pet_name']);
    $species = $mysqli->real_escape_string($_POST['species']);
    $breed = $mysqli->real_escape_string($_POST['breed']);
    $age = (int)$_POST['age'];
    $date = $mysqli->real_escape_string($_POST['date']);
    $time = $mysqli->real_escape_string($_POST['time']);
    $treatment = $mysqli->real_escape_string($_POST['treatment']);

    
    $sql = "INSERT INTO appointments (user_id, owner_name, pet_name, species, breed, age, appointment_date, appointment_time, treatment) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("issssisss", $user_id, $owner_name, $pet_name, $species, $breed, $age, $date, $time, $treatment);

    if ($stmt->execute()) {
        
        $_SESSION['success_message'] = "Appointment scheduled successfully!";
        
        header('Location: home.php');
        exit;
    } else {
        
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
