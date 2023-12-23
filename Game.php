<?php

class Game {
    public $region;
    public $patch;
    public $winner;
    public $blue_side;
    public $red_side;
    function __construct($region, $patch, $winner, $blue_side, $red_side) {
        $this->region = $region;
        $this->patch = $patch;
        $this->winner = $winner;
        $this->blue_side = $blue_side;
        $this->red_side = $red_side;
    }
}