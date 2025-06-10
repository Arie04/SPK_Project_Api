<?php
$disk = 15;
$cpu = 60;
$ram = 80;
$volt = 11;
$temp = 72;
$fan  = 1900;

$input_array = array((float)$cpu, (float)$ram, (float)$temp, (float)$volt, (float)$disk, (float)$fan);
$json_input = json_encode($input_array);

// Jalankan Python dan kirim JSON sebagai argumen
$command = escapeshellcmd("python api/decisionTreePrediction/predict.py " . escapeshellarg($json_input));
$output = shell_exec($command);

echo "hasil prediksi";
echo $output;
