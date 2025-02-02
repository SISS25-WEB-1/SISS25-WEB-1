<?php
session_start();
 
// 데이터베이스 연결
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb') or die("fail");

$user = $_SESSION['id'];

// POST로 입력받은 데이터 변수에 넣기
$board_title = mysqli_real_escape_string($conn, $_POST['board_title']);
$author = mysqli_real_escape_string($conn, $_POST['author']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$title = mysqli_real_escape_string($conn, $_POST['title']);

// 파일 업로드 
$upload_dir = 'uploads/';
$file_name = NULL; 
$file_tmp = NULL;
$upload_path = NULL;

// 디렉토리가 존재하지 않으면 생성 (uploads/디렉토리 밑에 생성하기 위해)
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true); // 디렉토리 권한 부여
}

// 파일이 업로드되었을 경우
if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
    // 파일명 처리
    $file_name = iconv("UTF-8", "EUC-KR", $_FILES['upload_file']['name']);
    $file_tmp = $_FILES['upload_file']['tmp_name'];
    $upload_path = $upload_dir . basename($file_name);

    if (!move_uploaded_file($file_tmp, $upload_path)) {
        echo "파일 업로드 실패";
        exit;
    }
}

$sql = "INSERT INTO board (board_user, board_title, book_title, book_author, board_description, board_date, file_name) 
        VALUES ('$user', '$board_title', '$title', '$author', '$description', NOW(), '$file_name')";

$result = mysqli_query($conn, $sql);

if ($result == false) {
    echo '문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
} else {
    echo "<script>alert('uploaded!');
    window.location.href = 'main.php';</script>";
}

mysqli_close($conn);
?>
