<?php

require_once('Enemy.php');
require_once('Player.php');

class Entity{
    protected $name, $hp_max, $hp, $damage;
    protected $isParalyzed = false, $isConfused = false;
    protected $img;

    public function attack($enemy){
        if($this->isParalyzed && rand(0, 1) == 1){
            $this->isParalyzed = false;
            echo "[!]$this->name is paralyzed and can't attack<br>";
            return;
        }
        $this->isParalyzed = false;
            if($this->isConfused && rand(0, 1) == 1){
                $this->isConfused = false;
                echo "[!]$this->name is confused and attacks itself<br>";
            $this->attack($this);
            return;
        }
        $this->isConfused = false;

        $enemy->hp -= $this->damage;
        echo $this->name . " attacks for " . $this->damage . " damage<br>";

        if($this != $enemy){
            $effect = rand(0, 1);
            if($effect == 0 && rand(0, 1) == 1){ $enemy->isParalyzed = true; echo "Applied Paralyzation<br>"; }
            if($effect == 1 && rand(0, 1) == 1){ $enemy->isConfused = true; echo "Applied Confusion<br>"; }
        }
    }

    public function createimage(){
        echo '<span class="bell">';
        echo '<img src="./img/'.$this::class.'.png" alt=missing_image>';
        echo '<span class="bellnumbers health '.$this::class.'">'.$this->hp.'</span>';
        echo '<span class="bellnumbers damage">'.$this->damage.'</span>';
        echo '</span>';
    }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getHpMax() { return $this->hp_max; }
    public function setHpMax($hp_max) { $this->hp_max = $hp_max; }

    public function getCurrentHp() { return $this->hp; }
    public function setCurrentHp($hp) { $this->hp = $hp; }

    public function getDamage() { return $this->damage; }
    public function setDamage($damage) { $this->damage = $damage; }
}
?>