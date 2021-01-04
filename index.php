<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/normalize.css">
    <title>File browser</title>
</head>

<body>
    <?php
    session_start();
    if (
        isset($_POST['login'])
        && !empty($_POST['username'])
        && !empty($_POST['password'])
    ) {
        if (
            $_POST['username'] == 'Benas' &&
            $_POST['password'] == '12345'
        ) {
            $_SESSION['logged_in'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = "Benas";
        } else {
            print('<h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Wrong username or password</h4>');
        }
    }
    ?>

    <div>
        <?php
        //logout logic
        if (isset($_GET['action']) && $_GET['action'] == 'logout') {
            session_start();
            unset($_SESSION['username']);
            unset($_SESSION['password']);
            unset($_SESSION['logged_in']);
            print('<h4>You have been successfully logged out!</h4>');
        }
        //login logic
        if ($_SESSION['logged_in'] == true) {
            require('driver.php');
        } else {
        ?>
            <form id="login" action="./index.php" method="post">
                <p> <img src="css/images.png" >Sign up  </p>
                <input type="text" name="username" placeholder="username = Benas" required autofocus></br>
                <input type="password" name="password" placeholder="password = 12345" required>
                <button class="button1" type="submit" name="login">Login</button>
                
            <?php } ?>
    </div>
</body>

</html>