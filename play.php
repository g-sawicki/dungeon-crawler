<?php
ini_set("display_errors",1);
error_reporting(E_ALL);

require_once('Dungeon.php');
require_once('Entity.php');

session_start();

if(!isset($_SESSION['user_id'])){
    exit(header("Location: login.php"));
}

$rooms = 20;

if($_POST){
    if(isset($_POST['enter']) && !isset($_SESSION['play']['dungeon'])){
        $_SESSION['play'] = array();
        $_SESSION['loot'] = array();
        $_SESSION['loot']['gold'] = 0;
        $_SESSION['loot']['enemies'] = 0;
        $_SESSION['loot']['treasures'] = 0;
        $player = new Player($_SESSION['login']);
        $_SESSION['play']['dungeon'] = new Dungeon($rooms, $player);
        $_SESSION['play']['isDead'] = false;
    } else if(isset($_POST['leave'])){
        exit(header('Location: account.php'));
    } else if(isset($_POST['continue'])){
        if($_SESSION['play']['isDead']){
            exit(header('Location: dungeon_screen.php'));
        }
        $_SESSION['play']['dungeon']->explore();
    } else if(isset($_POST['heal'])){
        $_SESSION['play']['dungeon']->heal();
    }
}

if(!isset($_SESSION['play'])){
    ?>
    You stand in front of a dungeon. There is no coming back.<br>
    <form method="post">
        <button type="submit" name='enter' value='enter'>Enter</button>
        <button type="submit" name='leave' value='leave'>Leave</button>
    </form>
    <?php
} else{
    $_SESSION['play']['dungeon']->showPlayer();
    $_SESSION['play']['dungeon']->showOptions();
}
?>

<link rel ="stylesheet" href="styles.css">