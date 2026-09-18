<?php
if (isset($_SESSION['admin'])) {

    if (isset($_REQUEST['submit'])) {

        $character_name = to_clean($_REQUEST['character'] ?? '');
        $crew = to_clean($_REQUEST['crew'] ?? '');
        $fruit_type = to_clean($_REQUEST['fruit_type'] ?? '');
        $origin = to_clean($_REQUEST['origin'] ?? '');
        $bounty = to_clean($_REQUEST['bounty'] ?? '0');
        $description = to_clean($_REQUEST['description'] ?? '');

        $trait1 = to_clean($_REQUEST['Trait1'] ?? '');
        $trait2 = to_clean($_REQUEST['Trait2'] ?? '');
        $trait3 = to_clean($_REQUEST['Trait3'] ?? '');

        // server-side validation - never trust the browser alone.
        // reject the submission if any required field is blank.
        if ($character_name == "" || $crew == "" || $fruit_type == "" || $origin == "" || $description == "" || $trait1 == "") {
            ?>
            <h2>Oops!</h2>
            <div class="error">
                <p>Please fill in all required fields (character name, crew, devil fruit type, origin, description and at least one trait).</p>
                <p><a class="trait pad-10" href="javascript:history.back()">Go back</a></p>
            </div>
            <?php
            exit;
        }

        if ($trait2 == "") { $trait2 = "n/a"; }
        if ($trait3 == "") { $trait3 = "n/a"; }

        $bounty = is_numeric($bounty) ? (int)$bounty : 0;

        // look up each trait, adding it to the Traits table if it's new
        $traits = [$trait1, $trait2, $trait3];
        $trait_IDs = [];

        $add_trait_stmt = $dbconnect->prepare("INSERT INTO `Traits` (`traits`) VALUES (?)");

        foreach ($traits as $trait) {
            $traitID = get_trait_ID($dbconnect, $trait);

            if ($traitID === null) {
                $add_trait_stmt->bind_param("s", $trait);
                $add_trait_stmt->execute();
                $traitID = $dbconnect->insert_id;
            }

            $trait_IDs[] = $traitID;
        }

        $add_trait_stmt->close();

        list($trait_ID_1, $trait_ID_2, $trait_ID_3) = $trait_IDs;

        // check for an existing character with the same name to avoid duplicates
        $dupe_params = ['%' . $character_name . '%'];
        $dupe_conditions = "WHERE d.full_character_name LIKE ?";
        list($dupe_query, $dupe_count) = get_query($dbconnect, $dupe_conditions, $dupe_params);

        if ($dupe_count > 0) {
            $heading = "Oops!";
            $help_text = "We already have an entry for " . htmlspecialchars($character_name) . ". Here it is...";
            $params = $dupe_params;
            $sql_conditions = $dupe_conditions;
        } else {

            $stmt_add = $dbconnect->prepare("INSERT INTO `characters`
                (`full_character_name`, `crew_ID`, `fruit_type_ID`, `origin_ID`,
                 `trait_1ID`, `trait_2ID`, `trait_3ID`, `bounty`, `description`, `featured`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $featured = "";

            $stmt_add->bind_param("siiiiiiiss",
                $character_name, $crew, $fruit_type, $origin,
                $trait_ID_1, $trait_ID_2, $trait_ID_3,
                $bounty, $description, $featured);

            $stmt_add->execute();
            $characterID = $dbconnect->insert_id;
            $stmt_add->close();

            $heading = "Character Added!";
            $help_text = "";
            $params = [$characterID];
            $sql_conditions = "WHERE d.unique_ID = ?";
        }

        include("content/results.php");
    }

} else {
    $login_error = urlencode('Please login to access this page');
    header("Location: index.php?page=admin/login&error=$login_error");
    exit;
}
?>
