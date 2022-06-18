<?php

//require_once('Entity.php');

class BossRoom extends Room{
    private $enemy;

    public function __construct()
    {
        $this->generate();
    }

    public function generate(){
        $this->enemy = new Boss();
    }

    public function explore($player){
        echo "You entered a room. You spot a " . $this->enemy->getName() . " inside.<br>";
        $_SESSION['play']['fight'] = new Fight($player, $this->enemy);
    }

    public function info(){
        return "boss = boss";
    }
}