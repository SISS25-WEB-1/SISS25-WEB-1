<?php
session_start(); // 세션 시작

// 로그인 확인
if (!isset($_SESSION['id'])) {
    echo "<script>
        alert('Login requird.');
        window.location.href = 'login.php'; 
    </script>";
    exit;
}

// 데이터베이스 연결
$host = 'localhost';
$user = 'root';
$pass = '1234';
$db = 'winterweb';

$conn = new mysqli($host, $user, $pass, $db);

// 연결 확인
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

// 현재 로그인된 사용자 ID 가져오기
$user_id = $_SESSION['id'];

// 사용자 정보 가져오기
$sql = "SELECT name, email, password, profile_picture FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $password, $profile_picture);
$stmt->fetch();
$stmt->close();

// 사용자의 게시글 가져오기
$sql = "SELECT board_id, board_title FROM board WHERE board_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// 기본 프로필 이미지 설정
$profile_picture = $profile_picture ? "profile_pictures/$profile_picture" : "default_profile.png";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Page</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { display: flex; }
        .sidebar { width: 200px; padding: 20px; border-right: 1px solid #ccc; }
        .content { flex-grow: 1; padding: 20px; }
        .profile-box { background: #f0f0f0; padding: 15px; border-radius: 10px; text-align: center; }
        .profile-box img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }
        .profile-box p { margin: 5px 0; }
        .form-group { margin: 10px 0; }
        .buttons { text-align: right; margin-top: 10px; }
    </style>
</head>
<body>

<div class="container">
    <!-- 사이드바 -->
    <div class="sidebar">
        <h2><a href="main.php">PageShare</a></h2>
    </div>

    <!-- 메인 콘텐츠 -->
    <div class="content">
        <h2>My Page</h2>
        <div class="profile-box">
            <img src="<?= $profile_picture ?>" alt="Profile Picture">
            <form action="upload_profile.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_picture" required>
                <button type="submit">Upload</button>
            </form>
        </div>

        <!-- 정보 수정 폼 -->
        <form action="update_profile.php" method="POST">
            <div class="form-group">
                <label>ID: </label>
                <input type="text" name="new_id" value="<?= htmlspecialchars($user_id) ?>" required>
            </div>
            <div class="form-group">
                <label>Email: </label>
                <input type="email" name="new_email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="form-group">
                <label>New Password: </label>
                <input type="password" name="new_password" placeholder="new password">
            </div>
            <button type="submit">Save Changes</button>
        </form>

        <div class="post-list">
            <h3>My Posts</h3>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div>
                    <span><?= htmlspecialchars($row['board_title']) ?></span>
                    <span>
                        <a href="edit_post.php?id=<?= $row['board_id'] ?>">Edit</a> |
                        <a href="delete_post.php?id=<?= $row['board_id'] ?>" onclick="return confirm('Are you sure you want to delete');">Delete</a>
                    </span>
                </div>
            <?php } ?>
        </div>

        <div class="buttons">
            <button onclick="location.href='logout.php'">Logout</button>
        </div>
    </div>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
