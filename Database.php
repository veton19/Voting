<?php
class Database {
    private $host = "localhost";
    private $dbname = "voting_system";
    private $username = "root";
    private $password = "Veton_2000##";
    public $conn;

    public function connect() {
        if (!$this->conn) {
            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}
?>