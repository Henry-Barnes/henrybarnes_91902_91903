<?php
if (isset($_REQUEST['login'])) {

    $username = to_clean($_REQUEST['username'] ?? '');

    $login_stmt = $dbconnect->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $login_stmt->bind_param("s", $username);
    $login_stmt->execute();
    $result = $login_stmt->get_result();
    $login_rs = $result->fetch_assoc();
    $login_stmt->close();

    if ($login_rs && password_verify($_REQUEST['password'] ?? '', $login_rs['password'])) {
        $_SESSION['admin'] = $login_rs['username'];
        header("Location: index.php?page=admin/add_entry");
        exit;
    } else {
        $login_error = urlencode("Invalid username or password.");
        header("Location: index.php?page=admin/login&error=$login_error");
        exit;
    }
}
?>
