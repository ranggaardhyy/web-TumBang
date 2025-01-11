<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../Models/NotificationModel.php';

class NotificationController
{
    private $notificationModel;
    private $db; // Properti $db untuk menyimpan koneksi database

    // Constructor untuk menginisialisasi koneksi database
    public function __construct($db)
    {
        if ($db instanceof PDO) {
            $this->db = $db; // Pastikan $db adalah objek PDO yang valid
            $this->notificationModel = new NotificationModel($db); // Memuat Instance Model
        } else {
            throw new Exception('Database connection is not valid');
        }
    }

    // Ambil notifikasi
    public function getNotifications()
    {
        return $this->notificationModel->getPendingNotifications();
    }

    public function addNotification($user_id, $age, $last_checkup)
    {
        if ($age < 3) {
            $interval = '1 MONTH'; // Interval untuk anak <3 bulan
            $message = "Halo Parents! Jangan lupa untuk melakukan pemeriksaan awal pada bayi Anda untuk memastikan tumbuh kembang yang optimal. Yuk periksa ke dokter anak!";
            $age_group = '<3';
        } elseif ($age >= 3 && $age <= 24) {
            $interval = '3 MONTH'; // Interval untuk usia 3–24 bulan
            $message = "Halo Parents! Saatnya Deteksi Dini Perkembangan Anak! 3 bulan setelah pemeriksaan terakhir sudah berlalu, yuk pastikan anak Anda tetap sehat dalam perkembangannya dan siap menjadi generasi emas🌟";
            $age_group = '3-24';
        } elseif ($age >= 24 && $age <= 72) {
            $interval = '6 MONTH'; // Interval untuk usia 24–72 bulan
            $message = "Halo Parents! Saatnya Deteksi Dini Perkembangan Anak! 6 bulan setelah pemeriksaan terakhir sudah berlalu, yuk pastikan anak Anda tetap sehat dalam perkembangannya dan siap menjadi generasi emas🌟";
            $age_group = '24-72';
        } else {
            return; // Tidak memenuhi kriteria usia
        }
        
        // Logika untuk menambahkan notifikasi
        $schedule_date = date('Y-m-d H:i:s', strtotime("$last_checkup + $interval"));
        $this->notificationModel->addNotification($user_id, $message, $schedule_date, $age_group);
        
    }

    public function fetchNotifications()
    {
        $stmt = $this->notificationModel->getPendingNotifications();
        return $stmt;
    }
    
    public function sendNotifications()
    {
        $notifications = $this->notificationModel->getPendingNotifications();
        foreach ($notifications as $notification) {
            echo "<script>alert('{$notification['message']}');</script>";
            $this->notificationModel->markAsSent($notification['id']);
        }
    }
}
?>