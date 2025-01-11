<?php
class NotificationModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addNotification($user_id, $message, $schedule_date, $age_group)
    {
        $stmt = $this->db->prepare("INSERT INTO notifications (user_id, message, schedule_date, age_group, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $message, $schedule_date, $age_group]);
    }

    public function getPendingNotifications()
    {
        $stmt = $this->db->query("SELECT * FROM notifications WHERE status = 'pending' AND schedule_date <= NOW()");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsSent($id)
    {
        $stmt = $this->db->prepare("UPDATE notifications SET status = 'sent' WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>