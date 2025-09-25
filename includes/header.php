<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Prepare user photo for navbar (for logged-in user)
$user_photo = "";
if (isset($_SESSION["user_id"])) {
    $user_name = $_SESSION["user_name"];
    $user_photo = (isset($_SESSION["user_photo"]) && $_SESSION["user_photo"])
        ? "/tripwave/assets/images/profiles/" . $_SESSION["user_photo"]
        : "https://ui-avatars.com/api/?name=" . urlencode($user_name) . "&background=009688&color=fff&rounded=true&size=32";
}
?>
<style>
nav {
  position: sticky;
  top: 0;
  z-index: 999;
  background: rgba(255, 255, 255, 0.95) !important;
  -webkit-backdrop-filter: blur(10px);
  backdrop-filter: blur(10px);
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.sticky-nav-shadow {
  box-shadow: 0 4px 18px -6px rgba(0,0,0,0.12), 0 1.5px 8px 0 rgba(0,0,0,0.08);
  background: rgba(255, 255, 255, 0.98) !important;
}
nav .brand-logo {
  font-family: 'Poppins',sans-serif;
  font-weight:700;
  letter-spacing:1px;
  font-size:2rem;
  display:flex;
  align-items:center;
}
nav .brand-logo i {
  margin-right:10px;
  font-size:1.25em;
}
.nav-links-container li a {
  font-weight: 500;
  position: relative;
  transition: color 0.2s ease;
}
.nav-links-container li a::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2.5px;
  bottom: 0;
  left: 50%;
  background-color: #009688;
  transform: translateX(-50%);
  transition: width 0.3s ease;
  border-radius: 2px;
}
.nav-links-container li a:hover::after {
  width: 70%;
}
.profile-nav-img {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #e0f2f1;
  background: #eee;
  margin-right: 8px;
  box-shadow: 0 2px 10px rgba(0, 150, 136, 0.15);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.profile-nav-img:hover {
  transform: scale(1.05);
  box-shadow: 0 3px 12px rgba(0, 150, 136, 0.25);
}
.dropdown-content {
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  transform-origin: top center;
  animation: dropdown-in 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  min-width: 180px !important;
}
.dropdown-content li a {
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  color: #424242 !important;
  padding: 12px 20px;
  transition: all 0.2s ease;
}
.dropdown-content li a:hover {
  background-color: #e0f2f1 !important;
  color: #009688 !important;
}
@keyframes dropdown-in {
  from {
    opacity: 0;
    transform: translateY(-8px) scale(0.98);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}
.sidenav {
  background: #ffffff;
  border-radius: 0 12px 12px 0;
  box-shadow: 0 8px 30px rgba(0,0,0,0.15);
  width: 280px;
}
.sidenav li a {
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  padding: 14px 20px;
  color: #424242;
  transition: all 0.2s ease;
}
.sidenav li a i {
  margin-right: 10px;
  color: #009688;
}
.sidenav li a:hover {
  background-color: #e0f2f1;
  color: #009688;
}
.auth-btn {
  padding: 0 20px;
  height: 36px;
  line-height: 36px;
  font-weight: 600;
  border-radius: 18px;
  text-transform: none;
  letter-spacing: 0.2px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 10px rgba(0, 150, 136, 0.2);
}
.auth-btn.login {
  background-color: #009688;
  color: white;
  margin-left: 12px;
}
.auth-btn.register {
  background-color: transparent;
  color: #009688;
  border: 2px solid #009688;
}
.auth-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0, 150, 136, 0.3);
}
@media (max-width: 992px) {
  nav .brand-logo { 
    font-size:1.45rem; 
    left: 50%;
    transform: translateX(-50%);
  }
  .hide-on-med-and-down {
    display: none !important;
  }
}
</style>
<nav class="white z-depth-0">
  <div class="nav-wrapper container">
    <!-- Logo Left -->
    <a href="/tripwave/index.php" class="brand-logo teal-text">
      <i class="fas fa-globe-asia pulse"></i> TripWave
    </a>
    <!-- Hamburger for mobile -->
    <a href="#" data-target="mobile-menu" class="sidenav-trigger right"><i class="fas fa-bars teal-text"></i></a>
    <!-- Desktop Menu -->
    <ul class="right hide-on-med-and-down nav-links-container" style="font-weight:500;font-size:1.08rem;font-family:'Poppins',sans-serif;">
      <li><a href="/tripwave/index.php" class="teal-text">Home</a></li>
      <li>
        <a class="dropdown-trigger teal-text" href="#!" data-target="use-dropdown">Explore <i class="fas fa-chevron-down right" style="font-size: 0.8rem; margin-left: 2px;"></i></a>
      </li>
      <li><a href="/tripwave/pages/booking.php" class="teal-text">Booking</a></li>
      <li><a href="/tripwave/pages/itinerary.php" class="teal-text">Itinerary</a></li>
      <li>
        <a class="dropdown-trigger teal-text" href="#!" data-target="reviews-dropdown">Community <i class="fas fa-chevron-down right" style="font-size: 0.8rem; margin-left: 2px;"></i></a>
      </li>
      <?php if (isset($_SESSION["user_id"])): ?>
        <li>
          <a href="/tripwave/pages/profile.php" class="teal-text" style="display:flex;align-items:center;gap:6px;font-weight:600;">
            <img src="<?php echo $user_photo; ?>" alt="Profile" class="profile-nav-img" />
            <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
          </a>
        </li>
        <li>
          <a href="/tripwave/pages/logout.php" class="teal-text" style="display:flex;align-items:center;gap:5px;font-weight:600;">
            Logout <i class="fas fa-sign-out-alt" style="font-size:1.14em;"></i>
          </a>
        </li>
      <?php else: ?>
        <li><a href="/tripwave/pages/register.php" class="auth-btn register waves-effect">Register</a></li>
        <li><a href="/tripwave/pages/login.php" class="auth-btn login waves-effect waves-light">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<!-- Dropdown Structures -->
