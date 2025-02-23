<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb') or die("fail");

// 게시글 정보 가져오기
$board_id = $_GET['idx'];
$sql = "SELECT * FROM board WHERE board_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $board_id);
$stmt->execute();
$board = $stmt->get_result()->fetch_assoc();
$stmt->close();

// 댓글 가져오기
$comment_sql = "SELECT * FROM comments WHERE board_id = ? ORDER BY created_at ASC";
$comment_stmt = $conn->prepare($comment_sql);
$comment_stmt->bind_param("i", $board_id);
$comment_stmt->execute();
$comments = $comment_stmt->get_result();
$comment_stmt->close();

// 로그인한 사용자 정보
$user = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($board['board_title']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; display: flex; }
        .sidebar { width: 250px; padding: 20px; background: #f0f0f0; height: 100vh; }
        .content { flex-grow: 1; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .button { padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; }
        .edit-btn { background: black; color: white; }
        .delete-btn { background: black; color: white; }
        .back-btn { background: black; color: white; display: block; text-align: center; padding: 10px; }
        .comment-box { background: #f9f9f9; padding: 10px; border-radius: 5px; margin-top: 20px; }
        .comment { border-bottom: 1px solid #ddd; padding: 10px; }
        .comment:last-child { border-bottom: none; }
        .small-btn {
            padding: 4px 8px; /* 기존보다 더 작은 패딩 */
            font-size: 12px; /* 폰트 크기 줄이기 */
            border-radius: 3px; /* 모서리 둥글게 하기 */
            margin-top: 3px; /* 버튼 사이에 간격 */
            display: inline-block; /* 버튼이 한 줄로 나열되게 하기 */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><a href="main.php">Page Share</a></h2>
    </div>
    <div class="content">
        <div class="container">
            <h2><?= htmlspecialchars($board['board_title']) ?></h2>
            <?php if ($user == $board['board_user']) { ?>
                <a href="edit.php?idx=<?= $board['board_id'] ?>" class="button edit-btn">Edit</a>
                <a href="delete.php?idx=<?= $board['board_id'] ?>" class="button delete-btn">Delete</a>
            <?php } ?>
            <p><strong>Author:</strong> <?= htmlspecialchars($board['book_author']) ?></p>
            <p><?= nl2br(htmlspecialchars($board['board_description'])) ?></p>
            <?php if (!empty($board['file_name'])) { ?>
                <img src="uploads/<?= htmlspecialchars($board['file_name']) ?>" alt="Attached Image" style="width: 100%; border-radius: 5px;">
            <?php } ?>
            <a href="main.php" class="button back-btn">Go Back</a>
        </div>

        <!-- 댓글 작성 -->
        <div class="comment-box">
            <h3>Comments</h3>
            <form action="add_comment.php" method="POST">
                <input type="hidden" name="board_id" value="<?= $board_id ?>">
                <textarea name="comment_text" required style="width: 100%; height: 80px;"></textarea>
                <button type="submit" class="button edit-btn" style="width: 100%;">Post Comment</button>
            </form>
        </div>

        <!-- 댓글 목록 -->
        <div class="comment-box">
            <h3>All Comments</h3>
            <?php if ($comments->num_rows > 0) { ?>
                <?php while ($comment = $comments->fetch_assoc()) { ?>
                    <div class="comment">
                        <p><strong><?= htmlspecialchars($comment['user_id']) ?>:</strong></p>
                        <p><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></p>
                        <small><?= $comment['created_at'] ?></small>
                
                        <!-- 수정과 삭제 버튼 (크기 조정) -->
                        <?php if ($user == $comment['user_id']) { ?>
                            <a href="edit_comment.php?comment_id=<?= $comment['comment_id'] ?>&idx=<?= $board_id ?>" class="button edit-btn small-btn" style="margin-top: 5px;">Edit</a>
                            <a href="delete_comment.php?comment_id=<?= $comment['comment_id'] ?>&idx=<?= $board_id ?>" class="button delete-btn small-btn" style="margin-top: 5px;">Delete</a>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No comments yet. Be the first to comment!</p>
            <?php } ?>
        </div>
</body>
</html>
