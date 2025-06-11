<?php

class GetAllHistory {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllHistory($token){
        $userTokenVerifier = new UserTokenVerifier($this->db);
        $userVerified = $userTokenVerifier->userTokenVerifier($token);
        if (!$userVerified) {
            return BaseResponse::unauthorize();
        }

        $history = new History($this->db);
        $history->UserId = $userVerified;
        $data = $history->getAll();
        
        if (!$data) {
            return BaseResponse::error("Data is empty");
        }

        return BaseResponse::success($data);
    }
}