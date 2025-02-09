<?php
// MySQL 연결 설정
$host = 'localhost'; // 데이터베이스 호스트
$db = 'winterWeb'; // 데이터베이스 이름
$user = 'root'; // MySQL 사용자 이름
$pass = '1234'; // MySQL 비밀번호

// 데이터베이스 연결
$conn = new mysqli($host, $user, $pass, $db);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 폼 데이터 가져오기
$id = $_POST['id']; // 사용자 ID
$name = $_POST['name']; // 사용자 이름
$email = $_POST['email']; // 이메일
$password = $_POST['password']; // 비밀번호

// INSERT 쿼리 준비
$sql = "INSERT INTO user (id, name, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $id, $name, $email, $password);

// 실행 및 결과 확인
if ($stmt->execute()) {
    echo "Sign up successful! <a href='login.php'>Go to login</a>";
} else {
    echo "Error: " . $stmt->error;
}

// 정리
$stmt->close();
$conn->close();
?>
