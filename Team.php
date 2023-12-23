<?php
class Team {
    public $champions = array();
    private $name;

    function __construct($name = null) {
        $this->name = $name;
    }

    public function add_champ($name) {
        $this->champions[] = $name;
    }

    public function get_name() {
        return $this->name;
    }
    public function set_name($name) {
        $this->name = $name;
    }
}