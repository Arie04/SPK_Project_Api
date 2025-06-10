<?php

class GetAllHistory {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllHistory(){
        $history = new History($this->db);
        $data = $history->getAll();
        
        if (!$data) {
            return BaseResponse::error("Data is empty");
        }

        return BaseResponse::success($data);
    }
}