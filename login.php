<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $mysqli = new mysqli("localhost", "root", "", "user_db");

    
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    
    if (isset($_POST['signup'])) {
        
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $cpassword = $_POST['cpassword'] ?? '';

        if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password) && !empty($cpassword)) {
            if ($password !== $cpassword) {
                $message = "Passwords do not match";
                $messageType = "error";
            } else {
                
                $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();                if ($stmt->num_rows > 0) {
                    $message = "Email already registered";
                    $messageType = "error";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->close();
                    $stmt = $mysqli->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
                    if ($stmt) {
                        $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);                        if ($stmt->execute()) {
                            $message = "User registered successfully!";
                            $messageType = "success";
                        } else {
                            $message = "Error: " . $stmt->error;
                            $messageType = "error";
                        }
                        $stmt->close();
                    } else {
                        $message = "<p style='color:red;'>Failed to prepare statement: " . $mysqli->error . "</p>";
                    }
                }
            }
        } else {
            $message = "Please fill in all fields";
            $messageType = "error";
        }
    } elseif (isset($_POST['login'])) {
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if (!empty($email) && !empty($password)) {
            $stmt = $mysqli->prepare("SELECT user_id, password, first_name FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($user_id, $hashed_password, $first_name);
                $stmt->fetch();
                if (password_verify($password, $hashed_password)) {
                    
                    session_start();
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['first_name'] = $first_name;
                    header("Location: home.php");
                    exit;
                } else {
                    $message = "Invalid email or password";
                    $messageType = "error";
                }
            } else {
                $message = "Invalid email or password";
                $messageType = "error";
            }
            $stmt->close();
        } else {
            $message = "Please fill in all fields";
            $messageType = "error";
        }
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Clinic and Veterinary Management System</title>    
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>    
    <section class="main">
        <div class="form_wrapper">
            <input type="radio" class="radio" name="radio" id="login" checked />
            <input type="radio" class="radio" name="radio" id="signup" />
            <div class="tile">
                <h3 class="login">Login Form</h3>
                <h3 class="signup">Signup Form</h3>
            </div>
            
            <label class="tab login_tab" for="login">Login</label>
            <label class="tab signup_tab" for="signup">Signup</label>
            <span class="shape"></span>

            <?php if (!empty($message)): ?>
                <div class="message <?php echo $messageType; ?>">
                    <i class="bx <?php echo $messageType === 'error' ? 'bx-x-circle' : 'bx-check-circle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>              
            <div class="form_wrap">
                <form method="post" class="form_fild login_form">
                    <div class="input_group">
                        <input type="email" class="input" placeholder="Email Address" name="email" required autocomplete="email" />
                    </div>
                    <div class="input_group">
                        <input type="password" class="input" placeholder="Password" name="password" required autocomplete="current-password" />
                    </div>

                    <a href="#forgot" class="forgot">Forgot password?</a>

                    <button type="submit" class="btn" name="login">Login</button>
                </form>                
                <form method="post" class="form_fild signup_form" id="signupForm" novalidate>
                    <div class="input_group">
                        <input type="text" class="input" placeholder="First Name" name="first_name" required 
                            pattern="[A-Za-z]+" title="Please enter a valid first name (letters only)" />
                    </div>
                    <div class="input_group">
                        <input type="text" class="input" placeholder="Last Name" name="last_name" required 
                            pattern="[A-Za-z]+" title="Please enter a valid last name (letters only)" />
                    </div>
                    <div class="input_group">
                        <input type="email" class="input" placeholder="Email Address" name="email" required />
                    </div>
                    <div class="input_group">
                        <input type="password" class="input" placeholder="Password" name="password" required />
                    </div>
                    <div class="input_group">
                        <input type="password" class="input" placeholder="Confirm Password" name="cpassword" required />
                    </div>

                    <button type="submit" class="btn" name="signup">Signup</button>
                </form>
            </div>
        </div>
    </section>    
</body>
</html>