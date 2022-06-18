<?php

class Boss extends Enemy{
    public function __construct()
    {
        $this->name = 'Boss';
        $this->hp = rand(500, 999);
        $this->damage = rand(48, 62);
        $this->gold = rand(500,600);
    }

    public function info(){
        return "Boss, $this->damage dmg, $this->hp hp";
    }
}

?>