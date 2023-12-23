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

    public function get_region() {
        return $this->region;
    }
    public function get_patch() {
        return $this->patch;
    }
    public function get_winner() {
        return $this->winner;
    }
    public function get_blue_side() {
        return $this->blue_side;
    }
    public function get_red_side() {
        return $this->red_side;
    }
}