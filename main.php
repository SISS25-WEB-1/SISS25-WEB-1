<?php
session_start(); 

// 데이터베이스 연결
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb') or die("fail");

$sql = "SELECT * FROM board ORDER BY board_id DESC"; 
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("fail " . mysqli_error($conn));
}

$num = mysqli_num_rows($result); 
$no_data = ($num == 0);

// 페이징 처리
$list_num = 10;
$page_num = 5;
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$total_page = ceil($num / $list_num);
$total_block = ceil($total_page / $page_num);
$now_block = ceil($page / $page_num);

$s_pageNum = ($now_block - 1) * $page_num + 1;
$s_pageNum = max($s_pageNum, 1);

$e_pageNum = min($now_block * $page_num, $total_page);
$start = ($page - 1) * $list_num;

$sql = "SELECT * FROM board ORDER BY board_date DESC LIMIT $start, $list_num";
$result2 = mysqli_query($conn, $sql);
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
            <a href="logout.php" class="button">Logout</a>
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
                while ($rows = mysqli_fetch_assoc($result2)) { 
                    $formatted_date = date('Y-m-d', strtotime($rows['board_date']));
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
    <div class="paging">

    <?php if ($page >= 1) { ?> 
        <a href="main.php?page=<?php if ($page ==1) {$page = 2;} echo ($page - 1) ?>">PREV</a> <!-- 이전 페이지로 이동 -->
    <?php } ?>

    <?php
    for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) { ?>
        <a href="main.php?page=<?= $print_page; ?>"
          >
           <?= $print_page; ?>
        </a>
    <?php } ?>

    <?php if ($page <= $total_page) { ?>
        <a href="main.php?page=<?= ($page < $total_page) ? ($page + 1) : $total_page ?>">NEXT</a>
    <?php } ?>

</div>

    </div>
</div>

</body>
</html>
