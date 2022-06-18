<?php

require_once('Room.php');

define('NORMAL_ROOM', 1);
define('TREASURE_ROOM', 2);
define('BOSS_ROOM', 3);

class Dungeon{
    private $current_room_number;
    private $current_room;
    private $room_count;
    private $rooms;
    private $player;

    public function __construct($room_count, $player)
    {
        $this->room_count = $room_count;
        $this->player = $player;
        $this->randomiseRooms();
        $this->current_room_number = 0;
        $this->explore();
    }

    public function randomiseRooms(){
        // generate rooms:
        // - boss always last
        // - 1 treasure room per 10 rooms 
        $this->rooms = array_fill(0, $this->room_count - 1, NORMAL_ROOM);
        $treasure_rooms = round(($this->room_count / 10));
        while($treasure_rooms > 0){
            $i = rand($this->room_count / 10, $this->room_count - 2);
            if($this->rooms[$i] == NORMAL_ROOM){
                $this->rooms[$i] = TREASURE_ROOM;
                $treasure_rooms--;
            }
        }
        $this->rooms[$this->room_count - 1] = BOSS_ROOM;
        //$this->print_rooms();
    }

    public function explore(){
        if($this->room_count == $this->current_room_number){
            exit(header('Location: dungeon_screen.php'));
        }
        $this->generateRoom();
        $this->current_room->explore($this->player);
        $this->current_room_number++;
    }

    public function generateRoom(){
        switch ($this->rooms[$this->current_room_number]) {
            case NORMAL_ROOM:
                $this->current_room = new NormalRoom();
                break;
            case TREASURE_ROOM:
                $this->current_room = new TreasureRoom();
                break;
            case BOSS_ROOM:
                $this->current_room = new BossRoom();
                break;
        }
        //echo $this->current_room_number . ' ' . $this->current_room->info() . '<br>';
    }

    public function heal(){
        if($this->player->getPotionCount() > 0){
            $this->player->usePotion();
        } else{
            echo "You don't have any potions left.<br>";
        }
    }

    public function showOptions(){
        ?>
        <form method="post">
            <button type="submit" name='continue' value='continue'>Continue</button>
        <?php if($this->player->getCurrentHp() > 0 && $this->player->getCurrentHp() < $this->player->getHpMax()){ ?>
            <button type="submit" name='heal' value='heal'>Heal</button>
        <?php } ?>
        </form>
        <?php
    }

    public function showPlayer(){
        $this->player->createimage();
        echo '<br><br>';
    }

    public function print_rooms(){
        foreach($this->rooms as $room){
            echo "[$room] ";
        }
        echo '<br>';
    }

    public function getCurrentRoom(){
        return $this->current_room_number;
    }
}
?>