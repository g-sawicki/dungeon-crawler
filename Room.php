<?php

require_once('NormalRoom.php');
require_once('TreasureRoom.php');
require_once('BossRoom.php');

abstract class Room{
    abstract protected function generate();
    abstract protected function explore($player);
    abstract protected function info();
}

?>