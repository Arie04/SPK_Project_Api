<?php
class Conclusion {
    private $conn;
    private $table_name = "conclusions";

    public $ConclusionId;
    public $Name;
    public $Solution;
    public $CreatedAt;
    public $UpdatedAt;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function findById() {
        $query = "SELECT Name AS Predict, Solution FROM " . $this->table_name . " WHERE ConclusionId = :conclusionId";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":conclusionId", $this->ConclusionId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}