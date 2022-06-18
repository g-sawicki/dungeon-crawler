<?php

class TreasureRoom extends Room{
    private $gold, $health_potion, $damage_boost, $health_boost;

    public function __construct()
    {
        $this->generate();
    }

    public function generate(){
        // create treasure
        $this->gold = rand(50, 100);
        $this->health_potion = (rand(0, 100) >= 20);
        $this->damage_boost = rand(2, 4);
        $this->health_boost = rand(5, 10);
    }

    public function explore($player){
        echo "You entered a room. You spot a treasure inside.<br>";


        echo "Gold: +$this->gold, ";
        if($this->health_potion > 0){
            echo "Potion: $this->health_potion, ";
        }
        echo "+$this->damage_boost damage, +$this->health_boost hp<br>";

        $_SESSION['loot']['gold'] += $this->gold;
        if($this->health_potion) $player->givePotion();
        $player->setCurrentHp($player->getCurrentHp() + $this->health_boost);
        $player->setHpMax($player->getHpMax() + $this->health_boost);
        $player->setDamage($player->getDamage() + $this->damage_boost);
        $_SESSION['loot']['treasures']++;
    }

    public function info(){
        return "Gold: $this->gold, Potion: $this->health_potion, +$this->damage_boost damage, +$this->health_boost hp";
    }
}