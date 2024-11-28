<?php
class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function countVotes() {
        $stmt = $this->db->query("SELECT category, nominee_name, COUNT(*) AS votes FROM votes GROUP BY category, nominee_name ORDER BY category, votes DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listVoters() {
        $stmt = $this->db->query("SELECT * FROM voters ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
?>