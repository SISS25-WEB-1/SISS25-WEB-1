<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb') or die("Database connection failed");

$comment_id = $_GET['comment_id'];
$board_id = $_GET['idx'];
$user_id = $_SESSION['id']; // 현재 로그인한 사용자 ID

// 해당 댓글 가져오기
$sql = "SELECT * FROM comments WHERE comment_id = $comment_id";
$result = mysqli_query($conn, $sql);
$comment = mysqli_fetch_assoc($result);

if (!$comment || $comment['user_id'] !== $user_id) {
    die("수정 권한이 없습니다.");
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>댓글 수정</title>
</head>
<body>
    <h2>댓글 수정</h2>
    <form action="update_comment.php" method="POST">
        <input type="hidden" name="comment_id" value="<?= $comment_id ?>">
        <input type="hidden" name="board_id" value="<?= $board_id ?>">
        <textarea name="comment_text" required><?= htmlspecialchars($comment['comment_text']) ?></textarea>
        <input type="submit" value="수정 완료">
    </form>
</body>
</html>
