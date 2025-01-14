<?php
session_start();
include '../../config/db.php'; // Pastikan Anda sudah menghubungkan ke database

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil umur anak dari session atau input
$umur_anak = isset($_SESSION['umur_anak']) ? $_SESSION['umur_anak'] : '0-3 bulan'; // Ganti sesuai logika Anda

// Stimulasi berdasarkan umur
$stimulasi = [
    '0-3 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Melihat, meraih dan menendang mainan gantung.',
            'Memperhatikan benda bergerak.',
            'Melihat benda-benda kecil.',
            'Memegang benda.',
            'Meraba dan merasakan bentuk permukaan.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Berbicara.',
            'Meniru suara-suara.',
            'Mengenali berbagai suara.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Memberi rasa aman dan kasih sayang.',
            'Mengajak bayi tersenyum.',
            'Mengajak bayi mengamati benda-benda dan keadaan di sekitarnya.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Stimulasi perlu dilanjutkan.',
            'Menyanggah berat.',
            'Mengembangkan kontrol terhadap kepala.'
        ]
    ],
    '3-6 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Stimulasi yang perlu dilanjutkan.',
            'Memegang benda dengan kuat.',
            'Memegang benda dengan kedua tangannya.',
            'Mengambil benda-benda kecil.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Stimulasi yang perlu dilanjutkan.',
            'Berguling-guling.',
            'Menahan kepala tetap tegak.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Memberi rasa aman dan kasih sayang.',
            'Mengajak bayi tersenyum.',
            'Mengajak bayi bermain "Ciluk-ba".'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Berbicara.',
            'Mengenali berbagai suara.',
            'Menirukan suara-suara.'
        ]
    ],
    '6-9 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Stimulasi yang perlu dilanjutkan.',
            'Memasukkan benda ke dalam wadah.',
            'Bermain "genderang".',
            'Menggambar.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Stimulasi yang perlu dilanjutkan.',
            'Merangkak.',
            'Menarik ke posisi berdiri.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Memberi rasa aman dan kasih sayang.',
            'Mengajak bayi tersenyum.',
            'Mengajak bayi bermain dengan teman sebaya.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Berbicara.',
            'Mencari sumber suara.',
            'Menirukan kata-kata.'
        ]
    ],
    '9-12 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Stimulasi yang perlu dilanjutkan.',
            'Menyusun balok/kotak.',
            'Menggambar.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Stimulasi yang perlu dilanjutkan.',
            'Bermain bola.',
            'Berjalan sambil berpegangan.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Memberi rasa aman dan kasih sayang.',
            'Mengajak bayi tersenyum.',
            'Mengajak bayi bermain dengan teman sebaya.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Berbicara.',
            'Menjawab pertanyaan.',
            'Menyebutkan nama gambar-gambar.'
        ]
    ],
    '12-15 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Stimulasi yang perlu dilanjutkan.',
            'Menyusun balok.',
            'Menggambar.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Bermain bola.',
            'Menarik mainan.',
            'Berjalan sendiri.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Minum sendiri dari sebuah cangkir.',
            'Makan bersama-sama.',
            'Menarik mainan yang letaknya agak jauh.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Menirukan kata-kata.',
            'Bercerita dengan boneka.',
            'Bersenandung dan bernyanyi.'
        ]
    ],
    '15-18 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Bermain dengan balok-balok.',
            'Meniup.',
            'Membuat untaian.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Bermain di luar rumah.',
            'Menendang bola.',
            'Berjalan mundur.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Menyusun mainan.',
            'Membantu kegiatan di rumah.',
            'Bermain dengan teman sebaya.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Bercerita tentang gambar di buku.',
            'Telepon-teleponan.',
            'Menyebut berbagai nama barang.'
        ]
    ],
    '18-24 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Dorong agar anak mau bermain puzzle.',
            'Menggambar dengan tangan.',
            'Mengenal berbagai ukuran dan bentuk.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Melompat.',
            'Melatih keseimbangan tubuh.',
            'Mendorong mainan dengan kaki.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Mengancingkan kancing baju.',
            'Bermain dengan teman sebaya.',
            'Membuat rumah-rumahan.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Bercerita tentang diri anak.',
            'Menyebut nama lengkap anak.',
            'Mengenal huruf.'
        ]
    ],
    '24-36 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Membuat gambar tempelan.',
            'Memilih dan mengelompokkan benda-benda.',
            'Mencocokkan gambar dan benda.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Latihan menghadapi rintangan.',
            'Melompat jauh.',
            'Melempar dan menangkap.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Melatih buang air kecil dan besar.',
            'Berdandan.',
            'Berpakaian.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Bercerita tentang apa yang dilihatnya.',
            'Menyebut nama berbagai jenis pakaian.',
            'Menyatakan keadaan suatu benda.'
        ]
    ],
    '36-48 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Bermain puzzle yang lebih sulit.',
            'Memotong.',
            'Membuat buku cerita gambar tempel.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Menangkap bola.',
            'Berjalan mengikuti garis lurus.',
            'Melompat.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Membentuk kemandirian.',
            'Membuat album keluarga.',
            'Bermain "berjualan dan berbelanja di toko".'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Mengenal benda yang serupa dan berbeda.',
            'Bermain tebak-tebakan.',
            'Menjawab pertanyaan "Mengapa?".'
        ]
    ],
    '48-60 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Menggambar dari berbagai sudut pandang.',
            'Membandingkan besar/kecil, banyak/sedikit.',
            'Menggunakan alat tulis dengan baik.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Bermain engklek.',
            'Melompati tali.',
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Berkomunikasi dengan anak.',
            'Berteman dan bergaul.',
            'Mematuhi peraturan keluarga.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Mengenal rambu/tanda lalu lintas.',
            'Mengenal uang logam.',
            'Mengamati atau meneliti keadaan sekitar.'
        ]
    ],
    '60-72 bulan' => [
        'KEMAMPUAN GERAK HALUS' => [
            'Bantu anak menulis namanya, kata-kata pendek serta angka-angka.',
            'Membuat sesuatu dari tanah liat/lilin.',
            'Mengerti urutan kegiatan.'
        ],
        'KEMAMPUAN GERAK KASAR' => [
            'Naik sepeda, bermain sepatu roda.',
            'Dorong agar anak dan temannya main bola.',
            'Melompat dengan satu kaki.'
        ],
        'KEMAMPUAN SOSIALISASI DAN KEMANDIRIAN' => [
            'Membentuk kemandirian.',
            'Membuat "album" keluarga.',
            'Mengikuti aturan permainan/petunjuk.'
        ],
        'KEMAMPUAN BICARA DAN BAHASA' => [
            'Mengenal benda yang serupa dan berbeda.',
            'Bermain tebak-tebakan.',
            'Menjawab pertanyaan "Mengapa?".'
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Stimulasi Sesuai Usia</title>
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
        <h1 class="text-3xl font-bold mb-6 text-center">Stimulasi Sesuai Usia</h1>

        <?php if (array_key_exists($umur_anak, $stimulasi)): ?>
            <?php foreach ($stimulasi[$umur_anak] as $kategori => $kegiatan): ?>
                <h2 class="text-2xl font-semibold mt-4"><?= $kategori ?></h2>
                <ul class="list-disc pl-6">
                    <?php foreach ($kegiatan as $item): ?>
                        <li><?= $item ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-red-600">Stimulasi untuk umur ini tidak tersedia.</p>
        <?php endif; ?>
    </div>
</body>
</html>