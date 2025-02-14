<?php
session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>write</title>
</head>
<body>
    <h1>Share Your Page! </h1> 
    <h3><?= $_SESSION['id'] ?>님의 page입니다</h3>
    
    <form action = "write_process.php" method = "POST" enctype = "multipart/form-data">
    <p>
    <input type = "text" name = "board_title" placeholder = "글제목" required>
    </p>
    <p>
    <input type = "text" name = "title" placeholder = "Book Title" required>
    <input type ="text" name ="author" placeholder = "author" required>
    <p>
            <select name="category" required>
                <option value="소설">소설</option>
                <option value="자기계발">자기계발</option>
                <option value="경제/경영">경제/경영</option>
                <option value="비문학">비문학</option>
                <option value="실용서">실용서</option>
                <option value ="예술/디자인">예술/디자인</option>
                <option value ="그외">그외</option>
            </select>
            + Choose Category
        </p>
    </p>
    <p><textarea name = "description" placeholder = "Enter details..." required rows="30" cols="100%"></textarea></p>
    <p><input type = "file" value = "upload_file" name = "upload_file"> + Share Image! </p>
    <p><input type="submit"  value = "upload"></p>
    <p><a href = "main.php">Go Back</a></p>
    </form>
    
</body>
</html>