<?php
session_start();

if(!isset($_SESSION['user_id'])){
    exit(header("Location: login.php"));
}

echo 'Nick: ' . $_SESSION['login'] . '<br><br>';

foreach($_SESSION['items'] as $key => $val){
    if($key == 'Gold'){
        echo "$key - $val<br>";
    } elseif($key == 'Healing Potion'){
        echo "$key - $val/5<br>";
    } else{
        echo "$key - lvl $val<br>";
    }
}
?>

<br>
<a href="account.php">Go back</a>