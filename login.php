<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/button.css">
</head>
<body>
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
</body>
</html>
