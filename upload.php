<?php
$fullname   = $_POST['fullname'] ?? '';
$address    = $_POST['address'] ?? '';
$email      = $_POST['email'] ?? '';
$phone      = $_POST['phone'] ?? '';
$position   = $_POST['position'] ?? '';

$uploadDir = "../dashboard/uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

function saveFile($fileKey, $uploadDir) {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
        $filename = time() . "_" . basename($_FILES[$fileKey]['name']);
        $targetPath = $uploadDir . $filename;
        move_uploaded_file($_FILES[$fileKey]['tmp_name'], $targetPath);
        return "uploads/" . $filename;
    }
    return '';
}


$cv = saveFile('cv', $uploadDir);
$application_letter = saveFile('application_letter', $uploadDir);
$resume = saveFile('resume', $uploadDir);
$degree = saveFile('degree', $uploadDir);
$certificates = saveFile('certificates', $uploadDir);

$dataFile = "../dashboard/data.json";
$data = [];
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
}

$newEntry = [
    "fullname" => $fullname,
    "address" => $address,
    "email" => $email,
    "phone" => $phone,
    "position" => $position,
    "cv" => $cv,
    "application_letter" => $application_letter,
    "resume" => $resume,
    "degree" => $degree,
    "certificates" => $certificates,
    "status" => "Menunggu"
];

$data[] = $newEntry;
file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

echo "Data berhasil dikirim! <a href='dashboard.php'>Lihat Dashboard</a>";
header("Location: terimakasih.php");
exit;
