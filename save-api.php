<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "sql100.infinityfree.com";
$username = "if0_40590891";
$password = "JnxF6pWuQV";
$dbname = "if0_40590891_QUIZLETEMRIP";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed"]));
}

$data = json_decode(file_get_contents('php://input'), true);

$stmt = $conn->prepare("INSERT INTO saved_quizzes (user_id, title, filename, questions, chapters, pdf_text) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", 
    $data['userId'],
    $data['title'],
    $data['filename'],
    json_encode($data['questions']),
    json_encode($data['chapters']),
    $data['pdfText']
);

if($stmt->execute()){
    echo json_encode(["success" => true, "id" => $stmt->insert_id]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
