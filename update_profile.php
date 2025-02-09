<?php
session_start();
if (!isset($_SESSION['id'])) {
    die("Login required.");
}

$conn = new mysqli("localhost", "root", "1234", "winterweb");

// 입력값 가져오기
$new_id = $_POST["new_id"];
$new_email = $_POST["new_email"];
$new_password = $_POST["new_password"];

// 기존 ID
$current_id = $_SESSION['id'];

// ID, Email 업데이트
$sql = "UPDATE user SET id = ?, email = ?" . ($new_password ? ", password = ?" : "") . " WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($new_password) {
    $stmt->bind_param("ssss", $new_id, $new_email, $new_password, $current_id);
} else {
    $stmt->bind_param("sss", $new_id, $new_email, $current_id);
}

$stmt->execute();
$stmt->close();
$conn->close();

// 세션 업데이트
$_SESSION['id'] = $new_id;

echo "<script>alert('Successfully updated!'); window.location.href='myPage.php';</script>";
?>
