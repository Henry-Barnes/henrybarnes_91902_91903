<?php
list($find_query, $find_count) = get_query($dbconnect, $sql_conditions, $params);

if ($find_count > 0) {

    if ($find_count == 1) {
        $results_heading = $heading;
    } else {
        $results_heading = $heading . " (" . $find_count . " results)";
    }

    if ($heading != "") {
        ?>
        <h2><?= htmlspecialchars($results_heading); ?></h2>
        <?php
    }

    if ($help_text != "") {
        ?>
        <i class="fa-solid fa-circle-info"></i> <?= htmlspecialchars($help_text); ?><br><br>
        <?php
    }

    ?>

    <div class='all-cards'>

    <?php

    while ($find_rs = mysqli_fetch_assoc($find_query)) {

        $ID = $find_rs['unique_ID'];
        $avatar = "images/avatars/" . $find_rs['featured'];

        $character = $find_rs['full_character_name'];
        $crew = $find_rs['crew'];
        $fruit_type = $find_rs['fruit_type'];
        $origin = $find_rs['origin'];
        $bounty = $find_rs['bounty'];

        $trait1 = $find_rs['Trait1'];
        $trait2 = $find_rs['Trait2'];
        $trait3 = $find_rs['Trait3'];

        $featured = $find_rs['featured'];

        $crew_icon = "images/icons/" . $find_rs['crew_icon'];
        $fruit_icon = "images/icons/" . $find_rs['type_icon'];
        $origin_icon = "images/icons/" . $find_rs['origin_icon'];

        $click_type = "index.php?page=content/click_search&search_type=";
        $click_term = "&search_term=";

        include("character_details.php");
    }

    ?>

    </div> <!-- / all-cards -->

<?php

} else {
    ?>

    <h2>No results found</h2>

    <div class="error">
        <p>Sorry! There are no results for your search.</p>
        <p>Please try again with different filters or a different search term.</p>
    </div>

    <?php
}
?>
