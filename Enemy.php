<?php

require_once('Goblin.php');
require_once('Orc.php');
require_once('Boss.php');

class Enemy extends Entity{
    protected $gold;

    public function getGold(){
        return $this->gold;
    }
}

?>