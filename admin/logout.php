<?php
unset($_SESSION['admin']);
header("Location: index.php?page=admin/login");
exit;
?>
