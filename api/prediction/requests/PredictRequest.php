<?php

class PredictRequest {
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
        
        if (empty($this->data['ClientName'])) {
            $this->errors['ClientName'] = 'ClientName is required.';
        } 

        if (empty($this->data['Date'])) {
            $this->errors['Date'] = 'Date is required.';
        } 

        if (empty($this->data['DeviceType'])) {
            $this->errors['DeviceType'] = 'DeviceType is required.';
        } 
        
        if (empty($this->data['CPUUsage'])) {
            $this->errors['CPUUsage'] = 'CPUUsage is required.';
        } 

        if (empty($this->data['RAMUsage'])) {
            $this->errors['RAMUsage'] = 'RAMUsage is required.';
        } 

        if (empty($this->data['Temperature'])) {
            $this->errors['Temperature'] = 'Temperature is required.';
        } 

        if (empty($this->data['Voltage'])) {
            $this->errors['Voltage'] = 'Voltage is required.';
        } 

        if (empty($this->data['DiskUsage'])) {
            $this->errors['DiskUsage'] = 'DiskUsage is required.';
        } 

        if (empty($this->data['FanSpeed'])) {
            $this->errors['FanSpeed'] = 'FanSpeed is required.';
        } 

        if (empty($this->data['VerifiedByUser'])) {
            $this->errors['VerifiedByUser'] = 'VerifiedByUser is required.';
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
