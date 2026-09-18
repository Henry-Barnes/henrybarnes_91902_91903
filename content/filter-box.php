    <div id="myFilterpanel" class="panel">

    <div class="PanelWrapper">

    <div class="panel-header">
        <h2>Filters...</h2>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    </div> <!-- / panel-header -->

    <i class="fa-solid fa-circle-info"></i> <i>Leave everything blank to show all the data.</i>
    <br><br>

    <?php

    $dropdowns = [
        // form field name | table              | id column   | label column   | prompt
        ['crew',           'Crew',              'crew_ID',    'crew',          'Crew ...'],
        ['fruit_type',     'Devil_Fruit_Type',  'type_ID',    'fruit_type',    'Devil Fruit Type ...'],
        ['origin',         'Origin',            'origin_ID',  'origin',        'Origin ...'],
    ];

    ?>

    <form method="post" action="index.php?page=content/filter_search">

    <?php
    foreach ($dropdowns as $d) {
        list($name, $table, $id_col, $label_col, $prompt) = $d;

        echo '<select name="' . htmlspecialchars($name) . '" class="advanced pad-10-round">';
        echo '<option value="">' . htmlspecialchars($prompt) . '</option>';

        $sql = "SELECT `$id_col`, `$label_col` FROM `$table` ORDER BY `$label_col` ASC";
        $query = mysqli_query($dbconnect, $sql);

        while ($row = mysqli_fetch_assoc($query)) {
            echo '<option value="' . htmlspecialchars($row[$id_col]) . '">' . htmlspecialchars($row[$label_col]) . '</option>';
        }

        echo '</select><br>';
    }
    ?>

    <button class="advanced advanced-button advanced-search">
        <span>Filter</span> <i class="fa-solid fa-filter"></i>
    </button>

    </form>

    </div> <!-- / PanelWrapper -->

    </div> <!-- / myFilterpanel -->
