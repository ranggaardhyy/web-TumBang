<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../Controllers/ProfileController.php';

if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

$userId = $_SESSION['user_id'];
$profileController = new ProfileController($db);
$profile = $profileController->getProfileData($userId);

// Menghitung usia anak
$birthDate = new DateTime($profile['tgl_lahir_anak']);
$today = new DateTime();
$age = $today->diff($birthDate)->m;

$profilePicture = $profile['profile_picture'] ? 'storage/uploads/' . $profile['profile_picture'] : 'storage/uploads/default.jpg'; // Foto profil default jika belum ada

// Jika foto profil diubah
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    try {
        $newProfilePicture = $profileController->updateProfilePicture($userId, $_FILES['profile_picture']);
        // Setelah foto diperbarui, redirect ke halaman yang sama untuk menampilkan perubahan
        header('Location: /web-TumBang/profile');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Comic Neue', cursive;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-5 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <a href="/web-TumBang/dashboard" class="text-blue-500 hover:text-blue-700"><i class="fas fa-home"></i> Dashboard</a>
                <a href="/web-TumBang/notification" class="text-gray-500 hover:text-gray-700"><i class="fas fa-bell"></i> Notifikasi</a>
                <a href="/web-TumBang/profile" class="text-gray-500 hover:text-gray-700"><i class="fas fa-user"></i> Profile</a>
                <a href="/web-TumBang/logout" class="text-gray-500 hover:text-gray-700"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-6 p-4">
        <h1 class="text-2xl font-bold mb-4">Profil Anda</h1>
        <div class="flex flex-col items-center">
        <img src="<?= $profilePicture ?>" alt="Foto Profil" class="rounded-full w-40 h-40 mb-4 border-4 border-gray-300 shadow-lg object-cover">
            <form action="/web-TumBang/profile" method="POST" enctype="multipart/form-data" class="mb-6">
                <input type="file" name="profile_picture" accept="image/*" class="border p-2 mb-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Ubah Foto Profil</button>
            </form>
        </div>
        <div>
            <p><strong>Nama Ayah:</strong> <?= htmlspecialchars($profile['nama_ayah']); ?></p>
            <p><strong>Nama Ibu:</strong> <?= htmlspecialchars($profile['nama_ibu']); ?></p>
            <p><strong>Nama Anak:</strong> <?= htmlspecialchars($profile['nama_anak']); ?></p>
            <p><strong>Tanggal Lahir Anak:</strong> <?= htmlspecialchars($profile['tgl_lahir_anak']); ?></p>
            <p><strong>Usia Anak:</strong> <?= $age; ?> Bulan</p>
        </div>
    </div>
</body>
</html>
