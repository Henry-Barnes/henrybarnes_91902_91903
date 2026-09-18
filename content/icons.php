<h2>Icon Legend</h2>
<i class="fa-solid fa-circle-info"></i> Click any icon below to see characters with that feature.

<br><br>

<?php

$click_type = "index.php?page=content/click_search&search_type=";
$click_term = "&search_term=";

$icon_sets = [
    ["heading" => "Crew",             "table" => "Crew",             "label_field" => "crew",       "icon_field" => "crew_icon",   "search_type" => "crew"],
    ["heading" => "Devil Fruit Type", "table" => "Devil_Fruit_Type", "label_field" => "fruit_type", "icon_field" => "type_icon",   "search_type" => "fruit_type"],
    ["heading" => "Origin",           "table" => "Origin",           "label_field" => "origin",     "icon_field" => "origin_icon", "search_type" => "origin"],
];

?>

<div class='all-cards'>

<?php
foreach ($icon_sets as $set) {

    $sql = "SELECT * FROM `{$set['table']}` ORDER BY `{$set['label_field']}` ASC";
    $query = mysqli_query($dbconnect, $sql);

    echo "<div class='icon-list text-large pad-10-round'>";
    echo "<div class='character-name pad-10-round'>" . htmlspecialchars($set['heading']) . "</div>";

    while ($rs = mysqli_fetch_assoc($query)) {

        $label = $rs[$set['label_field']];
        $icon_path = "images/icons/" . $rs[$set['icon_field']];
        $link = $click_type . $set['search_type'] . $click_term . urlencode($label);

        echo "
        <div class='row pad-10'>
            <a title='" . htmlspecialchars($label) . "' class='legend' href='" . htmlspecialchars($link) . "'>
                <img class='icon' src='" . htmlspecialchars($icon_path) . "' alt='" . htmlspecialchars($label) . "'>
                " . htmlspecialchars($label) . "
            </a>
        </div>";
    }

    echo "</div> <!-- / icon-list -->";
}
?>

</div> <!-- / all-cards -->
