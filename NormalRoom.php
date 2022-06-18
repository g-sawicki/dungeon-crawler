<?php

//require_once('Entity.php');
require_once('Fight.php');

class NormalRoom extends Room{
    private $enemy;

    public function __construct()
    {
        $this->generate();
    }

    public function generate(){
        // create enemies
        if(rand(1, 100) > 30){
            $this->enemy = new Goblin();
        } else{
            $this->enemy = new Orc();
        }
    }

    public function explore($player){
        if($this->enemy::class == 'Goblin')
            echo "You entered a room. You spot a Goblin inside.<br>";
        else if($this->enemy::class == 'Orc')
            echo "You entered a room. You spot an Orc inside.<br>";
        $_SESSION['play']['fight'] = new Fight($player, $this->enemy);
    }

    public function info(){
        return $this->enemy->info();
    }
}