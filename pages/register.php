<?php
require_once("../includes/db.php");
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim(mysqli_real_escape_string($conn, $_POST["name"]));
    $email = trim(mysqli_real_escape_string($conn, $_POST["email"]));
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirmpassword)) {
        $message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } elseif ($password !== $confirmpassword) {
        $message = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters!";
    } else {
        // Check if email exists
        $sql = "SELECT id FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $message = "Email is already registered!";
        } else {
            // Hash password and insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed')";
            if (mysqli_query($conn, $sql)) {
                header("Location: login.php?msg=registered");
                exit();
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - TripWave</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f6f8fa; }
    .card { margin-top: 48px; }
    .input-field input:focus { border-bottom: 2px solid #00796b !important; }
    .btn { border-radius: 20px; }
    .center-logo { font-size: 2.2rem; color: #00796b; }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col s12 m6 offset-m3">
        <div class="card z-depth-3">
          <div class="card-content">
            <div class="center-align">
              <span class="center-logo"><i class="fa fa-globe-asia"></i></span>
              <h5 style="font-weight:700;">Create Your TripWave Account</h5>
            </div>
            <?php if (!empty($message)) { ?>
              <div class="card-panel red lighten-4 red-text text-darken-4 center-align" style="margin-bottom:16px;">
                <?php echo $message; ?>
              </div>
            <?php } ?>
            <form method="post" action="register.php" id="registerForm">
              <div class="input-field">
                <input id="name" name="name" type="text" class="validate" required>
                <label for="name"><i class="fa fa-user"></i> Full Name</label>
              </div>
              <div class="input-field">
                <input id="email" name="email" type="email" class="validate" required>
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
              </div>
              <div class="input-field">
                <input id="password" name="password" type="password" class="validate" required minlength="6">
                <label for="password"><i class="fa fa-lock"></i> Password</label>
              </div>
              <div class="input-field">
                <input id="confirmpassword" name="confirmpassword" type="password" class="validate" required minlength="6">
                <label for="confirmpassword"><i class="fa fa-lock"></i> Confirm Password</label>
              </div>
              <div class="input-field">
                <button class="btn waves-effect waves-light teal lighten-1" type="submit" name="register">
                  Register <i class="fa fa-arrow-right"></i>
                </button>
              </div>
              <p class="center-align">Already have an account? <a href="login.php">Login here</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Materialize JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    // Frontend validation example
    document.getElementById('registerForm').onsubmit = function(e) {
      var pwd = document.getElementById('password').value;
      var cpwd = document.getElementById('confirmpassword').value;
      if (pwd !== cpwd) {
        M.toast({html: 'Passwords do not match', classes: 'red'});
        e.preventDefault();
        return false;
      }
      return true;
    }
  </script>

</body>
</html>