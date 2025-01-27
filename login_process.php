<?php
// 데이터베이스 연결 정보
$host = 'localhost'; // MySQL 서버 주소
$user = 'root'; // MySQL 사용자 이름
$pass = ''; // MySQL 사용자 비밀번호
$db = 'winterWeb'; // 사용할 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($host, $user, $pass, $db);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 폼 데이터 가져오기
$id = $_POST['id']; // 사용자 ID
$password = $_POST['password']; // 사용자 비밀번호

// 데이터베이스에서 ID 검색
$sql = "SELECT password FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->store_result();

// 결과 확인
if ($stmt->num_rows > 0) {
    $stmt->bind_result($stored_password);
    $stmt->fetch();

    // 비밀번호 확인
    if ($password === $stored_password) {
        echo "Login successful!";
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}

// 정리
$stmt->close();
$conn->close();
?>
