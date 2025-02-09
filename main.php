<?php
session_start(); //향후 로그인 아이디 기억 후 수정 등 수행하기 위해?
 
// 데이터베이스 연결 , conn.php 파일 따로 만들어서 빼기
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb') or die("fail");

$sql = "SELECT * FROM board ORDER BY board_id DESC"; //역순 출력 
$result = mysqli_query($conn, $sql);
if ($result == false) {
    echo '문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
}
//data가 있는 지 없는 지 확인하기 위해서 
if (mysqli_num_rows($result) == 0) {
    $no_data = true; 
} else {
    $no_data = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>read</title>
</head>
<body>
    <h1><a href="index.php">PageShare</a></h1>
    <a href="write.php"><input type="button" value="Go To Write Post!!"></a>
    <a href="myPage.php"><input type="button" value="My Page"></a>
    <p>
    <table align="center">
        <tbody align="center">
            <?php 
            if ($no_data) { 
                echo "<tr><td colspan='5'>No posts available.</td></tr>";
            } else {
                while ($rows = mysqli_fetch_assoc($result)) {
                    
                    $board_date = new DateTime($rows['board_date']);
                    $formatted_date = $board_date->format('Y-m-d');
            ?>
            <tr>
                <td width="400"><a href = "read.php?idx=<?= $rows['board_id']?>"><h4><?= $rows['board_title'] ?></h4></a></td>
                <td width="150"><?= $rows['book_title'] ?></td>
                <td width="150"><?= $rows['book_author'] ?></td>
                <td width="140"><?= $rows['board_user'] ?></td> 
                <td width="120"><?= $formatted_date; ?></td>
            </tr>
                    
            <?php
                }
            }
            ?>
        </tbody>
    </table>
    </p>
</body>
</html>
