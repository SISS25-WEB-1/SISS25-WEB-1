<?php
session_start();
$upload_dir = "profile_pictures/";

// 폴더 없으면 생성d하기기
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// 파일 업로드 확인
if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $original_filename = $_FILES['profile_picture']['name'];
    $extension = pathinfo($original_filename, PATHINFO_EXTENSION);
    
    // 새로운 파일명 (중복 방지)
    $new_filename = uniqid() . "." . $extension;
    $upload_file = $upload_dir . $new_filename;

    // 파일 이동
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
        echo "파일 업로드 성공!";

        // 데이터베이스에 저장 (사용자의 프로필 사진 경로 업데이트)
        $conn = new mysqli("localhost", "root", "1234", "winterweb");
        if ($conn->connect_error) {
            die("DB connection failed...: " . $conn->connect_error);
        }

        $user_id = $_SESSION['id'];
        $sql = "UPDATE user SET profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $upload_file, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Your profile successfully uploaded!');</script>";
        } else {
            echo "<script>alert('File upload failed!');</script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('File upload failed!');</script>";
    }
} else {
    echo "<script>alert('File upload error!');</script>";
}
?>
