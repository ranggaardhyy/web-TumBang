<?php
// Menentukan Base URL secara dinamis
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/web-TumBang'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Aplikasi Deteksi Dini Perkembangan Anak
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
</head>

<body class="bg-white flex items-center justify-center min-h-screen p-4">
    <div class="container mx-auto max-w-lg p-4 border border-gray-300 rounded-lg shadow-lg">
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-center mb-6" style="font-family: 'Roboto', sans-serif;">
            APLIKASI DETEKSI DINI PERKEMBANGAN ANAK
        </h1>
        <div class="flex justify-center mb-4">
            <img alt="Logo with a green circle and upward arrow bars" class="mb-4" height="200" src="https://storage.googleapis.com/a1aa/image/5AquWsyWJGZiBZV7i39IrCenQ2zS6euMMDDIsY6f3jwMWqGoA.jpg" width="200" />
        </div>
        <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-center mb-2" style="font-family: 'Roboto', sans-serif;">
            KEMBANGKU
        </h2>
        <p class="text-center text-green-600 mb-6" style="font-family: 'Roboto', sans-serif;">
            Tumbuh Bersama, Berkembang dengan Cinta
        </p>
        <p class="text-center text-black mb-6 px-4" style="font-family: 'Roboto', sans-serif;">
            Yuk, deteksi tumbuh kembang si kecil secara berkala agar tumbuh sehat dan bahagia. Klik mulai untuk memulai pemeriksaan.
        </p>
        <div class="flex justify-center">
            <a href="/web-TumBang/login" class="bg-blue-500 text-white py-2 px-6 rounded-full hover:bg-blue-600 transition">
                Mulai
            </a>
        </div>
    </div>
</body>

</html>