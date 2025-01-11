<?php

class ProfileModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Fungsi untuk mengambil data pengguna berdasarkan ID
    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
