<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require_once("../includes/db.php");

$user_id = $_SESSION["user_id"];
$message = "";

// Handle delete
if (isset($_POST['delete_profile'])) {
    // Delete user image if exists
    $sql = "SELECT profile_image FROM users WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);
    $userImg = mysqli_fetch_assoc($result);
    if ($userImg && !empty($userImg['profile_image'])) {
        @unlink("../assets/images/profiles/" . $userImg['profile_image']);
    }
    // Delete user
    $sql = "DELETE FROM users WHERE id=$user_id";
    mysqli_query($conn, $sql);
    session_destroy();
    header("Location: register.php?msg=deleted");
    exit();
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = trim(mysqli_real_escape_string($conn, $_POST["name"]));
    $email = trim(mysqli_real_escape_string($conn, $_POST["email"]));
    $phone = trim(mysqli_real_escape_string($conn, $_POST["phone"]));
    $address = trim(mysqli_real_escape_string($conn, $_POST["address"]));
    $about = trim(mysqli_real_escape_string($conn, $_POST["about"]));
    $profile_image = "";

    // Simple validation
    if (empty($name) || empty($email)) {
        $message = "Name and email are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } else {
        // Check if email changed and is not taken by someone else
        $sql = "SELECT id FROM users WHERE email='$email' AND id!=$user_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $message = "Email already in use by another user!";
        } else {
            // Handle image upload
            if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
                $target_dir = "../assets/images/profiles/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                $ext = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));
                $file_name = "user_" . $user_id . "_" . time() . ".$ext";
                $target_file = $target_dir . $file_name;
                $allowed = ["jpg", "jpeg", "png", "gif"];
                if (in_array($ext, $allowed)) {
                    move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
                    $profile_image = $file_name;

                    // Remove old image if exists
                    $sql = "SELECT profile_image FROM users WHERE id=$user_id";
                    $oldImgQ = mysqli_query($conn, $sql);
                    $oldImgRow = mysqli_fetch_assoc($oldImgQ);
                    if ($oldImgRow && !empty($oldImgRow['profile_image'])) {
                        @unlink($target_dir . $oldImgRow['profile_image']);
                    }
                }
            }

            // Update user info
            $img_sql = $profile_image ? ", profile_image='$profile_image'" : "";
            $sql = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address', about='$about' $img_sql WHERE id=$user_id";
            if (mysqli_query($conn, $sql)) {
                $_SESSION["user_name"] = $name;
                // ----- FIX: Always update session photo -----
                if ($profile_image) {
                    $_SESSION["user_photo"] = $profile_image;
                } else {
                    // If no new upload, ensure session sync with DB
                    $sql = "SELECT profile_image FROM users WHERE id=$user_id";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION["user_photo"] = $row['profile_image'];
                }
                // -------------------------------------------
                $message = "Profile updated successfully!";
            } else {
                $message = "Failed to update profile!";
            }
        }
    }
}

// Fetch user data
$sql = "SELECT * FROM users WHERE id=$user_id LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Set default image if not set
$profile_photo = !empty($user['profile_image']) ? "/tripwave/assets/images/profiles/" . $user['profile_image'] : "https://ui-avatars.com/api/?name=" . urlencode($user['name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - TripWave</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f6f8fa; }
    .card { margin-top: 48px; }
    .input-field input:focus, .input-field textarea:focus { border-bottom: 2px solid #00796b !important; }
    .btn { border-radius: 20px; }
    .center-logo { font-size: 2.2rem; color: #00796b; }
    .profile-photo { width: 95px; height: 95px; border-radius: 50%; object-fit: cover; border: 3px solid #e0f2f1; margin-bottom: 18px;}
    .action-btns { margin-top: 13px;}
    .delete-btn { margin-left: 12px;}
  </style>
</head>
<body>
  <?php include("../includes/header.php"); ?>
  <div class="container">
    <div class="row">
      <div class="col s12 m8 offset-m2">
        <div class="card z-depth-3">
          <div class="card-content">
            <div class="center-align">
              <img src="<?php echo $profile_photo; ?>" class="profile-photo" alt="Profile Photo">
              <h5 style="font-weight:700;">My Profile</h5>
            </div>
            <?php if (!empty($message)) { ?>
              <div class="card-panel <?php echo (strpos(strtolower($message), 'success') !== false) ? 'green' : 'red'; ?> lighten-4 <?php echo (strpos(strtolower($message), 'success') !== false) ? 'green-text' : 'red-text'; ?> text-darken-4 center-align" style="margin-bottom:16px;">
                <?php echo $message; ?>
              </div>
            <?php } ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="profileForm" enctype="multipart/form-data">
              <div class="input-field">
                <input id="name" name="name" type="text" class="validate" required value="<?php echo htmlspecialchars($user['name']); ?>">
                <label for="name" class="active"><i class="fa fa-user"></i> Full Name</label>
              </div>
              <div class="input-field">
                <input id="email" name="email" type="email" class="validate" required value="<?php echo htmlspecialchars($user['email']); ?>">
                <label for="email" class="active"><i class="fa fa-envelope"></i> Email</label>
              </div>
              <div class="input-field">
                <input id="phone" name="phone" type="text" class="validate" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                <label for="phone" class="active"><i class="fa fa-phone"></i> Phone</label>
              </div>
              <div class="input-field">
                <input id="address" name="address" type="text" class="validate" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
                <label for="address" class="active"><i class="fa fa-map-marker-alt"></i> Address</label>
              </div>
              <div class="input-field">
                <textarea id="about" name="about" class="materialize-textarea"><?php echo htmlspecialchars($user['about'] ?? ''); ?></textarea>
                <label for="about" class="active"><i class="fa fa-info-circle"></i> About Me</label>
              </div>
              <div class="input-field">
                <div style="margin-bottom:8px;">Profile Photo</div>
                <input type="file" name="profile_image" accept="image/*">
              </div>
              <div class="input-field center-align action-btns">
                <button class="btn waves-effect waves-light teal lighten-1" type="submit" name="update_profile">
                  Update Profile <i class="fa fa-save"></i>
                </button>
                <button class="btn red lighten-1 delete-btn" type="submit" name="delete_profile" onclick="return confirm('Are you sure you want to delete your profile? This cannot be undone!')">
                  Delete Profile <i class="fa fa-trash"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Materialize JS and jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    $(document).ready(function(){
      M.updateTextFields();
    });
  </script>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>