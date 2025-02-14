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
    <?php
    if ($user == $board['board_user']){
    ?>
    <a href="edit.php?idx=<?= $board['board_id'] ?>"><input type="button" value="edit"></a>
    <a href="delete.php?idx=<?= $board['board_id'] ?>"><input type="button" value="delete"></a>
    <?php } ?>   
    </p>
    <hr>
    <h3>#<?=$board['category']?></h3>
    <h3>📖 <?= $board['book_title'] ?></h3> <h4>✍ <?= $board['book_author'] ?></h4>
 
    <p>  작성자 : <?= $board['board_user'] ?></p>
    <p>📅 date <?= date("Y-m-d", strtotime($board['board_date'])) ?></p>
    
    <hr>
    <p><?= nl2br($board['board_description']) ?></p>
    
    <?php if (!empty($board['file_name'])){ ?>
        <p><img src="uploads/<?= $board['file_name'] ?>" width="400" height="400"></p>
    <?php } ?>
    <hr>
    
    <p>
    <a href="main.php"><input type = "button" value = "Go Back"></input></a>
    </p>
    <br>
    <div class ="reply">
    <h3>댓글 목록</h3>
    </div>
</body>
</html>

