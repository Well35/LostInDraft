<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();



include "DBConnector.php";
$connector = new DBConnector();

$background_color = "#6B6B6B";

// Quick logic that changes background color based on the user's guess
// TODO: Find a better way to visualize guessing correctly/incorrectly
//  Just changing background color looks ugly
//
// Also, all of this logic should be moved somewhere else at some point
// Most likely instead of form submitting, it should be moved to JS
if (isset($_GET['blue_side'])) {
    if ($connector->game->get_winner() == "BLUE") {
        $background_color = "#065c22";
    }
    else {
        $background_color = "#590e02";
    }
    $connector->find_new_game();
}
if (isset($_GET['red_side'])) {
    if ($connector->game->get_winner() == "RED") {
        $background_color = "#065c22";
    }
    else {
        $background_color = "#590e02";
    }
    $connector->find_new_game();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <title>Lost in Draft</title>
</head>
<body bgColor= <?php echo $background_color ?>>

    <div id="wrapper">

        <div id="champIcons">
            <?php
                $connector->draw_champion_icons($connector->game->get_blue_side());
            ?>

            <form method="get">
                <input type="submit" name="blue_side" value="Blue side win">
            </form> 
        </div>

        <h1>VS</h1>

        <div id="champIcons">
            <?php
                $connector->draw_champion_icons($connector->game->get_red_side());
            ?>

            <form method="get">
                <input type="submit" name="red_side" value="Red side win">
            </form>
        </div>
        
    </div>

    <div id="settings">
        Regions:
        <br>
        <input type="checkbox" name="LCK">
        <label for="LCK">LCK</label>
        <input type="checkbox" name="LCS">
        <label for="LCS">LCS</label>
        <input type="checkbox" name="LPL">
        <label for="LPL">LPL</label>
    </div>
    <script src="check_box.js"></script>

</body>
</html>