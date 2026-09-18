<?php
if (isset($_SESSION['admin'])) {

    $ID = to_clean($_REQUEST['ID'] ?? '');

    $stmt_featured = $dbconnect->prepare("SELECT * FROM `characters` WHERE `unique_ID` = ? LIMIT 1");
    $stmt_featured->bind_param("i", $ID);
    $stmt_featured->execute();

    $result = $stmt_featured->get_result();
    $find_rs = $result->fetch_assoc();
    $stmt_featured->close();

    if (!$find_rs) {
        echo "<h2>Not Found</h2><div class='error'><p>No character found with that ID.</p></div>";
        exit;
    }

    $featured = $find_rs['featured'];

    // featured items are protected from deletion
    if ($featured == "") {

        $stmt_delete = $dbconnect->prepare("DELETE FROM `characters` WHERE `unique_ID` = ?");
        $stmt_delete->bind_param("i", $ID);
        $stmt_delete->execute();
        $stmt_delete->close();

        ?>
        <h2>Delete Success</h2>
        <p>The entry has been deleted.</p>
        <?php

    } else {
        ?>
        <h2>Oops</h2>
        <div class="error">You tried to delete a featured item. This is not possible.</div>
        <?php
    }

} else {
    $login_error = urlencode('Please login to access this page');
    header("Location: index.php?page=admin/login&error=$login_error");
    exit;
}
?>
