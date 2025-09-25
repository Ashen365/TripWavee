<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: activities.php");
    exit();
}
$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM activities WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if (!$activity = $result->fetch_assoc()) {
    header("Location: activities.php");
    exit();
}

// Handle booking form submission
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_now']) && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $activity_date = $_POST["activity_date"];
    $num_people = intval($_POST["num_people"]);
    $sql = "INSERT INTO booking (user_id, item_id, item_type, booking_date, num_of_people)
            VALUES (?, ?, 'activity', ?, ?)";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("iisi", $user_id, $id, $activity_date, $num_people);
    if ($stmt2->execute()) {
        $success = "Activity booked successfully!";
    } else {
        $error = "Booking failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($activity['name']); ?> | TripWave</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;500&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f9f9f9; }
    .details-header { margin-top: 40px; }
    .activity-img-lg { width: 100%; max-width: 480px; height: 260px; object-fit: cover; border-radius: 14px; box-shadow: 0 4px 24px #aaa2; margin-bottom: 24px;}
    .back-link { margin-bottom: 18px; display: inline-block;}
    .desc-block { margin-top: 18px; }
    .booking-form { margin-top: 32px; max-width: 350px; }
    @media (max-width: 600px) {
      .activity-img-lg { max-height: 180px; }
      .details-header { margin-top: 18px; }
    }
  </style>
</head>
<body>
  <?php include("../includes/header.php"); ?>
  <div class="container details-header">
    <a href="activities.php" class="back-link teal-text"><i class="fa fa-arrow-left"></i> Back to activities</a>

    <img src="/tripwave/<?php echo htmlspecialchars($activity['image_url']); ?>" 
         alt="<?php echo htmlspecialchars($activity['name']); ?>" 
         class="activity-img-lg">

    <h3 class="teal-text" style="font-weight:700;margin-top:24px;"><?php echo htmlspecialchars($activity['name']); ?></h3>
    <p style="font-size:1.1em;"><i class="fa fa-location-dot"></i> <?php echo htmlspecialchars($activity['location']); ?></p>
    <?php if (isset($activity['rating'])): ?>
      <span class="rating" style="color:#fc0;font-weight:bold;margin-left:14px;">
        <i class="fa fa-star"></i> <?php echo number_format($activity['rating'],1); ?>
      </span>
    <?php endif; ?>
    <div class="desc-block">
      <h6>Description</h6>
      <p><?php echo nl2br(htmlspecialchars($activity['description'])); ?></p>
    </div>
    <hr>
    <h5 class="teal-text" style="margin-top:1.5rem;">Book This Activity</h5>
    <?php if($success): ?><div class="card-panel green lighten-3"><?=$success?></div><?php endif; ?>
    <?php if($error): ?><div class="card-panel red lighten-3"><?=$error?></div><?php endif; ?>
    <?php if(!isset($_SESSION["user_id"])): ?>
      <p><a href="/tripwave/pages/login.php">Login</a> to book this activity.</p>
    <?php else: ?>
    <form method="post" class="booking-form">
      <div class="input-field">
        <input type="date" name="activity_date" required>
        <label for="activity_date">Date</label>
      </div>
      <div class="input-field">
        <input type="number" name="num_people" min="1" max="15" value="1" required>
        <label for="num_people">Number of People</label>
      </div>
      <button type="submit" name="book_now" class="btn teal">Book Now</button>
    </form>
    <?php endif; ?>
  </div>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>