<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Weebok</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- Inline CSS for form toggling -->
    <style>
        .login-form-container, .register-form-container {
            display: none;
        }
        .login-form-container.active, .register-form-container.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="header-1">
            <a href="{{ route('landing') }}" class="logo"><i class="fas fa-book"></i>weebok</a>

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

    <!-- Bottom Navbar -->
    <nav class="bottom-navbar">
        <a href="#home" class="fas fa-home"></a>
        <a href="#featured" class="fas fa-list"></a>
        <a href="#arrivals" class="fas fa-tags"></a>
        <a href="#reviews" class="fas fa-comments"></a>
        <a href="#blogs" class="fas fa-blogs"></a>
    </nav>

    <!-- Login Form -->
    <div class="login-form-container">
        <div id="close-login-btn" class="fas fa-times"></div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <h3>Sign In</h3>
            <span>Email</span>
            <input type="email" class="box" name="email" placeholder="enter your email" value="{{ old('email') }}" required />
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
            <span>Password</span>
            <input type="password" class="box" name="password" placeholder="enter your password" required />
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
            <div class="checkbox">
                <input type="checkbox" name="remember" id="remember-me" />
                <label for="remember-me">remember me</label>
            </div>
            <input type="submit" value="sign in" class="btn" />
            {{-- <p>forget password? <a href="{{ route('password.request') }}">click here</a></p> --}}
            <p>don't have an account? <a href="#" id="create-account">create one</a></p>
        </form>
    </div>

    <!-- Register Form -->
    <div class="register-form-container">
        <div id="close-register-btn" class="fas fa-times"></div>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <h3>Sign Up</h3>
            <span>Full Name</span>
            <input type="text" class="box" name="name" placeholder="enter your full name" value="{{ old('name') }}" required />
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
            <span>Email</span>
            <input type="email" class="box" name="email" placeholder="enter your email" value="{{ old('email') }}" required />
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
            <span>Password</span>
            <input type="password" class="box" name="password" placeholder="enter your password" required />
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
            <span>Confirm Password</span>
            <input type="password" class="box" name="password_confirmation" placeholder="confirm your password" required />
            <input type="submit" value="sign up" class="btn" />
            <p>already have an account? <a href="#" id="sign-in">sign in</a></p>
        </form>
    </div>

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="row">
            <div class="content">
                <h3>up to 75% off</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque excepturi quaerat sequi blanditiis commodi facere recusandae, esse quos, incidunt earum explicabo laborum ratione delectus illum vero veritatis nihil ullam eveniet?
                </p>
                <a href="#" class="btn">shop now</a>
            </div>

            <div class="books-silinder">
                <div class="wraper">
                    <a href="#"><img src="{{ asset('img/book-1.jpg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('img/book-2.jpg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('img/book-3.jpg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('img/book-4.jpg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('img/book-5.jpg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('img/book-6.jpg') }}" alt="" /></a>
                </div>
                <img src="{{ asset('img/Standup.png') }}" class="stand" alt="" />
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
                <a href="{{ route('profile') }}">Account Info</a>
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

        <div class="credit">© {{ date('Y') }} <span>Weebok</span> | All rights reserved.</div>
    </footer>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginBtn = document.getElementById('login-btn');
            const closeLoginBtn = document.getElementById('close-login-btn');
            const closeRegisterBtn = document.getElementById('close-register-btn');
            const createAccountLink = document.getElementById('create-account');
            const signInLink = document.getElementById('sign-in');
            const loginFormContainer = document.querySelector('.login-form-container');
            const registerFormContainer = document.querySelector('.register-form-container');
    
            // 👇 UPDATE bagian ini:
            loginBtn.addEventListener('click', function () {
                window.location.href = "{{ route('login') }}";
            });
    
            // sisanya tetap (jika butuh buat popup manual lain)
            closeLoginBtn.addEventListener('click', function () {
                loginFormContainer.classList.remove('active');
            });
    
            closeRegisterBtn.addEventListener('click', function () {
                registerFormContainer.classList.remove('active');
            });
    
            createAccountLink.addEventListener('click', function (e) {
                e.preventDefault();
                loginFormContainer.classList.remove('active');
                registerFormContainer.classList.add('active');
            });
    
            signInLink.addEventListener('click', function (e) {
                e.preventDefault();
                registerFormContainer.classList.remove('active');
                loginFormContainer.classList.add('active');
            });
        });
    </script>
    
</body>
</html>