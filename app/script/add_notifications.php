<?php
require_once '../config/db.php';
require_once '../app/Controllers/NotificationController.php';

$db = new PDO($dsn, $username, $password);
$notificationController = new NotificationController($db);

$query = $db->query("SELECT u.id as user_id, a.tanggal_lahir, a.pemeriksaan_terakhir 
                     FROM users u
                     JOIN anak a ON u.id = a.user_id");

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $user_id = $row['user_id'];
    $tanggal_lahir = $row['tanggal_lahir'];
    $last_checkup = $row['pemeriksaan_terakhir'];

    $birth_date = new DateTime($tanggal_lahir);
    $current_date = new DateTime();
    $age = $birth_date->diff($current_date)->m + ($birth_date->diff($current_date)->y * 12);

    $notificationController->addNotification($user_id, $age, $last_checkup);
}
?>