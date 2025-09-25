<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: restaurants.php");
    exit;
}
$restaurant_id = intval($_GET['id']);

// Fetch restaurant data
$sql = "SELECT * FROM restaurants WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $restaurant_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<h4>Restaurant not found!</h4>";
    exit;
}
$row = $result->fetch_assoc();

// Fetch menu images from DB for this restaurant
$menu_images = [];
$sqlimg = "SELECT image_url, caption FROM menu_images WHERE restaurant_id = ?";
$stmtimg = $conn->prepare($sqlimg);
$stmtimg->bind_param("i", $restaurant_id);
$stmtimg->execute();
$resimg = $stmtimg->get_result();
while($imgrow = $resimg->fetch_assoc()) {
    $menu_images[] = $imgrow;
}

// Handle booking form submission
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_submit']) && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $booking_date = $_POST["booking_date"];
    $booking_time = $_POST["booking_time"];
    $num_of_people = intval($_POST["num_of_people"]);
    $sql = "INSERT INTO booking (user_id, item_id, item_type, booking_date, booking_time, num_of_people)
            VALUES (?, ?, 'restaurant', ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $user_id, $restaurant_id, $booking_date, $booking_time, $num_of_people);
    if ($stmt->execute()) {
        $success = "Booking successful!";
    } else {
        $error = "Booking failed. Please try again.";
    }
}

// Dummy reviews (replace with DB fetch in production)
$reviews = [
    ["name"=>"Jane", "stars"=>5, "comment"=>"Amazing food and cozy atmosphere!"],
    ["name"=>"Ravi", "stars"=>4, "comment"=>"Great seafood, will visit again."],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($row['name']); ?> | TripWave</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;500&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f9f9f9; }
    .detail-container { max-width: 900px; margin: 30px auto 0 auto; }
    .detail-img { width: 100%; max-width: 430px; height: 260px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 24px #aaa1; }
    .facilities .chip { margin-right: 8px; }
    .map-container { margin-top: 1.5rem; border-radius: 10px; overflow: hidden; }
    .menu-gallery img { width: 110px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 8px; margin-bottom: 8px; }
    .review-star { color: #FFD600; }
    @media (max-width: 800px) {
      .detail-container { padding: 8px; }
      .detail-img { max-width: 100%; }
    }
  </style>
</head>
<body>
  <?php include '../includes/header.php'; ?>
  <div class="detail-container">
    <h3 class="teal-text"><?php echo htmlspecialchars($row['name']); ?></h3>
    <div class="row">
      <div class="col s12 m6">
        <img src="/tripwave/<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="detail-img z-depth-2">
        <div class="facilities" style="margin:14px 0;">
          <span class="chip teal white-text">Wi-Fi</span>
          <span class="chip teal white-text">Parking</span>
          <span class="chip teal white-text">Vegetarian Options</span>
        </div>
        <div style="margin:12px 0;">
          <a href="tel:<?php echo htmlspecialchars($row['contact']); ?>" class="btn-small teal"><i class="fa fa-phone"></i> Call Now</a>
          <a href="https://www.google.com/maps/search/<?php echo urlencode($row['address']); ?>" target="_blank" class="btn-small teal"><i class="fa fa-map-marker-alt"></i> Get Directions</a>
        </div>
      </div>
      <div class="col s12 m6">
        <p><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['address']); ?></p>
        <p><?php echo htmlspecialchars($row['description']); ?></p>
        <p><strong>Contact:</strong> <?php echo htmlspecialchars($row['contact']); ?></p>
        <p><strong>Type:</strong> <?php echo htmlspecialchars($row['type']); ?></p>
        <div class="menu-gallery" style="margin-top:18px; display:flex; gap:10px;">
          <h6 class="teal-text" style="margin-bottom:8px;">Menu Highlights</h6>
          <?php if(count($menu_images) > 0): ?>
            <?php foreach($menu_images as $img): ?>
              <div style="text-align:center;">
                <img src="/tripwave/<?php echo htmlspecialchars($img['image_url']); ?>" alt="<?php echo htmlspecialchars($img['caption']); ?>" style="width:110px; height:80px; object-fit:cover; border-radius:8px;"><br>
                <span style="font-size:13px;"><?php echo htmlspecialchars($img['caption']); ?></span>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div>No menu images available for this restaurant.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="card-panel" style="margin-top:2.5rem;">
      <h5 class="teal-text">Book a Table</h5>
      <?php if($success): ?><div class="card-panel green lighten-3"><?= $success ?></div><?php endif; ?>
      <?php if($error): ?><div class="card-panel red lighten-3"><?= $error ?></div><?php endif; ?>
      <?php if(!isset($_SESSION["user_id"])): ?>
        <p><a href="/tripwave/pages/login.php">Login</a> to book a table.</p>
      <?php else: ?>
      <form method="post">
        <div class="input-field">
          <input type="date" name="booking_date" required>
          <label for="booking_date">Booking Date</label>
        </div>
        <div class="input-field">
          <input type="time" name="booking_time" required>
          <label for="booking_time">Booking Time</label>
        </div>
        <div class="input-field">
          <input type="number" name="num_of_people" min="1" max="20" required>
          <label for="num_of_people">Number of People</label>
        </div>
        <button type="submit" name="booking_submit" class="btn teal">Book Now</button>
      </form>
      <?php endif; ?>
    </div>
    <div class="card-panel" style="margin-top:2.5rem;">
      <h5 class="teal-text">Customer Reviews</h5>
      <?php foreach($reviews as $review): ?>
        <div style="margin-bottom:10px;">
          <strong><?php echo htmlspecialchars($review['name']); ?>:</strong>
          <?php for($i=0;$i<$review['stars'];$i++): ?>
            <i class="fa fa-star review-star"></i>
          <?php endfor; ?>
          <br>
          <?php echo htmlspecialchars($review['comment']); ?>
        </div>
        <hr>
      <?php endforeach; ?>
      <form method="post">
        <div class="input-field">
          <textarea name="review" class="materialize-textarea" required></textarea>
          <label for="review">Write your review</label>
        </div>
        <button type="submit" class="btn-small teal">Submit Review</button>
      </form>
    </div>
    <div class="map-container">
      <h5 class="teal-text">Location Map</h5>
      <iframe src="https://www.google.com/maps?q=<?php echo urlencode($row['address']); ?>&output=embed" width="100%" height="220" style="border:0;" allowfullscreen></iframe>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>