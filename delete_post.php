<?php
session_start();
if (!isset($_SESSION['id'])) {
    die("<script>alert('로그인이 필요합니다.'); window.location.href = 'login.php';</script>");
}

$conn = new mysqli("localhost", "root", "1234", "winterweb");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $board_id = $_GET['id'];
    $user_id = $_SESSION['id'];
    
    // 삭제할 파일 이름 가져오기
    $sql = "SELECT file_name FROM board WHERE board_id = ? AND board_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $board_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($file_name);
    $stmt->fetch();
    $stmt->close();
    
    // 파일이 존재하면 삭제
    if (!empty($file_name) && file_exists("uploads/" . $file_name)) {
        unlink("uploads/" . $file_name);
    }
    
    // 게시글 삭제
    $sql = "DELETE FROM board WHERE board_id = ? AND board_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $board_id, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Post successfully deleted!'); window.location.href = 'myPage.php';</script>";
    } else {
        echo "<script>alert('Failed to delete post...'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>