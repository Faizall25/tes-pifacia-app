searchForm = document.querySelector(".search-form");

document.querySelector("#search-btn").onclick = () => {
    searchForm.classList.toggle("active");
};

// let loginForm = document.querySelector(".login-form-container");

// document.querySelector('#login-btn').onclick = () => {
//   loginForm.classList.toggle('active');
// };

document.querySelector("#close-login-btn").onclick = () => {
    loginForm.classList.remove("active");
};

let registerForm = document.querySelector(".register-form-container");

document.querySelector("#register-btn").onclick = () => {
    registerForm.classList.toggle("active");
};

document.querySelector("#close-refister-btn").onclick = () => {
    registerForm.classList.remove("active");
};

window.onload = () => {
    // loader hilang setelah web siap
    document.getElementById("loader").classList.add("hidden");

    // tetap lanjutkan scrollY check untuk header
    if (window.scrollY > 80) {
        document.querySelector(".header .header-2").classList.add("active");
    } else {
        document.querySelector(".header .header-2").classList.remove("active");
    }
};

// Backup: paksa hilangkan loader setelah 3 detik
setTimeout(() => {
    document.getElementById("loader").classList.add("hidden");
}, 2000);

// Tunggu halaman selesai load
window.addEventListener("load", function () {
    const loader = document.getElementById("loader");
    loader.style.display = "none";
});

window.onscroll = () => {
    searchForm.classList.remove("active");

    if (window.scrollY > 80) {
        document.querySelector(".header .header-2").classList.add("active");
    } else {
        document.querySelector(".header .header-2").classList.remove("active");
    }
};

window.onload = () => {
    if (window.scrollY > 80) {
        document.querySelector(".header .header-2").classList.add("active");
    } else {
        document.querySelector(".header .header-2").classList.remove("active");
    }
};

// Register
// let registerForm = document.querySelector('.register-form-container');
// let registerBtn = document.querySelector('#register-btn');
// let closeRegisterBtn = document.querySelector('#close-register-btn');

// registerBtn.onclick = () => {
//   registerForm.classList.toggle('active');
//   loginForm.classList.remove('active'); // Kalau form login kebuka, kita tutup dulu
// };

// closeRegisterBtn.onclick = () => {
//   registerForm.classList.remove('active');
// };

// let createAccountLink = document.querySelector('#create-account');

// createAccountLink.onclick = (e) => {
//   e.preventDefault(); // supaya gak reload halaman
//   registerForm.classList.add('active');
//   loginForm.classList.remove('active');
// };
