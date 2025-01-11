<?php
// Menentukan Base URL secara dinamis
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/web-TumBang'; 

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tumbangDB";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menangani form registrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $nama_anak = $_POST['nama_anak'];
    $tgl_lahir_anak = $_POST['tgl_lahir_anak'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password
    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan Konfirmasi Password tidak cocok');</script>";
    } else {
        // Mengenkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyimpan data ke dalam database
        $sql = "INSERT INTO users (nama_ayah, nama_ibu, nama_anak, tgl_lahir_anak, password)
                VALUES ('$nama_ayah', '$nama_ibu', '$nama_anak', '$tgl_lahir_anak', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registrasi berhasil!'); window.location.href = '$baseUrl/login';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Parents Register
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
            Daftar Akun
        </h1>
        <form class="space-y-4" action="<?= $baseUrl ?>/register" method="post">
            <div>
                <label class="block text-lg mb-2">
                    Nama Ayah
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="text" name="nama_ayah" placeholder="Nama Ayah" required />
            </div>

            <div>
                <label class="block text-lg mb-2">
                    Nama Ibu
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="text" name="nama_ibu" placeholder="Nama Ibu" required />
            </div>
            <div>
                <label class="block text-lg mb-2">
                    Nama Anak
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="text" name="nama_anak" placeholder="Nama Anak" required />
            </div>
            <div>
                <label class="block text-lg mb-2">
                    Tgl Lahir Anak
                </label>
                <div class="flex items-center">
                    <input class="w-full p-2 border border-gray-300 rounded" type="date" name="tgl_lahir_anak" required />
                    <i class="fas fa-calendar-alt ml-2"></i>
                </div>
            </div>
            <div>
                <label class="block text-lg mb-2">
                    Password
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="password" name="password" placeholder="Password" required />
            </div>
            <div>
                <label class="block text-lg mb-2">
                    Konfirmasi Password
                </label>
                <input class="w-full p-2 border border-gray-300 rounded" type="password" name="confirm_password" placeholder="Konfirmasi Password" required />
            </div>
            <div class="text-center">
                <button class="w-full bg-blue-500 text-white py-2 rounded" type="submit">
                    Daftar
                </button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm">Sudah punya akun? <a href="/web-TumBang/login" class="text-blue-500 hover:text-blue-600">Login disini</a></p>
        </div>
        <div class="mt-8 flex justify-center">
            <img alt="Three children standing next to a height measurement chart, smiling and having fun." height="200" src="https://storage.googleapis.com/a1aa/image/ro6VbN4YuK7TCtopAZtpkohyT0RO1cq9ag1Rqx8d1PkNU1AF.jpg" width="300" />
        </div>
    </div>
</body>

</html>