<ul id="use-dropdown" class="dropdown-content">
  <li><a href="/tripwave/pages/tours.php" class="teal-text"><i class="fas fa-route fa-fw"></i> Attractions & Tours</a></li>
  <li><a href="/tripwave/pages/hotel.php" class="teal-text"><i class="fas fa-hotel fa-fw"></i> Hotels</a></li>
  <li><a href="/tripwave/pages/restaurants.php" class="teal-text"><i class="fas fa-utensils fa-fw"></i> Restaurants</a></li>
  <li><a href="/tripwave/pages/activities.php" class="teal-text"><i class="fas fa-hiking fa-fw"></i> Activities</a></li>
</ul>
<ul id="reviews-dropdown" class="dropdown-content">
  <li><a href="/tripwave/pages/community.php?lang=si" class="teal-text"><i class="fas fa-comments fa-fw"></i> Sinhala</a></li>
  <li><a href="/tripwave/pages/community.php?lang=en" class="teal-text"><i class="fas fa-comments fa-fw"></i> English</a></li>
  <li><a href="/tripwave/pages/community.php?lang=ta" class="teal-text"><i class="fas fa-comments fa-fw"></i> Tamil</a></li>
</ul>

<!-- Mobile Sidenav Menu -->
<ul class="sidenav" id="mobile-menu">
  <li class="center-align" style="margin: 20px 0;">
    <a href="/tripwave/index.php" class="teal-text" style="font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; justify-content: center;">
      <i class="fas fa-globe-asia pulse" style="margin-right: 10px;"></i> TripWave
    </a>
  </li>
  <li><div class="divider" style="margin: 10px 0;"></div></li>
  <li><a href="/tripwave/index.php" class="teal-text"><i class="fas fa-home"></i> Home</a></li>
  <li><a href="/tripwave/pages/tours.php" class="teal-text"><i class="fas fa-route"></i> Attractions & Tours</a></li>
  <li><a href="/tripwave/pages/hotel.php" class="teal-text"><i class="fas fa-hotel"></i> Hotels</a></li>
  <li><a href="/tripwave/pages/restaurants.php" class="teal-text"><i class="fas fa-utensils"></i> Restaurants</a></li>
  <li><a href="/tripwave/pages/activities.php" class="teal-text"><i class="fas fa-hiking"></i> Activities</a></li>
  <li><a href="/tripwave/pages/booking.php" class="teal-text"><i class="fas fa-calendar-check"></i> Booking</a></li>
  <li><a href="/tripwave/pages/itinerary.php" class="teal-text"><i class="fas fa-map-marked-alt"></i> Itinerary</a></li>
  <li><div class="divider" style="margin: 10px 0;"></div></li>
  <li><a href="/tripwave/pages/community.php?lang=si" class="teal-text"><i class="fas fa-comments"></i> Reviews (සිංහල)</a></li>
  <li><a href="/tripwave/pages/community.php?lang=en" class="teal-text"><i class="fas fa-comments"></i> Reviews (English)</a></li>
  <li><a href="/tripwave/pages/community.php?lang=ta" class="teal-text"><i class="fas fa-comments"></i> Reviews (தமிழ்)</a></li>
  <?php if (isset($_SESSION["user_id"])): ?>
    <li><div class="divider" style="margin: 10px 0;"></div></li>
    <li>
      <a href="/tripwave/pages/profile.php" class="teal-text" style="display:flex;align-items:center;gap:10px;">
        <img src="<?php echo $user_photo; ?>" alt="Profile" class="profile-nav-img" />
        <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
      </a>
    </li>
    <li><a href="/tripwave/pages/logout.php" class="teal-text"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
  <?php else: ?>
    <li><div class="divider" style="margin: 10px 0;"></div></li>
    <li class="center-align" style="padding: 10px;">
      <a href="/tripwave/pages/register.php" class="waves-effect waves-light btn-small teal lighten-1" style="margin-right: 8px;"><i class="fas fa-user-plus left"></i> Register</a>
      <a href="/tripwave/pages/login.php" class="waves-effect waves-light btn-small teal"><i class="fas fa-sign-in-alt left"></i> Login</a>
    </li>
  <?php endif; ?>
</ul>

<!-- FontAwesome, Materialize, Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var dropdowns = document.querySelectorAll('.dropdown-trigger');
    M.Dropdown.init(dropdowns, {
      coverTrigger: false,
      constrainWidth: false,
      alignment: 'right',
      hover: false,
      inDuration: 250,
      outDuration: 200
    });
    
    var sidenav = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenav, {
      edge: 'right',
      draggable: true,
      inDuration: 250,
      outDuration: 200
    });
  });

  // Add shadow and change opacity when scrolling
  window.addEventListener('scroll', function() {
    var nav = document.querySelector('nav');
    if (window.scrollY > 20) {
      nav.classList.add('sticky-nav-shadow');
    } else {
      nav.classList.remove('sticky-nav-shadow');
    }
  });
  
  // Add pulse animation to globe icon
  document.addEventListener('DOMContentLoaded', function() {
    const pulse = document.querySelector('.pulse');
    
    function addPulseClass() {
      pulse.classList.add('animate__animated', 'animate__pulse');
      setTimeout(() => {
        pulse.classList.remove('animate__animated', 'animate__pulse');
      }, 1000);
    }
    
    // Pulse every 5 seconds
    setInterval(addPulseClass, 5000);
    
    // Initial pulse
    setTimeout(addPulseClass, 2000);
  });
</script>