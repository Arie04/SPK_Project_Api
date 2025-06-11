<?php
class History {
    private $conn;
    private $table_name = "history";

    public $HistoryId;
    public $ClientName;
    public $Date;
    public $DeviceType;
    public $CPUUsage;
    public $RAMUsage;
    public $Temperature;
    public $Voltage;
    public $DiskUsage;
    public $FanSpeed;
    public $ConclusionId;
    public $VerifiedByUser;
    public $UserId;
    public $IsDeleted;
    public $CreatedAt;
    public $UpdatedAt;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (ClientName, Date, DeviceType, CPUUsage, RAMUsage, Temperature, Voltage, DiskUsage, FanSpeed, ConclusionId, VerifiedByUser, UserId) 
        VALUES 
        (:clientName, :date, :deviceType, :CPUUsage, :RAMUsage, :temperature, :voltage, :diskUsage, :fanSpeed, :conclusionId, :verifiedByUser, :userId)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":clientName", $this->ClientName);
        $stmt->bindParam(":date", $this->Date);
        $stmt->bindParam(":deviceType", $this->DeviceType);
        $stmt->bindParam(":CPUUsage", $this->CPUUsage);
        $stmt->bindParam(":RAMUsage", $this->RAMUsage);
        $stmt->bindParam(":temperature", $this->Temperature);
        $stmt->bindParam(":voltage", $this->Voltage);
        $stmt->bindParam(":diskUsage", $this->DiskUsage);
        $stmt->bindParam(":fanSpeed", $this->FanSpeed);
        $stmt->bindParam(":conclusionId", $this->ConclusionId);
        $stmt->bindParam(":userId", $this->UserId);
        $stmt->bindParam(":verifiedByUser", $this->VerifiedByUser);

        return $stmt->execute();
    }

    public function getAll(){
        $query = "SELECT h.*, c.ConclusionId, c.Name FROM " . $this->table_name . " h 
        JOIN conclusions c ON h.ConclusionId = c.ConclusionId
        WHERE h.IsDeleted = false AND h.UserId = :userId"; 

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $this->UserId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHistoryByUserId($userId){
        $query = "SELECT h.*, c.ConclusionId, c.Name FROM " . $this->table_name . " h 
        JOIN conclusions c ON h.ConclusionId = c.ConclusionId
        WHERE h.IsDeleted = false AND h.UserId = :userId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

