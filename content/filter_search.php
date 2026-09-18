<?php
    $order = " ORDER BY d.full_character_name ASC";
    $help_text = "Results show characters which match ALL the filters you chose. If there are no results, try fewer filters.";
    $heading = "Filter Results...";

    $crewID = to_clean($_REQUEST['crew'] ?? '');
    $fruitTypeID = to_clean($_REQUEST['fruit_type'] ?? '');
    $originID = to_clean($_REQUEST['origin'] ?? '');

    // blank filters become wildcards so they match everything
    $all_input = [$crewID, $fruitTypeID, $originID];

    foreach ($all_input as $index => $value) {
        if ($value === "") {
            $all_input[$index] = "%";
        }
    }

    list($crewID, $fruitTypeID, $originID) = $all_input;

    $sql_conditions = "
    WHERE d.crew_ID LIKE ?
    AND d.fruit_type_ID LIKE ?
    AND d.origin_ID LIKE ?
    ";

    $params = [$crewID, $fruitTypeID, $originID];

    $sql_conditions .= $order;

    include("results.php");
?>
