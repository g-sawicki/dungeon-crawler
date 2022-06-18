<?php

ini_set("display_errors",1);
error_reporting(E_ALL);

session_start();
if(!isset($_SESSION['user_id'])){
    exit(header("Location: login.php"));
}

$max_level = array(
    'Helmet' => 10,
    'Chestplate' => 10,
    'Leggings' => 10,
    'Boots' => 10,
    'Sword' => 10
);

$file = 'shop.txt';
$lines = file($file);
$products = array();
foreach($lines as $line){
    $line = str_replace(array("\n", "\r"), '', $line);
    $arr = explode(',', $line);
    $products[$arr[0]] = $arr[1];
}

if($_POST){
    if(isset($_POST['item'])){
        if(isset($_SESSION['cart'][$_POST['item']]))
            $_SESSION['cart'][$_POST['item']]++;
        else
            $_SESSION['cart'][$_POST['item']] = 1;
    } elseif (isset($_POST['remove'])) {
        unset($_SESSION['cart'][$_POST['remove']]);
    } elseif (isset($_POST['empty'])) {
        unset($_SESSION['cart']);
    } elseif(isset($_POST['buy'])){
        $file = 'items.txt';
        $lines = file($file);
        foreach($lines as &$line){
            if(substr($line, 0, strlen($_SESSION['login'])) != $_SESSION['login']) continue;

            $line = str_replace(array("\n", "\r"), '', $line);
            $arr = explode(',', $line);

            $new_line = array($arr[0]);

            $gold = explode(':', $arr[1]);
            $gold[1] -= $_POST['buy'];
            $_SESSION['items'][$gold[0]] = $gold[1];
            $gold = implode(':', $gold);
            array_push($new_line, $gold);

            for($i = 2; $i < count($arr); $i++){
                $item = explode(':', $arr[$i]);
                if(isset($_SESSION['cart'][$item[0]]))
                    $item[1] += $_SESSION['cart'][$item[0]];
                $_SESSION['items'][$item[0]] = $item[1];
                array_push($new_line, implode(':',$item));
            }
            $line = implode(',', $new_line) . "\n";
            break;
        }
        file_put_contents($file, $lines);
        unset($_SESSION['cart']);
    }
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}
?>

<form method="post">
    <?php
    //items
    echo "Gold: " . $_SESSION['items']['Gold'] . "<br>";
    foreach($products as $name => $value){
        if(!isset($_SESSION['cart'][$name])){
            if($_SESSION['items'][$name] + 1 <= $max_level[$name]){
                echo "<button type='submit' name='item' value='$name'>$name lvl ".($_SESSION['items'][$name] + 1).": ".$value * ($_SESSION['items'][$name] + 1)."</button><br>";
            }
        }
    }
    //cart
    echo '<br>Cart:<br>';
    $isEmpty = true;
    $price = 0;
    foreach($_SESSION["cart"] as $name => $value){
        if($value > 0){
            $price += $products[$name] * ($_SESSION['items'][$name] + 1);
            echo " <button type='submit' name='remove' value='$name'>remove</button>";
            echo $name . ' upgrade<br>';
            $isEmpty = false;
        }
    }
    //other
    if($isEmpty) echo ' empty<br>';
    else{
        echo " <input type='submit' name='empty' value='Empty the cart'><br><br>";
        echo "Total: $price<br>";
        if($_SESSION['items']['Gold'] >= $price)
            echo " <button type='submit' name='buy' value='$price'>Buy</button>";
    }
    ?>
</form>

<a href="account.php">Go back</a>