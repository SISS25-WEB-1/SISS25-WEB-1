<?php
session_start();

// 로그인 확인
if (!isset($_SESSION['id'])) {
    die("로그인이 필요합니다.");
}

// 데이터베이스 연결
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb');

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// POST 데이터 받기
$board_id = isset($_POST['board_id']) ? intval($_POST['board_id']) : 0;
$comment_text = isset($_POST['comment_text']) ? trim($_POST['comment_text']) : '';
$user_id = $_SESSION['id']; // 로그인한 사용자 ID

// 입력값 검증
if ($board_id <= 0 || empty($comment_text)) {
    die("모든 필드를 입력해야 합니다.");
}

// SQL 실행 (Prepared Statement 사용)
$sql = "INSERT INTO comments (board_id, user_id, comment_text) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $board_id, $user_id, $comment_text);

if ($stmt->execute()) {
    header("Location: read.php?idx=$board_id");
    exit;
} else {
    echo "댓글 추가 실패: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
