<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/button.css">
</head>
<body>
    <h1>Sign up</h1>
    <form action="signup_process.php" method="POST">
 
      <label for="id">ID</label>
      <br>
      <input type="text" name="id" id="id" required>
      <br>
      <label for="name">Name</label>
      <br>
      <input type="text" name="name" id="name" required>
      <br>
      <label for="email">E-mail</label>
      <br>
      <input type="text" name="email" id="email" required>
      <br>
      <label for="password">Password</label>
      <br>
      <input type="password" name="password" id="password" required>
      <br>
      <button id="signup_button" type="submit">Sign up</button>
    </form>
</body>
</html>
