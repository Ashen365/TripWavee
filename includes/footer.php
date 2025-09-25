<style>
  footer {
    margin-top: 60px;
    border-top: 1px solid #e0e0e0;
    padding-top: 40px;
    background: #ffffff;
  }
  .footer-logo {
    font-weight: 900;
    letter-spacing: 1px;
    color: #009688;
    margin-bottom: 16px;
    display: inline-block;
  }
  .footer-logo i {
    margin-right: 8px;
    animation: float 3s ease-in-out infinite;
  }
  @keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-6px); }
    100% { transform: translateY(0px); }
  }
  .footer-description {
    color: #616161;
    line-height: 1.6;
    font-size: 1.08em;
    margin-bottom: 20px;
  }
  .footer-links-title {
    font-weight: 700;
    margin-bottom: 16px;
    color: #009688;
    position: relative;
    display: inline-block;
  }
  .footer-links-title::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 30px;
    height: 3px;
    background-color: #009688;
    border-radius: 2px;
  }
  .footer-links {
    list-style: none;
    padding-left: 0;
    margin: 0;
  }
  .footer-links li {
    margin-bottom: 10px;
  }
  .footer-links a {
    color: #616161;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
  }
  .footer-links a::before {
    content: '';
    display: inline-block;
    width: 0;
    height: 2px;
    background-color: #009688;
    margin-right: 0;
    transition: all 0.2s ease;
    border-radius: 1px;
    vertical-align: middle;
  }
  .footer-links a:hover {
    color: #009688;
    transform: translateX(5px);
  }
  .footer-links a:hover::before {
    width: 15px;
    margin-right: 8px;
  }
  .social-icons {
    margin-bottom: 16px;
  }
  .social-icons a {
    display: inline-block;
    width: 36px;
    height: 36px;
    background-color: #e0f2f1;
    border-radius: 50%;
    margin-right: 12px;
    text-align: center;
    line-height: 36px;
    transition: all 0.3s ease;
  }
  .social-icons a i {
    color: #009688;
    font-size: 1.1rem;
    transition: all 0.3s ease;
  }
  .social-icons a:hover {
    background-color: #009688;
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 150, 136, 0.3);
  }
  .social-icons a:hover i {
    color: white;
  }
  .copyright {
    font-size: 0.92em;
    color: #757575;
    margin-top: 8px;
  }
  .heart {
    color: #e57373;
    display: inline-block;
    animation: heartBeat 1.5s infinite;
  }
  @keyframes heartBeat {
    0% { transform: scale(1); }
    14% { transform: scale(1.3); }
    28% { transform: scale(1); }
    42% { transform: scale(1.3); }
    70% { transform: scale(1); }
  }
  .footer-logo-link:hover .fa-globe-asia {
    animation: spin 2s linear infinite;
  }
  @keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
  @media (max-width: 992px) {
    .footer-col {
      margin-bottom: 30px;
    }
  }
</style>

<footer class="page-footer white">
  <div class="container">
    <div class="row">
      <div class="col s12 m4 footer-col">
        <a href="/tripwave/index.php" class="footer-logo footer-logo-link">
          <i class="fas fa-globe-asia"></i> TripWave
        </a>
        <p class="footer-description">
          Discover the best of Kandy & Sri Lanka — Hotels, Attractions, and more. 
          Your journey begins with experiences that last a lifetime.
        </p>
      </div>
      <div class="col s12 m4 footer-col">
        <h6 class="footer-links-title">Quick Links</h6>
        <ul class="footer-links">
          <li><a href="/tripwave/index.php">Home</a></li>
          <li><a href="/tripwave/pages/hotel.php">Hotels</a></li>
          <li><a href="/tripwave/pages/restaurants.php">Restaurants</a></li>
          <li><a href="/tripwave/pages/tours.php">Attractions & Tours</a></li>
          <li><a href="/tripwave/pages/activities.php">Activities</a></li>
          <li><a href="/tripwave/pages/community.php?lang=en">Community</a></li>
        </ul>
      </div>
      <div class="col s12 m4 footer-col">
        <h6 class="footer-links-title">Connect With Us</h6>
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <div class="copyright">
          Built with <i class="fas fa-heart heart"></i> by <b>Ashen365</b>
        </div>
        <div class="copyright" style="margin-top: 6px;">
          &copy; <?php echo date('Y'); ?> TripWave. All rights reserved.
        </div>
      </div>
    </div>
  </div>
</footer>