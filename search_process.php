<?php
$conn = mysqli_connect('localhost', 'root', '1234', 'winterweb');

// main.php에서 검색 기준 , 검색어를 GET 방식으로 받아옴
$sb = $_GET['selectbox'];
$search = $_GET['search'];
//board 테이블의 $sb 컬럼명에서 $search 값이 들어간 데이터를 찾음 
$sql2 = "SELECT * FROM board WHERE `$sb` LIKE '%$search%' ORDER BY board_id DESC";
$result2 = mysqli_query($conn, $sql2);

if (!$result2) {
    die("fail " . mysqli_error($conn));  // 쿼리 실패 시 오류 메시지 출력
}
$row_num = mysqli_num_rows($result2);
if ($sb == 'book_title'){
    $type = '책 제목 ';
}else if ($sb == 'book_author'){
    $type = '작가';
}
else if ($sb =='board_user'){
    $type = '작성자';
}
else if ($sb =='category'){
    $type = '카테고리';
}
else{
    $type = '별점';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>

<h1>Page Share</h1>
<h3><?= $type ?> : '<?= $search ?>' 검색 결과 표시</h3>

<table width="100%" border="1px solid black">
    <thead>
        <tr>
            <th width="70">번호</th>
            <th width="400">제목</th>
            <th width="150">책 제목</th>
            <th width="150">작가</th>
            <th width="140">작성자</th>
            <th width="120">작성일자</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($row_num > 0) {
            while ($rows = mysqli_fetch_assoc($result2)) { ?>
                <tr>
                    <td><?= $rows['board_id'] ?></td>
                    <td ><a href = "read.php?idx=<?= $rows['board_id']?>"><h4><?= $rows['board_title'] ?></h4></a></td>
                    <td><?= $rows['book_title'] ?></td>
                    <td><?= $rows['book_author'] ?></td>
                    <td><?= $rows['board_user'] ?></td>
                    <td><?= $rows['board_date'] ?></td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="6">검색 결과가 없습니다.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>

