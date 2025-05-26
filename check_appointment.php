<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include database configuration
$base_path = dirname($_SERVER['PHP_SELF']);
$base_path = str_replace('\\', '/', $base_path);

// Database connection
$mysqli = new mysqli("localhost", "root", "", "user_db");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch user's appointments
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM appointments WHERE user_id = ? ORDER BY appointment_date, appointment_time";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles_check_app.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <!-- Add back button -->                        
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <a href="<?php echo $base_path; ?>/home.php" class="btn btn-outline-secondary rounded-3">
                                <i class="bi bi-arrow-left"></i> Back to Dashboard
                            </a>
                            <h3 class="mb-0">Your Appointments</h3>
                            <a href="<?php echo $base_path; ?>/appointment.php" class="btn btn-primary rounded-3">
                                <i class="bi bi-plus-lg"></i> New Appointment
                            </a>
                        </div>                        <?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
                            <div class="row justify-content-center mb-4">
                                <div class="col-md-12">
                                    <?php if (isset($_SESSION['success_message'])): ?>
                                        <div class="alert alert-success alert-dismissible fade show rounded-3 d-flex align-items-center" role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                                <div>
                                                    <strong>Success!</strong>
                                                    <div class="mt-1">
                                                        <?php 
                                                        echo $_SESSION['success_message'];
                                                        unset($_SESSION['success_message']);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (isset($_SESSION['error_message'])): ?>
                                        <div class="alert alert-danger alert-dismissible fade show rounded-3 d-flex align-items-center" role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                                                <div>
                                                    <strong>Error!</strong>
                                                    <div class="mt-1">
                                                        <?php 
                                                        echo $_SESSION['error_message'];
                                                        unset($_SESSION['error_message']);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($result->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>                                            
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Pet Name</th>
                                            <th>Species</th>
                                            <th>Treatment/Service</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo date('M d, Y', strtotime($row['appointment_date'])); ?></td>
                                                <td><?php echo date('h:i A', strtotime($row['appointment_time'])); ?></td>
                                                <td>
                                                    <div class="fw-semibold"><?php echo htmlspecialchars($row['pet_name']); ?></div>
                                                    <small class="text-muted">Owner: <?php echo htmlspecialchars($row['owner_name']); ?></small>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['species']); ?></td>
                                                <td><?php echo htmlspecialchars($row['treatment']); ?></td>
                                                <td class="text-end">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <?php 
                                                        $appointmentDate = strtotime($row['appointment_date']);
                                                        $today = strtotime(date('Y-m-d'));
                                                        if ($appointmentDate >= $today): 
                                                        ?>
                                                            <a href="edit_appointment.php?id=<?php echo $row['id']; ?>" 
                                                               class="btn btn-sm btn-outline-primary rounded-3">
                                                                <i class="bi bi-pencil me-1"></i>Edit
                                                            </a>
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-danger rounded-3 delete-appointment"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal"
                                                                    data-id="<?php echo $row['id']; ?>"
                                                                    data-pet="<?php echo htmlspecialchars($row['pet_name'], ENT_QUOTES); ?>"
                                                                    data-date="<?php echo htmlspecialchars(date('M d, Y', strtotime($row['appointment_date'])), ENT_QUOTES); ?>">
                                                                <i class="bi bi-trash me-1"></i>Delete
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x text-muted fs-1"></i>
                                <p class="text-muted mt-3">No appointments found.</p>
                                <a href="appointment.php" class="btn btn-primary">Schedule an Appointment</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the appointment for <strong id="petName"></strong> on <span id="appointmentDate"></span>?</p>
                    <p class="text-danger mb-0"><small><i class="bi bi-exclamation-triangle-fill"></i> This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <form action="process_delete_appointment.php" method="POST" class="d-inline">
                        <input type="hidden" name="appointment_id" id="appointmentId">
                        <button type="submit" class="btn btn-danger">Delete Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete button clicks
        const deleteButtons = document.querySelectorAll('.delete-appointment');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const pet = this.getAttribute('data-pet');
                const date = this.getAttribute('data-date');
                
                document.getElementById('appointmentId').value = id;
                document.getElementById('petName').textContent = pet;
                document.getElementById('appointmentDate').textContent = date;
            });
        });
    });
    </script>
</body>
</html>