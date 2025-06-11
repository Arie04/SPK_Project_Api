<?php

class UpdateUserProfileRequest {
    private $data;
    private $errors = [];

    public function __construct() {
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    public function validate() {
        if (!$this->data) {
            $this->errors[] = 'Invalid JSON body';
            return false;
        }

        if (empty($this->data['Name'])) {
            $this->errors['Name'] = 'Name is required.';
        }

        if (empty($this->data['Address'])) {
            $this->errors['Address'] = 'Address is required.';
        }
        
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getData() {
        return $this->data;
    }
}
