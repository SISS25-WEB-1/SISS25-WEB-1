<?php
session_start();
if (!isset($_SESSION['id'])) {
    die("<script>alert('Login required.'); window.location.href = 'login.php';</script>");
}

$conn = new mysqli("localhost", "root", "1234", "winterweb");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $board_id = $_POST['board_id'];
    $board_title = $_POST['board_title'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $board_description = $_POST['board_description'];
    $user_id = $_SESSION['id'];
    
    // 파일 업로드 처리
    if (!empty($_FILES['upload_file']['name'])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["upload_file"]["name"]);
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file);
        
        $sql = "UPDATE board SET board_title=?, book_title=?, book_author=?, board_description=?, file_name=? WHERE board_id=? AND board_user=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $board_title, $book_title, $book_author, $board_description, $file_name, $board_id, $user_id);
    } else {
        $sql = "UPDATE board SET board_title=?, book_title=?, book_author=?, board_description=? WHERE board_id=? AND board_user=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $board_title, $book_title, $book_author, $board_description, $board_id, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Your post successfully updated.'); window.location.href = 'myPage.php';</script>";
    } else {
        echo "<script>alert('.'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
    exit;
}

$board_id = $_GET['id'];
$user_id = $_SESSION['id'];

$sql = "SELECT * FROM board WHERE board_id = ? AND board_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $board_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('No admission.'); window.location.href = 'myPage.php';</script>";
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Your Page!</h1>
    <h3><?= $_SESSION['id'] ?>님의 게시글 수정</h3>
    
    <form action="edit_post.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="board_id" value="<?= $board_id ?>">
        <p>
            <input type="text" name="board_title" value="<?= htmlspecialchars($row['board_title']) ?>" required>
        </p>
        <p>
            <input type="text" name="book_title" value="<?= htmlspecialchars($row['book_title']) ?>" required>
            <input type="text" name="book_author" value="<?= htmlspecialchars($row['book_author']) ?>" required>
        </p>
        <p>
            <textarea name="board_description" required rows="10" cols="50"><?= htmlspecialchars($row['board_description']) ?></textarea>
        </p>
        <p>
            <label>Current Image:</label><br>
            <?php if (!empty($row['file_name'])): ?>
                <img src="uploads/<?= htmlspecialchars($row['file_name']) ?>" alt="Current Image" width="150"><br>
            <?php endif; ?>
            <input type="file" name="upload_file">
        </p>
        <p>
            <input type="submit" value="Save Changes">
        </p>
        <p><a href="myPage.php">Go Back</a></p>
    </form>
</body>
</html>
