<?php
require_once __DIR__ . '/../Controllers/NotificationController.php';
require_once __DIR__ . '/../../config/db.php';

// Inisialisasi database dan controller
$notificationController = new NotificationController($db);

// Ambil daftar notifikasi
$notifications = $notificationController->fetchNotifications();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Notifikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Comic Neue', cursive;
        }
    </style>
</head>
<body class="bg-gray-100 p-5">
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

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-5">Notifikasi</h1>
        
        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="bg-white shadow p-4 rounded mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-semibold">Notifikasi</h2>
                        <span class="text-sm text-gray-500"><?= date('F j, Y, g:i a', strtotime($notification['schedule_date'])) ?></span>
                    </div>
                    <p class="text-gray-700"><?= htmlspecialchars($notification['message']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600">Tidak ada notifikasi untuk ditampilkan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
