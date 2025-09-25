<?php
session_start();
require_once("../includes/db.php");
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: search.php");
    exit();
}
$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM hotels WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if (!$hotel = $result->fetch_assoc()) {
    header("Location: search.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($hotel['name']); ?> - TripWave</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f6f8fa; }
    .details-header { margin-top: 40px; }
    .hotel-img-lg { width: 100%; max-height: 360px; object-fit: cover; border-radius: 22px; box-shadow: 0 6px 32px rgba(0,0,0,0.12);}
    .hotel-meta { margin: 18px 0; }
    .hotel-type-badge { padding: 3px 14px; border-radius: 10px; font-size: 1.1em; background: #e0f2f1; color: #00796b; margin-right: 10px;}
    .veg-badge { background: #dcedc8; color: #33691e; }
    .rating { color: #fc0; font-weight: bold; margin-left: 12px;}
    .desc-block { margin-top: 18px; }
    .back-link { margin-bottom: 18px; display: inline-block;}
    .book-btn { margin-top: 28px; }
    @media (max-width: 600px) {
      .hotel-img-lg { max-height: 180px; }
      .details-header { margin-top: 18px; }
    }
  </style>
</head>
<body>
  <?php include("../includes/header.php"); ?>
  <div class="container details-header">
    <a href="search.php" class="back-link teal-text"><i class="fa fa-arrow-left"></i> Back to search</a>
    <img src="<?php echo htmlspecialchars($hotel['image'] ?: '../assets/images/default-hotel.jpg'); ?>" class="hotel-img-lg" alt="<?php echo htmlspecialchars($hotel['name']); ?>">
    <h3 style="font-weight:700;margin-top:24px;"><?php echo htmlspecialchars($hotel['name']); ?></h3>
    <div class="hotel-meta">
      <span class="hotel-type-badge"><?php echo htmlspecialchars($hotel['hotel_type']); ?></span>
      <?php if ($hotel['vegetarian_friendly'] == 'Yes'): ?>
        <span class="hotel-type-badge veg-badge"><i class="fa fa-seedling"></i> Vegetarian</span>
      <?php endif; ?>
      <span class="rating"><i class="fa fa-star"></i> <?php echo number_format($hotel['rating'],1); ?></span>
    </div>
    <div class="desc-block">
      <h6>Description</h6>
      <p><?php echo nl2br(htmlspecialchars($hotel['description'])); ?></p>
    </div>
    <button class="btn btn-large waves-effect waves-light teal lighten-1 book-btn">
      <i class="fa fa-bed left"></i> Book Now
    </button>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>