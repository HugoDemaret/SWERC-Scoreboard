<?php
// Read the JSON file and convert it to an array
$data = json_decode(file_get_contents("./data/scoreboard.json"), true);

// Sort the array by problems resolved (descending order)
usort($data, function($a, $b) {
    return $b["problems_months"] - $a["problems_months"];
});

// Initialize a counter for the rank
$rank = 1;

// Loop through the array and display the scoreboard
foreach ($data as $user) {
    echo "<tr";
    if ($rank == 1) {
        echo " style='background-color: gold;'";
    } elseif ($rank == 2) {
        echo " style='background-color: silver;'";
    } elseif ($rank == 3) {
        echo " style='background-color: #cd7f32;'";
    }
    echo ">";
    echo "<td>" . $rank . "</td>";
    echo "<td>" . $user["username"] . "</td>";
    echo "<td>" . $user["problems_months"] . "</td>";
    echo "<td>" . $user["problems_resolved"] . "</td>";
    echo "<td>" . $user["codeforces_ranking"] . "</td>";
    echo "</tr>";
    $rank++;
}
?>