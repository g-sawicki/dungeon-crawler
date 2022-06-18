<?php

include_once('Entity.php');

class Fight{
    private Player $player;
    private Enemy $enemy;

    public function __construct($player, $enemy)
    {
        $this->player = $player;
        $this->enemy = $enemy;
        echo "Start the fight!<br> ";
        $this->fight();
    }


    public function fight(){
        $attacker = $this->player;
        $defender = $this->enemy;
        while(true) {
            $this->printStats();
            $attacker->attack($defender);
            if($defender->getCurrentHp() <= 0){
                if($attacker::class == 'Player'){
                    $_SESSION['loot']['gold'] += $this->enemy->getGold();
                    $_SESSION['loot']['enemies']++;
                    echo "You win!<br>";
                } else{
                    $_SESSION['play']['isDead'] = true;
                }
                return;
            }

            $tmp = $attacker;
            $attacker = $defender;
            $defender = $tmp;
        }
    }

    public function printStats(){
        $this->player->createimage();
        $this->enemy->createimage();
        echo '<br>';
    }
}