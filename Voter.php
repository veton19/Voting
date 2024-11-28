<?php
class Voter {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registerVoter($name) {
        $stmt = $this->db->prepare("INSERT INTO voters (name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    public function isRegistered($name) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM voters WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetchColumn() > 0;
    }
}
?>