<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb') or die("Database connection failed");

$comment_id = $_GET['comment_id'];
$board_id = $_GET['idx'];
$user_id = $_SESSION['id']; // 현재 로그인한 사용자 ID

// 댓글 작성자 확인
$check_sql = "SELECT user_id FROM comments WHERE comment_id = $comment_id";
$check_result = mysqli_query($conn, $check_sql);
$comment = mysqli_fetch_assoc($check_result);

if (!$comment) {
    die("댓글이 존재하지 않습니다.");
}

// 본인 댓글인지 확인 후 삭제
if ($comment['user_id'] === $user_id) {
    $sql = "DELETE FROM comments WHERE comment_id = $comment_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: view.php?idx=$board_id");
        exit;
    } else {
        echo "댓글 삭제 실패: " . mysqli_error($conn);
    }
} else {
    die("삭제 권한이 없습니다.");
}
?>
