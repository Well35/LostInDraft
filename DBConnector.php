<?php
include "Game.php";
include "Team.php";

class DBConnector {
    private $conn;
    public $game;

    public function __construct() {
        $this->connect_to_db();
        $this->get_game_data($this->get_random_game_id());
    }
    public function connect_to_db() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "test";

        $this->conn = new mysqli($servername, $username, $password, $database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Gets a random game_id between 1 and the amount in the database
    // In the future the random numbers generated will depend on what types of games the user wants to search for
    // (ie. only grabbing LCS and LPL games)
    public function get_random_game_id() {
        $sql = "SELECT * FROM games";
        $result = $this->conn->query($sql);
        return rand(1, $result->num_rows);
    }

    // Queries database for random game based on given $id
    public function get_game_data($id) {
        $blue_side = new Team();
        $red_side = new Team();
    
        $sql = "SELECT champion_name, blue_side, red_side, side_picked 
                FROM champion_picks 
                INNER JOIN games 
                ON champion_picks.game_id = games.game_id 
                WHERE games.game_id = $id";
    
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()){
                if ($row["side_picked"] == "blue") {
                    $blue_side->add_champ($row["champion_name"]);
                }
                else {
                    $red_side->add_champ($row["champion_name"]);
                }
            }
        }
    
        $sql = "SELECT * 
                FROM games 
                WHERE game_id = $id";
    
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $blue_side->set_name($row["blue_side"]);
            $red_side->set_name($row["red_side"]);
        }
        $this->game = new Game($row["region"], $row["patch"], $row["winner"], $blue_side, $red_side);
    }

    public function find_new_game() {
        $this->get_game_data($this->get_random_game_id());
    }

    // Displays all champion icon images for a given team
    public function draw_champion_icons(Team $side_to_draw) {
        echo '<h1>' . htmlspecialchars($side_to_draw->get_name()) . '</h1>';
        foreach($side_to_draw->champions as $champion) {
            echo '<img src="ChampionIcons/' . htmlspecialchars($champion) . '.png" alt=' . htmlspecialchars($champion) . '>';
        }
    }
}