<?php

if($_POST){
    //check if login is unique
    $db = new PDO("mysql:host=localhost;dbname=php", 'root', 'Grz.Sawi');
    $q = $db->prepare("SELECT id FROM users WHERE login = :login");
    $q->execute([
        'login' => $_POST['login']
    ]);
    $unique_login = !(bool)$q->fetchColumn();

    //check passwords
    if($_POST['password1'] == $_POST['password2']) $passwords_are_matching = true;

    //check with regex
    $login_pattern = "/^[a-zA-Z0-9]{3,16}$/m";
    $password_pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,16}$/m";
    $email_pattern = "/^.+@.+\..+$/m";
    $correct_login = preg_match($login_pattern, $_POST['login']);
    $correct_password = preg_match($password_pattern, $_POST['password1']);
    $correct_email = preg_match($email_pattern, $_POST['email']);

    if($unique_login && $correct_login && $passwords_are_matching && $correct_password && $correct_email){
        session_start();
        $_SESSION['login_failed'] = false;
        $_SESSION['account_created'] = true;

        //create account
        $q = $db->prepare("INSERT INTO users (id, login, password) VALUES (:id, :login, :password)");
        $q->execute([
            'id' => NULL,
            'login' => $_POST['login'],
            'password' => $_POST['password1']
        ]);

        //create items
        $file = 'items.txt';
        $str = file_get_contents($file);
        $str .= "\n" . $_POST['login'] . ',Gold:100,Helmet:1,Chestplate:1,Leggings:1,Boots:1,Sword:1';
        file_put_contents($file, $str);

        exit(header('Location: login.php'));
    }
}
?>

<form action="" method="post">
  <div class="container">
    <label for="login"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="login" maxlength="16" required>

    <label for="password1"><b>Password</b></label>
    <input type="text" placeholder="Enter Password" name="password1" maxlength="16" required>

    <label for="password2"><b>Repeat Password</b></label>
    <input type="text" placeholder="Enter Password" name="password2" maxlength="16" required>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" maxlength="32" required>

    <button type="submit">Create</button>
  </div>
</form>

<?php
if($_POST){
    // promtps
    if(!$unique_login)
        echo "This login is already in use. Try again with a different one.<br>";
    if(!$correct_login)
        echo "Login has to be 3-16 characters long.<br>";
    if(!$passwords_are_matching){
        echo "Passwords aren't identical.<br>";
    } else{
        if(!$correct_password)
            echo "Password must be 3-16 characters long and contain at least one of each: uppercase and lowercase letter, digit and special character.<br>";
    }
    if(!$correct_email)
        echo "Email must resemble this pattern: email@domain.abc<br>";
}
?>

<br>
<a href="login.php">Login page</a><br><br>