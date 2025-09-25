<?php
include("includes/header.php");
include 'includes/db.php';

// Get Top 3 Rated from each category
$tours = $conn->query("SELECT * FROM tours ORDER BY rating DESC LIMIT 3");
$hotels = $conn->query("SELECT * FROM hotels ORDER BY rating DESC LIMIT 3");
$restaurants = $conn->query("SELECT * FROM restaurants ORDER BY rating DESC LIMIT 3");
$activities = $conn->query("SELECT * FROM activities ORDER BY rating DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TripWave - Explore Kandy</title>
  <!-- Materialize CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!-- Poppins font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f6f8fa; }
    .hero-wrapper {
      width: 100vw;
      margin-left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(rgba(20, 50, 60, 0.44),rgba(0,0,0,0.18)), url('assets/images/kandy.jpg') center/cover no-repeat;
      min-height: 500px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      box-shadow: 0 6px 32px 0 rgba(0,0,0,0.13), 0 1.5px 8px 0 rgba(0,0,0,0.09);
      border-radius: 0 0 40px 40px;
      overflow: hidden;
      animation: fadeInHero 2s cubic-bezier(.4,0,.2,1);
    }
    @keyframes fadeInHero { from { opacity: 0; transform: translateY(-50px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .hero-content {
      color: #fff;
      text-align: center;
      z-index: 2;
      padding: 50px 24px 56px 24px;
      width: 100%;
      max-width: 700px;
      margin: 0 auto;
      background: rgba(9, 48, 55, 0.25);
      border-radius: 22px;
      box-shadow: 0 6px 32px 0 rgba(0,0,0,0.12);
      backdrop-filter: blur(1.5px);
    }
    .hero-content h1 {
      font-size: 3.4rem;
      font-weight: 800;
      letter-spacing: -2px;
      margin-bottom: 20px;
      text-shadow: 0 6px 32px #222, 0 1.5px 8px #000;
    }
    .hero-content h5 {
      font-size: 1.45rem;
      font-weight: 400;
      margin-bottom: 34px;
      color: #f8f8f8;
      text-shadow: 0px 2px 8px #333;
    }
    .hero-content .btn-large {
      font-size: 1.3rem;
      padding: 0 2.3rem;
      border-radius: 30px;
      font-weight: 600;
      letter-spacing: 1px;
      background: linear-gradient(90deg,#009688 70%,#00796b 100%);
      box-shadow: 0 4px 24px rgba(0,150,136,0.16);
      transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
      border: none;
    }
    .hero-content .btn-large:hover {
      background: linear-gradient(90deg,#00796b 60%,#009688 100%);
      box-shadow: 0 8px 36px rgba(0,150,136,0.28);
      transform: translateY(-3px) scale(1.04);
    }
    .hero-content .fa-search {
      margin-right: 8px;
    }
    /* Features Section */
    .features { margin-top: 40px; }
    .feature-icon { font-size: 2.5rem; color: #00796b; margin-bottom: 10px; }
    .feature-card { transition: transform .3s cubic-bezier(.4,0,.2,1), box-shadow .3s; }
    .feature-card:hover { transform: translateY(-8px) scale(1.04); box-shadow: 0 8px 32px rgba(0,0,0,0.12);}
    .feature-link { text-decoration: none !important; color: inherit !important; display: block;}
    .feature-link:focus, .feature-link:hover { outline: none; }
    footer { background: #00796b; color: #fff; }
    .rating { color:#fc0; font-weight:bold; margin-left:8px; }
    .top-section-title { margin-top:3rem; margin-bottom:1.2rem; font-weight:700; }
    .card img { width: 100%; height: 170px; object-fit:cover; border-radius: 8px 8px 0 0;}
    .card-title { background:rgba(0,0,0,0.54); border-radius:0 0 8px 8px; font-size: 1.12rem; padding: 4px 10px;}
    .card-content p { margin: 0.45rem 0 0 0; }
    @media (max-width: 600px) {
      .hero-content h1 { font-size: 2.1rem; }
      .hero-wrapper { min-height: 340px; border-radius: 0 0 20px 20px;}
      .hero-content { padding: 32px 6px 40px 6px; }
      .top-section-title { font-size:1.3rem; }
      .card img { height: 110px;}
    }
  </style>
</head>
<body>
  <!-- Hero Section -->
  <div class="hero-wrapper">
    <div class="hero-content">
      <h1>Welcome to TripWave</h1>
      <h5>Plan your perfect trip to Sri Lanka</h5>
      <a href="pages/search.php" class="btn-large waves-effect waves-light teal lighten-1 pulse">
        <i class="fa fa-search left"></i> START EXPLORING
      </a>
    </div>
  </div>
  <!-- Features Section -->
  <div class="container features">
    <div class="row">
      <div class="col s12 m4">
        <a href="pages/hotel.php" class="feature-link">
          <div class="card feature-card center-align z-depth-2">
            <div class="card-content">
              <span class="feature-icon"><i class="fa fa-hotel"></i></span>
              <h6>Hotels</h6>
              <p>Find and book beautiful stays with real reviews and photos.</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col s12 m4">
        <a href="pages/restaurants.php" class="feature-link">
          <div class="card feature-card center-align z-depth-2">
            <div class="card-content">
              <span class="feature-icon"><i class="fa fa-utensils"></i></span>
              <h6>Local Food</h6>
              <p>Discover the best vegetarian-friendly restaurants in Sri Lanka.</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col s12 m4">
        <a href="pages/tours.php" class="feature-link">
          <div class="card feature-card center-align z-depth-2">
            <div class="card-content">
              <span class="feature-icon"><i class="fa fa-map-marked-alt"></i></span>
              <h6>Attractions & Tours</h6>
              <p>Book city tours, temple visits, and more with one click.</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col s12 m4">
        <a href="pages/activities.php" class="feature-link">
          <div class="card feature-card center-align z-depth-2">
            <div class="card-content">
              <span class="feature-icon"><i class="fa fa-person-hiking"></i></span>
              <h6>Activities</h6>
              <p>Discover and book thrilling adventures, cultural experiences, and outdoor activities to make your trip unforgettable.</p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <!-- Top Rated Tours -->
  <div class="container">
    <h4 class="teal-text top-section-title">Top Rated Tours</h4>
    <div class="row">
    <?php while($t = $tours->fetch_assoc()): ?>
      <div class="col s12 m4">
        <div class="card z-depth-2">
          <div class="card-image">
            <img src="/tripwave/<?=htmlspecialchars($t['image_url'])?>" alt="<?=htmlspecialchars($t['name'])?>">
            <span class="card-title"><?=htmlspecialchars($t['name'])?></span>
          </div>
          <div class="card-content">
            <span class="rating"><i class="fa fa-star"></i> <?=number_format($t['rating'],1)?></span>
            <p><?=htmlspecialchars(substr($t['description'],0,70))?>...</p>
          </div>
          <div class="card-action">
            <a href="pages/tour_detail.php?id=<?=$t['id']?>" class="teal-text">See Details</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>

    <!-- Top Rated Hotels -->
    <h4 class="teal-text top-section-title">Top Rated Hotels</h4>
    <div class="row">
    <?php while($h = $hotels->fetch_assoc()): ?>
      <div class="col s12 m4">
        <div class="card z-depth-2">
          <div class="card-image">
            <img src="/tripwave/<?=htmlspecialchars($h['image'])?>" alt="<?=htmlspecialchars($h['name'])?>">
            <span class="card-title"><?=htmlspecialchars($h['name'])?></span>
          </div>
          <div class="card-content">
            <span class="rating"><i class="fa fa-star"></i> <?=number_format($h['rating'],1)?></span>
            <p><?=htmlspecialchars(substr($h['description'],0,70))?>...</p>
          </div>
          <div class="card-action">
            <a href="pages/hotel.php?id=<?=$h['id']?>" class="teal-text">See Details</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>

    <!-- Top Rated Restaurants -->
    <h4 class="teal-text top-section-title">Top Rated Restaurants</h4>
    <div class="row">
    <?php while($r = $restaurants->fetch_assoc()): ?>
      <div class="col s12 m4">
        <div class="card z-depth-2">
          <div class="card-image">
            <img src="/tripwave/<?=htmlspecialchars($r['image_url'])?>" alt="<?=htmlspecialchars($r['name'])?>">
            <span class="card-title"><?=htmlspecialchars($r['name'])?></span>
          </div>
          <div class="card-content">
            <span class="rating"><i class="fa fa-star"></i> <?=number_format($r['rating'],1)?></span>
            <p><?=htmlspecialchars(substr($r['description'],0,70))?>...</p>
          </div>
          <div class="card-action">
            <a href="pages/restaurant_detail.php?id=<?=$r['id']?>" class="teal-text">See Details</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>

    <!-- Top Rated Activities -->
    <h4 class="teal-text top-section-title">Top Rated Activities</h4>
    <div class="row">
    <?php while($a = $activities->fetch_assoc()): ?>
      <div class="col s12 m4">
        <div class="card z-depth-2">
          <div class="card-image">
            <img src="/tripwave/<?=htmlspecialchars($a['image_url'])?>" alt="<?=htmlspecialchars($a['name'])?>">
            <span class="card-title"><?=htmlspecialchars($a['name'])?></span>
          </div>
          <div class="card-content">
            <span class="rating"><i class="fa fa-star"></i> <?=number_format($a['rating'],1)?></span>
            <p><?=htmlspecialchars(substr($a['description'],0,70))?>...</p>
          </div>
          <div class="card-action">
            <a href="pages/activities_details.php?id=<?=$a['id']?>" class="teal-text">See Details</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>
  </div>
  <!-- Footer -->
  <?php include("includes/footer.php"); ?>
  <!-- Materialize JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>