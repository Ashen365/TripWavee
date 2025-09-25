<?php
session_start();
require_once("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Handle Delete
if (isset($_POST['delete_booking']) && is_numeric($_POST['booking_id'])) {
    $del_id = intval($_POST['booking_id']);
    $stmt = $conn->prepare("DELETE FROM booking WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $del_id, $user_id);
    $stmt->execute();
    header("Location: booking.php");
    exit();
}

// Handle Update
$update_success = "";
if (isset($_POST['update_booking']) && is_numeric($_POST['booking_id'])) {
    $upd_id = intval($_POST['booking_id']);
    $date = $_POST['booking_date'];
    $time = $_POST['booking_time'] ?? null;
    $num = intval($_POST['num_of_people']);
    $stmt = $conn->prepare("UPDATE booking SET booking_date=?, booking_time=?, num_of_people=? WHERE id=? AND user_id=?");
    $stmt->bind_param("ssiii", $date, $time, $num, $upd_id, $user_id);
    if($stmt->execute()) $update_success = "Booking updated!";
}

// Fetch bookings for the logged-in user
$stmt = $conn->prepare("SELECT * FROM booking WHERE user_id = ? ORDER BY booking_date DESC, id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// For displaying item names & extra info
function getItemDetails($conn, $item_id, $item_type) {
    if ($item_type == 'hotel') {
        $sql = "SELECT name FROM hotels WHERE id=?";
    } elseif ($item_type == 'restaurant') {
        $sql = "SELECT name FROM restaurants WHERE id=?";
    } elseif ($item_type == 'tour') {
        $sql = "SELECT name FROM tours WHERE id=?";
    } elseif ($item_type == 'activity') {
        $sql = "SELECT name FROM activities WHERE id=?";
    } else {
        return "Unknown";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        return $row['name'];
    }
    return "Unknown";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Bookings - TripWave</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f9f9f9; }
        .booking-table { margin-top: 36px; }
        .table-header { font-size: 2rem; margin-bottom: 20px; color: #009688; font-weight: 700;}
        .no-bookings { margin-top: 60px; font-size: 1.4rem; color: #666;}
        th, td { text-align: center; }
        .btn-action { min-width: 80px; margin: 0 2px; }
        .modal { max-width: 400px; }
    </style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="container booking-table">
    <div class="table-header">Your Bookings</div>
    <?php if ($update_success): ?><div class="card-panel green lighten-3"><?=$update_success?></div><?php endif; ?>
    <?php if ($result->num_rows > 0): ?>
    <table class="striped responsive-table z-depth-1">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Name</th>
                <th>Booking Date</th>
                <th>Time</th>
                <th>Number of People</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td style="text-transform:capitalize;"><?php echo htmlspecialchars($row['item_type']); ?></td>
                <td><?php echo htmlspecialchars(getItemDetails($conn, $row['item_id'], $row['item_type'])); ?></td>
                <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                <td><?php echo isset($row['booking_time']) ? htmlspecialchars($row['booking_time']) : '-'; ?></td>
                <td><?php echo htmlspecialchars($row['num_of_people']); ?></td>
                <td>
                  <!-- Update Button (Modal Trigger) -->
                  <a class="btn-small teal btn-action modal-trigger" href="#updateBooking<?=$row['id']?>">Update</a>
                  <!-- Delete Button (Form) -->
                  <form method="post" style="display:inline;">
                    <input type="hidden" name="booking_id" value="<?=$row['id']?>">
                    <button type="submit" name="delete_booking" class="btn-small red btn-action" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</button>
                  </form>
                  <!-- Update Modal -->
                  <div id="updateBooking<?=$row['id']?>" class="modal">
                    <div class="modal-content">
                      <h5 class="teal-text">Update Booking</h5>
                      <form method="post">
                        <input type="hidden" name="booking_id" value="<?=$row['id']?>">
                        <div class="input-field">
                          <input type="date" name="booking_date" value="<?php echo htmlspecialchars($row['booking_date']); ?>" required>
                          <label class="active">Booking Date</label>
                        </div>
                        <div class="input-field">
                          <input type="time" name="booking_time" value="<?php echo htmlspecialchars($row['booking_time']); ?>">
                          <label class="active">Time</label>
                        </div>
                        <div class="input-field">
                          <input type="number" name="num_of_people" min="1" value="<?php echo htmlspecialchars($row['num_of_people']); ?>" required>
                          <label class="active">Number of People</label>
                        </div>
                        <button type="submit" name="update_booking" class="btn teal">Save</button>
                      </form>
                    </div>
                  </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="no-bookings">You have not made any bookings yet.</div>
    <?php endif; ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var modals = document.querySelectorAll('.modal');
  M.Modal.init(modals);
});
</script>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>