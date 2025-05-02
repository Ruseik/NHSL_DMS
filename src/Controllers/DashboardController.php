<?php
require_once __DIR__ . '/../../config/database.php';

class DashboardController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /NHSL_DMS/public/');
            exit;
        }

        $wards = $this->getActiveWards();
        require __DIR__ . '/../Views/dashboard/index.php';
    }

    private function getActiveWards() {
        try {
            $stmt = $this->db->prepare('SELECT id, name, description FROM wards WHERE is_active = true ORDER BY name');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error fetching wards: ' . $e->getMessage());
            return [];
        }
    }

    public function getDietItems() {
        try {
            $stmt = $this->db->prepare('SELECT id, name, unit FROM diet_items WHERE is_active = true ORDER BY name');
            $stmt->execute();
            return ['success' => true, 'items' => $stmt->fetchAll()];
        } catch (PDOException $e) {
            error_log('Error fetching diet items: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to fetch diet items'];
        }
    }

    public function saveDietEntry($wardId, $items) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare('INSERT INTO diet_entries (ward_id, user_id, entry_date) VALUES (?, ?, CURRENT_DATE())');
            $stmt->execute([$wardId, $_SESSION['user_id']]);
            $entryId = $this->db->lastInsertId();

            $stmt = $this->db->prepare('INSERT INTO diet_entry_details (diet_entry_id, diet_item_id, quantity) VALUES (?, ?, ?)');
            foreach ($items as $item) {
                $stmt->execute([$entryId, $item['id'], $item['quantity']]);
            }

            $this->db->commit();
            return ['success' => true];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Error saving diet entry: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to save diet entry'];
        }
    }
}