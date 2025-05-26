<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$first_name = htmlspecialchars($_SESSION['first_name'] ?? 'User');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANICARE Dashboard</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles_home.css">
</head>
<body>    
    <div class="sidebar bg-white shadow-sm border-end d-flex flex-column" style="height: 100vh; overflow-y: auto;">
        <div class="logo p-4">            
            <div class="d-flex align-items-center">               
                 <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                    <i class="bi bi-hospital fs-4 text-primary"></i>
                </div>
                <div>
                    <span class="h4 mb-0 fw-bold text-primary">ANICARE</span>
                    <div class="text-muted small">Veterinary Care System</div>
                </div>
            </div>
        </div>
        <div class="px-3 py-2 flex-grow-1 d-flex flex-column">
            <ul class="nav nav-pills flex-column gap-2 mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active rounded-3">
                        <i class="bi bi-grid me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="appointment.php" class="nav-link text-dark rounded-3">
                        <i class="bi bi-calendar me-2"></i> Appointment
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark rounded-3">
                        <i class="bi bi-list-check me-2"></i> Services
                    </a>
                </li>                
                <li class="nav-item">
                    <a href="check_appointment.php" class="nav-link text-dark rounded-3">
                        <i class="bi bi-clipboard-check me-2"></i> Check Appointment
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark rounded-3">
                        <i class="bi bi-credit-card me-2"></i> Payment
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark rounded-3">
                        <i class="bi bi-gear me-2"></i> Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark rounded-3">
                        <i class="bi bi-person me-2"></i> My Account
                    </a>
                </li>
                <li class="nav-item">
                    <a href="login.php" class="nav-link text-dark rounded-3">
                        <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                    </a>
                </li>                
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark rounded-3">
                        <i class="bi bi-question-circle me-2"></i> Help
                    </a>
                </li>
            </ul>
            <div class="mt-3 border-top pt-3">
                <a href="login.php" class="nav-link text-dark rounded-3 d-flex align-items-center">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </div>
    </div>
    <div class="main-content bg-light">        
        <header class="navbar navbar-expand bg-white shadow-sm mb-4 px-4 py-3">
            <div class="container-fluid px-0">
                <form class="d-flex w-25">
                    <input type="search" placeholder="Search Here" class="form-control rounded-pill border-0 bg-light">
                </form>
                <div class="ms-auto">
                    <button class="btn btn-link text-muted">
                        <i class="bi bi-bell fs-5"></i>
                    </button>
                </div>
            </div>
        </header>

        <div class="container-fluid px-4">            
            <section class="card border-0 bg-primary text-white rounded-4 shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h2 class="display-6 fw-bold mb-4">Pet Services and Veterinary Clinic</h2>
                            <div class="d-flex gap-3 flex-wrap">
                                <button class="btn btn-light px-4 py-2 fw-semibold">Get Started</button>
                                <button class="btn btn-outline-light px-4 py-2 fw-semibold">Learn More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-semibold m-0">Features</h5>
                    <button class="btn btn-light rounded-pill px-3 py-2 text-primary">
                        <i class="bi bi-grid me-2"></i>View All</button>
                </div>
                <div class="row g-4">                    
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 rounded-4 shadow-sm hover-lift h-100">
                            <div class="card-body text-center p-4">
                                <div class="icon-box d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-3 p-3 mb-3">
                                    <i class="bi bi-building fs-4 text-primary"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Clinic</h6>
                                <small class="text-muted">24/7 Service</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 rounded-4 shadow-sm hover-lift h-100">
                            <div class="card-body text-center p-4">
                                <div class="icon-box d-inline-flex align-items-center justify-content-center bg-light rounded-3 p-3 mb-3">
                                    <i class="bi bi-person-vcard fs-4 text-primary"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Doctor</h6>
                                <small class="text-muted">Expert Care</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 rounded-4 shadow-sm hover-lift h-100">
                            <div class="card-body text-center p-4">
                                <div class="icon-box d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-3 p-3 mb-3">
                                    <i class="bi bi-gear-fill fs-4 text-primary"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Services</h6>
                                <small class="text-muted">Full Support</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 rounded-4 shadow-sm hover-lift h-100">
                            <div class="card-body text-center p-4">
                                <div class="icon-box d-inline-flex align-items-center justify-content-center bg-light rounded-3 p-3 mb-3">
                                    <i class="bi bi-capsule fs-4 text-primary"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Pharmacy</h6>
                                <small class="text-muted">Complete Stock</small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <aside class="right-panel bg-white shadow-sm p-4">
            
            <div class="schedule mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Schedule</h6>
                </div>
                <div class="schedule-items d-flex gap-2">
                    <div class="schedule-item card bg-primary text-white rounded-3 border-0 p-2">
                        <div class="text-center">
                            <div class="text-white-50 small mb-1">2024 December</div>
                            <div class="fs-3 fw-bold mb-1">20</div>
                            <div class="text-white small">Surgery</div>
                        </div>
                    </div>
                    <div class="schedule-item card bg-light rounded-3 border-0 p-2">
                        <div class="text-center">
                            <div class="text-muted small mb-1">2024 December</div>
                            <div class="fs-3 fw-bold text-dark mb-1">22</div>
                            <div class="text-muted small">Therapy</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="appointments mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="appointment.php" class="btn btn-primary btn-sm rounded-3">
                        <i class="bi bi-plus-lg"></i> New Appointment</a>
                </div>
                <div class="appointment-cards">
                    <div class="appointment-card bg-primary text-white rounded-4 border-0 p-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="appointment-icon bg-white rounded-circle p-2">
                                <i class="bi bi-calendar-check fs-5 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Lifestyle Counseling</h6>
                                <div class="text-white-50 small">Dr. Rajesh Khan</div>
                            </div>
                        </div>
                    </div>
                    <div class="appointment-card bg-light rounded-4 border-0 p-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="appointment-icon bg-primary bg-opacity-10 rounded-circle p-2">
                                <i class="bi bi-calendar-check fs-5 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Rehabilitation</h6>
                                <div class="text-muted small">Dr. Claudia Alves</div>
                            </div>
                        </div>
                    </div>
                    <div class="appointment-card bg-light rounded-4 border-0 p-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="appointment-icon bg-primary bg-opacity-10 rounded-circle p-2">
                                <i class="bi bi-calendar-check fs-5 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">Preventive Care</h6>
                                <div class="text-muted small">Dr. Niel Hermogenes</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="messages">                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Message</h6>
                </div>
                    <div class="card bg-primary text-white rounded-4 border-0 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">                    
                        <div>
                            <h5 class="fw-semibold mb-1">Dr. Alfredo Torres</h5>
                            <div class="text-white-50 small">1 Minute Ago</div>
                        </div>
                        <div>
                            <i class="bi bi-mic-fill fs-5 text-white"></i>
                        </div>
                    </div>
                    <p class="mb-0 text-white-50">You automatically lose the chances you don't take.</p>
                </div>
            </div>
        </aside>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"></script>
</body>
</html>
