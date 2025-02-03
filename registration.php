<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="registration-container">
    <h2>Registration</h2>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red; text-align:center;'>" . $_GET['error'] . "</p>";
    }

    if (isset($_GET['success'])) {
        echo "<p style='color:green; text-align:center;'>" . $_GET['success'] . "</p>";
    }
    ?>

    <form method="POST" action="php/registration_auth.php">
        <input type="text" name="username" class="input-field" placeholder="Username" required autocomplete="off"><br>
        <input type="email" name="email" class="input-field" placeholder="Email" required autocomplete="off"><br>
        <input type="password" name="password" class="input-field" placeholder="Password" required autocomplete="off"><br>
        <input type="text" name="course" class="input-field" placeholder="Course" required autocomplete="off"><br>
        <input type="text" name="department" class="input-field" placeholder="Department" required autocomplete="off"><br>

        <input type="hidden" value = "user" name="role">
        
        <button type="submit" class="btn">Register</button>
    </form>

    <a href="index.php">Back to Login</a>
</div>

</body>
</html>

