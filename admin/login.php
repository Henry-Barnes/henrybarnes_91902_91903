<div class="admin-form">

<h2>Login</h2>

<form action="index.php?page=admin/adminlogin" method="post">

    <p><input name="username" placeholder="Username" required /></p>
    <p><input name="password" placeholder="Password" type="password" required /></p>

    <?php
    if (isset($_GET['error'])) {
        ?>
        <div class="error">
            <?= htmlspecialchars(urldecode($_GET['error'])) ?>
        </div>
        <?php
    }
    ?>

    <button class="form-submit pad-10" type="submit" name="login">Log In</button>

</form>

</div>
