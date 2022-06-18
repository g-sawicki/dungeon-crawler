<?php

class Goblin extends Enemy{
    public function __construct()
    {
        $this->name = 'Goblin';
        $this->hp = rand(50, 70);
        $this->damage = rand(7, 12);
        $this->gold = rand(20,30);
    }

    public function info(){
        return "Goblin, $this->damage dmg, $this->hp hp";
    }
}

?>