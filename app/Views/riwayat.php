<?php
session_start();
include '../../config/db.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil riwayat deteksi user
try {
    $id_user = $_SESSION['user_id'];
    $query = "SELECT * FROM riwayat_deteksi 
              WHERE user_id = :user_id 
              ORDER BY tanggal DESC";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
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
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center">Riwayat Deteksi Perkembangan</h1>
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
        
        <?php if (!empty($riwayat)): ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Usia</th>
                            <th class="p-3 text-left">Total Pertanyaan</th>
                            <th class="p-3 text-left">Jawaban Ya</th>
                            <th class="p-3 text-left">Interpretasi</th>
                            <th class="p-3 text-left">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($riwayat as $row): ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="p-3"><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></td>
                                <td class="p-3"><?= htmlspecialchars($row['umur_anak']) ?></td>
                                <td class="p-3"><?= $row['total_pertanyaan'] ?></td>
                                <td class="p-3"><?= $row['jawaban_ya'] ?></td>
                                <td class="p-3">
                                    <span class="<?= 
                                        $row['kategori'] == 'Sesuai Umur' ? 'text-green-600' : 
                                        ($row['kategori'] == 'Meragukan' ? 'text-yellow-600' : 'text-red-600') 
                                    ?>"><?= htmlspecialchars($row['kategori']) ?></span>
                                </td>
                                <td class="p-3"><?= $row['saran'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-600">Belum ada riwayat.</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function showDetail(id) {
            // Implementasi untuk menampilkan detail riwayat
            alert("Menampilkan detail untuk ID: " + id);
        }
    </script>
</body>
</html>