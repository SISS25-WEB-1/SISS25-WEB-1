<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        /* 화면 중앙 정렬 */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* 전체 화면 높이 */
            background-color: #f4f4f4; /* 배경 색상 (연한 회색) */
            margin: 0;
        }

        /* 제목 + 폼을 감싸는 컨테이너 */
        .container {
            text-align: center;
        }

        /* 회색 배경 폼 스타일 */
        form {
            padding: 20px;
            text-align: center;
            width: 300px; 
            margin-top: 10px; 
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #aaa;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Login</h1>
    <form action="login_process.php" method="POST">
        <label for="id">ID</label>
        <br>
        <input type="text" name="id" id="id" required>
        <br>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password" required>
        <br>
        <button id="login_button" type="submit">Login</button>
    </form>
</div>
</body>
</html>
