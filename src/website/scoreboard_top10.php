<?php
// Read the JSON file and convert it to an array
$data = json_decode(file_get_contents("/var/data/scoreboard.json"), true);
$config = json_decode(file_get_contents("/var/data/config.json"), true);

if (!empty($config)){
    // Output the title, subtitle, and important message
    echo "<h1>{$config['title']}</h1>";
    echo "<p class=\"subtitle\">{$config['subtitle']}</p>";
    if (!empty($config['important_message'])){
        echo "<div class=\"message\">{$config['important_message']}</div>";
    }
}

$medals = array("🥇", "🥈", "🥉");

if (!empty($data)){
// Sort the array by score (descending order)
    usort($data, function($a, $b) {
        return $b["problems_resolved"] - $a["problems_resolved"];
    });

    // Initialize a counter for the rank
    $rank = 1;

    // Loop through the array and display the scoreboard
    foreach (array_slice($data, 0, 10) as $user) {
        echo "<tr";
        if ($rank == 1) {
            echo " style='background-color: gold;'";
        } elseif ($rank == 2) {
            echo " style='background-color: silver;'";
        } elseif ($rank == 3) {
            echo " style='background-color: #cd7f32;'";
        }
        echo ">";
        echo "<td>" . (($rank <= 3) ? $medals[$rank-1] : ($rank)) . "</td>";
        echo "<td>" . $user["username"] . "</td>";
        echo "<td>" . $user["problems_resolved"] . "</td>";
        echo "<td>" . $user["score"] . "</td>";
        echo "<td>" . $user["codeforces_ranking"] . "</td>";
        echo "</tr>";
        $rank++;
    }
}
?>
