<?php
include '../includes/db.php';
if (!isset($_GET['id'])) {
    header("Location: tours.php");
    exit;
}
$tour_id = intval($_GET['id']);

// Fetch tour data
$sql = "SELECT * FROM tours WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tour_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<h4>Tour not found!</h4>";
    exit;
}
$tour = $result->fetch_assoc();

// Handle booking
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_now']) && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $tour_date = $_POST["tour_date"];
    $num_people = intval($_POST["num_people"]);
    $sql = "INSERT INTO booking (user_id, item_id, item_type, booking_date, num_of_people)
            VALUES (?, ?, 'tour', ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $user_id, $tour_id, $tour_date, $num_people);
    if ($stmt->execute()) {
        $success = "Tour booked successfully!";
    } else {
        $error = "Booking failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=htmlspecialchars($tour['name'])?> | TripWave</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f9f9f9; }
        .tour-container { max-width: 900px; margin: 30px auto; }
        .tour-img { width: 100%; max-width: 450px; height: 250px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 24px #aaa1;}
        .details { margin-left: 2rem; }
        @media (max-width: 800px) {
            .details { margin-left: 0; }
            .tour-img { max-width: 100%; }
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="tour-container card-panel">
    <div class="row">
        <div class="col s12 m6">
            <img src="/tripwave/<?=htmlspecialchars($tour['image_url'])?>" alt="<?=htmlspecialchars($tour['name'])?>" class="tour-img">
        </div>
        <div class="col s12 m6 details">
            <h3 class="teal-text"><?=htmlspecialchars($tour['name'])?></h3>
            <p><?=nl2br(htmlspecialchars($tour['description']))?></p>
            <p><strong>Duration:</strong> <?=htmlspecialchars($tour['duration'])?></p>
            <p><strong>Price:</strong> Rs <?=number_format($tour['price'],2)?></p>
        </div>
    </div>
    <hr>
    <h5 class="teal-text" style="margin-top:1rem;">Book This Tour</h5>
    <?php if($success): ?><div class="card-panel green lighten-3"><?=$success?></div><?php endif; ?>
    <?php if($error): ?><div class="card-panel red lighten-3"><?=$error?></div><?php endif; ?>
    <?php if(!isset($_SESSION["user_id"])): ?>
        <p><a href="/tripwave/pages/login.php">Login</a> to book this tour.</p>
    <?php else: ?>
    <form method="post" style="max-width:350px;">
        <div class="input-field">
            <input type="date" name="tour_date" required>
            <label for="tour_date">Select Date</label>
        </div>
        <div class="input-field">
            <input type="number" name="num_people" min="1" max="15" value="1" required>
            <label for="num_people">Number of People</label>
        </div>
        <button type="submit" name="book_now" class="btn teal">Book Now</button>
    </form>
    <?php endif; ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>