<?php

class Orc extends Enemy{
    public function __construct()
    {
        $this->name = 'Orc';
        $this->hp = rand(120, 200);
        $this->damage = rand(13, 24);
        $this->gold = rand(50,100);
    }

    public function info(){
        return "Orc, $this->damage dmg, $this->hp hp";
    }
}

?>