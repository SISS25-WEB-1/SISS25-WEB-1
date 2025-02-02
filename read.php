<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb') or die("fail");

$board_id = $_GET['idx'];
$sql = "SELECT * FROM board WHERE board_id = $board_id";
$result = mysqli_query($conn, $sql);
$board = mysqli_fetch_assoc($result);

$user = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title><?= $board['board_title'] ?></title>
    
</head>
<body>
    
    <h2><?= $board['board_title'] ?></h2>
    <p>
    <!--현재 로그인된 user가 (세션 참고) 게시판 작성자 유저와 같은 경우 delete / edit 버튼 추가 -->
    <?php
    if ($user == $board['board_user']){
    ?>
    <a href="edit.php?idx=<?= $board['board_id'] ?>"><input type="button" value="edit"></a>
    <a href="delete.php?idx=<?= $board['board_id'] ?>"><input type="button" value="delete"></a>
    <?php } ?>   
    </p>
    <hr>
    <h3>📖 <?= $board['book_title'] ?></h3> <h4>✍ <?= $board['book_author'] ?></h4>
 
    <p>  작성자 : <?= $board['board_user'] ?></p>
    <p>📅 date <?= date("Y-m-d", strtotime($board['board_date'])) ?></p>
    
    <hr>
    <p><?= nl2br($board['board_description']) ?></p>
    <!--보드의 filename 이 NULL이지 않은 경우 uploads 파일 경로의 이미지를 불러옴 -->
    <?php if (!empty($board['file_name'])){ ?>
        <p><img src="uploads/<?= $board['file_name'] ?>" width="400" height="400"></p>
    <?php } ?>
    <hr>
    
    <p>
    <a href="main.php"><input type = "button" value = "Go Back"></input></a>
    </p>
</body>
</html>

