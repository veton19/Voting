<?php
class Vote {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Define the submitVote method
    public function submitVote($voter_name, $nominee_name, $category, $comment) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO votes (voter_name, nominee_name, category, comment, timestamp) 
                VALUES (:voter_name, :nominee_name, :category, :comment, NOW())
            ");
            $stmt->bindParam(':voter_name', $voter_name);
            $stmt->bindParam(':nominee_name', $nominee_name);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':comment', $comment);

            return $stmt->execute(); // Returns true on success, false on failure
        } catch (PDOException $e) {
            // Log the error message for debugging
            error_log("Failed to submit vote: " . $e->getMessage());
            return false;
        }
    }
}
?>