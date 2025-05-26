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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Appointment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles_appointment.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        
                        <div class="mb-4">
                            <a href="home.php" class="btn btn-outline-secondary rounded-3">
                                <i class="bi bi-arrow-left"></i> Back to Dashboard</a>
                        </div>
                        
                        <h3 class="text-center mb-4">Schedule Pet Appointment</h3>
                        
                        <form action="process_appointment.php" method="POST">
                           
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                            
                            <div class="mb-3">
                                <label for="owner_name" class="form-label">Owner Name</label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name" required>
                            </div>

                          
                            <div class="mb-3">
                                <label for="pet_name" class="form-label">Pet Name</label>
                                <input type="text" class="form-control" id="pet_name" name="pet_name" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="species" class="form-label">Species</label>
                                    <select class="form-select" id="species" name="species" required>
                                        <option value="">Select Species</option>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                        <option value="Bird">Bird</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="breed" class="form-label">Breed</label>
                                    <input type="text" class="form-control" id="breed" name="breed" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Pet Age</label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>

                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Preferred Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="time" class="form-label">Preferred Time</label>
                                    <input type="time" class="form-control" id="time" name="time" required>
                                </div>
                            </div>

                            
                            <div class="mb-4">
                                <label for="treatment" class="form-label">Treatment/Service Needed</label>
                                <textarea class="form-control" id="treatment" name="treatment" rows="3" placeholder="Please describe the treatment or service needed for your pet" required></textarea>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" name="submit_appointment" class="btn btn-primary btn-lg rounded-3">
                                    Schedule Appointment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>