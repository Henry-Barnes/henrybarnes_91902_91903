<?php
    $search_type = to_clean($_REQUEST['search_type'] ?? '');
    $search_term = to_clean($_REQUEST['search_term'] ?? '');

    $heading = htmlspecialchars($search_term);
    $help_text = "";
    $order = " ORDER BY d.full_character_name ASC";

    // maps icon-row clicks to the correct joined column
    $search_columns = [
        "crew" => "c.crew",
        "fruit_type" => "ft.fruit_type",
        "origin" => "o.origin",
    ];

    $params = ['%' . $search_term . '%'];

    if ($search_type == "trait") {
        $sql_conditions = "
        WHERE k1.traits LIKE ?
        OR k2.traits LIKE ?
        OR k3.traits LIKE ?
        ";
        $params = array_fill(0, 3, '%' . $search_term . '%');
    }

    elseif (array_key_exists($search_type, $search_columns)) {
        $column = $search_columns[$search_type];
        $sql_conditions = "WHERE $column LIKE ? ";
    }

    else {
        // unknown search type - show nothing rather than erroring
        $sql_conditions = "WHERE 1 = 0";
        $params = [];
    }

    $sql_conditions .= $order;

    include("results.php");
?>
