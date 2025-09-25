<?php
include '../includes/db.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM tours WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$param = "%$search%";
$stmt->bind_param("s", $param);
$stmt->execute();
$tours = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tours | TripWave</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;500&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f9f9f9; }
    .tour-card { margin-bottom: 2rem; }
    .tour-img { width: 100%; max-width: 350px; height: 180px; object-fit: cover; border-radius: 8px; }
    .tour-info { padding-left: 2rem; }
    .search-bar { margin: 2rem 0 1.5rem 0; }
    .rating { color:#fc0;font-weight:bold;margin-left:12px; }
    @media (max-width: 600px) {
      .tour-info { padding-left: 0; }
      .tour-img { max-width: 100%; height: 140px; }
    }
  </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container">
  <h3 class="teal-text page-header"><i class="fa fa-map-marked-alt"></i> Explore Tours</h3>
  <form method="get" class="search-bar">
    <div class="input-field">
      <input type="text" name="search" placeholder="Search tours..." value="<?=htmlspecialchars($search)?>">
      <button type="submit" class="btn teal"><i class="fa fa-search"></i></button>
    </div>
  </form>

  <?php if($tours->num_rows > 0): ?>
    <?php while($row = $tours->fetch_assoc()): ?>
      <div class="card white z-depth-1 tour-card">
        <div class="card-content row">
          <div class="col s12 m4">
            <img src="/tripwave/<?=htmlspecialchars($row['image_url'])?>" alt="<?=htmlspecialchars($row['name'])?>" class="tour-img">
          </div>
          <div class="col s12 m8 tour-info">
            <h5 class="teal-text"><?=htmlspecialchars($row['name'])?></h5>
            <?php if (isset($row['rating'])): ?>
              <span class="rating"><i class="fa fa-star"></i> <?=number_format($row['rating'],1)?></span>
            <?php endif; ?>
            <p><?=htmlspecialchars($row['description'])?></p>
            <a href="tour_detail.php?id=<?=$row['id']?>" class="btn teal">View Details</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No tours found.</p>
  <?php endif; ?>
</div>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>