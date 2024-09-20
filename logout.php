<?php
session_start();
session_reset();
session_destroy();
header("Location: https://anim.mjcbolbec.fr/login.php");
exit;
?>