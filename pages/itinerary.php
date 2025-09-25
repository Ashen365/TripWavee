<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION["user_id"];

// Fetch all bookings for this user, order by date/time
$stmt = $conn->prepare("SELECT * FROM booking WHERE user_id = ? ORDER BY booking_date ASC, booking_time ASC, id ASC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Helper: get item name & location
function getItemDetails($conn, $item_id, $item_type) {
    $name = "Unknown"; $location = "-";
    if ($item_type == 'hotel') {
        $sql = "SELECT name, location FROM hotels WHERE id=?";
    } elseif ($item_type == 'restaurant') {
        $sql = "SELECT name, address as location FROM restaurants WHERE id=?";
    } elseif ($item_type == 'tour') {
        $sql = "SELECT name, '' as location FROM tours WHERE id=?";
    } elseif ($item_type == 'activity') {
        $sql = "SELECT name, location FROM activities WHERE id=?";
    } else {
        return ["Unknown", "-"];
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $name = $row['name'];
        $location = $row['location'];
    }
    return [$name, $location];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Itinerary - TripWave</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f9f9f9; }
        .itinerary-table { margin-top: 36px; }
        .page-header { font-size: 2rem; margin-bottom: 20px; color: #009688; font-weight: 700;}
        .no-itinerary { margin-top: 60px; font-size: 1.4rem; color: #666;}
        th, td { text-align: center; }
    </style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="container itinerary-table">
    <div class="page-header"><i class="fa fa-route"></i> Your Trip Itinerary</div>
    <?php if ($result->num_rows > 0): ?>
    <table class="striped responsive-table z-depth-1">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Time</th>
                <th>Type</th>
                <th>Name</th>
                <th>Location</th>
                <th>People</th>
            </tr>
        </thead>
        <tbody>
        <?php $i=1; while ($row = $result->fetch_assoc()): 
            list($name, $location) = getItemDetails($conn, $row['item_id'], $row['item_type']);
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                <td><?php echo $row['booking_time'] ? htmlspecialchars($row['booking_time']) : '-'; ?></td>
                <td style="text-transform:capitalize;"><?php echo htmlspecialchars($row['item_type']); ?></td>
                <td><?php echo htmlspecialchars($name); ?></td>
                <td><?php echo htmlspecialchars($location); ?></td>
                <td><?php echo htmlspecialchars($row['num_of_people']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="no-itinerary">You have not planned any trips yet.</div>
    <?php endif; ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>