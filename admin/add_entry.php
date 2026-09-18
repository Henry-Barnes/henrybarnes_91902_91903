<?php
if (isset($_SESSION['admin'])) {

    $all_traits_sql = "SELECT * FROM Traits ORDER BY traits ASC";
    $all_traits = autocomplete_list($dbconnect, $all_traits_sql, 'traits');

    // form field name | table              | id column | label column
    $dropdown_details = [
        ['crew', 'Crew', 'crew_ID', 'crew'],
        ['fruit_type', 'Devil_Fruit_Type', 'type_ID', 'fruit_type'],
        ['origin', 'Origin', 'origin_ID', 'origin'],
    ];
?>

<div class="big-form">

    <h2>Add Character</h2>

    <form action="index.php?page=admin/insert_entry" method="post">

        <p><input name="character" placeholder="Character Name" required></p>

        <?php foreach ($dropdown_details as $drop) {
            list($name, $table, $id_field, $label_field) = $drop;
        ?>

        <select class="marg-bottom" name="<?= htmlspecialchars($name); ?>" required>
            <option value="" disabled selected>Select <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $name))); ?>...</option>
            <?php get_options($dbconnect, $table, $id_field, $label_field); ?>
        </select>

        <?php } ?>

        <p><input name="bounty" type="number" min="0" placeholder="Bounty (optional, in Berries)"></p>

        <p><textarea name="description" placeholder="Character Description" required></textarea></p>

        <div class="autocomplete marg-bottom">
            <input name="Trait1" id="Trait1" placeholder="Trait 1 (required)" required>
        </div> <!-- / autocomplete (Trait 1) -->

        <div class="autocomplete marg-bottom">
            <input name="Trait2" id="Trait2" placeholder="Trait 2 (optional)">
        </div> <!-- / autocomplete (Trait 2) -->

        <div class="autocomplete marg-bottom">
            <input name="Trait3" id="Trait3" placeholder="Trait 3 (optional)">
        </div> <!-- / autocomplete (Trait 3) -->

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
