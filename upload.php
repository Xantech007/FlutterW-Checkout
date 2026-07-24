<?php
// Disable displaying HTML errors to prevent breaking JSON output
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

// 1. Target directory
$targetDir = "receipts/";

// Create directory if it doesn't exist
if (!file_exists($targetDir)) {
    if (!mkdir($targetDir, 0777, true)) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to create receipts directory on server."
        ]);
        exit;
    }
}

// 2. Validate request method & file existence
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['receipt'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request or no file received."
    ]);
    exit;
}

$file = $_FILES['receipt'];

// 3. Check for PHP upload errors
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        "success" => false,
        "message" => "File upload error code: " . $file['error']
    ]);
    exit;
}

// 4. File size restriction (5MB limit)
$maxFileSize = 5 * 1024 * 1024; // 5 Megabytes
if ($file['size'] > $maxFileSize) {
    echo json_encode([
        "success" => false,
        "message" => "File size exceeds maximum limit of 5MB."
    ]);
    exit;
}

// 5. Allowed MIME types & extension check
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedMimeTypes)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid file type ($mimeType). Only JPG, PNG, and PDF files are allowed."
    ]);
    exit;
}

// 6. Generate a unique filename to avoid overwriting existing uploads
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (empty($fileExtension)) {
    // Fallback extensions based on MIME type
    if ($mimeType === 'application/pdf') $fileExtension = 'pdf';
    else if ($mimeType === 'image/png') $fileExtension = 'png';
    else $fileExtension = 'jpg';
}

$uniqueFileName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $fileExtension;
$targetFilePath = $targetDir . $uniqueFileName;

// 7. Move file to target directory
if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
    echo json_encode([
        "success" => true,
        "message" => "Receipt uploaded successfully.",
        "filePath" => $targetFilePath
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to save receipt file to server."
    ]);
}
exit;
?>
