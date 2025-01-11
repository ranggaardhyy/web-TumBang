<?php
session_start();

// Menentukan Base URL secara dinamis
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/web-TumBang'; 

// Memastikan koneksi ke database dengan require_once
require_once '../../config/db.php';

// Cek jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: /web-TumBang/dashboard');
    exit;
}

// Cek jika form login disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_ibu = $_POST['nama_ibu'];
    $password = $_POST['password'];

    // Periksa apakah $db sudah didefinisikan
    if ($db) {
        // Ambil data pengguna berdasarkan nama_ibu
        $stmt = $db->prepare("SELECT * FROM users WHERE nama_ibu = :nama_ibu");
        $stmt->bindParam(':nama_ibu', $nama_ibu);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cek apakah user ditemukan dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            // Jika login berhasil, set session
            $_SESSION['user_id'] = $user['id']; // Menyimpan id pengguna di session
            $_SESSION['nama_ibu'] = $user['nama_ibu']; // Menyimpan nama ibu di session

            // Redirect ke dashboard setelah login
            header('Location: /web-TumBang/dashboard');
            exit;
        } else {
            $error_message = "Nama ibu atau password salah.";
        }
    } else {
        $error_message = "Koneksi ke database gagal.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Parents Login
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Comic Neue', cursive;
        }
    </style>
</head>

<body class="bg-white flex flex-col items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md">
        <div class="text-left mb-6">
            <a href="<?= $baseUrl ?>" class="text-2xl">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h1 class="text-4xl text-center mb-6">
            Hallo Parents!!
        </h1>
        <form class="space-y-4" action="<?= $baseUrl ?>/login" method="post">
            <div>
                <label class="block text-lg mb-2">
                    Nama Ayah
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="text" name="nama_ayah" placeholder="Nama Ayah" />
            </div>
            <div>
                <label class="block text-lg mb-2">
                    Nama Ibu
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="text" name="nama_ibu" placeholder="Nama Ibu" />
            </div>
            <div>
                <label class="block text-lg mb-2">
                    Nama Anak
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="text" name="nama_anak" placeholder="Nama Anak" />
            </div>
            <div>
                <label class="block text-lg mb-2">
                    Tgl Lahir Anak
                </label>
                <div class="flex items-center">
                    <input class="w-full p-2 border border-gray-300 rounded" type="date" name="tgl_lahir_anak" />
                    <i class="fas fa-calendar-alt ml-2"></i>
                </div>
            </div>
            <div>
                <label class="block text-lg mb-2">
                    Password
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="password" name="password" placeholder="Password" />
            </div>
            <div class="text-center">
                <button class="w-full bg-blue-500 text-white py-2 rounded" type="submit">
                    Login
                </button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm">Belum punya akun? <a href="/web-TumBang/register" class="text-blue-500 hover:text-blue-600">Daftar disini</a></p>
        </div>
        <div class="mt-8 flex justify-center">
            <img alt="Three children standing next to a height measurement chart, smiling and having fun." height="200" src="https://storage.googleapis.com/a1aa/image/ro6VbN4YuK7TCtopAZtpkohyT0RO1cq9ag1Rqx8d1PkNU1AF.jpg" width="300" />
        </div>
    </div>
</body>

</html>