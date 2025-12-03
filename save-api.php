<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli(
    "sql100.infinityfree.com",
    "if0_40590891",
    "JnxF6pWuQV",
    "if0_40590891_QUIZLETEMRIP"
);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$title = $conn->real_escape_string($data["title"]);
$category = $conn->real_escape_string($data["category"]);
$filename = $conn->real_escape_string($data["filename"]);
$questions = $conn->real_escape_string(json_encode($data["questions"]));
$chapters = $conn->real_escape_string(json_encode($data["chapters"]));
$pdftext = $conn->real_escape_string(substr($data["pdf_text"], 0, 10000));
$qcount = intval($data["question_count"]);

$sql = "INSERT INTO quizzes (title, category, filename, questions, chapters, pdf_text, question_count)
        VALUES ('$title', '$category', '$filename', '$questions', '$chapters', '$pdftext', $qcount)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "id" => $conn->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
