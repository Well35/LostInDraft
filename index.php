<?php
include "Game.php";
include "Team.php";

function connect_to_db() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "test";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function get_random_game_id($conn) {
    $sql = "SELECT * FROM games";
    $result = $conn->query($sql);
    return rand(1, $result->num_rows);
}

function get_game_data($id, $conn) {
    $blue_side = new Team();
    $red_side = new Team();
    $id = 1;

    $sql = "SELECT champion_name, blue_side, red_side, side_picked 
            FROM champion_picks 
            INNER JOIN games 
            ON champion_picks.game_id = games.game_id 
            WHERE games.game_id = $id";

    $result = $conn->query($sql);
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

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $blue_side->set_name($row["blue_side"]);
        $red_side->set_name($row["red_side"]);
    }
    $game = new Game($row["region"], $row["patch"], $row["winner"], $blue_side, $red_side);
    return $game;
}

$conn = connect_to_db();
$random_game_id = get_random_game_id($conn);
$current_game = get_game_data($random_game_id, $conn);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Pro Guesser</title>
</head>
<style>
    img {
        padding: 10px;
    }
    #champIcons {
        margin: auto;
        width: 50%;
        height: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    #wrapper {
        display: flex;
        flex-direction: row;
        padding-top: 50px;
    }
</style>
<body bgColor="#6B6B6B">
    <div id="wrapper">
        <div id="champIcons">
            <?php
            echo '<h1>' . htmlspecialchars($current_game->blue_side->get_name()) . '</h1>';
            foreach($current_game->blue_side->champions as $champion) {
                echo '<img src="ChampionIcons/' . htmlspecialchars($champion) . '.png" alt=' . htmlspecialchars($champion) . '>';
            }
            ?>
            <form method="post">
                <input type="submit" name="Blue side" value="Blue side win">
            </form>
        </div>
        <div id="champIcons">
            <?php
            echo '<h1>' . htmlspecialchars($current_game->red_side->get_name()) . '</h1>';
            foreach($current_game->red_side->champions as $champion) {
                echo '<img src="ChampionIcons/' . htmlspecialchars($champion) . '.png" alt=' . htmlspecialchars($champion) . '>';
            }
            ?>
            <form method="post">
                <input type="submit" name="Red side" value="Red side win">
            </form>
        </div>
    </div>
</body>
</html>