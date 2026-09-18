<?php
if (isset($_SESSION['admin'])) {

    if (isset($_REQUEST['submit'])) {

        $ID = to_clean($_REQUEST['ID'] ?? '');
        $character_name = to_clean($_REQUEST['character'] ?? '');
        $crew = to_clean($_REQUEST['crew'] ?? '');
        $fruit_type = to_clean($_REQUEST['fruit_type'] ?? '');
        $origin = to_clean($_REQUEST['origin'] ?? '');
        $bounty = to_clean($_REQUEST['bounty'] ?? '0');
        $description = to_clean($_REQUEST['description'] ?? '');

        $trait1 = to_clean($_REQUEST['Trait1'] ?? '');
        $trait2 = to_clean($_REQUEST['Trait2'] ?? '');
        $trait3 = to_clean($_REQUEST['Trait3'] ?? '');

        // server-side validation - never trust the browser alone
        if ($ID == "" || $character_name == "" || $crew == "" || $fruit_type == "" || $origin == "" || $description == "" || $trait1 == "") {
            ?>
            <h2>Oops!</h2>
            <div class="error">
                <p>Please fill in all required fields.</p>
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

        $stmt_edit = $dbconnect->prepare("UPDATE `characters` SET
            `full_character_name` = ?, `crew_ID` = ?, `fruit_type_ID` = ?, `origin_ID` = ?,
            `trait_1ID` = ?, `trait_2ID` = ?, `trait_3ID` = ?, `bounty` = ?, `description` = ?
            WHERE `unique_ID` = ?");

        $stmt_edit->bind_param("siiiiiiisi",
            $character_name, $crew, $fruit_type, $origin,
            $trait_ID_1, $trait_ID_2, $trait_ID_3,
            $bounty, $description, $ID);

        $stmt_edit->execute();
        $stmt_edit->close();

        $heading = "Character Updated!";
        $help_text = "";
        $params = [$ID];
        $sql_conditions = "WHERE d.unique_ID = ?";

        include("content/results.php");
    }

} else {
    $login_error = urlencode('Please login to access this page');
    header("Location: index.php?page=admin/login&error=$login_error");
    exit;
}
?>
