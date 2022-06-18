<?php
session_start();
if(!isset($_SESSION['user_id'])){
    exit(header("Location: login.php"));
}

if(!$_SESSION['items']){
    //load items
    $_SESSION['items'] = array();

    $file = 'items.txt';
    $lines = file($file);
    foreach($lines as $line){
        if(substr($line, 0, strlen($_SESSION['login']) + 1) != $_SESSION['login'] . ',') continue;

        $line = str_replace(array("\n", "\r"), '', $line);
        $arr = explode(',', $line);

        $gold = explode(':', $arr[1]);
        $_SESSION['items'][$gold[0]] = $gold[1];

        for($i = 2; $i < count($arr); $i++){
            $item = explode(':', $arr[$i]);
            $_SESSION['items'][$item[0]] = $item[1];
        }
        break;
    }
    //echo "Loaded items<br><br>";
}

echo 'Welcome, ' . $_SESSION['login'] . '!<br><br>';
?>

<a href="play.php">Enter the dungeon</a>
<br><br>
<a href="shop.php">Shop</a>
<br><br>
<a href="equipment.php">Check equipment</a>
<br><br>
<a href="logout.php">Log out</a>