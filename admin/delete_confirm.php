<?php
if (isset($_SESSION['admin'])) {

    $ID = to_clean($_REQUEST['ID'] ?? '');

    $heading = "";
    $help_text = "";
    $params = [$ID];
    $sql_conditions = "WHERE d.unique_ID = ?";
?>

    <h2>Delete Character?</h2>

    <div class="single-holder">

    <?php include("content/results.php"); ?>

    <div class="error">
        <p>Are you sure you want to delete this entry?</p>

        <div class="trait-tags delete-tags">
            <a class="trait pad-10" href="index.php?page=admin/delete_entry&ID=<?= htmlspecialchars($ID); ?>">Yes, delete it!</a>
            <a class="trait pad-10" href="javascript:history.back()">No, take me back</a>
        </div> <!-- / yes / no delete buttons -->
    </div> <!-- / are you sure -->

    </div> <!-- / single-holder -->

<?php
} else {
    $login_error = urlencode('Please login to access this page');
    header("Location: index.php?page=admin/login&error=$login_error");
    exit;
}
?>
