<?php
    $search_term = to_clean($_REQUEST['quick_search_term'] ?? '');

    $heading = htmlspecialchars($search_term);
    $help_text = "";
    $order = " ORDER BY d.full_character_name ASC";

    // maps the button that was pressed to a search type
    $search_type_array = [
        "quick_search" => "quick",
        "crew_search" => "crew",
        "character_search" => "character",
        "fruit_search" => "fruit",
    ];

    $search_type = "quick"; // sensible default if nothing matches

    foreach ($search_type_array as $submit_name => $type_value) {
        if (isset($_POST[$submit_name])) {
            $search_type = $type_value;
            break;
        }
    }

    $search_term = '%' . $search_term . '%';

    // single-column searches (aliases match the joins in functions.php)
    $search_columns = [
        "crew" => "c.crew",
        "character" => "d.full_character_name",
        "fruit" => "ft.fruit_type",
    ];

    if (array_key_exists($search_type, $search_columns)) {
        $column = $search_columns[$search_type];
        $sql_conditions = "WHERE $column LIKE ? ";
        $params = [$search_term];
    }

    elseif ($search_type == "quick") {
        // quick search checks several fields at once
        $sql_conditions = "
        WHERE d.full_character_name LIKE ?
        OR c.crew LIKE ?
        OR ft.fruit_type LIKE ?
        OR k1.traits LIKE ?
        OR k2.traits LIKE ?
        OR k3.traits LIKE ?
        ";

        $params = array_fill(0, 6, $search_term);
        $help_text = "Results are based on character name, crew, devil fruit type, and traits.";
    }

    $sql_conditions .= $order;

    include("results.php");
?>
