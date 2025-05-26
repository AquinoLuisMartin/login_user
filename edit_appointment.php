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


$appointment_id = isset($_GET['appointment_id']) ? (int)$_GET['appointment_id'] : 0;
$user_id = $_SESSION['user_id'];


$stmt = $mysqli->prepare("SELECT * FROM appointments WHERE appointment_id = ? AND user_id = ?");
$stmt->bind_param("ii", $appointment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();



$appointment = $result->fetch_assoc();


if (strtotime($appointment['appointment_date']) < strtotime(date('Y-m-d'))) {
    $_SESSION['error_message'] = "Cannot edit past appointments.";
    header('Location: check_appointment.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles_check_app.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <a href="check_appointment.php" class="btn btn-outline-secondary rounded-3">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                            <h3 class="mb-0">Edit Appointment</h3>
                            <div style="width: 100px;"></div>
                        </div>

                        <form action="process_edit_appointment.php" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                            
                            <div class="mb-3">
                                <label for="pet_name" class="form-label">Pet Name</label>
                                <input type="text" class="form-control" id="pet_name" name="pet_name" 
                                       value="<?php echo htmlspecialchars($appointment['pet_name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="species" class="form-label">Species</label>
                                <input type="text" class="form-control" id="species" name="species" 
                                       value="<?php echo htmlspecialchars($appointment['species']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="owner_name" class="form-label">Owner Name</label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name" 
                                       value="<?php echo htmlspecialchars($appointment['owner_name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="treatment" class="form-label">Treatment/Service</label>
                                <input type="text" class="form-control" id="treatment" name="treatment" 
                                       value="<?php echo htmlspecialchars($appointment['treatment']); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="appointment_date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" 
                                           value="<?php echo $appointment['appointment_date']; ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="appointment_time" class="form-label">Time</label>
                                    <input type="time" class="form-control" id="appointment_time" name="appointment_time" 
                                           value="<?php echo $appointment['appointment_time']; ?>" required>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-100">Update Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
