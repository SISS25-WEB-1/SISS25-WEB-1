<?php
session_start();

// 데이터베이스 연결
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb') or die("fail");

$sql = "SELECT * FROM board ORDER BY board_id DESC";
$result = mysqli_query($conn, $sql);
if ($result == false) {
    echo '문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
}

$no_data = mysqli_num_rows($result) == 0;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageShare</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f4; }
        .container { width: 80%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; }
        .button { padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; background: black; color: white; text-decoration: none; font-size: 14px; }
        .button:hover { opacity: 0.8; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border-bottom: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #f0f0f0; }
        tr:hover { background: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><a href="index.php">PageShare</a></h1>
            <div>
                <a href="write.php" class="button">Write Post</a>
                <a href="myPage.php" class="button">My Page</a>
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>User</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($no_data) { 
                    echo "<tr><td colspan='5'>No posts available.</td></tr>";
                } else {
                    while ($rows = mysqli_fetch_assoc($result)) {
                        $board_date = new DateTime($rows['board_date']);
                        $formatted_date = $board_date->format('Y-m-d');
                ?>
                <tr>
                    <td><a href="read.php?idx=<?= $rows['board_id'] ?>"><?= htmlspecialchars($rows['board_title']) ?></a></td>
                    <td><?= htmlspecialchars($rows['book_title']) ?></td>
                    <td><?= htmlspecialchars($rows['book_author']) ?></td>
                    <td><?= htmlspecialchars($rows['board_user']) ?></td>
                    <td><?= $formatted_date; ?></td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
