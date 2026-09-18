<?php
    $search_term = "%";
    $params = [$search_term];

    $sql_conditions = "WHERE d.full_character_name LIKE ? ORDER BY RAND() LIMIT 5";

    $heading = "Random";
    $help_text = "Press 'Random' again to see another set of characters.";

    include("results.php");
?>
