<?php

ini_set("display_errors",1);
error_reporting(E_ALL);

session_start();

if($_POST){
  // try to log in
    $db = new PDO("mysql:host=localhost;dbname=php", 'root', 'Grz.Sawi');
    $q = $db->prepare("SELECT id FROM users WHERE login = :login AND password = :password");
    $q->execute([
      'login' => $_POST['login'],
      'password' => $_POST['password'],
    ]);
    $user_id = $q->fetchColumn();
    if($user_id){
      // succeeded
      $_SESSION['user_id'] = $user_id;
      $_SESSION['login'] = $_POST['login'];
      exit(header("Location: account.php"));
    } else {
        $_SESSION['login_failed'] = true;
    }
}
?>

<form method="post">
  <div class="container">
    <label for="login"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="login" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <button type="submit">Login</button>
  </div>
</form>

<?php
// prompts
if(isset($_SESSION['account_created'])){
  unset($_SESSION['account_created']);
  echo "Account created successfully! Proceed to log in.<br>";
} else if(isset($_SESSION['login_failed'])){
    echo "Incorrect login or password.<br>";
}
?>

<br>
<a href="create_account.php">Create new account</a>