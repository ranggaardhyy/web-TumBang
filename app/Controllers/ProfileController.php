<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/db.php';

class ProfileController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Ambil data pengguna berdasarkan ID yang login
    public function getProfileData($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengubah foto profil pengguna
    public function updateProfilePicture($userId, $file)
    {
        // Validasi file
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Hanya file gambar yang diperbolehkan');
        }

        $uploadDir = __DIR__ . "/../../storage/uploads/";
        $filename = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $uploadFile = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            // Update foto profil di database
            $stmt = $this->db->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
            $stmt->bindParam(':profile_picture', $filename);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $filename;
        } else {
            throw new Exception('Terjadi kesalahan saat mengunggah file');
        }
    }
}
