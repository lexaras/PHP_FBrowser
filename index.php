<?php 
session_start();
//logout logic
if(isset($_GET['action']) && $_GET['action'] == 'logout'){
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
    print('Logged out!');
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File browser</title>
</head>
<body>
    <h2>Enter Username and Password</h2>
    <div>
        <?php
        $msg = '';
        if(isset($_POST['login'])
            && !empty($_POST['username'])
            && !empty($_POST['password'])
        ){
            if ($_POST['username'] == 'Benas' && 
            $_POST['password']== 'qwerty123')
            {
                $_SESSION['logged_in'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = "Benas";
                echo 'You have entered valid username and password';
            } else{
                $msg = 'Wrong username or password';
            }
        }
        ?>
    </div>
    <div>
        <?php
        if($_SESSION['logged_in']==true){
          //  require(kitas page);
        }
        ?>
        <form action="./mano.php" method="post">
        <h4><?php echo $msg; ?></h4>
        <input type="text" name="username" placeholder="username = Benas" required autofocus></br>
        <input type="password" name="password" placeholder="password = qwerty123" required>
        <button class="btn" type="submit" name="login">Login</button>
    </form>
    Click here to<a href="index.php?action=logout"> logout.
    </div>
</body>
</html>