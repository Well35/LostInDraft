<?php
class Team {
    public $champions = array();
    public $name;

    function __construct($name = null) {
        $this->name = $name;
    }

    function add_champ($name) {
        $this->champions[] = $name;
    }

    public function get_name() {
        return $this->name;
    }
    public function set_name($name) {
        $this->name = $name;
    }
}