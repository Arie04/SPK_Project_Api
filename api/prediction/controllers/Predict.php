<?php

class Predict {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function predict($data, $token){
        $userTokenVerifier = new UserTokenVerifier($this->db);
        $userVerified = $userTokenVerifier->userTokenVerifier($token);
        if (!$userVerified) {
            return BaseResponse::unauthorize();
        }

        $request = new PredictRequest();
        $isRequestValid = $request->validate();
        if (!$isRequestValid){
            return BaseResponse::error($request->getErrors());
        }

        $cpu = (float)$data['CPUUsage'];
        $ram = (float)$data['RAMUsage'];
        $temp = (float)$data['Temperature'];
        $volt = (float)$data['Voltage'];
        $disk = (float)$data['DiskUsage'];
        $fan  = (float)$data['FanSpeed'];
    
        // Gabungkan jadi array lalu encode ke JSON
        $input_array = array($cpu, $ram, $temp, $volt, $disk, $fan);
        $json_input = json_encode($input_array);

        // Jalankan Python dan kirim JSON sebagai argumen
        $command = escapeshellcmd("python ../api/decisionTreePrediction/predict.py " . escapeshellarg($json_input));
        $output = trim(shell_exec($command));
        $predictLabel = (int)$output + 1;

        $conclusion = new Conclusion($this->db);
        $conclusion->ConclusionId = $predictLabel;
        
        $responseData = $conclusion->findById();
        if (!$responseData) {
            return BaseResponse::error("Data not found");
        }

        $history = new History($this->db);
        $history->ClientName = $data['ClientName'];
        $history->Date = $data['Date'];
        $history->DeviceType = $data['DeviceType'];
        $history->CPUUsage = $cpu;
        $history->RAMUsage = $ram;
        $history->Temperature = $temp;
        $history->Voltage = $volt;
        $history->DiskUsage = $disk;
        $history->FanSpeed = $fan;
        $history->ConclusionId = $predictLabel;
        $history->VerifiedByUser = $data['VerifiedByUser'];
        $history->UserId = $userVerified;
        
        if (!$history->create()) {
            return BaseResponse::error("Gagal menyimpan data history");
        }

        return BaseResponse::success($responseData);
    }
}

