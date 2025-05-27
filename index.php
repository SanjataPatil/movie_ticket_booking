<?php include('header.php'); ?>
<html>
<head>
  <style>
    .carousel-container {
      max-width: 900px;
      margin: 30px auto;
      border-radius: 20px;
      overflow: hidden;
      position: relative;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
      background: linear-gradient(to bottom, #1c1c1c, #2e2e2e);
      padding: 20px;
    }

    .carousel {
      overflow: hidden;
      position: relative;
    }

    .carousel-inner {
      display: flex;
      width: calc(180px * 5 + 10px * 10); /* 5 images + spacing */
      animation: slide 25s infinite;
    }

    .carousel-inner img {
      width: 180px;
      height: 260px;
      object-fit: cover;
      margin: 0 10px;
      border-radius: 15px;
      border: 5px solid transparent;
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
      animation: glow 3s infinite alternate;
      transition: transform 0.5s;
    }

    .carousel-inner img:hover {
      transform: scale(1.05);
    }

    @keyframes slide {
      0%, 20% { transform: translateX(0); }
      25%, 45% { transform: translateX(-190px); }
      50%, 70% { transform: translateX(-380px); }
      75%, 95% { transform: translateX(-570px); }
      100% { transform: translateX(0); }
    }

    @keyframes glow {
      0% { border-color: #ff0055; box-shadow: 0 0 10px #ff0055; }
      50% { border-color: #00ccff; box-shadow: 0 0 10px #00ccff; }
      100% { border-color: #00ff88; box-shadow: 0 0 10px #00ff88; }
    }

    .carousel-title {
      text-align: center;
      font-size: 28px;
      color: #fff;
      font-weight: bold;
      margin-bottom: 10px;
      font-family: 'Segoe UI', sans-serif;
    }

    .bloom-message {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      color: #ff0080;
      animation: bloom 2s ease-in-out infinite alternate;
      margin-top: 15px;
      display: none;
    }

    @keyframes bloom {
      0% { transform: scale(1); opacity: 0.3; color: #ff0080; }
      100% { transform: scale(1.3); opacity: 1; color: #00ffe7; }
    }

    .welcome-banner {
      text-align: center;
      font-size: 22px;
      padding: 15px;
      font-weight: bold;
      color: #333;
      background: #f3f3f3;
      margin: 20px auto;
      border-radius: 10px;
    }

    .middle-list {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    .listimg1 {
      width: 140px;
      text-align: center;
    }

    .listimg1 img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="content">
  <div class="wrap">

    <!-- ✅ WELCOME BANNER -->
    <div class="welcome-banner">
      🎥 Welcome to Movie Booking — Enjoy the Latest Releases and Book Now!
    </div>

    <!-- ✅ Carousel Section -->
    <div class="carousel-container">
      <div class="carousel-title">🎬 Featured Movie Posters</div>
      <div class="carousel">
        <div class="carousel-inner">
          <img src="images/cherry.jpg" alt="Cherry" />
          <img src="images/tim.jpg" alt="The Invisible Man" />
          <img src="images/otw.jpg" alt="Outside the Wire" />
          <img src="images/gvkpster.jpg" alt="Godzilla vs. Kong" />
          <img src="images/zsjl.jpg" alt="Justice League" />
        </div>
      </div>
      <!-- 🌟 Bloom Message -->
      <div class="bloom-message" id="bloomMessage">
        🎟️ Book Your Movie Now!
      </div>
    </div>

    <!-- ✅ Movie Trailers -->
    <div class="content-top">
      <div class="listview_1_of_3 images_1_of_3">
        <h2 style="color:#000000;">🎞 Movie Trailers</h2>
        <div class="middle-list">
          <?php 
          $qry4 = mysqli_query($con, "SELECT * FROM tbl_movie ORDER BY rand() LIMIT 6");
          while($nm = mysqli_fetch_array($qry4)) {
            if (!empty($nm['image'])) {
              $imgPath = "images/" . $nm['image'];
          ?>
          <div class="listimg1">
            <a target="_blank" href="<?php echo $nm['video_url']; ?>">
              <img src="<?php echo $imgPath; ?>" 
                   alt="<?php echo $nm['movie_name']; ?>" 
                   onerror="this.parentElement.style.display='none';" />
            </a>
            <a target="_blank" href="<?php echo $nm['video_url']; ?>" class="link" style="text-decoration:none; font-size:14px;">
              <?php echo $nm['movie_name']; ?>
            </a>
          </div>
          <?php } } ?>
        </div>
      </div>

      <?php include('movie_sidebar.php'); ?>
    </div>
    
  </div>
</div>

<?php include('footer.php'); ?>
<?php include('searchbar.php'); ?>

<!-- ✅ JS to show Bloom Message after 25s (once carousel completes) -->
<script>
  const bloom = document.getElementById('bloomMessage');

  function showBloomOnce() {
    bloom.style.display = 'block';
    setTimeout(() => {
      bloom.style.display = 'none';
    }, 5000);
  }

  setTimeout(() => {
    showBloomOnce();
  }, 25000); // Show message after 25s (carousel done)
</script>

</body>
</html>
