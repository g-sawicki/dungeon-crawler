<?php

class Player extends Entity{
    private $potions;
    public function __construct($name){
        $this->name = $name;
        $this->hp_max = 300;
        $this->damage = 30;
        $this->potions = 2;

        foreach($_SESSION['items'] as $key => $value){
            if($key == 'Helmet'){
                $this->hp_max += ($value - 1) * 50;
            } else if($key == 'Chestplate'){
                $this->hp_max += ($value - 1) * 80;
            } else if($key == 'Leggings'){
                $this->hp_max += ($value - 1) * 70;
            } else if($key == 'Boots'){
                $this->hp_max += ($value - 1) * 40;
            } else if($key == 'Sword'){
                $this->damage += ($value - 1) * 2;
            }
        }
        $this->hp = $this->hp_max;
    }

    public function info(){
        return "Player $this->name, $this->damage dmg, $this->hp hp";
    }

    public function getPotionCount(){
        return $this->potions;
    }
    public function givePotion(){
        $this->potions++;
    }
    public function usePotion(){
        $this->potions--;
        $this->hp += 50;
        if($this->hp > $this->hp_max) $this->hp = $this->hp_max;
    }
}

?>