<h2>Welcome</h2>

<p>This site features many of the most notable characters from One Piece. Use the search
    feature or the random button to explore the data.</p>

<p>Mouse over the icons on each character card if you're not sure what a given icon means.</p>

<p>Here are some featured characters:</p>

<div class='all-cards'>

<?php

$sql_conditions = "WHERE d.featured != ?";
$params = [''];

list($featured_query, $featured_count) = get_query($dbconnect, $sql_conditions, $params);

while ($find_rs = mysqli_fetch_assoc($featured_query)) {

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

    ?>

    <div class="container">

        <img class="featured-image" src="<?= htmlspecialchars($avatar); ?>" alt="<?= htmlspecialchars($character); ?>">

        <div class="overlay">
            <?php include("character_details.php"); ?>
        </div> <!-- / overlay -->

    </div> <!-- / container -->

    <?php
}
?>

</div> <!-- / all-cards -->
