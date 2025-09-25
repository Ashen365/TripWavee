<?php
require_once("../includes/db.php");
session_start();
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(mysqli_real_escape_string($conn, $_POST["email"]));
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row["password"])) {
            // Login success
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];
            header("Location: ../index.php");
            exit();
        } else {
            $message = "Invalid email or password!";
        }
    } else {
        $message = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - TripWave</title>
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
              <h5 style="font-weight:700;">Sign In to TripWave</h5>
            </div>
            <?php if (!empty($message)) { ?>
              <div class="card-panel red lighten-4 red-text text-darken-4 center-align" style="margin-bottom:16px;">
                <?php echo $message; ?>
              </div>
            <?php } ?>
            <?php if (isset($_GET['msg']) && $_GET['msg'] == "registered") { ?>
              <div class="card-panel green lighten-4 green-text text-darken-4 center-align" style="margin-bottom:16px;">
                Registration successful! Please login.
              </div>
            <?php } ?>
            <?php if (isset($_GET['msg']) && $_GET['msg'] == "loggedout") { ?>
              <div class="card-panel blue lighten-4 blue-text text-darken-4 center-align" style="margin-bottom:16px;">
                You have been logged out.
              </div>
            <?php } ?>
            <form method="post" action="login.php">
              <div class="input-field">
                <input id="email" name="email" type="email" class="validate" required>
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
              </div>
              <div class="input-field">
                <input id="password" name="password" type="password" class="validate" required minlength="6">
                <label for="password"><i class="fa fa-lock"></i> Password</label>
              </div>
              <div class="input-field">
                <button class="btn waves-effect waves-light teal lighten-1" type="submit" name="login">
                  Login <i class="fa fa-sign-in-alt"></i>
                </button>
              </div>
              <p class="center-align">Don't have an account? <a href="register.php">Register here</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Materialize JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>