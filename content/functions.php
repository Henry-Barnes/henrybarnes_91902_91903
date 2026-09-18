<?php

// Runs the main character query with whatever WHERE clause / params are passed in
// d  = characters (main data table)
// c  = Crew
// ft = Devil_Fruit_Type
// o  = Origin
// k1/k2/k3 = Traits, joined three times (one per trait slot)
function get_query($dbconnect, $sql_conditions, $params = [])
{
    $find_sql = "
    SELECT d.*,
           c.*,
           ft.*,
           o.*,
           k1.traits AS Trait1,
           k2.traits AS Trait2,
           k3.traits AS Trait3

    FROM characters d

    JOIN Crew c ON c.crew_ID = d.crew_ID
    JOIN Devil_Fruit_Type ft ON ft.type_ID = d.fruit_type_ID
    JOIN Origin o ON o.origin_ID = d.origin_ID
    JOIN Traits k1 ON d.trait_1ID = k1.trait_ID
    JOIN Traits k2 ON d.trait_2ID = k2.trait_ID
    JOIN Traits k3 ON d.trait_3ID = k3.trait_ID

    $sql_conditions
    ";

    $stmnt = $dbconnect->prepare($find_sql);

    if (!$stmnt) {
        die("Query failed to prepare: " . $dbconnect->error);
    }

    if (!empty($params)) {
        $types = str_repeat('s', count($params));

        $bind_values = [];
        foreach ($params as $key => $value) {
            $bind_values[$key] = &$params[$key];
        }

        array_unshift($bind_values, $types);
        call_user_func_array([$stmnt, 'bind_param'], $bind_values);
    }

    $stmnt->execute();

    $find_query = $stmnt->get_result();
    $find_count = $find_query->num_rows;

    $stmnt->close();

    return [$find_query, $find_count];
}

// trims whitespace from search input
function to_clean($data)
{
    return trim($data);
}

// builds <option> tags for a dropdown from any lookup table.
// pass $selectedID to pre-select the current value (used on the edit form)
function get_options($dbconnect, $table, $idField, $labelField, $selectedID = null)
{
    $sql = "SELECT * FROM `$table` ORDER BY `$labelField` ASC";
    $query = mysqli_query($dbconnect, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        $selected = ($selectedID !== null && $row[$idField] == $selectedID) ? "selected" : "";
        echo '<option value="' . htmlspecialchars($row[$idField]) . '" ' . $selected . '>'
            . htmlspecialchars($row[$labelField]) . '</option>';
    }
}

// returns a JSON list of values from a table/column, for autocomplete
function autocomplete_list($dbconnect, $item_sql, $entity)
{
    $all_items_query = mysqli_query($dbconnect, $item_sql);
    $items = [];

    while ($row = mysqli_fetch_assoc($all_items_query)) {
        $items[] = $row[$entity];
    }

    return json_encode($items);
}

// looks up a trait's ID by exact name; returns null if it doesn't exist yet
function get_trait_ID($dbconnect, $trait)
{
    $stmt = $dbconnect->prepare("SELECT trait_ID FROM Traits WHERE traits = ?");
    $stmt->bind_param("s", $trait);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return $row ? $row['trait_ID'] : null;
}

?>
