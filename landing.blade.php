<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Weebok</title>

    <!-- Font cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- Custom link css  -->
    <link rel="stylesheet" href="/css/style.css" />
  </head>
  <body>
    <!-- header section -->
    <header class="header">
      <div class="header-1">
        <a href="#" class="logo"><i class="fas fa-book"></i>weebok</a>

        <form action="" class="search-form">
          <input type="search" placeholder="search here..." id="search-box" />
          <label for="search-box" class="fas fa-search"></label>
        </form>

        <div class="icons">
          <div id="search-btn" class="fas fa-search"></div>
          <a href="#" class="fas fa-heart"></a>
          <a href="#" class="fas fa-shopping-cart"></a>
          <div id="login-btn" class="fas fa-user"></div>
        </div>
      </div>

      <div class="header-2">
        <nav class="navbar">
          <a href="#home">home</a>
          <a href="#featured">featured</a>
          <a href="#arrivals">arrivals</a>
          <a href="#reviews">reviews</a>
          <a href="#blogs">blogs</a>
        </nav>
      </div>
    </header>

    <!-- end header section -->

    <!-- Bottom Navbar -->
    <nav class="bottom-navbar">
      <a href="#home" class="fas fa-home"></a>
      <a href="#featured" class="fas fa-list"></a>
      <a href="#arrivals" class="fas fa-tags"></a>
      <a href="#reviews" class="fas fa-comments"></a>
      <a href="#blogs" class="fas fa-blogs"></a>
    </nav>

    <!-- Login form -->
    <div class="login-form-container">
      <div id="close-login-btn" class="fas fa-times"></div>

      <form action="">
        <h3>Sign In</h3>
        <span>Username</span>
        <input type="email" class="box" name="box" placeholder="enter your Email" id="" />
        <span>Password</span>
        <input type="password" class="box" name="box" placeholder="enter your Password" id="" />
        <div class="checkbox">
          <input type="checkbox" name="" id="remember-me" />
          <label for="remember-me"> remember me</label>
        </div>
        <input type="submit" value="sign in" class="btn" />
        <p>forget password ? <a href="#">click here</a></p>
        <p>don't have an account <a href="#" id="create-account">create one</a></p>
      </form>
    </div>

    <!-- Register Form -->
    <!-- <div class="register-form-container">
      <div id="close-register-btn" class="fas fa-times"></div>

      <form action="">
        <h3>Sign Up</h3>
        <span>Username</span>
        <input type="text" class="box" name="username" placeholder="enter your username" />
        <span>Email</span>
        <input type="email" class="box" name="email" placeholder="enter your email" />
        <span>Password</span>
        <input type="password" class="box" name="password" placeholder="enter your password" />
        <span>Confirm Password</span>
        <input type="password" class="box" name="confirm-password" placeholder="confirm your password" />
        <input type="submit" value="sign up" class="btn" />
        <p>already have an account? <a href="#">sign in</a></p>
      </form>
    </div> -->

    <!-- Home section starts -->

    <section class="home" id="home">
      <div class="row">
        <div class="content">
          <h3>up 75% off</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque excepturi quaerat sequi blanditiis commodi facere recusandae, esse quos, incidunt earum explicabo laborum ratione delectus illum vero veritatis nihil ullam eveniet?
          </p>
          <a href="#" class="btn">shope now</a>
        </div>

        <div class="books-silinder">
          <div class="wraper">
            <a href="#"><img src="/img/book-1.jpg" alt="" /></a>
            <a href="#"><img src="/img/book-2.jpg" alt="" /></a>
            <a href="#"><img src="/img/book-3.jpg" alt="" /></a>
            <a href="#"><img src="/img/book-4.jpg" alt="" /></a>
            <a href="#"><img src="/img/book-5.jpg" alt="" /></a>
            <a href="#"><img src="/img/book-6.jpg" alt="" /></a>
          </div>
          <img src="/img/Standup.png" class="stand" alt="" />
        </div>
      </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
      <div class="box-container">
        <div class="box">
          <h3>Quick Links</h3>
          <a href="#home">Home</a>
          <a href="#featured">Featured</a>
          <a href="#arrivals">Arrivals</a>
          <a href="#reviews">Reviews</a>
          <a href="#blogs">Blogs</a>
        </div>

        <div class="box">
          <h3>Extra Links</h3>
          <a href="#">Account Info</a>
          <a href="#">Ordered Items</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Payment Methods</a>
        </div>

        <div class="box">
          <h3>Contact Info</h3>
          <a href="#"> <i class="fas fa-phone"></i> +62 812-3456-7890 </a>
          <a href="#"> <i class="fas fa-envelope"></i> support@weebok.com </a>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia </a>
        </div>
      </div>

      <div class="credit">&copy; 2025 <span>Weebok</span> | All rights reserved.</div>
    </footer>

    <!-- Loader Section -->
    <!-- <div id="loader"></div> -->
  </body>

  <!-- Custom link js -->
  <script src="/js/script.js"></script>
</html>
