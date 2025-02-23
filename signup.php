<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            width: 300px; /* 폼 너비 */
            margin-top: 10px; /* 제목과 간격 조정 */
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
        <h1>Sign up</h1> 
        <form action="signup_process.php" method="POST">
            <label for="id">ID</label>
            <input type="text" name="id" id="id" required>

            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>

            <label for="email">E-mail</label>
            <input type="text" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button id="signup_button" type="submit">Sign up</button>
        </form>
    </div>
</body>
</html>
