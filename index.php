<?php
include "DBConnector.php";
$connector = new DBConnector();

$background_color = "#6B6B6B";

if (isset($_GET['blue_side'])) {
    if ($connector->game->winner == "BLUE") {
        $background_color = "#065c22";
    }
    else {
        $background_color = "#590e02";
    }
}

if (isset($_GET['red_side'])) {
    if ($connector->game->winner == "RED") {
        $background_color = "#065c22";
    }
    else {
        $background_color = "#590e02";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Lost In Draft</title>
</head>
<body bgColor= <?php echo $background_color ?>>

    <div id="wrapper">

        <div id="champIcons">
            <?php
            echo '<h1>' . htmlspecialchars($connector->game->blue_side->get_name()) . '</h1>';
            foreach($connector->game->blue_side->champions as $champion) {
                echo '<img src="ChampionIcons/' . htmlspecialchars($champion) . '.png" alt=' . htmlspecialchars($champion) . '>';
            }
            ?>
            <form method="get">
                <input type="submit" name="blue_side" value="Blue side win">
            </form>
        </div>

        <h1>VS</h1>

        <div id="champIcons">
            <?php
            echo '<h1>' . htmlspecialchars($connector->game->red_side->get_name()) . '</h1>';
            foreach($connector->game->red_side->champions as $champion) {
                echo '<img src="ChampionIcons/' . htmlspecialchars($champion) . '.png" alt=' . htmlspecialchars($champion) . '>';
            }
            ?>
            <form method="get">
                <input type="submit" name="red_side" value="Red side win">
            </form>
        </div>
        
    </div>

</body>
</html>