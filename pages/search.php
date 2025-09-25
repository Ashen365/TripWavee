<?php
session_start();
require_once("../includes/db.php");

// Handle search/filter
$where = [];
$params = [];

if (!empty($_GET['query'])) {
    $where[] = "name LIKE ?";
    $params[] = '%' . $_GET['query'] . '%';
}
if (!empty($_GET['hotel_type'])) {
    $where[] = "hotel_type = ?";
    $params[] = $_GET['hotel_type'];
}
if (!empty($_GET['vegetarian'])) {
    $where[] = "vegetarian_friendly = ?";
    $params[] = $_GET['vegetarian'];
}

$sql = "SELECT * FROM hotels";
if ($where) $sql .= " WHERE " . implode(" AND ", $where);

$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$results = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Hotels - TripWave</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f6f8fa; }
    .search-bar { margin: 36px auto 26px auto; max-width: 760px; border-radius: 18px; background: #fff; box-shadow: 0 3px 18px rgba(0,0,0,0.08);}
    .search-bar form { padding: 20px 30px; }
    .hotel-card { border-radius: 18px; box-shadow: 0 3px 18px rgba(0,0,0,0.10); }
    .hotel-img { width: 100%; height: 200px; object-fit: cover; border-radius: 18px 18px 0 0; }
    .hotel-card .card-content { min-height: 130px; }
    .hotel-type-badge { padding: 2px 10px; border-radius: 8px; font-size: 0.95em; background: #e0f2f1; color: #00796b; margin-right: 8px;}
    .veg-badge { background: #dcedc8; color: #33691e; margin-right: 0;}
    .rating { color: #fc0; font-weight: bold; }
    .no-results { text-align: center; color: #888; margin: 40px 0; }
    @media (max-width: 600px) {
      .search-bar form { padding: 14px 5px; }
      .hotel-img { height: 140px; }
    }
  </style>
</head>
<body>
  <?php include("../includes/header.php"); ?>

  <div class="search-bar z-depth-2">
    <form method="get" action="search.php" class="row">
      <div class="input-field col s12 m4">
        <input type="text" name="query" id="query" value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>">
        <label for="query">Search by name...</label>
      </div>
      <div class="input-field col s6 m3">
        <select name="hotel_type">
          <option value="" disabled selected>Hotel Type</option>
          <option value="Boutique" <?php if(($_GET['hotel_type'] ?? '')=='Boutique') echo 'selected'; ?>>Boutique</option>
          <option value="Budget" <?php if(($_GET['hotel_type'] ?? '')=='Budget') echo 'selected'; ?>>Budget</option>
          <option value="Luxury" <?php if(($_GET['hotel_type'] ?? '')=='Luxury') echo 'selected'; ?>>Luxury</option>
        </select>
        <label>Hotel Type</label>
      </div>
      <div class="input-field col s6 m3">
        <select name="vegetarian">
          <option value="" disabled selected>Vegetarian?</option>
          <option value="Yes" <?php if(($_GET['vegetarian'] ?? '')=='Yes') echo 'selected'; ?>>Yes</option>
          <option value="No" <?php if(($_GET['vegetarian'] ?? '')=='No') echo 'selected'; ?>>No</option>
        </select>
        <label>Vegetarian?</label>
      </div>
      <div class="input-field col s12 m2 center-align">
        <button class="btn waves-effect waves-light teal lighten-1" style="margin-top:10px;width:100%;" type="submit">
          <i class="fa fa-search left"></i> Search
        </button>
      </div>
    </form>
  </div>

  <div class="container">
    <div class="row">
      <?php if($results->num_rows > 0): ?>
        <?php while($h = $results->fetch_assoc()): ?>
        <div class="col s12 m6 l4">
          <div class="card hotel-card">
            <div class="card-image">
              <img src="<?php echo '../' . htmlspecialchars($h['image'] ?: 'assets/images/default-hotel.jpg'); ?>" alt="<?php echo htmlspecialchars($h['name']); ?>" class="hotel-img">
              <span class="card-title" style="background:rgba(0,0,0,0.44);border-radius:12px;padding:6px 14px;"><?php echo htmlspecialchars($h['name']); ?></span>
            </div>
            <div class="card-content">
              <span class="hotel-type-badge"><?php echo htmlspecialchars($h['hotel_type']); ?></span>
              <?php if ($h['vegetarian_friendly'] == 'Yes'): ?>
                <span class="hotel-type-badge veg-badge"><i class="fa fa-seedling"></i> Vegetarian</span>
              <?php endif; ?>
              <span class="rating"><i class="fa fa-star"></i> <?php echo number_format($h['rating'],1); ?></span>
              <p style="margin-top:8px;"><?php echo htmlspecialchars(substr($h['description'],0,90)); ?>...</p>
            </div>
<div class="card-action">
  <a href="hotel_details.php?id=<?php echo $h['id']; ?>" class="teal-text">View Details</a>
</div>
          </div>
        </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col s12"><div class="no-results">No hotels found for your criteria.</div></div>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    $(document).ready(function(){
      $('select').formSelect();
    });
  </script>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>