<!DOCTYPE html>
<html lang="en">

<?php
    include("config.php");
    include("content/functions.php");

    $dbconnect = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (mysqli_connect_errno()) {
        echo "Connection failed: " . mysqli_connect_error();
        exit;
    }

    // buffers output so header() redirects still work later in the page
    ob_start();
    session_start();
?>

<?php include("content/head.php"); ?>

<body>

    <div class="wrapper">

    <?php include("content/banner_nav.php"); ?>

    <main class="pad-20">
        <?php
        if (!isset($_REQUEST['page'])) {
            include("content/home.php");
        } else {
            // only allow letters, numbers, underscores and forward slashes
            // (blocks path traversal attempts like ../../config)
            $page = preg_replace('/[^a-zA-Z0-9_\/]/', '', $_REQUEST['page']);
            $page = str_replace('..', '', $page);

            $file_path = "$page.php";

            if (file_exists($file_path)) {
                include($file_path);
            } else {
                echo "<h2>Page not found</h2>";
            }
        }
        ?>
    </main>

    <?php include("content/footer.php"); ?>

    </div> <!-- / wrapper -->

</body>

</html>
