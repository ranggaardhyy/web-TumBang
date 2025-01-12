<?php
session_start();

// Menentukan Base URL secara dinamis
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);

// Mengambil URL yang diminta pengguna
$requestUri = $_SERVER['REQUEST_URI'];

// Cek apakah URL dimulai dengan base path aplikasi
if (strpos($requestUri, '/web-TumBang') === 0) {
    $requestUri = substr($requestUri, strlen('/web-TumBang'));
}

// Routing berdasarkan URL
switch ($requestUri) {
    case '/':
        require_once __DIR__ . '/app/Views/home.php';
        break;
    case '/login':
        require_once __DIR__ . '/app/Auth/login.php';
        break;
    case '/register':
        require_once __DIR__ . '/app/Auth/register.php';
        break;
    case '/dashboard':
        // Pastikan pengguna sudah login sebelum mengakses dashboard
        if (isset($_SESSION['user'])) {
            require_once __DIR__ . '/app/Views/dashboard.php';
        } else {
            // Arahkan ke login jika belum login dan hentikan eksekusi
            header('Location: ' . $baseUrl . '/login');
            exit();
        }
        break;
    case '/deteksi':
            // Pastikan pengguna sudah login sebelum mengakses deteksi
            if (isset($_SESSION['user'])) {
                require_once __DIR__ . '/app/Views/deteksi.php';
            } else {
                // Arahkan ke login jika belum login dan hentikan eksekusi
                header('Location: ' . $baseUrl . '/login');
                exit();
            }
            break;
    case '/profile':
        // Pastikan pengguna sudah login sebelum mengakses profile
        if (isset($_SESSION['user'])) {
            require_once __DIR__ . '/app/Views/profile.php';
        } else {
            // Arahkan ke login jika belum login dan hentikan eksekusi
            header('Location: ' . $baseUrl . '/login');
            exit();
        }
        break;
    case '/logout':
        session_destroy();
        header('Location: ' . $baseUrl . '/');
        exit(); // Hentikan eksekusi setelah logout
        break;
    default:
        echo 'Halaman tidak ditemukan!';
        break;
}
?>
