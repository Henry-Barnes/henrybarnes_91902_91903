<?php
if (isset($_SESSION['admin'])) {

    $ID = to_clean($_REQUEST['ID'] ?? '');

    $all_traits_sql = "SELECT * FROM Traits ORDER BY traits ASC";
    $all_traits = autocomplete_list($dbconnect, $all_traits_sql, 'traits');

    $params = [$ID];
    $sql_conditions = "WHERE d.unique_ID = ?";

    list($get_entry_query, $get_entry_count) = get_query($dbconnect, $sql_conditions, $params);
    $get_entry_rs = mysqli_fetch_assoc($get_entry_query);

    if (!$get_entry_rs) {
        echo "<h2>Not Found</h2><div class='error'><p>No character found with that ID.</p></div>";
        exit;
    }

    $character_name = $get_entry_rs['full_character_name'];
    $description = $get_entry_rs['description'];
    $bounty = $get_entry_rs['bounty'];

    $crewID = $get_entry_rs['crew_ID'];
    $fruit_typeID = $get_entry_rs['fruit_type_ID'];
    $originID = $get_entry_rs['origin_ID'];

    $trait_1 = $get_entry_rs['Trait1'];
    $trait_2 = $get_entry_rs['Trait2'];
    $trait_3 = $get_entry_rs['Trait3'];

    if ($trait_2 == "n/a") { $trait_2 = ""; }
    if ($trait_3 == "n/a") { $trait_3 = ""; }

    // form field name | table              | id column   | label column   | currently selected ID
    $dropdown_details = [
        ['crew', 'Crew', 'crew_ID', 'crew', $crewID],
        ['fruit_type', 'Devil_Fruit_Type', 'type_ID', 'fruit_type', $fruit_typeID],
        ['origin', 'Origin', 'origin_ID', 'origin', $originID],
    ];
?>

<div class="big-form">

    <h2>Edit Character</h2>

    <form action="index.php?page=admin/edit_entry&ID=<?= htmlspecialchars($ID); ?>" method="post">

        <p><input name="character" value="<?= htmlspecialchars($character_name); ?>" required></p>

        <?php foreach ($dropdown_details as $drop) {
            list($name, $table, $id_field, $label_field, $selectedID) = $drop;
        ?>

        <select class="marg-bottom" name="<?= htmlspecialchars($name); ?>" required>
            <?php get_options($dbconnect, $table, $id_field, $label_field, $selectedID); ?>
        </select>

        <?php } ?>

        <p><input name="bounty" type="number" min="0" value="<?= htmlspecialchars($bounty); ?>"></p>

        <p><textarea name="description" required><?= htmlspecialchars($description); ?></textarea></p>

        <div class="autocomplete marg-bottom">
            <input name="Trait1" id="Trait1" value="<?= htmlspecialchars($trait_1); ?>" required>
        </div> <!-- / autocomplete (trait 1) -->

        <div class="autocomplete marg-bottom">
            <input name="Trait2" id="Trait2" value="<?= htmlspecialchars($trait_2); ?>">
        </div> <!-- / autocomplete (trait 2) -->

        <div class="autocomplete marg-bottom">
            <input name="Trait3" id="Trait3" value="<?= htmlspecialchars($trait_3); ?>">
        </div> <!-- / autocomplete (trait 3) -->

        <button class="form-submit pad-10" type="submit" name="submit">Submit</button>

    </form>

</div> <!-- / big-form -->

<script>
    <?php include("autocomplete.php"); ?>

    var all_traits = <?= $all_traits ?>;
    autocomplete(document.getElementById("Trait1"), all_traits);
    autocomplete(document.getElementById("Trait2"), all_traits);
    autocomplete(document.getElementById("Trait3"), all_traits);
</script>

<?php
} else {
    $login_error = urlencode('Please login to access this page');
    header("Location: index.php?page=admin/login&error=$login_error");
    exit;
}
?>
