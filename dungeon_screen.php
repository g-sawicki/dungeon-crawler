<?php

session_start();

if(!isset($_SESSION['user_id'])){
    exit(header("Location: login.php"));
}

if(isset($_SESSION['play'])){
    if(isset($_SESSION['play']['isDead'])){
        if($_SESSION['play']['isDead']){
            echo "You Died<br><br>";
        } else {
            echo "You killed the boss<br><br>";
        }
    }

    echo "Gold looted: " . $_SESSION['loot']['gold'] . '<br>';
    echo "Enemies killed: " . $_SESSION['loot']['enemies'] . '<br>';
    echo "Treasures found: " . $_SESSION['loot']['treasures'] . '<br><br>';

    $file = 'items.txt';
    $lines = file($file);
    foreach($lines as &$line){
        if(substr($line, 0, strlen($_SESSION['login'])) != $_SESSION['login']) continue;

        $line = str_replace(array("\n", "\r"), '', $line);
        $arr = explode(',', $line);

        $new_line = array($arr[0]);

        $gold = explode(':', $arr[1]);
        $gold[1] += $_SESSION['loot']['gold'];
        $_SESSION['items'][$gold[0]] = $gold[1];
        $gold = implode(':', $gold);
        array_push($new_line, $gold);

        for($i = 2; $i < count($arr); $i++){
            array_push($new_line, $arr[$i]);
        }
        $line = implode(',', $new_line) . "\n";
        break;
    }
    file_put_contents($file, $lines);

    unset($_SESSION['play']);
    unset($_SESSION['loot']);
}
?>

<a href="account.php">Menu</a>