<?php

class UpdateUserProfile {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function updateUserProfile($data, $token){
        $userTokenVerifier = new UserTokenVerifier($this->db);
        $userVerified = $userTokenVerifier->userTokenVerifier($token);
        if (!$userVerified) {
            return BaseResponse::unauthorize();
        }

        $request = new UpdateUserProfileRequest($this->db);
        $isRequestValid = $request->validate();
        if (!$isRequestValid) {
            return BaseResponse::error($request->getErrors());
        }

        $userProfile = new UserProfile($this->db);
        $userProfile->Name = $data['Name'] ?? $data['Username'];
        $userProfile->Address = $data['Address'] ?? null;
        $userProfile->UserId = $userVerified;

        if (!$userProfile->update()) {
            return BaseResponse::error("Failed to update profile");
        }
        
        return BaseResponse::success("Update profile successful");
    }
}