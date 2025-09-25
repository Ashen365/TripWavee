<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/db.php';

// Handle language switching
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Language labels
$lang_labels = [
    'en' => 'English',
    'si' => 'සිංහල',
    'ta' => 'தமிழ்'
];

// Handle new post
$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $post_text = trim($_POST["post_text"]);
    $post_lang = $_POST["post_lang"];
    if ($post_text !== "" && in_array($post_lang, array_keys($lang_labels))) {
        $sql = "INSERT INTO community_posts (user_id, post_text, language, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $post_text, $post_lang);
        if ($stmt->execute()) {
            $success = "Post shared successfully!";
        } else {
            $error = "Failed to share your post.";
        }
    } else {
        $error = "Please write something and select a language.";
    }
}

// Fetch posts - FIXED: use u.name AS username
$stmt = $conn->prepare("SELECT p.*, u.name AS username FROM community_posts p LEFT JOIN users u ON p.user_id = u.id WHERE p.language = ? ORDER BY p.created_at DESC");
$stmt->bind_param("s", $lang);
$stmt->execute();
$posts = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviews & Community | TripWave</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f9f9f9;}
        .lang-switch { margin: 2rem 0 1.8rem 0; text-align: right;}
        .lang-switch a { margin-left: 12px; font-weight: 600;}
        .community-form { margin-bottom: 2rem; }
        .post-card { margin-bottom: 1.5rem; }
        .post-meta { font-size: 0.95em; color: #888;}
        .no-posts { text-align:center; color: #aaa; margin-top: 2.5rem;}
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container">
    <h3 class="teal-text page-header"><i class="fa fa-users"></i> Reviews & Community</h3>

    <div class="lang-switch">
        <?php foreach($lang_labels as $k => $label): ?>
            <a href="?lang=<?=$k?>" class="btn-small <?=($lang==$k?'teal white-text':'white teal-text')?>"><?=$label?></a>
        <?php endforeach; ?>
    </div>

    <?php if($success): ?><div class="card-panel green lighten-4"><?= $success ?></div><?php endif; ?>
    <?php if($error): ?><div class="card-panel red lighten-4"><?= $error ?></div><?php endif; ?>

    <?php if(isset($_SESSION["user_id"])): ?>
    <form method="post" class="card-panel community-form">
        <div class="input-field">
            <textarea name="post_text" class="materialize-textarea" required maxlength="1000"></textarea>
            <label for="post_text">Share your travel review, tip, question, or story...</label>
        </div>
        <input type="hidden" name="post_lang" value="<?=htmlspecialchars($lang)?>">
        <button type="submit" class="btn teal">Post</button>
    </form>
    <?php else: ?>
        <div class="card-panel yellow lighten-4">
            <a href="/tripwave/pages/login.php">Login</a> to share your review or start a community discussion.
        </div>
    <?php endif; ?>

    <?php if($posts->num_rows > 0): ?>
        <?php while($post = $posts->fetch_assoc()): ?>
            <div class="card post-card">
                <div class="card-content">
                    <p><?=nl2br(htmlspecialchars($post['post_text']))?></p>
                </div>
                <div class="card-action post-meta">
                    <span><i class="fa fa-user"></i> <?=htmlspecialchars($post['username']?:'User')?></span> &nbsp;•&nbsp;
                    <span><i class="fa fa-clock"></i> <?=date("Y-m-d H:i", strtotime($post['created_at']))?></span>
                    <span class="right teal-text"><?=strtoupper($lang_labels[$post['language']])?></span>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-posts">
            <i class="fa fa-users fa-2x"></i><br>
            No posts yet for this language.
        </div>
    <?php endif; ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <?php include("../includes/footer.php"); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>