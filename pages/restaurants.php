<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/db.php'; // Use your single connection file
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Restaurants | TripWave</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;500&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f9f9f9; }
    .page-header { margin-top: 2.5rem; }
    .restaurant-card { margin-bottom: 2rem; }
    .restaurant-img { width: 100%; max-width: 350px; height: 180px; object-fit: cover; border-radius: 8px; }
    .card-content h5 { margin-top: 0.5rem; }
    .restaurant-info { padding-left: 2rem; }
    .no-restaurants { margin: 3rem 0; text-align: center; color: #888; }
    .details-btn { margin-top: 1rem; }
    .rating { color:#fc0;font-weight:bold;margin-left:12px; }
    @media (max-width: 600px) {
      .restaurant-info { padding-left: 0; }
      .restaurant-img { max-width: 100%; height: 140px; }
    }
  </style>
</head>
<body>
  <?php include '../includes/header.php'; ?>
  <div class="container">
    <h3 class="teal-text page-header"><i class="fa fa-utensils"></i> Our Super Restaurants – A Journey of Flavors</h3>

    <?php
    $sql = "SELECT * FROM restaurants";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0): 
      while($row = mysqli_fetch_assoc($result)):
    ?>
        <div class="card white z-depth-1 restaurant-card">
          <div class="card-content row">
            <div class="col s12 m4">
              <img src="/tripwave/<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="restaurant-img">
            </div>
            <div class="col s12 m8 restaurant-info">
              <h5 class="teal-text"><?php echo htmlspecialchars($row['name']); ?></h5>
              <?php if (isset($row['rating'])): ?>
                <span class="rating"><i class="fa fa-star"></i> <?=number_format($row['rating'],1)?></span>
              <?php endif; ?>
              <p><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['address']); ?></p>
              <p><?php echo htmlspecialchars($row['description']); ?></p>
              <a href="restaurant_detail.php?id=<?php echo $row['id']; ?>" class="btn teal details-btn">Click here</a>
            </div>
          </div>
        </div>
    <?php 
      endwhile; 
    else: 
    ?>
      <div class="no-restaurants">
        <i class="fa fa-utensils fa-3x teal-text"></i>
        <h5>No restaurants found.</h5>
        <p>We are working on building a platform for exploring and reviewing restaurants.</p>
      </div>
    <?php endif; ?>

  </div>
    <!-- Footer -->
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
<?php
// mysqli_close($conn);
?>