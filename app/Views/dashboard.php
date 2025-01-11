<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../Controllers/ProfileController.php';


// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: /web-TumBang/login');
    exit();
}

// Ambil data pengguna dari database berdasarkan user_id
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data pengguna tidak ditemukan
if (!$user) {
    die("Pengguna tidak ditemukan.");
}

// Pastikan tanggal lahir anak ada dan valid
if (empty($user['tgl_lahir_anak'])) {
    die("Tanggal lahir anak tidak ditemukan.");
}

// Debugging untuk memastikan tanggal lahir
// var_dump($user['tgl_lahir_anak']); // Bisa digunakan untuk memeriksa format tanggal

$userId = $_SESSION['user_id'];
$profileController = new ProfileController($db);
$profile = $profileController->getProfileData($userId);
// Jika foto bayi tidak ada, kosongkan link gambar
$profilePicture = $profile['profile_picture'] ? 'storage/uploads/' . $profile['profile_picture'] : 'storage/uploads/default.jpg'; // Foto profil default jika belum ada
$nama_ibu = $user['nama_ibu'];
$nama_bayi = $user['nama_anak'];

// Hitung umur bayi menggunakan fungsi calculateAge
$umur_bayi = calculateAge($user['tgl_lahir_anak']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dashboard</title>
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
    <!-- Header -->
    <div class="bg-gray-800 text-white text-center py-2">
        <p>
            Hallo, <?= htmlspecialchars($nama_ibu) ?>! Selamat Datang Kembali!!
        </p>
    </div>

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

    <!-- Profile Info -->
    <div class="bg-white shadow-md p-4 mt-2">
        <div class="flex items-center space-x-4">
        <img src="<?= $profilePicture ?>" alt="Foto Profil" class="rounded-full w-12 h-12"/>
            <div>
                <p class="font-bold">Nama Anak : <?= htmlspecialchars($nama_bayi) ?></p>
                <p class="text-gray-600">Nama Ibu : <?= htmlspecialchars($nama_ibu) ?></p>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-gray-600">Umur Anak :</p>
            <p class="text-3xl font-bold text-blue-900"><?= $umur_bayi ?> Bulan</p>
        </div>
    </div>

    <!-- Child Growth -->
    <div class="bg-white shadow-md p-4 mt-2">
        <p class="font-bold">Tumbuh kembang anak</p>
        <p class="text-gray-600">adalah proses perkembangan fisik dan kemampuan anak.</p>
        <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2" onclick="window.location.href='/web-TumBang/deteksi'">Deteksi Tumbang</button>
    </div>

    <!-- Medical History -->
    <div class="bg-white shadow-md p-4 mt-2">
        <p class="font-bold">Riwayat pemeriksaan anak</p>
        <p class="text-gray-600">adalah catatan atau dokumentasi dari setiap pemeriksaan kesehatan dan deteksi tumbuh kembang yang dilakukan pada anak.</p>
        <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2" onclick="window.location.href='/web-TumBang/riwayat'">Cek Riwayat</button>
    </div>

    <!-- Stimulation Recommendation -->
    <div class="bg-white shadow-md p-4 mt-2">
        <p class="font-bold">Rekomendasi Stimulasi</p>
        <p class="text-gray-600">adalah saran aktivitas atau latihan yang dirancang untuk mendukung dan mengoptimalkan tumbuh kembang anak sesuai dengan usianya.</p>
        <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2" onclick="window.location.href='/web-TumBang/stimulasi'">Stimulasi</button>
    </div>

    <!-- Footer Image -->
    <div class="bg-white shadow-md p-4 mt-2">
        <img alt="Illustration of a mother measuring her child's height" class="w-full" src="https://storage.googleapis.com/a1aa/image/fr0Sd2xCxM3BMKBzstcFfSKPdWWCB92CrqeDArWmB5WjfaNQB.jpg" />
    </div>

</body>

</html>

<?php
function calculateAge($birth_date) {
    // Cek apakah input adalah string dan memiliki format yang benar
    if (!$birth_date) {
        return 0; // Jika tanggal lahir tidak ada atau kosong
    }

    // Membuat objek DateTime dari tanggal lahir
    $birth_date_obj = DateTime::createFromFormat('Y-m-d', $birth_date);
    
    // Cek apakah objek DateTime berhasil dibuat
    if (!$birth_date_obj) {
        return 0; // Jika format tanggal salah
    }

    // Mendapatkan tanggal saat ini
    $current_date = new DateTime();
    
    // Menghitung selisih antara tanggal lahir dan tanggal sekarang
    $interval = $birth_date_obj->diff($current_date);
    
    // Mengembalikan umur bayi dalam bulan
    return $interval->y * 12 + $interval->m;
}
?>